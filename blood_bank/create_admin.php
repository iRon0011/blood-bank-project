<?php
include 'db.php'; // تأكد إن ملف الاتصال بقاعدة البيانات موجود

$admin_email = 'admin@bloodbank.com';
$admin_password = 'admin123'; // تقدر تغيّرها
$admin_name = 'Admin';
$blood_type = 'O+';
$phone = '0000000000';
$role = 'admin';

// تحقق إذا كان المشرف موجود
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $admin_email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "✅ Admin already exists.";
} else {
    $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, blood_type, phone, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $admin_name, $admin_email, $hashed_password, $blood_type, $phone, $role);

    if ($stmt->execute()) {
        echo "✅ Admin created successfully. Email: $admin_email | Password: $admin_password";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}
$check->close();
$conn->close();
?>

