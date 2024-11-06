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

$stmt_history = $pdo->prepare("
    SELECT qr.*, q.title as quiz_title, q.duration
    FROM quiz_results qr
    JOIN quiz q ON qr.quiz_id = q.id
    WHERE qr.user_id = ?
    ORDER BY qr.date_taken DESC
");


// Mengambil data quiz yang tersedia
$stmt_available_quiz = $pdo->prepare("
    SELECT q.*, 
           COUNT(qq.id) as total_questions,
           (SELECT COUNT(*) FROM quiz_results WHERE quiz_id = q.id AND user_id = ?) as attempt_count
    FROM quiz q
    LEFT JOIN quiz_questions qq ON q.id = qq.quiz_id
    GROUP BY q.id
    ORDER BY q.created_at DESC
");
$stmt_available_quiz->execute([$user_id]);
$available_quizzes = $stmt_available_quiz->fetchAll();

// Mengambil riwayat quiz yang sudah dikerjakan
$stmt_history = $pdo->prepare("
    SELECT qr.*, q.title as quiz_title, q.duration
    FROM quiz_results qr
    JOIN quiz q ON qr.quiz_id = q.id
    WHERE qr.user_id = ?
    ORDER BY qr.date_taken DESC
");
$stmt_history->execute([$user_id]);
$quiz_history = $stmt_history->fetchAll();

// Menghitung statistik
$total_quizzes = count($quiz_history);
$total_score = 0;
$highest_score = 0;

foreach ($quiz_history as $result) {
    $total_score += $result['score'];
    if ($result['score'] > $highest_score) {
        $highest_score = $result['score'];
    }
}

$average_score = $total_quizzes > 0 ? round($total_score / $total_quizzes, 2) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambisi Belajar - Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .quiz-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .quiz-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .score-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
        }
        .difficulty-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .stats-card {
            border-left: 4px solid;
        }
        .timer-icon {
            color: #6c757d;
            margin-right: 5px;
        }
        .attempt-count {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 0.8rem;
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
                        <a class="nav-link" href="dashboard_mahasiswa.php">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="materi.php">
                            <i class="fas fa-book"></i> Materi Pembelajaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="quiz.php">
                            <i class="fas fa-tasks"></i> Quiz
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="diskusi.php">
                            <i class="fas fa-comments"></i> Forum Diskusi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="stream.php">
                            <i class="fas fa-broadcast-tower"></i> Stream
                        </a>
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
        <div class="row mb-4">
            <div class="col-12">
                <h2><i class="fas fa-tasks"></i> Quiz</h2>
                <p class="text-muted">Uji pemahaman materimu dengan mengerjakan quiz yang tersedia</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stats-card" style="border-left-color: #0d6efd;">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Total Quiz Diselesaikan</h6>
                        <h2 class="mb-0"><?php echo $total_quizzes; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card" style="border-left-color: #198754;">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Rata-rata Nilai</h6>
                        <h2 class="mb-0"><?php echo $average_score; ?>%</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card" style="border-left-color: #ffc107;">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Nilai Tertinggi</h6>
                        <h2 class="mb-0"><?php echo $highest_score; ?>%</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Quizzes -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="mb-3">Quiz yang Tersedia</h4>
                <div class="row g-4">
                    <?php foreach ($available_quizzes as $quiz): ?>
                    <div class="col-md-4">
                        <div class="card quiz-card">
                            <?php if ($quiz['attempt_count'] > 0): ?>
                            <div class="attempt-count badge bg-info">
                                <?php echo $quiz['attempt_count']; ?>x dikerjakan
                            </div>
                            <?php endif; ?>
                            
                            <?php
                            $difficulty_class = '';
                            $difficulty_text = '';
                            switch(strtolower($quiz['difficulty'] ?? 'medium')) {
                                case 'easy':
                                    $difficulty_class = 'bg-success';
                                    $difficulty_text = 'Mudah';
                                    break;
                                case 'medium':
                                    $difficulty_class = 'bg-warning';
                                    $difficulty_text = 'Sedang';
                                    break;
                                case 'hard':
                                    $difficulty_class = 'bg-danger';
                                    $difficulty_text = 'Sulit';
                                    break;
                            }
                            ?>
                            <span class="badge <?php echo $difficulty_class; ?> difficulty-badge">
                                <?php echo $difficulty_text; ?>
                            </span>
                            
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($quiz['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($quiz['description'] ?? ''); ?></p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">
                                        <i class="fas fa-question-circle"></i>
                                        <?php echo $quiz['total_questions']; ?> Pertanyaan
                                    </span>
                                    <span class="text-muted">
                                        <i class="fas fa-clock timer-icon"></i>
                                        <?php echo $quiz['duration']; ?> menit
                                    </span>
                                </div>
                                
                                <div class="d-grid">
                                    <a href="take_quiz.php?id=<?php echo $quiz['id']; ?>" 
                                       class="btn btn-primary">
                                        <i class="fas fa-play-circle"></i> Mulai Quiz
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Quiz History -->
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Riwayat Quiz</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Quiz</th>
                                        <th>Tanggal</th>
                                        <th>Durasi</th>
                                        <th>Nilai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($quiz_history as $history): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($history['quiz_title']); ?></td>
                                        <td><?php echo date('d M Y H:i', strtotime($history['date_taken'])); ?></td>
                                        <td><?php echo $history['duration']; ?> menit</td>
                                        <td>
                                            <div class="score-circle 
                                                <?php echo $history['score'] >= 70 ? 'bg-success' : 'bg-danger'; ?>">
                                                <?php echo $history['score']; ?>%
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($history['score'] >= 70): ?>
                                                <span class="badge bg-success">Lulus</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Lulus</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="quiz_review.php?result_id=<?php echo $history['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Review
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>