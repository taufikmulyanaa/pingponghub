<?php
// File: templates/profile_template.php
if (!$user): ?>
    <div class="max-w-4xl mx-auto p-4">
        <header class="bg-card p-4 border-b border-border">
            <h1 class="text-xl font-bold text-foreground flex items-center">
                <i data-lucide="alert-circle" class="w-6 h-6 text-red-500 mr-2"></i>
                Error
            </h1>
        </header>
        <div class="card p-8 text-center">
            <i data-lucide="user-x" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
            <p class="text-muted-foreground mb-4">User not found.</p>
            <a href="index.php" class="btn btn-primary">
                <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                Go Home
            </a>
        </div>
    </div>
<?php else: 
    // Get variables from controller scope
    global $loggedInUserId, $userId;
?>
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <header class="bg-card p-4 border-b border-border shadow-soft">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <?php if ($userId !== $loggedInUserId): ?>
                <button onclick="history.back()" class="btn btn-ghost mr-2 p-2">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </button>
                <?php endif; ?>
                <div class="flex items-center">
                    <i data-lucide="user" class="w-6 h-6 text-orange-500 mr-2"></i>
                    <h1 class="text-xl font-bold text-foreground">
                        <?= $userId === $loggedInUserId ? 'My Profile' : 'Player Profile' ?>
                    </h1>
                </div>
            </div>
            
            <?php if ($userId === $loggedInUserId): ?>
            <button class="btn btn-primary">
                <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                Edit Profile
            </button>
            <?php else: ?>
            <div class="flex items-center space-x-2">
                <button class="btn btn-secondary" data-tooltip="Add to Friends">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                </button>
                <button class="btn btn-primary">
                    <i data-lucide="message-circle" class="w-4 h-4 mr-2"></i>
                    Message
                </button>
            </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- Profile Header Card -->
    <div class="profile-header gradient-orange text-white">
        <div class="relative">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="flex space-x-8 transform rotate-12">
                    <i data-lucide="table-tennis-paddle" class="w-12 h-12"></i>
                    <i data-lucide="trophy" class="w-10 h-10"></i>
                    <i data-lucide="star" class="w-8 h-8"></i>
                </div>
            </div>
            
            <!-- Avatar -->
            <div class="profile-avatar mb-4">
                <?php if ($user['photo']): ?>
                <img src="<?= htmlspecialchars($user['photo']) ?>" 
                     class="w-full h-full rounded-full object-cover">
                <?php else: ?>
                <i data-lucide="user" class="w-12 h-12"></i>
                <?php endif; ?>
            </div>
            
            <!-- User Info -->
            <h2 class="text-3xl font-bold mb-2"><?= htmlspecialchars($user['name']) ?></h2>
            
            <div class="flex items-center justify-center text-orange-100 mb-4 space-x-4">
                <div class="flex items-center">
                    <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
                    <span><?= htmlspecialchars($user['location'] ?? 'Location not set') ?></span>
                </div>
                <div class="flex items-center">
                    <i data-lucide="star" class="w-4 h-4 mr-1"></i>
                    <span class="font-semibold"><?= htmlspecialchars($user['elo'] ?? '0') ?> Rating</span>
                </div>
            </div>
            
            <!-- Badges -->
            <div class="flex items-center justify-center space-x-3 mb-4">
                <span class="badge bg-white/20 text-white border-white/30">
                    <i data-lucide="award" class="w-3 h-3 mr-1"></i>
                    <?= htmlspecialchars($user['skill'] ?? 'Unranked') ?>
                </span>
                <span class="badge bg-white/20 text-white border-white/30">
                    <i data-lucide="zap" class="w-3 h-3 mr-1"></i>
                    <?= htmlspecialchars($user['style'] ?? 'All-round') ?>
                </span>
                <?php if ($user['online']): ?>
                <span class="badge bg-green-500 text-white">
                    <span class="status-dot status-online mr-1"></span>
                    Online Now
                </span>
                <?php endif; ?>
            </div>
            
            <!-- Club Info -->
            <?php if ($user['clubName']): ?>
            <div class="inline-flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg border border-white/30">
                <?php if ($user['clubLogo']): ?>
                <img src="<?= htmlspecialchars($user['clubLogo']) ?>" class="w-6 h-6 rounded-full mr-2">
                <?php else: ?>
                <i data-lucide="building" class="w-5 h-5 mr-2"></i>
                <?php endif; ?>
                <span class="font-medium"><?= htmlspecialchars($user['clubName']) ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="p-4">
        <h3 class="font-semibold text-foreground mb-4 flex items-center">
            <i data-lucide="bar-chart" class="w-5 h-5 mr-2 text-orange-500"></i>
            Player Statistics
        </h3>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <?php
            $matches = $user['matches'] ?? 0;
            $wins = $user['wins'] ?? 0;
            $winRate = ($matches > 0) ? round(($wins / $matches) * 100) : 0;
            
            $statsData = [
                [
                    'icon' => 'gamepad-2',
                    'value' => number_format($matches),
                    'label' => 'Total Matches',
                    'color' => 'text-blue-600',
                    'bgColor' => 'bg-blue-50'
                ],
                [
                    'icon' => 'trending-up',
                    'value' => $winRate . '%',
                    'label' => 'Win Rate',
                    'color' => 'text-green-600',
                    'bgColor' => 'bg-green-50'
                ],
                [
                    'icon' => 'trophy',
                    'value' => number_format($user['tournaments'] ?? 0),
                    'label' => 'Tournaments',
                    'color' => 'text-yellow-600',
                    'bgColor' => 'bg-yellow-50'
                ],
                [
                    'icon' => 'hash',
                    'value' => '#' . ($user['current_rank'] ?? 'N/A'),
                    'label' => 'Current Rank',
                    'color' => 'text-purple-600',
                    'bgColor' => 'bg-purple-50'
                ]
            ];
            ?>
            
            <?php foreach ($statsData as $stat): ?>
            <div class="card p-4 text-center <?= $stat['bgColor'] ?> border-0">
                <div class="w-12 h-12 <?= $stat['bgColor'] ?> rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="<?= $stat['icon'] ?>" class="w-6 h-6 <?= $stat['color'] ?>"></i>
                </div>
                <p class="text-2xl font-bold text-foreground mb-1"><?= $stat['value'] ?></p>
                <p class="text-sm text-muted-foreground"><?= $stat['label'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Equipment Section -->
        <div class="card p-6 mb-6">
            <h3 class="font-semibold text-foreground mb-4 flex items-center">
                <i data-lucide="table-tennis-paddle" class="w-5 h-5 mr-2 text-orange-500"></i>
                Equipment Setup
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php 
                // You can fetch equipment data from user_equipment table
                $equipment = [
                    ['icon' => 'square', 'label' => 'Blade', 'value' => 'Butterfly Viscaria'],
                    ['icon' => 'circle', 'label' => 'Forehand Rubber', 'value' => 'DHS Hurricane 3'],
                    ['icon' => 'circle', 'label' => 'Backhand Rubber', 'value' => 'Tenergy 05']
                ];
                ?>
                
                <?php foreach ($equipment as $item): ?>
                <div class="flex items-center p-3 bg-muted rounded-lg">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mr-3">
                        <i data-lucide="<?= $item['icon'] ?>" class="w-5 h-5 text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-muted-foreground"><?= $item['label'] ?></p>
                        <p class="font-medium text-foreground"><?= $item['value'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="card p-6 mb-6">
            <h3 class="font-semibold text-foreground mb-4 flex items-center">
                <i data-lucide="activity" class="w-5 h-5 mr-2 text-orange-500"></i>
                Recent Activity
            </h3>
            
            <div class="space-y-4">
                <?php 
                // Sample activities - replace with real data
                $activities = [
                    [
                        'icon' => 'trophy',
                        'title' => 'Won Tournament',
                        'description' => 'First place in Weekly Singles',
                        'time' => '2 days ago',
                        'color' => 'text-yellow-500',
                        'bgColor' => 'bg-yellow-50'
                    ],
                    [
                        'icon' => 'gamepad-2',
                        'title' => 'Match Completed',
                        'description' => 'Defeated John Doe 3-1',
                        'time' => '1 week ago',
                        'color' => 'text-green-500',
                        'bgColor' => 'bg-green-50'
                    ],
                    [
                        'icon' => 'users',
                        'title' => 'Joined Club',
                        'description' => 'Became member of Jakarta TTC',
                        'time' => '2 weeks ago',
                        'color' => 'text-blue-500',
                        'bgColor' => 'bg-blue-50'
                    ]
                ];
                ?>
                
                <?php foreach ($activities as $activity): ?>
                <div class="flex items-center">
                    <div class="w-10 h-10 <?= $activity['bgColor'] ?> rounded-lg flex items-center justify-center mr-3">
                        <i data-lucide="<?= $activity['icon'] ?>" class="w-5 h-5 <?= $activity['color'] ?>"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-foreground"><?= $activity['title'] ?></p>
                        <p class="text-sm text-muted-foreground"><?= $activity['description'] ?></p>
                    </div>
                    <span class="text-xs text-muted-foreground"><?= $activity['time'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Achievements -->
        <div class="card p-6">
            <h3 class="font-semibold text-foreground mb-4 flex items-center">
                <i data-lucide="award" class="w-5 h-5 mr-2 text-orange-500"></i>
                Achievements
            </h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php 
                // Sample achievements - replace with real data from user_achievements
                $achievements = [
                    ['icon' => 'trophy', 'name' => 'First Victory', 'color' => 'text-yellow-500'],
                    ['icon' => 'target', 'name' => '100 Matches', 'color' => 'text-blue-500'],
                    ['icon' => 'crown', 'name' => 'Club Champion', 'color' => 'text-purple-500'],
                    ['icon' => 'star', 'name' => 'Top 10 Rank', 'color' => 'text-green-500']
                ];
                ?>
                
                <?php foreach ($achievements as $achievement): ?>
                <div class="text-center p-3 bg-muted rounded-lg hover:shadow-soft transition-all">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mx-auto mb-2">
                        <i data-lucide="<?= $achievement['icon'] ?>" class="w-6 h-6 <?= $achievement['color'] ?>"></i>
                    </div>
                    <p class="text-sm font-medium text-foreground"><?= $achievement['name'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>