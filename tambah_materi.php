<?php
session_start();
include('config.php');

// Cek apakah pengguna adalah Superadmin
if ($_SESSION['level'] !== 'Superadmin') {
    header('Location: materi.php');
    exit();
}

// Jika form dikirim, simpan data ke database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $roadmap_id = $_POST['roadmap_id'];
    
    // Simpan materi baru
    $stmt = $pdo->prepare("INSERT INTO materi (title, content, roadmap_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $roadmap_id]);
    
    header('Location: materi.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Materi</title>
</head>
<body>
    <h2>Tambah Materi</h2>
    <form method="post" action="">
        <label>Judul:</label>
        <input type="text" name="title" required><br>

        <label>Konten:</label>
        <textarea name="content" required></textarea><br>

        <label>Roadmap ID:</label>
        <input type="text" name="roadmap_id" required><br>

        <button type="submit">Tambah</button>
        <a href="materi.php">Kembali</a>
    </form>
</body>
</html>
