<?php
$current_page = 'products';
$page_title = 'Product Form';
require_once __DIR__ . '/includes/header.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$is_edit = $id > 0;
$product = null;
$errors = [];

if ($is_edit) {
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    if (!$product) {
        header('Location: products.php?msg=' . urlencode('Product not found.') . '&type=error');
        exit;
    }
}

$categories = $db->query("SELECT id, name FROM product_categories WHERE status = 1 ORDER BY sort_order ASC, name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf($token)) {
        $errors[] = 'Invalid security token. Please try again.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $category_id = $_POST['category_id'] ? (int) $_POST['category_id'] : null;
        $short_description = trim($_POST['short_description'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = $_POST['price'] !== '' ? (float) $_POST['price'] : null;
        $sale_price = $_POST['sale_price'] !== '' ? (float) $_POST['sale_price'] : null;
        $sku = trim($_POST['sku'] ?? '');
        $unit = trim($_POST['unit'] ?? '');
        $stock = (int) ($_POST['stock'] ?? 0);
        $status = isset($_POST['status']) ? 1 : 0;
        $featured = isset($_POST['featured']) ? 1 : 0;
        $meta_title = trim($_POST['meta_title'] ?? '');
        $meta_description = trim($_POST['meta_description'] ?? '');
        $meta_keywords = trim($_POST['meta_keywords'] ?? '');
        $sort_order = (int) ($_POST['sort_order'] ?? 0);

        if (empty($name)) $errors[] = 'Product name is required.';
        if (empty($slug)) $slug = strtolower(trim(preg_replace('/[^a-z0-9-]+/', '-', $name), '-'));

        $existing = $db->prepare("SELECT id FROM products WHERE slug = ?" . ($is_edit ? " AND id != ?" : ""));
        if ($is_edit) {
            $existing->execute([$slug, $id]);
        } else {
            $existing->execute([$slug]);
        }
        if ($existing->fetch()) $errors[] = 'A product with this slug already exists.';

        if (empty($errors)) {
            $featured_image = $product['featured_image'] ?? null;
            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                $uploaded = upload_image($_FILES['featured_image'], __DIR__ . '/uploads/');
                if ($uploaded) {
                    if ($featured_image) delete_image($featured_image, __DIR__ . '/uploads/');
                    $featured_image = $uploaded;
                } else {
                    $errors[] = 'Failed to upload image. Allowed: jpg, jpeg, png, gif, webp, svg.';
                }
            }

            if (empty($errors)) {
                if ($is_edit) {
                    $stmt = $db->prepare("UPDATE products SET category_id=?, name=?, slug=?, short_description=?, description=?, price=?, sale_price=?, sku=?, unit=?, stock=?, featured_image=?, status=?, featured=?, meta_title=?, meta_description=?, meta_keywords=?, sort_order=?, updated_at=NOW() WHERE id=?");
                    $stmt->execute([$category_id, $name, $slug, $short_description, $description, $price, $sale_price, $sku, $unit, $stock, $featured_image, $status, $featured, $meta_title, $meta_description, $meta_keywords, $sort_order, $id]);
                    header('Location: product-form.php?id=' . $id . '&msg=' . urlencode('Product updated successfully.') . '&type=success');
                    exit;
                } else {
                    $stmt = $db->prepare("INSERT INTO products (category_id, name, slug, short_description, description, price, sale_price, sku, unit, stock, featured_image, status, featured, meta_title, meta_description, meta_keywords, sort_order, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())");
                    $stmt->execute([$category_id, $name, $slug, $short_description, $description, $price, $sale_price, $sku, $unit, $stock, $featured_image, $status, $featured, $meta_title, $meta_description, $meta_keywords, $sort_order]);
                    $new_id = (int) $db->lastInsertId();
                    header('Location: product-images.php?id=' . $new_id . '&msg=' . urlencode('Product created. Now add images, specs & features.') . '&type=success');
                    exit;
                }
            }
        }
    }
}
?>

<style>
    .product-form-wrap { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
    .product-form-wrap .full-width { grid-column: 1 / -1; }
    @media (max-width: 768px) { .product-form-wrap { grid-template-columns: 1fr; } }
    .meta-section { margin-top: 1.5rem; }
    .meta-toggle { cursor: pointer; user-select: none; display: inline-flex; align-items: center; gap: 0.5rem; color: var(--accent); font-size: 0.85rem; }
    .meta-toggle i { transition: transform 0.3s; }
    .meta-toggle.open i { transform: rotate(180deg); }
    .meta-body { display: none; margin-top: 1rem; }
    .meta-body.open { display: block; }
    .img-preview-wrap { margin-top: 0.5rem; }
    .img-preview-wrap img { width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border); }
    .img-preview-wrap .no-img { width: 120px; height: 120px; border-radius: 8px; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-dim); font-size: 2rem; }
    .product-tabs { margin-bottom: 1.5rem; }
    .tab-error { background: var(--danger-bg); border: 1px solid rgba(239,68,68,0.25); border-radius: 8px; padding: 0.75rem 1rem; color: var(--danger); font-size: 0.85rem; margin-bottom: 1rem; }
    .tab-error i { margin-right: 0.4rem; }
</style>

