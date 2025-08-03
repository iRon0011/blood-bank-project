<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// حساب عدد التبرعات
$sql = "SELECT COUNT(*) as total FROM donations WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_donations = $result->fetch_assoc()['total'] ?? 0;

$points = $total_donations * 10;

// معالجة استبدال الهدية
if (isset($_POST['exchange'])) {
    $reward = $_POST['reward_name'];
    $cost = intval($_POST['reward_cost']);

    if ($points >= $cost) {
        // خصم النقاط من الحساب المنطقي (بدون تعديل donations)
        $points -= $cost;

        // حفظ في سجل الاستبدالات
        $stmt = $conn->prepare("INSERT INTO rewards_log (user_id, reward_name) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $reward);
        $stmt->execute();
    }
}

// جلب سجل الاستبدالات
$stmt = $conn->prepare("SELECT reward_name, exchanged_at FROM rewards_log WHERE user_id = ? ORDER BY exchanged_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$log_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نظام المكافآت</title>
    <style>
        body {
            background-color: #2f2f2f;
            color: #fff;
            font-family: 'Tajawal', sans-serif;
            padding: 40px;
            direction: rtl;
            overflow-x: hidden;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #3a3a3a;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(255, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        h2 {
            text-align: center;
            color: #ff4d4d;
        }

        .points {
            text-align: center;
            font-size: 24px;
            margin: 20px 0;
            color: #ff6666;
        }

        .reward-form {
            background: #444;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        select, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
            font-size: 16px;
        }

        select {
            background-color: #555;
            color: white;
        }

        button {
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #c0392b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #555;
        }

        th {
            background-color: #333;
            color: #ff4d4d;
        }

        .back-home {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #1abc9c;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
        }

        .back-home:hover {
            text-decoration: underline;
        }

        /* دم متساقط */
        .blood-drop {
            position: fixed;
            width: 15px;
            height: 25px;
            background: red;
            border-radius: 50% 50% 50% 50%/60% 60% 40% 40%;
            animation: drop 3s linear infinite;
            opacity: 0.6;
            z-index: 0;
        }

        @keyframes drop {
            0% {
                top: -30px;
                opacity: 0.8;
            }
            100% {
                top: 100vh;
                opacity: 0;
            }
        }
    </style>
</head>
<body>

<!-- مؤثرات الدم -->
<script>
    for (let i = 0; i < 30; i++) {
        let drop = document.createElement('div');
        drop.className = 'blood-drop';
        drop.style.left = Math.random() * 100 + 'vw';
        drop.style.animationDelay = Math.random() * 5 + 's';
        drop.style.width = (10 + Math.random() * 10) + 'px';
        drop.style.height = (15 + Math.random() * 15) + 'px';
        document.body.appendChild(drop);
    }
</script>

<div class="container">
    <h2>🎁 نظام المكافآت</h2>

    <div class="points">
        🩸 لديك <strong><?= $points ?></strong> نقطة
    </div>

    <div class="reward-form">
        <form method="post">
            <label for="reward_name">اختر هدية:</label>
            <select name="reward_name" required>
                <option value="">-- اختر --</option>
                <option value="كوبون خصم 50 جنيه">كوبون خصم (50 جنيه) - 50 نقطة</option>
                <option value="تيشيرت المتبرع الذهبي">تيشيرت المتبرع الذهبي - 70 نقطة</option>
                <option value="شنطة إسعافات أولية">شنطة إسعافات أولية - 100 نقطة</option>
            </select>
            <input type="hidden" name="reward_cost" id="reward_cost">
            <button type="submit" name="exchange">استبدال</button>
        </form>
    </div>

    <script>
        // ضبط قيمة النقاط حسب الهدية
        document.querySelector("select[name=reward_name]").addEventListener("change", function () {
            const reward = this.value;
            const costMap = {
                "كوبون خصم 50 جنيه": 50,
                "تيشيرت المتبرع الذهبي": 70,
                "شنطة إسعافات أولية": 100
            };
            document.getElementById("reward_cost").value = costMap[reward] || 0;
        });
    </script>

    <h3>📜 سجل الاستبدالات</h3>
    <?php if ($log_result->num_rows > 0): ?>
        <table>
            <tr>
                <th>الهدية</th>
                <th>تاريخ الاستبدال</th>
            </tr>
            <?php while ($log = $log_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($log['reward_name']) ?></td>
                    <td><?= htmlspecialchars($log['exchanged_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">لا يوجد استبدالات بعد.</p>
    <?php endif; ?>

    <a href="home.php" class="back-home">🔙 الرجوع للرئيسية</a>
</div>

</body>
</html>
