<?php
// login.php
header('Content-Type: application/json; charset=utf-8');
require 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

$stmt = $pdo->prepare("
    SELECT u.id, u.username, u.password_hash, r.nombre AS rol
    FROM usuarios u
    JOIN roles r ON r.id = u.rol_id
    WHERE u.username = ?
");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Verificar con SHA-256
    $hashInput = hash('sha256', $password);
    if (hash_equals($user['password_hash'], $hashInput)) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'rol' => $user['rol']
        ];
        echo json_encode(['message' => 'ok', 'rol' => $user['rol'], 'username' => $user['username']]);
        exit;
    }
}

http_response_code(401);
echo json_encode(['error' => 'Credenciales inválidas']);
