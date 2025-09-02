<?php
// File: templates/profile_template.php (Tampilan)
if (!$user): // Penanganan jika user tidak ditemukan ?>
    <div class="max-w-4xl mx-auto p-4">
        <header class="bg-white p-4 border-b border-gray-100">
            <h1 class="text-xl font-bold text-gray-900">Error</h1>
        </header>
        <p class='p-4 text-center bg-white'>User tidak ditemukan.</p>
    </div>
<?php else: 
    // Ambil variabel loggedInUserId dan userId dari scope controller (profile.php)
    global $loggedInUserId, $userId;
?>
<div class="max-w-4xl mx-auto">
    <header class="bg-white p-4 border-b border-gray-100">
         <div class="flex items-center">
            <?php if ($userId !== $loggedInUserId): ?>
            <a href="javascript:history.back()" class="mr-4 p-2 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <?php endif; ?>
            <h1 class="text-xl font-bold text-gray-900">Profile</h1>
        </div>
    </header>

    <div class="bg-white p-6 text-center border-b border-gray-100">
        <img src="<?= htmlspecialchars($user['photo'] ?? 'https://via.placeholder.com/150') ?>" class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-gray-100 shadow">
        <h2 class="text-2xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($user['name']) ?></h2>
        <div class="flex items-center justify-center text-gray-600 mb-3">
            <span class="mr-4">📍 <?= htmlspecialchars($user['location']) ?></span>
            <span>⭐ <?= htmlspecialchars($user['elo']) ?> Rating</span>
        </div>
        <div class="flex items-center justify-center space-x-2 mb-4">
            <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full font-medium"><?= htmlspecialchars($user['skill']) ?></span>
            <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-medium"><?= htmlspecialchars($user['style']) ?></span>
        </div>
         <?php if ($user['clubName']) : ?>
            <div class="inline-flex items-center bg-orange-50 p-3 rounded-lg border border-orange-200 mt-2">
                <img src="<?= htmlspecialchars($user['clubLogo']) ?>" class="w-6 h-6 rounded-full mr-2">
                <span class="text-orange-800 font-medium"><?= htmlspecialchars($user['clubName']) ?></span>
            </div>
        <?php endif; ?>
    </div>

    <div class="bg-white p-4">
         <h3 class="font-semibold text-gray-900 mb-3 px-2">Statistics</h3>
         <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php
                $matches = $user['matches'] ?? 0;
                $wins = $user['wins'] ?? 0;
                $winRate = ($matches > 0) ? round(($wins / $matches) * 100) : 0;
            ?>
             <div class="text-center bg-gray-50 p-3 rounded-lg">
                <p class="text-2xl font-bold text-gray-900"><?= $matches ?></p>
                <p class="text-sm text-gray-600">Total Matches</p>
             </div>
             <div class="text-center bg-gray-50 p-3 rounded-lg">
                 <p class="text-2xl font-bold text-gray-900"><?= $winRate ?>%</p>
                 <p class="text-sm text-gray-600">Win Rate</p>
            </div>
             <div class="text-center bg-gray-50 p-3 rounded-lg">
                <p class="text-2xl font-bold text-gray-900"><?= $user['tournaments'] ?? 0 ?></p>
                <p class="text-sm text-gray-600">Tournaments</p>
             </div>
             <div class="text-center bg-gray-50 p-3 rounded-lg">
                 <p class="text-2xl font-bold text-gray-900">#<?= $user['current_rank'] ?? 'N/A' ?></p>
                 <p class="text-sm text-gray-600">Rank</p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>