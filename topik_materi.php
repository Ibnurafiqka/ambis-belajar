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
    <title>Topik Materi - Study Stream</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <style>
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
        --dark-secondary-bg2 : rgba(255, 255, 255, 0.1);
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
        color: var(--light-text);
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

      /* Main Content */
      .main-container {
        max-width: 1440px;
        margin: 2rem auto;
        padding: 1rem;
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 2rem;
      }

      .content-section {
        background: var(--light-bg);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        border-radius: 20px;
      }

      .dark-mode .content-section {
        background: var(--dark-bg);
        color: var(--dark-text);
      }

      .topic-content {
        margin-bottom: 2rem;
      }

      .topic-content h2 {
        color: var(--primary-color);
        margin-bottom: 1rem;
      }

      figure {
        text-align: center; /* Menyelaraskan teks di tengah */
      }

      img {
        max-width: 50%; /* Mengatur lebar gambar menjadi 50% dari ukuran aslinya */
        height: auto; /* Mengatur tinggi gambar secara otomatis */
        margin-top: 10px; /* Jarak antara h3 dan gambar */
        display: block; /* Mengatur gambar sebagai blok */
        margin-left: auto; /* Mengatur margin kiri secara otomatis */
        margin-right: auto; /* Mengatur margin kanan secara otomatis */
      }

      figcaption {
        margin-top: 10px;
        font-style: italic; /* Mengatur gaya font deskripsi menjadi italic */
        color: var(--light-text); /* Mengatur warna deskripsi */
      }

      .dark-mode figcaption {
        color: var(--dark-text);
      }

      .dark-mode {
        color: var(--dark-text);
      }

      .topic-content p {
        line-height: 1.8;
        margin-bottom: 1.5rem;
        text-align: justify;
      }

      .example-box {
        background: var(--light-secondary-bg);
        padding: 1.5rem;
        border-radius: 10px;
        margin: 1rem 0;
      }

      .dark-mode .example-box {
        background: var(--dark-secondary-bg2);
      }

      .material-controls {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
      }

      .control-btn {
        background: var(--light-accent);
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        border: none;
        color: var(--light-text);
        cursor: pointer;
        transition: background 0.3s ease;
      }

      .dark-mode .control-btn {
        background-color: var(--dark-secondary-bg2);
        color: var(--dark-text);
      }

      body.light-mode .control-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        color: var(--dark-text);
      }

      .control-btn a {
        color: var(--dark-text);
      }

      .control-btn:hover {
        background: var(--primary-color);
        color: white;
      }

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

      .dark-mode .content-list {
        background: var(--dark-bg);
        color: var(--dark-text);
      }

      .content-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        cursor: pointer;
        transition: background 0.3s ease;
      }

      body.light-mode .content-item {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
      }

      /* .content-item:hover { 
        background: rgba(255, 255, 255, 0.1);
      } */

      .content-item.active {
        background: rgba(78, 68, 255, 0.2);
      }

      .content-item.completed {
        background: rgba(40, 167, 69, 0.2);
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
            <a class="nav-link" href="stream_new.php"
              ><i class="fas fa-video"></i> Study Stream</a
            >
          </li>
          <li class="nav-item">
            <span class="nav-link toggle-theme">
              <i class="fas fa-moon" id="themeIcon"></i>
            </span>
          </li>
        </ul>
      </div>
    </nav>

    <div class="main-container">
      <!-- Content Section -->
      <div class="content-section">
        <div class="topic-content">
          <h2>Topik Utama: Pengenalan Pembelajaran</h2>

          <div class="example-box">
            <h4>Tujuan Pembelajaran:</h4>
            <ul>
              <li>Memahami konsep dasar materi</li>
              <li>Mengenali komponen-komponen penting</li>
              <li>Mengaplikasikan pengetahuan dalam contoh kasus</li>
            </ul>
          </div>

          <h3>1. Pendahuluan</h3>
          <figure>
            <img src="assets/react.png" alt="React JS" />
            <figcaption>Gambar 1: Pengenalan React.</figcaption>
          </figure>
          <p>
            React.js adalah pustaka JavaScript yang dikembangkan oleh Meta
            (sebelumnya Facebook) yang dirancang untuk membangun antarmuka
            pengguna (UI) yang interaktif dan responsif. Dengan fokus pada
            pengalaman pengguna, React mengadopsi pendekatan berbasis komponen
            yang memungkinkan pengembang untuk membangun UI dengan lebih efisien
            dan terstruktur. Konsep utama dalam React adalah komponen, yang
            merupakan bagian-bagian kecil dari UI yang dapat digunakan kembali.
            Setiap komponen dapat memiliki state dan props, sehingga
            memungkinkan pengembang untuk mengelola data dan tampilan dengan
            lebih baik. <br /><br />
            Selain itu, React memanfaatkan virtual DOM untuk meningkatkan
            performa rendering dengan mengurangi interaksi langsung dengan DOM
            asli. Dengan penggunaan React, pengembang dapat dengan mudah
            membangun aplikasi web yang kompleks dengan antarmuka yang dinamis
            dan interaktif. Pendekatan deklaratif yang diadopsi oleh React juga
            memungkinkan pengembang untuk lebih fokus pada logika aplikasi
            daripada detail implementasi, menjadikan pengembangan aplikasi lebih
            intuitif. Dengan ekosistem yang kaya dan dukungan komunitas yang
            besar, React telah menjadi salah satu pilihan utama bagi pengembang
            dalam menciptakan aplikasi web modern.
          </p>

          <h3>2. Konsep Dasar</h3>
          <p>
            Di dalam bagian ini, kita akan membahas beberapa konsep dasar yang
            perlu dipahami oleh pemula sebelum memulai dengan React.js. Pertama,
            komponen adalah blok bangunan utama dalam React, yang bisa berupa
            komponen fungsi atau kelas. Komponen fungsi lebih umum digunakan
            karena lebih sederhana dan lebih mudah untuk dikelola. Selanjutnya,
            props adalah cara untuk mengirim data dari komponen induk ke
            komponen anak, sedangkan state digunakan untuk mengelola data
            internal komponen yang dapat berubah seiring waktu. State
            memungkinkan komponen untuk merespons interaksi pengguna dan
            memperbarui tampilan dengan cepat. <br /><br />
            Selain itu, lifecycle methods adalah fungsi yang dapat digunakan
            untuk mengeksekusi kode pada titik tertentu selama siklus hidup
            komponen, seperti saat komponen dibuat, diperbarui, atau dihapus.
            Memahami cara kerja props dan state sangat penting, karena ini
            adalah cara utama untuk mengelola data dalam aplikasi React.
            Terakhir, penting juga untuk mengenal JSX, sintaks yang digunakan
            oleh React untuk mendeskripsikan tampilan UI. Dengan pemahaman yang
            kuat tentang konsep-konsep dasar ini, pemula akan lebih siap untuk
            membangun aplikasi React yang lebih kompleks dan fungsional.
          </p>

          <div class="example-box">
            <h4>Contoh Penerapan:</h4>
            <p>Berikut adalah contoh penerapan konsep yang telah dipelajari:</p>
            <ul>
              <li>Contoh 1: Installasi React JS</li>
              <li>Contoh 2: Program Sederhana React JS</li>
              <li>Contoh 3: Latihan membuat program React Js</li>
            </ul>
          </div>

          <h3>3. Rangkuman</h3>
          <p>
            Dalam rangkuman materi React.js untuk pemula, kita telah membahas
            beberapa konsep kunci yang membentuk dasar pengembangan aplikasi
            menggunakan pustaka ini. Pertama, pentingnya komponen sebagai blok
            bangunan UI yang dapat digunakan kembali, yang meningkatkan
            efisiensi dan pemeliharaan aplikasi. Komponen ini dikelola melalui
            props dan state, di mana props berfungsi untuk mengirimkan data
            antar komponen, sedangkan state memungkinkan komponen untuk
            menyimpan dan memperbarui data yang bersifat lokal. <br /><br />
            Selain itu, kita juga membahas lifecycle methods yang memberikan
            kontrol lebih besar atas perilaku komponen pada berbagai tahap
            siklus hidupnya. Dengan memahami cara kerja virtual DOM, pengembang
            dapat menciptakan aplikasi yang lebih responsif dan cepat. Rangkuman
            ini juga menggarisbawahi manfaat utama menggunakan React, seperti
            kemudahan dalam membangun antarmuka yang dinamis dan interaktif,
            serta fleksibilitas yang ditawarkan oleh ekosistem dan komunitas
            yang mendukung. Dengan fondasi yang kuat dalam konsep-konsep ini,
            pemula siap untuk melanjutkan perjalanan mereka dalam membangun
            aplikasi web yang lebih kompleks dan menarik menggunakan React.
          </p>
        </div>

        <div class="material-controls">
          <button class="control-btn" id="backButton">
            <i class="fas fa-backward"></i> Back
          </button>
          <button class="control-btn" id="nextButton">
            <i class="fas fa-forward"></i> Next
          </button>
          <button class="control-btn">
            <i class="fas fa-download"></i> Download Materi
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
        <div class="content-item active" data-section="2">
          <span>2. Topik Utama</span>
          <span class="status-icon"><i class="far fa-square"></i></span>
        </div>
        <div class="content-item" data-section="3">
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

      // Fungsi untuk menghubungkan ke forum_diskusi
      document
        .getElementById("forumButton")
        .addEventListener("click", function () {
          window.location.href = "forum_diskusi.php";
        });

      // Navigation Logic
      document
        .getElementById("nextButton")
        .addEventListener("click", function () {
          window.location.href = "latihan.php";
        });

      document
        .getElementById("backButton")
        .addEventListener("click", function () {
          window.location.href = "materi.php";
        });

      // Content Item Click Logic
      document.querySelectorAll(".content-item").forEach((item) => {
        item.addEventListener("click", function () {
          const section = this.getAttribute("data-section");
          switch (section) {
            case "1":
              window.location.href = "materi.php";
              break;
            case "3":
              window.location.href = "latihan.php";
              break;
            case "4":
              window.location.href = "kuis.php";
              break;
          }
        });
      });
    </script>
  </body>
</html>
