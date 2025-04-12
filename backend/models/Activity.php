<?php
class Activity {
    private $conn;
    private $table = "activities";

    public $id;
    public $title;
    public $description;
    public $author_id;
    public $created_at;
    public $due_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET title=:title, description=:description, author_id=:author_id, due_date=:due_date";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->bindParam(":due_date", $this->due_date);
        return $stmt->execute();
    }
}
