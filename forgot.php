<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Ambis Belajar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --primary-color: #4e44ff;
            --secondary-color: #6c63ff;
            --accent-color: #ff6b6b;
            --dark-bg: #1a1a2e;
            --light-bg: #25274D;
            --light-theme-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            --dark-theme-bg: linear-gradient(135deg, var(--dark-bg) 0%, var(--light-bg) 100%);
            --dark-text: #fff;
            --light-text: #333;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: var(--light-theme-bg);
            font-family: 'Segoe UI', sans-serif;
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

        .shape1 { width: 100px; height: 100px; top: 10%; left: 10%; animation-delay: 0s; }
        .shape2 { width: 150px; height: 150px; top: 70%; left: 80%; animation-delay: -5s; }
        .shape3 { width: 80px; height: 80px; top: 40%; left: 60%; animation-delay: -2s; }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(100px, 100px) rotate(180deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }

        .forgot-password-container {
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

        .forgot-password-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            animation: loading 2s linear infinite;
        }

        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .forgot-password-container:hover {
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
            content: '🔑';
            font-size: 1.5rem;
            margin-left: 10px;
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .form-description {
            text-align: center;
            color: #4a5568;
            margin-bottom: 2rem;
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

        .back-to-login {
            text-align: center;
            margin-top: 2rem;
            color: #4a5568;
        }

        .back-to-login a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            position: relative;
        }

        .back-to-login a::after {
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

        .back-to-login a:hover::after {
            transform: scaleX(1);
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
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

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            color: #4a5568;
        }

        @media (max-width: 576px) {
            .forgot-password-container {
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

    <div class="forgot-password-container">
        <h2 class="form-title">Lupa Password</h2>
        <p class="form-description">Masukkan email yang terdaftar. Kami akan mengirimkan link untuk mengatur ulang password kamu.</p>
        <form id="forgotPasswordForm" action="reset_password_process.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Masukkan email kamu">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset Password</button>
            
            <div>
                <p class="back-to-login">
                    Ingat password? <a href="login.php">Kembali ke login</a>
                </p>
            </div>
        </form>
        <div class="footer-text">
            <p>© 2024 Ambis Belajar. All rights reserved.</p>
        </div>
    </div>
</body>
</html>