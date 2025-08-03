
<?php
include 'db.php';
include 'navbar.php'; 
?>








session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}











<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body { font-family: Arial; }
        .dashboard {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        h2 { color: #c0392b; }
        a {
            display: block;
            margin: 10px 0;
            color: #2980b9;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <h2>Welcome, <?php echo $_SESSION['name']; ?> 👋</h2>

    <a href="schedule.php">📅 Schedule a Donation</a>
    <a href="view_donations.php">🧾 View Your Donations</a>
    <a href="request_blood.php">💉 Request Blood</a>
    <a href="logout.php">🚪 Logout</a>
</div>

</body>
</html>
