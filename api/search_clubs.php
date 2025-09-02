<?php
// File: api/search_clubs.php
// Endpoint ini tidak memerlukan header/footer lengkap

require_once '../config/db.php';
require_once '../lib/functions.php';

// Sanitasi input pencarian
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';

// Query untuk mencari klub berdasarkan kota
$sql = "SELECT * FROM clubs WHERE city LIKE ? ORDER BY name ASC";
$params = ['%' . $searchTerm . '%'];

$clubs = query($pdo, $sql, $params)->fetchAll();

// Penanganan Empty State
if (empty($clubs)) {
    echo '<p class="text-center text-gray-500 p-4">Tidak ada klub yang cocok dengan pencarian Anda.</p>';
    exit;
}

// Hasilkan HTML untuk setiap klub yang ditemukan
foreach ($clubs as $club) {
    // Anda bisa membuat file template terpisah untuk item klub jika ingin lebih rapi
    echo <<<HTML
    <div class="bg-white p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50">
        <div class="flex items-center">
            <img src="{$club['logo']}" class="w-12 h-12 rounded-full mr-3">
            <div class="flex-1">
                <div class="flex items-center justify-between mb-1">
                    <p class="font-medium text-gray-900">{$club['name']}</p>
                    <span class="text-sm text-gray-600">#{$club['team_ranking']}</span>
                </div>
                <p class="text-sm text-gray-600">{$club['city']}</p>
                <div class="flex items-center space-x-4 text-xs text-gray-500 mt-1">
                    <span>👥 {$club['members']}</span>
                    <span>⭐ {$club['rating']}</span>
                </div>
            </div>
        </div>
    </div>
    HTML;
}
?>