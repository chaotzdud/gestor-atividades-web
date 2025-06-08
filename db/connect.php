<?php
$host = 'localhost';
$db = 'login_db';
$user = 'root';
$pass = '1234';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
