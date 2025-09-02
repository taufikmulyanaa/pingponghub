<?php 
// File: play.php (Controller)
include 'includes/header.php'; 

// --- AMBIL DATA UNTUK HALAMAN PLAY HUB ---

// 1. Ambil semua turnamen yang statusnya masih 'Open'
$tournamentsStmt = query($pdo, "SELECT * FROM tournaments WHERE status = 'Open' ORDER BY date ASC");
$tournaments = $tournamentsStmt->fetchAll();

// 2. Ambil 3 venue terdekat (berdasarkan kolom 'distance')
$venuesStmt = query($pdo, "SELECT * FROM venues ORDER BY distance ASC LIMIT 3");
$venues = $venuesStmt->fetchAll();

// Muat template untuk menampilkan semua data
include 'templates/play_template.php';

include 'includes/footer.php'; 
?>