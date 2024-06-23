<?php
$servername = "mysql"; // Имя сервиса базы данных в docker-compose.yml
$username = "test_user";
$password = "test_pass";
$dbname = "testdb";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
