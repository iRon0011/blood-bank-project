
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}










<?php
include 'db.php';
 include 'navbar.php'; 

$result = $conn->query("SELECT * FROM users");
echo "<h2>Registered Users</h2><table border='1'><tr><th>ID</th><th>Name</th><th>Email</th></tr>";
while($row = $result->fetch_assoc()) {
  echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td></tr>";
}
echo "</table>";
?>