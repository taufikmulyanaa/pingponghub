<?php 
// File: play.php (Controller) - FIXED
include 'includes/header.php'; 

try {
    // --- AMBIL DATA UNTUK HALAMAN PLAY HUB ---

    // 1. Ambil turnamen yang statusnya masih 'Open' dengan LIMIT
    $tournamentsStmt = query($pdo, 
        "SELECT * FROM tournaments 
         WHERE status = 'Open' 
         ORDER BY date ASC 
         LIMIT 10"
    );
    
    if (!$tournamentsStmt) {
        throw new Exception("Failed to load tournaments data");
    }
    
    $tournaments = $tournamentsStmt->fetchAll();

    // 2. Ambil venue terdekat dengan LIMIT untuk performa
    $venuesStmt = query($pdo, 
        "SELECT * FROM venues 
         ORDER BY distance ASC 
         LIMIT 6"
    );
    
    if (!$venuesStmt) {
        throw new Exception("Failed to load venues data");
    }
    
    $venues = $venuesStmt->fetchAll();

    // Muat template untuk menampilkan semua data
    include 'templates/play_template.php';
    
} catch (Exception $e) {
    // Log error
    error_log("Play Page Error: " . $e->getMessage());
    
    // Show error page
    echo '<div class="max-w-4xl mx-auto p-4">
            <header class="bg-card p-4 border-b border-border">
                <h1 class="text-xl font-bold text-foreground flex items-center">
                    <i data-lucide="alert-circle" class="w-6 h-6 text-red-500 mr-2"></i>
                    Play Hub - Error
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