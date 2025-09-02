<?php 
// File: discover.php
include 'includes/header.php'; 
?>

<div class="max-w-4xl mx-auto">
    <header class="bg-white p-4 border-b border-gray-100 sticky top-0 z-40">
        <h1 class="text-xl font-bold text-gray-900 text-center">Discover Players</h1>
    </header>

    <div class="bg-gray-50">
        <?php
        // Ambil data semua user kecuali yang sedang login (ID 1)
        $usersStmt = query($pdo, "SELECT * FROM users WHERE id != 1 ORDER BY last_active DESC");
        while ($user = $usersStmt->fetch(PDO::FETCH_ASSOC)):
        ?>
            <div class="bg-white p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50">
                <a href="profile.php?id=<?= $user['id'] ?>" class="block">
                    <div class="flex items-center">
                        <div class="relative mr-4">
                            <img src="<?= htmlspecialchars($user['photo'] ?? 'https://via.placeholder.com/150') ?>" class="w-12 h-12 rounded-full">
                            <?php if ($user['online']): ?>
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <p class="font-medium text-gray-900"><?= htmlspecialchars($user['name']) ?></p>
                            </div>
                            <div class="flex items-center mb-2">
                                <span class="text-sm text-gray-600 mr-3">⭐ <?= htmlspecialchars($user['elo']) ?></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full"><?= htmlspecialchars($user['skill']) ?></span>
                                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full"><?= htmlspecialchars($user['style']) ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php 
include 'includes/footer.php'; 
?>