<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if (in_array($action, ['approved', 'rejected'])) {
        $stmt = $conn->prepare("UPDATE schedules SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $action, $id);
        $stmt->execute();
    }
}

if (in_array($action, ['approved', 'rejected'])) {
    $stmt = $conn->prepare("UPDATE schedules SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $action, $id);
    $stmt->execute();

    // Get user ID for the notification
    $user_query = $conn->query("SELECT user_id FROM schedules WHERE id = $id");
    $user = $user_query->fetch_assoc()['user_id'];
    
    // Message content
    $msg = ($action === 'approved') ? "Your donation appointment has been approved ✅" : "Your donation appointment was rejected ❌";

    // Insert notification
    $notif_stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
    $notif_stmt->bind_param("is", $user, $msg);
    $notif_stmt->execute();
}



// استعلام المواعيد
$result = $conn->query("
    SELECT schedules.id, users.name, donation_date, donation_time, location, status 
    FROM schedules 
    JOIN users ON schedules.user_id = users.id
    ORDER BY donation_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Schedules</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; margin: 2px; text-decoration: none; color: white; border-radius: 4px; }
        .approve { background-color: green; }
        .reject { background-color: red; }
    </style>
</head>
<body>
    <h2>📋 Donation Appointments</h2>

    <table>
        <tr>
            <th>User</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['donation_date'] ?></td>
            <td><?= $row['donation_time'] ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= ucfirst($row['status']) ?></td>
            <td>
                <?php if ($row['status'] == 'pending') { ?>
                    <a href="?action=approved&id=<?= $row['id'] ?>" class="btn approve">Approve</a>
                    <a href="?action=rejected&id=<?= $row['id'] ?>" class="btn reject">Reject</a>
                <?php } else { echo "—"; } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
