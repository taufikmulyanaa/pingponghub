<?php 
// File: discover.php (Controller) - FIXED
include 'includes/header.php'; 

// Include helper functions
require_once 'lib/discover_helpers.php';

try {
    // --- AMBIL DATA AWAL (DEFAULT FILTER: TERDEKAT) ---
    $loggedInUserId = 1; // Should come from session in production

    // Optimized query dengan LIMIT untuk performa
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
            ORDER BY u.distance ASC 
            LIMIT 20";
            
    $playersStmt = query($pdo, $sql, [$loggedInUserId]);
    
    if (!$playersStmt) {
        throw new Exception("Failed to load players data");
    }
    
    $players = $playersStmt->fetchAll();
    
    // Muat template
    include 'templates/discover_template.php';
    
} catch (Exception $e) {
    // Log error
    error_log("Discover Page Error: " . $e->getMessage());
    
    // Show error page
    echo '<div class="max-w-4xl mx-auto p-4">
            <div class="bg-red-50 border border-red-200 p-8 rounded-lg text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="alert-circle" class="w-8 h-8 text-red-500"></i>
                </div>
                <h4 class="text-lg font-semibold text-red-800 mb-2">Page Loading Error</h4>
                <p class="text-red-600 mb-4">We encountered an issue while loading the discover page.</p>
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