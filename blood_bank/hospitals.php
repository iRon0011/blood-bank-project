<?php
session_start();

// كلمة السر المطلوبة
$correct_password = "123456";

// التحقق من كلمة السر
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["page_password"])) {
    if ($_POST["page_password"] === $correct_password) {
        $_SESSION['authenticated'] = true;
    } else {
        $error = "كلمة السر غير صحيحة!";
    }
}

// إذا المستخدم غير مسجل الدخول، يظهر له نموذج الباسورد
if (!isset($_SESSION['authenticated'])) {
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>كلمة السر</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
  <style>
    body {
      background: #2e2e2e;
      color: white;
      font-family: 'Cairo', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
    }
    .blood-drop {
      position: absolute;
      width: 6px;
      height: 12px;
      background: red;
      border-radius: 50% 50% 50% 50%/60% 60% 40% 40%;
      animation: fall linear infinite;
      z-index: -1;
      opacity: 0.6;
    }
    @keyframes fall {
      0% { transform: translateY(-100vh); opacity: 1; }
      100% { transform: translateY(100vh); opacity: 0; }
    }
    .login-box {
      background: #222;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 0 15px red;
      z-index: 2;
    }
    input {
      padding: 10px;
      width: 80%;
      margin: 10px 0;
      border-radius: 8px;
      border: none;
    }
    button {
      padding: 10px 25px;
      background: red;
      border: none;
      color: white;
      border-radius: 8px;
      cursor: pointer;
    }
    .error {
      color: yellow;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <script>
    for (let i = 0; i < 30; i++) {
      let drop = document.createElement('div');
      drop.className = 'blood-drop';
      drop.style.left = Math.random() * 100 + 'vw';
      drop.style.animationDuration = (Math.random() * 5 + 2) + 's';
      drop.style.animationDelay = Math.random() * 5 + 's';
      document.body.appendChild(drop);
    }
  </script>

  <div class="login-box">
    <h2>ادخل كلمة السر للدخول</h2>
    <form method="post">
      <input type="password" name="page_password" placeholder="كلمة السر" required>
      <br>
      <button type="submit">دخول</button>
    </form>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
  </div>
</body>
</html>
<?php
exit();
}
?>

<?php
// الاتصال بقاعدة البيانات بعد التحقق
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$sql = "SELECT blood_type, COUNT(*) as count FROM hospitals GROUP BY blood_type";
$result = $conn->query($sql);

$blood_stats = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blood_stats[$row['blood_type']] = $row['count'];
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>المستشفيات - بنك الدم</title> 
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #2e2e2e;
            color: #fff;
            font-family: 'Cairo', sans-serif;
            padding: 20px;
            overflow-x: hidden;
        }
        .blood-drop {
            position: absolute;
            width: 6px;
            height: 12px;
            background: red;
            border-radius: 50% 50% 50% 50%/60% 60% 40% 40%;
            animation: fall linear infinite;
            z-index: -1;
            opacity: 0.6;
        }
        @keyframes fall {
            0% { transform: translateY(-100vh); opacity: 1; }
            100% { transform: translateY(100vh); opacity: 0; }
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 10px;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        .stat {
            background: #444;
            padding: 15px;
            border-radius: 8px;
            width: 120px;
            text-align: center;
        }
        form {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input, select, textarea, button {
            padding: 10px;
            border-radius: 5px;
            border: none;
        }
        button {
            background: #c0392b;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #e74c3c;
        }
        a.back, a.logout {
            display: inline-block;
            margin-top: 20px;
            color: white;
            text-decoration: none;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <script>
        for (let i = 0; i < 30; i++) {
            let drop = document.createElement('div');
            drop.className = 'blood-drop';
            drop.style.left = Math.random() * 100 + 'vw';
            drop.style.animationDuration = (Math.random() * 5 + 2) + 's';
            drop.style.animationDelay = Math.random() * 5 + 's';
            document.body.appendChild(drop);
        }
    </script>

    <div class="container">
        <h1>إحصائيات مخزون الدم</h1>
        <div class="stats">
            <?php foreach ($blood_stats as $type => $count): ?>
                <div class="stat">
                    <strong><?= htmlspecialchars($type) ?></strong><br>
                    <?= $count ?> وحدة
                </div>
            <?php endforeach; ?>
        </div>

        <h2 style="margin-top:30px;">طلب دم أو التواصل مع المشرف</h2>
        <form action="send_request.php" method="POST">
            <input type="text" name="hospital_name" placeholder="اسم المستشفى" required>
            <input type="text" name="contact_person" placeholder="اسم المسؤول" required>
            <input type="text" name="phone" placeholder="رقم الهاتف" required>
            <select name="blood_type" required>
                <option value="">-- اختر فصيلة الدم --</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
            <input type="number" name="quantity" placeholder="الكمية المطلوبة (بالوحدات)" required>
            <textarea name="notes" placeholder="ملاحظات إضافية"></textarea>
            <button type="submit">إرسال الطلب</button>
        </form>

        <a class="back" href="index.php">⬅ العودة للرئيسية</a>
        <a class="logout" href="logout.php">🔒 تسجيل الخروج</a>
    </div>
</body>
</html>
