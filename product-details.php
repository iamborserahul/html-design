<?php
$title = "Product Details | Khodiyar Steel";
$description = "View exhaustive dimensional plans, material grades, assembly instructions, and technical specifications for our precision steel products.";
$page = "products";
include 'header.php';

// Get product slug
$slug = $_GET['id'] ?? 'bed7201';

$product = null;
$images = [];
$specs = [];
$features = [];
$related = [];

try {
    $db = getDB();
    // 1. Fetch product
    $stmt = $db->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN product_categories c ON p.category_id = c.id WHERE p.slug = ? AND p.status = 1");
    $stmt->execute([$slug]);
    $product = $stmt->fetch();
    
    if ($product) {
        $pid = $product['id'];
        // 2. Fetch images
        $stmt_img = $db->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC");
        $stmt_img->execute([$pid]);
        $images = $stmt_img->fetchAll();
        
        // 3. Fetch specs
        $stmt_spec = $db->prepare("SELECT * FROM product_specs WHERE product_id = ? ORDER BY sort_order ASC");
        $stmt_spec->execute([$pid]);
        $specs = $stmt_spec->fetchAll();
        
        // 4. Fetch features
        $stmt_feat = $db->prepare("SELECT * FROM product_features WHERE product_id = ? ORDER BY sort_order ASC");
        $stmt_feat->execute([$pid]);
        $features = $stmt_feat->fetchAll();
        
        // Fetch related products (siblings from same category)
        $stmt_rel = $db->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? AND status = 1 LIMIT 3");
        $stmt_rel->execute([$product['category_id'], $pid]);
        $related = $stmt_rel->fetchAll();
    }
} catch (Exception $e) {
    // Fallback
}

if (!$product) {
    echo "<div class='container' style='padding: 8rem 8%; text-align: center;'><h2>Product not found.</h2><br><a href='products' class='aiero-btn-discover' style='display: inline-flex; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25); color: #000;'>Back to Products</a></div>";
    include 'footer.php';
    exit;
}

$title = $product['name'] . " | Khodiyar Steel";
?>

