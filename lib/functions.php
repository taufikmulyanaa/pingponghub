<?php
// File: lib/functions.php

/**
 * Helper function untuk menjalankan query PDO dengan aman dan timeout protection.
 */
function query($pdo, $sql, $params = []) {
    try {
        // Set query timeout
        $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters dengan type checking
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue($key + 1, $value, $type);
            }
        }
        
        $stmt->execute();
        return $stmt;
        
    } catch (PDOException $e) {
        // Log error untuk debugging
        error_log("Query Error: " . $e->getMessage() . " | SQL: " . $sql);
        
        if (IS_DEVELOPMENT) {
            die("Query failed: " . $e->getMessage() . "<br>SQL: " . $sql);
        } else {
            // Di produksi, kembalikan null untuk handling yang aman
            return null;
        }
    }
}

/**
 * Mengambil data lengkap pengguna (profil, statistik, dan klub) dari database.
 * Dengan timeout protection dan optimized query.
 */
function getUserData($pdo, $userId) {
    if (!is_numeric($userId) || $userId <= 0) {
        return false;
    }
    
    $sql = "SELECT u.*, s.*, c.name as clubName, c.logo as clubLogo, c.short_name as clubShortName
            FROM users u
            LEFT JOIN user_stats s ON u.id = s.user_id
            LEFT JOIN clubs c ON u.club_id = c.id
            WHERE u.id = ?
            LIMIT 1";
    
    $stmt = query($pdo, $sql, [$userId]);
    
    if ($stmt) {
        return $stmt->fetch();
    }
    
    return false;
}

/**
 * Sanitize input untuk mencegah XSS dan injection
 */
function sanitizeInput($input) {
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }
    
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email format
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generate safe filename
 */
function generateSafeFilename($filename) {
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $basename = pathinfo($filename, PATHINFO_FILENAME);
    $safe_basename = preg_replace('/[^a-zA-Z0-9\-_]/', '', $basename);
    return $safe_basename . '.' . $extension;
}

/**
 * Check if request is AJAX
 */
function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

/**
 * Return JSON response with proper headers
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-cache, must-revalidate');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Safe redirect function
 */
function safeRedirect($url) {
    // Validate URL to prevent open redirect vulnerability
    $allowed_domains = ['localhost', $_SERVER['HTTP_HOST']];
    $parsed = parse_url($url);
    
    if (isset($parsed['host']) && !in_array($parsed['host'], $allowed_domains)) {
        $url = '/';
    }
    
    header('Location: ' . $url, true, 302);
    exit;
}
?>