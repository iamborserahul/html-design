<?php

require_once __DIR__ . '/database.php';

define('UPLOADS_PATH', __DIR__ . '/../uploads');
define('UPLOADS_URL', 'uploads');

define('SLIDER_PATH', UPLOADS_PATH . '/slider');
define('SLIDER_URL', UPLOADS_URL . '/slider');

define('GALLERY_PATH', UPLOADS_PATH . '/gallery');
define('GALLERY_URL', UPLOADS_URL . '/gallery');

define('CATEGORY_PATH', UPLOADS_PATH . '/categories');
define('CATEGORY_URL', UPLOADS_URL . '/categories');

define('TEAM_PATH', UPLOADS_PATH . '/team');
define('TEAM_URL', UPLOADS_URL . '/team');

define('TESTIMONIAL_PATH', UPLOADS_PATH . '/testimonials');
define('TESTIMONIAL_URL', UPLOADS_URL . '/testimonials');

define('LOGO_PATH', UPLOADS_PATH . '/logo');
define('LOGO_URL', UPLOADS_URL . '/logo');

function get_setting($key) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT `value` FROM site_settings WHERE `key` = ? LIMIT 1");
        $stmt->execute([$key]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['value'] : null;
    } catch (PDOException $e) {
        return null;
    }
}
