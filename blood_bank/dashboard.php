<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>لوحة تحكم الأدمن</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(to left, #770000, #000);
      color: white;
      overflow-x: hidden;
      position: relative;
    }

    /* القائمة العلوية */
    .topnav {
      background-color: rgba(0,0,0,0.7);
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(255,0,0,0.5);
      animation: slideIn 1s ease-in-out;
    }

    .topnav a {
      float: right;
      display: block;
      color: white;
      text-align: center;
      padding: 20px 25px;
      text-decoration: none;
      font-size: 18px;
      transition: background 0.3s;
    }

    .topnav a:hover {
      background-color: rgba(255,0,0,0.5);
    }

    .topnav a.active {
      background-color: crimson;
    }

    header {
      background-color: rgba(0,0,0,0.7);
      padding: 20px;
      text-align: center;
      font-size: 28px;
      font-weight: bold;
      box-shadow: 0 2px 10px rgba(255,0,0,0.5);
    }

    .dashboard {
      display: none; /* سيتم عرضها عند اختيار القسم */
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      padding: 40px;
      animation: fadeIn 1s ease;
    }

    .card {
      background-color: rgba(255,255,255,0.08);
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 0 15px rgba(255,0,0,0.4);
      backdrop-filter: blur(8px);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 0 25px rgba(255,0,0,0.8);
    }

    .card h3 {
      font-size: 22px;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 18px;
      color: #ffdede;
    }

    footer {
      text-align: center;
      padding: 15px;
      background: rgba(0,0,0,0.3);
      font-size: 14px;
      margin-top: 40px;
    }

    .logout-btn {
      position: fixed;
      top: 20px;
      left: 20px;
      padding: 10px 20px;
      background: #cc0000;
      color: white;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s;
    }

    .logout-btn:hover {
      background: #990000;
    }

    /* جداول البيانات */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      background: rgba(255,255,255,0.08);
      border-radius: 15px;
      overflow: hidden;
      margin: 20px 0;
    }

    .data-table th {
      background: crimson;
      padding: 15px;
      text-align: center;
    }

    .data-table td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid crimson;
    }

    .action-btn {
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin: 0 5px;
    }

    .edit-btn {
      background: #ffcc00;
    }

    .delete-btn {
      background: #e60000;
      color: white;
    }

    /* تأثيرات الحركة */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateY(-30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* تأثير نزول دم */
    .drop {
      position: fixed;
      top: -50px;
      width: 10px;
      height: 30px;
      background: red;
      border-radius: 50%;
      opacity: 0.5;
      animation: fall linear infinite;
    }

    @keyframes fall {
      to {
        transform: translateY(110vh);
        opacity: 0;
      }
    }

    /* التوعيات المتحركة */
    .awareness-container {
      grid-column: 1/-1;
      background: rgba(211, 47, 47, 0.2);
      padding: 20px;
      border-radius: 15px;
      margin-bottom: 20px;
    }

    .awareness-marquee {
      white-space: nowrap;
      overflow: hidden;
      box-sizing: border-box;
      font-size: 18px;
      font-weight: bold;
    }

    .awareness-marquee span {
      display: inline-block;
      padding-left: 100%;
      animation: scrollText 25s linear infinite;
    }

    @keyframes scrollText {
      from { transform: translateX(0); }
      to { transform: translateX(-100%); }
    }

    /* الرسوم البيانية */
    .chart-container {
      height: 300px;
      margin-top: 20px;
    }

    /* إحصائيات التبرعات */
    .donation-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
      margin-top: 20px;
    }

    .stat-item {
      background: rgba(255,255,255,0.1);
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      border-top: 4px solid crimson;
    }

    .stat-value {
      font-size: 28px;
      font-weight: bold;
      margin: 10px 0;
      color: #ff6b6b;
    }

    .stat-label {
      font-size: 16px;
      color: #ffdede;
    }
  </style>
