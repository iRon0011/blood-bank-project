<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تعديل مستخدم</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(to left, #770000, #000);
      color: white;
      overflow-x: hidden;
      position: relative;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      padding: 30px;
      background-color: rgba(255,255,255,0.08);
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(255,0,0,0.4);
      backdrop-filter: blur(8px);
    }

    h2 {
      text-align: center;
      color: #fff;
      margin-bottom: 30px;
      font-size: 28px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-size: 18px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    select {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ff0000;
      background-color: rgba(0,0,0,0.5);
      color: white;
      font-size: 16px;
      font-family: 'Cairo', sans-serif;
    }

    .btn-group {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }

    .btn {
      padding: 12px 25px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      font-family: 'Cairo', sans-serif;
    }

    .btn-submit {
      background-color: #4CAF50;
      color: white;
    }

    .btn-submit:hover {
      background-color: #45a049;
      box-shadow: 0 0 10px rgba(76, 175, 80, 0.7);
    }

    .btn-back {
      background-color: #f44336;
      color: white;
    }

    .btn-back:hover {
      background-color: #d32f2f;
      box-shadow: 0 0 10px rgba(244, 67, 54, 0.7);
    }

    /* تأثير نزول دم */
    .drop {
      position: fixed;
      top: -50px;
      width: 10px;
      height: 30px;
      background: red;
      border-radius: 50%;
      opacity: 0.5;
      animation: fall linear infinite;
    }

    @keyframes fall {
      to {
        transform: translateY(110vh);
        opacity: 0;
      }
    }
  </style>
</head>
<body>

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

// جلب بيانات المستخدم
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("المستخدم غير موجود.");
    }
} else {
    die("معرف المستخدم غير محدد.");
}

// تحديث بيانات المستخدم
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $blood_type = trim($_POST['blood_type']);

    $sql = "UPDATE users SET name = ?, email = ?, phone = ?, blood_type = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $blood_type, $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?section=users");
        exit();
    } else {
        echo "<script>alert('حدث خطأ أثناء التحديث: " . $conn->error . "');</script>";
    }
}
?>

<div class="container">
  <h2>تعديل بيانات المستخدم</h2>
  
  <form method="post" action="">
    <div class="form-group">
      <label for="name">الاسم الكامل:</label>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
    </div>
    
    <div class="form-group">
      <label for="email">البريد الإلكتروني:</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </div>
    
    <div class="form-group">
      <label for="phone">رقم الهاتف:</label>
      <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
    </div>
    
    <div class="form-group">
      <label for="blood_type">فصيلة الدم:</label>
      <select id="blood_type" name="blood_type" required>
        <option value="A+" <?php echo ($user['blood_type'] == 'A+') ? 'selected' : ''; ?>>A+</option>
        <option value="A-" <?php echo ($user['blood_type'] == 'A-') ? 'selected' : ''; ?>>A-</option>
        <option value="B+" <?php echo ($user['blood_type'] == 'B+') ? 'selected' : ''; ?>>B+</option>
        <option value="B-" <?php echo ($user['blood_type'] == 'B-') ? 'selected' : ''; ?>>B-</option>
        <option value="AB+" <?php echo ($user['blood_type'] == 'AB+') ? 'selected' : ''; ?>>AB+</option>
        <option value="AB-" <?php echo ($user['blood_type'] == 'AB-') ? 'selected' : ''; ?>>AB-</option>
        <option value="O+" <?php echo ($user['blood_type'] == 'O+') ? 'selected' : ''; ?>>O+</option>
        <option value="O-" <?php echo ($user['blood_type'] == 'O-') ? 'selected' : ''; ?>>O-</option>
      </select>
    </div>
    
    <div class="btn-group">
      <button type="button" class="btn btn-back" onclick="window.location.href='dashboard.php?section=users'">
        الرجوع
      </button>
      <button type="submit" class="btn btn-submit">حفظ التعديلات</button>
    </div>
  </form>
</div>

<!-- تأثير نزول دم -->
<script>
  setInterval(() => {
    const drop = document.createElement("div");
    drop.className = "drop";
    drop.style.left = Math.random() * window.innerWidth + "px";
    drop.style.animationDuration = (2 + Math.random() * 2) + "s";
    document.body.appendChild(drop);
    setTimeout(() => drop.remove(), 5000);
  }, 300);
</script>

</body>
</html>
