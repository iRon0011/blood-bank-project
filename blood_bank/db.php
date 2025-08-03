



<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "blood_bank"; // ← تم التعديل هنا

// إنشاء الاتصال
$conn = new mysqli($host, $user, $password, $database);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