</head>
<body>

  <div class="topnav">
    <a href="#" class="active" onclick="showSection('dashboard')">الرئيسية</a>
    <a href="#" onclick="showSection('users')">المستخدمين</a>
    <a href="#" onclick="showSection('hospitals')">المستشفيات</a>
    <a href="#" onclick="showSection('support')">الدعم الفني</a>
    <a href="#" onclick="showSection('blood')">مخزون الدم</a>
    <a class="back" href="request.php">طلبات المستشفيات </a>


  </div>
  
  <button class="logout-btn" onclick="window.location.href='admin_login.php'">
    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
  </button>

  <!-- قسم الرئيسية -->
  <div id="dashboard" class="dashboard" style="display: block;">
    <div class="awareness-container">
      <div class="awareness-marquee">
        <span>
          <i class="fas fa-heartbeat"></i> التبرع بالدم ينقذ الأرواح - 
          كل تبرع يمكن أن ينقذ 3 أرواح - 
          يمكنك التبرع بالدم كل شهرين إلى ثلاثة أشهر - 
          فحص طبي مجاني قبل كل تبرع بالدم - 
          الرجال يمكنهم التبرع حتى 6 مرات في السنة والنساء 4 مرات
        </span>
      </div>
    </div>

    <div class="card">
      <h3><i class="fas fa-users"></i> المستخدمين المسجلين</h3>
      <p>1,248 مستخدم</p>
    </div>
    <div class="card">
      <h3><i class="fas fa-tint"></i> التبرعات اليوم</h3>
      <p>85 تبرع</p>
    </div>
    <div class="card">
      <h3><i class="fas fa-envelope"></i> الرسائل الواردة</h3>
      <p>17 رسالة</p>
    </div>
    <div class="card">
      <h3><i class="fas fa-calendar-check"></i> طلبات الحجز</h3>
      <p>34 طلب</p>
    </div>

    <div style="grid-column: 1/-1; margin-top: 30px;">
      <h3><i class="fas fa-chart-pie"></i> إحصائيات التبرعات</h3>
      <div class="donation-stats">
        <div class="stat-item">
          <div class="stat-value">1,248</div>
          <div class="stat-label">إجمالي التبرعات</div>
        </div>
        <div class="stat-item">
          <div class="stat-value">586</div>
          <div class="stat-label">متبرعون نشطون</div>
        </div>
        <div class="stat-item">
          <div class="stat-value">3,744</div>
          <div class="stat-label">حياة تم إنقاذها</div>
        </div>
        <div class="stat-item">
          <div class="stat-value">O-</div>
          <div class="stat-label">أكثر فصيلة مطلوبة</div>
        </div>
      </div>
    </div>

    <div style="grid-column: 1/-1; margin-top: 30px;">
      <h3><i class="fas fa-chart-line"></i> توزيع التبرعات حسب الفصائل</h3>
      <div class="chart-container">
        <canvas id="bloodTypeChart"></canvas>
      </div>
    </div>
  </div>

  <!-- باقي الأقسام (كما هي بدون تغيير) -->
  <div id="users" class="dashboard">
    <h2 style="text-align:center; grid-column: 1/-1;">المستخدمين المسجلين</h2>
    <table class="data-table" style="grid-column: 1/-1;">
      <thead>
        <tr>
          <th>الاسم</th>
          <th>الإيميل</th>
          <th>الهاتف</th>
          <th>فصيلة الدم</th>
          <th>إجراءات</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $conn = new mysqli("localhost", "root", "", "blood_bank");
        $result = $conn->query("SELECT * FROM users");
        while($user = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($user['name']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['phone']); ?></td>
            <td><?php echo htmlspecialchars($user['blood_type']); ?></td>
            <td>
              <button class="action-btn edit-btn" onclick="editUser(<?php echo $user['id']; ?>)">
                <i class="fas fa-edit"></i> تعديل
              </button>
              <button class="action-btn delete-btn" onclick="deleteUser(<?php echo $user['id']; ?>)">
                <i class="fas fa-trash"></i> حذف
              </button>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- قسم المستشفيات -->
  <div id="hospitals" class="dashboard">
    <div class="card" style="grid-column: 1/-1;">
      <h3><i class="fas fa-hospital"></i> مستشفيات تطلب دم</h3>
      <table class="data-table">
        <thead>
          <tr>
            <th>اسم المستشفى</th>
            <th>فصيلة الدم المطلوبة</th>
            <th>الكمية</th>
            <th>إجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>مستشفى عين شمس</td>
            <td>A+</td>
            <td>5 أكياس</td>
            <td>
              <button class="action-btn" onclick="contactHospital('مستشفى عين شمس')">
                <i class="fas fa-phone"></i> تواصل
              </button>
            </td>
          </tr>
          <tr>
            <td>مستشفى القصر العيني</td>
            <td>O-</td>
            <td>3 أكياس</td>
            <td>
              <button class="action-btn" onclick="contactHospital('مستشفى القصر العيني')">
                <i class="fas fa-phone"></i> تواصل
              </button>
            </td>
          </tr>
          <tr>
            <td>مستشفى الزقازيق العام</td>
            <td>B-</td>
            <td>2 كيس</td>
            <td>
              <button class="action-btn" onclick="contactHospital('مستشفى الزقازيق العام')">
                <i class="fas fa-phone"></i> تواصل
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- قسم الدعم الفني -->
  <div id="support" class="dashboard">
    <div class="card" style="grid-column: 1/-1;">
      <h3><i class="fas fa-headset"></i> رسائل الدعم الفني</h3>
      <div id="supportMessages">
        <!-- سيتم ملؤها بالجافاسكريبت -->
      </div>
    </div>
  </div>

  <!-- قسم مخزون الدم -->
  <div id="blood" class="dashboard">
    <div class="card" style="grid-column: 1/-1;">
      <h3><i class="fas fa-tint"></i> مخزون الدم الحالي</h3>
      <table class="data-table">
        <thead>
          <tr>
            <th>فصيلة الدم</th>
            <th>الكمية المتاحة</th>
            <th>آخر تحديث</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>A+</td><td>12 كيس</td><td>اليوم</td></tr>
          <tr><td>B+</td><td>8 أكياس</td><td>اليوم</td></tr>
          <tr><td>O+</td><td>20 كيس</td><td>اليوم</td></tr>
          <tr><td>AB+</td><td>5 أكياس</td><td>اليوم</td></tr>
          <tr><td>A-</td><td>3 أكياس</td><td>أمس</td></tr>
          <tr><td>B-</td><td>2 كيس</td><td>أمس</td></tr>
          <tr><td>O-</td><td>6 أكياس</td><td>اليوم</td></tr>
          <tr><td>AB-</td><td>1 كيس</td><td>منذ 3 أيام</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <footer>
    <i class="fas fa-heartbeat"></i> جميع الحقوق محفوظة © بنك الدم الإلكتروني 2025
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // تبديل الأقسام
    function showSection(sectionId) {
      document.querySelectorAll('.dashboard').forEach(section => {
        section.style.display = 'none';
      });
      document.getElementById(sectionId).style.display = 'grid';
      
      document.querySelectorAll('.topnav a').forEach(link => {
        link.classList.remove('active');
      });
      event.currentTarget.classList.add('active');
    }

    // جلب رسائل الدعم
    function fetchSupportMessages() {
      fetch('get_support_messages.php')
        .then(response => response.text())
        .then(data => {
          document.getElementById('supportMessages').innerHTML = data;
        });
    }

    // إرسال رد الدعم
    function sendReply(id) {
      const response = document.getElementById('reply_' + id).value;
      fetch('reply_support.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&response=${encodeURIComponent(response)}`
      })
      .then(() => fetchSupportMessages());
    }

    // إدارة المستخدمين
    function editUser(id) {
      window.location.href = 'edit_user.php?id=' + id;
    }

    function deleteUser(id) {
      if(confirm('هل أنت متأكد أنك تريد حذف هذا المستخدم؟')) {
        window.location.href = 'delete_user.php?id=' + id;
      }
    }

    // التواصل مع المستشفيات
    function contactHospital(hospitalName) {
      const message = `مرحبًا، نحن على استعداد لتوفير فصائل الدم المطلوبة. الرجاء التواصل معنا بخصوص: ${hospitalName}`;
      const mailto = `mailto:hospital@example.com?subject=طلب دم عاجل - ${hospitalName}&body=${encodeURIComponent(message)}`;
      window.location.href = mailto;
    }

    // إنشاء رسم بياني لفصائل الدم
    function createBloodTypeChart() {
      const ctx = document.getElementById('bloodTypeChart').getContext('2d');
      const chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['A+', 'B+', 'O+', 'AB+', 'A-', 'B-', 'O-', 'AB-'],
          datasets: [{
            label: 'عدد التبرعات حسب الفصيلة',
            data: [320, 180, 450, 90, 70, 50, 120, 30],
            backgroundColor: [
              'rgba(255, 99, 132, 0.7)',
              'rgba(54, 162, 235, 0.7)',
              'rgba(255, 206, 86, 0.7)',
              'rgba(75, 192, 192, 0.7)',
              'rgba(153, 102, 255, 0.7)',
              'rgba(255, 159, 64, 0.7)',
              'rgba(199, 199, 199, 0.7)',
              'rgba(83, 102, 255, 0.7)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)',
              'rgba(199, 199, 199, 1)',
              'rgba(83, 102, 255, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }

    // تحميل رسائل الدعم عند فتح الصفحة
    document.addEventListener('DOMContentLoaded', function() {
      fetchSupportMessages();
      createBloodTypeChart();
    });

    // تأثير نزول الدم
    setInterval(() => {
      const drop = document.createElement("div");
      drop.className = "drop";
      drop.style.left = Math.random() * window.innerWidth + "px";
      drop.style.animationDuration = (2 + Math.random() * 2) + "s";
      document.body.appendChild(drop);
      setTimeout(() => drop.remove(), 5000);
    }, 300);
  </script>
</body>
</html>
