<?php
session_start();
include('config.php');

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'Mahasiswa') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Mengambil kategori diskusi
$stmt_categories = $pdo->prepare("SELECT DISTINCT category_id, name FROM categories ORDER BY name");
$stmt_categories->execute();
$categories = $stmt_categories->fetchAll();

// Mengambil semua diskusi
$stmt_discussions = $pdo->prepare("
    SELECT d.*, u.username, c.name as category_name 
    FROM discussions d 
    JOIN users u ON d.user_id = u.id 
    JOIN categories c ON d.category_id = c.category_id 
    ORDER BY d.created_at DESC
");
$stmt_discussions->execute();
$discussions = $stmt_discussions->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambisi Belajar - Forum Diskusi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .discussion-card {
            transition: transform 0.3s;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .discussion-card:hover {
            transform: translateY(-5px);
        }
        .category-nav {
            padding: 15px;
            border-radius: 10px;
            background-color: #f8f9fa;
            margin-bottom: 20px;
        }
        .category-nav .nav-link {
            color: #495057;
            padding: 8px 16px;
            margin: 5px;
            border-radius: 20px;
        }
        .category-nav .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .card-body p {
            font-size: 0.9rem;
        }
        .create-discussion-btn {
            background-color: #0d6efd;
            color: white;
            border-radius: 50px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap"></i> Ambisi Belajar
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard_mahasiswa.php"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="materi.php"><i class="fas fa-book"></i> Materi Pembelajaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="diskusi.php"><i class="fas fa-comments"></i> Forum Diskusi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="quiz.php"><i class="fas fa-tasks"></i> Quiz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="stream.php"><i class="fas fa-broadcast-tower"></i> Stream</a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($user['username']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="settings.php">Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-comments"></i> Forum Diskusi</h2>
            <a href="create_discussion.php" class="btn create-discussion-btn">
                <i class="fas fa-plus-circle"></i> Buat Diskusi
            </a>
        </div>

        <!-- Category Navigation -->
        <div class="category-nav">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="#semua">Semua Kategori</a>
                </li>
                <?php foreach ($categories as $category): ?>
                <li class="nav-item">
                    <a class="nav-link" href="#category-<?php echo $category['category_id']; ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Discussions Grid -->
        <div class="row g-4">
            <?php foreach ($discussions as $discussion): ?>
            <div class="col-md-6">
                <div class="card discussion-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="discussion_detail.php?id=<?php echo $discussion['id']; ?>" class="text-dark">
                                <?php echo htmlspecialchars($discussion['title']); ?>
                            </a>
                        </h5>
                        <p class="text-muted mb-1"><i class="fas fa-tag"></i> <?php echo htmlspecialchars($discussion['category_name']); ?></p>
                        <p class="card-text mb-3">
                            <?php echo substr(htmlspecialchars($discussion['content']), 0, 100) . '...'; ?>
                        </p>
                        <p class="text-muted mb-0"><small><i class="fas fa-user"></i> <?php echo htmlspecialchars($discussion['username']); ?></small></p>
                        <small class="text-muted"><i class="fas fa-clock"></i> <?php echo date('d M Y', strtotime($discussion['created_at'])); ?></small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
