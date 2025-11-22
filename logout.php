<?php
// logout.php
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
echo json_encode(['message' => 'logout']);
