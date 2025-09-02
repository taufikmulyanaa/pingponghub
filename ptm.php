<?php 
// File: ptm.php (Controller)
include 'includes/header.php'; 

// Asumsikan user yang login punya ID 1
$loggedInUserId = 1;

// --- AMBIL DATA UNTUK HALAMAN PTM ---

// 1. Ambil data klub milik pengguna
$userClubId = query($pdo, "SELECT club_id FROM users WHERE id = ?", [$loggedInUserId])->fetchColumn();
$myClub = $userClubId ? query($pdo, "SELECT * FROM clubs WHERE id = ?", [$userClubId])->fetch() : null;

// 2. Ambil data pertandingan antar klub yang akan datang
$interClubMatchesStmt = query($pdo, 
    "SELECT 
        icm.*,
        home_club.name as home_club_name,
        home_club.logo as home_club_logo,
        away_club.name as away_club_name,
        away_club.logo as away_club_logo
    FROM inter_club_matches icm
    LEFT JOIN clubs home_club ON icm.home_club_id = home_club.id
    LEFT JOIN clubs away_club ON icm.away_club_id = away_club.id
    WHERE icm.match_datetime >= NOW()
    ORDER BY icm.match_datetime ASC
    LIMIT 5"
);
$interClubMatches = $interClubMatchesStmt->fetchAll();

// 3. Ambil data klub lainnya (untuk tampilan awal)
$otherClubs = query($pdo, "SELECT * FROM clubs WHERE id != ?", [$userClubId ?? 0])->fetchAll();

// Muat template untuk menampilkan semua data
include 'templates/ptm_template.php';

include 'includes/footer.php'; 
?>