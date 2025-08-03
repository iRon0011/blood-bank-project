<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الرئيسية - بنك الدم</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #ffebee, #fce4ec);
            overflow-x: hidden;
        }
        nav {
            background-color:rgb(86, 84, 72);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        nav .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }
        nav a {
            color: white;
            margin: 0 8px;
            text-decoration: none;
            font-weight: 600;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 25px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }
        h2, h3 {
            color:rgb(17, 92, 143);
        }
        .video-box, .awareness-text, .features, .images, .gifs {
            margin-top: 30px;
        }
        video {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .features ul {
            list-style: none;
            padding: 0;
        }
        .features li {
            background:rgb(154, 197, 208);
            margin-bottom: 10px;
            padding: 14px;
            border-right: 6px solidrgb(20, 61, 173);
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
        }
        .awareness-text p {
            line-height: 1.8;
            background-color:rgb(122, 47, 72);
            padding: 18px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            font-size: 17px;
        }
        .images, .gifs {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        .images img, .gifs img {
            width: 48%;
            border-radius: 12px;
            box-shadow: 0 6px 14px rgba(0,0,0,0.2);
        }
        .welcome {
            background:rgb(159, 192, 207);
            padding: 15px;
            border-radius: 12px;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }
        .marquee {
            background:rgb(128, 160, 175);
            color: white;
            padding: 12px;
            font-weight: bold;
            font-size: 17px;
            margin-top: 40px;
            border-radius: 10px;
            animation: scrollText 30s linear infinite;
        }
        footer {
            background-color:rgb(20, 128, 138);
            padding: 20px;
            text-align: center;
            color: white;
            margin-top: 50px;
            position: relative;
        }
        .moving-awareness {
            white-space: nowrap;
            overflow: hidden;
            box-sizing: border-box;
        }
        .moving-awareness span {
            display: inline-block;
            padding-left: 100%;
            animation: moveLeft 20s linear infinite;
            font-weight: bold;
            font-size: 18px;
        }
        @keyframes moveLeft {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
        @keyframes scrollText {
            from { transform: translateX(100%); }
            to { transform: translateX(-100%); }
        }
        body {
    font-family: 'Cairo', sans-serif;
    background: #2f2f2f; /* رمادي داكن */
    direction: rtl;
    padding: 30px;
    color: #fff;
}
    </style>
</head>
<body>
<nav>
<div class="nav-right">
        <a href="schedule.php">حجز موعد</a>
        
        <a href="my_history.php">سجل تبرعاتي</a>
        <a href="notifications.php">الإشعارات</a>
        <a href="match_search.php">مطابقة فصائل</a>
        <a href="support.php">الدعم الفني</a>
        <a href="location.php">موقع تبرع</a>
        <a href="rewards.php"> هدايا</a>
        <a href="donate.php">تبرع الآن</a>
        <a href="chatbot_ai.php" class="btn" style="background:#d32f2f; color:white; padding:8px 18px; border-radius:10px;">🤖 الروبوت الذكي</a>
        <a href="recommendation.php" class="btn" style="margin: 10px; padding: 10px 20px; border-radius: 8px; background-color: #d81b60; color: white;">نظام الذكي</a>
       
        <a href="logout.php">تسجيل الخروج</a>
    </div>
    <div class="logo">🩸 بنك الدم</div>
</nav>
<div class="container">
    <div class="welcome">👋 مرحبًا، <?= htmlspecialchars($_SESSION['name'] ?? 'زائر'); ?>! شكرًا لانضمامك إلينا ❤️</div>
    <div class="video-box">
        <h3>🎥 شاهد الفيديو التوعوي التالي</h3>
        <video controls>
            <source src="images/non.mp4" type="video/mp4">
            المتصفح لا يدعم عرض الفيديو.
        </video>
    </div>
    <div class="awareness-text">
        <h3>📢 لماذا التبرع بالدم مهم؟</h3>
        <p>التبرع بالدم هو عمل إنساني نبيل يمكنه إنقاذ حياة الكثير من المرضى والمصابين. كل تبرع يمكن أن ينقذ حياة ثلاثة أشخاص! لا تتردد، كن أنت الأمل لشخص ما، تبرع الآن وساهم في صناعة الفرق.</p>
    </div>
    <div class="features">
        <h3>✨ خدماتنا المميزة:</h3>
        <ul>
            <li>🗓 حجز موعد للتبرع بسهولة</li>
            <li>💉 تتبع التبرعات ونقاط المكافآت</li>
            <li>🔔 إشعارات فورية عند الحاجة للدم</li>
            <li>📜 عرض سجل تبرعاتك بالكامل</li>
            <li>🧬 نظام مطابقة فصائل متقدم</li>
            <li>🎁 استبدال النقاط بهدايا توعوية</li>
            <li>📍 تحديد أقرب مراكز التبرع تلقائيًا</li>
            <li>🤖 روبوت دردشة ذكي لمساعدتك</li>
        </ul>
    </div>
    <div class="images">
        <img src="images/nn.avif" alt="تبرع 1">
        <img src="images/mm.jpeg" alt="تبرع 2">
    </div>
    <div class="gifs">
        <img src="images/chat.png" alt="تبرع متحرك">
        <img src="images/chat.png" alt="توعية متحركة">
    </div>
    <div class="marquee">✅ كن أنت السبب في إنقاذ حياة ❤️ تبرع الآن عبر بنك الدم الإلكتروني</div>
</div>
<footer>
    <div class="moving-awareness">
        <span>التبرع بالدم ينقذ الأرواح ✨ شارك بقطرة حياة 💉 | حملات دورية للتبرع تنتظرك 🗓 | ساعد غيرك ولو مرة واحدة ♥️ | كن بطلًا في نظر من يحتاجك 🦸</span>
    </div>
</footer>
<script>
    const messages = [
        "هل تعلم؟ كل تبرع يمكن أن ينقذ 3 أرواح!",
        "انشر الوعي وكن مصدر أمل للآخرين",
        "نظام النقاط لدينا يقدّر عطائك",
        "ساهم في بناء مجتمع صحي ومتعاون"
    ];
    let i = 0;
    setInterval(() => {
        document.querySelector('.marquee').textContent = '✅ ' + messages[i % messages.length];
        i++;
    }, 6000);
</script>
<canvas id="bloodCanvas" style="position:fixed; top:0; left:0; z-index:-1;"></canvas>
<script>
    const canvas = document.getElementById("bloodCanvas");
    const ctx = canvas.getContext("2d");
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    let drops = [];

    function createDrop() {
        return {
            x: Math.random() * canvas.width,
            y: 0,
            r: Math.random() * 5 + 2,
            speed: Math.random() * 3 + 2
        };
    }

    for (let i = 0; i < 60; i++) drops.push(createDrop());

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let drop of drops) {
            ctx.beginPath();
            ctx.fillStyle = "#b71c1c";
            ctx.arc(drop.x, drop.y, drop.r, 0, Math.PI * 2);
            ctx.fill();
            drop.y += drop.speed;

            if (drop.y > canvas.height) {
                drop.y = 0;
                drop.x = Math.random() * canvas.width;
            }
        }
        requestAnimationFrame(animate);
    }

    animate();
    window.addEventListener("resize", () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });
</script>

</body>