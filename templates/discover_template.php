<?php // File: templates/discover_template.php ?>
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <header class="bg-card p-4 border-b border-border sticky top-0 z-40 shadow-soft">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
                <i data-lucide="compass" class="w-6 h-6 text-orange-500 mr-2"></i>
                <h1 class="text-xl font-bold text-foreground">Discover Players</h1>
            </div>
            <div class="flex gap-2">
                <button class="btn btn-secondary">
                    <i data-lucide="sliders-horizontal" class="w-4 h-4 mr-2"></i>
                    Filter
                </button>
                <button class="btn btn-primary">
                    <i data-lucide="map" class="w-4 h-4 mr-2"></i>
                    Map View
                </button>
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-5 h-5 text-muted-foreground"></i>
            </div>
            <input type="text" 
                   placeholder="Search by skill level, location, club..." 
                   class="search-input w-full pl-10 pr-4 py-3">
        </div>
    </header>

    <div class="p-4">
        <!-- Filter Buttons -->
        <div class="flex items-center space-x-2 mb-6 overflow-x-auto pb-2">
            <button data-filter="nearby" class="filter-btn active flex-shrink-0">
                <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i>
                Nearby
            </button>
            <button data-filter="online" class="filter-btn flex-shrink-0">
                <i data-lucide="circle" class="w-3 h-3 mr-2 text-green-500"></i>
                Online
            </button>
            <button data-filter="beginner" class="filter-btn flex-shrink-0">
                <i data-lucide="star" class="w-4 h-4 mr-2"></i>
                Beginner
            </button>
            <button data-filter="intermediate" class="filter-btn flex-shrink-0">
                <i data-lucide="star" class="w-4 h-4 mr-2"></i>
                Intermediate
            </button>
            <button data-filter="advanced" class="filter-btn flex-shrink-0">
                <i data-lucide="crown" class="w-4 h-4 mr-2"></i>
                Advanced
            </button>
        </div>

        <!-- Results Header -->
        <div class="flex items-center justify-between mb-4">
            <h3 id="player-results-header" class="font-semibold text-foreground">
                Nearby Players (<?= count($players) ?> found)
            </h3>
            <div class="flex items-center text-sm text-muted-foreground">
                <i data-lucide="users" class="w-4 h-4 mr-1"></i>
                <span><?= count($players) ?> players</span>
            </div>
        </div>

        <!-- Player List Container -->
        <div id="player-list-container" class="space-y-4">
            <?php if (empty($players)): ?>
                <div class="card p-8 text-center">
                    <i data-lucide="user-x" class="w-12 h-12 text-muted-foreground mx-auto mb-4"></i>
                    <p class="text-muted-foreground">No players found matching your criteria.</p>
                    <button onclick="location.reload()" class="btn btn-secondary mt-4">
                        <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                        Refresh
                    </button>
                </div>
            <?php else: ?>
                <?php foreach ($players as $player): 
                    $winRate = ($player['matches'] ?? 0) > 0 ? round(($player['wins'] / $player['matches']) * 100) : 0;
                    $skillInfo = mapSkillToLevel($player['skill']);
                    $initials = getInitials($player['name']);
                ?>
                <!-- Player Card -->
                <div class="card p-4 hover:shadow-medium transition-all duration-200">
                    <div class="flex space-x-4">
                        <!-- Avatar -->
                        <div class="relative flex-shrink-0">
                            <div class="avatar avatar-md">
                                <?= $initials ?>
                            </div>
                            <?php if($player['online']): ?>
                            <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Player Info -->
                        <div class="flex-1 min-w-0">
                            <!-- Header Row -->
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-semibold text-foreground truncate">
                                        <?= htmlspecialchars($player['name']) ?>
                                    </h4>
                                    <div class="flex items-center text-xs text-muted-foreground mt-1 space-x-3">
                                        <div class="flex items-center">
                                            <i data-lucide="star" class="w-3 h-3 mr-1"></i>
                                            <span><?= htmlspecialchars($player['elo'] ?? '0') ?></span>
                                        </div>
                                        <div class="flex items-center">
                                            <i data-lucide="message-circle" class="w-3 h-3 mr-1"></i>
                                            <span><?= htmlspecialchars($player['reviews'] ?? '0') ?> reviews</span>
                                        </div>
                                        <?php if($player['club_short_name']): ?>
                                        <div class="flex items-center text-orange-600 font-medium">
                                            <i data-lucide="building" class="w-3 h-3 mr-1"></i>
                                            <span><?= htmlspecialchars($player['club_short_name']) ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="text-right text-sm font-medium text-muted-foreground flex items-center">
                                    <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
                                    <span><?= htmlspecialchars($player['distance'] ?? 'N/A') ?>km</span>
                                </div>
                            </div>
                            
                            <!-- Badges Row -->
                            <div class="flex items-center space-x-2 mb-3">
                                <span class="badge <?= $skillInfo['class'] ?>"><?= $skillInfo['label'] ?></span>
                                <span class="badge badge-status"><?= htmlspecialchars($player['style'] ?? '') ?></span>
                                <?php if($player['online']): ?>
                                <span class="badge badge-online">
                                    <span class="status-dot status-online mr-1"></span>
                                    Online
                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Stats & Actions Row -->
                            <div class="flex justify-between items-center border-t border-border pt-3">
                                <div class="flex items-center space-x-4 text-sm text-muted-foreground">
                                    <div class="flex items-center">
                                        <i data-lucide="trophy" class="w-4 h-4 mr-1"></i>
                                        <span><?= htmlspecialchars($player['tournaments'] ?? '0') ?></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                                        <span><?= $winRate ?>%</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                        <span><?= htmlspecialchars($player['availability'] ?? 'N/A') ?></span>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <button class="btn btn-secondary text-sm py-1.5 px-3" data-tooltip="View Profile">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                    </button>
                                    <button class="btn btn-primary text-sm py-1.5 px-3">
                                        <i data-lucide="message-circle" class="w-4 h-4 mr-2"></i>
                                        Chat
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Load More Button -->
        <?php if (count($players) >= 10): ?>
        <div class="text-center mt-8">
            <button class="btn btn-secondary" data-dynamic-load>
                <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i>
                Load More Players
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Initialize player filters with updated data attributes
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const playerListContainer = document.getElementById('player-list-container');
        const resultsHeader = document.getElementById('player-results-header');

        if (filterButtons.length > 0 && playerListContainer && resultsHeader) {
            filterButtons.forEach(button => {
                button.addEventListener('click', async () => {
                    // Update active button state
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    const filter = button.dataset.filter;
                    
                    // Show loading state
                    playerListContainer.innerHTML = `
                        <div class="card p-8 text-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500 mx-auto mb-4"></div>
                            <p class="text-muted-foreground">Loading players...</p>
                        </div>
                    `;
                    
                    try {
                        const response = await fetch(`api/filter_players.php?filter=${filter}`);
                        const html = await response.text();
                        
                        playerListContainer.innerHTML = html;
                        
                        // Update header
                        const countEl = playerListContainer.querySelector('#player-count');
                        if(countEl) {
                            const count = countEl.dataset.count;
                            const filterName = button.textContent.trim();
                            resultsHeader.innerHTML = `${filterName} (${count} found)`;
                            countEl.remove();
                        }
                        
                        // Reinitialize icons
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                        
                    } catch (error) {
                        console.error('Error filtering players:', error);
                        playerListContainer.innerHTML = `
                            <div class="card p-8 text-center text-red-500">
                                <i data-lucide="alert-circle" class="w-8 h-8 mx-auto mb-4"></i>
                                <p>Failed to load players. Please try again.</p>
                                <button onclick="location.reload()" class="btn btn-secondary mt-4">
                                    <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                                    Refresh
                                </button>
                            </div>
                        `;
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                    }
                });
            });
        }
    });
</script>