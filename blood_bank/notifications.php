<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// استخراج التبرعات
$stmt = $conn->prepare("SELECT blood_type, donation_date, status FROM donations WHERE user_id = ? ORDER BY donation_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$new_notifications = [];

while ($row = $result->fetch_assoc()) {
    $donation_date = $row['donation_date'];
    $blood_type = $row['blood_type'];
    $status = $row['status'];

    switch ($status) {
        case 'Scheduled':
            $msg = "📅 تم جدولة موعد تبرع بتاريخ <strong>$donation_date</strong> لفصيلة الدم <strong>$blood_type</strong>.";
            break;
        case 'Completed':
            $msg = "✅ تم إتمام تبرعك بتاريخ <strong>$donation_date</strong> بنجاح. شكرًا لعطائك!";
            break;
        case 'Cancelled':
            $msg = "⚠️ تم إلغاء موعد التبرع الخاص بك بتاريخ <strong>$donation_date</strong>.";
            break;
        default:
            $msg = "ℹ️ تحديث جديد على تبرعك بتاريخ <strong>$donation_date</strong>.";
            break;
    }

    // تحقق من وجود الإشعار مسبقًا
    $check = $conn->prepare("SELECT id FROM notifications WHERE user_id = ? AND message = ?");
    $check->bind_param("is", $user_id, $msg);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        $insert = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
        $insert->bind_param("is", $user_id, $msg);
        $insert->execute();

        // اجمع الإشعار الجديد لعرضه بصوت
        $new_notifications[] = $msg;
    }
}

// جلب جميع الإشعارات
$notif_result = $conn->prepare("SELECT message FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$notif_result->bind_param("i", $user_id);
$notif_result->execute();
$notif_data = $notif_result->get_result();

$notifications = [];
while ($n = $notif_data->fetch_assoc()) {
    $notifications[] = $n['message'];
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الإشعارات - بنك الدم</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #2c2c2c;
            color: #fff;
            margin: 0;
            padding: 0;
            direction: rtl;
            overflow-x: hidden;
        }

        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            background-color: #444;
            color: #fff;
            padding: 15px 20px;
            margin-top: 10px;
            border-right: 5px solid #e74c3c;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.4);
            opacity: 0;
            transform: translateX(100%);
            animation: slideIn 0.5s forwards, fadeOut 0.5s ease-out 4.5s forwards;
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        .back-button {
            display: block;
            width: fit-content;
            margin: 30px auto;
            background-color: #e74c3c;
            color: #fff;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            text-decoration: none;
            transition: 0.3s;
        }

        .back-button:hover {
            background-color: #c0392b;
        }

        h2 {
            text-align: center;
            margin-top: 50px;
            color: #e74c3c;
        }

        .blood-drip {
            position: absolute;
            top: -50px;
            width: 10px;
            height: 50px;
            background-color: red;
            border-radius: 50%;
            animation: drop 3s infinite;
        }

        @keyframes drop {
            0% { top: -50px; opacity: 1; }
            80% { top: 100vh; opacity: 0.8; }
            100% { top: 100vh; opacity: 0; }
        }
    </style>
</head>
<body>

<h2>🔔 إشعاراتك</h2>

<div class="toast-container" id="toast-container"></div>

<a class="back-button" href="home.php">⬅ الرجوع إلى القائمة الرئيسية</a>

<!-- تأثير نزول الدم -->
<script>
    function createBloodDrop() {
        const drop = document.createElement('div');
        drop.className = 'blood-drip';
        drop.style.left = Math.random() * window.innerWidth + 'px';
        drop.style.width = Math.random() * 15 + 5 + 'px';
        drop.style.height = Math.random() * 30 + 20 + 'px';
        document.body.appendChild(drop);
        setTimeout(() => drop.remove(), 3000);
    }

    setInterval(createBloodDrop, 300);
</script>

<!-- تشغيل الإشعارات بالصوت -->
<script>
    const toastContainer = document.getElementById('toast-container');
    const audio = new Audio('sounds/notification.mp3');

    const newNotifications = <?php echo json_encode($new_notifications); ?>;
    const allNotifications = <?php echo json_encode($notifications); ?>;

    allNotifications.forEach((message, index) => {
        const toast = document.createElement('div');
        toast.classList.add('toast');
        toast.innerHTML = message;
        toastContainer.appendChild(toast);

        // شغل الصوت فقط للإشعارات الجديدة
        if (newNotifications.includes(message)) {
            setTimeout(() => {
                audio.play();
            }, 500 * index);
        }
    });
</script>

</body>
</html>











