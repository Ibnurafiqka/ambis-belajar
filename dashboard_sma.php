<?php
session_start();
include('config.php');

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'SMA') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Mengambil progress belajar
$stmt_progress = $pdo->prepare("SELECT * FROM progress WHERE user_id = ?");
$stmt_progress->execute([$user_id]);
$progress = $stmt_progress->fetch();

// Mengambil materi terbaru
$stmt_materi = $pdo->prepare("SELECT * FROM materi WHERE level = 'SMA' ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Utama - Ambis Belajar</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

      :root {
        /* Font */
        --font-utama: "Poppins", serif;

        /* Warna Utama */
        --primary-color: #4e44ff;
        --secondary-color: #6c63ff;
        --accent-color: #ff6b6b;
        --accent-2nd-color: #e55a5a;

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
        --light-theme-bg: linear-gradient(
          135deg,
          #f5f7fa 0%,
          #c3cfe2 100%
        ); /* Background gradient untuk tema terang */
      }

      body {
        background: var(--light-secondary-bg);
        font-family: var(--font-utama);
        color: var(--light-text);
        margin: 0;
        padding: 0;
        transition: background 0.3s, color 0.3s;
      }

      .logo-image {
        width: 50px;
        height: 50px;
        vertical-align: middle;
      }

      .bg-elements {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none; /* Agar tidak menghalangi interaksi */
        z-index: -1; /* Di belakang konten */
      }

      .floating-shape {
        position: absolute;
        background: rgba(78, 68, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        animation: float 20s infinite alternate ease-in-out;
        box-shadow: 0 10px 30px rgba(78, 68, 255, 0.2);
      }

      @keyframes float {
        0% {
          transform: translate(0, 0) rotate(0deg) scale(1);
          filter: hue-rotate(0deg);
        }
        50% {
          transform: translate(50px, 50px) rotate(180deg) scale(1.1);
          filter: hue-rotate(90deg);
        }
        100% {
          transform: translate(0, 0) rotate(360deg) scale(1);
          filter: hue-rotate(180deg);
        }
      }

      /* Responsif untuk layar kecil */
      @media (max-width: 768px) {
        .floating-shape {
          display: none; /* Sembunyikan di layar kecil untuk performa */
        }
      }

      .navbar {
        background: var(--light-bg);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.1); /* Ubah border untuk mode gelap */
        padding: 1rem 2rem;
        z-index: 1;
      }

      .navbar-brand {
        color: var(--primary-color) !important;
        font-weight: 800;
        font-size: 1.6rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .navbar-brand i {
        color: var(--accent-color);
      }

      .nav-link {
        color: var(--light-text) !important;
        transition: color 0.3s ease;
        font-weight: 500;
        font-size: 1.1rem;
      }

      .nav-link:hover,
      .nav-item.active .nav-link {
        color: var(--primary-color) !important;
        font-weight: 500;
      }

      .dropdown-menu {
        background: var(--light-bg);
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      }

      .dropdown-item {
        color: var(--light-text); /* Ubah ke warna teks gelap */
        transition: all 0.3s;
      }

      .divider {
        padding: 0.5px 0.5px;
        margin: 0.5rem 0.5rem;
        margin-left: 1.5rem;
        margin-right: 1.5rem;
        background-color: var(--light-text);
        border-radius: 20px;
        height: 1px;
      }

      .dropdown-item:hover {
        background: var(--primary-color);
        color: #fff;
      }

      .toggle-theme {
        cursor: pointer;
        color: var(--light-text); /* Ubah ke warna teks gelap */
        font-size: 1.4rem;
      }

      .btn-logout {
        background-color: var(--accent-color);
        border: none;
      }

      .btn-logout:hover {
        background-color: var(--accent-2nd-color);
      }

      .btn-logout-batal {
        border: none;
        color: var(--dark-text);
        background-color: #4a4a4a;
      }

      .btn-logout-batal:hover {
        background-color: #333;
      }

      /* Main Content */
      .main-container {
        background-color: var(--light-secondary-bg);
        display: grid;
        grid-template-columns: 1fr 3fr;
        gap: 2rem;
        padding: 2rem;
        max-width: 1440px;
        margin: 0 auto;
      }

      .sidebar {
        background: var(--light-bg);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        height: calc(100vh - 100px);
        position: sticky;
        top: 1rem;
        border-radius: 15px;
      }

      .sidebar h5 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        font-weight: 600;
      }

      .sidebar a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        color: rgba(255, 255, 255, 0.85);
        color: var(--primary-color);
        border-radius: 10px;
        transition: all 0.3s ease;
        text-decoration: none;
      }

      .sidebar a:hover,
      .sidebar a.active {
        background: var(--primary-color);
        color: #fff;
        transform: translateY(-2px);
      }

      .content {
        background: var(--light-bg);
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        position: relative;
      }

      .content h2 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1rem;
      }

      /* Modal styles for logout confirmation */
      .modal-backdrop.show {
        opacity: 0.8;
      }

      .welcome-card {
        background: linear-gradient(135deg, #4e44ff, #6c63ff);
        padding: 2rem;
        border-radius: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        margin-bottom: 1.5rem;
      }

      .welcome-card h3 {
        margin: 0;
        font-weight: 600;
        font-size: 1.5rem;
      }

      .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
      }

      .stat-card {
        /* background: rgba(255, 255, 255, 0.05); */
        background: var(--secondary-color);
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        transition: all 0.3s ease;
      }

      .stat-card:hover {
        transform: translateY(-2.5px);
        box-shadow: 0 5px 10px var(--secondary-color);
      }

      .stat-card-new {
        background: var(--light-accent);
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        transition: all 0.3s ease;
        margin-bottom: 0.75rem;
      }

      .stat-card-new:hover {
        transform: translateY(-2.5px);
        box-shadow: 0 5px 10px var(--light-accent);
      }

      .list-group-item {
        border: none;
      }

      .list-group-item:first-child,
      .list-group-item:last-child {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
      }

      .badge-primary {
        color: var(--dark-text);
        background-color: var(--primary-color);
      }

      .stat-title {
        /* color: #bbb; */
        font-size: 0.9rem;
        color: #fff;
      }

      .stat-value {
        /* color: var(--primary-color); */
        color: #fff;
        font-weight: 700;
        font-size: 1.4rem;
        margin-top: 0.5rem;
      }

      /* Pop-up Modal */
      .popup-modal {
        display: none; /* Awalnya disembunyikan */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(
          0,
          0,
          0,
          0.5
        ); /* Latar belakang semi-transparan */
      }

      .popup-content {
        background-color: var(--light-bg);
        color: var(--light-text);
        margin: 10% auto;
        padding: 20px;
        border-radius: 10px;
        width: 80%;
        max-width: 400px;
        text-align: center;
      }

      .close-btn {
        color: #4a4a4a;
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
      }

      .close-btn:hover {
        color: #333;
      }

      .h2-khusus {
        margin-top: 1rem;
        text-align: center;
      }

      .carousel-item {
        height: 200px;
        background: #6c757d;
        color: #fff;
        border-radius: 10px;
        overflow: hidden;
      }

      .carousel-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
      }

      .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        border-radius: 5px;
        padding: 10px;
      }

      .footer {
        background: var(--light-secondary-bg);
        margin-top: 2rem;
        text-align: center;
        color: #333;
        font-size: 0.9rem;
      }

      @media (max-width: 992px) {
        .main-container {
          grid-template-columns: 1fr;
        }

        .sidebar {
          position: static;
          height: auto;
        }

        .stats-grid {
          grid-template-columns: 1fr;
        }
      }

      /* Dark Mode */
      body.dark-mode {
        background: var(--dark-secondary-bg);
        color: var(--dark-text);
      }

      .dark-mode .main-container {
        background: var(--dark-secondary-bg);
      }

      .dark-mode .navbar {
        background: var(--dark-bg);
        color: var(--dark-text);
      }
      .dark-mode .sidebar,
      .dark-mode .content {
        background: var(--dark-bg);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
        color: var(--dark-text);
      }

      .dark-mode .navbar .nav-link {
        color: var(--dark-text) !important;
      }

      .dark-mode .nav-link {
        color: var(--light-text) !important;
        transition: color 0.3s ease;
        font-weight: 500;
      }

      .dark-mode .nav-link:hover,
      .dark-mode .nav-item.active .nav-link {
        color: var(--primary-color) !important;
        font-weight: 500;
      }

      .dark-mode .dropdown-item {
        color: var(--light-text);
      }

      .dark-mode .dropdown-item:hover {
        color: var(--dark-text);
      }

      .dark-mode .navbar .navbar-brand {
        color: var(--primary-color);
      }

      .dark-mode .navbar {
        background: var(--dark-bg);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .dark-mode .nav-link {
        color: var(--dark-text) !important;
      }

      .dark-mode .nav-link a:hover {
        color: var(--primary-color) !important;
      }

      .dark-mode .dropdown-menu {
        background: var(--dark-bg);
      }

      .dark-mode .dropdown-menu a {
        color: var(--dark-text);
      }

      /* Dark mode log out modal */
      .dark-mode .modal-header,
      .dark-mode .modal-body,
      .dark-mode .modal-footer {
        background: var(--dark-bg);
      }

      /* .dark-mode .close-btn {
        color: white;
      }

      .dark-mode .close-btn span {
        color: white;
      } */

      .dark-mode .divider {
        padding: 0.5px 0.5px;
        margin: 0.5rem 0.5rem;
        margin-left: 1.5rem;
        margin-right: 1.5rem;
        background-color: var(--dark-text);
        border-radius: 20px;
        height: 1px;
      }

      .dark-mode .toggle-theme {
        color: var(--dark-text);
        font-size: 1.2rem;
      }

      .dark-mode .sidebar a {
        color: var(--dark-text);
      }

      .dark-mode .carousel-item {
        background: var(--dark-secondary-bg);
      }

      .dark-mode .stat-card-new {
        background: var(--dark-secondary-bg);
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        transition: all 0.3s ease;
        margin-bottom: 0.75rem;
      }

      .dark-mode .stat-card-new:hover {
        box-shadow: 0 5px 10px var(--dark-secondary-bg);
      }

      .dark-mode .footer {
        background: var(--dark-secondary-bg);
        color: var(--dark-text);
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="#">
        <img src="assets/logo.png" alt="logo" class="logo-image" /> Ambis Belajar
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
            <a class="nav-link" href="#">Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="resourcesDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Academy
            </a>
            <div class="dropdown-menu" aria-labelledby="resourcesDropdown">
              <a class="dropdown-item" href="materi.php">Materi</a>
              <a class="dropdown-item" href="kuis.php">Kuis</a>
              <a class="dropdown-item" href="forum_diskusi_sma.php"
                >Forum Diskusi</a
              >
              <a class="dropdown-item" href="stream.php">Stream</a>
            </div>
          </li>
          <li>
            <span class="nav-link toggle-theme">
              <i class="fas fa-sun" id="themeIcon"></i>
            </span>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="profileDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="fas fa-user"></i>
              <?php echo htmlspecialchars($user['username']); ?>
            </a>
            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="profileDropdown"
            >
              <a class="dropdown-item" href="profile_sma.php">Profil Saya</a>
              <a class="dropdown-item" href="setting_sma.php">Pengaturan</a>
              <div class="divider"></div>
              <a
                class="dropdown-item"
                href="#"
                data-toggle="modal"
                data-target="#logoutModal"
                >Log Out</a
              >
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Logout -->
    <div
      class="modal fade"
      id="logoutModal"
      tabindex="-1"
      aria-labelledby="logoutModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">Apakah Anda yakin ingin logout?</div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary btn-logout-batal"
              data-dismiss="modal"
            >
              Batal
            </button>
            <a href="login.php" class="btn btn-primary btn-logout"
              >Ya, Logout</a
            >
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="main-container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <h5>Navigation</h5>
        <a href="materi_sma.php"><i class="fas fa-book"></i> Materi</a>
        <a href="kuis_sma.php"><i class="fas fa-clipboard-list"></i> Kuis</a>
        <a href="forum_diskusi_sma.php"
          ><i class="fas fa-comments"></i> Forum Diskusi</a
        >
        <a href="stream.php"><i class="fas fa-video"></i> Study Stream</a>
      </aside>

      <!-- Card section -->
      <div class="content">
        <div class="welcome-card">
          <div>
            <h3>Selamat Datang, <?php echo htmlspecialchars($user['username']); ?>👋</h3>
            <p>
              Jelajahi materi dan forum, mulai live stream, atau kerjakan kuis
              yang tersedia di dashboard ini.
            </p>
          </div>
          <i class="fas fa-graduation-cap fa-3x"></i>
        </div>

        <!-- Pop-up Modal -->
        <div id="popup-modal" class="popup-modal">
          <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h3 id="popup-title">Judul</h3>
            <p id="popup-content">Konten riwayat statistik</p>
          </div>
        </div>

        <!-- Statistik Section -->
        <h2>Statistik Pembelajaran</h2>
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-title">Materi Dibaca</div>
            <div class="stat-value">34 <i class="fas fa-book"></i></div>
          </div>
          <div class="stat-card">
            <div class="stat-title">Kuis Diselesaikan</div>
            <div class="stat-value">
              15 <i class="fas fa-clipboard-list"></i>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-title">XP Terkumpul</div>
            <div class="stat-value">800 <i class="fas fa-star"></i></div>
          </div>
          <div class="stat-card">
            <div class="stat-title">Achievement</div>
            <div class="stat-value">8 <i class="fas fa-trophy"></i></div>
          </div>
          <div class="stat-card">
            <div class="stat-title">Streak Hari Belajar</div>
            <div class="stat-value">14 Hari <i class="fas fa-fire"></i></div>
          </div>
          <div class="stat-card">
            <div class="stat-title">Total Point</div>
            <div class="stat-value">2500 <i class="fas fa-coins"></i></div>
          </div>
        </div>

        <!-- Materi Section -->
        <h2 class="h2-khusus">Materi Terbaru</h2>
        <div id="recentMaterials" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="assets/carousel-1.png" alt="Materi 1" class="d-block w-100" />
              <div class="carousel-caption d-none d-md-block">
                <h5>Materi Dasar React Js</h5>
              </div>
            </div>
            <div class="carousel-item">
              <img src="assets/carousel-2.png" alt="Materi 2" class="d-block w-100" />
              <div class="carousel-caption d-none d-md-block">
                <h5>Materi Dasar MySQL</h5>
              </div>
            </div>
            <div class="carousel-item">
              <img src="assets/carousel-3.png" alt="Materi 3" class="d-block w-100" />
              <div class="carousel-caption d-none d-md-block">
                <h5>HTML & CSS Untuk Pemula</h5>
              </div>
            </div>
          </div>
          <a
            class="carousel-control-prev"
            href="#recentMaterials"
            role="button"
            data-slide="prev"
          >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Sebelumnya</span>
          </a>
          <a
            class="carousel-control-next"
            href="#recentMaterials"
            role="button"
            data-slide="next"
          >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Selanjutnya</span>
          </a>
        </div>

        <!-- Event Section  -->
        <h2 class="h2-khusus">Event Mendatang</h2>
        <ul class="list-group mb-4">
          <li
            class="list-group-item d-flex justify-content-between align-items-center stat-card-new"
          >
            Webinar: Pengembangan Diri dan Minat Bakat
            <span class="badge badge-primary badge-pill"
              >5 Nov <i class="fas fa-calendar"></i
            ></span>
          </li>

          <li
            class="list-group-item d-flex justify-content-between align-items-center stat-card-new"
          >
            Kuis Akhir Semester
            <span class="badge badge-primary badge-pill"
              >10 Nov <i class="fas fa-calendar"></i
            ></span>
          </li>

          <li
            class="list-group-item d-flex justify-content-between align-items-center stat-card-new"
          >
            Workshop: Tips soal-soal SNBP
            <span class="badge badge-primary badge-pill"
              >15 Nov <i class="fas fa-calendar"></i
            ></span>
          </li>
        </ul>

        <!-- Bagian HTML di dashboard.html -->
        <div class="dashboard-container">
          <h2>Hasil Kuis Terakhir</h2>
          <div class="stats-overview">
              <div>
                  <span>Total Benar: <span id="correctCount">0</span></span><br />
                  <span>Total Salah: <span id="incorrectCount">0</span></span>
              </div>
              <div id="percentage"></div>
          </div>
          <div id="quizHistory"></div>
      </div>
      </div>
    </div>

    <footer class="footer">
      &copy; 2024 Ambis Belajar. Semua hak dilindungi.
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
      // Cek status mode saat halaman pertama kali dimuat
      document.addEventListener("DOMContentLoaded", function () {
        // Periksa mode dari localStorage
        const savedTheme = localStorage.getItem("theme");

        if (savedTheme === "dark") {
          document.body.classList.add("dark-mode"); // Aktifkan dark mode jika tersimpan
          document.getElementById("themeIcon").classList.add("fa-sun");
          document.getElementById("themeIcon").classList.remove("fa-moon");
        } else {
          document.body.classList.remove("dark-mode"); // Tetap di light mode jika tidak ada setting
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

      // Data riwayat statistik untuk setiap kartu
      const statHistory = {
        "Materi Dibaca":
          "Anda telah membaca total 34 materi, dengan peningkatan konsistensi membaca 40% dalam minggu terakhir.",
        "Kuis Diselesaikan":
          "Anda telah menyelesaikan 25 kuis dengan skor rata-rata 85%, dan peningkatan skor pada kuis terakhir sebesar 20%.",
        "XP Terkumpul":
          "XP Anda saat ini adalah 600, yang diraih dari kuis dan membaca materi.",
        Achievement:
          "Anda telah meraih 8 achievement, termasuk 'Pembaca Aktif' dan 'Penakluk Kuis'.",
        "Streak Hari Belajar":
          "Anda memiliki 18 hari berturut-turut belajar. Pertahankan streak untuk mendapatkan bonus XP!",
        "Total Point":
          "Anda telah mengumpulkan 2500 poin total dari semua aktivitas pembelajaran Anda.",
      };

      // Fungsi untuk menampilkan pop-up
      function openPopup(title) {
        document.getElementById("popup-modal").style.display = "block";
        document.getElementById("popup-title").innerText = title;
        document.getElementById("popup-content").innerText = statHistory[title];
      }

      // Fungsi untuk menutup pop-up
      function closePopup() {
        document.getElementById("popup-modal").style.display = "none";
      }

      // Tambahkan event listener ke setiap kartu statistik
      document.querySelectorAll(".stat-card").forEach((card) => {
        card.addEventListener("click", function () {
          const title = card.querySelector(".stat-title").innerText;
          openPopup(title);
        });
      });

      // Pastikan kode ini dijalankan setelah halaman sepenuhnya dimuat
      document.addEventListener("DOMContentLoaded", function () {
        const resultData = localStorage.getItem("quizResult");

        if (resultData) {
          const hasil = JSON.parse(resultData);

          // Update nilai di dashboard
          document.getElementById("correctCount").textContent =
            hasil.correctCount;
          document.getElementById("incorrectCount").textContent =
            hasil.incorrectCount;

          // Hitung persentase jika elemen ada
        if (document.getElementById("percentage")) {
          const total = hasil.correctCount + hasil.incorrectCount;
          const persentase = ((hasil.correctCount / total) * 100).toFixed(1);
          document.getElementById("percentage").textContent = `Persentase Benar: ${persentase}%`; // Fixed template literals
        }

        // Update total jawaban jika elemen ada
        if (document.getElementById("totalAnswered")) {
          const total = hasil.correctCount + hasil.incorrectCount;
          document.getElementById("totalAnswered").textContent = `Total Soal Dijawab: ${total}`; // Fixed template literals
        }

        } else {
          // Jika tidak ada data
          document.getElementById("correctCount").textContent = "0";
          document.getElementById("incorrectCount").textContent = "0";
          if (document.getElementById("percentage")) {
            document.getElementById("percentage").textContent =
              "Belum ada data";
          }
          if (document.getElementById("totalAnswered")) {
            document.getElementById("totalAnswered").textContent =
              "Belum ada data";
          }
        }
      });
    </script>
  </body>
</html>
