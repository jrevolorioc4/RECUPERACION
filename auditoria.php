<?php
// auditoria.php
header('Content-Type: application/json; charset=utf-8');
require 'db.php';
require 'auth.php';

require_login();
// SOLO ADMIN PUEDE CONSULTAR AUDITORÍA
require_role(['administrador']);

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        list_auditoria($pdo);
        break;

    default:
        echo json_encode(['error' => 'Acción no válida']);
}

/* ------------ FUNCIONES ---------------- */

function list_auditoria($pdo) {
    $stmt = $pdo->query("
        SELECT 
            a.id,
            a.creado_en,
            a.accion,
            a.detalle,
            u.username AS usuario,
            m.codigo AS codigo_membresia
        FROM auditoria a
        LEFT JOIN usuarios u ON u.id = a.usuario_id
        LEFT JOIN membresias m ON m.id = a.membresia_id
        ORDER BY a.creado_en DESC
        LIMIT 200
    ");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}
