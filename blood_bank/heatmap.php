<!DOCTYPE html>
<html>
<head>
  <title>خريطة التبرعات الحرارية</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    #map { height: 100vh; }
  </style>
</head>
<body>
  <div id="map"></div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>
  <script>
    // إنشاء الخريطة
    var map = L.map('map').setView([26.8206, 30.8025], 6); // مصر

    // طبقة الخريطة
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
      maxZoom: 18,
    }).addTo(map);

    // نقاط تجريبية (خط العرض، خط الطول، الكثافة)
    var heatPoints = [
      [30.0444, 31.2357, 0.8],  // القاهرة
      [31.2001, 29.9187, 0.6],  // الإسكندرية
      [30.7890, 30.9995, 0.4],  // طنطا
      [27.1801, 31.1837, 0.7],  // أسيوط
      [24.0889, 32.8998, 0.3]   // أسوان
    ];

    // إضافة الخريطة الحرارية
    var heat = L.heatLayer(heatPoints, {radius: 25}).addTo(map);
  </script>
</body>
</html>
