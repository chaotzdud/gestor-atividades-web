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
$id = (int)($data['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}

$userId = $_SESSION['user_id'];

// Garante que a atividade pertence ao usuário
$stmt = $conn->prepare("DELETE FROM activities WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $userId);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(['success' => true, 'message' => 'Atividade deletada']);
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Atividade não encontrada ou sem permissão']);
}
