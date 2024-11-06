<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Cek apakah email ada di database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Buat token untuk reset password
            $token = bin2hex(random_bytes(4)); // Token acak
            $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = NOW() + INTERVAL 1 HOUR WHERE id = ?");
            $stmt->execute([$token, $user['id']]);

            // Kirim email dengan token reset password
            $subject = "Reset Password";
            $message = "Gunakan token berikut untuk mereset password Anda: " . $token;

            if (mail($email, $subject, $message)) {
                echo "<script>alert('Token untuk reset password telah dikirim. Silakan cek email Anda.');</script>";
                $_SESSION['reset_email'] = $email; // Simpan email dalam session untuk memverifikasi token
            } else {
                echo "<script>alert('Gagal mengirim email.');</script>";
            }
        } else {
            echo "<script>alert('Email tidak ditemukan.');</script>";
        }
    } elseif (isset($_POST['token']) && isset($_POST['new_password'])) {
        $token = $_POST['token'];
        $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        // Cek apakah email dalam session dan token valid
        $email = $_SESSION['reset_email'] ?? '';
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND reset_token = ? AND reset_expires > NOW()");
        $stmt->execute([$email, $token]);
        $user = $stmt->fetch();

        if ($user) {
            // Reset password dan hapus token
            $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
            if ($stmt->execute([$newPassword, $user['id']])) {
                echo "<script>alert('Password berhasil direset.'); window.location.href = 'login.php';</script>";
                unset($_SESSION['reset_email']); // Hapus email dari session setelah reset
            } else {
                echo "<script>alert('Terjadi kesalahan saat mengupdate password.');</script>";
            }
        } else {
            echo "<script>alert('Token tidak valid atau telah kedaluwarsa.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #6b86f7, #58d3b8);
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #6b86f7;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #5873d9;
        }
        .link {
            margin-top: 15px;
            text-align: center;
            color: #666;
        }
        .link a {
            color: #6b86f7;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center;">Lupa Password / Reset Password</h2>

        <!-- Form input email -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required><br>
            </div>
            <div class="form-group">
                <input type="submit" value="Kirim Token Reset" class="btn">
            </div>
        </form>

        <!-- Form input token dan password baru -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="token">Token Reset:</label>
                <input type="text" name="token" required><br>
            </div>
            <div class="form-group">
                <label for="new_password">Password Baru:</label>
                <input type="password" name="new_password" required><br>
            </div>
            <div class="form-group">
                <input type="submit" value="Reset Password" class="btn">
            </div>
        </form>

        <div class="link">
            Kembali ke <a href="login.php">Login</a>
        </div>
    </div>
</body>
</html>
