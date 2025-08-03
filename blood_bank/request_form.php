<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طلب دم جديد - بنك الدم</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #D90429;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-family: 'Cairo', sans-serif;
        }

        button {
            background-color: #D90429;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        button:hover {
            background-color: #a00320;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #555;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>طلب دم جديد</h1>
        <form action="send_request.php" method="POST">
            <label for="hospital_name">اسم المستشفى:</label>
            <input type="text" name="hospital_name" id="hospital_name" required>

            <label for="contact_person">اسم المسؤول:</label>
            <input type="text" name="contact_person" id="contact_person" required>

            <label for="phone">رقم الهاتف:</label>
            <input type="text" name="phone" id="phone" required>

            <label for="blood_type">فصيلة الدم:</label>
            <select name="blood_type" id="blood_type" required>
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

            <label for="quantity">الكمية المطلوبة (بالوحدات):</label>
            <input type="number" name="quantity" id="quantity" min="1" required>

            <label for="notes">ملاحظات إضافية:</label>
            <textarea name="notes" id="notes" rows="4"></textarea>

            <button type="submit">إرسال الطلب</button>
        </form>

        <a href="dashboard.php" class="back-link">⬅ العودة للداشبورد</a>
    </div>
</body>
</html>
