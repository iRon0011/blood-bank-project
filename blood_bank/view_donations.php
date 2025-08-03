



session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}





<?php
session_start();
include 'db.php';
 include 'navbar.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM donations WHERE user_id = $user_id ORDER BY donation_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Donations</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 80%; margin: auto; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; color: #c0392b; }
    </style>
</head>
<body>

<h2>🩸 My Donation Appointments</h2>

<table>
    <tr>
        <th>Blood Type</th>
        <th>Date</th>
        <th>Location</th>
        <th>Status</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['blood_type'] ?></td>
                <td><?= $row['donation_date'] ?></td>
                <td><?= $row['location'] ?></td>
                <td><?= $row['status'] ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4">No donation records found.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>

