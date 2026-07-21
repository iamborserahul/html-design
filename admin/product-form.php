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
                $uploaded = upload_image($_FILES['featured_image'], __DIR__ . '/../uploads/');
                if ($uploaded) {
                    if ($featured_image) delete_image($featured_image, __DIR__ . '/../uploads/');
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
    /* Premium layout & spacing */
    .product-form-wrap {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-top: 1rem;
    }
    
    @media (max-width: 1024px) {
        .product-form-wrap {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }
    
    .glass-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .glass-card:hover {
        border-color: var(--accent);
        box-shadow: 0 10px 30px rgba(184, 134, 11, 0.04);
    }
    
    .glass-card-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
        padding-bottom: 1rem;
    }
    
    .glass-card-header i {
        color: var(--accent);
        font-size: 1.2rem;
    }
    
    .glass-card-header h3 {
        font-family: var(--font-sans);
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-primary);
    }

    /* Switch Styling */
    .switch-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border);
    }
    .switch-group:last-child {
        border-bottom: none;
    }
    .switch-label-wrap {
        display: flex;
        flex-direction: column;
    }
    .switch-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-primary);
    }
    .switch-desc {
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 24px;
        flex-shrink: 0;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: var(--border);
        transition: .3s;
        border-radius: 24px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    input:checked + .slider {
        background-color: var(--accent);
    }
    input:focus + .slider {
        box-shadow: 0 0 1px var(--accent);
    }
    input:checked + .slider:before {
        transform: translateX(22px);
    }

    /* Tabs Styling */
    .product-tabs {
        border-bottom: 1px solid var(--border);
        margin-bottom: 2rem;
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
    }
    .product-tabs .tab-item {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 0.5rem;
        font-weight: 500;
        color: var(--text-muted);
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .product-tabs .tab-item:hover {
        color: var(--text-primary);
    }
    .product-tabs .tab-item.active {
        color: var(--accent);
        border-bottom-color: var(--accent);
    }

    /* Modern Dropzone & Drag-drop */
    .dropzone-upload {
        border: 2px dashed var(--border);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        background: var(--bg-input);
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }
    .dropzone-upload:hover, .dropzone-upload.dragover {
        border-color: var(--accent);
        background: var(--accent-dim);
    }
    .dropzone-upload .upload-icon {
        color: var(--text-muted);
        margin-bottom: 0.75rem;
        font-size: 1.8rem;
        transition: color 0.3s;
    }
    .dropzone-upload:hover .upload-icon {
        color: var(--accent);
    }
    .dropzone-upload p {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin: 0;
    }
    .dropzone-upload .img-preview-container {
        margin-top: 1rem;
        display: flex;
        justify-content: center;
    }
    .dropzone-upload img {
        max-width: 100%;
        max-height: 180px;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    /* Form Fields Styling */
    .form-row-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }
    @media (max-width: 576px) {
        .form-row-grid {
            grid-template-columns: 1fr;
        }
    }
    .form-group {
        margin-bottom: 1.25rem;
        display: block;
        width: 100%;
        box-sizing: border-box;
    }
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-secondary);
        margin-bottom: 6px;
        letter-spacing: 0.3px;
    }
    .form-control {
        display: block;
        width: 100%;
        padding: 10px 14px;
        background: var(--bg-input, #f9fafb);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text-primary);
        font-family: var(--font-sans);
        font-size: 14px;
        transition: all 0.3s;
        outline: none;
        box-sizing: border-box;
    }
    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.15);
    }
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    select.form-control {
        height: auto;
    }
    .form-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
        display: block;
    }

    /* SEO Google Preview */
    .seo-preview {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 1.25rem;
        font-family: Arial, sans-serif;
        color: #202124;
        margin-top: 1.5rem;
        max-width: 600px;
    }
    .seo-preview .seo-url {
        font-size: 12px;
        color: #202124;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 4px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .seo-preview .seo-title {
        font-size: 19px;
        color: #1a0dab;
        line-height: 1.3;
        margin-bottom: 4px;
        cursor: pointer;
        word-break: break-word;
    }
    .seo-preview .seo-title:hover {
        text-decoration: underline;
    }
    .seo-preview .seo-desc {
        font-size: 14px;
        color: #4d5156;
        line-height: 1.4;
        word-break: break-word;
    }

    .meta-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border);
        cursor: pointer;
        font-weight: 500;
        color: var(--text-secondary);
    }
    .meta-toggle i {
        transition: transform 0.3s;
    }
    .meta-toggle.open i {
        transform: rotate(180deg);
    }
    .meta-body {
        display: none;
        padding-top: 1.25rem;
    }
    .meta-body.open {
        display: block;
    }

    /* Actions Bar */
    .actions-bar {
        display: flex;
        gap: 1rem;
        align-items: center;
        border-top: 1px solid var(--border);
        padding-top: 1.5rem;
        margin-top: 1rem;
    }
    .tab-error {
        background: var(--danger-bg);
        border: 1px solid rgba(220, 38, 38, 0.2);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        color: var(--danger);
        font-size: 0.85rem;
        margin-bottom: 1.5rem;
    }
    .tab-error i {
        margin-right: 0.4rem;
    }
