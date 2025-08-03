<?php
session_start();
include 'db.php';

// التأكد إن المستخدم مسجل دخول
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// جلب البيانات
$user_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$donation_count = $conn->query("SELECT COUNT(*) AS total FROM donations")->fetch_assoc()['total'];

$blood_query = $conn->query("SELECT blood_type, COUNT(*) AS total FROM donations GROUP BY blood_type");
$status_query = $conn->query("SELECT status, COUNT(*) AS total FROM donations GROUP BY status");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporting - Blood Bank</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f5f5f5;
            padding: 20px;
        }

        h2 {
            color: #b30000;
        }

        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 200px;
            text-align: center;
        }

        .chart-container {
            margin-top: 40px;
            width: 100%;
            max-width: 600px;
        }

        canvas {
            width: 100% !important;
            height: auto !important;
        }
    </style>
</head>
<body>

<div class="chart-container">
        <h3>🩸 Donations by Blood Type</h3>
        <canvas id="bloodChart"></canvas>
    </div>

    <div class="chart-container">
        <h3>📌 Donations by Status</h3>
        <canvas id="statusChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const bloodData = <?php echo json_encode($blood_data); ?>;
        const statusData = <?php echo json_encode($status_data); ?>;

        new Chart(document.getElementById('bloodChart'), {
            type: 'bar',
            data: {
                labels: bloodData.map(item => item.blood_type),
                datasets: [{
                    label: 'Total Donations',
                    data: bloodData.map(item => item.total),
                    backgroundColor: '#b30000'
                }]
            }
        });

        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: {
                labels: statusData.map(item => item.status),
                datasets: [{
                    label: 'Total',
                    data: statusData.map(item => item.total),
                    backgroundColor: ['#4caf50', '#f44336', '#ff9800']
                }]
            }
        });
    </script>
</body>
</html>


    <h2>📊 System Statistics</h2>
    <div class="stats">
        <div class="card">
            <h3>👤 Users</h3>
            <p><?php echo $user_count; ?></p>
        </div>

        <div class="card">
            <h3>🩸 Donations</h3>
            <p><?php echo $donation_count; ?></p>
        </div>
    </div>

    <?php
$blood_data = [];
while ($row = $blood_query->fetch_assoc()) {
    $blood_data[] = $row;
}

$status_data = [];
while ($row = $status_query->fetch_assoc()) {
    $status_data[] = $row;
}
?>






