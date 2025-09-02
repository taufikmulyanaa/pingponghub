<?php 
require_once 'config/db.php'; 
require_once 'lib/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PingPong+ - Table Tennis Community</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
                        border: 'hsl(214.3, 31.8%, 91.4%)',
                        input: 'hsl(214.3, 31.8%, 91.4%)',
                        ring: 'hsl(222.2, 84%, 4.9%)',
                        background: 'hsl(0, 0%, 100%)',
                        foreground: 'hsl(222.2, 84%, 4.9%)',
                        primary: {
                            DEFAULT: 'hsl(221.2, 83.2%, 53.3%)',
                            foreground: 'hsl(210, 40%, 98%)',
                        },
                        secondary: {
                            DEFAULT: 'hsl(210, 40%, 96.1%)',
                            foreground: 'hsl(222.2, 47.4%, 11.2%)',
                        },
                        muted: {
                            DEFAULT: 'hsl(210, 40%, 96.1%)',
                            foreground: 'hsl(215.4, 16.3%, 46.9%)',
                        },
                        accent: {
                            DEFAULT: 'hsl(210, 40%, 96.1%)',
                            foreground: 'hsl(222.2, 47.4%, 11.2%)',
                        },
                        card: {
                            DEFAULT: 'hsl(0, 0%, 100%)',
                            foreground: 'hsl(222.2, 84%, 4.9%)',
                        },
                    },
                    borderRadius: {
                        lg: `0.5rem`,
                        md: `calc(0.5rem - 2px)`,
                        sm: `calc(0.5rem - 4px)`,
                    },
                }
            }
        }
    </script>
    
    <style>
        /* Critical CSS for immediate rendering */
        body {
            font-family: 'Inter', sans-serif;
            background-color: hsl(210, 40%, 98%);
            padding-bottom: 64px;
        }
        @media (min-width: 768px) {
            body { padding-bottom: 0; }
        }
    </style>
</head>
<body class="bg-muted/40 font-sans text-foreground antialiased">

    <div class="flex min-h-screen bg-background">
        <!-- Desktop Sidebar -->
        <aside class="hidden md:block w-64 flex-shrink-0 flex flex-col border-r border-border bg-card">
            <div class="p-6 flex-1">
                <!-- Logo -->
                <div class="flex items-center mb-8">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center mr-3 shadow-lg">
                        <i data-lucide="table-tennis-paddle" class="w-6 h-6 text-white"></i>
                    </div>
                    <h1 class="text-xl font-bold text-foreground">PingPong+</h1>
                </div>
                
                <!-- Navigation -->
                <nav class="flex flex-col space-y-2">
                    <?php
                    $navItems = [
                        ['id' => 'index', 'label' => 'Home', 'icon' => 'home', 'description' => 'Dashboard & Feed'],
                        ['id' => 'discover', 'label' => 'Discover', 'icon' => 'compass', 'description' => 'Find Players'],
                        ['id' => 'play', 'label' => 'Play', 'icon' => 'play', 'description' => 'Tournaments & Venues'],
                        ['id' => 'ptm', 'label' => 'Clubs', 'icon' => 'building', 'description' => 'Club Management'],
                        ['id' => 'profile', 'label' => 'Profile', 'icon' => 'user', 'description' => 'My Profile']
                    ];
                    $currentPage = basename($_SERVER['PHP_SELF'], ".php");

                    foreach ($navItems as $item) {
                        $isActive = ($currentPage == $item['id']) ? 'nav-item active' : 'nav-item';
                        echo "<a href='{$item['id']}.php' class='{$isActive} group' data-tooltip='{$item['description']}'>
                                <i data-lucide='{$item['icon']}' class='w-5 h-5 transition-transform group-hover:scale-110'></i>
                                <div class='flex flex-col'>
                                    <span class='font-medium'>{$item['label']}</span>
                                    <span class='text-xs opacity-70'>{$item['description']}</span>
                                </div>
                              </a>";
                    }
                    ?>
                </nav>
            </div>
            
            <!-- User Profile Section -->
            <div class="p-6 border-t border-border">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold mr-3">
                        BS
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-foreground truncate">Budi Santoso</p>
                        <p class="text-xs text-muted-foreground">Stoni TTC</p>
                    </div>
                    <button class="p-1 text-muted-foreground hover:text-foreground transition-colors">
                        <i data-lucide="settings" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-h-screen overflow-y-auto"><?php
    // Initialize Lucide icons when page loads
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof lucide !== "undefined") {
                lucide.createIcons();
            }
        });
    </script>';
?>