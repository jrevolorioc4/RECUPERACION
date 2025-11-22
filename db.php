<?php
// db.php
$host = '127.0.0.1';
$db   = 'recuperacion';
$user = 'root';  // o el usuario que uses en Workbench
$pass = 'UMG12345';      // la misma contraseña que en Workbench (si tienes, ponla aquí)

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}
