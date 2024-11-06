<?php
session_start();
include('config.php');

// Cek apakah pengguna adalah Superadmin
if ($_SESSION['level'] !== 'Superadmin') {
    header('Location: materi.php');
    exit();
}

// Ambil data materi yang akan diedit
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM materi WHERE id = ?");
$stmt->execute([$id]);
$material = $stmt->fetch();

// Jika form dikirim, update data di database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $roadmap_id = $_POST['roadmap_id'];
    
    // Update data materi
    $stmt = $pdo->prepare("UPDATE materi SET title = ?, content = ?, roadmap_id = ? WHERE id = ?");
    $stmt->execute([$title, $content, $roadmap_id, $id]);
    
    header('Location: materi.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Materi</title>
</head>
<body>
    <h2>Edit Materi</h2>
    <form method="post" action="">
        <label>Judul:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($material['title']); ?>" required><br>

        <label>Konten:</label>
        <textarea name="content" required><?php echo htmlspecialchars($material['content']); ?></textarea><br>

        <label>Roadmap ID:</label>
        <input type="text" name="roadmap_id" value="<?php echo htmlspecialchars($material['roadmap_id']); ?>" required><br>

        <button type="submit">Update</button>
        <a href="materi.php">Kembali</a>
    </form>
</body>
</html>
    