<?php
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ .'/../models/User.php';

class UserController {
    private $db;
    private $requestMethod;

    public function __construct($db, $requestMethod) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                $this->getUsers();
                break;
            case 'POST':
                $this->createUser();
                break;
            default:
                http_response_code(405);
                echo json_encode(["message" => "Método não permitido"]);
        }
    }

    private function getUsers() {
        $user = new User($this->db);
        $stmt = $user->readAll();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
    }

    private function createUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        $user = new User($this->db);
        $user->fname = $data['fname'] ?? '';
        $user->lname = $data['lname'] ?? '';
        $user->dbirth = $data['dbirth'] ?? '';
        $user->username = $data['username'] ?? '';
        $user->password = password_hash($data['password'] ?? '', PASSWORD_BCRYPT);

        if ($user->create()) {
            http_response_code(201);
            echo json_encode(["message" => "Usuário criado com sucesso"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao criar usuário"]);
        }
    }
}
