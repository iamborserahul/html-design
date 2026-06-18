<?php
/**
 * CONFIG.PHP — Manthan Clinic
 * Database configuration and site settings
 */

// Database configuration
 define('DB_HOST', 'localhost');
 define('DB_USER', 'root');
 define('DB_PASS', '');
 define('DB_NAME', 'manthan_clinic');

// Site settings
 define('SITE_NAME', 'Manthan Clinic');
 define('SITE_EMAIL', 'info@manthanclinic.com');
 define('SITE_PHONE', '+91 98765 43210');
 define('SITE_ADDRESS', '42, Wellness Avenue, Sector 14, Jaipur, Rajasthan – 302001');
 define('SITE_URL', 'https://www.manthanclinic.com');
 define('WHATSAPP_NUMBER', '919876543210');
 define('WHATSAPP_MESSAGE', 'Hello, I would like to book an appointment.');

// Auto-detect base path (works in subdirectories like /html-design/)
 $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
 define('BASE_PATH', $scriptDir === '' ? '' : $scriptDir);

/**
 * Get database connection
 * @return PDO|null
 */
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            );
        } catch (PDOException $e) {
            // In production, log error instead of displaying
            return null;
        }
    }
    return $pdo;
}

/**
 * Sanitize input string
 */
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}
