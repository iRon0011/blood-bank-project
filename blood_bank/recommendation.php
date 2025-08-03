<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نظام التوصية الذكي</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: #2c2c2c;
            color: white;
            padding: 30px;
            direction: rtl;
            overflow-x: hidden;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #3a3a3a;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(255, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        h2 {
            text-align: center;
            color: #ff4d4d;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            color: #f1f1f1;
        }

        input, select, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
        }

        input, select {
            background-color: #555;
            color: white;
        }

        button {
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #c0392b;
        }

        .recommendation {
            background: #444;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .main-back {
            display: block;
            text-align: center;
            margin-top: 30px;
            background: #1abc9c;
            color: white;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            border-radius: 12px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .main-back:hover {
            background: #16a085;
        }

        .blood-drop {
            position: fixed;
            width: 15px;
            height: 25px;
            background: red;
            border-radius: 50% 50% 50% 50%/60% 60% 40% 40%;
            animation: drop 3s linear infinite;
            z-index: 0;
            opacity: 0.6;
        }

        @keyframes drop {
            0% { top: -30px; opacity: 0.8; }
            100% { top: 100vh; opacity: 0; }
        }

        footer {
            margin-top: 50px;
            background-color: #222;
            padding: 15px;
            overflow: hidden;
            position: relative;
            border-top: 2px solid red;
        }

        .marquee {
            white-space: nowrap;
            display: inline-block;
            animation: marquee 15s linear infinite;
            color: #ff8080;
            font-size: 18px;
        }

        @keyframes marquee {
            0%   { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
    </style>
</head>
<body>

<script>
    for (let i = 0; i < 30; i++) {
        let drop = document.createElement('div');
        drop.className = 'blood-drop';
        drop.style.left = Math.random() * 100 + 'vw';
        drop.style.animationDelay = Math.random() * 5 + 's';
        drop.style.width = (10 + Math.random() * 10) + 'px';
        drop.style.height = (15 + Math.random() * 15) + 'px';
        document.body.appendChild(drop);
    }
</script>

<div class="container">
    <h2>🔍 نظام التوصية الذكي</h2>

    <form method="post">
        <label for="blood_type">فصيلة الدم</label>
        <select name="blood_type" required>
            <option value="">اختر الفصيلة</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select>

        <label for="last_donation">آخر تاريخ تبرع</label>
        <input type="date" name="last_donation" required>

        <label for="location">الموقع الحالي</label>
        <select name="location" required>
            <option value="">اختر المحافظة</option>
            <?php
            $governorates = [
                "القاهرة", "الجيزة", "الإسكندرية", "الدقهلية", "البحر الأحمر", "البحيرة", "الفيوم",
                "الغربية", "الإسماعيلية", "المنوفية", "المنيا", "القليوبية", "الوادي الجديد",
                "السويس", "أسوان", "أسيوط", "بني سويف", "بورسعيد", "دمياط", "الشرقية", "جنوب سيناء",
                "كفر الشيخ", "مطروح", "الأقصر", "قنا", "شمال سيناء", "سوهاج"
            ];
            foreach ($governorates as $gov) {
                echo "<option value=\"$gov\">$gov</option>";
            }
            ?>
        </select>

        <button type="submit" name="recommend">احصل على التوصية</button>
    </form>

    <?php
    if (isset($_POST['recommend'])) {
        $blood = $_POST['blood_type'];
        $last = $_POST['last_donation'];
        $location = $_POST['location'];

        $centers = [
            "القاهرة" => "مركز التبرع الرئيسي - مدينة نصر",
            "الجيزة" => "مستشفى أم المصريين",
            "الإسكندرية" => "مركز دم الإسكندرية العام",
            "الدقهلية" => "مستشفى المنصورة العام",
            "البحر الأحمر" => "مستشفى الغردقة المركزي",
            "البحيرة" => "مستشفى دمنهور التعليمي",
            "الفيوم" => "مستشفى الفيوم العام",
            "الغربية" => "مركز طنطا الإقليمي للدم",
            "الإسماعيلية" => "مستشفى الإسماعيلية العام",
            "المنوفية" => "مستشفى شبين الكوم",
            "المنيا" => "مستشفى المنيا الجامعي",
            "القليوبية" => "مستشفى بنها التعليمي",
            "الوادي الجديد" => "مستشفى الخارجة العام",
            "السويس" => "مستشفى السويس العام",
            "أسوان" => "مستشفى أسوان الجامعي",
            "أسيوط" => "مستشفى أسيوط العام",
            "بني سويف" => "مركز التبرع ببني سويف",
            "بورسعيد" => "مستشفى بورسعيد العام",
            "دمياط" => "مستشفى دمياط المركزي",
            "الشرقية" => "مستشفى الزقازيق العام",
            "جنوب سيناء" => "مستشفى شرم الشيخ الدولي",
            "كفر الشيخ" => "مستشفى كفر الشيخ العام",
            "مطروح" => "مستشفى مطروح العام",
            "الأقصر" => "مستشفى الأقصر العام",
            "قنا" => "مستشفى قنا الجامعي",
            "شمال سيناء" => "مستشفى العريش العام",
            "سوهاج" => "مستشفى سوهاج التعليمي"
        ];

        $nearest_center = $centers[$location] ?? "يرجى مراجعة وزارة الصحة لأقرب نقطة";

        echo "<div class='recommendation'>";
        echo "<h3>📌 توصياتك:</h3>";
        echo "<ul>";
        echo "<li>🕒 أقرب موعد مناسب للتبرع: بعد 3 شهور من آخر تبرع لك.</li>";
        echo "<li>🌅 أفضل وقت للتبرع: الصباح الباكر (9 ص - 11 ص).</li>";
        echo "<li>💉 نوع التبرع الموصى به: دم كامل.</li>";
        echo "<li>📍 أقرب نقطة تبرع في <strong>$location</strong>: <strong>$nearest_center</strong></li>";
        echo "</ul>";
        echo "</div>";
    }
    ?>

    <a href="home.php" class="main-back">🔙 الرجوع إلى القائمة الرئيسية</a>
</div>

<footer>
    <div class="marquee">
        🚨 تبرعك ينقذ حياة! كن جزءاً من الأمل – سجل تبرعك الآن 💉 | 📢 تابع أحدث حملات التبرع في منطقتك على صفحة الموقع الرئيسية 🌍
    </div>
</footer>

</body>
</html>

