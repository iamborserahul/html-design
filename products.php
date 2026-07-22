<?php
$title = "Our Product Categories | Khodiyar Steel";
$description = "Explore our extensive industrial range of metal beds, hospital equip, cupboards, modular almirahs, dining sets, safety doors, and outdoor steel structures.";
$page = "products";
include 'header.php';

$categories = [];
try {
    $db = getDB();
    $categories = $db->query("SELECT * FROM product_categories WHERE status = 1 ORDER BY sort_order ASC, name ASC")->fetchAll();
} catch (Exception $e) {}
?>

<!-- Subpage Hero Section -->
    <section class="aiero-hero subpage-hero" style="height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline">PRODUCT PORTFOLIO</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1;">Our Product Categories</h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto;">Discover our specialized production lines engineered for ultimate durability, load strength, and premium architectural utility.</p>
        </div>
    </section>

    <!-- Categories Grid Section -->
    <section class="aiero-creations" id="categories" style="padding: 6rem 8% 8rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-creations-container">
            <div class="aiero-creations-grid">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $i => $cat): ?>
                    <?php 
                    $float_class = 'card-float-' . (($i % 3) + 1); 
                    // Fetch category image or default fallback
                    $cat_image = '';
                    if (!empty($cat['image']) && file_exists(__DIR__ . '/uploads/categories/' . $cat['image'])) {
                        $cat_image = 'uploads/categories/' . $cat['image'];
                    } else {
                        // Find first product of this category
                        $stmt_first = $db->prepare("SELECT featured_image FROM products WHERE category_id = ? AND status = 1 LIMIT 1");
                        $stmt_first->execute([$cat['id']]);
                        $first_prod = $stmt_first->fetch();
                        if (!empty($first_prod['featured_image'])) {
                            $img_src = $first_prod['featured_image'];
                            if (strpos($img_src, 'assets/') === 0) {
                                $cat_image = $img_src;
                            } else {
                                $cat_image = 'uploads/' . $img_src;
                            }
                        } else {
                            $cat_image = 'assets/metal-bed-7201-01.webp';
                        }
                    }
                    ?>
                    <div class="aiero-creation-card-wrapper">
                        <a href="category/<?= htmlspecialchars($cat['slug']) ?>" class="aiero-creation-card <?= $float_class ?>" style="display: block;">
                            <div class="aiero-creation-img" style="background-image: url('<?= htmlspecialchars($cat_image) ?>');"></div>
                            <div class="aiero-creation-view-more">ENTER</div>
                            <div class="aiero-creation-content">
                                <span class="aiero-creation-label"><?= htmlspecialchars($cat['name']) ?></span>
                                <p class="aiero-creation-desc"><?= htmlspecialchars($cat['description']) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback if empty -->
                <p style="opacity: 0.6; text-align: center; width: 100%;">No categories found.</p>
            <?php endif; ?>

            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
