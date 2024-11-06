<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$alert_message = '';
$alert_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('config.php');
    
    // Validasi input
    $username = filter_var($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $alert_message = "Username dan password harus diisi!";
        $alert_type = "error";
    } else {
        try {
            // Query untuk memeriksa username
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // Periksa password
                if (password_verify($password, $user['password'])) {
                    // Login berhasil
                    $_SESSION['login'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['level'] = $user['level'];
                    
                    // Redirect berdasarkan level
                    switch ($user['level']) {
                        case 'SMP':
                            header("Location: dashboard_smp.php");
                            break;
                        case 'SMA':
                            header("Location: dashboard_sma.php");
                            break;
                        case 'Mahasiswa':
                            header("Location: dashboard_mahasiswa.php");
                            break;
                        case 'Super Admin':
                            header("Location: dashboard.php");
                            break;
                        default:
                            $alert_message = "Level pengguna tidak valid!";
                            $alert_type = "error";
                            exit();
                    }
                    exit(); // Pastikan exit untuk menghentikan eksekusi setelah redirect
                } else {
                    $alert_message = "Password salah!";
                    $alert_type = "error";
                }
            } else {
                $alert_message = "Username salah atau belum terdaftar";
                $alert_type = "error";
            }
        } catch (PDOException $e) {
            $alert_message = "Terjadi kesalahan: " . $e->getMessage();
            $alert_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Ambis Belajar</title>
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

    <style>
        :root {
  --primary-color: #4e44ff;
  --secondary-color: #6c63ff;
  --accent-color: #ff6b6b;
  --dark-bg: #1a1a2e;
  --light-bg: #25274d;
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
  background: var(--light-theme-bg);
  font-family: "Segoe UI", sans-serif;
  position: relative;
  overflow: hidden;
}

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
  width: 100px;
  height: 100px;
  top: 10%;
  left: 10%;
  animation-delay: 0s;
}
.shape2 {
  width: 150px;
  height: 150px;
  top: 70%;
  left: 80%;
  animation-delay: -5s;
}
.shape3 {
  width: 80px;
  height: 80px;
  top: 40%;
  left: 60%;
  animation-delay: -2s;
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

.login-container {
  width: 100%;
  max-width: 450px;
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

.login-container::before {
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

.login-container:hover {
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
  content: "📚";
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
  padding: 0.75rem 1rem;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(78, 68, 255, 0.2);
}

.forgot-password a {
  color: var(--primary-color);
  font-weight: 600;
  text-decoration: none;
  position: relative;
}

.unready-have-account {
  text-align: center;
  margin-top: 2rem;
  color: #4a5568;
}

.unready-have-account a {
  color: var(--primary-color);
  font-weight: 600;
  text-decoration: none;
  position: relative;
}

.unready-have-account a::after {
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

.unready-have-account a:hover::after {
  transform: scaleX(0.75);
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

.social-login {
  margin: 2rem 0;
  position: relative;
  text-align: center;
  color: #4a5568;
}

.social-login::before,
.social-login::after {
  content: "";
  position: absolute;
  top: 15%;
  width: 27.5%;
  height: 1px;
  background: #4a5568;
}

.social-login::before {
  left: 0;
}
.social-login::after {
  right: 0;
}

.social-login .social-icons {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-top: 20px;
}

.social-login .social-icon {
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  background-color: #e2e8f0;
  transition: all 0.3s ease;
  color: white;
  text-decoration: none;
}

.social-login .social-icon.google {
  background-color: #db4437;
}
.social-login .social-icon.facebook {
  background-color: #3b5998;
}
.social-login .social-icon.twitter {
  background-color: #1da1f2;
}

.social-login .social-icon:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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

@media (max-width: 576px) {
  .login-container {
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

    <div class="login-container">
      <h2 class="form-title">Ambis Belajar</h2>
        
<form action="" method="POST">
    <div class="form-group">
        <label for="username">Username</label>
        <input
            type="text"
            class="form-control"
            name="username"
            required
            placeholder="Masukkan Username kamu"
        />
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input
            type="password"
            class="form-control"
            name="password"
            required
            placeholder="Masukkan password kamu"
        />
    </div>
    <div>
        <p class="forgot-password">
            <a href="forgot.php">Lupa password?</a>
        </p>
    </div>
    <button type="submit" name="login" class="btn btn-primary btn-block">
        Masuk
    </button>

    <div>
        <p class="unready-have-account">
            Belum memiliki akun? <a href="register.php">Daftar disini</a>
        </p>
    </div>

    <div class="social-login">
        <p class="mb-3">atau masuk dengan</p>
        <div class="social-icons">
            <a href="#" class="social-icon google">
                <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon twitter">
                <i class="fab fa-twitter"></i>
            </a>
        </div>
    </div>
</form>
      <div class="footer-text">
        <p>© 2024 Ambis Belajar. All rights reserved.</p>
      </div>
    </div>
  </body>
</html>