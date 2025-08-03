<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
  die("فشل الاتصال: " . $conn->connect_error);
}

$sql = "SELECT * FROM donation_locations";
$result = $conn->query($sql);
$locations = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $locations[] = $row;
  }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>أماكن التبرع أو طلب الدم</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Cairo', sans-serif;
      background-color: #2c2c2c;
      color: white;
    }

    h2 {
      text-align: center;
      margin: 20px 0;
      color: #ff4d4d;
    }

    .btn-back {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 10px 20px;
      background: #444;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      z-index: 999;
    }

    .btn-back:hover {
      background: #666;
    }

    .selectors {
      display: flex;
      justify-content: center;
      gap: 40px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    label {
      font-size: 18px;
    }

    select {
      padding: 8px;
      border-radius: 8px;
      font-size: 16px;
    }

    #map {
      height: 80vh;
      width: 100%;
    }

    .blood-drop {
      position: fixed;
      width: 15px;
      height: 15px;
      background: red;
      border-radius: 50%;
      animation: fall 3s infinite;
      z-index: 9999;
    }

    @keyframes fall {
      0% { top: -20px; opacity: 1; }
      100% { top: 100%; opacity: 0; }
    }
  </style>
</head>
<body>

<h2>اختر محافظة للتبرع أو طلب الدم</h2>
<button class="btn-back" onclick="window.location.href='home.php'">الرجوع للرئيسية</button>

<div class="selectors">
  <div>
    <label for="donate-select">التبرع بالدم:</label><br>
    <select id="donate-select" onchange="showGovernorate(this.value, 'تبرع')">
      <option value="">-- اختر المحافظة --</option>
    </select>
  </div>

  <div>
    <label for="need-select">طلب دم:</label><br>
    <select id="need-select" onchange="showGovernorate(this.value, 'طلب')">
      <option value="">-- اختر المحافظة --</option>
    </select>
  </div>
</div>

<div id="map"></div>

<script>
  const locations = <?php echo json_encode($locations, JSON_UNESCAPED_UNICODE); ?>;
  const map = L.map('map').setView([30.0444, 31.2357], 6);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; خرائط مفتوحة المصدر'
  }).addTo(map);

  const donateSelect = document.getElementById("donate-select");
  const needSelect = document.getElementById("need-select");
  const uniqueGovernorates = [...new Set(locations.map(l => l.governorate))];

  uniqueGovernorates.forEach(gov => {
    const option1 = new Option(gov, gov);
    const option2 = new Option(gov, gov);
    donateSelect.add(option1);
    needSelect.add(option2);
  });

  function showGovernorate(governorate, type) {
    map.eachLayer((layer) => {
      if (layer instanceof L.Marker) map.removeLayer(layer);
    });

    locations.forEach(loc => {
      if (loc.governorate === governorate) {
        const marker = L.marker([loc.latitude, loc.longitude]).addTo(map);
        marker.bindPopup(`<b>${loc.name}</b><br>${loc.address}<br>${type === 'تبرع' ? 'مكان متاح للتبرع' : 'تم إرسال طلب الدم'}`).openPopup();
      }
    });

    const centerLoc = locations.find(loc => loc.governorate === governorate);
    if (centerLoc) map.setView([centerLoc.latitude, centerLoc.longitude], 10);
  }

  // نزول دم
  function createBloodDrop() {
    const drop = document.createElement('div');
    drop.classList.add('blood-drop');
    drop.style.left = Math.random() * window.innerWidth + 'px';
    document.body.appendChild(drop);
    setTimeout(() => drop.remove(), 3000);
  }
  setInterval(createBloodDrop, 300);
</script>

</body>
</html>