<!-- Subpage Hero Section (Compact) -->
    <section class="aiero-hero subpage-hero" style="height: 45vh; min-height: 300px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <ul class="aiero-breadcrumbs" id="details-breadcrumbs">
                <li class="aiero-breadcrumb-item"><a href="./">Home</a></li>
                <li class="aiero-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></li>
                <li class="aiero-breadcrumb-item"><a href="products">Products</a></li>
                <li class="aiero-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></li>
                <li class="aiero-breadcrumb-item active"><?= htmlspecialchars($product['name']) ?></li>
            </ul>
            <h1 class="aiero-slide-title" id="details-hero-title" style="transform: none; opacity: 1; font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 0.5rem;"><?= htmlspecialchars($product['name']) ?></h1>
            <p class="aiero-slide-desc" id="details-hero-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto; font-size: 0.95rem;">Exhaustive structural plans, dimensional limits, and engineering specifications directly transcribed from our official catalogs.</p>
        </div>
    </section>

    <!-- Dynamic Product Details Section -->
    <section class="aiero-about" style="padding: 4rem 8% 6rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-about-container aiero-details-grid">
            
            <!-- Left Side: Interactive Image Gallery -->
            <div class="aiero-details-gallery">
                <div class="aiero-gallery-main">
                    <img id="details-main-img" src="uploads/<?= htmlspecialchars($product['featured_image']) ?>" alt="Selected model preview">
                </div>
                <div class="aiero-gallery-thumbs" id="details-thumbs-row">
                    <?php foreach ($images as $idx => $img): ?>
                        <div class="aiero-gallery-thumb <?= $idx === 0 ? 'active' : '' ?>" data-src="uploads/<?= htmlspecialchars($img['image']) ?>">
                            <img src="uploads/<?= htmlspecialchars($img['image']) ?>" alt="<?= htmlspecialchars($img['alt_text'] ?? 'Preview') ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right Side: Model Specifications & Highlights -->
            <div class="aiero-about-content" style="gap: 1.5rem;">
                <span class="aiero-about-tagline" id="details-category-tagline" style="color: #FFC229;"><?= htmlspecialchars(strtoupper($product['category_name'] ?? 'Products')) ?></span>
                <h2 class="aiero-about-title" id="details-product-title" style="font-size: clamp(2rem, 3.2vw, 2.6rem); line-height: 1.25; margin-bottom: 0.5rem;"><?= htmlspecialchars($product['name']) ?></h2>
                
                <p id="details-short-desc" style="opacity: 0.7; font-size: 1.02rem; line-height: 1.8;"><?= htmlspecialchars($product['short_description']) ?></p>
                
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.25rem; color: var(--color-text); margin-top: 1rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 0.5rem;"><i class="fa-solid fa-list-check" style="color:#FFC229; margin-right:0.6rem;"></i>Technical Specifications</h3>
                
                <table class="aiero-spec-table">
                    <tbody id="details-spec-body">
                        <?php foreach ($specs as $spec): ?>
                            <tr>
                                <th><?= htmlspecialchars($spec['label']) ?></th>
                                <td><?= htmlspecialchars($spec['value']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Interactive Tab Panels -->
                <div class="aiero-tabs">
                    <div class="aiero-tabs-headers">
                        <button class="aiero-tab-header active" data-tab="tab-desc">Features</button>
                        <button class="aiero-tab-header" data-tab="tab-engineering">Engineering</button>
                        <button class="aiero-tab-header" data-tab="tab-custom">Custom Sizing</button>
                    </div>
                    
                    <div class="aiero-tab-panel active" id="tab-desc">
                        <ul id="details-features-list" style="list-style: none; display: flex; flex-direction: column; gap: 0.8rem;">
                            <?php foreach ($features as $feat): ?>
                                <li style="display: flex; gap: 0.8rem; align-items: flex-start;">
                                    <i class="fa-solid fa-circle-check" style="color: #FFC229; margin-top: 0.2rem; font-size: 0.9rem;"></i>
                                    <span><?= htmlspecialchars($feat['feature']) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="aiero-tab-panel" id="tab-engineering">
                        <p id="details-eng-info" style="opacity: 0.8; font-size: 0.95rem; line-height: 1.7;">All joints are joined via seamless carbon dioxide welding grids, ensuring standard structural integrity and a perfect load limit. Surface coatings use standard industrial pre-treatments, acid cleaning, phosphating, and oven-baked polyester powder coating.</p>
                    </div>
                    
                    <div class="aiero-tab-panel" id="tab-custom">
                        <p id="details-custom-info" style="opacity: 0.8; font-size: 0.95rem; line-height: 1.7;">Custom dimensional width parameters, height setups, and alternative coloring sheets (such as standard chocolate, charcoal, metallic grey, gold, and white) can be requested during quotation.</p>
                    </div>
                </div>

                <!-- Call to Actions -->
                <div style="display: flex; gap: 1.5rem; margin-top: 2.2rem; width: 100%;">
                    <a href="contact?product=<?= urlencode($product['name']) ?>" id="details-inquire-btn" class="aiero-btn-discover" style="transform: none; opacity: 1; margin: 0; flex: 1.2; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25);">
                        <i class="fa-solid fa-paper-plane"></i> Submit Inquiry Quote
                    </a>
                </div>
            </div>
            
        </div>
    </section>

    <!-- Related Products Carousel -->
    <section class="aiero-creations" id="related-products" style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 7rem;">
        <div class="aiero-creations-container">
            <div class="aiero-creations-header">
                <span class="aiero-creations-tagline">ALTERNATIVE SELECTIONS</span>
                <h2 class="aiero-creations-title" style="font-size: 34px;">Related Products</h2>
            </div>
            
            <div class="aiero-creations-grid" id="details-related-grid">
                <?php if (!empty($related)): ?>
                    <?php foreach ($related as $i => $rel): ?>
                        <?php $float_class = 'card-float-' . (($i % 3) + 1); ?>
                        <div class="aiero-creation-card-wrapper">
                            <a href="product-details?id=<?= htmlspecialchars($rel['slug']) ?>" class="aiero-creation-card <?= $float_class ?>" style="display: block; height: 380px;">
                                <div class="aiero-creation-img" style="background-image: url('uploads/<?= htmlspecialchars($rel['featured_image']) ?>');"></div>
                                <div class="aiero-creation-view-more">VIEW DETAILS</div>
                                <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                                    <span class="aiero-creation-label" style="font-size: 1.15rem;"><?= htmlspecialchars($rel['name']) ?></span>
                                    <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;"><?= htmlspecialchars($rel['short_description']) ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
