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

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id, title, description, due_date, status FROM activities WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($activity = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'activity' => $activity]);
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Atividade não encontrada']);
}
