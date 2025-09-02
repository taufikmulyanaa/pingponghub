<?php // File: templates/play_template.php ?>
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <header class="bg-card p-4 border-b border-border sticky top-0 z-40 shadow-soft">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <i data-lucide="play" class="w-6 h-6 text-orange-500 mr-2"></i>
                <h1 class="text-xl font-bold text-foreground">Play Hub</h1>
            </div>
            <button class="btn btn-primary">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Create Event
            </button>
        </div>
        
        <!-- Search Bar -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-5 h-5 text-muted-foreground"></i>
            </div>
            <input type="text" 
                   placeholder="Search tournaments, venues, events..." 
                   class="search-input w-full pl-10 pr-4 py-3">
        </div>
    </header>

    <div class="p-4 space-y-8">
        <!-- Quick Actions Grid -->
        <div>
            <h3 class="font-semibold text-foreground mb-4 flex items-center">
                <i data-lucide="zap" class="w-5 h-5 mr-2 text-orange-500"></i>
                Quick Actions
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php 
                $quickActions = [
                    [
                        'icon' => 'users',
                        'title' => 'Find Opponent',
                        'subtitle' => 'Match now',
                        'href' => 'discover.php',
                        'color' => 'bg-blue-50 hover:bg-blue-100 border-blue-200',
                        'textColor' => 'text-blue-800',
                        'iconColor' => 'text-blue-600'
                    ],
                    [
                        'icon' => 'map-pin',
                        'title' => 'Book Venue',
                        'subtitle' => 'Reserve court',
                        'href' => '#venues',
                        'color' => 'bg-green-50 hover:bg-green-100 border-green-200',
                        'textColor' => 'text-green-800',
                        'iconColor' => 'text-green-600'
                    ],
                    [
                        'icon' => 'trophy',
                        'title' => 'Tournaments',
                        'subtitle' => 'Join competitions',
                        'href' => '#tournaments',
                        'color' => 'bg-yellow-50 hover:bg-yellow-100 border-yellow-200',
                        'textColor' => 'text-yellow-800',
                        'iconColor' => 'text-yellow-600'
                    ],
                    [
                        'icon' => 'shopping-bag',
                        'title' => 'Equipment',
                        'subtitle' => 'Buy gear',
                        'href' => '#marketplace',
                        'color' => 'bg-purple-50 hover:bg-purple-100 border-purple-200',
                        'textColor' => 'text-purple-800',
                        'iconColor' => 'text-purple-600'
                    ]
                ];
                ?>
                
                <?php foreach ($quickActions as $action): ?>
                <a href="<?= $action['href'] ?>" class="<?= $action['color'] ?> p-4 rounded-xl border transition-all duration-200 text-center hover:shadow-soft group">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-lg bg-white/70 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i data-lucide="<?= $action['icon'] ?>" class="w-6 h-6 <?= $action['iconColor'] ?>"></i>
                        </div>
                        <h4 class="font-bold <?= $action['textColor'] ?> text-sm mb-1"><?= $action['title'] ?></h4>
                        <p class="text-xs <?= $action['textColor'] ?>/70"><?= $action['subtitle'] ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Upcoming Tournaments -->
        <div id="tournaments">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-foreground flex items-center">
                    <i data-lucide="trophy" class="w-5 h-5 mr-2 text-orange-500"></i>
                    Upcoming Tournaments
                </h3>
                <a href="#" class="text-sm text-orange-500 hover:text-orange-600 font-medium flex items-center">
                    View All
                    <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>
            
            <div class="space-y-4">
                <?php if (empty($tournaments)): ?>
                <div class="card p-8 text-center">
                    <i data-lucide="trophy" class="w-12 h-12 text-muted-foreground mx-auto mb-4"></i>
                    <p class="text-muted-foreground mb-4">No tournaments available at the moment.</p>
                    <button class="btn btn-primary">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Organize Tournament
                    </button>
                </div>
                <?php else: ?>
                    <?php foreach ($tournaments as $tournament):
                        $participants = $tournament['participants'] ?? 0;
                        $maxParticipants = $tournament['max_participants'] > 0 ? $tournament['max_participants'] : 1;
                        $progress = min(($participants / $maxParticipants) * 100, 100);
                        $isFull = $participants >= $maxParticipants;
                        $isAlmostFull = $progress > 80;
                    ?>
                    <div class="tournament-card hover:shadow-medium transition-all duration-200">
                        <!-- Tournament Header -->
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h4 class="font-bold text-foreground text-lg mb-1">
                                    <?= htmlspecialchars($tournament['name']) ?>
                                </h4>
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="badge badge-status">
                                        <i data-lucide="calendar" class="w-3 h-3 mr-1"></i>
                                        <?= ucfirst($tournament['type']) ?>
                                    </span>
                                    <span class="badge badge-skill-intermediate">
                                        <?= htmlspecialchars($tournament['category']) ?>
                                    </span>
                                    <?php if ($isAlmostFull && !$isFull): ?>
                                    <span class="badge bg-orange-100 text-orange-800 animate-pulse">
                                        <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                        Almost Full
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tournament Details -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center text-sm text-muted-foreground">
                                <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                                <span><?= date("M d, Y", strtotime($tournament['date'])) ?></span>
                            </div>
                            <div class="flex items-center text-sm text-muted-foreground">
                                <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i>
                                <span><?= htmlspecialchars($tournament['location']) ?></span>
                            </div>
                            <div class="flex items-center text-sm text-muted-foreground">
                                <i data-lucide="award" class="w-4 h-4 mr-2"></i>
                                <span class="font-semibold">$<?= number_format($tournament['prize'], 0) ?></span>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-foreground">Registration Progress</span>
                                <span class="text-sm text-muted-foreground">
                                    <i data-lucide="users" class="w-4 h-4 inline mr-1"></i>
                                    <?= $participants ?>/<?= $maxParticipants ?>
                                </span>
                            </div>
                            <div class="tournament-progress">
                                <div class="tournament-progress-bar <?= $isAlmostFull ? 'bg-orange-500' : '' ?>" 
                                     style="width: <?= $progress ?>%"></div>
                            </div>
                        </div>
                        
                        <!-- Tournament Footer -->
                        <div class="flex items-center justify-between border-t border-border pt-4">
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-foreground mr-2">
                                    $<?= number_format($tournament['fee'], 0) ?>
                                </span>
                                <span class="text-sm text-muted-foreground">entry fee</span>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <button class="btn btn-secondary" data-tooltip="Share Tournament">
                                    <i data-lucide="share" class="w-4 h-4"></i>
                                </button>
                                <button class="btn btn-secondary" data-tooltip="More Info">
                                    <i data-lucide="info" class="w-4 h-4"></i>
                                </button>
                                <?php if($isFull): ?>
                                <button class="btn bg-gray-200 text-gray-500 cursor-not-allowed" disabled>
                                    <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                                    Full
                                </button>
                                <?php else: ?>
                                <button class="btn btn-primary shadow-sm">
                                    <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                                    Register
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Nearby Venues -->
        <div id="venues">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-foreground flex items-center">
                    <i data-lucide="map-pin" class="w-5 h-5 mr-2 text-orange-500"></i>
                    Nearby Venues
                </h3>
                <a href="#" class="text-sm text-orange-500 hover:text-orange-600 font-medium flex items-center">
                    View All
                    <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

            <div class="space-y-3">
                <?php if(empty($venues)): ?>
                <div class="card p-8 text-center">
                    <i data-lucide="map-pin" class="w-12 h-12 text-muted-foreground mx-auto mb-4"></i>
                    <p class="text-muted-foreground mb-4">No nearby venues found.</p>
                    <button class="btn btn-primary">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Add Venue
                    </button>
                </div>
                <?php else: ?>
                    <?php foreach($venues as $venue): ?>
                    <div class="venue-card hover:shadow-medium transition-all duration-200">
                        <!-- Venue Icon/Image -->
                        <div class="venue-icon">
                            <i data-lucide="building" class="w-8 h-8"></i>
                        </div>
                        
                        <!-- Venue Info -->
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-foreground">
                                    <?= htmlspecialchars($venue['name']) ?>
                                </h4>
                                <div class="flex items-center text-sm font-medium text-muted-foreground">
                                    <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
                                    <span><?= htmlspecialchars($venue['distance']) ?> km</span>
                                </div>
                            </div>
                            
                            <!-- Venue Details -->
                            <div class="flex items-center space-x-4 text-sm text-muted-foreground mb-3">
                                <div class="flex items-center">
                                    <i data-lucide="star" class="w-4 h-4 mr-1"></i>
                                    <span><?= htmlspecialchars($venue['rating']) ?></span>
                                </div>
                                <div class="flex items-center">
                                    <i data-lucide="message-circle" class="w-4 h-4 mr-1"></i>
                                    <span><?= htmlspecialchars($venue['reviews']) ?> reviews</span>
                                </div>
                                <div class="flex items-center">
                                    <i data-lucide="layout-grid" class="w-4 h-4 mr-1"></i>
                                    <span><?= htmlspecialchars($venue['tables']) ?> tables</span>
                                </div>
                            </div>
                            
                            <!-- Price & Actions -->
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-lg font-bold text-orange-600">
                                        $<?= number_format($venue['price'], 0) ?>
                                    </span>
                                    <span class="text-sm text-muted-foreground">/hour</span>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <button class="btn btn-secondary" data-tooltip="View Details">
                                        <i data-lucide="info" class="w-4 h-4"></i>
                                    </button>
                                    <button class="btn btn-primary">
                                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                                        Book Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Featured Section -->
        <div class="card p-6 gradient-blue text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold mb-2">Join the Championship!</h3>
                    <p class="text-blue-100 mb-4">Annual Table Tennis Championship is coming soon. Register now for early bird pricing.</p>
                    <button class="btn bg-white text-blue-600 hover:bg-blue-50">
                        <i data-lucide="trophy" class="w-4 h-4 mr-2"></i>
                        Learn More
                    </button>
                </div>
                <div class="hidden md:block">
                    <i data-lucide="trophy" class="w-24 h-24 text-white/30"></i>
                </div>
            </div>
        </div>
    </div>
</div>