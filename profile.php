<?php
// File: profile.php (Controller)
include 'includes/header.php';

// Asumsikan user yang login punya ID 1
$loggedInUserId = 1;

// --- VALIDASI INPUT ---
// Cek apakah ada ID di URL, pastikan itu angka positif
$userId = $loggedInUserId; // Default ke user yang login
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
    $userId = (int)$_GET['id'];
}

// Ambil data user menggunakan fungsi terpusat
$user = getUserData($pdo, $userId);

// Muat template untuk menampilkan data
include 'templates/profile_template.php';

include 'includes/footer.php';
?>