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

// Mendapatkan semua kategori
$stmt_categories = $pdo->prepare("SELECT DISTINCT roadmap_id, title FROM materi ORDER BY roadmap_id");
// $stmt_categories->execute();
// $categories = $stmt_categories->fetchAll();

// Mendapatkan materi berdasarkan kategori
// $stmt_materials = $pdo->prepare("
//     SELECT m.id, m.title AS material_title, m.content AS material_content,
//            m.roadmap_id
//     FROM materi m
//     ORDER BY m.roadmap_id
// ");
// $stmt_materials->execute();
// $materials = $stmt_materials->fetchAll();

// Periksa apakah pengguna adalah super admin
$is_super_admin = ($user['level'] === 'super admin');
?>


<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Materi Belajar - Study Stream</title>
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
        margin: 0;
        padding: 0;
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

      .toggle-theme {
        cursor: pointer;
        font-size: 1.2rem;
      }

      /* Main Container */
      .main-container {
        max-width: 1440px;
        margin: 2rem auto;
        padding: 1rem;
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 2rem;
      }

      .main-container h3 {
        margin-top: 1rem;
      }

      /* Video Section */
      .video-section {
        background: var(--light-bg);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        border-radius: 20px;
      }

      .video-container {
        background: #000;
        width: 100%;
        padding-top: 56.25%;
        position: relative;
        border-radius: 15px;
        overflow: hidden;
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
        background: url("https://img.youtube.com/vi/kcnwI_5nKyA/maxresdefault.jpg")
          center center / cover;
        border-radius: 15px;
        cursor: pointer;
      }

      /* Material Controls */
      .material-controls {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1rem;
      }

      .control-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        background: var(--light-accent);
        border: 1px solid var(--light-border);
        color: var(--light-text);
        cursor: pointer;
        transition: background 0.3s ease;
      }

      body.dark-mode .control-btn {
        background: var(--dark-secondary-bg2) !important;
      }

      body.dark-mode .control-btn:hover {
        background: var(--primary-color) !important;
      }

      .control-btn:hover {
        background: var(--primary-color);
        color: #fff;
      }

      /* Daftar Isi */
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

      .content-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: background 0.3s ease;
      }

      .content-item:hover {
        background: rgba(0, 0, 0, 0.05);
      }

      .content-item.active {
        background: rgba(78, 68, 255, 0.1);
      }

      .content-item.completed {
        background: rgba(40, 167, 69, 0.2);
      }

      /* Responsiveness */
      @media (max-width: 992px) {
        .navbar-nav {
          background-color: rgba(248, 249, 250, 0.95);
          position: absolute;
          top: 60px;
          right: 0;
          width: 100%;
          text-align: center;
        }

        .navbar-collapse {
          display: flex;
          flex-direction: column;
        }

        .main-container {
          grid-template-columns: 1fr;
          gap: 1rem;
        }

        .material-controls {
          flex-direction: column;
        }
      }
      /* Tambahan untuk Dark Mode */
      body.dark-mode {
        background: var(--dark-secondary-bg);
        color: var(--dark-text);
      }

      body.dark-mode .navbar {
        background: var(--dark-bg);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      body.dark-mode .nav-link {
        color: var(--dark-text) !important;
      }

      body.dark-mode .nav-link:hover,
      body.dark-mode .nav-item.active .nav-link {
        color: var(--primary-color) !important;
      }

      body.dark-mode .video-section,
      body.dark-mode .content-list {
        background: var(--dark-bg);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
      }

      body.dark-mode .control-btn {
        background: var(--dark-secondary-bg);
        border: 1px solid var(--dark-bg);
        color: var(--dark-text);
      }

      body.dark-mode .control-btn:hover {
        background: var(--primary-color);
        color: #fff;
      }

      body.dark-mode .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23ffffff' viewBox='0 0 30 30'%3E%3Cpath d='M4 7h22v2H4V7zm0 7h22v2H4v-2zm0 7h22v2H4v-2z'/%3E%3C/svg%3E");
      }

      .topic-description a {
        color: #007bff !important;
        cursor: pointer;
        text-decoration: none;
      }

      .topic-description a:hover {
        color: #0056b3 !important;
      }

      .topic-description #textContent.collapsed {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }

      .topic-description #textContent {
        transition: max-height 0.3s ease;
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
              <i class="fas fa-sun" id="themeIcon"></i>
            </span>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
      <!-- Video Section -->
      <div class="video-section">
        <div class="video-container">
          <div class="video-placeholder" id="videoPlaceholder"></div>

          <!-- Video iframe hidden by default -->
          <iframe
            id="youtubeVideo"
            width="100%"
            height="100%"
            src="https://www.youtube.com/embed/kcnwI_5nKyA?enablejsapi=1"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            style="
              display: none;
              position: absolute;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              border-radius: 15px;
            "
          ></iframe>
        </div>

        <div class="material-controls">
          <button class="control-btn" id="startMaterial">
            <i class="fas fa-play"></i> Play
          </button>
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

        <!-- Content container for descriptive sections -->
        <div class="content-container" id="topicContent">
          <h3>Topik Utama</h3>
          <div class="topic-description">
            <p id="textContent" class="collapsed">
              React JS adalah pustaka JavaScript yang sangat populer untuk
              membangun antarmuka pengguna (UI) yang interaktif dan dinamis.
              Dibuat oleh Facebook, React memungkinkan pengembang untuk membuat
              komponen UI yang dapat digunakan kembali, sehingga mempercepat
              proses pengembangan. Dengan konsep Virtual DOM, React dapat
              memperbarui tampilan UI dengan efisien tanpa perlu memuat ulang
              halaman. Bagi pemula, mempelajari React dapat dimulai dengan
              memahami konsep dasar seperti komponen, props, dan state. Komponen
              adalah blok bangunan dari aplikasi React, di mana setiap komponen
              dapat memiliki logika dan render tampilan sendiri. Props digunakan
              untuk mengirimkan data dari satu komponen ke komponen lainnya,
              sementara state memungkinkan komponen untuk mengelola data yang
              dapat berubah seiring waktu. <br /><br />
              Setelah memahami dasar-dasar ini, pemula dapat melanjutkan untuk
              mempelajari lebih dalam tentang manajemen state menggunakan
              pustaka seperti Redux atau Context API, serta pengelolaan efek
              samping menggunakan Hooks seperti useEffect. Dengan pendekatan
              yang modular dan komponen yang terisolasi, React memungkinkan
              pengembang untuk menciptakan aplikasi yang skalabel dan mudah
              dirawat.
            </p>
            <a id="toggleButton">Baca Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Sidebar Daftar Isi -->
      <div class="content-list">
        <h5>Daftar Isi Materi</h5>
        <div class="content-item" data-video="kcnwI_5nKyA" data-section="1">
          <span>1. Pendahuluan</span>
          <span class="status-icon"><i class="far fa-square"></i></span>
        </div>
        <div class="content-item" data-video="SECOND_VIDEO_ID" data-section="2">
          <span>2. Topik Utama</span>
          <span class="status-icon"><i class="far fa-square"></i></span>
        </div>
        <div class="content-item" data-video="THIRD_VIDEO_ID" data-section="3">
          <span>3. Contoh dan Latihan</span>
          <span class="status-icon"><i class="far fa-square"></i></span>
        </div>
        <div class="content-item" data-section="4">
          <span>4. Ringkasan & Kuis</span>
          <span class="status-icon"><i class="far fa-square"></i></span>
        </div>
      <div>
    </div>

    <script>
      // Cek status mode saat halaman pertama kali dimuat
      document.addEventListener("DOMContentLoaded", function () {
        // Periksa mode dari localStorage
        const savedTheme = localStorage.getItem("theme");

        if (savedTheme === "dark") {
          document.body.classList.add("dark-mode");
          document.getElementById("themeIcon").classList.add("fa-sun");
          document.getElementById("themeIcon").classList.remove("fa-moon");
        } else {
          document.body.classList.remove("dark-mode");
          document.getElementById("themeIcon").classList.add("fa-moon");
          document.getElementById("themeIcon").classList.remove("fa-sun");
        }
      });

      // Tombol toggle untuk mengubah mode
      document
        .querySelector(".toggle-theme")
        .addEventListener("click", function () {
          document.body.classList.toggle("dark-mode");

          let themeIcon = document.getElementById("themeIcon");
          themeIcon.classList.toggle("fa-sun");
          themeIcon.classList.toggle("fa-moon");

          // Simpan preferensi ke localStorage
          if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
          } else {
            localStorage.setItem("theme", "light");
          }
        });

      // Event listener untuk tombol start material (video youtube)
      document
        .getElementById("startMaterial")
        .addEventListener("click", function () {
          // Sembunyikan placeholder dan tampilkan video
          document.getElementById("videoPlaceholder").style.display = "none";
          var video = document.getElementById("youtubeVideo");
          video.style.display = "block";

          // Mulai pemutaran video
          video.contentWindow.postMessage(
            '{"event":"command","func":"playVideo","args":""}',
            "*"
          );
        });

      let currentSection = 1;
      const totalSections = 4;

      // Fungsi untuk memuat konten topik
      async function loadTopicContent() {
        try {
          const response = await fetch("topic-content.json");
          const data = await response.json();
          document.querySelector(".topic-description").innerHTML = data.content;
        } catch (error) {
          console.error("Error loading topic content:", error);
          document.querySelector(".topic-description").innerHTML =
            "<p>Maaf, konten tidak dapat dimuat.</p>";
        }
      }

      // Fungsi untuk mengganti tampilan antara video dan konten
      function switchView(type) {
        const videoWrapper = document.getElementById("videoWrapper");
        const contentContainer = document.getElementById("topicContent");
        const startButton = document.getElementById("startMaterial");

        if (type === "video") {
          videoWrapper.style.display = "block";
          contentContainer.style.display = "none";
          startButton.style.display = "block";
        } else if (type === "content") {
          videoWrapper.style.display = "none";
          contentContainer.style.display = "block";
          startButton.style.display = "none";
          loadTopicContent();
        }
      }

      // Fungsi untuk menghubungkan ke forum_diskusi
      document
        .getElementById("forumButton")
        .addEventListener("click", function () {
          window.location.href = "forum_diskusi.php";
        });

      // Fungsi untuk menandai section sebagai selesai
      function markSectionComplete(sectionNumber) {
        const section = document.querySelector(
          `.content-item[data-section="${sectionNumber}"]`
        );
        section.classList.add("completed");
        const icon = section.querySelector(".status-icon i");
        icon.classList.remove("fa-square");
        icon.classList.add("fa-check-square");
      }

      // Fungsi untuk mengubah section yang sedang aktif
      function changeSection(newSection) {
        // Pindah halaman berdasarkan section tertentu
        if (newSection === 2) {
          // Pindah ke halaman topik-materi.html setelah Pendahuluan
          window.location.href = "topik_materi.php";
          return;
        } else if (newSection === 3) {
          // Pindah ke halaman latihan.html setelah Topik Utama
          window.location.href = "latihan.php";
          return;
        } else if (newSection > totalSections) {
          // Pindah ke halaman kuis.html setelah Latihan
          window.location.href = "kuis.php";
          return;
        }

        // Perbarui currentSection dan aktifkan section baru
        ccurrentSection = newSection;
        document.querySelectorAll(".content-item").forEach((item) => {
          item.classList.remove("active");
        });

        const newSectionElement = document.querySelector(
          `.content-item[data-section="${currentSection}"]`
        );
        newSectionElement.classList.add("active");

        // Cek jenis section dan perbarui tampilan sesuai dengan tipe (video atau konten)
        const sectionType = newSectionElement.dataset.type;
        switchView(sectionType);

        // Jika section adalah video, perbarui ID video
        if (sectionType === "video") {
          const videoId = newSectionElement.dataset.video;
          if (videoId) {
            updateVideo(videoId);
          }
        }
      }

      // Fungsi untuk memperbarui sumber video
      function updateVideo(videoId) {
        const iframe = document.getElementById("youtubeVideo");
        iframe.src = `https://www.youtube.com/embed/${videoId}?enablejsapi=1`;
      }

      // Event Listener untuk Tombol Next
      document.getElementById("nextButton").addEventListener("click", () => {
        changeSection(currentSection + 1);
      });

      // Event Listener untuk Tombol Back
      document.getElementById("backButton").addEventListener("click", () => {
        if (currentSection > 1) {
          changeSection(currentSection - 1);
        }
      });

      // Event Listener untuk item konten (pindah section saat item diklik)
      document.querySelectorAll(".content-item").forEach((item) => {
        item.addEventListener("click", () => {
          const sectionNumber = parseInt(item.dataset.section);
          changeSection(sectionNumber);
        });
      });

      // Event Listener untuk tombol mulai material (tampilkan video)
      document
        .getElementById("startMaterial")
        .addEventListener("click", function () {
          document.getElementById("videoPlaceholder").style.display = "none";
          const video = document.getElementById("youtubeVideo");
          video.style.display = "block";
          video.contentWindow.postMessage(
            '{"event":"command","func":"playVideo","args":""}',
            "*"
          );
        });

      // Inisialisasi halaman dengan section pertama
      changeSection(1);

      const textContent = document.getElementById("textContent");
      const toggleButton = document.getElementById("toggleButton");

      // Atur paragraf ke tampilan singkat secara default
      textContent.classList.add("collapsed");

      toggleButton.addEventListener("click", () => {
        textContent.classList.toggle("collapsed");
        toggleButton.textContent = textContent.classList.contains("collapsed")
          ? "Baca Selengkapnya"
          : "Tutup";
      });
    </script>
  </body>
</html>

