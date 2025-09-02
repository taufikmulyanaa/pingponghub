<?php
// File: api/filter_players.php
// FIXED: Removed circular dependency with discover.php

// Set proper headers for API response
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');

// Include required files (no circular dependency)
require_once '../config/db.php';
require_once '../lib/functions.php';
require_once '../lib/discover_helpers.php';

// Validate and sanitize input
$filter = sanitizeInput($_GET['filter'] ?? 'nearby');
$loggedInUserId = 1; // Should come from session in production

try {
    // Generate query based on filter
    $sql = generatePlayerFilterQuery($filter, $loggedInUserId);
    
    // Execute query with timeout protection
    $stmt = query($pdo, $sql, [$loggedInUserId]);
    
    if (!$stmt) {
        throw new Exception("Database query failed");
    }
    
    $players = $stmt->fetchAll();
    
    // Return count for header update
    echo '<div id="player-count" data-count="' . count($players) . '"></div>';
    
    if (empty($players)) {
        echo '<div class="bg-white p-8 rounded-lg border border-gray-200 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="user-x" class="w-8 h-8 text-gray-400"></i>
                </div>
                <p class="text-gray-500 mb-4">No players found matching your filter.</p>
                <button onclick="location.reload()" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
                    <i data-lucide="refresh-cw" class="w-4 h-4 mr-2 inline"></i>
                    Refresh
                </button>
              </div>';
        exit;
    }
    
    // Render players using helper function
    foreach ($players as $player) {
        echo renderPlayerCard($player);
    }
    
} catch (Exception $e) {
    // Log error
    error_log("Filter Players API Error: " . $e->getMessage());
    
    // Return user-friendly error
    echo '<div class="bg-red-50 border border-red-200 p-8 rounded-lg text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="alert-circle" class="w-8 h-8 text-red-500"></i>
            </div>
            <h4 class="text-lg font-semibold text-red-800 mb-2">Oops! Something went wrong</h4>
            <p class="text-red-600 mb-4">We encountered an issue while loading players.</p>
            <button onclick="location.reload()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                <i data-lucide="refresh-cw" class="w-4 h-4 mr-2 inline"></i>
                Try Again
            </button>
          </div>';
}
?>