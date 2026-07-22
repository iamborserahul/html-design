<?php
$title = "Category Products | Khodiyar Steel";
$description = "Browse our high-quality structural steel products and custom modular solutions manufactured by Khodiyar Steel.";
$page = "products";
include 'header.php';

$id = $_GET['id'] ?? '';
$category = null;
$products = [];

try {
    $db = getDB();
    // Fetch category by ID or slug
    $stmt = $db->prepare("SELECT * FROM product_categories WHERE (slug = ? OR id = ?) AND status = 1");
    $stmt->execute([$id, $id]);
    $category = $stmt->fetch();
    
    if ($category) {
        // Fetch category products
        $stmt_prod = $db->prepare("SELECT * FROM products WHERE category_id = ? AND status = 1 ORDER BY sort_order ASC, id DESC");
        $stmt_prod->execute([$category['id']]);
        $products = $stmt_prod->fetchAll();
    }
} catch (Exception $e) {
    // Fallback
}

if (!$category) {
    echo "<div class='container' style='padding: 8rem 8%; text-align: center;'><h2>Category not found.</h2><br><a href='products' class='aiero-btn-discover' style='display: inline-flex; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25); color: #000;'>Back to Categories</a></div>";
    include 'footer.php';
    exit;
}

$title = $category['name'] . " | Khodiyar Steel";

// Determine hero image
$cat_image = '';
if (!empty($category['image']) && file_exists(__DIR__ . '/uploads/categories/' . $category['image'])) {
    $cat_image = 'uploads/categories/' . $category['image'];
} elseif (!empty($products[0]['featured_image'])) {
    $img_src = $products[0]['featured_image'];
    if (strpos($img_src, 'assets/') === 0) {
        $cat_image = $img_src;
    } else {
        $cat_image = 'uploads/' . $img_src;
    }
} else {
    $cat_image = 'assets/metal-bed-7201-01.webp';
}

// Fetch dynamic brochures from database
$pdf_brochures = [];
try {
    $stmt_brochures = $db->prepare("SELECT name, file_path as path, bg_color as bg FROM category_brochures WHERE category_id = ? ORDER BY sort_order ASC, id ASC");
    $stmt_brochures->execute([$category['id']]);
    $db_brochures = $stmt_brochures->fetchAll();
    
    foreach ($db_brochures as $b) {
        $pdf_brochures[] = [
            'name' => $b['name'],
            'path' => 'uploads/brochures/' . $b['path'],
            'bg' => $b['bg'],
            'shadow' => 'rgba(0,0,0,0.2)' // Default fallback shadow
        ];
    }
} catch (Exception $e) {
    // Silent fallback
}
?>

<!-- Subpage Hero Section -->
    <section class="aiero-hero subpage-hero" style="height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline">CATEGORY PROFILE</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1;"><?= htmlspecialchars($category['name']) ?></h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto;"><?= htmlspecialchars($category['description']) ?></p>
        </div>
    </section>

    <!-- Category Highlight details -->
    <section class="aiero-about" style="padding: 6rem 8% 4rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-about-container" style="grid-template-columns: 1fr 1fr; gap: 5rem;">
            <div class="aiero-about-content">
                <span class="aiero-about-tagline" style="color: #FFC229;">PRODUCT FEATURES</span>
                <h2 class="aiero-about-title" style="font-size: 36px;">Premium <?= htmlspecialchars($category['name']) ?></h2>
                <p style="opacity: 0.7; font-size: 1.02rem; line-height: 1.8;">Our dynamic production line utilizes high-grade materials, advanced fabrication standards, anti-corrosion treatments, and precision welding layouts built to support lifetime structural resilience.</p>

                <h3 style="font-family: 'Cinzel', serif; font-size: 1.4rem; color: var(--color-text); margin-top: 1.5rem;">Core Design Values:</h3>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-shield-halved" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Heavy-Duty Builds</strong>: Structured reinforcement layouts designed to withstand high loading limits.</span>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-compass-drafting" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Tailored Configurations</strong>: Modifiable sizing limits, custom paneling boards, and multiple baked powder color shades.</span>
                    </li>
                </ul>
            </div>

            <!-- Category Image Panel -->
            <div style="border-radius: 20px; overflow: hidden; min-height: 400px; background: url('<?= $cat_image ?>') center center / cover no-repeat; border: 1px solid rgba(255,255,255,0.06);"></div>
        </div>
    </section>

    <!-- Product Catalog Grid -->
    <section class="aiero-creations" id="products-list" style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 7rem;">
        <div class="aiero-creations-container">
            <div class="aiero-creations-header">
                <span class="aiero-creations-tagline">CATALOG SELECTIONS</span>
                <h2 class="aiero-creations-title" style="font-size: 34px;"><?= htmlspecialchars($category['name']) ?> Models</h2>
            </div>

            <div class="aiero-creations-grid">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $i => $prod): ?>
                        <?php 
                        $float_class = 'card-float-' . (($i % 3) + 1); 
                        $prod_img = $prod['featured_image'];
                        if (strpos($prod_img, 'assets/') !== 0) {
                            $prod_img = 'uploads/' . $prod_img;
                        }
                        ?>
                        <div class="aiero-creation-card-wrapper">
                            <a href="product/<?= htmlspecialchars($prod['slug']) ?>" class="aiero-creation-card <?= $float_class ?>" style="display: block; height: 380px;">
                                <div class="aiero-creation-img" style="background-image: url('<?= htmlspecialchars($prod_img) ?>');"></div>
                                <div class="aiero-creation-view-more">VIEW DETAILS</div>
                                <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                                    <span class="aiero-creation-label" style="font-size: 1.15rem;"><?= htmlspecialchars($prod['name']) ?></span>
                                    <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;"><?= htmlspecialchars($prod['short_description']) ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="opacity: 0.6; text-align: center; width: 100%;">No products found in this category.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Download Catalogues Section -->
    <?php if (!empty($pdf_brochures)): ?>
    <section class="aiero-about" style="padding: 4rem 8% 6rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div style="display: flex; justify-content: center;">
            <div class="aiero-about-content" style="justify-content: center; gap: 2rem; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); padding: 3rem; border-radius: 20px; text-align: center; align-items: center; max-width: 500px;">
                <i class="fa-solid fa-file-pdf" style="font-size: 4rem; color: #ff3333; filter: drop-shadow(0 0 15px rgba(255,51,51,0.2));"></i>
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.8rem; color: var(--color-text);">Download Catalogues</h3>
                <p style="opacity: 0.6; font-size: 0.92rem; line-height: 1.6; max-width: 320px;">Download our official specification catalogs containing structural designs, models, colors, and layout dimensions.</p>
                <div style="display: flex; flex-direction: column; gap: 1.2rem; width: 100%; max-width: 340px;">
                    <?php foreach ($pdf_brochures as $pdf): ?>
                        <a href="<?= htmlspecialchars($pdf['path']) ?>" download class="aiero-btn-discover" style="transform: none; opacity: 1; margin: 0 auto; width: 100%; justify-content: center; background: <?= $pdf['bg'] ?>; box-shadow: 0 10px 20px <?= $pdf['shadow'] ?>;">
                            <i class="fa-solid fa-download"></i> <?= htmlspecialchars($pdf['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

<?php
include 'footer.php';
?>
