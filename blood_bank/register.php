<?php
session_start();
$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $blood_type = $_POST['blood_type'] ?? '';

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $message = "❌ هذا البريد الإلكتروني مسجل بالفعل.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, blood_type) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $email, $password, $blood_type);
            if ($stmt->execute()) {
                $message = "✅ تم التسجيل بنجاح! يمكنك الآن تسجيل الدخول.";
            } else {
                $message = "❌ حدث خطأ أثناء التسجيل.";
            }
            $stmt->close();
        } else {
            $message = "❌ خطأ في إعداد قاعدة البيانات.";
        }
    }

    $check->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل - بنك الدم</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            background: #1e1e2f;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .blood-drop {
            position: absolute;
            width: 20px;
            height: 20px;
            background: crimson;
            border-radius: 50%;
            animation: fall 5s linear infinite;
            opacity: 0.7;
        }

        @keyframes fall {
            0% {top: -20px;}
            100% {top: 110%;}
        }

        .header-animation {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100px;
            overflow: hidden;
            background: linear-gradient(to bottom, #282c3f, transparent);
        }

        .register-box {
            background-color: #2f3244;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0,0,0,0.5);
            z-index: 1;
            position: relative;
            width: 400px;
            text-align: center;
        }

        .register-box h2 {
            color: #00c3ff;
            margin-bottom: 30px;
        }

        label {
            color: #eee;
            display: block;
            text-align: right;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            background: #44495f;
            color: white;
        }

        button {
            background-color: #00c3ff;
            border: none;
            padding: 14px;
            border-radius: 10px;
            width: 100%;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #00a4d6;
        }

        .message {
            margin-top: 15px;
            color: yellow;
            font-weight: bold;
        }

        .back-link a {
            color: #ccc;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .footer-animation {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 80px;
            background: radial-gradient(circle at center, #444 0%, transparent 80%);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="header-animation" id="drops"></div>

<div class="register-box">
    <h2>تسجيل مستخدم جديد</h2>
    <form method="POST">
        <label>الاسم الكامل:</label>
        <input type="text" name="name" required>

        <label>البريد الإلكتروني:</label>
        <input type="email" name="email" required>

        <label>كلمة المرور:</label>
        <input type="password" name="password" required>

        <label>فصيلة الدم:</label>
        <select name="blood_type" required>
            <option disabled selected>اختر فصيلة دمك</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select>

        <button type="submit">تسجيل</button>
        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
        <div class="back-link">
            <a href="index.php">🔙 العودة للرئيسية</a>
        </div>
    </form>
</div>

<div class="footer-animation">جميع الحقوق محفوظة © بنك الدم 2025</div>

<script>
    // توليد نقاط دم متساقطة
    const dropsContainer = document.getElementById('drops');
    for (let i = 0; i < 30; i++) {
        const drop = document.createElement('div');
        drop.classList.add('blood-drop');
        drop.style.left = Math.random() * 100 + 'vw';
        drop.style.animationDuration = (3 + Math.random() * 3) + 's';
        drop.style.opacity = Math.random();
        dropsContainer.appendChild(drop);
    }
</script>
</body>
</html>


