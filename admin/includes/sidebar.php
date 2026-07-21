<?php
$nav_items = [
    'dashboard' => ['label' => 'Dashboard', 'icon' => 'fa-chart-pie', 'file' => 'index.php'],
    'products' => [
        'label' => 'Products',
        'icon' => 'fa-box',
        'file' => 'products.php',
        'children' => [
            'products.php'   => ['label' => 'All Products', 'icon' => 'fa-box',  'slug' => 'products'],
            'categories.php' => ['label' => 'Categories',   'icon' => 'fa-tags', 'slug' => 'categories'],
        ]
    ],
    'hero-slides'    => ['label' => 'Hero Slides',    'icon' => 'fa-images',          'file' => 'hero-slides.php'],
    'gallery'        => ['label' => 'Gallery',         'icon' => 'fa-photo-film',      'file' => 'gallery.php'],
    'inquiries'      => ['label' => 'Inquiries',       'icon' => 'fa-envelope',        'file' => 'inquiries.php'],
    'testimonials'   => ['label' => 'Testimonials',    'icon' => 'fa-quote-right',     'file' => 'testimonials.php'],
    'faqs'           => ['label' => 'FAQs',            'icon' => 'fa-question-circle', 'file' => 'faqs.php'],
    'team'           => ['label' => 'Team Members',    'icon' => 'fa-users',           'file' => 'team.php'],
    'stats'          => ['label' => 'Stats Counters',  'icon' => 'fa-chart-simple',    'file' => 'stats.php'],
    'extra-services' => ['label' => 'Extra Services',  'icon' => 'fa-screwdriver-wrench', 'file' => 'extra-services.php'],
    'partners'       => ['label' => 'Partners',        'icon' => 'fa-handshake',       'file' => 'partners.php'],
    'settings'       => ['label' => 'Site Settings',   'icon' => 'fa-gear',            'file' => 'settings.php'],
];

function is_active($slug) {
    global $current_page;
    return $current_page === $slug;
}

function has_active_child($children) {
    global $current_page;
    foreach ($children as $child) {
        $slug = $child['slug'] ?? '';
        if ($slug && $current_page === $slug) return true;
    }
    return false;
}

$mobile_tabs = ['dashboard', 'products', 'hero-slides', 'gallery', 'inquiries'];
?>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="dashboard.php" class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="fas fa-industry"></i>
            </div>
            <div class="sidebar-logo-text">
                <span class="sidebar-logo-title"><?= htmlspecialchars($site_name ?? 'Khodiyar Steel') ?></span>
                <span class="sidebar-logo-subtitle">Admin Panel</span>
            </div>
        </a>
        <button class="sidebar-close" id="sidebarClose">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <?php foreach ($nav_items as $key => $item): ?>
                <?php if (isset($item['children'])): ?>
                    <li class="nav-item nav-item-has-children <?= has_active_child($item['children']) ? 'active' : '' ?>">
                        <a href="<?= $item['file'] ?>" class="nav-link">
                            <span class="nav-icon"><i class="fas <?= $item['icon'] ?>"></i></span>
                            <span class="nav-label"><?= $item['label'] ?></span>
                            <span class="nav-arrow"><i class="fas fa-chevron-down"></i></span>
                        </a>
                        <ul class="nav-children">
                            <?php foreach ($item['children'] as $child_file => $child): ?>
                                <li class="nav-item <?= is_active($child['slug'] ?? '') ? 'active' : '' ?>">
                                    <a href="<?= $child_file ?>" class="nav-link">
                                        <span class="nav-icon"><i class="fas <?= $child['icon'] ?>"></i></span>
                                        <span class="nav-label"><?= $child['label'] ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item <?php echo $key;?> <?= is_active($key) ? 'active' : '' ?>">
                        <a href="<?= $item['file'] ?>" class="nav-link">
                            <span class="nav-icon"><i class="fas <?= $item['icon'] ?>"></i></span>
                            <span class="nav-label"><?= $item['label'] ?></span>
                            <?php if ($key === 'inquiries'): ?>
                                <span class="nav-badge" id="unreadBadge">0</span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </nav>
</aside>

<nav class="bottom-tab-bar" id="bottomTabBar">
    <?php foreach ($mobile_tabs as $tab_key): ?>
        <?php $item = $nav_items[$tab_key]; ?>
        <a href="<?= $item['file'] ?>" class="bottom-tab-item <?= is_active($tab_key) ? 'active' : '' ?>">
            <span class="bottom-tab-icon"><i class="fas <?= $item['icon'] ?>"></i></span>
            <span class="bottom-tab-label"><?= $item['label'] ?></span>
        </a>
    <?php endforeach; ?>
</nav>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
