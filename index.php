<?php
$title = "Khodiyar Steel – High-End Steel Furniture & Precision Metal Products";
$description = "Transforming spaces with high-end steel furniture and premium storage solutions.";
$page = "home";
require_once __DIR__ . '/config/database.php';
include 'header.php';
$hero_slides = [];
$categories = [];
$stats = [];
$faqs = [];
$gallery_items = [];
$featured_products = [];
$showcase_products = [];
$partners = [];
$extra_services = [];

try {
    $db = getDB();
    $hero_slides = $db->query("SELECT * FROM hero_slides WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
    $categories = $db->query("SELECT * FROM product_categories WHERE status = 1 ORDER BY sort_order ASC, name ASC")->fetchAll();
    $stats = $db->query("SELECT * FROM stats_counters WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
    $faqs = $db->query("SELECT * FROM faqs WHERE status = 1 ORDER BY sort_order ASC, id ASC LIMIT 6")->fetchAll();
    $gallery_items = $db->query("SELECT * FROM gallery_items WHERE status = 1 ORDER BY sort_order ASC, id DESC")->fetchAll();
    $featured_products = $db->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN product_categories c ON p.category_id = c.id WHERE p.status = 1 ORDER BY p.sort_order ASC, p.id DESC LIMIT 6")->fetchAll();
    $showcase_products = $db->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN product_categories c ON p.category_id = c.id WHERE p.featured = 1 AND p.status = 1 ORDER BY p.sort_order ASC, p.id DESC LIMIT 3")->fetchAll();
    $partners = $db->query("SELECT * FROM partners WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
    $extra_services = $db->query("SELECT * FROM extra_services WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
} catch (Exception $e) {
    // Fallback
}
$total_slides = count($hero_slides);
?>

<!-- Full-Width 2D Image Slider Hero -->
    <section class="aiero-hero">
        <div class="aiero-slider-2d-container">

<?php if (!empty($hero_slides)): ?>
    <?php foreach ($hero_slides as $i => $slide): ?>
            <div class="aiero-slide-2d<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>">
                <div class="aiero-slide-img" style="background-image: url('<?= SLIDER_URL ?>/<?= htmlspecialchars($slide['image']) ?>');"></div>
                <div class="aiero-slide-content">
                    <span class="aiero-slide-tagline"><?= htmlspecialchars($slide['subtitle'] ?? '') ?></span>
                    <h1 class="aiero-slide-title"><?= htmlspecialchars($slide['title']) ?></h1>
                    <p class="aiero-slide-desc"><?= htmlspecialchars($slide['description'] ?? '') ?></p>
                    <a href="<?= htmlspecialchars($slide['btn_link'] ?? '#contact') ?>" class="aiero-btn-discover"><?= htmlspecialchars($slide['btn_text'] ?? 'Discover') ?> <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
            </div>
    <?php endforeach; ?>
<?php endif; ?>
        </div>

        <!-- Progress Timeline Bar -->
        <div class="aiero-progress-bar-container">
            <div class="aiero-progress-bar"></div>
        </div>

        <!-- 2D Slider Arrow Navigation -->
        <button class="aiero-arrow btn-prev" aria-label="Previous Slide"><i
                class="fa-solid fa-arrow-left-long"></i></button>
        <button class="aiero-arrow btn-next" aria-label="Next Slide"><i
                class="fa-solid fa-arrow-right-long"></i></button>

        <!-- 2D Slider Pagination dots -->
        <div class="aiero-nav-controls">
<?php if (!empty($hero_slides)): ?>
    <?php foreach ($hero_slides as $i => $slide): ?>
            <span class="aiero-nav-dot<?= $i === 0 ? ' active' : '' ?>" data-slide="<?= $i ?>"></span>
    <?php endforeach; ?>
<?php endif; ?>
        </div>
    </section>

    <!-- Premium Animated About Us Section -->
    <?php
    $about_tagline = get_setting('about_tagline') ?: 'ABOUT US';
    $about_title = get_setting('about_title') ?: 'Built on Strength.<br>Driven by Quality.';
    $about_desc = get_setting('about_description') ?: '';
    $about_img1 = get_setting('about_image_1') ?: 'assets/metal-bed-7201-01.webp';
    $about_img2 = get_setting('about_image_2') ?: 'assets/origami-bunk-bed-02.webp';
    $about_phone = get_setting('site_phone') ?: '90999 99266';
    $about_phone_clean = preg_replace('/[^0-9]/', '', $about_phone);
    ?>
    <section class="aiero-about" id="about">
        <!-- Purple Semi-Circle - Right Side -->
        <div class="aiero-geom-shape shape-purple"></div>
        <!-- Pink Circle - Bottom Right -->
        <div class="aiero-geom-shape shape-pink-circle"></div>
        <div class="aiero-about-container">
            <!-- Left Column Content -->
            <div class="aiero-about-content">
                <span class="aiero-about-tagline"><?= htmlspecialchars($about_tagline) ?></span>
                <h2 class="aiero-about-title">
                    <?= $about_title ?>
                </h2>
                <div class="aiero-about-desc">
                    <?= $about_desc ?>
                </div>
                <div class="aiero-about-phone">
                    <div class="aiero-phone-icon">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>
                    <div class="aiero-phone-details">
                        <span class="aiero-phone-label">Contact Us</span>
                        <a href="tel:<?= htmlspecialchars($about_phone_clean) ?>" class="aiero-phone-num"><?= htmlspecialchars($about_phone) ?></a>
                    </div>
                </div>
            </div>

            <!-- Right Column staggered images -->
            <div class="aiero-about-images">
                <div class="aiero-about-img-wrapper animate-img-left">
                    <div class="aiero-about-img-box aiero-float-left">
                        <img src="<?= htmlspecialchars($about_img1) ?>" alt="Premium steel lounge structure design">
                    </div>
                </div>
                <div class="aiero-about-img-wrapper shifted animate-img-right">
                    <div class="aiero-about-img-box aiero-float-right">
                        <img src="<?= htmlspecialchars($about_img2) ?>" alt="Modern sensory bedroom sanctuary space">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Glassmorphic Portfolio Number Counters -->
    <section class="aiero-counters-section">
        <!-- Gold Sector Shape - Top Left -->
        <div class="aiero-geom-shape shape-gold-sector"></div>
        <!-- 3D Spiral Helix - Right Side -->
        <div class="aiero-counters-grid">
        <?php if (!empty($stats)): ?>
            <?php foreach ($stats as $s): ?>
                <div class="aiero-counter-card">
                    <div class="aiero-counter-icon"><i class="fa-solid <?= htmlspecialchars($s['icon'] ?: 'fa-chart-simple') ?>"></i></div>
                    <span class="aiero-counter-number" data-target="<?= (int) $s['value'] ?>" data-suffix="<?= htmlspecialchars($s['suffix']) ?>">0</span>
                    <span class="aiero-counter-label"><?= htmlspecialchars($s['label']) ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="aiero-counter-card">
                <div class="aiero-counter-icon"><i class="fa-solid fa-calendar-check"></i></div>
                <span class="aiero-counter-number" data-target="1998">0</span>
                <span class="aiero-counter-label">Established &amp; serving<br>the industry since</span>
            </div>
            <div class="aiero-counter-card">
                <div class="aiero-counter-icon"><i class="fa-solid fa-layer-group"></i></div>
                <span class="aiero-counter-number" data-target="15000">0</span>
                <span class="aiero-counter-label">Projects delivered<br>across all categories</span>
            </div>
            <div class="aiero-counter-card">
                <div class="aiero-counter-icon"><i class="fa-solid fa-handshake"></i></div>
                <span class="aiero-counter-number" data-target="500">0</span>
                <span class="aiero-counter-label">Active national dealers<br>and distribution points</span>
            </div>
            <div class="aiero-counter-card">
                <div class="aiero-counter-icon"><i class="fa-solid fa-award"></i></div>
                <span class="aiero-counter-number" data-target="25">0</span>
                <span class="aiero-counter-label">Years of manufacturing<br>excellence &amp; trust</span>
            </div>
        <?php endif; ?>
        </div>
    </section>
    <!-- Interactive Product Categories Section -->
    <section class="aiero-categories-section" id="categories">
        <!-- Floating Ambient Background Light -->
        <div class="aiero-categories-glow"></div>

        <div class="aiero-categories-container">
            <div class="aiero-categories-header">
                <span class="aiero-categories-tagline">OUR DIVISIONS</span>
                <h2 class="aiero-categories-title">Explore Our Premium<br>Product Collections</h2>
            </div>

            <div class="aiero-categories-grid">
            <?php
            $slug_mapping = [
                'metal-beds-bunks' => 'category-beds',
                'steel-cupboards' => 'category-cupboards',
                'dining-bathroom' => 'category-dining-bathroom',
                'doors-security-gates' => 'category-doors',
                'hospital-equipment' => 'category-hospital',
                'outdoor-furniture' => 'category-outdoor',
            ];
            ?>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $c): ?>
                    <?php 
                    $link = 'category/' . urlencode($c['slug']);
                    ?>
                    <a href="<?= htmlspecialchars($link) ?>" class="aiero-category-card">
                        <div class="aiero-category-card-border"></div>
                        <div class="aiero-category-icon" style="display:flex;align-items:center;justify-content:center;width:64px;height:64px;">
                            <?php if (!empty($c['icon'])): ?>
                                <?php if (strpos($c['icon'], 'fa-') === 0): ?>
                                    <i class="fa-solid <?= htmlspecialchars($c['icon']) ?>" style="font-size: 2rem;"></i>
                                <?php else: ?>
                                    <img src="uploads/categories/<?= htmlspecialchars($c['icon']) ?>" alt="" style="width: 100%; height: 100%; object-fit: contain;">
                                <?php endif; ?>
                            <?php else: ?>
                                <i class="fa-solid fa-tag" style="font-size: 2rem;"></i>
                            <?php endif; ?>
                        </div>
                        <h3 class="aiero-category-card-title"><?= htmlspecialchars($c['name']) ?></h3>
                        <p class="aiero-category-card-desc"><?= htmlspecialchars($c['description'] ?? '') ?></p>
                        <span class="aiero-category-link-btn">EXPLORE CATALOG <i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Category 1 -->
                <a href="category/metal-beds-bunks" class="aiero-category-card">
                    <div class="aiero-category-card-border"></div>
                    <div class="aiero-category-icon"><i class="fa-solid fa-couch"></i></div>
                    <h3 class="aiero-category-card-title">Metal Beds & Bunks</h3>
                    <p class="aiero-category-card-desc">Heavy-duty elegant single, double, & kids bunk beds engineered for lifetime durability.</p>
                    <span class="aiero-category-link-btn">EXPLORE CATALOG <i class="fa-solid fa-chevron-right"></i></span>
                </a>
                <!-- Category 2 -->
                <a href="category/steel-cupboards" class="aiero-category-card">
                    <div class="aiero-category-card-border"></div>
                    <div class="aiero-category-icon"><i class="fa-solid fa-cabinet-filing"></i></div>
                    <h3 class="aiero-category-card-title">Steel Cupboards</h3>
                    <p class="aiero-category-card-desc">Secure modular almirahs, wardrobe lockers, and premium dynamic storage cabinets.</p>
                    <span class="aiero-category-link-btn">EXPLORE CATALOG <i class="fa-solid fa-chevron-right"></i></span>
                </a>
            <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Premium Animated Creations Section -->
    <section class="aiero-creations" id="creations">
        <div class="aiero-creations-container">
            <!-- Section Header -->
            <div class="aiero-creations-header">
                <span class="aiero-creations-tagline">OUR CREATIONS</span>
                <h2 class="aiero-creations-title">Engineered for Strength.<br>Built for Everyday Use</h2>
            </div>

            <!-- Staggered Card Grid -->
            <div class="aiero-creations-grid">
            <?php if (!empty($featured_products)): ?>
                <?php foreach ($featured_products as $i => $prod): ?>
                    <?php 
                    $float_class = 'card-float-' . (($i % 3) + 1); 
                    $img_src = htmlspecialchars($prod['featured_image']);
                    if (strpos($img_src, 'assets/') !== 0) {
                        $img_src = 'uploads/' . $img_src;
                    }
                    ?>
                    <div class="aiero-creation-card-wrapper">
                        <a href="product/<?= htmlspecialchars($prod['slug']) ?>" class="aiero-creation-card <?= $float_class ?>" style="display: block;">
                            <div class="aiero-creation-img" style="background-image: url('<?= $img_src ?>');"></div>
                            <div class="aiero-creation-view-more">VIEW DETAILS</div>
                            <div class="aiero-creation-content">
                                <span class="aiero-creation-label"><?= htmlspecialchars($prod['name']) ?></span>
                                <p class="aiero-creation-desc"><?= htmlspecialchars($prod['short_description']) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="opacity: 0.6; text-align: center; width: 100%;">No creations found.</p>
            <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Stacked Sticky Product Showcase Section -->
    <section class="showcase-section" id="showcase">
        <div class="showcase-container">
            <!-- Header -->
            <div class="showcase-header">
                <span class="showcase-subtitle">SIGNATURE COLLECTION</span>
                <h2 class="showcase-title">Value for Money Steel Masterpieces</h2>
                <p class="showcase-desc-text">Explore our best-value creations, engineered with industrial-strength
                    and designed for state-of-the-art visual aesthetics.</p>
            </div>

            <!-- Sticky Cards Stack -->
            <div class="showcase-stack">
            <?php if (!empty($showcase_products)): ?>
                <?php foreach ($showcase_products as $idx => $prod): ?>
                    <?php 
                    $progress = $idx === 0 ? '100%' : '0%'; 
                    $img_src = htmlspecialchars($prod['featured_image']);
                    if (strpos($img_src, 'assets/') !== 0) {
                        $img_src = 'uploads/' . $img_src;
                    }
                    ?>
                    <div class="showcase-card" id="card-<?= ($idx + 1) ?>">
                        <div class="card-inner">
                            <div class="card-bg-img" style="background-image: url('<?= $img_src ?>');"></div>
                            <div class="card-gradient-overlay"></div>

                            <div class="card-tags-overlay">
                                <span class="card-pill-tag">SIGNATURE</span>
                                <span class="card-pill-tag"><?= htmlspecialchars(strtoupper($prod['category_name'] ?? 'Product')) ?></span>
                            </div>

                            <div class="card-scroll-indicator">
                                <svg class="progress-ring" width="60" height="60">
                                    <circle class="progress-ring__circle-bg" stroke="rgba(255, 255, 255, 0.15)" stroke-width="2" fill="transparent" r="24" cx="30" cy="30" />
                                    <circle class="progress-ring__circle" stroke="var(--color-primary)" stroke-width="2" fill="transparent" r="24" cx="30" cy="30" />
                                </svg>
                                <span class="progress-val"><?= $progress ?></span>
                            </div>

                            <div class="card-content-overlay">
                                <span class="card-category"><?= htmlspecialchars(strtoupper($prod['category_name'] ?? 'Product')) ?></span>
                                <h3 class="card-title"><?= htmlspecialchars($prod['name']) ?></h3>
                                <div class="card-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating-val">5.0</span>
                                </div>
                                <p class="card-desc"><?= htmlspecialchars($prod['short_description']) ?></p>
                                <div class="card-footer-row">
                                    <div class="card-price"></div>
                                    <div class="card-actions">
                                        <a href="contact?product=<?= urlencode($prod['name']) ?>" class="btn-shop-now">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                                        <a href="product/<?= htmlspecialchars($prod['slug']) ?>" class="btn-view-details">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="opacity: 0.6; text-align: center; width: 100%;">No showcase products found.</p>
            <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="aiero-gallery-section" id="gallery">
        <div class="aiero-geom-shape shape-gold-sector"></div>
        <div class="aiero-geom-shape shape-pink-circle"></div>
        <div class="aiero-gallery-container">
            <div class="aiero-gallery-header">
                <span class="aiero-gallery-subtitle">PORTFOLIO</span>
                <h2 class="aiero-gallery-title">Featured Gallery</h2>
                <p class="aiero-gallery-desc">Explore our curated collection of premium steel fabrications — each piece
                    engineered for industrial strength and designed for architectural elegance.</p>
            </div>
            <div class="aiero-gallery-rows">
            <?php
            $top_items = [];
            $bottom_items = [];
            if (!empty($gallery_items)) {
                foreach ($gallery_items as $idx => $item) {
                    if ($idx % 2 === 0) {
                        $top_items[] = $item;
                    } else {
                        $bottom_items[] = $item;
                    }
                }
            }
            ?>
                <div class="aiero-gallery-row">
                    <div class="aiero-gallery-track aiero-gallery-track--top">
                    <?php if (!empty($top_items)): ?>
                        <?php 
                        $display_top = $top_items;
                        while (count($display_top) < 8) {
                            $display_top = array_merge($display_top, $top_items);
                        }
                        $sizes = ['lg', 'sm', 'md'];
                        ?>
                        <?php foreach ($display_top as $idx => $item): ?>
                            <?php $size = $sizes[$idx % 3]; ?>
                            <div class="aiero-gallery-card aiero-gallery-card--<?= $size ?>">
                                <div class="aiero-gallery-card-img" style="background-image: url('uploads/gallery/<?= htmlspecialchars($item['image']) ?>');">
                                </div>
                                <div class="aiero-gallery-card-overlay">
                                    <span class="aiero-gallery-card-label"><?= htmlspecialchars($item['title']) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/metal-bed-7201-01.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Luxury Bedstead</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--sm">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/fire-safety-door-03.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Steel Doors</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--md">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/icu-fowler-bed-01.webp');"></div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Hospital Suite</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/household-wardrobe-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Cupboard System</span></div>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="aiero-gallery-row">
                    <div class="aiero-gallery-track aiero-gallery-track--bottom">
                    <?php if (!empty($bottom_items)): ?>
                        <?php 
                        $display_bottom = $bottom_items;
                        while (count($display_bottom) < 8) {
                            $display_bottom = array_merge($display_bottom, $bottom_items);
                        }
                        $sizes = ['md', 'lg', 'sm'];
                        ?>
                        <?php foreach ($display_bottom as $idx => $item): ?>
                            <?php $size = $sizes[$idx % 3]; ?>
                            <div class="aiero-gallery-card aiero-gallery-card--<?= $size ?>">
                                <div class="aiero-gallery-card-img" style="background-image: url('uploads/gallery/<?= htmlspecialchars($item['image']) ?>');">
                                </div>
                                <div class="aiero-gallery-card-overlay">
                                    <span class="aiero-gallery-card-label"><?= htmlspecialchars($item['title']) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="aiero-gallery-card aiero-gallery-card--md">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/household-wardrobe-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Cupboard System</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/icu-fowler-bed-01.webp');"></div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Hospital Suite</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--sm">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/garden-steel-gazebo-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Outdoor Structure</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/dining-set-ds301-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Dining Set</span></div>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Unique Pro "Extra Services" Section -->
    <?php
    // Fetch section settings
    $svc_subtitle     = get_setting('services_subtitle')      ?: 'UTILITY RANGE';
    $svc_title        = get_setting('services_title')         ?: 'Bathroom & Utility Metal Products';
    $svc_desc         = get_setting('services_description')   ?: '';
    $svc_catalogue    = get_setting('services_catalogue_url') ?: 'ksi/Khodiyar_Bathroom_Utility_Metal_Products_Catalogue.pdf';
    $svc_contact_name = get_setting('services_contact_name')  ?: 'Mr. Manthan Sakariya (CEO)';
    $svc_contact_ph   = get_setting('services_contact_phone') ?: '+91 73598 40800';
    $svc_contact_em   = get_setting('services_contact_email') ?: 'info@khodiyarsteel.com';
    $svc_phone_clean  = preg_replace('/[^0-9+]/', '', $svc_contact_ph);
    ?>
    <section class="aiero-services-section" id="services">
        <!-- Pink Sector - Left Side -->
        <div class="aiero-geom-shape shape-pink-sector"></div>
        <!-- Yellow Cone - Bottom Left -->
        <div class="aiero-geom-shape shape-yellow-cone"></div>
        <!-- Pink Cube - Floating Right -->
        <div class="aiero-geom-shape shape-pink-cube"></div>
        <div class="aiero-services-container">
            <!-- Left Side: Elegant Text Details -->
            <div class="aiero-services-text-col">
                <span class="aiero-services-subtitle"><?= htmlspecialchars($svc_subtitle) ?></span>
                <h2 class="aiero-services-title"><?= htmlspecialchars($svc_title) ?></h2>
                <div class="aiero-services-desc">
                    <?= $svc_desc ?>
                </div>
                <?php if ($svc_catalogue): ?>
                <div style="margin-bottom: 2rem;">
                    <a href="<?= htmlspecialchars($svc_catalogue) ?>" download
                        class="aiero-btn-capsule" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-file-pdf"></i> Download Catalogue
                    </a>
                </div>
                <?php endif; ?>
                <div class="aiero-services-contact-container"
                    style="display: flex; flex-direction: column; gap: 1.2rem;">
                    <div class="aiero-services-contact">
                        <div class="aiero-services-contact-icon">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="aiero-services-contact-details">
                            <span class="aiero-services-contact-label"><?= htmlspecialchars($svc_contact_name) ?></span>
                            <a href="tel:<?= htmlspecialchars($svc_phone_clean) ?>" class="aiero-services-contact-num"><?= htmlspecialchars($svc_contact_ph) ?></a>
                            <span class="aiero-services-contact-label"
                                style="display: block; font-size: 0.75rem; opacity: 0.8; margin-top: 0.1rem; text-transform: lowercase;"><?= htmlspecialchars($svc_contact_em) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Liquid Parallax Depth Slider -->
            <div class="aiero-services-slider-col">
                <div class="aiero-services-slider-wrapper">
                    <div class="aiero-services-slider-track">
                        <?php if (!empty($extra_services)): ?>
                            <?php foreach ($extra_services as $svc): ?>
                            <div class="aiero-service-card">
                                <div class="aiero-service-card-img-wrap">
                                    <div class="aiero-service-card-img"
                                        style="background-image: url('<?= htmlspecialchars($svc['image'] ?: 'assets/service_br01.png') ?>');">
                                    </div>
                                </div>
                                <div class="aiero-service-card-content">
                                    <h3 class="aiero-service-card-title"><?= htmlspecialchars($svc['title']) ?></h3>
                                    <div class="aiero-service-card-price-row">
                                        <span class="aiero-service-card-price"><?= htmlspecialchars($svc['prefix']) ?></span>
                                        <span class="aiero-service-card-period">/ <?= htmlspecialchars($svc['subtitle']) ?></span>
                                    </div>
                                    <ul class="aiero-service-card-specs">
                                        <?php foreach (['spec_1','spec_2','spec_3','spec_4'] as $spec): ?>
                                            <?php if (!empty($svc[$spec])): ?>
                                            <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                                <span><?= htmlspecialchars($svc[$spec]) ?></span>
                                            </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Fallback: no cards in DB -->
                            <div class="aiero-service-card">
                                <div class="aiero-service-card-content" style="padding: 2rem; text-align: center; color: rgba(255,255,255,0.4);">
                                    <i class="fa-solid fa-screwdriver-wrench" style="font-size:2rem;margin-bottom:0.75rem;display:block;"></i>
                                    No service cards have been added yet.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Slider Navigation Dots -->
                <div class="aiero-services-nav-controls"></div>
            </div>
        </div>
    </section>

    <!-- Premium Home FAQ Section -->
    <section class="aiero-faq-section" id="home-faq">
        <!-- Dark Node - Bottom Left -->
        <div class="aiero-faq-wrapper">
            <div class="aiero-geom-shape shape-spiral-helix"></div>

            <div style="text-align: center; display: flex; flex-direction: column; gap: 1rem; margin-bottom: 3.5rem;">
                <span class="aiero-creations-tagline">COMMON INQUIRIES</span>
                <h2 class="aiero-creations-title" style="font-size: 36px; text-align: center;">Frequently Asked
                    Questions</h2>
            </div>

            <?php if (!empty($faqs)): ?>
                <?php foreach ($faqs as $faq): ?>
                    <div class="aiero-faq-item">
                        <button class="aiero-faq-trigger" aria-expanded="false">
                            <span class="aiero-faq-question"><?= htmlspecialchars($faq['question']) ?></span>
                            <i class="fa-solid fa-chevron-down aiero-faq-icon"></i>
                        </button>
                        <div class="aiero-faq-panel">
                            <div class="aiero-faq-content">
                                <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="aiero-faq-item">
                    <button class="aiero-faq-trigger" aria-expanded="false">
                        <span class="aiero-faq-question">What structural raw materials does Khodiyar Steel utilize?</span>
                        <i class="fa-solid fa-chevron-down aiero-faq-icon"></i>
                    </button>
                    <div class="aiero-faq-panel">
                        <div class="aiero-faq-content">
                            We utilize premium-grade structural steel, high-gauge carbon steel pipes, and durable stainless steel sections. Every piece of raw metal undergoes strict anti-rust treatments, phosphating chemical cleaning, and is finished with industrial-grade powder coating to guarantee load resistance and rust prevention.
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Infinite Sliding Collaboration Marquee -->
    <section class="aiero-marquee-section">
        <div class="aiero-marquee-container">
            <span class="aiero-creations-tagline" style="font-size: 0.75rem; opacity: 0.85;">TRUSTED BY INDUSTRY
                LEADERS</span>
        </div>
        <div style="overflow: hidden; width: 100%;">
            <div class="aiero-marquee-track">
                <?php if (!empty($partners)): ?>
                    <!-- Set 1 -->
                    <?php foreach ($partners as $partner): ?>
                        <div class="aiero-marquee-item"><i class="<?= htmlspecialchars($partner['icon']) ?>"></i> <?= htmlspecialchars($partner['name']) ?></div>
                    <?php endforeach; ?>
                    <!-- Set 2 (Duplicated for seamless loop) -->
                    <?php foreach ($partners as $partner): ?>
                        <div class="aiero-marquee-item"><i class="<?= htmlspecialchars($partner['icon']) ?>"></i> <?= htmlspecialchars($partner['name']) ?></div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Set 1 -->
                    <div class="aiero-marquee-item"><i class="fa-solid fa-hospital"></i> Apex Hospital Group</div>
                    <div class="aiero-marquee-item"><i class="fa-solid fa-hotel"></i> Royal Palace Hotels</div>
                    <div class="aiero-marquee-item"><i class="fa-solid fa-building-shield"></i> Gujarat Infra Ltd</div>
                    <div class="aiero-marquee-item"><i class="fa-solid fa-couch"></i> Luxury Living Co.</div>
                    <div class="aiero-marquee-item"><i class="fa-solid fa-graduation-cap"></i> Elite Academy Group</div>
                    <div class="aiero-marquee-item"><i class="fa-solid fa-warehouse"></i> Surat Steel Hub</div>
                    <!-- Set 2 (Duplicated for seamless loop) -->
                    <div class="aiero-marquee-item"><i class="fa-solid fa-hospital"></i> Apex Hospital Group</div>
                    <div class="aiero-marquee-item"><i class="fa-solid fa-hotel"></i> Royal Palace Hotels</div>
                    <div class="aiero-marquee-item"><i class="fa-solid fa-building-shield"></i> Gujarat Infra Ltd</div>
                    <div class="aiero-marquee-item"><i class="fa-solid fa-couch"></i> Luxury Living Co.</div>
                    <div class="aiero-marquee-item"><i class="fa-solid fa-graduation-cap"></i> Elite Academy Group</div>
                    <div class="aiero-marquee-item"><i class="fa-solid fa-warehouse"></i> Surat Steel Hub</div>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
