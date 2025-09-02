<?php // File: templates/discover_template.php (Tampilan) ?>
<div class="max-w-4xl mx-auto">
    <header class="bg-white p-4 border-b border-gray-100 sticky top-0 z-40">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-gray-900">Discover Players</h1>
            <div>
                <button class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm rounded-lg font-medium">Filter</button>
                <button class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm rounded-lg font-medium">Map</button>
            </div>
        </div>
        <div class="bg-gray-100 rounded-lg px-4 py-3 flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Cari berdasarkan skill, lokasi..." class="bg-transparent text-gray-600 text-sm flex-1 outline-none">
        </div>
    </header>

    <div class="p-4">
        <div class="flex items-center space-x-2 mb-4 overflow-x-auto pb-2">
            <button data-filter="terdekat" class="player-filter-btn active-filter flex-shrink-0">Terdekat</button>
            <button data-filter="online" class="player-filter-btn flex-shrink-0">Online</button>
            <button data-filter="pemula" class="player-filter-btn flex-shrink-0">Pemula</button>
            <button data-filter="menengah" class="player-filter-btn flex-shrink-0">Menengah</button>
            <button data-filter="mahir" class="player-filter-btn flex-shrink-0">Mahir</button>
        </div>
        <style>
            .player-filter-btn { padding: 6px 16px; border-radius: 9999px; font-size: 14px; font-weight: 500; background-color: #f3f4f6; color: #374151; transition: all 0.2s; }
            .active-filter { background-color: #f97316; color: white; }
        </style>

        <h3 id="player-results-header" class="font-semibold text-gray-900 mb-3">
            Pemain Terdekat (<?= count($players) ?> ditemukan)
        </h3>

        <div id="player-list-container" class="space-y-3">
            <?php if (empty($players)): ?>
                <p class="text-center text-gray-500 p-4">Tidak ada pemain yang ditemukan.</p>
            <?php else: ?>
                <?php foreach ($players as $player): 
                    $winRate = ($player['matches'] ?? 0) > 0 ? round(($player['wins'] / $player['matches']) * 100) : 0;
                    $skillInfo = mapSkillToLevel($player['skill']);
                ?>
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm flex space-x-4">
                    <div class="relative flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-xl">
                            <?= getInitials($player['name']) ?>
                        </div>
                        <?php if($player['online']): ?>
                        <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-bold text-gray-900"><?= htmlspecialchars($player['name']) ?></p>
                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                    <span>⭐ <?= htmlspecialchars($player['elo'] ?? '0') ?></span>
                                    <span class="mx-2">|</span>
                                    <span>💬 <?= htmlspecialchars($player['reviews'] ?? '0') ?> Reviews</span>
                                    <?php if($player['club_short_name']): ?>
                                    <span class="mx-2">|</span>
                                    <span class="font-semibold text-orange-600"><?= htmlspecialchars($player['club_short_name']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <span class="text-sm font-medium text-gray-600"><?= htmlspecialchars($player['distance'] ?? 'N/A') ?>km</span>
                        </div>
                        <div class="flex items-center space-x-2 my-2">
                            <span class="text-xs font-medium px-2 py-1 rounded-full <?= $skillInfo['class'] ?>"><?= $skillInfo['label'] ?></span>
                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 text-gray-800"><?= htmlspecialchars($player['style'] ?? '') ?></span>
                            <?php if($player['online']): ?><span class="text-xs font-medium px-2 py-1 rounded-full bg-green-100 text-green-800">Online</span><?php endif; ?>
                        </div>
                        <div class="flex justify-between items-center border-t border-gray-100 pt-2 mt-2">
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span>🏆 <?= htmlspecialchars($player['tournaments'] ?? '0') ?></span>
                                <span>📈 <?= $winRate ?>%</span>
                                <span>📅 <?= htmlspecialchars($player['availability'] ?? 'N/A') ?></span>
                            </div>
                            <a href="#" class="px-4 py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-sm rounded-lg font-medium">Chat</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>