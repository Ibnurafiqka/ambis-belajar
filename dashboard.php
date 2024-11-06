<?php
session_start();
include('config.php');

// Cek apakah user adalah super admin
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'Super Admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin - Ambis Belajar</title>a
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }
        
        .sidebar .nav-link {
            color: #fff;
            padding: 10px 20px;
        }
        
        .sidebar .nav-link:hover {
            background-color: #495057;
        }
        
        .sidebar .nav-link.active {
            background-color: #007bff;
        }
        
        .content {
            padding: 20px;
        }
        
        .stats-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .table-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .action-buttons .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="position-sticky">
                    <h5 class="text-light px-3 mb-3">Super Admin</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#dashboard">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#users">
                                <i class="fas fa-users mr-2"></i>Manajemen User
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#materi">
                                <i class="fas fa-book mr-2"></i>Manajemen Materi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#kuis">
                                <i class="fas fa-question-circle mr-2"></i>Manajemen Kuis
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ml-sm-auto px-4">
                <div class="content">
                    <h1 class="mb-4">Dashboard Super Admin</h1>
                    
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="stats-card">
                                <h5>Total Users</h5>
                                <h2><?php echo array_sum(array_column($statistics['users'], 'count')); ?></h2>
                                <p class="mb-0">Across all levels</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card">
                                <h5>Total Materi</h5>
                                <h2><?php echo array_sum(array_column($statistics['materi'], 'count')); ?></h2>
                                <p class="mb-0">All educational levels</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card">
                                <h5>Total Kuis</h5>
                                <h2><?php echo array_sum(array_column($statistics['kuis'], 'count')); ?></h2>
                                <p class="mb-0">Active quizzes</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card">
                                <h5>Active Sessions</h5>
                                <h2>24</h2>
                                <p class="mb-0">Current users online</p>
                            </div>
                        </div>
                    </div>

                    <!-- Materi Management Section -->
                    <div class="table-container mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3>Manajemen Materi</h3>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addMateriModal">
                                <i class="fas fa-plus mr-2"></i>Tambah Materi
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Judul</th>
                                        <th>Tingkat</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sample data, replace with dynamic data -->
                                    <tr>
                                        <td>1</td>
                                        <td>Matematika Dasar</td>
                                        <td>SMP</td>
                                        <td>Matematika</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Kuis Management Section -->
                    <div class="table-container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3>Manajemen Kuis</h3>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addKuisModal">
                                <i class="fas fa-plus mr-2"></i>Tambah Kuis
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Judul Kuis</th>
                                        <th>Tingkat</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Durasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sample data, replace with dynamic data -->
                                    <tr>
                                        <td>1</td>
                                        <td>Kuis Aljabar</td>
                                        <td>SMA</td>
                                        <td>Matematika</td>
                                        <td>30 menit</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Materi Modal -->
    <div class="modal fade" id="addMateriModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Materi Baru</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addMateriForm">
                        <div class="form-group">
                            <label>Judul Materi</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tingkat</label>
                            <select class="form-control" required>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Konten</label>
                            <textarea class="form-control" rows="4" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Kuis Modal -->
    <div class="modal fade" id="addKuisModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kuis Baru</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addKuisForm">
                        <div class="form-group">
                            <label>Judul Kuis</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tingkat</label>
                            <select class="form-control" required>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Durasi (menit)</label>
                            <input type="number" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Toggle sidebar on mobile
            $('#sidebarCollapse').on('click', function() {
                $('.sidebar').toggleClass('active');
            });
            
            // Confirm delete
            $('.btn-danger').on('click', function() {
                return confirm('Are you sure you want to delete this item?');
            });
            
            // Handle form submissions
            $('#addMateriForm, #addKuisForm').on('submit', function(e) {
                e.preventDefault();
                // Add your AJAX submission logic here
            });
        });
    </script>
</body>
</html>