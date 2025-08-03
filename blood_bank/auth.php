<?php
session_start();
include 'db.php';
include 'navbar.php'; 


$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

$table = ($role === 'admin') ? 'admins' : 'users';

$query = "SELECT * FROM $table WHERE email='$email' AND password='$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  $_SESSION['user'] = $result->fetch_assoc();
  $_SESSION['role'] = $role;
  header("Location: " . ($role === 'admin' ? "dashboard.php" : "index.html"));
} else {
  echo "Invalid credentials!";
}
?>
