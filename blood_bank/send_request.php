<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // استلام البيانات من النموذج
    $hospital_name = $_POST['hospital_name'] ?? '';
    $contact_person = $_POST['contact_person'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $blood_type = $_POST['blood_type'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);
    $notes = $_POST['notes'] ?? '';

    // الاتصال بقاعدة البيانات
    $conn = new mysqli("localhost", "root", "", "blood_bank");
    $conn->set_charset("utf8mb4");

    if ($conn->connect_error) {
        die("فشل الاتصال: " . $conn->connect_error);
    }

    // إدخال البيانات
    $stmt = $conn->prepare("INSERT INTO blood_requests (hospital_name, contact_person, phone, blood_type, quantity, notes) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssis", $hospital_name, $contact_person, $phone, $blood_type, $quantity, $notes);
        if ($stmt->execute()) {
            echo "<p style='color:green; font-family:Cairo;'>✅ تم إرسال طلب الدم بنجاح.</p>";
            echo "<a href='hospitals.php' style='color:white; font-family:Cairo;'>⬅ العودة للصفحة السابقة</a>";
        } else {
            echo "<p style='color:red; font-family:Cairo;'>❌ فشل في إرسال الطلب: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color:red; font-family:Cairo;'>❌ خطأ في إعداد الاستعلام: " . $conn->error . "</p>";
    }

    $conn->close();
} else {
    header("Location: hospitals.php");
    exit();
}
?>
