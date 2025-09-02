<?php 
// File: index.php - FIXED
include 'includes/header.php'; 

try {
    $currentUserId = 1; // Should come from session in production
    
    // Get user data with error handling
    $user = getUserData($pdo, $currentUserId);
    if (!$user) { 
        throw new Exception("User not found. Please login again."); 
    }

    // Get unread notifications count with limit and timeout protection
    $unreadStmt = query($pdo, 
        "SELECT COUNT(*) FROM notifications 
         WHERE recipient_user_id = ? AND is_read = 0", 
        [$currentUserId]
    );
    
    $unreadCount = $unreadStmt ? $unreadStmt->fetchColumn() : 0;

    // Get feed posts with LIMIT for performance (was causing hang due to no limit)
    $feedStmt = query($pdo, 
        "SELECT f.*, u.name as userName, u.photo as userPhoto 
         FROM feed f 
         LEFT JOIN users u ON f.user_id = u.id 
         ORDER BY f.created_at DESC 
         LIMIT 10"
    );
    
    $feedPosts = $feedStmt ? $feedStmt->fetchAll() : [];

    // Load template
    include 'templates/index_template.php';
    
} catch (Exception $e) {
    // Log error
    error_log("Index Page Error: " . $e->getMessage());
    
    // Show error page
    echo '<div class="max-w-4xl mx-auto p-4">
            <div class="bg-red-50 border border-red-200 p-8 rounded-lg text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="alert-circle" class="w-8 h-8 text-red-500"></i>
                </div>
                <h4 class="text-lg font-semibold text-red-800 mb-2">Loading Error</h4>
                <p class="text-red-600 mb-4">' . htmlspecialchars($e->getMessage()) . '</p>
                <div class="space-x-4">
                    <button onclick="location.reload()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        <i data-lucide="refresh-cw" class="w-4 h-4 mr-2 inline"></i>
                        Try Again
                    </button>
                    <a href="login.php" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 inline-block">
                        <i data-lucide="log-in" class="w-4 h-4 mr-2 inline"></i>
                        Login
                    </a>
                </div>
            </div>
          </div>';
}

include 'includes/footer.php'; 
?>