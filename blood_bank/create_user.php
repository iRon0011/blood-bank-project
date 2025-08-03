<?php
include 'db.php';

// بيانات المستخدم الجديد
$name = "Test User";
$email = "test@example.com";
$password = "123456"; // كلمة السر الأصلية
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$blood_type = "A+";
$phone = "0123456789";
$role = "user";

// إدخال البيانات
$stmt = $conn->prepare("INSERT INTO users (name, email, password, blood_type, phone, role) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $email, $hashed_password, $blood_type, $phone, $role);

if ($stmt->execute()) {
    echo "✅ تم إنشاء المستخدم بنجاح.<br>";
    echo "🔑 يمكنك تسجيل الدخول بـ:<br>Email: $email<br>Password: $password";
} else {
    echo "❌ فشل في إنشاء المستخدم: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
