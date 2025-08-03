<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// معالجة التبرع المادي
$success_msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['amount'])) {
    $amount = floatval($_POST['amount']);
    if ($amount > 0) {
        $stmt = $conn->prepare("INSERT INTO monetary_donations (user_id, amount, donation_date) VALUES (?, ?, NOW())");
        $stmt->bind_param("id", $user_id, $amount);
        $stmt->execute();
        $success_msg = "✅ شكراً لتبرعك بمبلغ $amount جنيه!";
    }
}

// حساب النقاط والهدايا
$donation_points = $conn->query("SELECT COUNT(*) AS total FROM donations WHERE user_id = $user_id AND status = 'Completed'")->fetch_assoc()['total'] * 10;
$gifts = [
    ['name' => 'تيشيرت بنك الدم', 'points' => 30],
    ['name' => 'كوب حراري', 'points' => 50],
    ['name' => 'شنطة إسعافات أولية', 'points' => 80],
    ['name' => 'سماعة بلوتوث', 'points' => 100]
];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تبرع الآن - بنك الدم</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
            margin: 0;
            padding: 0;
            background: #1c1c1c;
            color: white;
            overflow-x: hidden;
            position: relative;
        }

        .navbar {
            background: #333;
            padding: 15px;
            text-align: center;
        }

        .navbar a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            padding: 30px;
            max-width: 800px;
            margin: auto;
            position: relative;
            z-index: 1;
        }

        h2 {
            color: #e74c3c;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input[type="number"], input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 18px;
            border-radius: 6px;
            border: none;
            margin-bottom: 10px;
        }

        button {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 12px 25px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 6px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .points {
            background: #fff3cd;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            color: #333;
            position: relative;
            animation: glow 2s infinite alternate;
        }

        @keyframes glow {
            from { box-shadow: 0 0 10px #e67e22; }
            to { box-shadow: 0 0 25px #f1c40f; }
        }

        .gifts {
            margin-top: 20px;
        }

        .gift-item {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 5px solid #c0392b;
            border-radius: 6px;
            color: #333;
            transition: transform 0.3s;
        }

        .gift-item:hover {
            transform: scale(1.02);
        }

        .footer {
            text-align: center;
            padding: 15px;
            background: #444;
            margin-top: 40px;
            color: white;
        }

        /* قطرات دم متحركة */
        .blood-drop {
            width: 12px;
            height: 12px;
            background: #e74c3c;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            position: absolute;
            top: -20px;
            animation: fall 5s linear infinite;
            opacity: 0.7;
        }

        @keyframes fall {
            0% { top: -20px; opacity: 0.7; }
            100% { top: 100%; opacity: 0; }
        }

        .blood-animation-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .payment-section {
            background: #2c3e50;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .payment-section h3 {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>


<div class="navbar">
    <a href="home.php">🏠 الرئيسية</a>
    <a href="donate_now.php">💸 تبرع الآن</a>
</div>

<div class="container">
    <h2>💸 تبرع مادي</h2>
    <?php if ($success_msg): ?>
        <div class="success"><?= $success_msg ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label>أدخل المبلغ (بالجنيه المصري):</label>
            <input type="number" name="amount" min="1" required>
        </div>

        <div class="payment-section">
            <h3>💳 اختر طريقة الدفع:</h3>
            <label>بطاقة فيزا:</label>
            <input type="text" placeholder="رقم البطاقة" maxlength="16" required>
            <input type="text" placeholder="تاريخ الانتهاء (MM/YY)" maxlength="5" required>
            <input type="text" placeholder="CVV" maxlength="3" required>

            <hr>

            <label>أو التحويل البنكي:</label>
            <input type="text" value="1234567890 - بنك مصر" readonly>
        </div>

        <button type="submit">تبرع الآن</button>
    </form>


    
</div>

<div class="footer">
    &copy; <?= date("Y") ?> بنك الدم الإلكتروني - كل الحقوق محفوظة
</div>

<!-- قطرات دم -->
<div class="blood-animation-container">
    <?php for ($i = 0; $i < 20; $i++): ?>
        <div class="blood-drop" style="left: <?= rand(0, 100) ?>%; animation-delay: <?= rand(0, 5) ?>s;"></div>
    <?php endfor; ?>
</div>

</body>
</html>
