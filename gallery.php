<?php
$title = "Product Gallery | Khodiyar Steel";
$description = "View high-resolution product photos of modular wardrobes, ICU hospital beds, poolside recliners, safety gates, and landscape gazebos manufactured by Khodiyar Steel.";
$page = "gallery";
include 'header.php';

$categories = [];
$gallery_by_cat = [];
try {
    $db = getDB();
    $categories = $db->query("SELECT * FROM product_categories WHERE status = 1 ORDER BY sort_order ASC, name ASC")->fetchAll();
    
    $gallery_items = $db->query("SELECT * FROM gallery_items WHERE status = 1 ORDER BY sort_order ASC, id DESC")->fetchAll();
    foreach ($gallery_items as $item) {
        $gallery_by_cat[$item['category']][] = $item;
    }
} catch (Exception $e) {
    // Fallback
}
?>

<!-- Subpage Hero Section -->
    <section class="aiero-hero subpage-hero" style="height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline">VISUAL ARCHIVE</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1;">Product Gallery</h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto;">Browse through our high-end steel furniture, custom security gates, ICU modular hospital beds, and modern almirahs.</p>
        </div>
    </section>

    <section class="aiero-creations" style="padding: 6rem 8% 4rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $cat): ?>
            <?php 
            $cat_items = $gallery_by_cat[$cat['name']] ?? []; 
            if (empty($cat_items)) continue;
            ?>
            <div style="margin-bottom: 5rem;">
                <div style="display: flex; flex-direction: column; gap: 0.6rem; margin-bottom: 3rem; padding-left: 0.5rem; border-left: 3px solid #FFC229;">
                    <span class="aiero-creations-tagline">CATEGORY</span>
                    <h2 class="aiero-creations-title" style="font-size: 32px;"><?= htmlspecialchars($cat['name']) ?></h2>
                </div>
                <div class="aiero-creations-grid">
                    <?php foreach ($cat_items as $i => $item): ?>
                        <?php $float_class = 'card-float-' . (($i % 3) + 1); ?>
                        <div class="aiero-creation-card-wrapper">
                            <div class="aiero-creation-card <?= $float_class ?>" style="display: block; height: 380px; position: relative; border-radius: 16px; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.05); transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s ease;">
                                <div class="aiero-creation-img" style="background-image: url('uploads/gallery/<?= htmlspecialchars($item['image']) ?>'); width: 100%; height: 100%; background-size: cover; background-position: center; transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);"></div>
                                <div class="aiero-creation-content" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%); padding: 2rem; display: flex; flex-direction: column; justify-content: flex-end; height: 60%; pointer-events: none; z-index: 2;">
                                    <span class="aiero-creation-label" style="font-family: 'Cinzel', serif; font-size: 1.15rem; color: #fff; text-transform: uppercase; font-weight: 500; letter-spacing: 1px; display: block; margin-bottom: 0.4rem; text-shadow: 0 2px 4px rgba(0,0,0,0.5);"><?= htmlspecialchars($item['title']) ?></span>
                                    <p class="aiero-creation-desc" style="font-size: 0.85rem; color: rgba(255,255,255,0.7); line-height: 1.5; margin: 0; text-shadow: 0 1px 2px rgba(0,0,0,0.5);"><?= htmlspecialchars($item['description'] ?? '') ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="text-align: center; color: var(--text-dim); padding: 4rem 0;">
            <p>No gallery items available at the moment.</p>
        </div>
    <?php endif; ?>
    </section>

<?php
include 'footer.php';
?>
