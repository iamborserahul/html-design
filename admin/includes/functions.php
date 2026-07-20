<?php
/**
 * Khodiyar Steel Industries - Admin Helper Functions
 */

function csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function verify_csrf($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}

function is_authenticated() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function require_auth() {
    if (!is_authenticated()) {
        header('Location: login.php');
        exit;
    }
}

function upload_image($file, $path) {
    if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        return false;
    }

    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }

    $filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
    $dest = rtrim($path, '/') . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $dest)) {
        return $filename;
    }

    return false;
}

function delete_image($filename, $path) {
    if (empty($filename)) return false;
    $file = rtrim($path, '/') . '/' . basename($filename);
    if (file_exists($file)) {
        return unlink($file);
    }
    return false;
}

function time_ago($timestamp) {
    if (!$timestamp) return 'N/A';

    if (is_string($timestamp)) {
        $timestamp = strtotime($timestamp);
    }

    $diff = time() - $timestamp;

    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hour' . (floor($diff / 3600) > 1 ? 's' : '') . ' ago';
    if ($diff < 604800) return floor($diff / 86400) . ' day' . (floor($diff / 86400) > 1 ? 's' : '') . ' ago';
    if ($diff < 2592000) return floor($diff / 604800) . ' week' . (floor($diff / 604800) > 1 ? 's' : '') . ' ago';
    if ($diff < 31536000) return floor($diff / 2592000) . ' month' . (floor($diff / 2592000) > 1 ? 's' : '') . ' ago';

    return floor($diff / 31536000) . ' year' . (floor($diff / 31536000) > 1 ? 's' : '') . ' ago';
}

function truncate($text, $length = 100) {
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . '...';
}
