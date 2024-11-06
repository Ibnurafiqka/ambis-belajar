<?php
session_start();
include('config.php');

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Cek apakah level user valid
$allowed_levels = ['SMP', 'SMA', 'Mahasiswa', 'Superadmin'];
if (!in_array($_SESSION['level'], $allowed_levels)) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Fungsi untuk mendapatkan redirect dashboard berdasarkan level
function getDashboardByLevel($level) {
    switch($level) {
        case 'SMP':
            return 'dashboard_smp.php';
        case 'SMA':
            return 'dashboard_sma.php';
        case 'Mahasiswa':
            return 'dashboard_mahasiswa.php';
        case 'Superadmin':
            return 'dashboard_admin.php';
        default:
            return 'login.php';
    }
}
$user = [
    'username' => 'yuni',   // Nama pengguna yang login
    'role' => 'SMA'         // Peran pengguna yang login
];

// Tambahkan tombol kembali ke dashboard sesuai role
$dashboard_url = getDashboardByLevel($_SESSION['level']);
?>




<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengaturan - Ambis Belajar</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
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
        --dark-bg: #1a1a2e;
        --dark-secondary-bg: #25274d;
        --dark-theme-bg: linear-gradient(
          135deg,
          var(--dark-bg) 0%,
          var(--dark-secondary-bg) 100%
        );
        --dark-text: #ffffff;

        /* Tema Terang */
        --light-bg: #f0f0f3;
        --light-secondary-bg: #e8eaf6;
        --light-accent: #b8c1ec;
        --light-text: #4a4a4a;
        --light-border: #d1d1e0;
        --highlight-color: #009688;
        --light-theme-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --correct-color: #48bb78;
        --incorrect-color: #ff6b6b;
      }

      body {
        background: var(--dark-bg);
        font-family: var(--font-utama);
        color: var(--dark-text);
        transition: all 0.3s ease;
        min-height: 100vh;
      }

      .navbar {
        background: rgba(26, 26, 46, 0.95);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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

      .settings-layout {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 2rem;
        margin: 2rem auto;
        max-width: 1400px;
        padding: 0 2rem;
      }

      .settings-sidebar {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 1.5rem;
        height: fit-content;
        position: sticky;
        top: 2rem;
      }

      .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
      }

      .sidebar-menu li {
        margin-bottom: 0.5rem;
      }

      .sidebar-menu a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: var(--dark-text);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
      }

      .sidebar-menu a:hover,
      .sidebar-menu a.active {
        background: var(--primary-color);
        color: white;
      }

      .settings-content {
        display: grid;
        gap: 2rem;
      }

      .settings-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 2rem;
        transition: transform 0.3s ease;
      }

      .settings-card:hover {
        transform: translateY(-5px);
      }

      .settings-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
      }

      .settings-header i {
        font-size: 2rem;
        color: var(--primary-color);
      }

      .settings-header h2 {
        margin: 0;
        font-weight: 600;
        color: var(--primary-color);
      }

      .form-group {
        margin-bottom: 1.5rem;
      }

      .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--dark-text);
        border-radius: 8px;
        padding: 0.75rem 1rem;
      }

      .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: var(--primary-color);
        color: var(--dark-text);
        box-shadow: 0 0 0 2px rgba(78, 68, 255, 0.2);
      }

      .btn-primary {
        background: var(--primary-color);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
      }

      .btn-primary:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
      }

      .btn-danger {
        margin-bottom: 1.5rem;
      }

      .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
      }

      .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 5px solid var(--secondary-color); /* Border putih melingkar */
        overflow: hidden; /* Menghindari gambar melampaui batas lingkaran */
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .profile-avatar img {
        width: 100%; /* Mengisi lebar lingkaran */
        height: 100%; /* Mengisi tinggi lingkaran */
        object-fit: cover; /* Menjaga proporsi gambar */
      }

      .avatar-upload {
        position: absolute;
        bottom: 0;
        right: 0;
        background: rgba(
          0,
          0,
          0,
          0.7
        ); /* Latar belakang semi-transparan untuk ikon upload */
        border-radius: 50%;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .profile-info {
        margin-left: 20px; /* Jarak antara avatar dan informasi profil */
      }

      .avatar-upload:hover {
        transform: scale(1.1);
      }

      .profile-info h3 {
        margin: 0;
        font-weight: 600;
      }

      .profile-info p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0.5rem 0;
      }

      .toggle-switch {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
      }

      .toggle-switch .slider {
        width: 48px;
        height: 24px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 24px;
        position: relative;
        transition: all 0.3s ease;
      }

      .toggle-switch .slider:before {
        content: "";
        position: absolute;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: white;
        top: 3px;
        left: 3px;
        transition: all 0.3s ease;
      }

      .toggle-switch input:checked + .slider {
        background: var(--primary-color);
      }

      .toggle-switch input:checked + .slider:before {
        transform: translateX(24px);
      }

      .notification-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        margin-bottom: 1rem;
      }

      .notification-info {
        display: flex;
        align-items: center;
        gap: 1rem;
      }

      .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
      }

      /* Light Mode Styles */
      body.light-mode {
        background: var(--light-secondary-bg);
        color: var(--light-text);
      }

      .light-mode .sidebar-menu a.active {
        color: var(--dark-text);
      }

      .light-mode .profile-info p {
        color: var(--light-text);
      }

      .light-mode .settings-card,
      .light-mode .settings-sidebar {
        background: var(--light-bg);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }

      .light-mode .sidebar-menu a {
        color: var(--light-text);
      }

      .light-mode .sidebar-menu a:hover {
        color: var(--dark-text);
      }

      .light-mode .form-control {
        background: var(--light-secondary-bg);
        border-color: var(--light-border);
        color: var(--light-text);
      }

      .light-mode .notification-item {
        background: var(--light-bg);
      }

      .light-mode .toggle-switch .slider {
        background: var(--light-accent);
      }

      .light-mode .navbar {
        background: var(--light-bg);
        border-bottom: 1px solid var(--light-border);
      }

      .light-mode .navbar-nav .nav-link {
        color: var(--light-text);
      }

      .light-mode .navbar-nav .nav-link:hover {
        color: var(--primary-color);
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="#">
        <i class="fas fa-cog"></i> Pengaturan
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
            <a class="nav-link" href="profile_mahasiswa.php"
              ><i class="fas fa-user"></i> Profile</a
            >
          </li>
        </ul>
      </div>
    </nav>

    <!-- Settings Layout -->
    <div class="settings-layout">
      <!-- Sidebar -->
      <div class="settings-sidebar">
        <ul class="sidebar-menu">
          <li>
            <a href="#profile" class="active">
              <i class="fas fa-user"></i>
              Profil
            </a>
          </li>
          <li>
            <a href="#security">
              <i class="fas fa-shield-alt"></i>
              Keamanan
            </a>
          </li>
          <li>
            <a href="#notifications">
              <i class="fas fa-bell"></i>
              Notifikasi
            </a>
          </li>
          <li>
            <a href="#appearance">
              <i class="fas fa-paint-brush"></i>
              Tampilan
            </a>
          </li>
          <li>
            <a href="#privacy">
              <i class="fas fa-lock"></i>
              Privasi
            </a>
          </li>
          <li>
            <a href="#connected">
              <i class="fas fa-link"></i>
              Akun Terhubung
            </a>
          </li>
        </ul>
      </div>

      <!-- Content -->
      <div class="settings-content">
        <!-- Profile Section -->
        <div class="settings-card" id="profile">
          <div class="settings-header">
            <i class="fas fa-user-circle"></i>
            <h2>Profil Saya</h2>
          </div>

          <div class="profile-header">
            <div class="profile-avatar">
              <img
                src="https://cdn.idntimes.com/content-images/community/2024/03/snapinstaapp-431777785-998355464994256-8145634998698151039-n-1080-d0a1c20114a30bbb3b60a40cca6b5170-ef72f892656c3e449ac0ad1028f02ad3.jpg"
                alt="Profile Picture"
              />
              <div class="avatar-upload">
                <i class="fas fa-camera"></i>
              </div>
            </div>
            <div class="profile-info">
              <h3>John Doe</h3>
              <p>Bergabung sejak Januari 2024</p>
              <p>Status: Mahasiswa</p>
            </div>
          </div>

          <form>
            <div class="form-group">
              <label for="username">Nama Pengguna</label>
              <input
                type="text"
                class="form-control"
                id="username"
                value="johndoe123"
              />
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input
                type="email"
                class="form-control"
                id="email"
                value="john@example.com"
              />
            </div>
            <div class="form-group">
              <label for="bio">Bio</label>
              <textarea class="form-control" id="bio" rows="3">
Seorang pelajar yang antusias dalam bidang teknologi dan pendidikan.
              </textarea>
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save mr-2"></i>
              Simpan Perubahan
            </button>
          </form>
        </div>

        <!-- Security Section -->
        <div class="settings-card" id="security">
          <div class="settings-header">
            <i class="fas fa-shield-alt"></i>
            <h2>Keamanan</h2>
          </div>
          <form>
            <div class="form-group">
              <label for="currentPassword">Password Saat Ini</label>
              <input
                type="password"
                class="form-control"
                id="currentPassword"
              />
            </div>
            <div class="form-group">
              <label for="newPassword">Password Baru</label>
              <input type="password" class="form-control" id="newPassword" />
            </div>
            <div class="form-group">
              <label for="confirmPassword">Konfirmasi Password</label>
              <input
                type="password"
                class="form-control"
                id="confirmPassword"
              />
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-key mr-2"></i>
              Perbarui Password
            </button>
          </form>
        </div>

        <!-- Notifications Section -->
        <div class="settings-card" id="notifications">
          <div class="settings-header">
            <i class="fas fa-bell"></i>
            <h2>Notifikasi</h2>
          </div>

          <div class="notification-item">
            <div class="notification-info">
              <div class="notification-icon">
                <i class="fas fa-envelope"></i>
              </div>
              <div>
                <h5>Email Notifikasi</h5>
                <p>Terima notifikasi terkait pembaruan akun melalui email</p>
              </div>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" checked />
              <span class="slider"></span>
            </label>
          </div>

          <div class="notification-item">
            <div class="notification-info">
              <div class="notification-icon">
                <i class="fas fa-comment-dots"></i>
              </div>
              <div>
                <h5>Pesan Pribadi</h5>
                <p>Aktifkan notifikasi untuk pesan baru di kotak masuk Anda</p>
              </div>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" checked />
              <span class="slider"></span>
            </label>
          </div>
        </div>

        <!-- Appearance Section -->
        <div class="settings-card" id="appearance">
          <div class="settings-header">
            <i class="fas fa-paint-brush"></i>
            <h2>Tampilan</h2>
          </div>
          <label class="toggle-switch">
            <input type="checkbox" id="themeSwitch" />
            <span class="slider"></span>
          </label>
          <label for="themeSwitch">Mode Gelap</label>
        </div>

        <!-- Privacy Section -->
        <div class="settings-card" id="privacy">
          <div class="settings-header">
            <i class="fas fa-lock"></i>
            <h2>Privasi</h2>
          </div>

          <div class="form-group">
            <label class="toggle-switch">
              <input type="checkbox" checked />
              <span class="slider"></span>
            </label>
            <label>Profil Publik</label>
            <p>Izinkan pengguna lain untuk melihat profil Anda.</p>
          </div>

          <div class="form-group">
            <label class="toggle-switch">
              <input type="checkbox" />
              <span class="slider"></span>
            </label>
            <label>Histori Aktivitas</label>
            <p>Simpan histori aktivitas Anda di akun ini.</p>
          </div>

          <div class="form-group">
            <label class="toggle-switch">
              <input type="checkbox" />
              <span class="slider"></span>
            </label>
            <label>Lokasi</label>
            <p>Bagikan lokasi Anda untuk pengalaman yang lebih baik.</p>
          </div>
        </div>

        <!-- Connected Accounts Section -->
        <div class="settings-card" id="connected">
          <div class="settings-header">
            <i class="fas fa-link"></i>
            <h2>Akun Terhubung</h2>
          </div>

          <div class="connected-account">
            <div class="notification-info">
              <div class="notification-icon" style="background: #db4437">
                <i class="fab fa-google"></i>
              </div>
              <div>
                <h5>Google</h5>
                <p>Tersambung ke akun Google Anda</p>
              </div>
            </div>
            <button class="btn btn-danger">
              <i class="fas fa-unlink mr-2"></i>
              Putuskan Koneksi
            </button>
          </div>

          <div class="connected-account">
            <div class="notification-info">
              <div class="notification-icon" style="background: #3b5998">
                <i class="fab fa-facebook-f"></i>
              </div>
              <div>
                <h5>Facebook</h5>
                <p>Tersambung ke akun Facebook Anda</p>
              </div>
            </div>
            <button class="btn btn-danger">
              <i class="fas fa-unlink mr-2"></i>
              Putuskan Koneksi
            </button>
          </div>

          <div class="connected-account">
            <div class="notification-info">
              <div class="notification-icon" style="background: #000000">
                <i class="fab fa-apple"></i>
              </div>
              <div>
                <h5>Apple</h5>
                <p>Tersambung ke akun Apple Anda</p>
              </div>
            </div>
            <button class="btn btn-primary">
              <i class="fas fa-link mr-2"></i>
              Hubungkan
            </button>
          </div>
        </div>
      </div>
    </div>

    <script>
      // JavaScript untuk mengelola tema
      const themeSwitch = document.getElementById("themeSwitch");
      const body = document.body;

      themeSwitch.addEventListener("change", () => {
        if (themeSwitch.checked) {
          body.classList.remove("light-mode");
        } else {
          body.classList.add("light-mode");
        }
      });

      // Ambil semua link di sidebar
      const menuLinks = document.querySelectorAll(".sidebar-menu a");

      // Tambahkan event listener untuk setiap link
      menuLinks.forEach((link) => {
        link.addEventListener("click", function () {
          // Hapus class 'active' dari semua link
          menuLinks.forEach((link) => link.classList.remove("active"));

          // Tambahkan class 'active' ke link yang diklik
          this.classList.add("active");
        });
      });
    </script>
  </body>
</html>
