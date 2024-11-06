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
            <a class="nav-link" href="dashboard_mahasiswa.php"
              ><i class="fas fa-home"></i> Home</a
            >
          </li>
          <li class="nav-item">
            <a class="nav-link" href="setting_mahasiswa.php"
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

    <div class="main-container">
      <div class="profile-header">
        <div class="profile-picture-container">
          <div class="profile-picture">
            <img
              src="https://cdn.idntimes.com/content-images/community/2024/03/snapinstaapp-431777785-998355464994256-8145634998698151039-n-1080-d0a1c20114a30bbb3b60a40cca6b5170-ef72f892656c3e449ac0ad1028f02ad3.jpg"
              alt="Foto Profil"
            />
          </div>
          <div class="profile-edit">
            <a href="setting.php">Edit</a>
          </div>
        </div>
        <div class="profile-info">
          <h3><?php echo $user['username'];?></h3>
          <p class="subtitle">
            Role: <?php echo $user['level']; ?> <br />
            Email: <?php echo $user['email']; ?> <br />
            Status: Online <span class="online-indicator"></span>
          </p>

          <div class="tags">
            <span class="tag">Teknologi</span>
            <span class="tag">Inovasi</span>
            <span class="tag">Pendidikan</span>
          </div>
          <div class="social-links">
            <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </div>

      <div class="bio-container" id="bioContent">
        <h5>Bio</h5>
        <div class="topic-description">
          <p id="textContent" class="collapsed">
            Saya adalah seorang mahasiswa yang antusias belajar teknologi web development. Ia memiliki ketertarikan yang mendalam terhadap pembuatan website dan aplikasi, serta senang mempelajari berbagai bahasa pemrograman dan framework yang digunakan dalam pengembangan web. Dalam perjalanannya, Ibnu sering terlibat dalam proyek-proyek kelompok, di mana ia dapat menerapkan pengetahuan yang didapatkan di kelas dan berkolaborasi dengan teman-temannya untuk menciptakan solusi inovatif. <br /><br />
            Dengan semangat belajar yang tinggi, saya terus memperdalam pemahaman tentang HTML, CSS, JavaScript, dan berbagai library modern lainnya. Saya percaya bahwa penguasaan teknologi web adalah kunci untuk menghadapi tantangan di dunia digital yang terus berkembang. Melalui eksperimen dan latihan praktis, Ibnu berkomitmen untuk menjadi pengembang web yang handal dan siap untuk berkontribusi dalam industri teknologi.
          </p>
          <a id="toggleButton">Baca Selengkapnya</a>
        </div>
      </div>

      <div class="stats-container">
        <div class="stat-box">
          <div class="stat-number">5</div>
          <div class="stat-label">Kursus Diselesaikan</div>
        </div>
        <div class="stat-box">
          <div class="stat-number">120</div>
          <div class="stat-label">Jam Belajar</div>
        </div>
        <div class="stat-box">
          <div class="stat-number">15</div>
          <div class="stat-label">Proyek</div>
        </div>
        <div class="stat-box">
          <div class="stat-number">300</div>
          <div class="stat-label">Pengikut</div>
        </div>
      </div>

      <div class="progress-section">
        <h5 class="progress-title">Kemajuan Belajar</h5>
        <div class="progress-bar">
          <div class="progress-bar-inner" style="width: 70%">70%</div>
        </div>
        <div class="progress-bar">
          <div class="progress-bar-inner" style="width: 85%">85%</div>
        </div>
        <div class="progress-bar">
          <div class="progress-bar-inner" style="width: 60%">60%</div>
        </div>
      </div>

      <div class="achievement-grid">
        <div class="achievement-card">
          <div class="achievement-icon"><i class="fas fa-trophy"></i></div>
          <div class="achievement-info">
            <h4>Pemenang Hackathon</h4>
            <p>Juara pertama dalam hackathon nasional.</p>
          </div>
        </div>
        <div class="achievement-card">
          <div class="achievement-icon"><i class="fas fa-certificate"></i></div>
          <div class="achievement-info">
            <h4>Sertifikat Kursus</h4>
            <p>Menyelesaikan kursus di bidang Data Science.</p>
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
