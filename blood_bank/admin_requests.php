<?php
session_start();
include 'db.php';
 include 'navbar.php'; 


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


<?php
if (isset($_POST['update_status'])) {
    $request_id = $_POST['request_id'];
    $new_status = $_POST['status'];

    $update = "UPDATE requests SET status = '$new_status' WHERE id = $request_id";
    $conn->query($update);
}

$sql = "SELECT r.*, u.full_name FROM requests r JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Requests</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 95%; border-collapse: collapse; margin: auto; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #eee; }
        form { display: inline; }
    </style>
</head>
<body>

<h2>🛠 Manage Blood Requests</h2>

<table>
    <tr>
        <th>User</th>
        <th>Blood Type</th>
        <th>Units</th>
        <th>Hospital</th>
        <th>Location</th>
        <th>Needed Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['full_name'] ?></td>
            <td><?= $row['blood_type'] ?></td>
            <td><?= $row['units_needed'] ?></td>
            <td><?= $row['hospital_name'] ?></td>
            <td><?= $row['location'] ?></td>
            <td><?= $row['needed_date'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                    <select name="status">
                        <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Approved" <?= $row['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="Rejected" <?= $row['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                    <button type="submit" name="update_status">Update</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
