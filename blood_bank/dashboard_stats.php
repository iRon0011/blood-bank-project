<?php
include 'db.php';

$users_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$donations_count = $conn->query("SELECT COUNT(*) AS total FROM donations")->fetch_assoc()['total'];

$blood_data = [];
$blood_query = $conn->query("SELECT blood_type, COUNT(*) AS total FROM donations GROUP BY blood_type");
while ($row = $blood_query->fetch_assoc()) {
    $blood_data[] = $row;
}

$status_data = [];
$status_query = $conn->query("SELECT status, COUNT(*) AS total FROM donations GROUP BY status");
while ($row = $status_query->fetch_assoc()) {
    $status_data[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial; padding: 30px; }
        .stat-box { margin-bottom: 20px; background: #f4f4f4; padding: 20px; border-radius: 10px; }
        canvas { margin-top: 40px; }
    </style>
</head>
<body>

<?php include 'dashboard_stats.php'; ?>

<h2>System Dashboard</h2>

<div class="stat-box">
    <strong>Total Users:</strong> <?= $users_count ?> <br>
    <strong>Total Donations:</strong> <?= $donations_count ?>
</div>

<h3>Donations by Blood Type</h3>
<canvas id="bloodChart" width="400" height="200"></canvas>

<h3>Donations by Status</h3>
<canvas id="statusChart" width="400" height="200"></canvas>

<script>
const bloodChart = document.getElementById('bloodChart');
new Chart(bloodChart, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($blood_data, 'blood_type')) ?>,
        datasets: [{
            label: 'Total Donations',
            data: <?= json_encode(array_column($blood_data, 'total')) ?>,
            backgroundColor: '#e60000'
        }]
    }
});

const statusChart = document.getElementById('statusChart');
new Chart(statusChart, {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_column($status_data, 'status')) ?>,
        datasets: [{
            label: 'Donation Status',
            data: <?= json_encode(array_column($status_data, 'total')) ?>,
            backgroundColor: ['#28a745', '#ffc107', '#dc3545']
        }]
    }
});
</script>

</body>
</html>
