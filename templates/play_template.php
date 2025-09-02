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
        <!-- Upcoming Tournaments -->
        <div id="tournaments">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-foreground flex items-center">
                    <i data-lucide="trophy" class="w-6 h-6 mr-3 text-orange-500"></i>
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
                    <i data-lucide="trophy" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
                    <h4 class="text-lg font-semibold text-foreground mb-2">No Tournaments Available</h4>
                    <p class="text-muted-foreground mb-6">Be the first to organize a tournament in your community!</p>
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
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h4 class="font-bold text-foreground text-lg mb-2">
                                    <?= htmlspecialchars($tournament['name']) ?>
                                </h4>
                                <div class="flex items-center space-x-2 mb-3">
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
                            
                            <!-- Prize Badge -->
                            <div class="text-right">
                                <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-3 py-1 rounded-lg">
                                    <div class="text-lg font-bold">$<?= number_format($tournament['prize'], 0) ?></div>
                                    <div class="text-xs opacity-90">Prize Pool</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tournament Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="flex items-center p-3 bg-muted rounded-lg">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-muted-foreground">Date</p>
                                    <p class="font-medium text-foreground"><?= date("M d, Y", strtotime($tournament['date'])) ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-muted rounded-lg">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-green-600"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm text-muted-foreground">Location</p>
                                    <p class="font-medium text-foreground truncate"><?= htmlspecialchars($tournament['location']) ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-muted rounded-lg">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i data-lucide="dollar-sign" class="w-5 h-5 text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-muted-foreground">Entry Fee</p>
                                    <p class="font-medium text-foreground">$<?= number_format($tournament['fee'], 0) ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="mb-6">
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
                            <div class="flex items-center space-x-4">
                                <button class="btn btn-secondary" data-tooltip="Share Tournament">
                                    <i data-lucide="share" class="w-4 h-4 mr-2"></i>
                                    Share
                                </button>
                                <button class="btn btn-secondary" data-tooltip="More Info">
                                    <i data-lucide="info" class="w-4 h-4 mr-2"></i>
                                    Details
                                </button>
                            </div>
                            
                            <?php if($isFull): ?>
                            <button class="btn bg-gray-200 text-gray-500 cursor-not-allowed" disabled>
                                <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                                Tournament Full
                            </button>
                            <?php else: ?>
                            <button class="btn btn-primary shadow-sm">
                                <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                                Register Now
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Nearby Venues -->
        <div id="venues">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-foreground flex items-center">
                    <i data-lucide="map-pin" class="w-6 h-6 mr-3 text-orange-500"></i>
                    Nearby Venues
                </h3>
                <a href="#" class="text-sm text-orange-500 hover:text-orange-600 font-medium flex items-center">
                    View All
                    <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if(empty($venues)): ?>
                <div class="col-span-full">
                    <div class="card p-8 text-center">
                        <i data-lucide="map-pin" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
                        <h4 class="text-lg font-semibold text-foreground mb-2">No Venues Found</h4>
                        <p class="text-muted-foreground mb-6">Help grow the community by adding venues in your area!</p>
                        <button class="btn btn-primary">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                            Add Venue
                        </button>
                    </div>
                </div>
                <?php else: ?>
                    <?php foreach($venues as $venue): ?>
                    <div class="venue-card hover:shadow-medium transition-all duration-200">
                        <!-- Venue Header -->
                        <div class="flex items-center mb-4">
                            <div class="venue-icon mr-4">
                                <i data-lucide="building" class="w-8 h-8"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-foreground text-lg mb-1">
                                    <?= htmlspecialchars($venue['name']) ?>
                                </h4>
                                <div class="flex items-center text-sm text-muted-foreground">
                                    <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
                                    <span><?= htmlspecialchars($venue['distance']) ?> km away</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Venue Stats -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="text-center p-2 bg-muted rounded-lg">
                                <div class="flex items-center justify-center mb-1">
                                    <i data-lucide="star" class="w-4 h-4 text-yellow-500"></i>
                                </div>
                                <p class="text-sm font-bold text-foreground"><?= htmlspecialchars($venue['rating']) ?></p>
                                <p class="text-xs text-muted-foreground">Rating</p>
                            </div>
                            <div class="text-center p-2 bg-muted rounded-lg">
                                <div class="flex items-center justify-center mb-1">
                                    <i data-lucide="layout-grid" class="w-4 h-4 text-blue-500"></i>
                                </div>
                                <p class="text-sm font-bold text-foreground"><?= htmlspecialchars($venue['tables']) ?></p>
                                <p class="text-xs text-muted-foreground">Tables</p>
                            </div>
                            <div class="text-center p-2 bg-muted rounded-lg">
                                <div class="flex items-center justify-center mb-1">
                                    <i data-lucide="message-circle" class="w-4 h-4 text-green-500"></i>
                                </div>
                                <p class="text-sm font-bold text-foreground"><?= htmlspecialchars($venue['reviews']) ?></p>
                                <p class="text-xs text-muted-foreground">Reviews</p>
                            </div>
                        </div>
                        
                        <!-- Price & Actions -->
                        <div class="flex justify-between items-center border-t border-border pt-4">
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-orange-600">
                                    $<?= number_format($venue['price'], 0) ?>
                                </span>
                                <span class="text-sm text-muted-foreground ml-1">/hour</span>
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
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Featured Section -->
        <div class="card p-6 gradient-blue text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-2">🏆 Join the Championship!</h3>
                    <p class="text-blue-100 mb-4 max-w-md">Annual Table Tennis Championship is coming soon. Register now for early bird pricing and secure your spot!</p>
                    <div class="flex items-center space-x-4">
                        <button class="btn bg-white text-blue-600 hover:bg-blue-50">
                            <i data-lucide="trophy" class="w-4 h-4 mr-2"></i>
                            Learn More
                        </button>
                        <div class="text-white/80 text-sm">
                            <i data-lucide="calendar" class="w-4 h-4 inline mr-1"></i>
                            Registration ends in 15 days
                        </div>
                    </div>
                </div>
                <div class="hidden md:block opacity-20">
                    <i data-lucide="trophy" class="w-32 h-32"></i>
                </div>
            </div>
        </div>
    </div>
</div>