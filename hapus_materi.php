<?php
session_start();
include('config.php');

// Cek apakah pengguna adalah Superadmin
if ($_SESSION['level'] !== 'Superadmin') {
    header('Location: materi.php');
    exit();
}

$id = $_GET['id'];

// Hapus data materi
$stmt = $pdo->prepare("DELETE FROM materi WHERE id = ?");
$stmt->execute([$id]);

header('Location: materi.php');
exit();
?>
