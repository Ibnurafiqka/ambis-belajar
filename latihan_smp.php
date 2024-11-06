<?php
session_start();
include('config.php');

// Cek apakah pengguna sudah login dan ambil level user
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$level = $_SESSION['level'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

?>


<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Latihan - Study Stream</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <style>
      /* Style dasar yang sama */
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");

      /* Tema dasar */
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
        --light-theme-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      }

      body {
        background: var(--light-secondary-bg);
        color: var(--light-text);
        font-family: var(--font-utama);
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

      /* Container dan Grid */
      .main-container {
        max-width: 1440px;
        margin: 2rem auto;
        padding: 1rem;
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 2rem;
      }

      /* Bagian Latihan */
      .exercise-section {
        background: var(--light-bg);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        border-radius: 20px;
      }

      body.dark-mode .exercise-section {
        background: var(--dark-bg);
      }

      .exercise-card {
        background: var(--light-bg);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
      }

      body.dark-mode .exercise-card {
        background: rgba(255, 255, 255, 0.08);
      }

      .exercise-question {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
      }

      .exercise-options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }

      .option-btn {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: var(--light-secondary-bg);
        border: 1px solid var(--light-border);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      body.dark-mode .option-btn {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
      }

      .option-text {
        color: var(--light-text);
      }

      body.dark-mode .option-text {
        color: var(--dark-text);
      }

      .option-btn:hover {
        background: rgba(78, 68, 255, 0.2);
      }

      .option-btn.correct {
        background: rgba(40, 167, 69, 0.2);
        border-color: #28a745;
      }

      .option-btn.incorrect {
        background: rgba(220, 53, 69, 0.2);
        border-color: #dc3545;
      }

      .feedback-box {
        margin-top: 1rem;
        padding: 1rem;
        border-radius: 10px;
        display: none;
      }

      .feedback-box.correct {
        background: rgba(40, 167, 69, 0.1);
        border: 1px solid #28a745;
        color: #28a745;
      }

      .feedback-box.incorrect {
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid #dc3545;
        color: #dc3545;
      }

      /* Navigation Controls */
      .material-controls {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
      }

      .control-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        background: var(--light-accent);
        border: none;
        color: var(--light-text);
        cursor: pointer;
        transition: background 0.3s ease;
      }

      body.dark-mode .control-btn {
        background: rgba(255, 255, 255, 0.1);
        color: var(--dark-text);
      }

      body.dark-mode .control-btn:hover {
        background: var(--primary-color);
        color: var(--dark-text);
      }

      .control-btn a {
        color: var(--light-text);
      }

      body.dark-mode .control-btn a {
        color: var(--dark-text);
      }

      .control-btn:hover {
        background: var(--primary-color);
        color: white;
      }

      /* Progress Bar */
      .progress-container {
        margin-bottom: 2rem;
      }

      .progress {
        height: 0.5rem;
        background: var(--light-accent);
        border-radius: 1rem;
      }

      body.dark-mode .progress {
        background: rgba(255, 255, 255, 0.1);
      }

      .progress-bar {
        background: var(--primary-color);
        border-radius: 1rem;
        transition: width 0.3s ease;
      }

      /* Sidebar */
      .content-list {
        background: var(--light-bg);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        padding: 1rem;
        border-radius: 15px;
        position: sticky;
        top: 20px;
        max-height: 100vh;
        overflow-y: auto;
      }

      body.dark-mode .content-list {
        background: var(--dark-bg);
      }

      .content-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem;
        border-bottom: 1px solid var(--light-border);
        cursor: pointer;
        transition: background 0.3s ease;
      }

      body.dark-mode .content-item {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .content-item.active {
        background: rgba(78, 68, 255, 0.2);
      }

      .content-item.completed {
        background: rgba(40, 167, 69, 0.2);
      }

      /* Timer */
      .timer-container {
        text-align: right;
        margin-bottom: 1rem;
        font-size: 1.2rem;
        color: var(--primary-color);
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="#">
        <i class="fas fa-book"></i> Materi Belajar
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
      <!-- Exercise Section -->
      <div class="exercise-section">
        <h2>Latihan dan Contoh Soal Aljabar</h2>

        <div class="progress-container">
          <p>Progress Latihan</p>
          <div class="progress">
            <div
              class="progress-bar"
              role="progressbar"
              style="width: 0%"
              aria-valuenow="0"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div>
        </div>

        <div class="timer-container">Waktu: <span id="timer">00:00</span></div>

        <div id="exerciseContainer">
          <!-- Exercise 1 -->
          <div class="exercise-card">
            <div class="exercise-question">
              <h4>Latihan 1</h4>
              <p>Diketahui persamaan berikut: 3x+5=20 <br>Carilah nilai x yang memenuhi persamaan tersebut.</p>
            </div>
            <div class="exercise-options">
              <button class="option-btn" data-correct="true">
                <span class="option-text">A. x = 5</span>
              </button>
              <button class="option-btn">
                <span class="option-text">B. x = 3</span>
              </button>
              <button class="option-btn">
                <span class="option-text">C. x = 7</span>
              </button>
              <button class="option-btn">
                <span class="option-text">D. x = 15</span>
              </button>
            </div>
            <div class="feedback-box">
              <!-- Feedback will be inserted here -->
            </div>
          </div>

          <!-- Exercise 2 -->
          <div class="exercise-card" style="display: none">
            <div class="exercise-question">
              <h4>Latihan 2</h4>
              <p>
              Sebuah angka dikalikan dengan 4, kemudian ditambah 7, hasilnya adalah 31. <br>
              Jika angka tersebut adalah y, tuliskan persamaan yang sesuai dan tentukan nilai y.
              </p>
            </div>
            <div class="exercise-options">
              <button class="option-btn">
                <span class="option-text">A. y = 7</span>
              </button>
              <button class="option-btn" data-correct="true">
                <span class="option-text">B. y = 6</span>
              </button>
              <button class="option-btn">
                <span class="option-text">C. y = 8</span>
              </button>
              <button class="option-btn">
                <span class="option-text">D. y = 9</span>
              </button>
            </div>

            <div class="feedback-box">
              <!-- Feedback will be inserted here -->
            </div>
          </div>
        </div>

        <div class="material-controls">
          <button class="control-btn" id="backButton">
            <i class="fas fa-backward"></i> Back
          </button>
          <button class="control-btn" id="nextButton">
            <i class="fas fa-forward"></i> Next
          </button>
          <button class="control-btn">
            <i class="fas fa-redo"></i> Reset Latihan
          </button>
          <button id="forumButton" class="control-btn">
            <i class="fas fa-comments"></i> Forum Diskusi
          </button>
        </div>
      </div>

      <!-- Sidebar Daftar Isi -->
      <div class="content-list">
        <h5>Daftar Isi Materi</h5>
        <div class="content-item completed" data-section="1">
          <span>1. Pendahuluan</span>
          <span class="status-icon"><i class="fas fa-check-square"></i></span>
        </div>
        <div class="content-item completed" data-section="2">
          <span>2. Topik Utama</span>
          <span class="status-icon"><i class="fas fa-check-square"></i></span>
        </div>
        <div class="content-item active" data-section="3">
          <span>3. Contoh dan Latihan</span>
          <span class="status-icon"><i class="far fa-square"></i></span>
        </div>
        <div class="content-item" data-section="4">
          <span>4. Ringkasan & Kuis</span>
          <span class="status-icon"><i class="far fa-square"></i></span>
        </div>
      </div>
    </div>

    <script>
      // Theme Toggle
      document.addEventListener("DOMContentLoaded", function () {
        const savedTheme = localStorage.getItem("theme");
        const icon = document.getElementById("themeIcon");

        // Set default theme to light if no theme is saved
        if (!savedTheme) {
          localStorage.setItem("theme", "light");
        }

        // Apply dark mode if saved theme is dark
        if (savedTheme === "dark") {
          document.body.classList.add("dark-mode");
          icon.classList.replace("fa-moon", "fa-sun");
        } else {
          // Ensure light mode is active (default)
          document.body.classList.remove("dark-mode");
          icon.classList.replace("fa-sun", "fa-moon");
        }
      });

      document
        .getElementById("themeIcon")
        .addEventListener("click", function () {
          const icon = document.getElementById("themeIcon");

          // Toggle dark mode
          document.body.classList.toggle("dark-mode");

          // Update icon and save preference
          if (document.body.classList.contains("dark-mode")) {
            icon.classList.replace("fa-moon", "fa-sun");
            localStorage.setItem("theme", "dark");
          } else {
            icon.classList.replace("fa-sun", "fa-moon");
            localStorage.setItem("theme", "light");
          }
        });

      // Timer functionality
      let seconds = 0;
      const timerDisplay = document.getElementById("timer");

      setInterval(() => {
        seconds++;
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        timerDisplay.textContent = `${String(minutes).padStart(
          2,
          "0"
        )}:${String(remainingSeconds).padStart(2, "0")}`;
      }, 1000);

      // Exercise functionality
      let currentExercise = 0;
      let totalExercises = document.querySelectorAll(".exercise-card").length;
      let score = 0;

      // Handle option selection
      document.querySelectorAll(".option-btn").forEach((button) => {
        button.addEventListener("click", function () {
          const card = this.closest(".exercise-card");
          const options = card.querySelectorAll(".option-btn");
          const feedbackBox = card.querySelector(".feedback-box");

          // Disable all options after selection
          options.forEach((opt) => opt.classList.add("disabled"));

          // Check if the selected option is correct
          if (this.dataset.correct) {
            this.classList.add("correct");
            feedbackBox.classList.add("correct");
            feedbackBox.textContent = "Jawaban Benar!";
            score++;
          } else {
            this.classList.add("incorrect");
            feedbackBox.classList.add("incorrect");
            feedbackBox.textContent = "Jawaban Salah!";
          }

          feedbackBox.style.display = "block";
          updateProgress();
        });
      });

      // Fungsi untuk menghubungkan ke forum_diskusi
      document
        .getElementById("forumButton")
        .addEventListener("click", function () {
          window.location.href = "forum_diskusi.html";
        });

      // Navigation controls
      const nextButton = document.getElementById("nextButton");
      const backButton = document.getElementById("backButton");

      nextButton.addEventListener("click", () => {
        if (currentExercise < totalExercises - 1) {
          document.querySelectorAll(".exercise-card")[
            currentExercise
          ].style.display = "none";
          currentExercise++;
          document.querySelectorAll(".exercise-card")[
            currentExercise
          ].style.display = "block";
        } else {
          window.location.href = "kuis_smp.php"; // Redirect to quiz page after last exercise
        }
      });

      backButton.addEventListener("click", () => {
        if (currentExercise > 0) {
          document.querySelectorAll(".exercise-card")[
            currentExercise
          ].style.display = "none";
          currentExercise--;
          document.querySelectorAll(".exercise-card")[
            currentExercise
          ].style.display = "block";
        }
      });

      function updateProgress() {
        const progressBar = document.querySelector(".progress-bar");
        const progressPercentage =
          ((currentExercise + 1) / totalExercises) * 100;
        progressBar.style.width = `${progressPercentage}%`;
        progressBar.setAttribute("aria-valuenow", progressPercentage);
      }

      // Daftar isi materi navigasi (diarahkan ke web yang bersangkutan)
        document.querySelectorAll(".content-item").forEach(item => {
            item.addEventListener("click", function() {
                const section = this.getAttribute("data-section");
                switch(section) {
                    case "1":
                        window.location.href = "materi_smp.php";
                        break;
                    case "2":
                        window.location.href = "topik_materi_smp.php";
                        break;
                    case "4":
                        window.location.href = "kuis_smp.php";
                        break;
                }
            });
        });
    </script>

    <!-- Scripts for Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
