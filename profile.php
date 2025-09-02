<?php include 'includes/header.php'; ?>

<?php
// Asumsikan user yang login punya ID 1
$loggedInUserId = 1; 

// Cek apakah ada ID di URL, jika tidak gunakan ID user yang login
$userId = isset($_GET['id']) ? (int)$_GET['id'] : $loggedInUserId;

$userStmt = query($pdo, "SELECT users.*, clubs.name as clubName, clubs.logo as clubLogo FROM users LEFT JOIN clubs ON users.clubId = clubs.id WHERE users.id = ?", [$userId]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<p class='p-4 text-center'>User tidak ditemukan.</p>";
    include 'includes/footer.php';
    exit();
}
?>

<div class="max-w-4xl mx-auto">
    <header class="bg-white p-4 border-b border-gray-100">
         <div class="flex items-center">
            <?php if ($userId !== $loggedInUserId): ?>
            <a href="javascript:history.back()" class="mr-4 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <?php endif; ?>
            <h1 class="text-xl font-bold text-gray-900">Profile</h1>
        </div>
    </header>

    <div class="bg-white p-6 text-center border-b border-gray-100">
        <img src="<?= htmlspecialchars($user['photo']) ?>" class="w-24 h-24 rounded-full mx-auto mb-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($user['name']) ?></h2>
        <div class="flex items-center justify-center text-gray-600 mb-3">
            <span class="mr-4">📍 <?= htmlspecialchars($user['location']) ?></span>
            <span>⭐ <?= htmlspecialchars($user['elo']) ?></span>
        </div>
        <div class="flex items-center justify-center space-x-2 mb-3">
            <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full"><?= htmlspecialchars($user['skill']) ?></span>
            <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full"><?= htmlspecialchars($user['style']) ?></span>
        </div>
         <?php if ($user['clubName']) : ?>
            <div class="inline-flex items-center bg-orange-50 p-3 rounded-lg border border-orange-200">
                <img src="<?= htmlspecialchars($user['clubLogo']) ?>" class="w-6 h-6 rounded-full mr-2">
                <span class="text-orange-800 font-medium"><?= htmlspecialchars($user['clubName']) ?></span>
            </div>
        <?php endif; ?>
    </div>

    <div class="bg-white p-4">
         <h3 class="font-semibold text-gray-900 mb-3">Statistics</h3>
         <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
             <div class="text-center bg-gray-50 p-3 rounded-lg">
                <p class="text-2xl font-bold text-gray-900"><?= $user['matches_played'] ?></p>
                <p class="text-sm text-gray-600">Total Matches</p>
             </div>
             <div class="text-center bg-gray-50 p-3 rounded-lg">
                 <p class="text-2xl font-bold text-gray-900"><?= $user['matches_played'] > 0 ? round(($user['wins'] / $user['matches_played']) * 100) : 0 ?>%</p>
                 <p class="text-sm text-gray-600">Win Rate</p>
            </div>
            </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>