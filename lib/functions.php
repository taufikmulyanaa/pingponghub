<?php
// File: lib/functions.php

/**
 * Helper function untuk menjalankan query PDO dengan aman.
 */
function query($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        // Tangani error query dengan aman
        if (IS_DEVELOPMENT) {
            die("Query failed: " . $e->getMessage());
        } else {
            // Di produksi, jangan tampilkan detail error
            // Cukup kembalikan false atau handle error sesuai kebutuhan
            return false;
        }
    }
}

/**
 * Mengambil data lengkap pengguna (profil, statistik, dan klub) dari database.
 * Menerapkan prinsip DRY (Don't Repeat Yourself).
 */
function getUserData($pdo, $userId) {
    $sql = "SELECT u.*, s.*, c.name as clubName, c.logo as clubLogo, c.short_name as clubShortName
            FROM users u
            LEFT JOIN user_stats s ON u.id = s.user_id
            LEFT JOIN clubs c ON u.club_id = c.id
            WHERE u.id = ?";
    
    $stmt = query($pdo, $sql, [$userId]);
    
    if ($stmt) {
        return $stmt->fetch();
    }
    
    return false; // Kembalikan false jika user tidak ditemukan atau query error
}