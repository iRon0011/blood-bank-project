<?php
// الكود فوق للتحقق من الأدمن

// تحديث الحالة
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE donation_schedule SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

// عرض الطلبات
$schedules = $conn->query("
    SELECT ds.id, u.name, ds.donation_date, ds.donation_time, ds.location, ds.status
    FROM donation_schedule ds
    JOIN users u ON ds.user_id = u.id
");
?>

<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Donation Schedules</title>
    <style>
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 40px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #b30000;
            color: white;
        }
        select, button {
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Donation Schedule Requests</h2>
    <table>
        <tr>
            <th>User Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Status</th>
            <th>Change Status</th>
        </tr>

        <?php while ($row = $schedules->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['donation_date'] ?></td>
            <td><?= $row['donation_time'] ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <select name="status">
                        <option <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option <?= $row['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                        <option <?= $row['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
