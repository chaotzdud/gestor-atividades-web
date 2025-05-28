<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ .'/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/ActivityController.php';


$database = new Database();
$db = $database->connect();

$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = $_SERVER["REQUEST_URI"];

if (preg_match("/\/api\/users(?:\/(\d+))?/", $requestUri, $matches)) {
    $userId = $matches[1] ?? null;
    $controller = new UserController($db, $requestMethod);
    $controller->processRequest($userId);
} elseif (preg_match("/\/api\/activities/", $requestUri)) {
    $controller = new ActivityController($db, $requestMethod);
    $controller->processRequest();
} else {
    http_response_code(404);
    echo json_encode(["message" => "Rota nao encontrada"]);
}