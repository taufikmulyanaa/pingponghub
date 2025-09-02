<?php 
include 'includes/header.php'; 

$currentUserId = 1;
$user = getUserData($pdo, $currentUserId);
if (!$user) { die("Pengguna tidak ditemukan."); }

$unreadStmt = query($pdo, "SELECT COUNT(*) FROM notifications WHERE recipient_user_id = ? AND is_read = 0", [$currentUserId]);
$unreadCount = $unreadStmt->fetchColumn();

$feedStmt = query($pdo, 
    "SELECT f.*, u.name as userName, u.photo as userPhoto 
     FROM feed f 
     LEFT JOIN users u ON f.user_id = u.id 
     ORDER BY f.created_at DESC"
);
$feedPosts = $feedStmt->fetchAll();

include 'templates/index_template.php';
include 'includes/footer.php'; 
?>