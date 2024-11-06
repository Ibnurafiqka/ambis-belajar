<?php
session_start();
include('config.php');

// Variabel untuk menyimpan pesan error
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $level = $_POST['level'];

    // Cek apakah username atau email sudah ada di database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $user = $stmt->fetch();
    
    if ($user) {
        $error_message = "Username atau email sudah terdaftar!";
    } else {
        // Insert pengguna baru jika tidak ada duplikasi
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, level, reset_token, reset_expires) VALUES (?, ?, ?, ?, NULL, NULL)");
        $stmt->execute([$username, $password, $email, $level]);
        
        // Set session untuk pesan sukses
        $_SESSION['register_success'] = true;
        
        echo "success";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Ambis Belajar</title>
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        :root {
  --primary-color: #4e44ff;
  --secondary-color: #6c63ff;
  --accent-color: #ff6b6b;
  --dark-bg: #1a1a2e;
  --light-bg: #25274d;
  --success-color: #3f9b70;
  --light-theme-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  --dark-theme-bg: linear-gradient(
    135deg,
    var(--dark-bg) 0%,
    var(--light-bg) 100%
  );
  --dark-text: #fff;
  --light-text: #333;
}

body {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  /* background: var(--dark-theme-bg); */
  background: var(--light-theme-bg);
  font-family: "Segoe UI", sans-serif;
  position: relative;
  overflow: hidden;
  padding: 2rem 0;
}

/* Animated background elements */
.bg-elements {
  position: fixed;
  width: 100%;
  height: 100%;
  z-index: -1;
}

.floating-shape {
  position: absolute;
  background: rgba(78, 68, 255, 0.1);
  border-radius: 50%;
  animation: float 15s infinite linear;
}

.shape1 {
  width: 120px;
  height: 120px;
  top: 15%;
  left: 15%;
  animation-delay: -2s;
}
.shape2 {
  width: 180px;
  height: 180px;
  top: 60%;
  left: 75%;
  animation-delay: -7s;
}
.shape3 {
  width: 100px;
  height: 100px;
  top: 35%;
  left: 65%;
  animation-delay: -4s;
}

@keyframes float {
  0% {
    transform: translate(0, 0) rotate(0deg);
  }
  50% {
    transform: translate(100px, 100px) rotate(180deg);
  }
  100% {
    transform: translate(0, 0) rotate(360deg);
  }
}

