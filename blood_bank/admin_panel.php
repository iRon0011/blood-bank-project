<?php
session_start();

 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

 
$usersCount = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$donationsCount = $conn->query("SELECT COUNT(*) AS count FROM donations")->fetch_assoc()['count'];
$requestsCount = $conn->query("SELECT COUNT(*) AS count FROM requests")->fetch_assoc()['count'];
$schedulesCount = $conn->query("SELECT COUNT(*) AS count FROM schedule")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Blood Bank</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }
        header {
            background-color: #b71c1c;
            padding: 15px 30px;
            color: white;
            font-size: 22px;
        }
        .panel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 30px;
        }
        .card {
            background-color: white;
            border-left: 5px solid #d32f2f;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .card h3 {
            margin: 0;
            color: #d32f2f;
        }
        .card p {
            font-size: 28px;
            font-weight: bold;
        }
        nav {
            background: #f5f5f5;
            padding: 10px 30px;
        }
        nav a {
            text-decoration: none;
            color: #b71c1c;
            font-weight: bold;
            margin-right: 20px;
        }
        nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    🛠️ Admin Panel - Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>
</header>

<nav>
    <a href="admin_panel.php">Dashboard</a>
    <a href="users.php">Manage Users</a>
    <a href="donations.php">View Donations</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="panel">
    <div class="card">
        <h3>👥 Total Users</h3>
        <p><?php echo $usersCount; ?></p>
    </div>
    <div class="card">
        <h3>💉 Total Donations</h3>
        <p><?php echo $donationsCount; ?></p>
    </div>
    <div class="card">
        <h3>📩 Requests</h3>
        <p><?php echo $requestsCount; ?></p>
    </div>
    <div class="card">
        <h3>🗓️ Scheduled Appointments</h3>
        <p><?php echo $schedulesCount; ?></p>
    </div>
</div>

</body>
</html>
