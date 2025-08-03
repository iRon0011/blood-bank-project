<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>بنك الدم الإلكتروني</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #D90429;
      --secondary-color: #2b2d42;
      --admin-color: #08f7fe;
      --register-color:rgb(11, 153, 255);
      --dark-bg: #1a1a1a;
      --light-text: #f9f9f9;
      --glass: rgba(255,255,255,0.08);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Cairo', sans-serif;
    }

    body {
      background-color: var(--dark-bg);
      color: var(--light-text);
    }

    header {
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background: linear-gradient(145deg, #2a2a2a, #1c1c1c);
      position: relative;
      overflow: hidden;
      text-align: center;
      padding: 20px;
    }

    header::before {
      content: "";
      background: url('https://i.gifer.com/Wo7p.gif') no-repeat center;
      background-size: contain;
      opacity: 0.03;
      position: absolute;
      top: 0; right: 0; bottom: 0; left: 0;
      z-index: 0;
    }

    .logo {
      font-size: 60px;
      font-weight: bold;
      color: var(--primary-color);
      z-index: 1;
      margin-bottom: 15px;
    }

    .subtitle {
      font-size: 20px;
      margin-bottom: 30px;
      z-index: 1;
      color: #ccc;
    }

    .btn-group {
      z-index: 1;
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      justify-content: center;
      margin-bottom: 40px;
    }

    .btn-group a {
      padding: 12px 25px;
      border-radius: 30px;
      text-decoration: none;
      font-size: 16px;
      transition: all 0.3s ease-in-out;
      color: white;
    }

    .btn-register {
      background: var(--register-color);
      color: #000;
      font-weight: bold;
    }

    .btn-register:hover {
      background:rgb(0, 179, 255);
      transform: scale(1.08);
    }

    .btn-login {
      background: var(--primary-color);
    }

    .btn-login:hover {
      background: #ff3c3c;
      transform: scale(1.05);
    }

    .btn-admin {
      background: transparent;
      border: 2px solid var(--admin-color);
      color: var(--admin-color);
    }

    .btn-admin:hover {
      background: var(--admin-color);
      color: #000;
      transform: scale(1.05);
    }

    .features {
      z-index: 1;
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      max-width: 1000px;
      margin-top: 20px;
    }

    .feature {
      background: var(--glass);
      padding: 20px;
      border-radius: 15px;
      width: 220px;
      text-align: center;
      backdrop-filter: blur(10px);
      box-shadow: 0 0 10px rgba(255, 0, 0, 0.1);
      transition: 0.3s;
    }

    .feature:hover {
      transform: scale(1.07);
      background: rgba(255, 255, 255, 0.15);
    }

    footer {
      background: #111;
      padding: 30px 20px;
      color: #aaa;
      font-size: 15px;
      margin-top: 60px;
    }

    .marquee {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 25px;
      margin-top: 20px;
      animation: fadeIn 1s ease-in-out;
    }

    .marquee .item {
      display: flex;
      align-items: center;
      gap: 10px;
      background: #222;
      padding: 10px 20px;
      border-radius: 30px;
      box-shadow: 0 0 5px rgba(255,255,255,0.05);
      transition: 0.3s;
    }

    .marquee .item:hover {
      background: #333;
    }

    .marquee svg {
      width: 20px;
      height: 20px;
      fill: var(--primary-color);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px);}
      to { opacity: 1; transform: translateY(0);}
    }

    @media (max-width: 768px) {
      .logo {
        font-size: 40px;
      }
      .subtitle {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">بنك الدم</div>
    <div class="subtitle">أنقذ حياة شخص... بتبرع بسيط</div>

    <div class="btn-group">
      <a href="register.php" class="btn-register">📝 تسجيل</a>
      <a href="login.php" class="btn-login">🔐 تسجيل الدخول</a>
      <a href="admin_login_simple.php" class="btn-admin">🛡️ دخول المشرف</a>
      
      <a href="hospitals.php" class="btn-login" style="background: #4CAF50;">🏥 المستشفيات</a>
    </div>

    <div class="features">
      <div class="feature">🩸 حجز موعد</div>
      <div class="feature">📍 أقرب نقطة تبرع</div>
      <div class="feature">💳 تبرع مالي</div>
      <div class="feature">🎁 نظام النقاط والهدايا</div>
      <div class="feature">🔔 إشعارات فورية</div>
    </div>
  </header>

  <footer>
    <div class="marquee">
      <div class="item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C10 7 5 9 5 14a7 7 0 0 0 14 0c0-5-5-7-7-12z"/></svg>
        <span>التبرع ينقذ الأرواح</span>
      </div>
      <div class="item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3 3v18h18V3H3zm16 16H5V5h14v14z"/></svg>
        <span>كل وحدة دم يتم فحصها</span>
      </div>
      <div class="item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 22c5.5 0 10-4.5 10-10S17.5 2 12 2 2 6.5 2 12s4.5 10 10 10z"/></svg>
        <span>اجمع نقاطك وبدلها بهدايا</span>
      </div>
      <div class="item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 7v5l4 2"/></svg>
        <span>يستغرق فقط 15 دقيقة</span>
      </div>
    </div>
    <br>
    <div style="text-align: center; color: #666;">حقوق النشر © 2025 - بنك الدم الإلكتروني</div>
  </footer>
  

</body>
</html>



