<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$database = "blood_bank";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// حذف المستخدم
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // أولاً حذف التبرعات المرتبطة بهذا المستخدم عشان مشاكل الـ Foreign Key
    $deleteDonations = "DELETE FROM donations WHERE user_id = ?";
    $stmtDonations = $conn->prepare($deleteDonations);
    $stmtDonations->bind_param("i", $id);
    $stmtDonations->execute();

    // بعدين حذف المستخدم
    $deleteUser = "DELETE FROM users WHERE id = ?";
    $stmtUser = $conn->prepare($deleteUser);
    $stmtUser->bind_param("i", $id);

    if ($stmtUser->execute()) {
        header("Location: users.php");
        exit();
    } else {
        echo "خطأ أثناء حذف المستخدم: " . $conn->error;
    }
} else {
    echo "معرف المستخدم غير محدد.";
}
?>
