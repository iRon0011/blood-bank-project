<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الخروج</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@500&display=swap');

        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            height: 100vh;
            background: radial-gradient(ellipse at bottom, #1b2735 0%, #090a0f 100%);
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .stars {
            width: 100%;
            height: 100%;
            background: transparent url('https://raw.githubusercontent.com/JulianLaval/canvas-particle-network/master/img/stars.png') repeat top center;
            position: absolute;
            animation: moveStars 200s linear infinite;
            z-index: 0;
        }

        @keyframes moveStars {
            from { background-position: 0 0; }
            to { background-position: 0 10000px; }
        }

        .logout-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(6px);
            max-width: 420px;
            width: 90%;
            text-align: center;
            z-index: 1;
            animation: pulse 2s infinite;
        }

        .logout-box h1 {
            font-size: 30px;
            margin-bottom: 20px;
        }

        .logout-box p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .logout-box span {
            font-size: 22px;
            font-weight: bold;
            color: #fff;
            background: #e74c3c;
            padding: 10px 20px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 10px;
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 15px rgba(255,255,255,0.2); }
            50% { transform: scale(1.03); box-shadow: 0 0 25px rgba(255,255,255,0.4); }
            100% { transform: scale(1); box-shadow: 0 0 15px rgba(255,255,255,0.2); }
        }

        @media (max-width: 600px) {
            .logout-box h1 {
                font-size: 24px;
            }

            .logout-box p {
                font-size: 16px;
            }

            .logout-box span {
                font-size: 18px;
            }
        }
    </style>

    <script>
        let countdown = 5;
        function updateCountdown() {
            const el = document.getElementById('countdown');
            const beep = document.getElementById('beep');

            if (countdown <= 0) {
                window.location.href = 'index.php';
            } else {
                el.textContent = countdown;
                beep.play();
                countdown--;
                setTimeout(updateCountdown, 1000);
            }
        }

        window.onload = updateCountdown;
    </script>
</head>
<body>

<audio id="beep" src="https://www.soundjay.com/button/beep-07.mp3" preload="auto"></audio>

<div class="stars"></div>

<div class="logout-box">
    <h1>👋 تم تسجيل الخروج بنجاح</h1>
    <p>سيتم تحويلك تلقائيًا إلى الصفحة الرئيسية خلال:</p>
    <span id="countdown">5</span> ثوانٍ
</div>

</body>
</html>