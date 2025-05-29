<?php
require_once __DIR__ .'/../models/User.php';

class UserController {
    private $db;
    private $requestMethod;

    public function __construct($db, $requestMethod) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
    }

    public function processRequest($userId = null) {
        switch ($this->requestMethod) {
            case 'GET':
                if($userId) {
                    $this->getUserById($userId);
                } else {
                    $this->getUsers();
                }
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

    private function getUserById($id) {
        $user = new User($this->db);
        $stmt = $user->readById($id);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Usuário não encontrado"]);
        }
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

    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (empty($data['username']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(["message" => "Usuário e senha são obrigatórios"]);
            return;
        }
    
        $user = new User($this->db);
        $stmt = $user->readByUsername($data['username']);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($userData && password_verify($data['password'], $userData['password'])) {
            http_response_code(200);
            echo json_encode([
                "message" => "Login bem-sucedido",
                "user" => [
                    "id" => $userData['id'],
                    "fname" => $userData['fname'],
                    "lname" => $userData['lname'],
                    "username" => $userData['username']
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Credenciais inválidas"]);
        }
    }
    
}
