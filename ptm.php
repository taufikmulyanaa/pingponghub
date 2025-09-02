<?php 
// File: ptm.php (Controller) - FIXED
include 'includes/header.php'; 

try {
    // Asumsikan user yang login punya ID 1
    $loggedInUserId = 1; // Should come from session in production

    // --- AMBIL DATA UNTUK HALAMAN PTM ---

    // 1. Ambil data klub milik pengguna
    $userClubStmt = query($pdo, 
        "SELECT club_id FROM users WHERE id = ? LIMIT 1", 
        [$loggedInUserId]
    );
    
    if (!$userClubStmt) {
        throw new Exception("Failed to load user club data");
    }
    
    $userClubId = $userClubStmt->fetchColumn();
    $myClub = null;
    
    if ($userClubId) {
        $clubStmt = query($pdo, 
            "SELECT * FROM clubs WHERE id = ? LIMIT 1", 
            [$userClubId]
        );
        $myClub = $clubStmt ? $clubStmt->fetch() : null;
    }

    // 2. Ambil data pertandingan antar klub yang akan datang dengan LIMIT
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
        LIMIT 10"
    );
    
    if (!$interClubMatchesStmt) {
        throw new Exception("Failed to load inter club matches data");
    }
    
    $interClubMatches = $interClubMatchesStmt->fetchAll();

    // 3. Ambil data klub lainnya dengan LIMIT untuk performa
    $otherClubsStmt = query($pdo, 
        "SELECT * FROM clubs 
         WHERE id != ? 
         ORDER BY team_ranking ASC 
         LIMIT 20", 
        [$userClubId ?? 0]
    );
    
    if (!$otherClubsStmt) {
        throw new Exception("Failed to load other clubs data");
    }
    
    $otherClubs = $otherClubsStmt->fetchAll();

    // Muat template untuk menampilkan semua data
    include 'templates/ptm_template.php';
    
} catch (Exception $e) {
    // Log error
    error_log("PTM Page Error: " . $e->getMessage());
    
    // Show error page
    echo '<div class="max-w-4xl mx-auto p-4">
            <header class="bg-card p-4 border-b border-border">
                <h1 class="text-xl font-bold text-foreground flex items-center">
                    <i data-lucide="alert-circle" class="w-6 h-6 text-red-500 mr-2"></i>
                    Clubs & Matches - Error
                </h1>
            </header>
            <div class="bg-red-50 border border-red-200 p-8 rounded-lg text-center mt-4">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="alert-circle" class="w-8 h-8 text-red-500"></i>
                </div>
                <h4 class="text-lg font-semibold text-red-800 mb-2">Page Loading Error</h4>
                <p class="text-red-600 mb-4">' . htmlspecialchars($e->getMessage()) . '</p>
                <div class="space-x-4">
                    <button onclick="location.reload()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        <i data-lucide="refresh-cw" class="w-4 h-4 mr-2 inline"></i>
                        Try Again
                    </button>
                    <a href="index.php" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 inline-block">
                        <i data-lucide="home" class="w-4 h-4 mr-2 inline"></i>
                        Go Home
                    </a>
                </div>
            </div>
          </div>';
}

include 'includes/footer.php'; 
?>