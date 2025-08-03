<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "blood_bank");
$conn->set_charset("utf8mb4");

// عرض تفاصيل أخطاء MySQL
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// معالجة تحديث حالة الطلب
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
    $request_id = intval($_POST['request_id']);
    $action = $_POST['action'];

    $query = "";
    if ($action === 'approve') {
        $query = "UPDATE blood_requests SET status='approved' WHERE id=?";
    } elseif ($action === 'reject') {
        $query = "UPDATE blood_requests SET status='rejected' WHERE id=?";
    }

    if (!empty($query)) {
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $request_id);
            $stmt->execute();
            $stmt->close();
        } else {
            die("فشل في إعداد الاستعلام: " . $conn->error);
        }
    }
}

// جلب طلبات الدم
$requests = [];
$sql = "SELECT * FROM blood_requests ORDER BY request_date DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if (!isset($row['status']) || $row['status'] === '') {
            $row['status'] = 'pending';
        }
        $requests[] = $row;
    }
}

// جلب إحصائية مخزون الدم
$blood_stats = [];
$sql = "SELECT blood_type, SUM(quantity) as total FROM blood_inventory GROUP BY blood_type";
$result = $conn->query($sql);

if ($result) {
    while($row = $result->fetch_assoc()) {
        $blood_stats[$row['blood_type']] = $row['total'];
    }
} else {
    error_log("خطأ في استعلام المخزون: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>إدارة طلبات الدم</title>
    <!-- بعد عنوان الصفحة مباشرة -->
<h1>إدارة طلبات الدم</h1>

<!-- زر الرجوع -->
<div style="text-align: center; margin-bottom: 20px;">
    <a href="index.php" style="
        display: inline-block;
        padding: 10px 20px;
        background-color: #e74c3c;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        font-family: 'Cairo', sans-serif;
        transition: background-color 0.3s ease;
    " onmouseover="this.style.backgroundColor='#c0392b';" onmouseout="this.style.backgroundColor='#e74c3c';">
        الرجوع للرئيسية
    </a>
</div>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #2c3e50;
            color: white;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 30px;
        }
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
            justify-content: center;
        }
        .blood-stat {
            background-color: #34495e;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            min-width: 100px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .blood-stat .type {
            font-size: 18px;
            font-weight: bold;
            color: #e74c3c;
        }
        .blood-stat .amount {
            font-size: 24px;
            margin: 5px 0;
        }
        .requests-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #34495e;
            border-radius: 8px;
            overflow: hidden;
        }
        .requests-table th, .requests-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #3d566e;
        }
        .requests-table th {
            background-color: #2c3e50;
            color: #e74c3c;
        }
        .status-pending {
            color: #f39c12;
        }
        .status-approved {
            color: #2ecc71;
        }
        .status-rejected {
            color: #e74c3c;
        }
        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            margin: 0 5px;
        }
        .approve-btn {
            background-color: #2ecc71;
            color: white;
        }
        .reject-btn {
            background-color: #e74c3c;
            color: white;
        }
        .blood-drop {
            position: fixed;
            width: 5px;
            height: 10px;
            background-color: #e74c3c;
            border-radius: 50% 50% 0 0;
            pointer-events: none;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>إدارة طلبات الدم</h1>
        
        <!-- إحصائية مخزون الدم -->
        <h2>مخزون الدم المتاح</h2>
        <div class="stats-container">
            <?php 
            $blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            foreach ($blood_types as $type): 
                $amount = $blood_stats[$type] ?? 0;
                $isLow = $amount < 5;
            ?>
            <div class="blood-stat <?= $isLow ? 'low-stock' : '' ?>">
                <div class="type"><?= $type ?></div>
                <div class="amount"><?= $amount ?></div>
                <div class="unit">وحدة</div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- جدول طلبات الدم -->
        <h2>الطلبات المقدمة</h2>
        <table class="requests-table">
            <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>اسم المستشفى</th>
                    <th>مسئول الاتصال</th>
                    <th>الهاتف</th>
                    <th>فصيلة الدم</th>
                    <th>الكمية</th>
                    <th>تاريخ الطلب</th>
                    <th>الحالة</th>
                    <th>الملاحظات</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                <?php $status = $request['status'] ?? 'pending'; ?>
                <tr>
                    <td><?= $request['id'] ?></td>
                    <td><?= htmlspecialchars($request['hospital_name']) ?></td>
                    <td><?= htmlspecialchars($request['contact_person']) ?></td>
                    <td><?= htmlspecialchars($request['phone']) ?></td>
                    <td><?= $request['blood_type'] ?></td>
                    <td><?= $request['quantity'] ?></td>
                    <td><?= date('Y-m-d H:i', strtotime($request['request_date'])) ?></td>
                    <td class="status-<?= $status ?>">
                        <?php 
                        switch($status) {
                            case 'approved': echo 'مقبول'; break;
                            case 'rejected': echo 'مرفوض'; break;
                            default: echo 'قيد الانتظار';
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialchars($request['notes']) ?></td>
                    <td>
                        <?php if (!isset($request['status']) || $request['status'] === 'pending'): ?>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                            <button type="submit" name="action" value="approve" class="action-btn approve-btn">قبول</button>
                            <button type="submit" name="action" value="reject" class="action-btn reject-btn">رفض</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
    // تأثير نزول الدم
    function createBloodDrop() {
        const blood = document.createElement("div");
        blood.className = "blood-drop";
        blood.style.left = Math.random() * window.innerWidth + "px";
        blood.style.opacity = 0.7 + Math.random() * 0.3;
        blood.style.transform = `scale(${0.5 + Math.random()})`;
        document.body.appendChild(blood);
        
        let pos = -10;
        const speed = 3 + Math.random() * 5;
        const sway = Math.random() * 4 - 2;
        let currentLeft = parseFloat(blood.style.left);
        
        const fall = setInterval(() => {
            pos += speed;
            currentLeft += sway;
            blood.style.top = pos + "px";
            blood.style.left = currentLeft + "px";
            
            if (pos > window.innerHeight) {
                clearInterval(fall);
                blood.remove();
            }
        }, 20);
    }

    // نزول الدم بشكل متكرر
    setInterval(createBloodDrop, 300);

    // زيادة كمية الدم عند وجود طلبات قيد الانتظار
    const pendingRequests = document.querySelectorAll('.status-pending');
    if (pendingRequests.length > 0) {
        setInterval(createBloodDrop, 100);
    }
    </script>
</body>
</html>
