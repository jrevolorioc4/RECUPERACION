<?php
// membresias.php
header('Content-Type: application/json; charset=utf-8');
require 'db.php';
require 'auth.php';

require_login(); // obliga a estar logueado

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        list_membresias($pdo);
        break;
    case 'create':
        require_role(['recepcionista', 'supervisor', 'administrador']);
        create_membresia($pdo);
        break;
    case 'update':
        require_role(['supervisor', 'administrador']);
        update_membresia($pdo);
        break;
    case 'cancel':
        require_role(['administrador']);
        cancel_membresia($pdo);
        break;
    case 'reactivate':
        require_role(['administrador']);
        reactivate_membresia($pdo);
        break;
    default:
        echo json_encode(['error' => 'Acción no válida']);
}

/* ------------ FUNCIONES ---------------- */

function list_membresias($pdo) {
    $stmt = $pdo->query("
        SELECT m.*,
               DATEDIFF(m.fecha_vencimiento, CURDATE()) AS dias_restantes
        FROM membresias m
        ORDER BY m.id DESC
    ");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}

function create_membresia($pdo) {
    $input = json_decode(file_get_contents('php://input'), true);

    $codigo = trim($input['codigo'] ?? '');
    $nombre_cliente = trim($input['nombre_cliente'] ?? '');
    $tipo = $input['tipo'] ?? 'mensual';
    $fecha_inicio = $input['fecha_inicio'] ?? '';
    $fecha_vencimiento = $input['fecha_vencimiento'] ?? '';
    $monto_pagado = floatval($input['monto_pagado'] ?? 0);
    $metodo_pago = trim($input['metodo_pago'] ?? '');
    $telefono = trim($input['telefono'] ?? '');
    $usuario_id = current_user_id();

    // Código único
    $stmt = $pdo->prepare("SELECT id FROM membresias WHERE codigo = ?");
    $stmt->execute([$codigo]);
    if ($stmt->fetch()) {
        http_response_code(400);
        echo json_encode(['error' => 'Código de membresía ya existe']);
        return;
    }

    // Vigencia correcta (fecha_vencimiento >= hoy)
    $stmt = $pdo->query("SELECT CURDATE()");
    $hoy = $stmt->fetchColumn();
    if ($fecha_vencimiento < $hoy) {
        http_response_code(400);
        echo json_encode(['error' => 'La fecha de vencimiento no puede ser menor a la fecha actual']);
        return;
    }

    // Monto válido
    if ($monto_pagado <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'El monto pagado debe ser mayor que cero']);
        return;
    }

    // Teléfono válido (mínimo 8 dígitos)
    if (!preg_match('/^[0-9]{8,}$/', $telefono)) {
        http_response_code(400);
        echo json_encode(['error' => 'Teléfono inválido (mínimo 8 dígitos numéricos)']);
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO membresias
        (codigo, nombre_cliente, tipo, fecha_inicio, fecha_vencimiento, estado,
         monto_pagado, metodo_pago, telefono, usuario_id)
        VALUES (?,?,?,?,?,'activa',?,?,?,?)
    ");
    $stmt->execute([
        $codigo,
        $nombre_cliente,
        $tipo,
        $fecha_inicio,
        $fecha_vencimiento,
        $monto_pagado,
        $metodo_pago,
        $telefono,
        $usuario_id
    ]);

    $id = $pdo->lastInsertId();
    registrar_auditoria($pdo, $id, $usuario_id, 'crear', 'Creación de membresía');

    echo json_encode(['message' => 'Membresía creada', 'id' => $id]);
}

function update_membresia($pdo) {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = intval($input['id'] ?? 0);

    $stmt = $pdo->prepare("SELECT * FROM membresias WHERE id = ?");
    $stmt->execute([$id]);
    $m = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$m) {
        http_response_code(404);
        echo json_encode(['error' => 'Membresía no encontrada']);
        return;
    }

    // No modificar canceladas
    if ($m['estado'] === 'cancelada') {
        http_response_code(400);
        echo json_encode(['error' => 'No se pueden modificar membresías canceladas']);
        return;
    }

    $nombre_cliente = trim($input['nombre_cliente'] ?? $m['nombre_cliente']);
    $tipo = $input['tipo'] ?? $m['tipo'];
    $fecha_inicio = $input['fecha_inicio'] ?? $m['fecha_inicio'];
    $fecha_vencimiento = $input['fecha_vencimiento'] ?? $m['fecha_vencimiento'];
    $monto_pagado = floatval($input['monto_pagado'] ?? $m['monto_pagado']);
    $metodo_pago = trim($input['metodo_pago'] ?? $m['metodo_pago']);
    $telefono = trim($input['telefono'] ?? $m['telefono']);
    $usuario_id = current_user_id();

    // Validaciones
    if ($monto_pagado <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'El monto pagado debe ser mayor que cero']);
        return;
    }

    if (!preg_match('/^[0-9]{8,}$/', $telefono)) {
        http_response_code(400);
        echo json_encode(['error' => 'Teléfono inválido']);
        return;
    }

    $stmt = $pdo->query("SELECT CURDATE()");
    $hoy = $stmt->fetchColumn();
    if ($fecha_vencimiento < $hoy) {
        http_response_code(400);
        echo json_encode(['error' => 'La fecha de vencimiento no puede ser menor a la fecha actual']);
        return;
    }

    $stmt = $pdo->prepare("
        UPDATE membresias SET
            nombre_cliente = ?,
            tipo = ?,
            fecha_inicio = ?,
            fecha_vencimiento = ?,
            monto_pagado = ?,
            metodo_pago = ?,
            telefono = ?,
            usuario_id = ?,
            updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([
        $nombre_cliente,
        $tipo,
        $fecha_inicio,
        $fecha_vencimiento,
        $monto_pagado,
        $metodo_pago,
        $telefono,
        $usuario_id,
        $id
    ]);

    registrar_auditoria($pdo, $id, $usuario_id, 'modificar', 'Modificación de membresía');
    echo json_encode(['message' => 'Membresía actualizada']);
}

function cancel_membresia($pdo) {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = intval($input['id'] ?? 0);
    $usuario_id = current_user_id();

    $stmt = $pdo->prepare("
        UPDATE membresias
        SET estado = 'cancelada',
            usuario_id = ?,
            updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([$usuario_id, $id]);

    registrar_auditoria($pdo, $id, $usuario_id, 'cancelar', 'Cancelación de membresía');
    echo json_encode(['message' => 'Membresía cancelada']);
}

function reactivate_membresia($pdo) {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = intval($input['id'] ?? 0);
    $usuario_id = current_user_id();

    $stmt = $pdo->prepare("
        UPDATE membresias
        SET estado = 'activa',
            usuario_id = ?,
            updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([$usuario_id, $id]);

    registrar_auditoria($pdo, $id, $usuario_id, 'reactivar', 'Reactivación de membresía');
    echo json_encode(['message' => 'Membresía reactivada']);
}

function registrar_auditoria($pdo, $membresia_id, $usuario_id, $accion, $detalle = '') {
    $stmt = $pdo->prepare("
        INSERT INTO auditoria (membresia_id, usuario_id, accion, detalle)
        VALUES (?,?,?,?)
    ");
    $stmt->execute([$membresia_id, $usuario_id, $accion, $detalle]);
}
