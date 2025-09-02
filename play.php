<?php 
// File: play.php
include 'includes/header.php'; 
?>

<div class="max-w-4xl mx-auto">
    <header class="bg-white p-4 border-b border-gray-100 sticky top-0 z-40">
        <h1 class="text-xl font-bold text-gray-900 mb-4 text-center md:text-left">Play Hub</h1>
        <div class="bg-gray-100 rounded-lg px-4 py-3 flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Cari turnamen, venue..." class="bg-transparent text-gray-600 text-sm flex-1 outline-none">
        </div>
    </header>

    <div class="bg-gray-50">
        <div class="px-4 py-3 bg-white border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Turnamen Mendatang</h3>
                <a href="#" class="text-sm text-orange-500 font-medium">Lihat Semua</a>
            </div>
        </div>
        
        <?php
        try {
            $tournamentsStmt = query($pdo, "SELECT * FROM tournaments WHERE status = 'Open' ORDER BY date ASC LIMIT 3");
            
            if ($tournamentsStmt->rowCount() > 0) {
                while ($t = $tournamentsStmt->fetch(PDO::FETCH_ASSOC)):
                    // Gunakan data partisipan dari database
                    $participants = $t['participants'] ?? 0;
                    $max_participants = $t['max_participants'] ?? 1; // Hindari pembagian dengan nol
                    $progress = ($participants / $max_participants) * 100;
        ?>
        <div class="bg-white p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1 pr-4">
                    <h3 class="font-medium text-gray-900 mb-1"><?= htmlspecialchars($t['name']) ?></h3>
                    <div class="space-y-1 text-sm text-gray-600">
                        <p>📅 <?= date("d M Y", strtotime($t['date'])) ?></p>
                        <p>📍 <?= htmlspecialchars($t['location']) ?></p>
                        <p>🏆 Rp <?= number_format($t['prize'], 0, ',', '.') ?></p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full"><?= htmlspecialchars($t['category']) ?></span>
                    <p class="text-xs text-gray-500 mt-2">👥 <?= $participants ?>/<?= $t['max_participants'] ?></p>
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                <div class="bg-orange-500 h-2 rounded-full" style="width: <?= $progress ?>%"></div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-900">Rp <?= number_format($t['fee'], 0, ',', '.') ?></span>
                <button class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm rounded-lg font-medium">Daftar</button>
            </div>
        </div>
        <?php 
                endwhile;
            } else {
                echo "<p class='text-center text-gray-500 p-4'>Belum ada turnamen yang tersedia.</p>";
            }
        } catch (PDOException $e) {
             echo "<p class='text-center text-red-500 p-4'>Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
    
</div>

<?php 
include 'includes/footer.php'; 
?>