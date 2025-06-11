<?php
require_once '../includes/session.php';
require_once '../../db/connect.php';

startSecureSession();

header('Content-Type: application/json');

if (!isUserLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$title = trim($data['title'] ?? '');
$description = trim($data['description'] ?? '');
$due_date = $data['due_date'] ?? '';

if (!$title || !$description || !$due_date) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios']);
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO activities (user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $userId, $title, $description, $due_date);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Atividade criada com sucesso']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao criar atividade']);
}
