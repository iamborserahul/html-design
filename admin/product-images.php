<?php
$current_page = 'products';
$page_title = 'Product Images';
require_once __DIR__ . '/includes/header.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$id) {
    header('Location: products.php?msg=' . urlencode('Product ID is required.') . '&type=error');
    exit;
}

$stmt = $db->prepare("SELECT id, name FROM products WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) {
    header('Location: products.php?msg=' . urlencode('Product not found.') . '&type=error');
    exit;
}

// Handle delete image
if (isset($_GET['delete'])) {
    $img_id = (int) $_GET['delete'];
    $token = $_GET['csrf_token'] ?? '';
    if (verify_csrf($token)) {
        $stmt = $db->prepare("SELECT image FROM product_images WHERE id = ? AND product_id = ?");
        $stmt->execute([$img_id, $id]);
        $img = $stmt->fetch();
        if ($img) {
            delete_image($img['image'], __DIR__ . '/uploads/');
            $db->prepare("DELETE FROM product_images WHERE id = ?")->execute([$img_id]);
        }
    }
    header('Location: product-images.php?id=' . $id . '&msg=' . urlencode('Image deleted.') . '&type=success');
    exit;
}

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf($token)) {
        header('Location: product-images.php?id=' . $id . '&msg=' . urlencode('Invalid security token.') . '&type=error');
        exit;
    }

    if (!empty($_FILES['images']['name'][0])) {
        $uploaded_count = 0;
        $files = $_FILES['images'];
        $total = count($files['name']);

        // Get max sort_order
        $max_order = (int) $db->prepare("SELECT COALESCE(MAX(sort_order), 0) FROM product_images WHERE product_id = ?")->execute([$id]);
        $max_order = 0;
        $stmt = $db->prepare("SELECT COALESCE(MAX(sort_order), 0) FROM product_images WHERE product_id = ?");
        $stmt->execute([$id]);
        $max_order = (int) $stmt->fetchColumn();

        $stmt = $db->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?, ?, ?, ?)");

        for ($i = 0; $i < $total; $i++) {
            $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i],
            ];
            $filename = upload_image($file, __DIR__ . '/uploads/');
            if ($filename) {
                $stmt->execute([$id, $filename, '', $max_order + $uploaded_count + 1]);
                $uploaded_count++;
            }
        }

        header('Location: product-images.php?id=' . $id . '&msg=' . urlencode($uploaded_count . ' image(s) uploaded.') . '&type=success');
        exit;
    }
    header('Location: product-images.php?id=' . $id . '&msg=' . urlencode('No files selected.') . '&type=warning');
    exit;
}

// Handle update alt text / sort order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $token = $_POST['csrf_token'] ?? '';
    if (verify_csrf($token) && isset($_POST['items'])) {
        foreach ($_POST['items'] as $img_id => $data) {
            $img_id = (int) $img_id;
            $alt = trim($data['alt_text'] ?? '');
            $sort = (int) ($data['sort_order'] ?? 0);
            $stmt = $db->prepare("UPDATE product_images SET alt_text = ?, sort_order = ? WHERE id = ? AND product_id = ?");
            $stmt->execute([$alt, $sort, $img_id, $id]);
        }
        header('Location: product-images.php?id=' . $id . '&msg=' . urlencode('Images updated.') . '&type=success');
        exit;
    }
}

$images = $db->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC, id ASC");
$images->execute([$id]);
$images = $images->fetchAll();
?>

<style>
    .image-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-top: 1rem; }
    .image-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; transition: all 0.3s; }
    .image-card:hover { border-color: rgba(255,255,255,0.12); }
    .image-card .img-wrap { width: 100%; height: 150px; overflow: hidden; background: var(--bg-input); position: relative; }
    .image-card .img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .image-card .img-body { padding: 0.65rem; }
    .image-card .img-body input[type="text"] { width: 100%; padding: 5px 8px; background: var(--bg-input); border: 1px solid var(--border); border-radius: 4px; color: var(--text); font-size: 0.75rem; outline: none; }
    .image-card .img-body input[type="text"]:focus { border-color: var(--accent); }
    .image-card .img-actions { display: flex; gap: 0.35rem; padding: 0.35rem 0.65rem 0.65rem; }
    .image-card .img-actions .btn { font-size: 0.7rem; padding: 0.3rem 0.6rem; }
    .img-sort-row { display: flex; gap: 0.35rem; align-items: center; margin-top: 0.35rem; }
    .img-sort-row label { font-size: 0.7rem; color: var(--text-dim); }
    .img-sort-row input { width: 50px; padding: 3px 6px; background: var(--bg-input); border: 1px solid var(--border); border-radius: 4px; color: var(--text); font-size: 0.75rem; text-align: center; outline: none; }
    .img-sort-row input:focus { border-color: var(--accent); }
