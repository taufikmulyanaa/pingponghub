<?php
// File: config/db.php

// Atur ke 'true' saat development, dan 'false' saat sudah online (produksi)
define('IS_DEVELOPMENT', true);

if (IS_DEVELOPMENT) {
    // Tampilkan semua error saat development
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    // Sembunyikan error dari pengguna di produksi
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
    // Catat error ke file log
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/php-error.log');
}

$host = 'localhost';
$dbname = 'pingpong_hub';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Set timeout untuk mencegah hanging
    $pdo->setAttribute(PDO::ATTR_TIMEOUT, 30);
    
    // Optimize MySQL connection
    $pdo->exec("SET SESSION wait_timeout = 300");
    $pdo->exec("SET SESSION interactive_timeout = 300");
    
} catch (PDOException $e) {
    // Tangani error koneksi dengan aman
    if (IS_DEVELOPMENT) {
        die("Database connection failed: " . $e->getMessage());
    } else {
        // Log error dan tampilkan pesan user-friendly di produksi
        error_log("Database connection failed: " . $e->getMessage());
        http_response_code(500);
        die("Service temporarily unavailable. Please try again later.");
    }
}
?>