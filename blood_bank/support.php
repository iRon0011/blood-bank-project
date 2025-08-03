<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>الدعم الفني</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Cairo', sans-serif;
      background-color: #2b2b2b;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
      overflow: hidden;
    }

    .support-box {
      background: rgba(255,255,255,0.05);
      padding: 30px;
      border-radius: 15px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 0 15px rgba(255,0,0,0.4);
      backdrop-filter: blur(10px);
      position: relative;
      z-index: 2;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #ff4c4c;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
    }

    button {
      padding: 12px 20px;
      border: none;
      background-color: #ff0000;
      color: white;
      font-size: 16px;
      border-radius: 10px;
      cursor: pointer;
      width: 100%;
      transition: 0.3s;
    }

    button:hover {
      background-color: #cc0000;
    }

    .back-btn {
      margin-top: 15px;
      display: inline-block;
      text-align: center;
      color: #ccc;
      text-decoration: underline;
      cursor: pointer;
    }

    /* نزول دم */
    .drop {
      position: absolute;
      width: 15px;
      height: 15px;
      background: red;
      border-radius: 50%;
      animation: fall linear infinite;
      opacity: 0.7;
    }

    @keyframes fall {
      0% {
        top: -50px;
        left: calc(100vw * var(--x));
        opacity: 1;
      }
      100% {
        top: 100vh;
        left: calc(100vw * var(--x) + 50px);
        opacity: 0;
      }
    }
  </style>
</head>
<body>

<script>
  for (let i = 0; i < 20; i++) {
    const drop = document.createElement('div');
    drop.classList.add('drop');
    drop.style.setProperty('--x', Math.random());
    drop.style.animationDuration = (4 + Math.random() * 4) + 's';
    document.body.appendChild(drop);
  }
</script>

<div class="support-box">
  <h2>الدعم الفني</h2>
  <form method="post">
    <input type="text" name="name" placeholder="الاسم" required>
    <input type="text" name="address" placeholder="العنوان" required>
    <textarea name="message" placeholder="مضمون الرسالة" rows="5" required></textarea>
    <button type="submit">إرسال</button>
  </form>

  <div class="back-btn" onclick="window.location.href='home.php'">↩ العودة للصفحة الرئيسية</div>

  <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $conn = new mysqli("localhost", "root", "", "blood_bank"); // ← عدل اسم قاعدة البيانات

      if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
      }

      $name = $conn->real_escape_string($_POST['name']);
      $address = $conn->real_escape_string($_POST['address']);
      $message = $conn->real_escape_string($_POST['message']);

      $sql = "INSERT INTO support_messages (name, address, message) VALUES ('$name', '$address', '$message')";

      if ($conn->query($sql) === TRUE) {
        echo "<p style='color:lightgreen; margin-top:10px;'>تم إرسال رسالتك بنجاح!</p>";
      } else {
        echo "<p style='color:yellow; margin-top:10px;'>حدث خطأ أثناء الإرسال.</p>";
      }

      $conn->close();
    }
  ?>
</div>

</body>
</html>
