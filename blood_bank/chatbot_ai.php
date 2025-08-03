
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>روبوت الدردشة الذكي - بنك الدم</title>
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: #f1f1f1;
      margin: 0;
      padding: 0;
    }
    .chat-container {
      width: 90%;
      max-width: 600px;
      margin: 50px auto;
      background: white;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      overflow: hidden;
    }
    .chat-header {
      background: #dc3545;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 1.4rem;
    }
    .chat-messages {
      height: 400px;
      overflow-y: auto;
      padding: 15px;
      background:rgb(72, 47, 47);
    }
    .chat-input {
      display: flex;
      padding: 10px;
      border-top: 1px solid #ddd;
    }
    .chat-input input {
      flex: 1;
      padding: 10px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 10px;
    }
    .chat-input button {
      background: #dc3545;
      color: white;
      border: none;
      padding: 10px 15px;
      margin-left: 10px;
      border-radius: 10px;
      cursor: pointer;
    }
    .voice-btn {
      background: #007bff;
      color: white;
      border: none;
      padding: 10px 15px;
      margin-left: 10px;
      border-radius: 10px;
      cursor: pointer;
    }
    .home-btn {
      text-align: center;
      margin: 20px auto;
    }
    .home-btn a {
      background:rgb(48, 41, 45);
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 10px;
    }
    body {
    font-family: 'Cairo', sans-serif;
    background: #2f2f2f; /* رمادي داكن */
    direction: rtl;
    padding: 30px;
    color: #fff;
}
  </style>
</head>
<body>
  <div class="chat-container">
    <div class="chat-header">🤖 روبوت بنك الدم الذكي</div>
    <div class="chat-messages" id="chat"></div>
    <div class="chat-input">
      <input type="text" id="userInput" placeholder="اكتب رسالتك هنا...">
      <button onclick="sendMessage()">إرسال</button>
      <button class="voice-btn" onclick="startListening()">🎤</button>
    </div>
  </div>

  <div class="home-btn">
    <a href="home.php">🔙 الرجوع للصفحة الرئيسية</a>
  </div>

  <script>
    const chat = document.getElementById("chat");
    const userInput = document.getElementById("userInput");

    function addMessage(text, sender = "bot") {
      const div = document.createElement("div");
      div.style.margin = "10px 0";
      div.innerHTML = `<b>${sender === "bot" ? "🤖" : "👤"}:</b> ${text}`;
      chat.appendChild(div);
      chat.scrollTop = chat.scrollHeight;
      if (sender === "bot") speak(text);
    }

    function sendMessage() {
      const msg = userInput.value;
      if (!msg.trim()) return;
      addMessage(msg, "user");
      userInput.value = "";
      setTimeout(() => reply(msg), 800);
    }

    function reply(message) {
      message = message.toLowerCase();
      if (message.includes("نقاط")) {
        addMessage("عدد نقاطك حاليًا هو: 150 نقطة . يمكنك استبدالهم بهدية من صفحة التبرع الآن.");
      } else if (message.includes("اقرب")) {
        addMessage("أقرب نقطة تبرع لك هي: مستشفى الهلال الأحمر - وسط البلد ");
      } else if (message.includes("اخر تبرع")) {
        addMessage("آخر تبرع لك كان يوم 1 إبريل 2025 ");
      } else if (message.includes("دكتور فادي")) {
        addMessage("  مَرحَباً دكتور فادي والسادة المشرفين أنا بوت بنك الدم الذكي وجاهز للرد عليَ أسئلتكم وأنا بوت خاص بمشروع بنك الدم صممني المهندس أحمد فؤاد للرد عليكم" );
      } else {
        addMessage("أنا هنا لمساعدتك في كل ما يخص التبرع بالدم. اسألني عن نقاطك، أقرب مكان، أو آخر تبرع.");
      }
    }

    // Text-to-speech
    function speak(text) {
      const msg = new SpeechSynthesisUtterance(text);
      msg.lang = 'ar-SA';
      window.speechSynthesis.speak(msg);
    }

    function startListening() {
      const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
      recognition.lang = 'ar-SA';
      recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        userInput.value = transcript;
        sendMessage();
      }
      recognition.start();
    }
  </script>
  <canvas id="bloodCanvas" style="position:fixed; top:0; left:0; z-index:-1;"></canvas>
<script>
    const canvas = document.getElementById("bloodCanvas");
    const ctx = canvas.getContext("2d");
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    let drops = [];

    function createDrop() {
        return {
            x: Math.random() * canvas.width,
            y: 0,
            r: Math.random() * 5 + 2,
            speed: Math.random() * 3 + 2
        };
    }

    for (let i = 0; i < 60; i++) drops.push(createDrop());

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let drop of drops) {
            ctx.beginPath();
            ctx.fillStyle = "#b71c1c";
            ctx.arc(drop.x, drop.y, drop.r, 0, Math.PI * 2);
            ctx.fill();
            drop.y += drop.speed;

            if (drop.y > canvas.height) {
                drop.y = 0;
                drop.x = Math.random() * canvas.width;
            }
        }
        requestAnimationFrame(animate);
    }

    animate();
    window.addEventListener("resize", () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });
</script>

</body>
</html>
