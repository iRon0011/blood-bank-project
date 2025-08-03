<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// لو المستخدم ضغط على زر "تم التبرع"
if (isset($_GET['mark_completed'])) {
    $donation_id = intval($_GET['mark_completed']);
    $check = $conn->query("SELECT * FROM donations WHERE id = $donation_id AND user_id = $user_id");
    if ($check->num_rows > 0) {
        $conn->query("UPDATE donations SET status = 'Completed' WHERE id = $donation_id");
    }
    header("Location: my_donations_log.php");
    exit();
}

// استعلام التبرعات الخاصة بالمستخدم
$sql = "SELECT id, donation_date, status FROM donations WHERE user_id = $user_id ORDER BY donation_date DESC";
$result = $conn->query($sql);

$points_per_donation = 10;
$completed_donations = 0;
$donations = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $donations[] = $row;
        if ($row['status'] == 'Completed') {
            $completed_donations++;
        }
    }
}

$total_points = $completed_donations * $points_per_donation;
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>سجل تبرعاتي</title>
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f9f9f9; direction: rtl; padding: 20px; }
        h2 { text-align: center; color: #c0392b; }
        .nav { text-align: center; margin-bottom: 20px; }
        .nav a { margin: 5px; padding: 10px 15px; background: #c0392b; color: white; border-radius: 10px; text-decoration: none; }
        .points-box { background: #eaf5ea; padding: 15px; border-radius: 10px; color: #27ae60; margin-bottom: 20px; font-weight: bold; text-align: center; }
        .gift-box { background: #fff3cd; padding: 15px; border-radius: 10px; color: #856404; text-align: center; margin-bottom: 20px; font-weight: bold; border: 1px solid #ffeeba; }
        table { width: 100%; background: white; border-collapse: collapse; box-shadow: 0 0 10px #ccc; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: center; }
        th { background-color: #c0392b; color: white; }
        .btn-complete {
            padding: 5px 10px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
        }
        .btn-complete:hover { background-color: #27ae60; }
    </style>
</head>
<body>

<div class="nav">
    <a href="home.php">🏠 الرئيسية</a>
    <a href="donate.php">💉 تبرع الآن</a>
</div>

<h2>📄 سجل التبرعات الخاصة بي</h2>

<div class="points-box">
    إجمالي النقاط الخاصة بك: <?= $total_points ?> نقطة 🎯
</div>

<?php if ($total_points >= 50): ?>
    <div class="gift-box">
        🎁 مبروك! حصلت على هدية مقابل تبرعاتك. توجه لأقرب مركز واستلمها!
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>تاريخ التبرع</th>
            <th>الحالة</th>
            <th>نقاط</th>
            <th>إجراء</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($donations) > 0): ?>
            <?php foreach ($donations as $donation): ?>
                <tr>
                    <td><?= htmlspecialchars($donation['donation_date']) ?></td>
                    <td><?= htmlspecialchars($donation['status']) ?></td>
                    <td><?= $donation['status'] == 'Completed' ? $points_per_donation : 0 ?></td>
                    <td>
                        <?php if ($donation['status'] != 'Completed'): ?>
                            <a class="btn-complete" href="donations.php?mark_completed=<?= $donation['id'] ?>">✅ تم التبرع</a>
                        <?php else: ?>
                            ✔️
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">لا توجد تبرعات مسجلة بعد.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>





