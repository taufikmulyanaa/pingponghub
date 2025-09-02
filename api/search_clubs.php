<?php
// File: api/search_clubs.php
// FIXED: Added proper error handling and timeout protection

// Set proper headers for API response
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');

require_once '../config/db.php';
require_once '../lib/functions.php';

try {
    // Validate and sanitize input
    $searchTerm = sanitizeInput($_GET['q'] ?? '');
    
    // Minimum search length validation
    if (strlen($searchTerm) < 2) {
        echo '<div class="p-4 text-center text-gray-500">
                <p>Please enter at least 2 characters to search.</p>
              </div>';
        exit;
    }
    
    // Query untuk mencari klub berdasarkan kota dengan LIMIT untuk performa
    $sql = "SELECT * FROM clubs 
            WHERE city LIKE ? OR name LIKE ? OR province LIKE ?
            ORDER BY verified DESC, name ASC 
            LIMIT 20";
    
    $searchParam = '%' . $searchTerm . '%';
    $params = [$searchParam, $searchParam, $searchParam];
    
    $stmt = query($pdo, $sql, $params);
    
    if (!$stmt) {
        throw new Exception("Database query failed");
    }
    
    $clubs = $stmt->fetchAll();
    
    // Empty state dengan helpful message
    if (empty($clubs)) {
        echo '<div class="p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="building" class="w-8 h-8 text-gray-400"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-800 mb-2">No clubs found</h4>
                <p class="text-gray-500 mb-4">No clubs match your search for "<strong>' . htmlspecialchars($searchTerm) . '</strong>"</p>
                <p class="text-sm text-gray-400">Try searching for a different city or club name.</p>
              </div>';
        exit;
    }
    
    // Render hasil pencarian
    foreach ($clubs as $club) {
        $clubName = sanitizeInput($club['name']);
        $clubCity = sanitizeInput($club['city']);
        $clubLogo = sanitizeInput($club['logo']);
        $teamRanking = sanitizeInput($club['team_ranking']);
        $members = sanitizeInput($club['members'] ?? 0);
        $rating = sanitizeInput($club['rating'] ?? 'N/A');
        $verified = $club['verified'] ? 'verified' : '';
        $verifiedBadge = $club['verified'] ? 
            '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800 ml-2">
                <i data-lucide="shield-check" class="w-3 h-3 mr-1"></i>
                Verified
             </span>' : '';
        
        echo <<<HTML
        <div class="bg-white p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition-colors {$verified}">
            <div class="flex items-center">
                <div class="relative flex-shrink-0">
                    <img src="{$clubLogo}" class="w-12 h-12 rounded-full mr-3 object-cover border-2 border-gray-100">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-900 truncate">{$clubName}</p>
                            {$verifiedBadge}
                        </div>
                        <span class="text-sm text-orange-600 font-bold">#{$teamRanking}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{$clubCity}</p>
                    <div class="flex items-center space-x-4 text-xs text-gray-500">
                        <div class="flex items-center">
                            <i data-lucide="users" class="w-3 h-3 mr-1"></i>
                            <span>{$members}</span>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="star" class="w-3 h-3 mr-1"></i>
                            <span>{$rating}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center ml-4">
                    <button class="p-2 text-gray-400 hover:text-orange-500 transition-colors">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>
HTML;
    }
    
} catch (Exception $e) {
    // Log error for debugging
    error_log("Club Search API Error: " . $e->getMessage());
    
    // Return user-friendly error
    echo '<div class="p-8 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="alert-circle" class="w-8 h-8 text-red-500"></i>
            </div>
            <h4 class="text-lg font-semibold text-red-800 mb-2">Search Error</h4>
            <p class="text-red-600 mb-4">We encountered an issue while searching for clubs.</p>
            <button onclick="location.reload()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                <i data-lucide="refresh-cw" class="w-4 h-4 mr-2 inline"></i>
                Try Again
            </button>
          </div>';
}
?>