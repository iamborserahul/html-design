<?php
$current_page = 'products';
$page_title = 'Product Specifications';
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

// Handle add/edit/delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf($token)) {
        $errors[] = 'Invalid security token.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'add' || $action === 'edit') {
            $spec_id = $action === 'edit' ? (int) ($_POST['spec_id'] ?? 0) : 0;
            $label = trim($_POST['label'] ?? '');
            $value = trim($_POST['value'] ?? '');
            $sort_order = (int) ($_POST['sort_order'] ?? 0);

            if (empty($label)) $errors[] = 'Label is required.';
            if (empty($value)) $errors[] = 'Value is required.';

            if (empty($errors)) {
                if ($action === 'edit' && $spec_id) {
                    $stmt = $db->prepare("UPDATE product_specs SET label = ?, value = ?, sort_order = ? WHERE id = ? AND product_id = ?");
                    $stmt->execute([$label, $value, $sort_order, $spec_id, $id]);
                    header('Location: product-specs.php?id=' . $id . '&msg=' . urlencode('Specification updated.') . '&type=success');
                    exit;
                } else {
                    $stmt = $db->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$id, $label, $value, $sort_order]);
                    header('Location: product-specs.php?id=' . $id . '&msg=' . urlencode('Specification added.') . '&type=success');
                    exit;
                }
            }
        }

        if ($action === 'delete') {
            $spec_id = (int) ($_POST['spec_id'] ?? 0);
            if ($spec_id) {
                $stmt = $db->prepare("DELETE FROM product_specs WHERE id = ? AND product_id = ?");
                $stmt->execute([$spec_id, $id]);
                header('Location: product-specs.php?id=' . $id . '&msg=' . urlencode('Specification deleted.') . '&type=success');
                exit;
            }
        }
    }
}

// Get edit spec
$edit_spec = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM product_specs WHERE id = ? AND product_id = ?");
    $stmt->execute([(int) $_GET['edit'], $id]);
    $edit_spec = $stmt->fetch();
}

$specs = $db->prepare("SELECT * FROM product_specs WHERE product_id = ? ORDER BY sort_order ASC, id ASC");
$specs->execute([$id]);
$specs = $specs->fetchAll();
?>

<style>
    .spec-form-card { max-width: 500px; }
</style>

<div class="d-flex-between mb-4">
    <div>
        <h2 style="font-family:var(--font-display);font-size:1rem;color:var(--accent);">
            <i class="fas fa-list"></i> Specifications for: <?= htmlspecialchars($product['name']) ?>
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
            <?= $edit_spec ? 'Edit Specification' : 'Add New Specification' ?>
        </h3>
        <form method="post" class="spec-form-card">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="<?= $edit_spec ? 'edit' : 'add' ?>">
            <?php if ($edit_spec): ?>
                <input type="hidden" name="spec_id" value="<?= $edit_spec['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label class="form-label">Label <span class="required">*</span></label>
                <input type="text" name="label" class="form-control" value="<?= htmlspecialchars($edit_spec['label'] ?? $_POST['label'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Value <span class="required">*</span></label>
                <input type="text" name="value" class="form-control" value="<?= htmlspecialchars($edit_spec['value'] ?? $_POST['value'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" min="0" name="sort_order" class="form-control" value="<?= (int) ($edit_spec['sort_order'] ?? $_POST['sort_order'] ?? 0) ?>">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-<?= $edit_spec ? 'save' : 'plus' ?>"></i> <?= $edit_spec ? 'Update' : 'Add' ?>
                </button>
                <?php if ($edit_spec): ?>
                    <a href="product-specs.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Specs List -->
    <div class="glass-card">
        <h3 style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:1rem;">
            Current Specifications (<?= count($specs) ?>)
        </h3>

        <?php if (empty($specs)): ?>
            <p class="text-dim fs-small">No specifications yet.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Value</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($specs as $spec): ?>
                            <tr>
                                <td class="fw-500"><?= htmlspecialchars($spec['label']) ?></td>
                                <td><?= htmlspecialchars($spec['value']) ?></td>
                                <td class="text-dim"><?= (int) $spec['sort_order'] ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="product-specs.php?id=<?= $id ?>&edit=<?= $spec['id'] ?>" class="btn btn-secondary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form method="post" style="display:inline;" data-confirm-form="Delete this specification?">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="spec_id" value="<?= $spec['id'] ?>">
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
