<?php
require_once '../includes/session.php';

startSecureSession();

header('Content-Type: application/json');

if (isUserLoggedIn()) {
    echo json_encode(['authenticated' => true]);
} else {
    echo json_encode(['authenticated' => false]);
}
