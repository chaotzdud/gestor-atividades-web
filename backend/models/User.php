<?php
class User {
    private $conn;
    private $table = "users";

    public $id;
    public $fname;
    public $lname;
    public $dbirth;
    public $username;
    public $password;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET fname=:fname, lname=:lname, dbirth=:dbirth, username=:username, password=:password";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":fname", $this->fname);
        $stmt->bindParam(":lname", $this->lname);
        $stmt->bindParam(":dbirth", $this->dbirth);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        return $stmt->execute();
    }
}
