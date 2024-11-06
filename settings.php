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

// Handle update pengaturan notifikasi
if(isset($_POST['update_notifications'])) {
    $email_notif = isset($_POST['email_notifications']) ? 1 : 0;
    $push_notif = isset($_POST['push_notifications']) ? 1 : 0;
    
    $stmt = $pdo->prepare("UPDATE user_settings SET email_notifications = ?, push_notifications = ? WHERE user_id = ?");
    try {
        $stmt->execute([$email_notif, $push_notif, $user_id]);
        $message = '<div class="alert alert-success">Pengaturan notifikasi berhasil diperbarui!</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-danger">Gagal memperbarui pengaturan notifikasi.</div>';
    }
}

// Handle update tema
if(isset($_POST['update_theme'])) {
    $theme = $_POST['theme_preference'];
    
    $stmt = $pdo->prepare("UPDATE user_settings SET theme = ? WHERE user_id = ?");
    try {
        $stmt->execute([$theme, $user_id]);
        $message = '<div class="alert alert-success">Tema berhasil diperbarui!</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-danger">Gagal memperbarui tema.</div>';
    }
}

// Handle update bahasa
if(isset($_POST['update_language'])) {
    $language = $_POST['language_preference'];
    
    $stmt = $pdo->prepare("UPDATE user_settings SET language = ? WHERE user_id = ?");
    try {
        $stmt->execute([$language, $user_id]);
        $message = '<div class="alert alert-success">Bahasa berhasil diperbarui!</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-danger">Gagal memperbarui bahasa.</div>';
    }
}

// Ambil pengaturan user saat ini
$stmt = $pdo->prepare("SELECT * FROM user_settings WHERE user_id = ?");
$stmt->execute([$user_id]);
$settings = $stmt->fetch();

// Jika belum ada pengaturan, buat default
if (!$settings) {
    $stmt = $pdo->prepare("INSERT INTO user_settings (user_id, email_notifications, push_notifications, theme, language) VALUES (?, 1, 1, 'light', 'id')");
    $stmt->execute([$user_id]);
    $settings = [
        'email_notifications' => 1,
        'push_notifications' => 1,
        'theme' => 'light',
        'language' => 'id'
    ];
}

$dashboard_url = getDashboardByLevel($_SESSION['level']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Ambisi Belajar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <!-- Tombol kembali -->
        <div class="mb-4">
            <a href="<?php echo $dashboard_url; ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <?php echo $message; ?>

        <!-- Tampilkan level/role user -->
        <div class="alert alert-info mb-4">
            Level Akun: <?php echo htmlspecialchars($_SESSION['level']); ?>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Pengaturan Notifikasi -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bell"></i> Pengaturan Notifikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="emailNotif" 
                                       name="email_notifications" <?php echo $settings['email_notifications'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="emailNotif">Notifikasi Email</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="pushNotif" 
                                       name="push_notifications" <?php echo $settings['push_notifications'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="pushNotif">Notifikasi Push</label>
                            </div>
                            <button type="submit" name="update_notifications" class="btn btn-primary">Simpan Pengaturan Notifikasi</button>
                        </form>
                    </div>
                </div>

                <!-- Pengaturan Tema -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-palette"></i> Pengaturan Tema
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <select class="form-select" name="theme_preference">
                                    <option value="light" <?php echo $settings['theme'] === 'light' ? 'selected' : ''; ?>>Light Mode</option>
                                    <option value="dark" <?php echo $settings['theme'] === 'dark' ? 'selected' : ''; ?>>Dark Mode</option>
                                    <option value="system" <?php echo $settings['theme'] === 'system' ? 'selected' : ''; ?>>System Default</option>
                                </select>
                            </div>
                            <button type="submit" name="update_theme" class="btn btn-primary">Simpan Tema</button>
                        </form>
                    </div>
                </div>

                <!-- Pengaturan Bahasa -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-language"></i> Pengaturan Bahasa
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <select class="form-select" name="language_preference">
                                    <option value="id" <?php echo $settings['language'] === 'id' ? 'selected' : ''; ?>>Bahasa Indonesia</option>
                                    <option value="en" <?php echo $settings['language'] === 'en' ? 'selected' : ''; ?>>English</option>
                                </select>
                            </div>
                            <button type="submit" name="update_language" class="btn btn-primary">Simpan Bahasa</button>
                        </form>
                    </div>
                </div>

                <!-- Informasi Akun -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle"></i> Informasi Akun
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Level Akun:</strong> <?php echo htmlspecialchars($_SESSION['level']); ?></p>
                        <p><strong>Status:</strong> <span class="badge bg-success">Aktif</span></p>
                        <p><strong>Terakhir Login:</strong> <?php echo date('d M Y H:i'); ?></p>
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="profile.php" class="btn btn-outline-primary">
                                <i class="fas fa-user-edit"></i> Edit Profil
                            </a>
                            <a href="logout.php" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>