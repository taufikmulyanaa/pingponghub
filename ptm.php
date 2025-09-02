<?php 
// File: ptm.php
include 'includes/header.php'; 
?>

<div class="max-w-4xl mx-auto">
    <header class="bg-white p-4 border-b border-gray-100 sticky top-0 z-40">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-900">Clubs & PTM</h1>
            <button class="bg-orange-500 text-white text-sm px-3 py-2 rounded-lg font-medium">+ Tambah PTM</button>
        </div>
        <div class="mt-4 bg-gray-100 rounded-lg px-4 py-3 flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Cari klub berdasarkan kota..." class="bg-transparent text-gray-600 text-sm flex-1 outline-none">
        </div>
    </header>

    <?php
    // Asumsikan user yang login punya ID 1
    $loggedInUserId = 1;
    $userStmt = query($pdo, "SELECT club_id FROM users WHERE id = ?", [$loggedInUserId]);
    $userClubId = $userStmt->fetchColumn();

    $myClub = null;
    if ($userClubId) {
        $myClubStmt = query($pdo, "SELECT * FROM clubs WHERE id = ?", [$userClubId]);
        $myClub = $myClubStmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>

    <?php if ($myClub): ?>
    <div class="bg-white p-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-900 mb-3">Klub Saya</h3>
        <div class="bg-orange-50 p-4 rounded-lg border border-orange-200 cursor-pointer hover:bg-orange-100">
            <div class="flex items-center mb-3">
                <img src="<?= htmlspecialchars($myClub['logo']) ?>" class="w-16 h-16 rounded-full mr-4 border-2 border-orange-500">
                <div class="flex-1">
                    <p class="font-bold text-gray-900"><?= htmlspecialchars($myClub['name']) ?></p>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($myClub['city']) ?></p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-orange-600">#<?= htmlspecialchars($myClub['team_ranking']) ?></p>
                    <p class="text-xs text-gray-500">Ranking</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="bg-gray-50">
        <div class="px-4 py-3 bg-white border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Klub Lainnya</h3>
        </div>
        <?php
        $otherClubsStmt = query($pdo, "SELECT * FROM clubs WHERE id != ?", [$userClubId ?? 0]);
        while ($club = $otherClubsStmt->fetch(PDO::FETCH_ASSOC)):
        ?>
            <div class="bg-white p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50">
                <div class="flex items-center">
                    <img src="<?= htmlspecialchars($club['logo']) ?>" class="w-12 h-12 rounded-full mr-3">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <p class="font-medium text-gray-900"><?= htmlspecialchars($club['name']) ?></p>
                            <span class="text-sm text-gray-600">#<?= htmlspecialchars($club['team_ranking']) ?></span>
                        </div>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($club['city']) ?></p>
                        <div class="flex items-center space-x-4 text-xs text-gray-500 mt-1">
                            <span>👥 <?= htmlspecialchars($club['members'] ?? 'N/A') ?> Anggota</span>
                            <span>⭐ <?= htmlspecialchars($club['rating'] ?? 'N/A') ?> Rating</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php 
include 'includes/footer.php'; 
?>