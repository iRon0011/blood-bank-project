<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// تأكيد التبرع وتحديث الحالة والنقاط
if (isset($_GET['mark_completed'])) {
    $donation_id = intval($_GET['mark_completed']);

    // تحقق من أن التبرع يخص هذا المستخدم ولم يتم تأكيده مسبقًا
    $check = $conn->query("SELECT * FROM donations WHERE id = $donation_id AND user_id = $user_id AND status != 'completed'");
    if ($check && $check->num_rows > 0) {
        $conn->query("UPDATE donations SET status = 'completed' WHERE id = $donation_id");
        // تحديث البوينتات
        $conn->query("UPDATE users SET points = points + 10 WHERE id = $user_id"); // فرضًا 10 نقاط لكل تبرع
        header("Location: my_donations_log.php?success=1");
        exit();
    }
}

$donations = $conn->query("SELECT * FROM donations WHERE user_id = $user_id ORDER BY donation_date DESC");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>سجل تبرعاتي</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #c0392b;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            padding: 40px;
        }

        h2 {
            color: #c0392b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #e74c3c;
            color: white;
        }

        .btn {
            background-color: #27ae60;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn:disabled {
            background-color: gray;
            cursor: not-allowed;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background: #ddd;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>
        <strong>سجل تبرعاتي</strong>
    </div>
    <div>
        <a href="home.php">الصفحة الرئيسية</a>
        <a href="donate_now.php">تبرع الآن</a>
        <a href="dashboard.php">لوحة التحكم</a>
        <a href="logout.php">تسجيل الخروج</a>
    </div>
</div>

<div class="container">
    <h2>📋 سجل تبرعاتي</h2>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">✅ تم تأكيد التبرع وحصلت على نقاطك!</p>
    <?php endif; ?>

    <table>
        <tr>
            <th>التاريخ</th>
            <th>الفصيلة</th>
            <th>الكمية (مل)</th>
            <th>الحالة</th>
            <th>إجراء</th>
        </tr>
        <?php while ($row = $donations->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['donation_date']) ?></td>
                <td><?= htmlspecialchars($row['blood_type']) ?></td>
                <td><?= htmlspecialchars($row['amount']) ?></td>
                <td><?= ($row['status'] == 'completed') ? 'تم التبرع' : 'قيد الانتظار' ?></td>
                <td>
                    <?php if ($row['status'] != 'completed'): ?>
                        <a class="btn" href="?mark_completed=<?= $row['id'] ?>" onclick="return confirm('هل تأكدت من أنك قمت بالتبرع؟');">تم التبرع</a>
                    <?php else: ?>
                        <button class="btn" disabled>✔ تم</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<div class="footer">
    &copy; <?= date("Y") ?> نظام بنك الدم الإلكتروني
</div>

</body>
</html>
