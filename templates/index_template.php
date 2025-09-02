<div class="max-w-4xl mx-auto">
    <header class="bg-white p-4 border-b border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <span class="text-2xl font-bold text-pink-500 mr-2">🏓</span>
                <h1 class="text-xl font-bold text-gray-900">PingPong+</h1>
            </div>
            <div class="flex items-center space-x-3">
                <button class="relative p-2 text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5V9l-5 5h5zM12 6V4a2 2 0 00-2-2H7a2 2 0 00-2 2v2"></path></svg>
                    <?php if ($unreadCount > 0) : ?><span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center"><?= $unreadCount ?></span><?php endif; ?>
                </button>
                <button class="p-2 text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426-1.756-2.924-1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></button>
            </div>
        </div>
        <div class="flex items-center text-sm text-gray-600">
            📍 <span class="ml-1"><?= htmlspecialchars($user['location'] ?? 'N/A') ?></span>
            <span class="w-2 h-2 bg-green-500 rounded-full mx-2"></span><span class="text-green-600 font-medium">Online</span>
            <?php if ($user['clubShortName']) : ?><span class="ml-3 flex items-center text-orange-500 font-medium">🏢 <span class="ml-1"><?= htmlspecialchars($user['clubShortName']) ?></span></span><?php endif; ?>
        </div>
    </header>
    <div class="p-4">
        <div class="bg-gray-100 rounded-lg px-4 py-3 flex items-center mb-4"><svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg><input type="text" placeholder="Cari pemain, venue..." class="bg-transparent text-gray-600 text-sm flex-1 outline-none"></div>
        <div class="bg-orange-500 text-white rounded-xl p-4 mb-6 shadow-lg">
            <div class="flex items-center"><div class="relative"><img src="<?= htmlspecialchars($user['photo'] ?? 'https://via.placeholder.com/150') ?>" class="w-16 h-16 rounded-full border-4 border-white/50 shadow-md"><?php if ($user['online']): ?><div class="absolute -bottom-1 -right-1 bg-white rounded-full p-1"><div class="w-3 h-3 bg-green-500 rounded-full"></div></div><?php endif; ?></div><div class="ml-4 flex-1"><h3 class="text-lg font-bold"><?= htmlspecialchars($user['name']) ?></h3><div class="flex items-center text-sm"><span class="text-orange-200">⭐</span> <span class="ml-1 font-semibold"><?= htmlspecialchars($user['elo'] ?? 0) ?> Rating</span></div><div class="flex items-center mt-1"><span class="bg-white/20 text-xs px-2 py-1 rounded-full"><?= htmlspecialchars($user['skill'] ?? 'N/A') ?></span><span class="bg-white/20 text-xs px-2 py-1 rounded-full ml-2"><?= htmlspecialchars($user['style'] ?? 'N/A') ?></span></div></div></div>
        </div>
        <div class="grid grid-cols-4 gap-4 text-center mb-6">
            <?php $winRate = ($user['matches'] ?? 0) > 0 ? round(($user['wins'] / $user['matches']) * 100) : 0; ?>
            <div><p class="text-xl font-bold"><?= $user['matches'] ?? 0 ?></p><p class="text-xs text-gray-500">Main</p></div><div><p class="text-xl font-bold"><?= $user['wins'] ?? 0 ?></p><p class="text-xs text-gray-500">Menang</p></div><div><p class="text-xl font-bold"><?= $winRate ?>%</p><p class="text-xs text-gray-500">Rate</p></div><div><p class="text-xl font-bold">#<?= $user['current_rank'] ?? 'N/A' ?></p><p class="text-xs text-gray-500">Rank</p></div>
        </div>
        <h3 class="font-semibold text-gray-900 mb-3">Feed Komunitas</h3>
        <div class="space-y-4">
        <?php if (empty($feedPosts)): ?><p class="text-center text-gray-500 p-4">Feed komunitas masih kosong.</p>
        <?php else: foreach ($feedPosts as $post): ?>
            <div class="bg-white p-4 rounded-lg border border-gray-200">
                <div class="flex items-center mb-3"><img src="<?= htmlspecialchars($post['userPhoto'] ?? 'https://via.placeholder.com/150') ?>" class="w-10 h-10 rounded-full mr-3"><div><p class="font-medium text-gray-900"><?= htmlspecialchars($post['userName'] ?? 'Pengguna') ?></p><p class="text-xs text-gray-500"><?= date('d M H:i', strtotime($post['created_at'])) ?></p></div></div>
                <p class="text-gray-800 mb-3 text-sm"><?= nl2br(htmlspecialchars($post['content'] ?? '')) ?></p>
                <div class="flex items-center space-x-4 text-sm text-gray-500"><span>❤️ <?= $post['likes'] ?? 0 ?></span><span>💬 <?= $post['comments'] ?? 0 ?></span></div>
            </div>
        <?php endforeach; endif; ?>
        </div>
    </div>
</div>