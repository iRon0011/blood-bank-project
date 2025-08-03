<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// إحصائيات
$user_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$donation_count = $conn->query("SELECT COUNT(*) AS total FROM donations")->fetch_assoc()['total'];
$message_count = $conn->query("SELECT COUNT(*) AS total FROM support_messages")->fetch_assoc()['total'];

// استرجاع الرسائل
$messages = $conn->query("SELECT sm.*, u.username FROM support_messages sm JOIN users u ON sm.user_id = u.id ORDER BY sm.sent_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial; padding: 20px; }
        .stats { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat {
            background-color: #f2f2f2;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        table {
            width: 100%; border-collapse: collapse;
        }
        th, td {
            padding: 10px; border: 1px solid #ccc;
        }
        th {
            background-color: #1976d2; color: white;
        }
    </style>
</head>
<body>

<h1>Admin Dashboard</h1>

<div class="stats">
    <div class="stat">👥 Users: <strong><?= $user_count ?></strong></div>
    <div class="stat">💉 Donations: <strong><?= $donation_count ?></strong></div>
    <div class="stat">📨 Messages: <strong><?= $message_count ?></strong></div>
</div>

<h2>Support Messages</h2>
<table>
    <tr>
        <th>User</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Date</th>
    </tr>
    <?php while ($row = $messages->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['subject']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td><?= $row['sent_at'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

