<?php
// auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_login() {
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(['error' => 'No autenticado']);
        exit;
    }
}

function current_user_id() {
    return $_SESSION['user']['id'] ?? null;
}

function current_role() {
    return $_SESSION['user']['rol'] ?? null;
}

function require_role(array $rolesPermitidos) {
    $rol = current_role();
    if (!in_array($rol, $rolesPermitidos)) {
        http_response_code(403);
        echo json_encode(['error' => 'Permiso denegado']);
        exit;
    }
}
