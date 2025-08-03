<?php
$host = "localhost";
$dbname = "blood_bank";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

// تحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

