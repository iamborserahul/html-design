<?php
$title = "Khodiyar Steel – High-End Steel Furniture & Precision Metal Products";
$description = "Transforming spaces with high-end steel furniture and premium storage solutions.";
$page = "home";
require_once __DIR__ . '/config/database.php';
include 'header.php';
$hero_slides = [];
try {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM hero_slides WHERE status = 1 ORDER BY sort_order ASC, id ASC");
    $hero_slides = $stmt->fetchAll();
} catch (Exception $e) {
    $hero_slides = [];
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
    <section class="aiero-about" id="about">
        <!-- Purple Semi-Circle - Right Side -->
        <div class="aiero-geom-shape shape-purple"></div>
        <!-- Pink Circle - Bottom Right -->
        <div class="aiero-geom-shape shape-pink-circle"></div>
        <div class="aiero-about-container">
            <!-- Left Column Content -->
            <div class="aiero-about-content">
                <span class="aiero-about-tagline">ABOUT US</span>
                <h2 class="aiero-about-title">
                    Built on Strength.<br>Driven by Quality.
                </h2>
                <div class="aiero-about-desc">
                    <p>Founded in 1998 by Vimal Sakariya, Khodiyar Steel Industries began with a clear vision: to
                        manufacture durable, high-quality steel furniture that customers could trust. What started as a
                        small manufacturing operation serving the Indian market has grown into an established metal
                        furniture manufacturer with more than 25 years of industry experience.</p>
                    <p>Today, Khodiyar Steel Industries is a trusted manufacturing partner for distributors, importers,
                        retailers, institutions, and project buyers globally, with a production capacity of up to 10,000
                        metal beds per month.</p>
                </div>
                <div class="aiero-about-phone">
                    <div class="aiero-phone-icon">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>
                    <div class="aiero-phone-details">
                        <span class="aiero-phone-label">Contact Us</span>
                        <a href="tel:9099999266" class="aiero-phone-num">90999 99266</a>
                    </div>
                </div>
            </div>

            <!-- Right Column staggered images -->
            <div class="aiero-about-images">
                <div class="aiero-about-img-wrapper animate-img-left">
                    <div class="aiero-about-img-box aiero-float-left">
                        <img src="assets/metal-bed-7201-01.webp" alt="Premium steel lounge structure design">
                    </div>
                </div>
                <div class="aiero-about-img-wrapper shifted animate-img-right">
                    <div class="aiero-about-img-box aiero-float-right">
                        <img src="assets/origami-bunk-bed-02.webp" alt="Modern sensory bedroom sanctuary space">
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
                <!-- Category 1 -->
                <a href="category-beds" class="aiero-category-card">
                    <div class="aiero-category-card-border"></div>
                    <div class="aiero-category-icon"><i class="fa-solid fa-couch"></i></div>
                    <h3 class="aiero-category-card-title">Metal Beds & Bunks</h3>
                    <p class="aiero-category-card-desc">Heavy-duty elegant single, double, & kids bunk beds engineered
                        for lifetime durability.</p>
                    <span class="aiero-category-link-btn">EXPLORE CATALOG <i
                            class="fa-solid fa-chevron-right"></i></span>
                </a>

                <!-- Category 2 -->
                <a href="category-cupboards" class="aiero-category-card">
                    <div class="aiero-category-card-border"></div>
                    <div class="aiero-category-icon"><svg xmlns="http://www.w3.org/2000/svg"
     width="64"
     height="64"
     viewBox="0 0 64 64"
     fill="none">

    <!-- Cabinet Body -->
    <rect x="14" y="10"
          width="36"
          height="40"
          rx="2"
          stroke="#F9B21D"
          stroke-width="3"/>

    <!-- Base -->
    <line x1="18" y1="50" x2="46" y2="50"
          stroke="#F9B21D"
          stroke-width="3"/>

    <!-- Legs -->
    <line x1="18" y1="50" x2="18" y2="54"
          stroke="#F9B21D"
          stroke-width="3"/>

    <line x1="46" y1="50" x2="46" y2="54"
          stroke="#F9B21D"
          stroke-width="3"/>

    <!-- Divider -->
    <line x1="32" y1="14" x2="32" y2="46"
          stroke="#F9B21D"
          stroke-width="3"/>

    <!-- Left Handle -->
    <line x1="26" y1="24" x2="26" y2="31"
          stroke="#F9B21D"
          stroke-width="3"
          stroke-linecap="round"/>

    <!-- Right Handle -->
    <line x1="38" y1="24" x2="38" y2="31"
          stroke="#F9B21D"
          stroke-width="3"
          stroke-linecap="round"/>
</svg></div>
                    <h3 class="aiero-category-card-title">Steel Cupboards</h3>
                    <p class="aiero-category-card-desc">Secure modular almirahs, wardrobe lockers, and premium dynamic
                        storage cabinets.</p>
                    <span class="aiero-category-link-btn">EXPLORE CATALOG <i
                            class="fa-solid fa-chevron-right"></i></span>
                </a>

                <!-- Category 3 -->
                <a href="category-dining-bathroom" class="aiero-category-card">
                    <div class="aiero-category-card-border"></div>
                    <div class="aiero-category-icon"><i class="fa-solid fa-utensils"></i></div>
                    <h3 class="aiero-category-card-title">Dining & Bathroom</h3>
                    <p class="aiero-category-card-desc">Minimalist, moisture-proof metallic dining sets, washstands, and
                        sleek accessories.</p>
                    <span class="aiero-category-link-btn">EXPLORE CATALOG <i
                            class="fa-solid fa-chevron-right"></i></span>
                </a>

                <!-- Category 4 -->
                <a href="category-doors" class="aiero-category-card">
                    <div class="aiero-category-card-border"></div>
                    <div class="aiero-category-icon"><i class="fa-solid fa-door-closed"></i></div>
                    <h3 class="aiero-category-card-title">Doors &amp; Security Gates</h3>
                    <p class="aiero-category-card-desc">Bespoke heavy-gauge security safety gates, main entry doors, and
                        secure metal frames.</p>
                    <span class="aiero-category-link-btn">EXPLORE CATALOG <i
                            class="fa-solid fa-chevron-right"></i></span>
                </a>

                <!-- Category 5 -->
                <a href="category-hospital" class="aiero-category-card">
                    <div class="aiero-category-card-border"></div>
                    <div class="aiero-category-icon"><i class="fa-solid fa-hospital-user"></i></div>
                    <h3 class="aiero-category-card-title">Hospital Equipment</h3>
                    <p class="aiero-category-card-desc">Standard and semi-fowler clinical ward fowler beds, lockers,
                        stands, and stretchers.</p>
                    <span class="aiero-category-link-btn">EXPLORE CATALOG <i
                            class="fa-solid fa-chevron-right"></i></span>
                </a>

                <!-- Category 6 -->
                <a href="category-outdoor" class="aiero-category-card">
                    <div class="aiero-category-card-border"></div>
                    <div class="aiero-category-icon"><i class="fa-solid fa-umbrella"></i></div>
                    <h3 class="aiero-category-card-title">Outdoor Furniture</h3>
                    <p class="aiero-category-card-desc">Rust-protected all-weather garden gazebos, poolside recliners, and
                        structural outdoor pavilions.</p>
                    <span class="aiero-category-link-btn">EXPLORE CATALOG <i
                            class="fa-solid fa-chevron-right"></i></span>
                </a>
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

                <!-- Card 1 -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-1">
                        <div class="aiero-creation-img" style="background-image: url('assets/images/bad.png');"></div>
                        <div class="aiero-creation-view-more">VIEW MORE</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Metal Bed Frames</span>
                            <p class="aiero-creation-desc">Durable and comfortable steel beds designed for homes,
                                hostels,
                                hospitals, and commercial sectors.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-2">
                        <div class="aiero-creation-img" style="background-image: url('assets/images/hospital-bed.png');"></div>
                        <div class="aiero-creation-view-more">VIEW MORE</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Hospital Beds</span>
                            <p class="aiero-creation-desc">Reliable hospital beds engineered for patient safety and
                                comfort,
                                built with heavy-duty materials.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-3">
                        <div class="aiero-creation-img" style="background-image: url('assets/images/cabinate.png');"></div>
                        <div class="aiero-creation-view-more">VIEW MORE</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Steel Cupboards & Storage Cabinets</span>
                            <p class="aiero-creation-desc">Strong and secure storage solutions built for households,
                                offices, schools, and industrial needs.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-1">
                        <div class="aiero-creation-img" style="background-image: url('assets/images/door.png');"></div>
                        <div class="aiero-creation-view-more">VIEW MORE</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Metal Doors &amp; Security Gates</span>
                            <p class="aiero-creation-desc">Custom metal doors and security gates designed to
                                match
                                specific size, safety, and architectural layout needs.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-2">
                        <div class="aiero-creation-img" style="background-image: url('assets/images/dinning.png');"></div>
                        <div class="aiero-creation-view-more">VIEW MORE</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Dining Sets & Bathroom Furniture</span>
                            <p class="aiero-creation-desc">Functional and elegant modern metal dining sets, stands, and
                                damp-proof bathroom utilities.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-3">
                        <div class="aiero-creation-img" style="background-image: url('assets/images/outdoor.png');"></div>
                        <div class="aiero-creation-view-more">VIEW MORE</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Outdoor Metal Furniture & Structures</span>
                            <p class="aiero-creation-desc">Premium all-weather garden gazebos, poolside recliners, and commercial
                                landscape architectural steel models.</p>
                        </div>
                    </div>
                </div>

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
                <!-- Card 1 -->
                <div class="showcase-card" id="card-1">
                    <div class="card-inner">
                        <!-- Full Background Image -->
                        <div class="card-bg-img" style="background-image: url('assets/metal-bed-7201-01.webp');"></div>
                        <!-- Gradient Overlay for Legibility -->
                        <div class="card-gradient-overlay"></div>

                        <!-- Top-Left Pill Tags -->
                        <div class="card-tags-overlay">
                            <span class="card-pill-tag">RESIDENTIAL</span>
                            <span class="card-pill-tag">VALUE BEDSTEAD</span>
                        </div>

                        <!-- Right Circular Scroll Progress Indicator -->
                        <div class="card-scroll-indicator">
                            <svg class="progress-ring" width="60" height="60">
                                <circle class="progress-ring__circle-bg" stroke="rgba(255, 255, 255, 0.15)"
                                    stroke-width="2" fill="transparent" r="24" cx="30" cy="30" />
                                <circle class="progress-ring__circle" stroke="var(--color-primary)" stroke-width="2"
                                    fill="transparent" r="24" cx="30" cy="30" />
                            </svg>
                            <span class="progress-val">100%</span>
                        </div>

                        <!-- Bottom Content Overlay -->
                        <div class="card-content-overlay">
                            <span class="card-category">VALUE BEDS</span>
                            <h3 class="card-title">Platform Bed</h3>
                            <div class="card-rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-val">4.9 (124 reviews)</span>
                            </div>
                            <p class="card-desc">Water & fire proof design with elegant grooved wood color panels, high-quality emboss outlines, and an adjustable screw-cap leg support grid designed to maximize comfort and structural longevity.</p>
                            <div class="card-footer-row">
                                <div class="card-price"></div>
                                <div class="card-actions">
                                    <a href="contact?product=Platform%20Bed"
                                        class="btn-shop-now">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                                    <a href="product-details?id=bed7201" class="btn-view-details">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="showcase-card" id="card-2">
                    <div class="card-inner">
                        <!-- Full Background Image -->
                        <div class="card-bg-img" style="background-image: url('assets/adjustable-bad2.png');"></div>
                        <!-- Gradient Overlay for Legibility -->
                        <div class="card-gradient-overlay"></div>

                        <!-- Top-Left Pill Tags -->
                        <div class="card-tags-overlay">
                            <span class="card-pill-tag">RESIDENTIAL</span>
                            <span class="card-pill-tag">FOLDING FRAME</span>
                        </div>

                        <!-- Right Circular Scroll Progress Indicator -->
                        <div class="card-scroll-indicator">
                            <svg class="progress-ring" width="60" height="60">
                                <circle class="progress-ring__circle-bg" stroke="rgba(255, 255, 255, 0.15)"
                                    stroke-width="2" fill="transparent" r="24" cx="30" cy="30" />
                                <circle class="progress-ring__circle" stroke="var(--color-primary)" stroke-width="2"
                                    fill="transparent" r="24" cx="30" cy="30" />
                            </svg>
                            <span class="progress-val">0%</span>
                        </div>

                        <!-- Bottom Content Overlay -->
                        <div class="card-content-overlay">
                            <span class="card-category">VALUE BEDS</span>
                            <h3 class="card-title">Adjustable Bed</h3>
                            <div class="card-rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-val">4.8 (95 reviews)</span>
                            </div>
                            <p class="card-desc">Heavy structural steel adjustable folding beds with high durability finishes and multi-level customizable resting positions.</p>
                            <div class="card-footer-row">
                                <div class="card-price"></div>
                                <div class="card-actions">
                                    <a href="contact?product=Adjustable%20Bed"
                                        class="btn-shop-now">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                                    <a href="category-beds" class="btn-view-details">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="showcase-card" id="card-3">
                    <div class="card-inner">
                        <!-- Full Background Image -->
                        <div class="card-bg-img" style="background-image: url('assets/dining.png');"></div>
                        <!-- Gradient Overlay for Legibility -->
                        <div class="card-gradient-overlay"></div>

                        <!-- Top-Left Pill Tags -->
                        <div class="card-tags-overlay">
                            <span class="card-pill-tag">RESIDENTIAL</span>
                            <span class="card-pill-tag">CULINARY SET</span>
                        </div>

                        <!-- Right Circular Scroll Progress Indicator -->
                        <div class="card-scroll-indicator">
                            <svg class="progress-ring" width="60" height="60">
                                <circle class="progress-ring__circle-bg" stroke="rgba(255, 255, 255, 0.15)"
                                    stroke-width="2" fill="transparent" r="24" cx="30" cy="30" />
                                <circle class="progress-ring__circle" stroke="var(--color-primary)" stroke-width="2"
                                    fill="transparent" r="24" cx="30" cy="30" />
                            </svg>
                            <span class="progress-val">0%</span>
                        </div>

                        <!-- Bottom Content Overlay -->
                        <div class="card-content-overlay">
                            <span class="card-category">VALUE DINING</span>
                            <h3 class="card-title">Dining Set</h3>
                            <div class="card-rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-val">5.0 (82 reviews)</span>
                            </div>
                            <p class="card-desc">Elegant steel dining table set pairing mirror-polished tubes with comfortable high-back chairs and durable, heat-resistant overlays.</p>
                            <div class="card-footer-row">
                                <div class="card-price"></div>
                                <div class="card-actions">
                                    <a href="contact?product=Dining%20Set"
                                        class="btn-shop-now">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                                    <a href="product-details?id=dining-set" class="btn-view-details">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                <div class="aiero-gallery-row">
                    <div class="aiero-gallery-track aiero-gallery-track--top">
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/metal-bed-7201-01.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Luxury
                                    Bedstead</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--sm">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/fire-safety-door-03.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Steel
                                    Doors</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--md">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/icu-fowler-bed-01.webp');"></div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Hospital
                                    Suite</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/household-wardrobe-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Cupboard
                                    System</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--sm">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/garden-steel-gazebo-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Outdoor
                                    Structure</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--md">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/dining-set-ds301-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Dining
                                    Set</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/metal-bed-7201-01.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Luxury
                                    Bedstead</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--sm">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/fire-safety-door-03.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Steel
                                    Doors</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--md">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/icu-fowler-bed-01.webp');"></div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Hospital
                                    Suite</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/household-wardrobe-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Cupboard
                                    System</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--sm">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/garden-steel-gazebo-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Outdoor
                                    Structure</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--md">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/dining-set-ds301-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Dining
                                    Set</span></div>
                        </div>
                    </div>
                </div>
                <div class="aiero-gallery-row">
                    <div class="aiero-gallery-track aiero-gallery-track--bottom">
                        <div class="aiero-gallery-card aiero-gallery-card--md">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/household-wardrobe-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Cupboard
                                    System</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/icu-fowler-bed-01.webp');"></div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Hospital
                                    Suite</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--sm">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/garden-steel-gazebo-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Outdoor
                                    Structure</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/dining-set-ds301-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Dining
                                    Set</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--sm">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/metal-bed-7201-01.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Luxury
                                    Bedstead</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--md">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/fire-safety-door-03.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Steel
                                    Doors</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--md">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/household-wardrobe-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Cupboard
                                    System</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/icu-fowler-bed-01.webp');"></div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Hospital
                                    Suite</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--sm">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/garden-steel-gazebo-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Outdoor
                                    Structure</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--lg">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/dining-set-ds301-02.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Dining
                                    Set</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--sm">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/metal-bed-7201-01.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Luxury
                                    Bedstead</span></div>
                        </div>
                        <div class="aiero-gallery-card aiero-gallery-card--md">
                            <div class="aiero-gallery-card-img" style="background-image: url('assets/fire-safety-door-03.webp');">
                            </div>
                            <div class="aiero-gallery-card-overlay"><span class="aiero-gallery-card-label">Steel
                                    Doors</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Unique Pro "Extra Services" Section -->
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
                <span class="aiero-services-subtitle">UTILITY RANGE</span>
                <h2 class="aiero-services-title">Bathroom & Utility Metal Products</h2>
                <div class="aiero-services-desc">
                    <p>A focused development catalogue for bathroom racks, towel hangers, luggage trolleys, bedside
                        tables, and clothes racks manufactured by Khodiyar Steel Industries.</p>
                    <p>Designed for bulk buyers, hotel projects, bathroom brands, furniture distributors, and
                        OEM/private-label supply.</p>
                </div>
                <div style="margin-bottom: 2rem;">
                    <a href="ksi/Khodiyar_Bathroom_Utility_Metal_Products_Catalogue.pdf" download
                        class="aiero-btn-capsule" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-file-pdf"></i> Download Catalogue
                    </a>
                </div>
                <div class="aiero-services-contact-container"
                    style="display: flex; flex-direction: column; gap: 1.2rem;">
                    <!-- Contact 1: Mr. Vimalbhai Sakariya -->
                    <div class="aiero-services-contact">
                        <div class="aiero-services-contact-icon">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="aiero-services-contact-details">
                            <span class="aiero-services-contact-label">Mr. Manthan Sakariya (CEO)</span>
                            <a href="tel:+917359840800" class="aiero-services-contact-num">+91 73598 40800</a>
                            <span class="aiero-services-contact-label"
                                style="display: block; font-size: 0.75rem; opacity: 0.8; margin-top: 0.1rem; text-transform: lowercase;">info@khodiyarsteel.com</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Liquid Parallax Depth Slider -->
            <div class="aiero-services-slider-col">
                <div class="aiero-services-slider-wrapper">
                    <div class="aiero-services-slider-track">
                        <!-- Card 1: Bathroom Rack (BR-01) -->
                        <div class="aiero-service-card">
                            <div class="aiero-service-card-img-wrap">
                                <div class="aiero-service-card-img"
                                    style="background-image: url('assets/service_br01.png');">
                                </div>
                            </div>
                            <div class="aiero-service-card-content">
                                <h3 class="aiero-service-card-title">Bathroom Rack</h3>
                                <div class="aiero-service-card-price-row">
                                    <span class="aiero-service-card-price">BR-01</span>
                                    <span class="aiero-service-card-period">/ Utility Storage</span>
                                </div>
                                <ul class="aiero-service-card-specs">
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Wall-mounted & free-standing formats</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Mild steel or stainless steel tube</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Powder-coated & chrome-look finishes</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>KD or semi-KD export packing</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Card 2: Bathroom Towel Hanger (TH-01) -->
                        <div class="aiero-service-card">
                            <div class="aiero-service-card-img-wrap">
                                <div class="aiero-service-card-img"
                                    style="background-image: url('assets/service_th01.png');">
                                </div>
                            </div>
                            <div class="aiero-service-card-content">
                                <h3 class="aiero-service-card-title">Towel Hanger</h3>
                                <div class="aiero-service-card-price-row">
                                    <span class="aiero-service-card-price">TH-01</span>
                                    <span class="aiero-service-card-period">/ Accessories</span>
                                </div>
                                <ul class="aiero-service-card-specs">
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Bars, rails, hooks & ladder formats</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Tube, rod & pressed plate build</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Concealed or bracket-mounted</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Sanitaryware & hotel spec options</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Card 3: Luggage Trolley (LT-01) -->
                        <div class="aiero-service-card">
                            <div class="aiero-service-card-img-wrap">
                                <div class="aiero-service-card-img"
                                    style="background-image: url('assets/service_lt01.png');">
                                </div>
                            </div>
                            <div class="aiero-service-card-content">
                                <h3 class="aiero-service-card-title">Luggage Trolley</h3>
                                <div class="aiero-service-card-price-row">
                                    <span class="aiero-service-card-price">LT-01</span>
                                    <span class="aiero-service-card-period">/ Hospitality</span>
                                </div>
                                <ul class="aiero-service-card-specs">
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Arched tubular steel/stainless frame</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Carpeted or rubber platform</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Heavy-duty casters with brakes</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Knock-down design for shipping</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Card 4: Bed Side Table (BST-01) -->
                        <div class="aiero-service-card">
                            <div class="aiero-service-card-img-wrap">
                                <div class="aiero-service-card-img"
                                    style="background-image: url('assets/service_bst01.png');">
                                </div>
                            </div>
                            <div class="aiero-service-card-content">
                                <h3 class="aiero-service-card-title">Bed Side Table</h3>
                                <div class="aiero-service-card-price-row">
                                    <span class="aiero-service-card-price">BST-01</span>
                                    <span class="aiero-service-card-period">/ Bedroom</span>
                                </div>
                                <ul class="aiero-service-card-specs">
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Steel tube frame with wood/glass tops</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Open shelf, drawer or cabinet setup</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Adjustable feet, casters or locks</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Hostel, home & project bedroom fit</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Card 5: Clothes Rack (CR-01) -->
                        <div class="aiero-service-card">
                            <div class="aiero-service-card-img-wrap">
                                <div class="aiero-service-card-img"
                                    style="background-image: url('assets/service_cr01.png');">
                                </div>
                            </div>
                            <div class="aiero-service-card-content">
                                <h3 class="aiero-service-card-title">Clothes Rack</h3>
                                <div class="aiero-service-card-price-row">
                                    <span class="aiero-service-card-price">CR-01</span>
                                    <span class="aiero-service-card-period">/ Garment Rail</span>
                                </div>
                                <ul class="aiero-service-card-specs">
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Welded or bolt-together frame build</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Single/double rail with shoe shelf</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Load-rated rail for commercial use</span>
                                    </li>
                                    <li class="aiero-service-card-spec-item check"><i class="fa-solid fa-check"></i>
                                        <span>Flat-pack export packing available</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
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

            <div class="aiero-faq-item">
                <button class="aiero-faq-trigger" aria-expanded="false">
                    <span class="aiero-faq-question">What structural raw materials does Khodiyar Steel utilize?</span>
                    <i class="fa-solid fa-chevron-down aiero-faq-icon"></i>
                </button>
                <div class="aiero-faq-panel">
                    <div class="aiero-faq-content">
                        We utilize premium-grade structural steel, high-gauge carbon steel pipes, and durable stainless
                        steel sections. Every piece of raw metal undergoes strict anti-rust treatments, phosphating
                        chemical cleaning, and is finished with industrial-grade powder coating to guarantee load
                        resistance and rust prevention.
                    </div>
                </div>
            </div>

            <div class="aiero-faq-item">
                <button class="aiero-faq-trigger" aria-expanded="false">
                    <span class="aiero-faq-question">Can I submit custom blueprint layouts for fabrication?</span>
                    <i class="fa-solid fa-chevron-down aiero-faq-icon"></i>
                </button>
                <div class="aiero-faq-panel">
                    <div class="aiero-faq-content">
                        Absolutely. Precision custom structural fabrication is one of our primary specialties. Our
                        engineering department accepts custom CAD blueprints, dimension sheets, or sketches for fire
                        doors, safety gates, outdoor gazebos, and bespoke residential furniture designs.
                    </div>
                </div>
            </div>

            <div class="aiero-faq-item">
                <button class="aiero-faq-trigger" aria-expanded="false">
                    <span class="aiero-faq-question">What is the turnaround time for bulk or custom orders?</span>
                    <i class="fa-solid fa-chevron-down aiero-faq-icon"></i>
                </button>
                <div class="aiero-faq-panel">
                    <div class="aiero-faq-content">
                        Turnaround times depend on the complexity and scale of the fabrication. Standard catalog orders
                        (such as wardrobes, hospital lockers, or single beds) are processed immediately. Large-scale
                        structural or bulk institutional orders typically range from 2 to 4 weeks, with clear timelines
                        provided during the blueprint finalization stage.
                    </div>
                </div>
            </div>
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
            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
