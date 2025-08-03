<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank"; // غيّر الاسم إذا كانت قاعدة البيانات باسم آخر

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
