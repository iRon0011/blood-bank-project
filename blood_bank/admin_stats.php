<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// الإحصائيات العامة
$user_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$donation_count = $conn->query("SELECT COUNT(*) AS total FROM donations")->fetch_assoc()['total'];

// التبرعات حسب الفصيلة
$blood_data = [];
$blood_result = $conn->query("SELECT blood_type, COUNT(*) AS total FROM donations GROUP BY blood_type");
while ($row = $blood_result->fetch_assoc()) {
    $blood_data[] = $row;
}

// التبرعات حسب الحالة
$status_data = [];
$status_result = $conn->query("SELECT status, COUNT(*) AS total FROM donations GROUP BY status");
while ($row = $status_result->fetch_assoc()) {
    $status_data[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Statistics</title>
    <style>
        body { font-family: Arial; margin: 30px; background: #f5f5f5; }
        h2 { color: #333; }
        .stat-box { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc; margin-bottom: 20px; }
        .chart { display: flex; gap: 50px; }
        table { border-collapse: collapse; width: 50%; background: #fff; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>

    <h2>📊 System Statistics</h2>

    <div class="stat-box">
        <p><strong>Total Users:</strong> <?= $user_count ?></p>
        <p><strong>Total Donations:</strong> <?= $donation_count ?></p>
    </div>

    <div class="chart">
        <div>
            <h3>🩸 Donations by Blood Type</h3>
            <table>
                <tr><th>Blood Type</th><th>Count</th></tr>
                <?php foreach ($blood_data as $item): ?>
                <tr><td><?= $item['blood_type'] ?></td><td><?= $item['total'] ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div>
            <h3>📌 Donations by Status</h3>
            <table>
                <tr><th>Status</th><th>Count</th></tr>
                <?php foreach ($status_data as $item): ?>
                <tr><td><?= ucfirst($item['status']) ?></td><td><?= $item['total'] ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

</body>
</html>
<li><a href="admin_stats.php">📊 Statistics</a></li>
