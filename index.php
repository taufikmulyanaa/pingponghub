<?php 
// File: index.php
include 'includes/header.php'; 

// --- MENGAMBIL DATA PENGGUNA SAAT INI ---
// Asumsikan pengguna yang sedang login memiliki ID = 1 untuk demonstrasi
$currentUserId = 1;
$userStmt = query($pdo, 
    "SELECT users.*, clubs.shortName as clubShortName 
     FROM users 
     LEFT JOIN clubs ON users.clubId = clubs.id 
     WHERE users.id = ?", 
    [$currentUserId]
);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

// Jika pengguna tidak ditemukan, hentikan
if (!$user) {
    echo "<p class='text-center p-4'>Pengguna tidak ditemukan.</p>";
    include 'includes/footer.php';
    exit;
}

// Hitung notifikasi yang belum dibaca (contoh)
// Anda perlu membuat tabel 'notifications' untuk ini
$unreadCount = 2; // Ganti dengan query dinamis nanti
?>

<div class="max-w-4xl mx-auto">
    <header class="bg-white p-4 border-b border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <span class="text-2xl font-bold text-orange-500 mr-2">🏓</span>
                <h1 class="text-xl font-bold text-gray-900">PingPong+</h1>
            </div>
            <div class="flex items-center space-x-3">
                <button class="relative p-2 text-gray-600 hover:text-orange-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5V9l-5 5h5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4a2 2 0 00-2-2H7a2 2 0 00-2 2v2"/></svg>
                    <?php if ($unreadCount > 0) : ?>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center"><?= $unreadCount ?></span>
                    <?php endif; ?>
                </button>
                <button class="p-2 text-gray-600 hover:text-orange-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </button>
            </div>
        </div>
        <div class="flex items-center text-sm text-gray-600">
            📍 <span class="ml-1"><?= htmlspecialchars($user['location']) ?></span>
            <span class="w-2 h-2 bg-green-500 rounded-full mx-2"></span>
            <span class="text-green-600 font-medium">Online</span>
            <?php if ($user['clubShortName']) : ?>
                <span class="ml-3 flex items-center text-orange-500 font-medium">
                    🏢 <span class="ml-1"><?= htmlspecialchars($user['clubShortName']) ?></span>
                </span>
            <?php endif; ?>
        </div>
    </header>

    <div class="bg-white px-4 pb-4">
        <div class="bg-gray-100 rounded-lg px-4 py-3 flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Cari pemain, venue..." class="bg-transparent text-gray-600 text-sm flex-1 outline-none">
        </div>
    </div>

    <div class="bg-white mx-4 rounded-xl border border-gray-200 mb-4 overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-4 text-white">
            <div class="flex items-center">
                <div class="relative">
                    <img src="<?= htmlspecialchars($user['photo']) ?>" class="w-16 h-16 rounded-full border-4 border-white shadow-lg">
                    <?php if ($user['online']): ?>
                    <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-1">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold"><?= htmlspecialchars($user['name']) ?></h3>
                    <div class="flex items-center">
                        ⭐ <span class="ml-1 text-orange-100 font-semibold"><?= htmlspecialchars($user['elo']) ?> Rating</span>
                    </div>
                    <div class="flex items-center mt-1">
                        <span class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full"><?= htmlspecialchars($user['skill']) ?></span>
                        <span class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full ml-2"><?= htmlspecialchars($user['style']) ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-4 gap-4">
                <?php
                    $winRate = ($user['matches_played'] > 0) ? round(($user['wins'] / $user['matches_played']) * 100) : 0;
                    // Anda perlu menambahkan kolom 'rank' di tabel users untuk ini
                    $rank = $user['rank'] ?? 'N/A'; 
                ?>
                <div class="text-center"><div class="bg-blue-50 rounded-lg p-3"><p class="text-xl font-bold text-gray-900"><?= $user['matches_played'] ?></p><p class="text-xs text-gray-500">Main</p></div></div>
                <div class="text-center"><div class="bg-green-50 rounded-lg p-3"><p class="text-xl font-bold text-gray-900"><?= $user['wins'] ?></p><p class="text-xs text-gray-500">Menang</p></div></div>
                <div class="text-center"><div class="bg-yellow-50 rounded-lg p-3"><p class="text-xl font-bold text-gray-900"><?= $winRate ?>%</p><p class="text-xs text-gray-500">Rate</p></div></div>
                <div class="text-center"><div class="bg-orange-50 rounded-lg p-3"><p class="text-xl font-bold text-gray-900">#<?= $rank ?></p><p class="text-xs text-gray-500">Rank</p></div></div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50">
        <div class="px-4 py-3 bg-white border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Feed Komunitas</h3>
        </div>
        <?php
        $feedStmt = query($pdo, 
            "SELECT f.*, u.name as userName, u.photo as userPhoto 
             FROM feed f 
             JOIN users u ON f.userId = u.id 
             ORDER BY f.created_at DESC"
        );
        while ($post = $feedStmt->fetch(PDO::FETCH_ASSOC)):
            // Di sini kita bisa gunakan if/else untuk merender tipe post yang berbeda
            // Untuk sekarang, kita buat contoh sederhana untuk 'match_report'
        ?>
            <div class="bg-white p-4 border-b border-gray-100">
                <div class="flex items-center mb-3">
                    <img src="<?= htmlspecialchars($post['userPhoto']) ?>" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-medium text-gray-900"><?= htmlspecialchars($post['userName']) ?></p>
                        <p class="text-xs text-gray-500"><?= date('d M H:i', strtotime($post['created_at'])) ?></p>
                    </div>
                </div>
                <p class="text-gray-800 mb-3"><?= htmlspecialchars($post['content']) ?></p>
                <?php if (!empty($post['image'])): ?>
                    <img src="<?= htmlspecialchars($post['image']) ?>" class="w-full h-48 rounded-lg object-cover mb-3">
                <?php endif; ?>
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <span>❤️ <?= $post['likes'] ?></span>
                    <span>💬 <?= $post['comments'] ?></span>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php 
include 'includes/footer.php'; 
?>