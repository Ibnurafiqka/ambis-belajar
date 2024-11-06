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

// Tambahkan tombol kembali ke dashboard sesuai role
$dashboard_url = getDashboardByLevel($_SESSION['level']);

// Handle foto profil upload
if (isset($_FILES['profile_photo'])) {
    $target_dir = "uploads/profile/";
    $file_extension = strtolower(pathinfo($_FILES["profile_photo"]["name"], PATHINFO_EXTENSION));
    $new_filename = $user_id . '_' . time() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;

    // Cek file adalah gambar
    $allowed_types = ['jpg', 'jpeg', 'png'];
    if (in_array($file_extension, $allowed_types)) {
        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            $stmt = $pdo->prepare("UPDATE users SET profile_photo = ? WHERE id = ?");
            $stmt->execute([$new_filename, $user_id]);
            $message = '<div class="alert alert-success">Foto profil berhasil diperbarui!</div>';
        } else {
            $message = '<div class="alert alert-danger">Gagal mengupload foto profil.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Hanya file JPG, JPEG & PNG yang diizinkan.</div>';
    }
}

// Handle update biodata
if (isset($_POST['update_biodata'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $bio = $_POST['bio'];

    $stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, address = ?, bio = ? WHERE id = ?");
    try {
        $stmt->execute([$nama_lengkap, $email, $no_telp, $alamat, $bio, $user_id]);
        $message = '<div class="alert alert-success">Biodata berhasil diperbarui!</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-danger">Gagal memperbarui biodata.</div>';
    }
}

// Handle reset password
if (isset($_POST['reset_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (password_verify($old_password, $user['password'])) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            try {
                $stmt->execute([$hashed_password, $user_id]);
                $message = '<div class="alert alert-success">Password berhasil diubah!</div>';
            } catch (PDOException $e) {
                $message = '<div class="alert alert-danger">Gagal mengubah password.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Password lama tidak sesuai.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Password baru dan konfirmasi tidak cocok.</div>';
    }
}

// Ambil data user
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil - Ambis Belajar</title>
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
        --dark-secondary-bg2: rgba(255, 255, 255, 0.1);
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
        --success-color: #2ecc71;
      }

      body {
        background: var(--light-secondary-bg);
        font-family: "Segoe UI", sans-serif;
        color: #fff;
        margin: 0;
        padding: 0;
      }

      body.dark-mode {
        background: var(--dark-secondary-bg);
      }

      /* Navbar */
      .navbar {
        background: var(--light-bg);
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        padding: 1rem 2rem;
      }

      .dark-mode .navbar {
        background: var(--dark-bg);
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

      .dark-mode .nav-link {
        color: var(--dark-text) !important;
      }

      .nav-link:hover,
      .nav-item.active .nav-link {
        color: var(--primary-color) !important;
      }

      .toggle-theme {
        cursor: pointer;
        font-size: 1.2rem;
      }

      /* Main content */
      .main-container {
        display: flex;
        flex-direction: column;
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
      }

      .profile-header {
        display: flex;
        align-items: flex-start;
        gap: 2rem;
        background: var(--light-bg);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      }

      .dark-mode .profile-header {
        background: var(--dark-bg);
      }

      .profile-picture-container {
        position: relative;
        width: 200px;
        flex-shrink: 0;
      }

      .profile-picture {
        width: 200px;
        height: 200px;
        border-radius: 20px;
        overflow: hidden;
        border: 4px solid var(--secondary-color);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        position: relative;
      }

      .profile-picture img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
      }

      .profile-picture:hover img {
        transform: scale(1.05);
      }

      .profile-edit {
        position: absolute;
        bottom: -10px;
        right: -10px;
        background: var(--secondary-color);
        padding: 0.5rem 1.25rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .profile-edit a {
        color: var(--dark-text);
        text-decoration: none;
      }

      .profile-edit:hover {
        transform: translateY(-3px);
        background: var(--primary-color);
      }

      .profile-info {
        flex-grow: 1;
      }

      .profile-info h3 {
        font-weight: 700;
        font-size: 2.2rem;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
      }

      .profile-info .subtitle {
        color: var(--light-text);
        font-size: 1.2rem;
        margin-bottom: 1rem;
        font-weight: 500;
      }

      .dark-mode .profile-info .subtitle {
        color: var(--dark-text);
      }

      .online-indicator {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: #2ecc71; /* Warna hijau indikator */
        border-radius: 50%; /* Bentuk bulat */
        margin-left: 5px; /* Jarak dari teks */
        vertical-align: middle; /* Posisikan sejajar dengan teks */
        margin-bottom: 0.2rem;
      }

      .bio-container {
        background: var(--light-bg);
        border-radius: 20px;
        padding: 2rem;
        margin: 2rem 0;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      }

      .bio-container h5 {
        color: var(--light-text);
      }

      .dark-mode .bio-container h5 {
        color: var(--dark-text);
      }

      .dark-mode .bio-container {
        background-color: var(--dark-bg);
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

      .topic-description p {
        color: var(--light-text);
      }

      .dark-mode .topic-description p {
        color: var(--dark-text);
      }

      .tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 1rem 0;
      }

      .tag {
        background: var(--light-secondary-bg);
        color: var(--secondary-color);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
      }

      .dark-mode .tag {
        background: var(--dark-secondary-bg2);
        color: var(--secondary-color);
      }

      .social-links {
        margin-top: 1.5rem;
      }

      .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: var(--light-secondary-bg);
        border-radius: 50%;
        margin-right: 1rem;
        color: var(--secondary-color);
        font-size: 1.2rem;
        transition: all 0.3s ease;
        text-decoration: none;
      }

      .dark-mode .social-links a {
        background: rgba(255, 255, 255, 0.1);
      }

      .social-links a:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-3px);
      }

      .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
      }

      .stat-box {
        background: var(--light-bg);
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.3s ease;
      }

      .dark-mode .stat-box {
        background: var(--dark-bg);
      }

      .stat-box:hover {
        transform: translateY(-3px);
      }

      .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
      }

      .stat-label {
        color: var(--light-text);
        font-size: 1rem;
      }

      .dark-mode .stat-label {
        color: var(--dark-text);
      }

      .progress-section {
        background: var(--light-bg);
        border-radius: 20px;
        padding: 2rem;
        margin: 2rem 0;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      }

      .dark-mode .progress-section {
        background: var(--dark-bg);
      }

      .progress-title {
        font-weight: 600;
        color: var(--light-text);
      }

      .dark-mode .progress-title {
        color: var(--dark-text);
      }

      .progress-bar {
        background-color: var(--light-accent);
        border-radius: 25px;
        margin: 1.5rem 0;
      }

      .dark-mode .progress-bar {
        background-color: rgba(255, 255, 255, 0.1);
      }

      .progress-bar-inner {
        background: linear-gradient(
          90deg,
          var(--primary-color),
          var(--secondary-color)
        );
        height: 25px;
        border-radius: 25px;
        transition: width 1s ease;
      }

      .achievement-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
      }

      .achievement-card {
        background: var(--light-bg);
        border-radius: 15px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
      }

      .dark-mode .achievement-card {
        background: var(--dark-bg);
      }

      .achievement-icon {
        font-size: 2rem;
        color: var(--primary-color);
      }
      

      .achievement-info h4 {
        margin: 0;
        color: var(--light-text);
        font-size: 1.1rem;
      }

      .dark-mode .achievement-info h4 {
        color: var(--dark-text);
      }

      .achievement-info p {
        margin: 0.5rem 0 0;
        color: #bbb;
        font-size: 0.9rem;
      }

      @media (max-width: 768px) {
        .profile-header {
          flex-direction: column;
          align-items: center;
        }

        .profile-picture {
          width: 150px;
          height: 150px;
        }

        .profile-info h3 {
          font-size: 1.8rem;
        }

        .profile-info .subtitle {
          font-size: 1rem;
        }
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="#">
        <i class="fas fa-user"></i> Profile
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
            <a class="nav-link" href="dashboard.php"
              ><i class="fas fa-home"></i> Home</a
            >
          </li>
          <li class="nav-item">
            <a class="nav-link" href="setting.php"
              ><i class="fas fa-cog"></i> Pengaturan</a
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
              <h3>johndoe123</h3>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
      // Cek status mode saat halaman pertama kali dimuat
      document.addEventListener("DOMContentLoaded", function () {
        // Periksa mode dari localStorage
        const savedTheme = localStorage.getItem("theme");

        if (savedTheme === "dark") {
          document.body.classList.add("dark-mode");
          document.getElementById("themeIcon").classList.add("fa-moon");
          document.getElementById("themeIcon").classList.remove("fa-sun");
        } else {
          document.body.classList.remove("dark-mode");
          document.getElementById("themeIcon").classList.add("fa-sun");
          document.getElementById("themeIcon").classList.remove("fa-moon");
        }
      });

      // Tombol toggle untuk mengubah mode
      document
        .querySelector(".toggle-theme")
        .addEventListener("click", function () {
          document.body.classList.toggle("dark-mode");

          let themeIcon = document.getElementById("themeIcon");
          themeIcon.classList.toggle("fa-moon");
          themeIcon.classList.toggle("fa-sun");

          // Simpan preferensi ke localStorage
          if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
          } else {
            localStorage.setItem("theme", "light");
          }
        });

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
