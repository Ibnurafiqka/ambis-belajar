<?php
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'Mahasiswa') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Mengambil data stream yang sedang berlangsung
$stmt_active_streams = $pdo->prepare("
    SELECT s.*, u.username, COUNT(sp.participant_id) as participant_count 
    FROM study_streams s 
    JOIN users u ON s.creator_id = u.id 
    LEFT JOIN stream_participants sp ON s.id = sp.stream_id 
    WHERE s.status = 'active' 
    GROUP BY s.id 
    ORDER BY s.created_at DESC 
    LIMIT 10
");
$stmt_active_streams->execute();
$active_streams = $stmt_active_streams->fetchAll();

// Mengambil statistik stream pengguna
$stmt_user_stats = $pdo->prepare("
    SELECT 
        SUM(duration_minutes) as total_study_time,
        COUNT(DISTINCT stream_id) as streams_joined,
        SUM(xp_earned) as total_stream_xp
    FROM stream_participants
    WHERE participant_id = ?
");
$stmt_user_stats->execute([$user_id]);
$user_stats = $stmt_user_stats->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambisi Belajar - Study Stream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .stream-card {
            transition: transform 0.2s;
            border-left: 4px solid #007bff;
        }
        .stream-card:hover {
            transform: translateY(-3px);
        }
        .stream-stats {
            background: linear-gradient(135deg, #6c5ce7, #a363d9);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .participant-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: -10px;
            border: 2px solid white;
        }
        .stream-timer {
            font-family: monospace;
            font-size: 1.5rem;
            color: #2ecc71;
        }
        .category-badge {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 15px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar (sesuaikan dengan navbar yang sudah ada, tambahkan menu Stream) -->
    <div class="container mt-4">
        <!-- Stream Statistics -->
        <div class="stream-stats shadow">
            <div class="row">
                <div class="col-md-4 text-center">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <h3><?php echo number_format($user_stats['total_study_time'] ?? 0); ?></h3>
                    <p>Total Menit Belajar</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h3><?php echo number_format($user_stats['streams_joined'] ?? 0); ?></h3>
                    <p>Stream Diikuti</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-star fa-2x mb-2"></i>
                    <h3><?php echo number_format($user_stats['total_stream_xp'] ?? 0); ?></h3>
                    <p>XP dari Stream</p>
                </div>
            </div>
        </div>

        <!-- Create Stream Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="fas fa-broadcast-tower"></i> Study Streams</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createStreamModal">
                <i class="fas fa-plus"></i> Mulai Stream
            </button>
        </div>

        <!-- Active Streams -->
        <div class="row">
            <?php foreach ($active_streams as $stream): ?>
            <div class="col-md-6 mb-4">
                <div class="card stream-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="card-title mb-0"><?php echo htmlspecialchars($stream['title']); ?></h5>
                            <span class="stream-timer">02:45:30</span>
                        </div>
                        
                        <div class="mb-3">
                            <span class="category-badge bg-primary"><?php echo htmlspecialchars($stream['subject']); ?></span>
                            <span class="category-badge bg-info"><?php echo htmlspecialchars($stream['difficulty']); ?></span>
                        </div>

                        <p class="card-text"><?php echo htmlspecialchars($stream['description']); ?></p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <img src="../assets/avatar.png" class="participant-avatar" alt="Host">
                                    <small class="ms-2"><?php echo htmlspecialchars($stream['username']); ?></small>
                                </div>
                                <div>
                                    <i class="fas fa-users"></i>
                                    <small><?php echo $stream['participant_count']; ?> peserta</small>
                                </div>
                            </div>
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-sign-in-alt"></i> Gabung Stream
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Create Stream Modal -->
    <div class="modal fade" id="createStreamModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mulai Study Stream</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createStreamForm">
                        <div class="mb-3">
                            <label class="form-label">Judul Stream</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <select class="form-select" required>
                                <option value="matematika">Matematika</option>
                                <option value="fisika">Fisika</option>
                                <option value="kimia">Kimia</option>
                                <option value="biologi">Biologi</option>
                                <option value="bahasa">Bahasa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tingkat Kesulitan</label>
                            <select class="form-select" required>
                                <option value="pemula">Pemula</option>
                                <option value="menengah">Menengah</option>
                                <option value="lanjutan">Lanjutan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Mulai Stream</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>