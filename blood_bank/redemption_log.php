<?php
session_start();
$host = "localhost";
$dbname = "blood_bank";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'] ?? 1; // مؤقتًا لو ما في جلسة

$sql = "SELECT reward_name, redeemed_at FROM redemption_log WHERE user_id = ? ORDER BY redeemed_at DESC";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("خطأ في الاستعلام: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>سجل الاستبدالات</title>
    <style>
        body {
            background-color: #2c2c2c;
            color: white;
            font-family: 'Cairo', sans-serif;
            text-align: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #3d3d3d;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #555;
        }
        th {
            background-color: #444;
        }
        tr:nth-child(even) {
            background-color: #2e2e2e;
        }
        .back-btn {
            margin-top: 30px;
            padding: 10px 20px;
            background-color: crimson;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        .drop {
            position: absolute;
            width: 15px;
            height: 15px;
            background: red;
            border-radius: 50%;
            animation: fall linear infinite;
        }
        @keyframes fall {
            0% { top: -20px; opacity: 0.7; }
            100% { top: 100%; opacity: 0; }
        }
    </style>
</head>
<body>

    <h1>سجل استبدال النقاط</h1>

    <table>
        <tr>
            <th>اسم المكافأة</th>
            <th>تاريخ الاستبدال</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['reward_name']) ?></td>
            <td><?= htmlspecialchars($row['redeemed_at']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <button class="back-btn" onclick="location.href='home.php'">الرجوع إلى القائمة الرئيسية</button>

    <script>
        function createDrop() {
            const drop = document.createElement('div');
            drop.className = 'drop';
            drop.style.left = Math.random() * window.innerWidth + 'px';
            drop.style.animationDuration = (2 + Math.random() * 2) + 's';
            document.body.appendChild(drop);
            setTimeout(() => drop.remove(), 4000);
        }
        setInterval(createDrop, 200);
    </script>

</body>
</html>



