<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PingPong+ App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            padding-bottom: 64px; /* Memberi ruang untuk navigasi bawah di mobile */
        }
        @media (min-width: 768px) {
            body { padding-bottom: 0; }
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="md:flex">
        <!-- Sidebar untuk Desktop -->
        <aside class="hidden md:block md:w-64 bg-white border-r border-gray-200 p-6 min-h-screen fixed top-0 left-0">
            <div class="flex items-center mb-8">
                <span class="text-3xl font-bold text-orange-500 mr-2">🏓</span>
                <h1 class="text-2xl font-bold text-gray-900">PingPong+</h1>
            </div>
            <nav class="flex flex-col space-y-2">
                <?php
                $navItems = [
                    ['id' => 'index', 'label' => 'Home', 'icon' => '🏠'],
                    ['id' => 'discover', 'label' => 'Discover', 'icon' => '🔍'],
                    ['id' => 'play', 'label' => 'Play', 'icon' => '▶️'],
                    ['id' => 'ptm', 'label' => 'PTM', 'icon' => '🏢'],
                    ['id' => 'profile', 'label' => 'Profile', 'icon' => '👤']
                ];
                // Dapatkan nama file halaman saat ini
                $currentPage = basename($_SERVER['PHP_SELF'], ".php");

                foreach ($navItems as $item) {
                    $isActive = ($currentPage == $item['id']) ? 'bg-orange-100 text-orange-600' : 'text-gray-600 hover:bg-gray-100';
                    echo "<a href='{$item['id']}.php' class='flex items-center px-4 py-3 rounded-lg font-medium {$isActive}'>
                            <span class='mr-3 text-xl'>{$item['icon']}</span>
                            {$item['label']}
                          </a>";
                }
                ?>
            </nav>
        </aside>

        <!-- Area Konten Utama -->
        <main class="flex-grow md:ml-64">
            <!-- Konten dari halaman spesifik akan dimuat di sini -->
