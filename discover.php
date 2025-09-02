<?php 
// File: discover.php (Controller)
include 'includes/header.php'; 

// --- HELPER FUNCTIONS (Bisa dipindah ke lib/functions.php jika mau) ---

// Fungsi untuk membuat inisial dari nama
function getInitials($name) {
    $words = explode(' ', $name);
    $initials = '';
    $max = 2;
    for ($i = 0; $i < min(count($words), $max); $i++) {
        $initials .= strtoupper(substr($words[$i], 0, 1));
    }
    return $initials;
}

// Fungsi untuk memetakan skill 'Division' ke level yang lebih umum
function mapSkillToLevel($skill) {
    // Sesuaikan mapping ini sesuai kebutuhan Anda
    $levelMap = [
        'Division 1' => ['label' => 'Mahir', 'class' => 'bg-red-100 text-red-800'],
        'Division 2' => ['label' => 'Mahir', 'class' => 'bg-red-100 text-red-800'],
        'Division 3' => ['label' => 'Menengah', 'class' => 'bg-yellow-100 text-yellow-800'],
        'Division 4' => ['label' => 'Menengah', 'class' => 'bg-yellow-100 text-yellow-800'],
        'Division 5' => ['label' => 'Menengah', 'class' => 'bg-yellow-100 text-yellow-800'],
        'Division 6' => ['label' => 'Pemula', 'class' => 'bg-green-100 text-green-800'],
        'Division 7' => ['label' => 'Pemula', 'class' => 'bg-green-100 text-green-800'],
    ];
    return $levelMap[$skill] ?? ['label' => 'N/A', 'class' => 'bg-gray-100 text-gray-800'];
}


// --- AMBIL DATA AWAL (DEFAULT FILTER: TERDEKAT) ---
$loggedInUserId = 1; // Asumsi

$sql = "SELECT 
            u.*, 
            s.matches, 
            s.wins, 
            s.tournaments, 
            c.short_name as club_short_name 
        FROM users u 
        LEFT JOIN user_stats s ON u.id = s.user_id 
        LEFT JOIN clubs c ON u.club_id = c.id 
        WHERE u.id != ? 
        ORDER BY u.distance ASC";
        
$playersStmt = query($pdo, $sql, [$loggedInUserId]);
$players = $playersStmt->fetchAll();

// Muat template
include 'templates/discover_template.php';

include 'includes/footer.php'; 
?>