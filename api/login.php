<?php
require_once '../includes/session.php';
require_once '../db/connect.php';

startSecureSession();

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];

$stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(["success" => true]);
        exit;
    }
}

echo json_encode(["success" => false, "message" => "Credenciais inválidas."]);
