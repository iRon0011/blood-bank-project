<?php
session_start();
$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            header("Location: home.php");
            exit;
        } else {
            $message = "❌ البريد الإلكتروني أو كلمة المرور غير صحيحة.";
        }

        $stmt->close();
    } else {
        $message = "حدث خطأ في قاعدة البيانات: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول - بنك الدم</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #2e2e2e;
            overflow: hidden;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .blood-drop {
            position: absolute;
            width: 15px;
            height: 25px;
            background-color: crimson;
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            animation: fall 4s infinite linear;
            opacity: 0.7;
        }

        @keyframes fall {
            0% {
                top: -50px;
                opacity: 0.8;
            }
            100% {
                top: 110%;
                opacity: 0;
            }
        }

        .login-box {
            background-color:rgb(24, 62, 87);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(17, 25, 28, 0.3);
            width: 380px;
            z-index: 10;
            position: relative;
        }

        h2 {
            text-align: center;
            color:rgb(156, 147, 170);
            margin-bottom: 25px;
            font-weight: bold;
            font-size: 26px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: white;
        }

        input[type=email], input[type=password] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #bbb;
            border-radius: 10px;
            background-color: #fff;
        }

        input:focus {
            border-color:rgb(20, 31, 34);
            outline: none;
            box-shadow: 0 0 5px rgba(32, 47, 50, 0.5);
        }

        button {
            background-color:rgb(86, 96, 100);
            color: white;
            border: none;
            padding: 14px;
            width: 100%;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background-color:rgb(35, 47, 51);
        }

        .message {
            margin-top: 15px;
            text-align: center;
            color: #d32f2f;
            font-weight: bold;
        }

        .back-link {
            margin-top: 20px;
            text-align: center;
        }

        .back-link a {
            text-decoration: none;
            color: #007baa;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .logo {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo img {
            width: 80px;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

<!-- قطرات الدم المتحركة -->
<?php for ($i = 0; $i < 30; $i++): ?>
    <div class="blood-drop" style="
        left: <?= rand(0, 100) ?>%;
        animation-delay: <?= rand(0, 5) ?>s;
        width: <?= rand(10, 20) ?>px;
        height: <?= rand(20, 30) ?>px;
    "></div>
<?php endfor; ?>

<div class="login-box">
    <div class="logo">
        <img src="images/ahmed.jpg" alt="شعار بنك الدم">
    </div>
    <h2>تسجيل الدخول</h2>
    <form method="POST" action="login.php">
        <label for="email">البريد الإلكتروني:</label>
        <input type="email" id="email" name="email" placeholder="example@email.com" required>

        <label for="password">كلمة المرور:</label>
        <input type="password" id="password" name="password" placeholder="********" required>

        <button type="submit">دخول</button>

        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <div class="back-link">
            <a href="index.php">🔙 العودة إلى الصفحة الرئيسية</a>
        </div>
    </form>
</div>

</body>
</html>











