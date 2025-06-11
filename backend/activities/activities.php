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

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id, title, description, due_date, status FROM activities WHERE user_id = ? ORDER BY due_date ASC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$activities = [];
while ($row = $result->fetch_assoc()) {
    $activities[] = $row;
}

echo json_encode(['success' => true, 'activities' => $activities]);
