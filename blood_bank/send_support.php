<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php'; // ملف الاتصال بقاعدة البيانات

// تأكد من أن كل الحقول موجودة
if (isset($_POST['name'], $_POST['address'], $_POST['subject'], $_POST['message'])) {
    $user_id = $_SESSION['user_id'];
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $sql = "INSERT INTO support_messages (user_id, name, email, subject, message)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issss", $user_id, $name, $email, $subject, $message);

        if ($stmt->execute()) {
            echo "<script>alert('تم إرسال الرسالة بنجاح ✅'); window.location.href='support.php';</script>";
        } else {
            echo "<script>alert('حدث خطأ أثناء إرسال الرسالة ❌'); window.location.href='support.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('فشل تحضير الاستعلام. تحقق من الجدول أو الاتصال.'); window.location.href='support.php';</script>";
    }
} else {
    echo "<script>alert('يرجى تعبئة كل الحقول.'); window.location.href='support.php';</script>";
}

$conn->close();
?>
