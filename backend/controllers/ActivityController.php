<?php
require_once __DIR__ . '/../models/Activity.php';

class ActivityController {
    private $db;
    private $requestMethod;

    public function __construct($db, $requestMethod) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                $this->getActivities();
                break;
            case 'POST':
                $this->createActivity();
                break;
            default:
                http_response_code(405);
                echo json_encode(["message" => "Método não permitido"]);
        }
    }

    private function getActivities() {
        $activity = new Activity($this->db);
        $stmt = $activity->readAll();
        $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($activities);
    }

    private function createActivity() {
        $data = json_decode(file_get_contents("php://input"), true);

        $activity = new Activity($this->db);
        $activity->title = $data['title'] ?? '';
        $activity->description = $data['description'] ?? '';
        $activity->status = false;
        $activity->author_id = $data['author_id'] ?? null;
        $activity->due_date = $data['due_date'] ?? null;

        if ($activity->create()) {
            http_response_code(201);
            echo json_encode(["message" => "Atividade criada com sucesso"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao criar atividade"]);
        }
    }
}