</style>

<?php if ($is_edit): ?>
    <div class="tabs product-tabs">
        <a href="product-form.php?id=<?= $id ?>" class="tab-item active"><i class="fa-solid fa-circle-info"></i> Basic Info</a>
        <a href="product-images.php?id=<?= $id ?>" class="tab-item"><i class="fa-solid fa-images"></i> Images</a>
        <a href="product-specs.php?id=<?= $id ?>" class="tab-item"><i class="fa-solid fa-list-check"></i> Specifications</a>
        <a href="product-features.php?id=<?= $id ?>" class="tab-item"><i class="fa-solid fa-star"></i> Features</a>
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="tab-error"><i class="fas fa-exclamation-circle"></i> <?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $id ?>">

    <div class="product-form-wrap">
        <div>
            <!-- Basic Information Card -->
            <div class="glass-card">
                <div class="glass-card-header">
                    <i class="fa-solid fa-file-invoice"></i>
                    <h3>General Details</h3>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Product Name <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control" id="productName" value="<?= htmlspecialchars($product['name'] ?? $_POST['name'] ?? '') ?>" required placeholder="e.g. Stainless Steel Showcase">
                </div>

                <div class="form-row-grid">
                    <div class="form-group">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" id="productSlug" value="<?= htmlspecialchars($product['slug'] ?? $_POST['slug'] ?? '') ?>" placeholder="auto-generated-slug">
                        <div class="form-hint">URL friendly text. Auto-generated from name if empty.</div>
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
                    <textarea name="short_description" id="shortDescInput" class="form-control" rows="2" maxlength="500" placeholder="Brief summary of the product for listings..."><?= htmlspecialchars($product['short_description'] ?? $_POST['short_description'] ?? '') ?></textarea>
                    <div class="form-hint">Brief description for search listings (max 500 chars).</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="6" placeholder="Enter rich description here..."><?= htmlspecialchars($product['description'] ?? $_POST['description'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- SEO Settings Card -->
            <div class="glass-card">
                <div class="glass-card-header">
                    <i class="fa-solid fa-search"></i>
                    <h3>SEO Settings</h3>
                </div>
                
                <div class="meta-toggle" id="metaToggle">
                    <span>Configure Search Engine Optimization Metadata</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="meta-body" id="metaBody">
                    <div class="form-group">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" id="metaTitleInput" class="form-control" placeholder="Meta title for Google" value="<?= htmlspecialchars($product['meta_title'] ?? $_POST['meta_title'] ?? '') ?>">
                        <div class="form-hint">Keep it under 60 characters for best display.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" id="metaDescInput" class="form-control" rows="3" placeholder="Snippet for search engines"><?= htmlspecialchars($product['meta_description'] ?? $_POST['meta_description'] ?? '') ?></textarea>
                        <div class="form-hint">Keep it under 160 characters for search listings.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" placeholder="keyword1, keyword2, keyword3" value="<?= htmlspecialchars($product['meta_keywords'] ?? $_POST['meta_keywords'] ?? '') ?>">
                        <div class="form-hint">Separate keywords with commas.</div>
                    </div>

                    <!-- Interactive Google Search Preview -->
                    <div class="form-group">
                        <label class="form-label" style="margin-top: 1rem;">Search Engine Result Preview</label>
                        <div class="seo-preview">
                            <div class="seo-url">
                                <span>https://khodiyarsteel.com</span>
                                <i class="fas fa-chevron-right" style="font-size: 8px;"></i>
                                <span>products</span>
                                <i class="fas fa-chevron-right" style="font-size: 8px;"></i>
                                <span id="seoPreviewSlug">example-product</span>
                            </div>
                            <div class="seo-title" id="seoPreviewTitle">Example Product Title</div>
                            <div class="seo-desc" id="seoPreviewDesc">Please enter a description or short description to preview the snippet here on Google.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <!-- Pricing & Inventory Card -->
            <div class="glass-card">
                <div class="glass-card-header">
                    <i class="fa-solid fa-tags"></i>
                    <h3>Pricing & Stock</h3>
                </div>

                <div class="form-row-grid">
                    <div class="form-group">
                        <label class="form-label">Price (₹)</label>
                        <input type="number" step="0.01" min="0" name="price" class="form-control" placeholder="0.00" value="<?= htmlspecialchars($product['price'] ?? $_POST['price'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sale Price (₹)</label>
                        <input type="number" step="0.01" min="0" name="sale_price" class="form-control" placeholder="0.00" value="<?= htmlspecialchars($product['sale_price'] ?? $_POST['sale_price'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-row-grid">
                    <div class="form-group">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control" placeholder="e.g. KS-001" value="<?= htmlspecialchars($product['sku'] ?? $_POST['sku'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unit</label>
                        <input type="text" name="unit" class="form-control" placeholder="e.g. kg, pcs, meter" value="<?= htmlspecialchars($product['unit'] ?? $_POST['unit'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" min="0" name="stock" class="form-control" value="<?= (int) ($product['stock'] ?? $_POST['stock'] ?? 0) ?>">
                </div>
            </div>

            <!-- Media Upload Card -->
            <div class="glass-card">
                <div class="glass-card-header">
                    <i class="fa-solid fa-image"></i>
                    <h3>Featured Image</h3>
                </div>

                <div class="form-group">
                    <div class="dropzone-upload dropzone" id="imageDropzone">
                        <input type="file" name="featured_image" id="featuredImageInput" accept="image/*" data-preview="#featuredPreview" style="display: none;">
                        <div onclick="document.getElementById('featuredImageInput').click();" style="width:100%; height:100%;">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <p><strong>Click to upload</strong> or drag and drop</p>
                            <p style="font-size: 0.7rem; color: var(--text-muted); margin-top: 4px;">PNG, JPG, JPEG, WEBP or SVG</p>
                        </div>
                        <div class="img-preview-container" id="featuredPreview">
                            <?php if ($is_edit && !empty($product['featured_image'])): ?>
                                <?php 
                                $img_src = htmlspecialchars($product['featured_image']);
                                $img = (strpos($img_src, 'assets/') === 0) ? '../' . $img_src : '../uploads/' . $img_src;
                                ?>
                                <img src="<?= $img ?>" alt="Featured">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Settings Card -->
            <div class="glass-card">
                <div class="glass-card-header">
                    <i class="fa-solid fa-sliders"></i>
                    <h3>Status & Settings</h3>
                </div>

                <div class="switch-group">
                    <div class="switch-label-wrap">
                        <span class="switch-label">Active</span>
                        <span class="switch-desc">Visible on store frontend</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="status" id="status" value="1" <?= ($product['status'] ?? 1) ? 'checked' : '' ?>>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="switch-group">
                    <div class="switch-label-wrap">
                        <span class="switch-label">Featured Product</span>
                        <span class="switch-desc">Promoted on homepage</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="featured" id="featured" value="1" <?= ($product['featured'] ?? 0) ? 'checked' : '' ?>>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="form-group" style="margin-top: 1.5rem; margin-bottom: 0;">
                    <label class="form-label">Sort Order</label>
                    <input type="number" min="0" name="sort_order" class="form-control" value="<?= (int) ($product['sort_order'] ?? $_POST['sort_order'] ?? 0) ?>">
                    <div class="form-hint">Used for ordering products (low to high).</div>
                </div>
            </div>
        </div>

        <div class="full-width actions-bar">
            <button type="submit" class="btn btn-gold">
                <i class="fas fa-save"></i> <?= $is_edit ? 'Update Product' : 'Create Product' ?>
            </button>
            <a href="products.php" class="btn btn-ghost">Cancel</a>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('productName');
    const slugInput = document.getElementById('productSlug');
    
    // Auto-slug generation
    if (nameInput && slugInput) {
        nameInput.addEventListener('blur', function () {
            if (!slugInput.value.trim()) {
                const slugified = this.value.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-|-$/g, '');
                slugInput.value = slugified;
                updateSeoPreview();
            }
        });
        slugInput.addEventListener('input', updateSeoPreview);
    }

    // Toggle SEO section
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

    // Interactive SEO Preview Logic
    const metaTitleInput = document.getElementById('metaTitleInput');
    const metaDescInput = document.getElementById('metaDescInput');
    const shortDescInput = document.getElementById('shortDescInput');
    
    const seoPreviewTitle = document.getElementById('seoPreviewTitle');
    const seoPreviewSlug = document.getElementById('seoPreviewSlug');
    const seoPreviewDesc = document.getElementById('seoPreviewDesc');

    function updateSeoPreview() {
        // Title
        if (metaTitleInput && metaTitleInput.value.trim()) {
            seoPreviewTitle.textContent = metaTitleInput.value.trim();
        } else if (nameInput && nameInput.value.trim()) {
            seoPreviewTitle.textContent = nameInput.value.trim();
        } else {
            seoPreviewTitle.textContent = 'Example Product Title';
        }

        // Slug
        if (slugInput && slugInput.value.trim()) {
            seoPreviewSlug.textContent = slugInput.value.trim()
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
        } else if (nameInput && nameInput.value.trim()) {
            seoPreviewSlug.textContent = nameInput.value.trim()
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
        } else {
            seoPreviewSlug.textContent = 'example-product';
        }

        // Description
        if (metaDescInput && metaDescInput.value.trim()) {
            seoPreviewDesc.textContent = metaDescInput.value.trim();
        } else if (shortDescInput && shortDescInput.value.trim()) {
            seoPreviewDesc.textContent = shortDescInput.value.trim();
        } else {
            seoPreviewDesc.textContent = 'Please enter a description or short description to preview the snippet here on Google.';
        }
    }

    if (nameInput) nameInput.addEventListener('input', updateSeoPreview);
    if (metaTitleInput) metaTitleInput.addEventListener('input', updateSeoPreview);
    if (metaDescInput) metaDescInput.addEventListener('input', updateSeoPreview);
    if (shortDescInput) shortDescInput.addEventListener('input', updateSeoPreview);
    
    // Initial SEO preview update
    updateSeoPreview();
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
