<?php // File: templates/ptm_template.php ?>
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <header class="bg-card p-4 border-b border-border sticky top-0 z-40 shadow-soft">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <i data-lucide="building" class="w-6 h-6 text-orange-500 mr-2"></i>
                <h1 class="text-xl font-bold text-foreground">Clubs & Matches</h1>
            </div>
            <button class="btn btn-primary">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Create Match
            </button>
        </div>
        
        <!-- Search Bar -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-5 h-5 text-muted-foreground"></i>
            </div>
            <input type="text" 
                   id="club-search-input"
                   placeholder="Search clubs by city, name, or region..." 
                   class="search-input w-full pl-10 pr-4 py-3">
        </div>
    </header>

    <div class="p-4 space-y-8">
        <!-- My Club Section -->
        <?php if ($myClub): ?>
        <div>
            <h3 class="text-2xl font-bold text-foreground mb-4 flex items-center">
                <i data-lucide="home" class="w-6 h-6 mr-3 text-orange-500"></i>
                My Club
            </h3>
            
            <div class="card p-6 bg-gradient-to-r from-orange-50 to-orange-100 border-orange-200">
                <div class="flex items-center mb-6">
                    <!-- Club Logo -->
                    <div class="relative">
                        <img src="<?= htmlspecialchars($myClub['logo']) ?>" 
                             class="w-20 h-20 rounded-full shadow-lg border-4 border-white object-cover">
                        <?php if($myClub['verified']): ?>
                        <div class="absolute -top-1 -right-1 bg-blue-500 rounded-full p-1">
                            <i data-lucide="check" class="w-3 h-3 text-white"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Club Info -->
                    <div class="ml-6 flex-1">
                        <div class="flex items-center mb-2">
                            <h4 class="text-xl font-bold text-foreground"><?= htmlspecialchars($myClub['name']) ?></h4>
                            <?php if($myClub['verified']): ?>
                            <span class="badge bg-blue-100 text-blue-800 ml-2">
                                <i data-lucide="shield-check" class="w-3 h-3 mr-1"></i>
                                Verified
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center text-muted-foreground mb-2">
                            <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
                            <span><?= htmlspecialchars($myClub['city']) ?></span>
                            <span class="mx-2">•</span>
                            <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                            <span>Est. <?= htmlspecialchars($myClub['established']) ?></span>
                        </div>
                        <div class="flex items-center text-sm">
                            <div class="flex items-center mr-4">
                                <i data-lucide="star" class="w-4 h-4 text-yellow-500 mr-1"></i>
                                <span class="font-semibold"><?= htmlspecialchars($myClub['rating']) ?></span>
                            </div>
                            <div class="text-orange-600 font-bold text-lg">
                                #<?= htmlspecialchars($myClub['team_ranking']) ?> Ranking
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex flex-col space-y-2">
                        <button class="btn btn-secondary text-sm">
                            <i data-lucide="settings" class="w-4 h-4 mr-2"></i>
                            Manage
                        </button>
                        <button class="btn btn-primary text-sm">
                            <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                            Members
                        </button>
                    </div>
                </div>
                
                <!-- Club Stats -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-white/70 rounded-lg">
                        <div class="flex items-center justify-center mb-2">
                            <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-foreground"><?= $myClub['members'] ?? 0 ?></p>
                        <p class="text-sm text-muted-foreground">Members</p>
                    </div>
                    <div class="text-center p-4 bg-white/70 rounded-lg">
                        <div class="flex items-center justify-center mb-2">
                            <i data-lucide="gamepad-2" class="w-5 h-5 text-green-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-foreground"><?= $myClub['recent_matches'] ?? 0 ?></p>
                        <p class="text-sm text-muted-foreground">Recent Matches</p>
                    </div>
                    <div class="text-center p-4 bg-white/70 rounded-lg">
                        <div class="flex items-center justify-center mb-2">
                            <i data-lucide="trending-up" class="w-5 h-5 text-purple-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-foreground"><?= $myClub['win_rate'] ?? 0 ?>%</p>
                        <p class="text-sm text-muted-foreground">Win Rate</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Inter Club Matches -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-foreground flex items-center">
                    <i data-lucide="zap" class="w-6 h-6 mr-3 text-orange-500"></i>
                    Upcoming Matches
                </h3>
                <a href="#" class="text-sm text-orange-500 hover:text-orange-600 font-medium flex items-center">
                    View All
                    <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>
            
            <div class="space-y-4">
                <?php if (empty($interClubMatches)): ?>
                <div class="card p-8 text-center">
                    <i data-lucide="calendar-x" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
                    <h4 class="text-lg font-semibold text-foreground mb-2">No Upcoming Matches</h4>
                    <p class="text-muted-foreground mb-6">Schedule a match with other clubs to start competing!</p>
                    <button class="btn btn-primary">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Schedule Match
                    </button>
                </div>
                <?php else: ?>
                    <?php foreach($interClubMatches as $match): ?>
                    <div class="card p-6 hover:shadow-medium transition-all duration-200">
                        <!-- Match Header -->
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="font-bold text-foreground text-lg"><?= htmlspecialchars($match['name']) ?></h4>
                            <?php 
                                $statusColors = [
                                    'scheduled' => 'bg-blue-100 text-blue-800',
                                    'registration_open' => 'bg-green-100 text-green-800',
                                    'completed' => 'bg-gray-100 text-gray-800'
                                ];
                                $statusClass = $statusColors[$match['status']] ?? 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="badge <?= $statusClass ?>">
                                <i data-lucide="info" class="w-3 h-3 mr-1"></i>
                                <?= ucfirst(str_replace('_', ' ', $match['status'])) ?>
                            </span>
                        </div>
                        
                        <!-- VS Section -->
                        <?php if ($match['home_club_name'] && $match['away_club_name']): ?>
                        <div class="flex items-center justify-center my-6 p-4 bg-muted rounded-lg">
                            <!-- Home Club -->
                            <div class="flex flex-col items-center text-center flex-1">
                                <img src="<?= htmlspecialchars($match['home_club_logo'])?>" 
                                     class="w-16 h-16 rounded-full shadow-lg mb-2 border-4 border-white">
                                <p class="font-bold text-foreground"><?= htmlspecialchars($match['home_club_name'])?></p>
                                <p class="text-sm text-muted-foreground">Home</p>
                            </div>
                            
                            <!-- VS Badge -->
                            <div class="mx-6">
                                <div class="bg-orange-500 text-white px-4 py-2 rounded-lg font-bold text-center shadow-lg">
                                    VS
                                </div>
                            </div>
                            
                            <!-- Away Club -->
                            <div class="flex flex-col items-center text-center flex-1">
                                <img src="<?= htmlspecialchars($match['away_club_logo'])?>" 
                                     class="w-16 h-16 rounded-full shadow-lg mb-2 border-4 border-white">
                                <p class="font-bold text-foreground"><?= htmlspecialchars($match['away_club_name'])?></p>
                                <p class="text-sm text-muted-foreground">Away</p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Match Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="flex items-center p-3 bg-muted rounded-lg">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-muted-foreground">Date & Time</p>
                                    <p class="font-medium text-foreground">
                                        <?= date('M d, Y', strtotime($match['match_datetime'])) ?>
                                        <span class="text-muted-foreground">at</span>
                                        <?= date('H:i', strtotime($match['match_datetime'])) ?>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-muted rounded-lg">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-green-600"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm text-muted-foreground">Venue</p>
                                    <p class="font-medium text-foreground truncate"><?= htmlspecialchars($match['venue']) ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center justify-between border-t border-border pt-4">
                            <div class="flex items-center space-x-4 text-sm text-muted-foreground">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                                <span><?= date('M d, Y \a\t H:i', strtotime($match['match_datetime'])) ?></span>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <button class="btn btn-secondary" data-tooltip="Share Match">
                                    <i data-lucide="share" class="w-4 h-4"></i>
                                </button>
                                <button class="btn btn-primary">
                                    <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Other Clubs -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-foreground flex items-center">
                    <i data-lucide="building" class="w-6 h-6 mr-3 text-orange-500"></i>
                    Discover Clubs
                </h3>
                <a href="#" class="text-sm text-orange-500 hover:text-orange-600 font-medium flex items-center">
                    View All
                    <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>
            
            <div id="club-list-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if (empty($otherClubs)): ?>
                <div class="col-span-full">
                    <div class="card p-8 text-center">
                        <i data-lucide="building" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
                        <h4 class="text-lg font-semibold text-foreground mb-2">No Clubs Found</h4>
                        <p class="text-muted-foreground mb-6">Be the first to register your club in this area!</p>
                        <button class="btn btn-primary">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                            Register Club
                        </button>
                    </div>
                </div>
                <?php else: ?>
                    <?php foreach ($otherClubs as $club): ?>
                    <div class="club-card hover:shadow-medium transition-all duration-200">
                        <!-- Club Header -->
                        <div class="flex items-center mb-4">
                            <div class="relative">
                                <img src="<?= htmlspecialchars($club['logo']) ?>" 
                                     class="w-14 h-14 rounded-full object-cover shadow-lg border-2 border-white">
                                <?php if($club['verified']): ?>
                                <div class="absolute -top-1 -right-1 bg-blue-500 rounded-full p-1">
                                    <i data-lucide="check" class="w-2 h-2 text-white"></i>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-bold text-foreground"><?= htmlspecialchars($club['name']) ?></h4>
                                    <span class="text-sm font-bold text-orange-600">#<?= htmlspecialchars($club['team_ranking']) ?></span>
                                </div>
                                <div class="flex items-center text-sm text-muted-foreground mb-2">
                                    <i data-lucide="map-pin" class="w-3 h-3 mr-1"></i>
                                    <span><?= htmlspecialchars($club['city']) ?></span>
                                    <?php if($club['verified']): ?>
                                    <span class="badge bg-blue-100 text-blue-800 ml-2 text-xs">
                                        <i data-lucide="shield-check" class="w-2 h-2 mr-1"></i>
                                        Verified
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Club Stats -->
                        <div class="grid grid-cols-3 gap-2 mb-4 text-center">
                            <div class="p-2 bg-muted rounded-lg">
                                <div class="flex items-center justify-center mb-1">
                                    <i data-lucide="users" class="w-4 h-4 text-blue-500"></i>
                                </div>
                                <p class="text-sm font-bold text-foreground"><?= $club['members'] ?? 0 ?></p>
                                <p class="text-xs text-muted-foreground">Members</p>
                            </div>
                            <div class="p-2 bg-muted rounded-lg">
                                <div class="flex items-center justify-center mb-1">
                                    <i data-lucide="star" class="w-4 h-4 text-yellow-500"></i>
                                </div>
                                <p class="text-sm font-bold text-foreground"><?= $club['rating'] ?? 'N/A' ?></p>
                                <p class="text-xs text-muted-foreground">Rating</p>
                            </div>
                            <div class="p-2 bg-muted rounded-lg">
                                <div class="flex items-center justify-center mb-1">
                                    <i data-lucide="calendar" class="w-4 h-4 text-green-500"></i>
                                </div>
                                <p class="text-sm font-bold text-foreground"><?= $club['established'] ?? 'N/A' ?></p>
                                <p class="text-xs text-muted-foreground">Est.</p>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center justify-between border-t border-border pt-3">
                            <div class="flex items-center space-x-2">
                                <button class="btn btn-secondary text-sm py-1.5 px-3" data-tooltip="View Profile">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="btn btn-secondary text-sm py-1.5 px-3" data-tooltip="Challenge">
                                    <i data-lucide="zap" class="w-4 h-4"></i>
                                </button>
                            </div>
                            <button class="btn btn-primary text-sm py-1.5 px-4">
                                <i data-lucide="message-circle" class="w-4 h-4 mr-2"></i>
                                Contact
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>