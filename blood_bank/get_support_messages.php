<?php
$conn = new mysqli("localhost", "root", "", "blood_bank");
if ($conn->connect_error) {
  die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM support_messages ORDER BY created_at DESC");

while ($row = $result->fetch_assoc()) {
  $user_name = $row['user_name'] ?? 'غير معروف';
  $email = $row['email'] ?? 'غير متوفر';
  $message = $row['message'] ?? 'لا توجد رسالة';
  $response = $row['response'] ?? '';

  echo "<div style='background: #111; padding: 15px; margin: 10px 0; border-radius: 10px;'>
    <strong>الاسم:</strong> $user_name<br>
    <strong>البريد:</strong> $email<br>
    <strong>الرسالة:</strong> $message<br>
    <strong>الرد:</strong> " . ($response ? $response : "<textarea id='reply_{$row['id']}' placeholder='اكتب الرد هنا' style='width:100%; margin-top:5px;'></textarea>
    <button onclick='sendReply({$row['id']})' style='margin-top:5px;'>إرسال الرد</button>") . "
  </div>";
}
?>
