<?php
session_start();
include 'db.php';

// تأكد من أن المستخدم مسجل دخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// جلب سجل التبرعات للمستخدم
$stmt = $conn->prepare("SELECT blood_type, amount, donation_date, status FROM donations WHERE user_id = ? ORDER BY donation_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>سجل تبرعاتي</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }

        .navbar {
            background-color: #c0392b;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .navbar a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #c0392b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #e74c3c;
            color: white;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .status {
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .Scheduled { background-color: #f39c12; color: white; }
        .Completed { background-color: #2ecc71; color: white; }
        .Cancelled { background-color: #e74c3c; color: white; }
    </style>
</head>
<body>

<div class="navbar">
    <div><strong>🩸 بنك الدم - سجل تبرعاتي</strong></div>
    <div>
        <a href="home.php">الرئيسية</a>
        <a href="dashboard.php">لوحة التحكم</a>
        <a href="notifications.php">الإشعارات</a>
        <a href="logout.php">تسجيل الخروج</a>
    </div>
</div>

<div class="container">
    <h2>📅 سجل تبرعاتي</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>فصيلة الدم</th>
                    <th>الكمية (مل)</th>
                    <th>تاريخ التبرع</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['blood_type']) ?></td>
                        <td><?= htmlspecialchars($row['amount']) ?></td>
                        <td><?= htmlspecialchars($row['donation_date']) ?></td>
                        <td><span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">لا توجد تبرعات مسجلة حتى الآن.</p>
    <?php endif; ?>
</div>

</body>
</html>



