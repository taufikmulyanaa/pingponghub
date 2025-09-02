<?php // File: templates/ptm_template.php (Tampilan) ?>
<div class="max-w-4xl mx-auto">
    <header class="bg-white p-4 border-b border-gray-100 sticky top-0 z-40">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-900">Clubs & PTM</h1>
            <button class="bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-lg font-medium shadow-sm">+ Tambah PTM</button>
        </div>
        <div class="mt-4 bg-gray-100 rounded-lg px-4 py-3 flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="club-search-input" placeholder="Cari klub berdasarkan kota..." class="bg-transparent text-gray-600 text-sm flex-1 outline-none">
        </div>
    </header>

    <div class="p-4 space-y-6">
        <?php if ($myClub): ?>
        <div>
            <h3 class="font-semibold text-gray-900 mb-2">Klub Saya</h3>
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center mb-4">
                    <img src="<?= htmlspecialchars($myClub['logo']) ?>" class="w-16 h-16 rounded-full mr-4">
                    <div class="flex-1">
                        <p class="font-bold text-lg text-gray-900"><?= htmlspecialchars($myClub['name']) ?></p>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($myClub['city']) ?>, Member sejak <?= htmlspecialchars($myClub['established']) ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-bold text-orange-600">#<?= htmlspecialchars($myClub['team_ranking']) ?></p>
                        <p class="text-xs text-gray-500">Ranking</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 text-center border-t border-gray-100 pt-3">
                    <div>
                        <p class="font-bold text-gray-900"><?= $myClub['members'] ?? 0 ?></p>
                        <p class="text-xs text-gray-500">Members</p>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900"><?= $myClub['recent_matches'] ?? 0 ?></p>
                        <p class="text-xs text-gray-500">Matches</p>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900"><?= $myClub['rating'] ?? 'N/A' ?> ⭐</p>
                        <p class="text-xs text-gray-500">Rating</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div>
            <h3 class="font-semibold text-gray-900 mb-2">✨ Pertandingan Antar Klub</h3>
            <?php if (empty($interClubMatches)): ?>
                <div class="bg-white p-4 rounded-lg border border-gray-200 text-center text-gray-500">
                    <p>Belum ada jadwal pertandingan mendatang.</p>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                <?php foreach($interClubMatches as $match): ?>
                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-gray-800"><?= htmlspecialchars($match['name']) ?></h4>
                            <?php 
                                $statusClass = $match['status'] == 'scheduled' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800';
                            ?>
                            <span class="text-xs font-medium px-2 py-1 rounded-full <?= $statusClass ?>"><?= ucfirst($match['status']) ?></span>
                        </div>
                        
                        <?php if ($match['home_club_name'] && $match['away_club_name']): ?>
                        <div class="flex items-center justify-around text-center my-4">
                            <div class="flex flex-col items-center">
                                <img src="<?= htmlspecialchars($match['home_club_logo'])?>" class="w-12 h-12 rounded-full mb-1">
                                <p class="font-semibold text-sm"><?= htmlspecialchars($match['home_club_name'])?></p>
                            </div>
                            <span class="text-gray-500 font-bold">VS</span>
                             <div class="flex flex-col items-center">
                                <img src="<?= htmlspecialchars($match['away_club_logo'])?>" class="w-12 h-12 rounded-full mb-1">
                                <p class="font-semibold text-sm"><?= htmlspecialchars($match['away_club_name'])?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="text-sm text-gray-600 flex items-center justify-between border-t border-gray-100 pt-3 mt-3">
                            <span>📅 <?= date('d M Y', strtotime($match['match_datetime'])) ?> @ <?= date('H:i', strtotime($match['match_datetime'])) ?></span>
                            <span>📍 <?= htmlspecialchars($match['venue']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div>
            <h3 class="font-semibold text-gray-900 mb-2">Klub Lainnya</h3>
            <div id="club-list-container" class="space-y-3">
                <?php if (empty($otherClubs)): ?>
                    <div class="bg-white p-4 rounded-lg border border-gray-200 text-center text-gray-500">
                        <p>Tidak ada klub lain yang ditemukan.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($otherClubs as $club): ?>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 flex items-center">
                            <img src="<?= htmlspecialchars($club['logo']) ?>" class="w-12 h-12 rounded-full mr-4">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <p class="font-medium text-gray-900"><?= htmlspecialchars($club['name']) ?></p>
                                    <span class="text-sm text-gray-600">#<?= htmlspecialchars($club['team_ranking']) ?></span>
                                </div>
                                <p class="text-sm text-gray-600"><?= htmlspecialchars($club['city']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>