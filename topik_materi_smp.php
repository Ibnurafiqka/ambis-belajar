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
            <a class="nav-link" href="materi_smp.php"
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
          <h2>Topik Utama: Aljabar</h2>

          <div class="example-box">
            <h4>Tujuan Pembelajaran:</h4>
            <ul>
              <li>Memahami konsep dasar Aljabar</li>
              <li>Mengenali komponen-komponen penting dalam Aljabar</li>
              <li>Mengaplikasikan pengetahuan dalam studi kasus</li>
            </ul>
          </div>

          <h3>1. Pendahuluan</h3>
          <figure>
            <img src="assets/aljabar.png" alt="aljabar" />
            <figcaption>Gambar 1: Pengenalan aljabar.</figcaption>
          </figure>
          <p>
          Aljabar adalah salah satu cabang matematika yang penting bagi siswa SMP. Aljabar mempelajari cara menggunakan simbol-simbol, seperti huruf, untuk mewakili angka-angka dalam persamaan dan masalah matematika. Dengan aljabar, kita bisa memecahkan berbagai jenis masalah dengan mengganti variabel dengan angka tertentu.

Konsep utama dalam aljabar adalah variabel dan konstanta. Variabel adalah simbol yang mewakili suatu nilai yang dapat berubah, misalnya 
x
x atau 
y
y. Di sisi lain, konstanta adalah nilai tetap yang tidak berubah, seperti 3, -7, atau 0. Dengan menggabungkan variabel dan konstanta, kita dapat membentuk persamaan dan ekspresi aljabar. <br /><br />
Contoh sederhana adalah persamaan 
x
+
5
=
10
x+5=10. Dalam persamaan ini, kita bisa mencari nilai 
x
x yang memenuhi persamaan tersebut. Di aljabar, kita juga belajar berbagai operasi seperti penjumlahan, pengurangan, perkalian, dan pembagian yang melibatkan variabel.

Selain itu, aljabar juga membantu kita dalam memahami hubungan antar bilangan dan memecahkan soal cerita. Dengan aljabar, kita bisa mengembangkan cara berpikir yang lebih logis dan sistematis, yang sangat bermanfaat dalam menyelesaikan berbagai jenis masalah dalam kehidupan sehari-hari.
          </p>

          <h3>2. Konsep Dasar</h3>
          <p>
          Di bagian ini, kita akan membahas beberapa konsep dasar aljabar yang penting dipahami oleh siswa SMP sebelum mulai mempelajari soal-soal yang lebih kompleks. Pertama, kita mengenal variabel, yaitu simbol (biasanya berupa huruf) yang digunakan untuk mewakili angka yang tidak diketahui atau yang bisa berubah. Variabel ini dapat berupa huruf seperti 
x
x atau 
y
y.

Selanjutnya, ada konstanta, yaitu nilai tetap yang tidak berubah, seperti angka 2, 5, atau -3. Dalam aljabar, kita sering membuat ekspresi yang menggabungkan variabel dan konstanta, seperti 
3
x
+
2
3x+2. Ekspresi ini membantu kita dalam memodelkan berbagai situasi dalam bentuk matematika. <br /><br />
Persamaan adalah pernyataan yang menyatakan bahwa dua ekspresi aljabar setara, misalnya 
x
+
5
=
10
x+5=10. Di sini, kita bisa mencari nilai 
x
x yang memenuhi persamaan tersebut. Selain persamaan, kita juga belajar tentang penyederhanaan ekspresi untuk mengurangi bentuk aljabar menjadi lebih sederhana, misalnya dengan menjumlahkan atau mengalikan variabel dan konstanta.

Penting juga memahami konsep pemecahan persamaan, di mana kita mencari nilai variabel yang membuat persamaan benar. Selain itu, kita bisa mempelajari hubungan antara variabel dan bagaimana perubahan satu variabel dapat memengaruhi hasil dari suatu ekspresi.

Dengan memahami konsep-konsep dasar ini, siswa akan lebih siap untuk memecahkan masalah aljabar yang lebih kompleks dan memahami bagaimana aljabar digunakan untuk menyelesaikan berbagai persoalan dalam matematika dan kehidupan sehari-hari.
          </p>

          <div class="example-box">
            <h4>Contoh Penerapan:</h4>
            <p>Berikut adalah contoh penerapan konsep aljabar yang telah dipelajari:</p>
            <ul>
              <li>Contoh 1: Menyederhanakan Ekspresi Aljabar</li>
              <li>Contoh 2: Memecahkan Persamaan Sederhana</li>
              <li>Contoh 3: Latihan Menyusun Persamaan</li>
            </ul>
          </div>

          <h3>3. Rangkuman</h3>
          <p>
          Dalam rangkuman materi aljabar untuk SMP, kita telah membahas beberapa konsep dasar yang penting untuk memahami cara menyelesaikan masalah matematika dengan aljabar. Pertama, kita mengenal variabel sebagai simbol yang mewakili angka yang belum diketahui atau dapat berubah. Variabel ini memudahkan kita dalam menyusun persamaan dan menyelesaikan masalah secara sistematis.

Kita juga belajar tentang konstanta, yang merupakan nilai tetap, serta ekspresi aljabar, yang menggabungkan variabel dan konstanta dalam bentuk penjumlahan, pengurangan, perkalian, atau pembagian. Konsep persamaan juga penting karena digunakan untuk menyatakan hubungan antara dua ekspresi, yang kemudian dapat kita selesaikan untuk menemukan nilai variabel. <br /><br />
Selain itu, kita membahas cara menyederhanakan ekspresi dan memecahkan persamaan sederhana sebagai langkah awal dalam aljabar. Dengan memahami konsep-konsep dasar ini, siswa akan siap untuk memecahkan masalah yang lebih kompleks dan mengembangkan keterampilan berpikir logis yang sangat berguna dalam matematika.

Rangkuman ini menekankan pentingnya konsep aljabar dalam menyelesaikan berbagai jenis persoalan serta penerapannya dalam kehidupan sehari-hari. Dengan fondasi yang kuat dalam konsep-konsep ini, siswa siap melanjutkan pelajaran ke topik-topik aljabar yang lebih lanjut.
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
          window.location.href = "latihan_smp.php";
        });

      document
        .getElementById("backButton")
        .addEventListener("click", function () {
          window.location.href = "materi_smp.php";
        });

      // Content Item Click Logic
      document.querySelectorAll(".content-item").forEach((item) => {
        item.addEventListener("click", function () {
          const section = this.getAttribute("data-section");
          switch (section) {
            case "1":
              window.location.href = "materi_smp.php";
              break;
            case "3":
              window.location.href = "latihan_smp.php";
              break;
            case "4":
              window.location.href = "kuis_smp.php";
              break;
          }
        });
      });
    </script>
  </body>
</html>
