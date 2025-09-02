<?php
// File: lib/discover_helpers.php
// Helper functions untuk discover functionality tanpa mengload template

/**
 * Fungsi untuk membuat inisial dari nama
 */
function getInitials($name) {
    $words = explode(' ', trim($name));
    $initials = '';
    $max = 2;
    for ($i = 0; $i < min(count($words), $max); $i++) {
        $initials .= strtoupper(substr($words[$i], 0, 1));
    }
    return $initials ?: 'U'; // Default 'U' untuk unknown
}

/**
 * Fungsi untuk memetakan skill 'Division' ke level yang lebih umum
 */
function mapSkillToLevel($skill) {
    $levelMap = [
        'Division 1' => ['label' => 'Advanced', 'class' => 'bg-red-100 text-red-800'],
        'Division 2' => ['label' => 'Advanced', 'class' => 'bg-red-100 text-red-800'],
        'Division 3' => ['label' => 'Intermediate', 'class' => 'bg-yellow-100 text-yellow-800'],
        'Division 4' => ['label' => 'Intermediate', 'class' => 'bg-yellow-100 text-yellow-800'],
        'Division 5' => ['label' => 'Intermediate', 'class' => 'bg-yellow-100 text-yellow-800'],
        'Division 6' => ['label' => 'Beginner', 'class' => 'bg-green-100 text-green-800'],
        'Division 7' => ['label' => 'Beginner', 'class' => 'bg-green-100 text-green-800'],
        'Division 8' => ['label' => 'Beginner', 'class' => 'bg-green-100 text-green-800'],
        'Division 9' => ['label' => 'Beginner', 'class' => 'bg-green-100 text-green-800'],
        'Division 10' => ['label' => 'Beginner', 'class' => 'bg-green-100 text-green-800'],
    ];
    
    return $levelMap[$skill] ?? ['label' => 'Unranked', 'class' => 'bg-gray-100 text-gray-800'];
}

/**
 * Generate filter query berdasarkan filter type
 */
function generatePlayerFilterQuery($filter, $loggedInUserId) {
    $baseSql = "SELECT u.*, s.matches, s.wins, s.tournaments, c.short_name as club_short_name 
                FROM users u 
                LEFT JOIN user_stats s ON u.id = s.user_id 
                LEFT JOIN clubs c ON u.club_id = c.id 
                WHERE u.id != ?";
    
    switch ($filter) {
        case 'online':
            $sql = $baseSql . " AND u.online = 1 ORDER BY u.distance ASC LIMIT 20";
            break;
            
        case 'beginner':
            $sql = $baseSql . " AND u.skill IN ('Division 6', 'Division 7', 'Division 8', 'Division 9', 'Division 10') 
                               ORDER BY u.distance ASC LIMIT 20";
            break;
            
        case 'intermediate':
            $sql = $baseSql . " AND u.skill IN ('Division 3', 'Division 4', 'Division 5') 
                               ORDER BY u.distance ASC LIMIT 20";
            break;
            
        case 'advanced':
            $sql = $baseSql . " AND u.skill IN ('Division 1', 'Division 2') 
                               ORDER BY u.distance ASC LIMIT 20";
            break;
            
        case 'nearby':
        default:
            $sql = $baseSql . " ORDER BY u.distance ASC LIMIT 20";
            break;
    }
    
    return $sql;
}

/**
 * Render player card HTML
 */
function renderPlayerCard($player) {
    $winRate = ($player['matches'] ?? 0) > 0 ? round(($player['wins'] / $player['matches']) * 100) : 0;
    $skillInfo = mapSkillToLevel($player['skill']);
    $initials = getInitials($player['name']);
    
    // Sanitize data
    $name = sanitizeInput($player['name']);
    $elo = sanitizeInput($player['elo'] ?? '0');
    $reviews = sanitizeInput($player['reviews'] ?? '0');
    $club_short_name = sanitizeInput($player['club_short_name'] ?? '');
    $distance = sanitizeInput($player['distance'] ?? 'N/A');
    $style = sanitizeInput($player['style'] ?? '');
    $tournaments = sanitizeInput($player['tournaments'] ?? '0');
    $availability = sanitizeInput($player['availability'] ?? 'N/A');
    
    $onlineBadge = $player['online'] ? '<span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>' : '';
    $onlineTag = $player['online'] ? '<span class="text-xs font-medium px-2 py-1 rounded-full bg-green-100 text-green-800">Online</span>' : '';
    $clubTag = $club_short_name ? "<span class='mx-2'>|</span><span class='font-semibold text-orange-600'>{$club_short_name}</span>" : '';

    return <<<HTML
    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm flex space-x-4">
        <div class="relative flex-shrink-0">
            <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-xl">{$initials}</div>
            {$onlineBadge}
        </div>
        <div class="flex-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-bold text-gray-900">{$name}</p>
                    <div class="flex items-center text-xs text-gray-500 mt-1">
                        <span>⭐ {$elo}</span>
                        <span class="mx-2">|</span>
                        <span>💬 {$reviews} Reviews</span>
                        {$clubTag}
                    </div>
                </div>
                <span class="text-sm font-medium text-gray-600">{$distance}km</span>
            </div>
            <div class="flex items-center space-x-2 my-2">
                <span class="text-xs font-medium px-2 py-1 rounded-full {$skillInfo['class']}">{$skillInfo['label']}</span>
                <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 text-gray-800">{$style}</span>
                {$onlineTag}
            </div>
            <div class="flex justify-between items-center border-t border-gray-100 pt-2 mt-2">
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <span>🏆 {$tournaments}</span>
                    <span>📈 {$winRate}%</span>
                    <span>📅 {$availability}</span>
                </div>
                <a href="#" class="px-4 py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-sm rounded-lg font-medium">Chat</a>
            </div>
        </div>
    </div>
HTML;
}
?>