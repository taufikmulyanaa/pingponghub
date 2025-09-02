<?php
$host = 'localhost';
$dbname = 'pingpong_hub'; // Diubah dari pingpong_plus
$user = 'root'; // Ganti dengan username database Anda
$pass = '';     // Ganti dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Memberikan pesan error yang lebih ramah di produksi
    // Anda bisa menggantinya dengan logging error
    die("Tidak dapat terhubung ke database. Silakan coba lagi nanti.");
}

// Helper function untuk memudahkan query
function query($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        // Menangani error query
        // Di lingkungan produksi, sebaiknya log error ini daripada menampilkannya
        die("Query failed: " . $e->getMessage());
    }
}
?>