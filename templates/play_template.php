<?php // File: templates/play_template.php (Tampilan) ?>
<div class="max-w-4xl mx-auto">
    <header class="bg-white p-4 border-b border-gray-100 sticky top-0 z-40">
        <h1 class="text-xl font-bold text-gray-900 mb-4 text-center md:text-left">Play Hub</h1>
        <div class="bg-gray-100 rounded-lg px-4 py-3 flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Cari turnamen, venue..." class="bg-transparent text-gray-600 text-sm flex-1 outline-none">
        </div>
    </header>

    <div class="p-4 space-y-8">
        <div>
            <h3 class="font-semibold text-gray-900 mb-3">Aksi Cepat</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="#" class="text-center bg-blue-50 border border-blue-200 p-4 rounded-lg hover:bg-blue-100">
                    <span class="text-3xl">🏸</span>
                    <p class="font-bold text-blue-800 mt-2">Cari Lawan</p>
                    <p class="text-xs text-blue-700">Match sekarang</p>
                </a>
                <a href="#" class="text-center bg-green-50 border border-green-200 p-4 rounded-lg hover:bg-green-100">
                    <span class="text-3xl">🏢</span>
                    <p class="font-bold text-green-800 mt-2">Book Venue</p>
                    <p class="text-xs text-green-700">Pesan lapangan</p>
                </a>
                <a href="#" class="text-center bg-yellow-50 border border-yellow-200 p-4 rounded-lg hover:bg-yellow-100">
                    <span class="text-3xl">🏆</span>
                    <p class="font-bold text-yellow-800 mt-2">Turnamen</p>
                    <p class="text-xs text-yellow-700">Daftar kompetisi</p>
                </a>
                <a href="#" class="text-center bg-purple-50 border border-purple-200 p-4 rounded-lg hover:bg-purple-100">
                    <span class="text-3xl">🛒</span>
                    <p class="font-bold text-purple-800 mt-2">Shop</p>
                    <p class="text-xs text-purple-700">Beli equipment</p>
                </a>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-gray-900">Turnamen Mendatang</h3>
                <a href="#" class="text-sm text-orange-500 font-medium">Lihat Semua</a>
            </div>
            
            <div class="space-y-4">
            <?php if (empty($tournaments)): ?>
                <div class="bg-white p-6 rounded-lg border border-gray-200 text-center text-gray-500"><p>Belum ada turnamen tersedia.</p></div>
            <?php else: ?>
                <?php foreach ($tournaments as $t):
                    $participants = $t['participants'] ?? 0;
                    $max_participants = $t['max_participants'] > 0 ? $t['max_participants'] : 1;
                    $progress = ($participants / $max_participants) * 100;
                    $isFull = $participants >= $max_participants;
                ?>
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <div class="mb-3">
                        <div class="flex justify-between items-start">
                             <h4 class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($t['name']) ?></h4>
                             <div class="flex items-center space-x-2">
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-blue-100 text-blue-800"><?= htmlspecialchars($t['type']) ?></span>
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 text-gray-800"><?= htmlspecialchars($t['category']) ?></span>
                            </div>
                        </div>
                        <div class="flex justify-between items-end">
                            <div class="space-y-1 text-sm text-gray-600 mt-2">
                                <p>📅 <?= date("d M Y", strtotime($t['date'])) ?></p>
                                <p>📍 <?= htmlspecialchars($t['location']) ?></p>
                                <p>🏆 Rp <?= number_format($t['prize'], 0, ',', '.') ?></p>
                            </div>
                            <p class="text-sm text-gray-500">👥 <?= $participants ?>/<?= $t['max_participants'] ?></p>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-orange-500 h-2 rounded-full" style="width: <?= $progress ?>%"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-gray-800">Rp <?= number_format($t['fee'], 0, ',', '.') ?></span>
                        <?php if($isFull): ?>
                            <button class="px-5 py-2 bg-gray-300 text-gray-500 text-sm rounded-lg font-medium cursor-not-allowed" disabled>Penuh</button>
                        <?php else: ?>
                            <button class="px-5 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm rounded-lg font-medium shadow-sm">Daftar</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-gray-900">Venue Terdekat</h3>
                <a href="#" class="text-sm text-orange-500 font-medium">Lihat Semua</a>
            </div>

            <div class="space-y-3">
            <?php if(empty($venues)): ?>
                 <div class="bg-white p-6 rounded-lg border border-gray-200 text-center text-gray-500"><p>Belum ada venue terdekat yang ditemukan.</p></div>
            <?php else: ?>
                <?php foreach($venues as $venue): ?>
                <div class="bg-white p-4 rounded-lg border border-gray-200 flex items-center">
                    <div class="w-16 h-16 bg-blue-500 text-white flex items-center justify-center rounded-lg mr-4 font-bold">
                        <?= substr(htmlspecialchars($venue['name']), 0, 3) ?>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800"><?= htmlspecialchars($venue['name']) ?></p>
                        <div class="flex items-center text-xs text-gray-500 mt-1">
                            <span>⭐ <?= htmlspecialchars($venue['rating']) ?> (<?= htmlspecialchars($venue['reviews']) ?> reviews)</span>
                            <span class="mx-2">|</span>
                            <span>🏓 <?= htmlspecialchars($venue['tables']) ?> Meja</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-700"><?= htmlspecialchars($venue['distance']) ?> km</p>
                        <p class="text-sm font-bold text-orange-600">Rp <?= number_format($venue['price'], 0, ',', '.') ?>/jam</p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>