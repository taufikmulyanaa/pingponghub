<?php 
require_once 'config/db.php'; 
require_once 'lib/functions.php';

// Get current page info
$currentPage = basename($_SERVER['PHP_SELF'], ".php");
$pageInfo = [
    'index' => ['title' => 'Dashboard', 'icon' => 'home', 'description' => 'Your ping pong hub'],
    'discover' => ['title' => 'Discover Players', 'icon' => 'compass', 'description' => 'Find your perfect match'],
    'play' => ['title' => 'Play Hub', 'icon' => 'play', 'description' => 'Tournaments & venues'],
    'ptm' => ['title' => 'Clubs & Matches', 'icon' => 'building', 'description' => 'Club management'],
    'profile' => ['title' => 'Profile', 'icon' => 'user', 'description' => 'Manage your profile']
];
$page = $pageInfo[$currentPage] ?? ['title' => 'PingPong+', 'icon' => 'table-tennis-paddle', 'description' => ''];

// Get user notification count (if user is logged in)
$unreadCount = 0;
if (isset($_SESSION['user_id'])) {
    $stmt = query($pdo, "SELECT COUNT(*) FROM notifications WHERE recipient_user_id = ? AND is_read = 0", [$_SESSION['user_id']]);
    $unreadCount = $stmt ? $stmt->fetchColumn() : 0;
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PingPong+ - Connect with table tennis players, find venues, join tournaments">
    <meta name="theme-color" content="#f97316">
    <title><?= htmlspecialchars($page['title']) ?> - PingPong+</title>
    
    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js (only load if needed) -->
    <?php if ($currentPage === 'index' || $currentPage === 'profile'): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- PWA Meta tags -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="PingPong+">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.ico">
    
    <style>
        /* Critical CSS for immediate rendering */
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f9fafb;
        }
        
        /* Loading state */
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased min-h-full">
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-white z-50 flex items-center justify-center transition-opacity duration-300" style="display: none;">
        <div class="text-center">
            <div class="w-12 h-12 border-4 border-primary-200 border-t-primary-500 rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-gray-600">Loading...</p>
        </div>
    </div>

    <div class="app-container">
        <!-- Desktop Sidebar -->
        <aside class="app-sidebar">
            <!-- Logo Section -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center mr-3 shadow-lg">
                        <i data-lucide="table-tennis-paddle" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">PingPong+</h1>
                        <p class="text-xs text-gray-500">Table Tennis Community</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <?php
                $navItems = [
                    ['id' => 'index', 'label' => 'Dashboard', 'icon' => 'home', 'description' => 'Overview & Feed'],
                    ['id' => 'discover', 'label' => 'Discover', 'icon' => 'compass', 'description' => 'Find Players'],
                    ['id' => 'play', 'label' => 'Play Hub', 'icon' => 'play', 'description' => 'Tournaments & Venues'],
                    ['id' => 'ptm', 'label' => 'Clubs', 'icon' => 'building', 'description' => 'Club Management'],
                    ['id' => 'profile', 'label' => 'Profile', 'icon' => 'user', 'description' => 'My Profile']
                ];

                foreach ($navItems as $item) {
                    $isActive = ($currentPage === $item['id']) ? 'nav-item active' : 'nav-item';
                    echo "<a href='{$item['id']}.php' class='{$isActive}' data-tooltip='{$item['description']}'>
                            <i data-lucide='{$item['icon']}' class='nav-icon'></i>
                            <div class='flex flex-col min-w-0'>
                                <span class='font-medium truncate'>{$item['label']}</span>
                                <span class='text-xs opacity-70 truncate'>{$item['description']}</span>
                            </div>
                          </a>";
                }
                ?>
            </nav>
            
            <!-- User Profile Section -->
            <div class="p-4 border-t border-gray-200">
                <?php 
                // Sample user data - replace with actual logged-in user
                $currentUser = [
                    'name' => 'Budi Santoso',
                    'club' => 'Stoni TTC',
                    'avatar' => null,
                    'elo' => 2150,
                    'online' => true
                ];
                
                $initials = implode('', array_map(fn($n) => strtoupper($n[0]), explode(' ', $currentUser['name'])));
                ?>
                <div class="flex items-center">
                    <div class="relative">
                        <div class="avatar avatar-md">
                            <?= $initials ?>
                        </div>
                        <?php if ($currentUser['online']): ?>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                        <?php endif; ?>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($currentUser['name']) ?></p>
                        <div class="flex items-center text-xs text-gray-500">
                            <span class="truncate"><?= htmlspecialchars($currentUser['club']) ?></span>
                            <span class="mx-1">•</span>
                            <span class="text-primary-600 font-medium"><?= $currentUser['elo'] ?></span>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <button class="p-1.5 text-gray-400 hover:text-gray-600 transition-colors rounded-md hover:bg-gray-100" 
                                data-tooltip="Settings">
                            <i data-lucide="settings" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="app-main">
            <!-- Mobile/Desktop Header -->
            <header class="app-header">
                <div class="app-header-content">
                    <!-- Mobile menu button -->
                    <button class="md:hidden p-2 -ml-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
                            id="mobile-menu-button">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    
                    <!-- Page Title -->
                    <div class="flex items-center flex-1 md:flex-initial">
                        <i data-lucide="<?= $page['icon'] ?>" class="app-header-icon"></i>
                        <div class="min-w-0">
                            <h1 class="text-xl font-bold text-gray-900 truncate"><?= htmlspecialchars($page['title']) ?></h1>
                            <?php if ($page['description']): ?>
                            <p class="text-sm text-gray-500 truncate mobile:hidden"><?= htmlspecialchars($page['description']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Header Actions -->
                    <div class="flex items-center space-x-2">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" 
                                data-tooltip="Notifications"
                                id="notifications-button">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <?php if ($unreadCount > 0): ?>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-medium animate-pulse">
                                <?= $unreadCount > 9 ? '9+' : $unreadCount ?>
                            </span>
                            <?php endif; ?>
                        </button>
                        
                        <!-- Search (Desktop only) -->
                        <button class="hidden md:block p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" 
                                data-tooltip="Search"
                                onclick="document.querySelector('.search-input').focus()">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </button>
                        
                        <!-- Settings/Profile -->
                        <div class="relative">
                            <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" 
                                    data-tooltip="Profile Menu"
                                    id="profile-menu-button">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </button>
                            
                            <!-- Profile Dropdown (hidden by default) -->
                            <div id="profile-dropdown" class="absolute right-0 top-12 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-40 hidden">
                                <div class="p-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($currentUser['name']) ?></p>
                                    <p class="text-xs text-gray-500"><?= htmlspecialchars($currentUser['club']) ?></p>
                                </div>
                                <div class="py-2">
                                    <a href="profile.php" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                        My Profile
                                    </a>
                                    <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i data-lucide="settings" class="w-4 h-4 mr-2"></i>
                                        Settings
                                    </a>
                                    <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i data-lucide="help-circle" class="w-4 h-4 mr-2"></i>
                                        Help
                                    </a>
                                    <hr class="my-2">
                                    <a href="#" class="flex items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                                        Sign Out
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Search Bar (visible on all pages) -->
                <div class="search-container">
                    <i data-lucide="search" class="search-icon"></i>
                    <input type="text" 
                           placeholder="Search players, clubs, tournaments..." 
                           class="search-input"
                           id="global-search">
                </div>
            </header>

            <!-- Page Content Container -->
            <div class="app-content">
                <!-- Success/Error Messages -->
                <div id="message-container" class="mx-4 mt-4 space-y-2" style="display: none;">
                    <!-- Messages will be inserted here -->
                </div>

    <script>
        // Initialize critical functionality immediately
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Hide loading overlay
            const loadingOverlay = document.getElementById('loading-overlay');
            if (loadingOverlay) {
                loadingOverlay.style.display = 'none';
            }
            
            // Profile dropdown functionality
            const profileButton = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');
            
            if (profileButton && profileDropdown) {
                profileButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!profileButton.contains(e.target)) {
                        profileDropdown.classList.add('hidden');
                    }
                });
            }
            
            // Mobile menu functionality (for future implementation)
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    // TODO: Implement mobile menu
                    console.log('Mobile menu clicked');
                });
            }
            
            // Global search functionality
            const globalSearch = document.getElementById('global-search');
            if (globalSearch) {
                let searchTimeout;
                globalSearch.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    const query = e.target.value.trim();
                    
                    if (query.length > 0) {
                        searchTimeout = setTimeout(() => {
                            console.log('Searching for:', query);
                            // TODO: Implement global search
                        }, 300);
                    }
                });
            }
        });
        
        // Utility functions
        window.PingPongApp = window.PingPongApp || {};
        window.PingPongApp.showMessage = function(message, type = 'info') {
            const container = document.getElementById('message-container');
            if (!container) return;
            
            const colors = {
                success: 'bg-green-50 border-green-200 text-green-800',
                error: 'bg-red-50 border-red-200 text-red-800',
                warning: 'bg-yellow-50 border-yellow-200 text-yellow-800',
                info: 'bg-blue-50 border-blue-200 text-blue-800'
            };
            
            const icons = {
                success: 'check-circle',
                error: 'alert-circle',
                warning: 'alert-triangle',
                info: 'info'
            };
            
            const messageEl = document.createElement('div');
            messageEl.className = `p-4 rounded-lg border ${colors[type]} flex items-center fade-in`;
            messageEl.innerHTML = `
                <i data-lucide="${icons[type]}" class="w-5 h-5 mr-3 flex-shrink-0"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto p-1 hover:bg-black/10 rounded">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            `;
            
            container.appendChild(messageEl);
            container.style.display = 'block';
            
            // Re-initialize icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                messageEl.remove();
                if (!container.children.length) {
                    container.style.display = 'none';
                }
            }, 5000);
        };
    </script><?php
    // Initialize Lucide icons when page loads
    echo '<script>
        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    </script>';
?>