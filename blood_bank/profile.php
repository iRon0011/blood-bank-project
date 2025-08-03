<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();
$donations = $conn->query("SELECT * FROM donations WHERE user_id = $user_id ORDER BY donation_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container { padding: 30px; font-family: Arial; max-width: 800px; margin: auto; }
        .section { margin-bottom: 30px; }
        h2 { color: #d32f2f; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        .btn { padding: 10px 15px; background-color: #d32f2f; color: white; border: none; border-radius: 5px; }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Welcome, <?= htmlspecialchars($user['name']) ?>!</h2>

    <div class="section">
        <h3>Your Info</h3>
        <p><strong>Email:</strong> <?= $user['email'] ?></p>
        <p><strong>Blood Type:</strong> <?= $user['blood_type'] ?></p>
        <p><strong>Phone:</strong> <?= $user['phone'] ?></p>
        <p><a href="edit_profile.php" class="btn">Edit Profile</a></p>
    </div>

    <div class="section">
        <h3>Your Donation History</h3>
        <table>
            <tr>
                <th>Date</th>
                <th>Location</th>
                <th>Status</th>
            </tr>
            <?php while($row = $donations->fetch_assoc()): ?>
            <tr>
                <td><?= $row['donation_date'] ?></td>
                <td><?= $row['location'] ?></td>
                <td><?= $row['status'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>
