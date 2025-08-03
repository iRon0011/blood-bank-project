
<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$database = "blood_bank";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// عند إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $phone = trim($_POST['phone']);
    $blood_type = trim($_POST['blood_type']);

    $sql = "INSERT INTO users (name, email, password, phone, blood_type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $password, $phone, $blood_type);

    if ($stmt->execute()) {
        header("Location: users.php");
        exit();
    } else {
        $error = "حدث خطأ أثناء الإضافة: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة مستخدم جديد - بنك الدم</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #d32f2f;
            --secondary-color: #1976d2;
            --dark-color: #121212;
            --light-color: #f5f5f5;
            --accent-color: #ffab00;
            --success-color: #388e3c;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to left, #770000, #000);
            color: white;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(30, 30, 30, 0.7);
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 0, 0, 0.2);
        }
        
        h2 {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-size: 28px;
            position: relative;
            padding-bottom: 15px;
        }
        
        h2::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            width: 100px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        input, select {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.1);
            color: white;
            font-family: 'Cairo', sans-serif;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 10px rgba(211, 47, 47, 0.5);
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 30px;
            text-align: center;
        }
        
        .btn:hover {
            background: #b71c1c;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(211, 47, 47, 0.6);
        }
        
        .btn i {
            margin-left: 8px;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #ff9999;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .back-link:hover {
            color: white;
            text-decoration: underline;
        }
        
        .error-message {
            color: #ff6b6b;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        /* تأثير نزول دم */
        .drop {
            position: fixed;
            top: -50px;
            width: 10px;
            height: 30px;
            background: red;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            opacity: 0.7;
            pointer-events: none;
            z-index: -1;
            animation: fall linear forwards;
        }
        
        @keyframes fall {
            to {
                transform: translateY(100vh) rotate(-45deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2><i class="fas fa-user-plus"></i> إضافة مستخدم جديد</h2>
    
    <?php if(isset($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="post" action="">
        <div class="form-group">
            <label for="name"><i class="fas fa-user"></i> الاسم الكامل</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> كلمة المرور</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label for="phone"><i class="fas fa-phone"></i> رقم الهاتف</label>
            <input type="text" id="phone" name="phone" required>
        </div>
        
        <div class="form-group">
            <label for="blood_type"><i class="fas fa-tint"></i> فصيلة الدم</label>
            <select id="blood_type" name="blood_type" required>
                <option value="">اختر فصيلة الدم</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>
        </div>
        
        <button type="submit" class="btn">
            <i class="fas fa-save"></i> إضافة مستخدم
        </button>
    </form>
    
    <a href="users.php" class="back-link">
        <i class="fas fa-arrow-right"></i> العودة إلى قائمة المستخدمين
    </a>
</div>

<!-- تأثيرات الدم المتحركة -->
<script>
    function createBloodDrops() {
        const drop = document.createElement('div');
        drop.className = 'drop';
        
        const size = Math.random() * 15 + 5;
        const posX = Math.random() * window.innerWidth;
        const duration = Math.random() * 3 + 2;
        
        drop.style.width = `${size}px`;
        drop.style.height = `${size * 1.5}px`;
        drop.style.left = `${posX}px`;
        drop.style.top = `-30px`;
        drop.style.animationDuration = `${duration}s`;
        
        document.body.appendChild(drop);
        
        setTimeout(() => {
            drop.remove();
        }, duration * 1000);
    }
    
    setInterval(createBloodDrops, 300);
</script>

</body>
</html>