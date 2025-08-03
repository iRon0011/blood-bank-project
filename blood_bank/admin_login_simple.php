<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تسجيل دخول الأدمن</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(135deg, #000, #770000);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.1);
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(255, 0, 0, 0.6);
      backdrop-filter: blur(10px);
      text-align: center;
      animation: fadeIn 1.5s ease-in-out;
    }

    h2 {
      color: white;
      margin-bottom: 20px;
      animation: floatText 3s ease-in-out infinite;
    }

    input[type="password"] {
      padding: 10px;
      border: none;
      border-radius: 10px;
      width: 80%;
      margin-bottom: 20px;
      font-size: 16px;
    }

    button {
      padding: 12px 30px;
      border: none;
      border-radius: 10px;
      background-color: #ff0000;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    button:hover {
      background-color: #cc0000;
      transform: scale(1.05);
    }

    .error {
      color: yellow;
      margin-top: 15px;
      font-size: 14px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes floatText {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    /* تأثيرات فقاعات دم */
    .bubble {
      position: absolute;
      width: 20px;
      height: 20px;
      background: red;
      border-radius: 50%;
      opacity: 0.5;
      animation: rise 10s linear infinite;
    }

    @keyframes rise {
      0% {
        bottom: -50px;
        left: calc(100vw * var(--randX));
        opacity: 0.5;
      }
      100% {
        bottom: 100vh;
        left: calc(100vw * var(--randX) + 50px);
        opacity: 0;
      }
    }
  </style>
</head>
<body>

  <!-- تأثير الفقاعات -->
  <script>
    for (let i = 0; i < 20; i++) {
      const bubble = document.createElement('div');
      bubble.classList.add('bubble');
      bubble.style.setProperty('--randX', Math.random());
      bubble.style.animationDuration = (5 + Math.random() * 5) + 's';
      document.body.appendChild(bubble);
    }
  </script>

  <div class="login-box">
    <h2>دخول الأدمن</h2>
    <form method="post">
      <input type="password" name="admin_pass" ahmed ="ادخل كلمة السر">
      <br>
      <button type="submit">دخول</button>
    </form>
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = $_POST["admin_pass"];
        if ($password === "123456") { // ← غيرها لو حبيت
          header("Location: dashboard.php");
          exit();
        } else {
          echo "<div class='error'>كلمة السر غير صحيحة!</div>";
        }
      }
    ?>
  </div>

</body>
</html>