</style>

<div class="d-flex-between mb-4">
    <div>
        <h2 style="font-family:var(--font-display);font-size:1rem;color:var(--accent);">
            <i class="fas fa-image"></i> Images for: <?= htmlspecialchars($product['name']) ?>
        </h2>
    </div>
    <a href="product-form.php?id=<?= $id ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Product</a>
</div>

<!-- Upload Form -->
<div class="glass-card mb-4">
    <h3 style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:0.75rem;">Upload New Images</h3>
    <form method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="upload">
        <div class="dropzone">
            <div class="dropzone-icon"><i class="fas fa-cloud-upload-alt"></i></div>
            <div class="dropzone-text">Drag & drop images here or click to browse</div>
            <div class="dropzone-hint">Supports: jpg, jpeg, png, gif, webp, svg</div>
            <input type="file" name="images[]" multiple accept="image/*" style="display:none;" id="fileInput">
            <div class="dropzone-preview"></div>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload Images</button>
        </div>
    </form>
</div>

<!-- Existing Images -->
<?php if (empty($images)): ?>
    <div class="glass-card text-center" style="padding:2rem;">
        <p class="text-dim">No images yet. Upload some above.</p>
    </div>
<?php else: ?>
    <form method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="update">
        <div class="image-grid">
            <?php foreach ($images as $img): ?>
                <div class="image-card">
                    <div class="img-wrap">
                        <img src="../admin/uploads/<?= htmlspecialchars($img['image']) ?>" alt="<?= htmlspecialchars($img['alt_text']) ?>">
                    </div>
                    <div class="img-body">
                        <input type="text" name="items[<?= $img['id'] ?>][alt_text]" value="<?= htmlspecialchars($img['alt_text']) ?>" placeholder="Alt text">
                        <div class="img-sort-row">
                            <label>Order:</label>
                            <input type="number" name="items[<?= $img['id'] ?>][sort_order]" value="<?= (int) $img['sort_order'] ?>" min="0">
                        </div>
                    </div>
                    <div class="img-actions">
                        <a href="product-images.php?id=<?= $id ?>&delete=<?= $img['id'] ?>&csrf_token=<?= csrf_token() ?>" class="btn btn-danger btn-sm" data-confirm="Delete this image?"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
    </form>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropzone = document.querySelector('.dropzone');
    const fileInput = document.getElementById('fileInput');
    const preview = document.querySelector('.dropzone-preview');

    if (dropzone && fileInput) {
        dropzone.addEventListener('click', function () { fileInput.click(); });

        fileInput.addEventListener('change', function () {
            preview.innerHTML = '';
            Array.from(this.files).forEach(function (file, i) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = document.createElement('div');
                        div.className = 'dropzone-preview-item';
                        div.innerHTML = '<img src="' + e.target.result + '" alt="Preview"><button type="button" class="remove-file" data-index="' + i + '"><i class="fas fa-times"></i></button>';
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        preview.addEventListener('click', function (e) {
            if (e.target.closest('.remove-file')) {
                e.target.closest('.dropzone-preview-item').remove();
                const dt = new DataTransfer();
                const files = fileInput.files;
                const idx = parseInt(e.target.closest('.remove-file').dataset.index);
                Array.from(files).forEach(function (f, i) { if (i !== idx) dt.items.add(f); });
                fileInput.files = dt.files;
            }
        });

        dropzone.addEventListener('dragover', function (e) { e.preventDefault(); this.classList.add('dragover'); });
        dropzone.addEventListener('dragleave', function (e) { e.preventDefault(); this.classList.remove('dragover'); });
        dropzone.addEventListener('drop', function (e) {
            e.preventDefault();
            this.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                fileInput.dispatchEvent(new Event('change'));
            }
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
