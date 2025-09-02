<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <header class="bg-card p-4 border-b border-border shadow-soft">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg gradient-orange flex items-center justify-center mr-3">
                    <i data-lucide="table-tennis-paddle" class="w-5 h-5 text-white"></i>
                </div>
                <h1 class="text-xl font-bold text-foreground">PingPong+</h1>
            </div>
            <div class="flex items-center space-x-3">
                <!-- Notifications -->
                <button class="relative p-2 text-muted-foreground hover:text-foreground transition-colors" data-tooltip="Notifications">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <?php if ($unreadCount > 0): ?>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-medium">
                        <?= $unreadCount ?>
                    </span>
                    <?php endif; ?>
                </button>
                
                <!-- Settings -->
                <button class="p-2 text-muted-foreground hover:text-foreground transition-colors" data-tooltip="Settings">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
        
        <!-- User Location & Status -->
        <div class="flex items-center text-sm text-muted-foreground">
            <div class="flex items-center">
                <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
                <span><?= htmlspecialchars($user['location'] ?? 'Location not set') ?></span>
            </div>
            <span class="status-dot status-online mx-3"></span>
            <span class="text-green-600 font-medium">Online</span>
            
            <?php if ($user['clubShortName']): ?>
            <div class="flex items-center ml-4 text-orange-500 font-medium">
                <i data-lucide="building" class="w-4 h-4 mr-1"></i>
                <span><?= htmlspecialchars($user['clubShortName']) ?></span>
            </div>
            <?php endif; ?>
        </div>
    </header>
    
    <div class="p-4 space-y-6">
        <!-- Search Bar -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-5 h-5 text-muted-foreground"></i>
            </div>
            <input type="text" 
                   placeholder="Search players, venues, tournaments..." 
                   class="search-input w-full pl-10 pr-4 py-3">
        </div>
        
        <!-- User Profile Card -->
        <div class="card gradient-orange text-white p-6 shadow-medium">
            <div class="flex items-center">
                <!-- Avatar -->
                <div class="relative">
                    <img src="<?= htmlspecialchars($user['photo'] ?? 'https://via.placeholder.com/150') ?>" 
                         class="w-16 h-16 rounded-full border-4 border-white/30 shadow-lg object-cover">
                    <?php if ($user['online']): ?>
                    <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-1">
                        <div class="status-dot status-online"></div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- User Info -->
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold"><?= htmlspecialchars($user['name']) ?></h3>
                    <div class="flex items-center text-sm text-orange-100">
                        <i data-lucide="star" class="w-4 h-4 mr-1"></i>
                        <span class="font-semibold"><?= htmlspecialchars($user['elo'] ?? 0) ?> Rating</span>
                    </div>
                    <div class="flex items-center mt-2 space-x-2">
                        <span class="badge bg-white/20 text-white">
                            <?= htmlspecialchars($user['skill'] ?? 'Unranked') ?>
                        </span>
                        <span class="badge bg-white/20 text-white">
                            <?= htmlspecialchars($user['style'] ?? 'All-round') ?>
                        </span>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="flex flex-col space-y-2">
                    <button class="btn bg-white/20 hover:bg-white/30 text-white border-white/30 text-sm">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        Edit
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Stats Grid -->
        <div class="stats-grid">
            <?php 
            $winRate = ($user['matches'] ?? 0) > 0 ? round(($user['wins'] / $user['matches']) * 100) : 0;
            $statsData = [
                ['icon' => 'gamepad-2', 'value' => $user['matches'] ?? 0, 'label' => 'Games'],
                ['icon' => 'trophy', 'value' => $user['wins'] ?? 0, 'label' => 'Wins'],
                ['icon' => 'trending-up', 'value' => $winRate . '%', 'label' => 'Win Rate'],
                ['icon' => 'hash', 'value' => '#' . ($user['current_rank'] ?? 'N/A'), 'label' => 'Rank']
            ];
            ?>
            
            <?php foreach ($statsData as $stat): ?>
            <div class="stat-item">
                <div class="flex flex-col items-center">
                    <i data-lucide="<?= $stat['icon'] ?>" class="w-6 h-6 text-orange-500 mb-2"></i>
                    <p class="stat-value"><?= $stat['value'] ?></p>
                    <p class="stat-label"><?= $stat['label'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Quick Actions -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <?php 
            $quickActions = [
                ['icon' => 'search', 'label' => 'Find Opponent', 'href' => 'discover.php', 'color' => 'bg-blue-50 hover:bg-blue-100 text-blue-700'],
                ['icon' => 'calendar', 'label' => 'Book Venue', 'href' => 'play.php#venues', 'color' => 'bg-green-50 hover:bg-green-100 text-green-700'],
                ['icon' => 'trophy', 'label' => 'Tournaments', 'href' => 'play.php#tournaments', 'color' => 'bg-yellow-50 hover:bg-yellow-100 text-yellow-700'],
                ['icon' => 'shopping-bag', 'label' => 'Marketplace', 'href' => '#marketplace', 'color' => 'bg-purple-50 hover:bg-purple-100 text-purple-700']
            ];
            ?>
            
            <?php foreach ($quickActions as $action): ?>
            <a href="<?= $action['href'] ?>" class="<?= $action['color'] ?> p-4 rounded-lg border transition-all duration-200 text-center hover:shadow-soft">
                <i data-lucide="<?= $action['icon'] ?>" class="w-8 h-8 mx-auto mb-2"></i>
                <p class="font-semibold text-sm"><?= $action['label'] ?></p>
            </a>
            <?php endforeach; ?>
        </div>
        
        <!-- Community Feed -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-foreground flex items-center">
                    <i data-lucide="activity" class="w-5 h-5 mr-2 text-orange-500"></i>
                    Community Feed
                </h3>
                <button class="text-sm text-orange-500 hover:text-orange-600 font-medium">View All</button>
            </div>
            
            <div class="space-y-4">
                <?php if (empty($feedPosts)): ?>
                <div class="card p-8 text-center">
                    <i data-lucide="activity" class="w-12 h-12 text-muted-foreground mx-auto mb-4"></i>
                    <p class="text-muted-foreground mb-4">Community feed is empty.</p>
                    <button class="btn btn-primary">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Share Your Game
                    </button>
                </div>
                <?php else: ?>
                    <?php foreach ($feedPosts as $post): ?>
                    <div class="feed-card">
                        <!-- Feed Header -->
                        <div class="feed-header">
                            <div class="feed-avatar">
                                <?php if ($post['userPhoto']): ?>
                                <img src="<?= htmlspecialchars($post['userPhoto']) ?>" 
                                     class="w-full h-full rounded-full object-cover">
                                <?php else: ?>
                                <i data-lucide="user" class="w-6 h-6"></i>
                                <?php endif; ?>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-foreground">
                                    <?= htmlspecialchars($post['userName'] ?? 'Anonymous User') ?>
                                </p>
                                <div class="flex items-center text-xs text-muted-foreground">
                                    <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                    <span><?= date('M d, H:i', strtotime($post['created_at'])) ?></span>
                                    
                                    <!-- Post type badge -->
                                    <span class="badge badge-status ml-2 text-xs">
                                        <?= ucfirst(str_replace('_', ' ', $post['type'])) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- More actions -->
                            <button class="p-1 text-muted-foreground hover:text-foreground">
                                <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                            </button>
                        </div>
                        
                        <!-- Feed Content -->
                        <div class="feed-content">
                            <?= nl2br(htmlspecialchars($post['content'] ?? '')) ?>
                        </div>
                        
                        <!-- Feed Actions -->
                        <div class="feed-actions border-t border-border pt-3">
                            <button class="flex items-center hover:text-red-500 transition-colors">
                                <i data-lucide="heart" class="w-4 h-4 mr-1"></i>
                                <span><?= $post['likes'] ?? 0 ?></span>
                            </button>
                            <button class="flex items-center hover:text-blue-500 transition-colors">
                                <i data-lucide="message-circle" class="w-4 h-4 mr-1"></i>
                                <span><?= $post['comments'] ?? 0 ?></span>
                            </button>
                            <button class="flex items-center hover:text-green-500 transition-colors">
                                <i data-lucide="share" class="w-4 h-4 mr-1"></i>
                                Share
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="card p-4">
            <h3 class="font-semibold text-foreground mb-3 flex items-center">
                <i data-lucide="clock" class="w-5 h-5 mr-2 text-orange-500"></i>
                Recent Activity
            </h3>
            
            <div class="space-y-3">
                <?php 
                // Sample recent activities - you can replace with actual data
                $recentActivities = [
                    ['icon' => 'gamepad-2', 'text' => 'Played a match with John Doe', 'time' => '2 hours ago', 'color' => 'text-blue-500'],
                    ['icon' => 'trophy', 'text' => 'Won the Monthly Tournament', 'time' => '1 day ago', 'color' => 'text-yellow-500'],
                    ['icon' => 'user-plus', 'text' => 'Joined Jakarta TTC Club', 'time' => '3 days ago', 'color' => 'text-green-500'],
                ];
                ?>
                
                <?php foreach ($recentActivities as $activity): ?>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-muted flex items-center justify-center mr-3">
                        <i data-lucide="<?= $activity['icon'] ?>" class="w-4 h-4 <?= $activity['color'] ?>"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-foreground"><?= $activity['text'] ?></p>
                        <p class="text-xs text-muted-foreground"><?= $activity['time'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>