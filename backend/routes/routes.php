<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ .'/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/ActivityController.php';


$database = new Database();
$db = $database->connect();

$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = $_SERVER["REQUEST_URI"];

if (preg_match("/\/users/", $requestUri)) {
    $controller = new UserController($db, $requestMethod);
    $controller->processRequest();
} elseif (preg_match("/\/activities/", $requestUri)) {
    $controller = new ActivityController($db, $requestMethod);
    $controller->processRequest();
} else {
    http_response_code(404);
    echo json_encode(["message" => "Rota nao encontrada"]);
}