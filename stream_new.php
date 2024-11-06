<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Stream - Ambis Belajar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
      :root {
        /* Font */
        --font-utama: "Poppins", serif;

        /* Warna Utama */
        --primary-color: #4e44ff;
        --secondary-color: #6c63ff;
        --accent-color: #ff6b6b;

        /* Tema Gelap */
        --dark-bg: #1a1a2e; /* Latar belakang utama gelap */
        --dark-secondary-bg: #25274d; /* Warna latar sekunder gelap */
        --dark-theme-bg: linear-gradient(
          135deg,
          var(--dark-bg) 0%,
          var(--dark-secondary-bg) 100%
        );
        --dark-text: #ffffff; /* Warna teks untuk tema gelap */

        /* Tema Terang */
        --light-bg: #f0f0f3; /* Latar belakang utama yang lembut dan netral */
        --light-secondary-bg: #e8eaf6; /* Warna sekunder untuk kartu atau elemen lain */
        --light-accent: #b8c1ec; /* Warna aksen ringan */
        --light-text: #4a4a4a; /* Warna teks utama */
        --light-border: #d1d1e0; /* Warna border lembut */
        --highlight-color: #009688; /* Warna aksen untuk tombol atau elemen interaktif */
        --light-theme-bg: linear-gradient(135deg, var(--light-accent) 0%, var(--light-secondary-bg) 100%);

        /* Tambahan */
        --correct-color: #48bb78;
        --timer-color: #48bb78;
        --incorrect-color: #ff6b6b;
      }

    body {
        background: var(--light-secondary-bg);
        font-family: var(--font-utama);
        color: var(--light-text);
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    body.dark-mode {
        background: var(--dark-secondary-bg);
        color: var(--dark-text);
    }

      /* Navbar */
      .navbar {
        background: var(--light-bg);
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        padding: 1rem 2rem;
      }

      .navbar-brand {
        color: var(--primary-color) !important;
        font-weight: 800;
        font-size: 1.6rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .navbar-toggler {
        border: none;
        color: var(--light-text);
      }

      .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%234a4a4a' viewBox='0 0 30 30'%3E%3Cpath d='M4 7h22v2H4V7zm0 7h22v2H4v-2zm0 7h22v2H4v-2z'/%3E%3C/svg%3E");
      }

      .nav-link {
        color: var(--light-text) !important;
        transition: color 0.3s ease;
        font-weight: 500;
        font-size: 16px;
      }

      .nav-link:hover,
      .nav-item.active .nav-link {
        color: var(--primary-color) !important;
      }

      .dark-mode .nav-link {
        color: var(--dark-text) !important;
      }

      .dark-mode .nav-link:hover,
      .dark-mode .nav-item.active .nav-link {
        color: var(--primary-color) !important;
      }

      .toggle-theme {
        cursor: pointer;
        font-size: 1.2rem;
      }

      .dark-mode .navbar {
        background: var(--dark-bg);
        color: var(--dark-text);
      }

        .main-container {
            padding: 2rem;
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 2rem;
            max-width: 1440px;
            margin: 0 auto;
        }

        .stream-section {
            background: var(--light-bg);
            border-radius: 20px;
            padding: 1.5rem;
            position: relative;
        }

        .dark-mode .stream-section {
            background: var(--dark-bg);
        }

        .video-container {
            width: 100%;
            padding-top: 56.25%;
            position: relative;
            background: #000;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .video-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background: var(--light-accent);
        }

        .dark-mode .video-placeholder {
            background: var(--dark-theme-bg);
        }

        .stream-controls {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .control-btn {
            background: var(--light-accent);
            border: none;
            color: var(--light-text);
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .control-btn:hover {
            color: var(--dark-text);
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        .control-btn.active {
            background: var(--primary-color);
        }

        .dark-mode .control-btn {
            background: rgba(255, 255, 255, 0.1);
            color: var(--dark-text);
        }

        .dark-mode .control-btn:hover {
            background: var(--primary-color);
        }

        .chat-container {
            background: var(--light-bg);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            height: calc(100vh - 100px);
            position: sticky;
            top: 1rem;
            color: var(--light-text);
        }

        .dark-mode .chat-container {
            background: var(--dark-bg);
            color: var(--dark-text);
        }

        .chat-header {
            padding: 1rem;
            border-bottom: 1px solid var(--light-text);
            font-weight: 600;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            background: var(--light-secondary-background);
        }

        .message {
            margin-bottom: 1rem;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message-author {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .message-content {
            padding: 0.75rem;
            border-radius: 10px;
            font-size: 0.9rem;
            background: var(--light-accent);
        }

        .dark-mode .message-content {
            background: rgba(255, 255, 255, 0.1);
        }

        .chat-input {
            padding: .75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .chat-input form {
            display: flex;
            gap: 0.5rem;
        }

        .chat-input input {
            flex: 1;
            background: white;
            border: none;
            padding: 0.50rem;
            border-radius: 10px;
            color: var(--light-text);
        }

        .dark-mode .chat-input input {
            background: rgba(255, 255, 255, 0.1);
            color: var(--dark-text);
        }

        .chat-input input:focus {
            outline: none;
        }

        .chat-input button {
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 0.65rem 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .chat-input button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 68, 255, 0.3);
        }

        .timer-container {
            text-align: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: var(--light-secondary-bg);
            border-radius: 15px;
        }

        .dark-mode .timer-container {
            background: var(--dark-secondary-bg);
        }

        .timer-display {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--timer-color);
            margin: 1rem 0;
            font-family: monospace;
        }

        .timer-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .stats-container {
            background: var(--light-secondary-bg);
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .dark-mode .stats-container{
            background: var(--dark-secondary-bg);
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .online-users {
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
        }

        .user-list {
            list-style: none;
            padding: 0;
            margin: 0.5rem 0 0 0;
        }

        .user-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .user-status {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--timer-color);
        }

        @media (max-width: 992px) {
            .main-container {
                grid-template-columns: 1fr;
            }

            .chat-container {
                height: 500px;
                position: static;
            }
        }

        .music-player {
            background: var(--light-secondary-bg);
            border-radius: 15px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .dark-mode .music-player{
            background: var(--dark-secondary-bg);
        }

        .music-controls {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .music-btn {
            background: none;
            border: none;
            color: var(--light-text);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .dark-mode .music-btn {
            color: var(--dark-text);
        }

        .music-btn:hover {
            color: var(--primary-color);
        }

        .volume-control {
            width: 100%;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">
          <i class="fas fa-video"></i> Study Stream
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="dashboard_mahasiswa.php"
                ><i class="fas fa-home"></i> Home</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="materi.php"
                ><i class="fas fa-book"></i> Materi</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="stream.php"
                ><i class="fas fa-video"></i> Study Stream</a
              >
            </li>
            <li class="nav-item">
              <span class="nav-link toggle-theme">
                <i id="themeIcon" class="fas fa-moon"></i>
              </span>
            </li>
          </ul>
        </div>
      </nav>

    <div class="main-container">
        <div class="stream-section">
            <div class="video-container">
                <div class="video-placeholder">
                    <i class="fas fa-video fa-3x mb-3"></i>
                    <h4>Start Your Study Stream</h4>
                    <p class="text-muted">Click 'Start Stream' to begin</p>
                </div>
            </div>

            <div class="stream-controls">
                <button class="control-btn" id="startStream">
                    <i class="fas fa-play"></i> Start Stream
                </button>
                <button class="control-btn">
                    <i class="fas fa-microphone"></i> Mic
                </button>
                <button class="control-btn">
                    <i class="fas fa-video"></i> Camera
                </button>
                <button class="control-btn">
                    <i class="fas fa-desktop"></i> Share Screen
                </button>
            </div>

            <div class="timer-container">
                <h5>Study Timer</h5>
                <div class="timer-display" id="timer">00:00:00</div>
                <div class="timer-buttons">
                    <button class="control-btn" id="startTimer">
                        <i class="fas fa-play"></i> Start
                    </button>
                    <button class="control-btn" id="pauseTimer">
                        <i class="fas fa-pause"></i> Pause
                    </button>
                    <button class="control-btn" id="resetTimer">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </div>

            <div class="stats-container">
                <h5>Belajar React JS Dasar</h5>
                <div class="stat-item">
                    <span>Total Study Time</span>
                    <span>4h 30m</span>
                </div>
                <div class="stat-item">
                    <span>Today's Goal</span>
                    <span>6h 00m</span>
                </div>
                <div class="stat-item">
                    <span>Focus Score</span>
                    <span>85%</span>
                </div>
            </div>

            <div class="music-player">
                <h5>Study Music</h5>
                <div class="music-controls">
                    <button class="music-btn"><i class="fas fa-step-backward"></i></button>
                    <button class="music-btn" id="playMusic"><i class="fas fa-play"></i></button>
                    <button class="music-btn"><i class="fas fa-step-forward"></i></button>
                </div>
                <input type="range" class="volume-control" min="0" max="100" value="50">
            </div>
        </div>

        <div class="chat-container">
            <div class="chat-header">
                Study Chat
            </div>
            <div class="chat-messages" id="chatMessages">
                <!-- Chat messages will be inserted here -->
            </div>
            <div class="chat-input">
                <form id="chatForm">
                    <input type="text" placeholder="Type message..." id="messageInput">
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const savedTheme = localStorage.getItem("theme");
        const icon = document.getElementById("themeIcon");

        // Default ke tema terang jika belum ada tema yang tersimpan
        if (!savedTheme || savedTheme === "light") {
          localStorage.setItem("theme", "light");
          icon.classList.replace("fa-sun", "fa-moon");
        } else if (savedTheme === "dark") {
          document.body.classList.add("dark-mode");
          icon.classList.replace("fa-moon", "fa-sun");
        }
      });

      // Event listener untuk mengubah tema
      document
        .getElementById("themeIcon")
        .addEventListener("click", function () {
          const icon = document.getElementById("themeIcon");

          // Toggle dark mode
          document.body.classList.toggle("dark-mode");

          // Update ikon dan simpan preferensi tema
          if (document.body.classList.contains("dark-mode")) {
            icon.classList.replace("fa-moon", "fa-sun");
            localStorage.setItem("theme", "dark");
          } else {
            icon.classList.replace("fa-sun", "fa-moon");
            localStorage.setItem("theme", "light");
          }
        });

        // Timer functionality
        let timer;
        let seconds = 0;
        let isRunning = false;

        function formatTime(seconds) {
            const h = Math.floor(seconds / 3600);
            const m = Math.floor((seconds % 3600) / 60);
            const s = seconds % 60;
            return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;

        }

        document.getElementById('startTimer').addEventListener('click', function() {
            if (!isRunning) {
                isRunning = true;
                timer = setInterval(() => {
                    seconds++;
                    document.getElementById('timer').textContent = formatTime(seconds);
                }, 1000);
            }
        });

        document.getElementById('pauseTimer').addEventListener('click', function() {
            clearInterval(timer);
            isRunning = false;
        });

        document.getElementById('resetTimer').addEventListener('click', function() {
            clearInterval(timer);
            isRunning = false;
            seconds = 0;
            document.getElementById('timer').textContent = formatTime(seconds);
        });

        // Chat functionality
        document.getElementById("chatForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const messageInput = document.getElementById("messageInput");
            const messageText = messageInput.value.trim();
            if (messageText) {
                const messageElement = document.createElement("div");
                messageElement.classList.add("message");
                messageElement.innerHTML = <div class="message-content">${messageText}</div>;
                document.getElementById("chatMessages").appendChild(messageElement);
                messageInput.value = "";
                document.getElementById("chatMessages").scrollTop = document.getElementById("chatMessages").scrollHeight;
            }
        });
    </script>
</body>
</html>