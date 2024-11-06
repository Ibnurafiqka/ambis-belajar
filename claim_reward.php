<?php
session_start();
include('config.php');

$user_id = $_SESSION['user_id'];

// Hitung total waktu belajar
$stmt = $pdo->prepare("SELECT SUM(study_duration) AS total_time FROM riwayat WHERE user_id = ?");
$stmt->execute([$user_id]);
$row = $stmt->fetch();

$total_time = $row['total_time'];

// Hitung reward berdasarkan waktu
$points = $total_time / 60; // Misalnya 1 jam = 1 poin

$stmt = $pdo->prepare("SELECT * FROM hadiah WHERE points_required <= ?");
$stmt->execute([$points]);
$rewards = $stmt->fetchAll();
?>
