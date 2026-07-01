<?php
$current_page = 'products';
$page_title = 'Product Features';
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

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf($token)) {
        $errors[] = 'Invalid security token.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'add' || $action === 'edit') {
            $feature_id = $action === 'edit' ? (int) ($_POST['feature_id'] ?? 0) : 0;
            $feature = trim($_POST['feature'] ?? '');
            $icon = trim($_POST['icon'] ?? '');
            $sort_order = (int) ($_POST['sort_order'] ?? 0);

            if (empty($feature)) $errors[] = 'Feature text is required.';

            if (empty($errors)) {
                if ($action === 'edit' && $feature_id) {
                    $stmt = $db->prepare("UPDATE product_features SET feature = ?, icon = ?, sort_order = ? WHERE id = ? AND product_id = ?");
                    $stmt->execute([$feature, $icon, $sort_order, $feature_id, $id]);
                    header('Location: product-features.php?id=' . $id . '&msg=' . urlencode('Feature updated.') . '&type=success');
                    exit;
                } else {
                    $stmt = $db->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$id, $feature, $icon, $sort_order]);
                    header('Location: product-features.php?id=' . $id . '&msg=' . urlencode('Feature added.') . '&type=success');
                    exit;
                }
            }
        }

        if ($action === 'delete') {
            $feature_id = (int) ($_POST['feature_id'] ?? 0);
            if ($feature_id) {
                $stmt = $db->prepare("DELETE FROM product_features WHERE id = ? AND product_id = ?");
                $stmt->execute([$feature_id, $id]);
                header('Location: product-features.php?id=' . $id . '&msg=' . urlencode('Feature deleted.') . '&type=success');
                exit;
            }
        }
    }
}

$edit_feature = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM product_features WHERE id = ? AND product_id = ?");
    $stmt->execute([(int) $_GET['edit'], $id]);
    $edit_feature = $stmt->fetch();
}

$features = $db->prepare("SELECT * FROM product_features WHERE product_id = ? ORDER BY sort_order ASC, id ASC");
$features->execute([$id]);
$features = $features->fetchAll();
?>

<style>
    .feature-icon-preview { display: inline-block; width: 28px; text-align: center; color: var(--accent); font-size: 1rem; }
</style>

<div class="d-flex-between mb-4">
    <div>
        <h2 style="font-family:var(--font-display);font-size:1rem;color:var(--accent);">
            <i class="fas fa-star"></i> Features for: <?= htmlspecialchars($product['name']) ?>
        </h2>
    </div>
    <a href="product-form.php?id=<?= $id ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Product</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
<?php endif; ?>

<div class="grid-2" style="grid-template-columns: 1fr 1.5fr;">
    <!-- Add / Edit Form -->
    <div class="glass-card">
        <h3 style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:1rem;">
            <?= $edit_feature ? 'Edit Feature' : 'Add New Feature' ?>
        </h3>
        <form method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="<?= $edit_feature ? 'edit' : 'add' ?>">
            <?php if ($edit_feature): ?>
                <input type="hidden" name="feature_id" value="<?= $edit_feature['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label class="form-label">Feature <span class="required">*</span></label>
                <textarea name="feature" class="form-control" rows="3" required><?= htmlspecialchars($edit_feature['feature'] ?? $_POST['feature'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Icon Class</label>
                <input type="text" name="icon" class="form-control" placeholder="fa-solid fa-check" value="<?= htmlspecialchars($edit_feature['icon'] ?? $_POST['icon'] ?? '') ?>">
                <div class="form-hint">Font Awesome class, e.g. <code>fa-solid fa-check</code></div>
                <?php if ($edit_feature && $edit_feature['icon']): ?>
                    <div class="mt-2"><span class="feature-icon-preview"><i class="<?= htmlspecialchars($edit_feature['icon']) ?>"></i></span> Preview</div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" min="0" name="sort_order" class="form-control" value="<?= (int) ($edit_feature['sort_order'] ?? $_POST['sort_order'] ?? 0) ?>">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-<?= $edit_feature ? 'save' : 'plus' ?>"></i> <?= $edit_feature ? 'Update' : 'Add' ?>
                </button>
                <?php if ($edit_feature): ?>
                    <a href="product-features.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Features List -->
    <div class="glass-card">
        <h3 style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:1rem;">
            Current Features (<?= count($features) ?>)
        </h3>

        <?php if (empty($features)): ?>
            <p class="text-dim fs-small">No features yet.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Feature</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($features as $feat): ?>
                            <tr>
                                <td>
                                    <?php if ($feat['icon']): ?>
                                        <span class="feature-icon-preview"><i class="<?= htmlspecialchars($feat['icon']) ?>"></i></span>
                                    <?php else: ?>
                                        <span class="text-dim">—</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($feat['feature']) ?></td>
                                <td class="text-dim"><?= (int) $feat['sort_order'] ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="product-features.php?id=<?= $id ?>&edit=<?= $feat['id'] ?>" class="btn btn-secondary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form method="post" style="display:inline;" data-confirm-form="Delete this feature?">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="feature_id" value="<?= $feat['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

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
