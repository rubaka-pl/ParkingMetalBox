<?php
// db.php
$host = '127.0.0.1';
$db = '123';
$user = '123';
$pass = '123';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