.register-container {
  width: 100%;
  max-width: 500px;
  padding: 2.5rem;
  background: rgba(255, 255, 255, 0.95);
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(10px);
  transform: translateY(0);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.register-container::before {
  content: "";
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 4px;
  background: linear-gradient(
    to right,
    var(--primary-color),
    var(--secondary-color)
  );
  animation: loading 2s linear infinite;
}

@keyframes loading {
  0% {
    left: -100%;
  }
  100% {
    left: 100%;
  }
}

.register-container:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

.form-title {
  text-align: center;
  font-weight: 800;
  margin-bottom: 2rem;
  color: var(--primary-color);
  font-size: 2rem;
  position: relative;
}

.form-title::after {
  content: "🎓";
  font-size: 1.5rem;
  margin-left: 10px;
  animation: bounce 1s infinite;
}

@keyframes bounce {
  0%,
  100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}

.form-group {
  margin-bottom: 1.5rem;
  position: relative;
}

.form-group label {
  font-weight: 600;
  color: #2d3748;
  margin-bottom: 0.5rem;
  display: block;
}

.form-control {
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  /* padding: 0.75rem 1rem; */
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(78, 68, 255, 0.2);
}

.password-toggle {
  position: absolute;
  right: 1rem;
  top: 2.5rem;
  cursor: pointer;
  color: #718096;
}

.progress {
  height: 6px;
  margin-top: 0.5rem;
  border-radius: 3px;
}

.btn-primary {
  background: linear-gradient(
    45deg,
    var(--primary-color),
    var(--secondary-color)
  );
  border: none;
  padding: 0.75rem;
  font-weight: 600;
  border-radius: 10px;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(78, 68, 255, 0.4);
}

.social-register {
  margin: 2rem 0;
  position: relative;
  color: #4a5568;
}

.social-register::before,
.social-register::after {
  content: "";
  position: absolute;
  top: 15%;
  width: 30%;
  height: 1px;
  background: #4a5568;
}

.social-register::before {
  left: 0;
}
.social-register::after {
  right: 0;
}

.social-register button {
  margin-bottom: 1rem;
  border-radius: 50%; /* Ubah menjadi berbentuk lingkaran */
  /* padding: 0.75rem; */
  font-weight: 500;
  transition: all 0.3s ease;
  width: 45px; /* Sesuaikan lebar tombol */
  height: 45px; /* Sesuaikan tinggi tombol */
}

.social-register button:hover {
  transform: translateY(-2px);
}

.footer-text {
  text-align: center;
  margin-top: 2rem;
  color: #4a5568;
}

.footer-text a {
  color: var(--primary-color);
  font-weight: 600;
  text-decoration: none;
  position: relative;
}

.footer-text a::after {
  content: "";
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 100%;
  height: 2px;
  background: var(--primary-color);
  transform: scaleX(0);
  transition: transform 0.3s ease;
}

.footer-text a:hover::after {
  transform: scaleX(1);
}

.animation {
  display: none;
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  background: var(--success-color);
  color: white;
  padding: 1rem 2rem;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  animation: slideDown 0.5s ease;
  z-index: 1000;
}

@keyframes slideDown {
  from {
    transform: translate(-50%, -100%);
  }
  to {
    transform: translate(-50%, 0);
  }
}

.terms-text {
  font-size: 0.9rem;
  color: #718096;
  margin-top: 1rem;
}

.terms-text a {
  color: var(--primary-color);
  text-decoration: none;
}

/* Responsive adjustments */
@media (max-width: 576px) {
  .register-container {
    margin: 1rem;
    padding: 1.5rem;
  }

  .form-title {
    font-size: 1.5rem;
  }
}

    </style>
</head>
<body>
    <div class="bg-elements">
        <div class="floating-shape shape1"></div>
        <div class="floating-shape shape2"></div>
        <div class="floating-shape shape3"></div>
    </div>
    <div class="register-container">
        <h1 class="form-title">Daftar Akun</h1>

        <form id="register-form" method="POST">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" class="form-control" name="username" placeholder="Masukkan nama lengkap" required />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Masukkan email" required />
            </div>
            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" class="form-control" name="password" placeholder="Masukkan kata sandi" required />
                <span class="password-toggle" onclick="togglePasswordVisibility()"><i class="fas fa-eye" id="toggle-icon"></i></span>
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select class="form-control" name="level" required>
                    <option value="Mahasiswa">Mahasiswa</option>
                    <option value="SMA">SMA</option>
                    <option value="SMP">SMP</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </form>
        
        <p class="footer-text">
            Sudah memiliki akun? <a href="login.php">Masuk di sini</a>
        </p>
        <div class="terms-text">
            <p>
                Dengan mendaftar, Anda setuju dengan <a href="#">syarat dan ketentuan</a> kami.
            </p>
        </div>
    </div>
    <div class="animation" id="animation">Pendaftaran berhasil!</div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.querySelector("input[name='password']");
            const toggleIcon = document.getElementById("toggle-icon");
            const isPasswordVisible = passwordInput.type === "text";

            passwordInput.type = isPasswordVisible ? "password" : "text";
            toggleIcon.classList.toggle("fa-eye");
            toggleIcon.classList.toggle("fa-eye-slash");
        }
        document.getElementById("register-form").addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch("register.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === "success") { 
            document.getElementById("animation").style.display = "block";
            setTimeout(() => {
                document.getElementById("animation").style.display = "none";
                window.location = "login.php";
            }, 2000);
            this.reset();
        } else {
            alert("Pendaftaran gagal: " + data);
        }
    })
    .catch(error => console.error("Error:", error));
});

    </script>
</body>
</html>
