<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('يرجى تسجيل الدخول أولاً.'); window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// جلب اسم المستخدم المسجل
$user_query = $conn->query("SELECT name FROM users WHERE id = '$user_id'");
$user_data = $user_query->fetch_assoc();
$full_name = $user_data['name'] ?? '';

// إضافة موعد جديد
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book'])) {
    $blood_type = $_POST['blood_type'];
    $donation_date = $_POST['donation_date'];
    $governorate = $_POST['governorate'];
    $name = $_POST['name'];
    $location_name = $_POST['location_name'];

    $stmt = $conn->prepare("INSERT INTO donations (user_id, name, blood_type, donation_date, governorate, location_name, status) VALUES (?, ?, ?, ?, ?, ?, 'Scheduled')");
    $stmt->bind_param("isssss", $user_id, $name, $blood_type, $donation_date, $governorate, $location_name);

    if ($stmt->execute()) {
        echo "<script>alert('تم حجز الموعد بنجاح!'); window.location.href='schedule.php';</script>";
        exit;
    } else {
        echo "<script>alert('حدث خطأ أثناء الحجز: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// حذف موعد
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $conn->query("DELETE FROM donations WHERE id='$delete_id' AND user_id='$user_id'");
    echo "<script>alert('تم حذف الموعد.'); window.location.href='schedule.php';</script>";
}

// الفلترة
$filter_query = "SELECT * FROM donations WHERE user_id = '$user_id'";
if (isset($_GET['filter_type']) && $_GET['filter_type'] != '') {
    $blood = $_GET['filter_type'];
    $filter_query .= " AND blood_type = '$blood'";
}
if (isset($_GET['filter_date']) && $_GET['filter_date'] != '') {
    $date = $_GET['filter_date'];
    $filter_query .= " AND donation_date = '$date'";
}

$result = $conn->query($filter_query);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>حجز المواعيد</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');
        body {
            font-family: 'Cairo', sans-serif;
            background: #2f2f2f;
            direction: rtl;
            padding: 30px;
            color: #fff;
        }
        .container {
            max-width: 1000px;
            background: white;
            margin: auto;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
            color: #000;
        }
        h2 {
            color: #0077b6;
            text-align: center;
            margin-bottom: 20px;
        }
        input, select, button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        button {
            background-color: #0077b6;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #023e8a;
        }
        .back-btn {
            background-color:rgb(81, 76, 175);
            margin-bottom: 15px;
        }
        .back-btn:hover {
            background-color:rgb(98, 56, 142);
        }
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            text-align: center;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background: #0077b6;
            color: white;
            padding: 12px;
        }
        td {
            padding: 10px;
        }
        .filter-box {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .filter-box input, .filter-box select {
            flex: 1;
        }
        .delete-btn {
            background-color: #e74c3c;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        footer {
            margin-top: 40px;
            padding: 20px;
            text-align: center;
            background: #023e8a;
            color: white;
            border-radius: 15px;
            font-size: 18px;
            position: relative;
        }
        .moving-text {
            display: inline-block;
            white-space: nowrap;
            animation: moveText 15s linear infinite;
            font-weight: bold;
        }
        @keyframes moveText {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .blood-animation {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: linear-gradient(to top, #ff4d4d, transparent);
            animation: wave 3s infinite ease-in-out;
            border-top-left-radius: 50% 20%;
            border-top-right-radius: 50% 20%;
            z-index: -1;
        }
        @keyframes wave {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body>
<div class="container">
    <a href="home.php"><button class="back-btn">⬅ الرجوع للصفحة الرئيسية</button></a>

    <h2>نموذج حجز موعد للتبرع</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="الاسم الكامل" value="<?= htmlspecialchars($full_name) ?>" required readonly>
        <input type="text" name="blood_type" placeholder="فصيلة الدم (مثال: A+)" required>
        <input type="date" name="donation_date" required>
        
        <select name="governorate" id="governorate" onchange="updateLocations()" required>
            <option value="">اختر المحافظة</option>
            <option value="القاهرة">القاهرة</option>
            <option value="الجيزة">الجيزة</option>
            <option value="الإسكندرية">الإسكندرية</option>
            <option value="المنصورة">المنصورة</option>
            <option value="أسيوط">أسيوط</option>
            <option value="المنيا">المنيا</option>
            <option value="سوهاج">سوهاج</option>
            <option value="قنا">قنا</option>
            <option value="الأقصر">الأقصر</option>
            <option value="أسوان">أسوان</option>
        </select>

        <select name="location_name" id="location_name" required>
            <option value="">اختر مكان التبرع</option>
        </select>

        <button type="submit" name="book">تأكيد الحجز</button>
    </form>

    <h2>مواعيدي المحجوزة</h2>

    <form method="GET" class="filter-box">
        <select name="filter_type">
            <option value="">- فصيلة الدم -</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
        </select>
        <input type="date" name="filter_date">
        <button type="submit">فلترة</button>
    </form>

    <table>
        <tr>
            <th>الاسم</th>
            <th>فصيلة الدم</th>
            <th>التاريخ</th>
            <th>المحافظة</th>
            <th>الموقع</th>
            <th>الحالة</th>
            <th>إجراء</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['blood_type']) ?></td>
                    <td><?= htmlspecialchars($row['donation_date']) ?></td>
                    <td><?= htmlspecialchars($row['governorate']) ?></td>
                    <td><?= htmlspecialchars($row['location_name']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
                        <a href="schedule.php?delete=<?= $row['id'] ?>" onclick="return confirm('هل أنت متأكد من الحذف؟');">
                            <button class="delete-btn">حذف</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">لا يوجد مواعيد حالياً.</td></tr>
        <?php endif; ?>
    </table>
</div>

<footer>
    <div class="moving-text">💉 تبرعك بالدم ينقذ حياة... كن جزءاً من الأمل! 💖 شارك في الحملة الآن! 💪</div>
</footer>

<div class="blood-animation"></div>
<script>
    const locationsByGovernorate = {
        "القاهرة": ["مستشفى القصر العيني", "بنك الدم المركزي", "مستشفى الهلال"],
        "الجيزة": ["مستشفى أم المصريين", "مستشفى الجيزة العام"],
        "الإسكندرية": ["مستشفى العامرية", "مستشفى رأس التين"],
        "المنصورة": ["مستشفى المنصورة الجامعي", "بنك الدم بالمنصورة"],
        "أسيوط": ["مستشفى أسيوط الجامعي", "مركز التبرع بأسيوط"],
        "المنيا": ["مستشفى المنيا العام", "بنك الدم بالمنيا"],
        "سوهاج": ["مستشفى سوهاج التعليمي", "مركز سوهاج للتبرع"],
        "قنا": ["مستشفى قنا العام", "بنك الدم بقنا"],
        "الأقصر": ["مستشفى الأقصر الدولي", "مركز تبرع الأقصر"],
        "أسوان": ["مستشفى أسوان الجامعي", "بنك الدم بأسوان"]
    };

    function updateLocations() {
        const governorate = document.getElementById("governorate").value;
        const locationSelect = document.getElementById("location_name");
        locationSelect.innerHTML = '<option value="">اختر مكان التبرع</option>';
        if (locationsByGovernorate[governorate]) {
            locationsByGovernorate[governorate].forEach(function(location) {
                const option = document.createElement("option");
                option.value = location;
                option.text = location;
                locationSelect.appendChild(option);
            });
        }
    }
</script>
</body>
</html>





