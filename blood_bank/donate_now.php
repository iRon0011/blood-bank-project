<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// حساب عدد التبرعات العينية الخاصة بالمستخدم
$count_query = "SELECT COUNT(*) AS total FROM donations WHERE user_id='$user_id' AND donation_type='تبرع عيني'";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_donations = $count_data['total'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donation_type = 'تبرع عيني';
    $item_description = $_POST['item_description'];
    $payment_method = $_POST['payment_method'];
    $status = 'تم التبرع';
    $amount = 0;
    $points = 0;
    $image_name = null;

    // رفع الصورة
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $image_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    $sql = "INSERT INTO donations (user_id, donation_type, amount, item_description, payment_method, status, points, image, created_at)
            VALUES ('$user_id', '$donation_type', '$amount', '$item_description', '$payment_method', '$status', '$points', '$image_name', NOW())";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "تم تسجيل التبرع العيني بنجاح! شكرًا لك ❤️";
        header("Location: my_donations_log.php");
        exit();
    } else {
        echo "حدث خطأ أثناء الحفظ: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تبرع عيني</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
            background: #1e1e1e;
            color: white;
            margin: 0;
            overflow: hidden;
        }

        form {
            background: #2c2c2c;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(255,0,0,0.3);
            width: 400px;
            margin: 30px auto;
            position: relative;
            z-index: 1;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #555;
            background: #3a3a3a;
            color: white;
        }

        button {
            padding: 12px 20px;
            background: #c0392b;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        button:hover {
            background: #e74c3c;
        }

        h2, .count-box {
            text-align: center;
            margin-top: 30px;
            z-index: 2;
            position: relative;
        }

        .count-box {
            background: #444;
            margin: 0 auto 20px;
            padding: 10px;
            border-radius: 15px;
            width: fit-content;
        }

        .blood-drop {
            position: absolute;
            width: 10px;
            height: 10px;
            background: red;
            border-radius: 50%;
            animation: fall 5s linear infinite;
            opacity: 0.8;
        }

        @keyframes fall {
            0% {
                top: -10px;
                transform: translateX(0);
            }
            100% {
                top: 100%;
                transform: translateX(20px);
            }
        }
        header {
        background: #333;
        padding: 15px;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 10px rgba(0,0,0,0.4);
    }

    .back-button {
        background: #e74c3c;
        color: white;
        padding: 15px 30px;
        font-size: 18px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .back-button:hover {
        background: #ff5e57;
    }
    </style>
</head>
<body>
<header>
    <a href="home.php" class="back-button">🏠 الرجوع للرئيسية</a>
</header>


<h2>تبرع عيني الآن 🎁</h2>
<div class="count-box">عدد تبرعاتك العينية: <strong><?php echo $total_donations; ?></strong></div>

<form action="" method="POST" enctype="multipart/form-data">
    <label>وصف الشيء المتبرع به:</label>
    <textarea name="item_description" placeholder="مثال: كرتونة ملابس شتوية بحالة جيدة، أدوات طبية..." required></textarea>

    <label>طريقة التوصيل:</label>
    <select name="payment_method" required>
        <option value="توصيل مباشر">توصيل مباشر</option>
        <option value="عن طريق مندوب">عن طريق مندوب</option>
        <option value="أخرى">أخرى</option>
    </select>

    <label>صورة للشيء المتبرع به (اختياري):</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit">تبرع الآن</button>
</form>

<script>
    // إنشاء قطرات دم متحركة
    const numDrops = 50;
    for (let i = 0; i < numDrops; i++) {
        const drop = document.createElement('div');
        drop.className = 'blood-drop';
        drop.style.left = Math.random() * 100 + 'vw';
        drop.style.animationDuration = (Math.random() * 3 + 2) + 's';
        drop.style.animationDelay = Math.random() * 5 + 's';
        document.body.appendChild(drop);
    }
</script>

</body>
</html>



