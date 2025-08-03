<?php
session_start();
include 'db.php';
include 'navbar.php';

// التأكد من صلاحيات الادمن
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donation_id'], $_POST['status'])) {
    $donation_id = $_POST['donation_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE donations SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $donation_id);
    $stmt->execute();
    // بعد السطر: $stmt->execute();
$msg = "Your donation scheduled on {$donation_date} has been updated to status: $status.";
$notif = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
$notif->bind_param("is", $row['user_id'], $msg);
$notif->execute();

}

// استعلام التبرعات
$sql = "SELECT donations.*, users.name FROM donations JOIN users ON donations.user_id = users.id ORDER BY donation_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Donations</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #b30000;
        }

        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #b30000;
            color: white;
        }

        select {
            padding: 5px;
        }

        button {
            padding: 6px 12px;
            background: #b30000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form {
            margin: 0;
        }
    </style>
</head>
<body>

<h2>📋 All Scheduled Donations</h2>

<table>
    <tr>
        <th>ID</th>
        <th>User Name</th>
        <th>Blood Type</th>
        <th>Location</th>
        <th>Date</th>
        <th>Status</th>
        <th>Update</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['blood_type'] ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= $row['donation_date'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="donation_id" value="<?= $row['id'] ?>">
                    <select name="status">
                        <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="approved" <?= $row['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="rejected" <?= $row['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
