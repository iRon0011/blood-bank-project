<?php
session_start();
include 'db.php';
include 'navbar.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM requests WHERE user_id = $user_id ORDER BY needed_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Blood Requests</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        h2 { text-align: center; color: #b30000; }
        table { border-collapse: collapse; width: 90%; margin: auto; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>

<h2>📋 My Blood Requests</h2>

<table>
    <tr>
        <th>Blood Type</th>
        <th>Units</th>
        <th>Hospital</th>
        <th>Location</th>
        <th>Needed Date</th>
        <th>Status</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['blood_type'] ?></td>
                <td><?= $row['units_needed'] ?></td>
                <td><?= $row['hospital_name'] ?></td>
                <td><?= $row['location'] ?></td>
                <td><?= $row['needed_date'] ?></td>
                <td><?= $row['status'] ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="6">No requests found.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
