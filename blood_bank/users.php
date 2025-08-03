<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إدارة المستخدمين - بنك الدم</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(to left, #770000, #000);
      color: white;
      overflow-x: hidden;
    }

    .container {
      max-width: 1200px;
      margin: 50px auto;
      padding: 30px;
      background-color: rgba(255,255,255,0.08);
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(255,0,0,0.4);
      backdrop-filter: blur(8px);
    }

    h1 {
      text-align: center;
      color: #fff;
      margin-bottom: 30px;
      font-size: 32px;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
    }

    .btn {
      padding: 12px 25px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .btn-primary {
      background-color: #4CAF50;
      color: white;
    }

    .btn-primary:hover {
      background-color: #45a049;
      box-shadow: 0 0 10px rgba(76, 175, 80, 0.7);
    }

    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .data-table th {
      background-color: crimson;
      padding: 15px;
      text-align: center;
      font-size: 18px;
    }

    .data-table td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .data-table tr:hover {
      background-color: rgba(255,0,0,0.1);
    }

    .action-btn {
      padding: 8px 15px;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s;
      margin: 0 5px;
      text-decoration: none;
      display: inline-block;
    }

    .edit-btn {
      background-color: #ffcc00;
      color: #000;
    }

    .edit-btn:hover {
      background-color: #e6b800;
      box-shadow: 0 0 8px rgba(255, 204, 0, 0.7);
    }

    .delete-btn {
      background-color: #f44336;
      color: white;
    }

    .delete-btn:hover {
      background-color: #d32f2f;
      box-shadow: 0 0 8px rgba(244, 67, 54, 0.7);
    }

    .no-data {
      text-align: center;
      padding: 20px;
      font-size: 18px;
      color: #ff9999;
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

// تحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// جلب المستخدمين من قاعدة البيانات
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<div class="container">
  <h1>إدارة المستخدمين</h1>
  
  <div class="top-bar">
    <a href="dashboard.php" class="btn">العودة للوحة التحكم</a>
    <a href="add_user.php" class="btn btn-primary">إضافة مستخدم جديد</a>
  </div>

  <table class="data-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>الاسم</th>
        <th>البريد الإلكتروني</th>
        <th>الهاتف</th>
        <th>فصيلة الدم</th>
        <th>الإجراءات</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['blood_type']); ?></td>
            <td>
              <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="action-btn edit-btn">تعديل</a>
              <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا المستخدم؟');">حذف</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="6" class="no-data">لا يوجد مستخدمين مسجلين</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
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

<?php
$conn->close();
?>
</body>
</html>