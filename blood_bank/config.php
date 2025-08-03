<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank"; // غيره لو اسم قاعدة بياناتك مختلف

$conn = mysqli_connect($servername, $username, $password, $dbname);

// فحص الاتصال
if (!$conn) {
    die("فشل الاتصال: " . mysqli_connect_error());
}
?>