<?php if ($is_edit): ?>
    <div class="tabs product-tabs">
        <a href="product-form.php?id=<?= $id ?>" class="tab-item active">Basic Info</a>
        <a href="product-images.php?id=<?= $id ?>" class="tab-item">Images</a>
        <a href="product-specs.php?id=<?= $id ?>" class="tab-item">Specifications</a>
        <a href="product-features.php?id=<?= $id ?>" class="tab-item">Features</a>
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="tab-error"><i class="fas fa-exclamation-circle"></i> <?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $id ?>">

    <div class="product-form-wrap">
        <div class="glass-card">
            <div class="form-group">
                <label class="form-label">Product Name <span class="required">*</span></label>
                <input type="text" name="name" class="form-control" id="productName" value="<?= htmlspecialchars($product['name'] ?? $_POST['name'] ?? '') ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" id="productSlug" value="<?= htmlspecialchars($product['slug'] ?? $_POST['slug'] ?? '') ?>">
                    <div class="form-hint">Auto-generated from name if left empty.</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">— Select Category —</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ((int) ($product['category_id'] ?? $_POST['category_id'] ?? 0)) === (int) $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Short Description</label>
                <textarea name="short_description" class="form-control" rows="2" maxlength="500"><?= htmlspecialchars($product['short_description'] ?? $_POST['short_description'] ?? '') ?></textarea>
                <div class="form-hint">Brief description for listings (max 500 chars).</div>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="6"><?= htmlspecialchars($product['description'] ?? $_POST['description'] ?? '') ?></textarea>
            </div>
        </div>

        <div>
            <div class="glass-card mb-2">
                <h3 style="font-size:0.85rem;color:var(--accent);font-family:var(--font-display);margin-bottom:1rem;">Pricing & Inventory</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Price (₹)</label>
                        <input type="number" step="0.01" min="0" name="price" class="form-control" value="<?= htmlspecialchars($product['price'] ?? $_POST['price'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sale Price (₹)</label>
                        <input type="number" step="0.01" min="0" name="sale_price" class="form-control" value="<?= htmlspecialchars($product['sale_price'] ?? $_POST['sale_price'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control" value="<?= htmlspecialchars($product['sku'] ?? $_POST['sku'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unit</label>
                        <input type="text" name="unit" class="form-control" placeholder="kg, pcs, meter..." value="<?= htmlspecialchars($product['unit'] ?? $_POST['unit'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" min="0" name="stock" class="form-control" value="<?= (int) ($product['stock'] ?? $_POST['stock'] ?? 0) ?>">
                </div>
            </div>

            <div class="glass-card mb-2">
                <h3 style="font-size:0.85rem;color:var(--accent);font-family:var(--font-display);margin-bottom:1rem;">Featured Image</h3>

                <div class="form-group">
                    <input type="file" name="featured_image" class="form-control" accept="image/*" data-preview="#featuredPreview">
                    <div class="form-hint">Allowed: jpg, jpeg, png, gif, webp, svg</div>
                </div>
                <div class="img-preview-wrap">
                    <div id="featuredPreview" class="image-preview">
                        <?php if ($is_edit && !empty($product['featured_image'])): ?>
                            <img src="../admin/uploads/<?= htmlspecialchars($product['featured_image']) ?>" alt="Featured">
                        <?php else: ?>
                            <i class="fas fa-image placeholder-icon"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="glass-card">
                <div class="form-check">
                    <input type="checkbox" name="status" id="status" value="1" <?= ($product['status'] ?? 1) ? 'checked' : '' ?>>
                    <label for="status">Active</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="featured" id="featured" value="1" <?= ($product['featured'] ?? 0) ? 'checked' : '' ?>>
                    <label for="featured">Featured Product</label>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Sort Order</label>
                    <input type="number" min="0" name="sort_order" class="form-control" value="<?= (int) ($product['sort_order'] ?? $_POST['sort_order'] ?? 0) ?>">
                </div>
            </div>
        </div>

        <div class="full-width">
            <div class="glass-card meta-section">
                <div class="meta-toggle" id="metaToggle">
                    <i class="fas fa-chevron-down"></i> <span>Meta Information (SEO)</span>
                </div>
                <div class="meta-body" id="metaBody">
                    <div class="form-group">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($product['meta_title'] ?? $_POST['meta_title'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3"><?= htmlspecialchars($product['meta_description'] ?? $_POST['meta_description'] ?? '') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" placeholder="Comma-separated" value="<?= htmlspecialchars($product['meta_keywords'] ?? $_POST['meta_keywords'] ?? '') ?>">
                        <div class="form-hint">Separate keywords with commas.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="full-width d-flex gap-2" style="margin-top:0.5rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> <?= $is_edit ? 'Update Product' : 'Create Product' ?>
            </button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('productName');
    const slugInput = document.getElementById('productSlug');
    if (nameInput && slugInput) {
        nameInput.addEventListener('blur', function () {
            if (!slugInput.value.trim()) {
                slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            }
        });
    }

    const metaToggle = document.getElementById('metaToggle');
    const metaBody = document.getElementById('metaBody');
    if (metaToggle && metaBody) {
        <?php if ($is_edit && ($product['meta_title'] || $product['meta_description'] || $product['meta_keywords'])): ?>
            metaBody.classList.add('open');
            metaToggle.classList.add('open');
        <?php endif; ?>
        metaToggle.addEventListener('click', function () {
            this.classList.toggle('open');
            metaBody.classList.toggle('open');
        });
    }
});
</script>

<?php
$msg = $_GET['msg'] ?? '';
$type = $_GET['type'] ?? 'success';
if ($msg):
?>
<div id="toastContainer" class="toast-container"></div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof showToast === 'function') {
        showToast(<?= json_encode(htmlspecialchars_decode($msg)) ?>, <?= json_encode($type) ?>);
    }
});
</script>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
