<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forum Diskusi - Study Stream</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap");
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

      /* Default ke tema terang */
      body {
        background: var(--light-secondary-bg);
        color: var(--light-text);
        font-family: var(--font-utama);
      }

      /* Warna dan gaya untuk tema gelap */
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

      .forum-container {
        max-width: 720px;
        margin: 2rem auto;
        padding: 2rem;
        background: var(--light-bg);
        border-radius: 20px;
      }

      .dark-mode .forum-container {
        background: var(--dark-bg);
      }

      .comment-box {
        width: 100%;
        padding: 0.75rem;
        margin-top: 1rem;
        border-radius: 10px;
        resize: none;
        font-size: 1rem;
        background: var(--light-secondary-bg);
      }

      .dark-mode .comment-box {
        background: rgba(255, 255, 255, 0.1);
        color: var(--dark-text);
      }

      .post-btn {
        background: var(--primary-color);
        color: var(--dark-text);
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background 0.3s ease;
        margin-top: 0.5rem;
        text-align: right;
        transition: 0.3s all ease;
      }

      .post-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 68, 255, 0.3);
      }

      .comments-section {
        margin-top: 2rem;
        border-top: 1px solid var(--light-text);
        padding-top: 1rem;
      }

      .dark-mode .comments-section {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
      }

      .comment {
        padding: 0.75rem;
        background: var(--light-accent);
        border-radius: 10px;
        margin-bottom: 0.5rem;
      }

      .dark-mode .comment {
        background: rgba(255, 255, 255, 0.1);
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="#">
        <i class="fas fa-comments"></i> Forum Diskusi
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

    <div class="forum-container">
      <h3 class="text-center">Forum Diskusi: Framework React JS</h3>
      <textarea
        id="commentBox"
        class="comment-box"
        rows="3"
        placeholder="Tulis komentar Anda..."
      ></textarea>
      <button class="post-btn" onclick="postComment()">
        <i class="fas fa-paper-plane"></i>
      </button>

      <div class="comments-section" id="commentsSection">
        <!-- Komentar akan ditampilkan disini -->
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

      // Post Comment
      function postComment() {
        const commentBox = document.getElementById("commentBox");
        const commentText = commentBox.value.trim();

        if (commentText) {
          const commentSection = document.getElementById("commentsSection");
          const commentDiv = document.createElement("div");
          commentDiv.classList.add("comment");
          commentDiv.textContent = commentText;

          commentSection.appendChild(commentDiv);
          commentBox.value = "";
        } else {
          alert("Komentar tidak boleh kosong!");
        }
      }

      document
        .getElementById("commentBox")
        .addEventListener("keydown", function (event) {
          if (event.key === "Enter" && !event.shiftKey) {
            event.preventDefault(); 
            postComment(); 
          }
        });
    </script>
  </body>
</html>