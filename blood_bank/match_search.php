<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$blood_type = $_GET['blood_type'] ?? '';
$results = [];
$userLat = $_GET['lat'] ?? null;
$userLng = $_GET['lng'] ?? null;

if (!empty($blood_type) && $userLat && $userLng) {
    $stmt = $conn->prepare("SELECT full_name, phone, blood_type, latitude, longitude FROM users WHERE blood_type = ? AND latitude IS NOT NULL AND longitude IS NOT NULL");
    $stmt->bind_param("s", $blood_type);
    $stmt->execute();
    $results = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>مطابقة الفصائل</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #2c3e50;
            margin: 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .main-button {
            display: block;
            background-color: #e74c3c;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            border: none;
            border-radius: 10px;
            margin: 30px auto;
            cursor: pointer;
            width: 80%;
        }

        .container {
            padding: 40px;
        }

        h2, h3 {
            color: #f1c40f;
            text-align: center;
        }

        form {
            margin: 20px auto;
            text-align: center;
        }

        select, button {
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            margin: 10px;
            font-size: 16px;
        }

        table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
            background: #34495e;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #7f8c8d;
            text-align: center;
        }

        th {
            background-color: #e74c3c;
            color: white;
        }

        .no-result {
            text-align: center;
            margin-top: 30px;
            color: #ecf0f1;
            font-size: 18px;
        }

        .blood-drop {
            position: absolute;
            top: -20px;
            width: 20px;
            height: 20px;
            background: red;
            border-radius: 50%;
            animation: fall linear infinite;
        }

        @keyframes fall {
            0% { top: -20px; opacity: 1; }
            100% { top: 100vh; opacity: 0; }
        }
    </style>
</head>
<body>

<button class="main-button" onclick="location.href='home.php'">🔙 الرجوع إلى القائمة الرئيسية</button>

<script>
    function createBloodDrop() {
        const drop = document.createElement("div");
        drop.classList.add("blood-drop");
        drop.style.left = Math.random() * window.innerWidth + "px";
        drop.style.animationDuration = (2 + Math.random() * 3) + "s";
        document.body.appendChild(drop);
        setTimeout(() => drop.remove(), 5000);
    }

    setInterval(createBloodDrop, 200);
</script>

<div class="container">
    <h2>🔎 ابحث عن متبرعين حسب فصيلة الدم</h2>

    <form method="GET" onsubmit="return attachLocation(this);">
    <select name="blood_type" required>
        <option value="">اختر الفصيلة</option>
        <?php
        $blood_options = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        foreach ($blood_options as $type) {
            $selected = $blood_type == $type ? 'selected' : '';
            echo "<option value='$type' $selected>$type</option>";
        }
        ?>
    </select>
    <label style="color:white">
        <input type="checkbox" name="need_blood" <?= isset($_GET['need_blood']) ? 'checked' : '' ?>>
        أحتاج إلى دم
    </label>
    <input type="hidden" name="lat" id="lat">
    <input type="hidden" name="lng" id="lng">
    <button type="submit">بحث</button>
</form>

    <script>
        function attachLocation(form) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(pos => {
                    form.lat.value = pos.coords.latitude;
                    form.lng.value = pos.coords.longitude;
                    form.submit();
                }, err => {
                    alert("يرجى السماح بالوصول إلى الموقع.");
                });
                return false;
            } else {
                alert("المتصفح لا يدعم تحديد الموقع.");
                return false;
            }
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return (R * c).toFixed(2);
        }
    </script>

<?php
if (!empty($blood_type) && $userLat && $userLng && isset($_GET['need_blood'])):
    echo "<h3>🏥 أقرب المستشفيات التي تحتوي على فصيلة $blood_type</h3>";

    $stmt_h = $conn->prepare("SELECT name, phone, blood_type, latitude, longitude FROM hospitals WHERE blood_type = ?");
    $stmt_h->bind_param("s", $blood_type);
    $stmt_h->execute();
    $hospitals = $stmt_h->get_result();

    if ($hospitals->num_rows > 0):
?>
        <table>
            <tr>
                <th>اسم المستشفى</th>
                <th>رقم الهاتف</th>
                <th>فصيلة الدم</th>
                <th>المسافة (كم)</th>
            </tr>
            <?php
            while ($h = $hospitals->fetch_assoc()) {
                $dLat = deg2rad($h['latitude'] - $userLat);
                $dLon = deg2rad($h['longitude'] - $userLng);
                $a = sin($dLat/2) * sin($dLat/2) +
                     cos(deg2rad($userLat)) * cos(deg2rad($h['latitude'])) *
                     sin($dLon/2) * sin($dLon/2);
                $c = 2 * atan2(sqrt($a), sqrt(1-$a));
                $distance = 6371 * $c;

                echo "<tr>
                        <td>" . htmlspecialchars($h['name']) . "</td>
                        <td>" . htmlspecialchars($h['phone']) . "</td>
                        <td>" . htmlspecialchars($h['blood_type']) . "</td>
                        <td>" . number_format($distance, 2) . " كم</td>
                      </tr>";
            }
            ?>
        </table>
<?php
    else:
        echo "<div class='no-result'>لا توجد مستشفيات قريبة تحتوي على هذه الفصيلة</div>";
    endif;
endif;
?>

</div>


</body>
</html>

