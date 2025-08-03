<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT blood_type, amount, donation_date FROM donations WHERE user_id = ? ORDER BY donation_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_donations = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تاريخ تبرعاتي</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            overflow-x: hidden;
        }

        .container {
            max-width: 800px;
            margin: 60px auto;
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(255, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        h2 {
            text-align: center;
            color: #e53935;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #444;
            text-align: center;
        }

        th {
            background-color: #3b3b3b;
            color: #f44336;
        }

        tr:hover {
            background-color: #383838;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #aaa;
            font-size: 18px;
        }

        .back-home {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-size: 18px;
            color: #f44336;
            text-decoration: none;
            font-weight: bold;
        }

        .back-home:hover {
            text-decoration: underline;
        }

        /* دم متحرك */
        .blood-drop {
            width: 20px;
            height: 20px;
            background-color: red;
            border-radius: 50%;
            position: fixed;
            animation: fall 4s infinite linear;
            opacity: 0.6;
            z-index: 0;
        }

        @keyframes fall {
            0% {
                transform: translateY(-100px);
                opacity: 0.6;
            }
            100% {
                transform: translateY(100vh);
                opacity: 0;
            }
        }

        /* عداد */
        .counter-box {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
            color: #f44336;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- صوت القطرات -->
<audio id="dropSound" src="sounds/blood-drop.mp3" preload="auto"></audio>

<!-- دم متحرك + صوت -->
<script>
    const numDrops = 30;
    const dropSound = document.getElementById("dropSound");

    for (let i = 0; i < numDrops; i++) {
        const drop = document.createElement("div");
        drop.classList.add("blood-drop");

        drop.style.left = Math.random() * window.innerWidth + "px";
        drop.style.animationDelay = Math.random() * 5 + "s";

        const size = Math.random() * 10 + 10;
        drop.style.width = size + "px";
        drop.style.height = size + "px";

        // تشغيل الصوت بشكل متقطع
        setTimeout(() => {
            if (i % 5 === 0) {
                dropSound.cloneNode(true).play();
            }
        }, Math.random() * 3000);

        document.body.appendChild(drop);
    }
</script>

<div class="container">
    <h2>📜 سجل تبرعاتي</h2>

    <!-- العداد -->
    <div class="counter-box">
    عدد التبرعات: <span id="donationCounter">0</span><br>
    عدد النقاط: <span id="pointsCounter">0</span> 🩸
</div>


    <?php if ($total_donations > 0): ?>
        <table>
            <tr>
                <th>فصيلة الدم</th>
                <th>الكمية (مل)</th>
                <th>تاريخ التبرع</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['blood_type']) ?></td>
                    <td><?= htmlspecialchars($row['amount']) ?></td>
                    <td><?= htmlspecialchars($row['donation_date']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="no-data">لا يوجد تبرعات مسجلة حتى الآن.</div>
    <?php endif; ?>

    <a href="home.php" class="back-home">🏠 الرجوع إلى الصفحة الرئيسية</a>
</div>

<!-- عداد JS -->
<script>
    let counter = 0;
const total = <?= $total_donations ?>;
const pointsPerDonation = 10;
const display = document.getElementById("donationCounter");
const pointsDisplay = document.getElementById("pointsCounter");

const increment = () => {
    if (counter < total) {
        counter++;
        display.textContent = counter;
        pointsDisplay.textContent = counter * pointsPerDonation;
        setTimeout(increment, 100);
    }
};

increment();

</script>

</body>
</html>
