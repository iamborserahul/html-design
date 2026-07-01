<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/functions.php';

require_auth();

$id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;
$token = $_REQUEST['csrf_token'] ?? '';

if (!$id || !verify_csrf($token)) {
    header('Location: products.php?msg=' . urlencode('Invalid request.') . '&type=error');
    exit;
}

$db = getDB();

try {
    $stmt = $db->prepare("SELECT id, name, featured_image FROM products WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if (!$product) {
        header('Location: products.php?msg=' . urlencode('Product not found.') . '&type=error');
        exit;
    }

    // Delete featured image
    if (!empty($product['featured_image'])) {
        delete_image($product['featured_image'], __DIR__ . '/uploads/');
    }

    // Delete product images from filesystem
    $stmt = $db->prepare("SELECT image FROM product_images WHERE product_id = ?");
    $stmt->execute([$id]);
    $images = $stmt->fetchAll();
    foreach ($images as $img) {
        delete_image($img['image'], __DIR__ . '/uploads/');
    }

    // Delete related records (cascading should handle this, but be explicit)
    $db->prepare("DELETE FROM product_images WHERE product_id = ?")->execute([$id]);
    $db->prepare("DELETE FROM product_specs WHERE product_id = ?")->execute([$id]);
    $db->prepare("DELETE FROM product_features WHERE product_id = ?")->execute([$id]);

    // Delete product
    $db->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);

    header('Location: products.php?msg=' . urlencode('Product "' . htmlspecialchars($product['name']) . '" deleted successfully.') . '&type=success');
    exit;

} catch (PDOException $e) {
    header('Location: products.php?msg=' . urlencode('Database error: ' . $e->getMessage()) . '&type=error');
    exit;
}
