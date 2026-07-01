<?php
$current_page = 'stats';
$page_title = 'Stats Counters';
require_once __DIR__ . '/includes/header.php';

$errors = [];
$success = '';

// --- Handle Delete ---
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    if (!isset($_GET['csrf']) || !verify_csrf($_GET['csrf'])) {
        $errors[] = 'Invalid security token.';
    } else {
        $stmt = $db->prepare("DELETE FROM stats_counters WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Counter deleted successfully.';
    }
}

// --- Handle Add / Edit ---
$edit_mode = false;
$edit_row = [
    'id' => '', 'label' => '', 'value' => '', 'suffix' => '+',
    'icon' => 'fa-layer-group', 'sort_order' => '0', 'status' => '1',
];

if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM stats_counters WHERE id = ?");
    $stmt->execute([(int) $_GET['edit']]);
    $row = $stmt->fetch();
    if ($row) {
        $edit_mode = true;
        $edit_row = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_counter') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token. Please reload the page.';
    } else {
        $label = trim($_POST['label'] ?? '');
        $value = (int) ($_POST['value'] ?? 0);
        $suffix = trim($_POST['suffix'] ?? '+');
        $icon = trim($_POST['icon'] ?? 'fa-layer-group');
        $sort_order = (int) ($_POST['sort_order'] ?? 0);
        $status = isset($_POST['status']) ? 1 : 0;

        if ($label === '') {
            $errors[] = 'Label is required.';
        }

        if (empty($errors)) {
            if (!empty($_POST['id'])) {
                $stmt = $db->prepare("UPDATE stats_counters SET label=?, `value`=?, suffix=?, icon=?, sort_order=?, status=? WHERE id=?");
                $stmt->execute([$label, $value, $suffix, $icon, $sort_order, $status, (int) $_POST['id']]);
                $success = 'Counter updated successfully.';
            } else {
                $stmt = $db->prepare("INSERT INTO stats_counters (label, `value`, suffix, icon, sort_order, status) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$label, $value, $suffix, $icon, $sort_order, $status]);
                $success = 'Counter added successfully.';
            }
            $edit_mode = false;
            $edit_row = ['id' => '', 'label' => '', 'value' => '', 'suffix' => '+', 'icon' => 'fa-layer-group', 'sort_order' => '0', 'status' => '1'];
        }
    }
}

$counters = $db->query("SELECT * FROM stats_counters ORDER BY sort_order ASC, id ASC")->fetchAll();
?>

<style>
    .counter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.25rem;
    }
    .counter-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    .counter-card:hover {
        background: var(--bg-card-hover);
        border-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    }
    .counter-card .cc-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        background: var(--gold-dim);
        color: var(--gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin: 0 auto 0.75rem;
    }
    .counter-card .cc-value {
        font-family: 'Cinzel', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--gold);
        line-height: 1;
    }
    .counter-card .cc-label {
        font-size: 0.82rem;
        color: var(--text-dim);
        margin-top: 0.3rem;
    }
    .counter-card .cc-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 0.6rem;
        font-size: 0.7rem;
    }
    .counter-card .cc-order {
        color: var(--text-dim);
        background: rgba(255, 255, 255, 0.04);
        padding: 0.15rem 0.5rem;
        border-radius: 4px;
    }
    .counter-card .cc-actions {
        margin-top: 1rem;
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        border-top: 1px solid var(--border);
        padding-top: 0.75rem;
    }
    .counter-card .cc-actions a {
        font-size: 0.75rem;
        padding: 0.3rem 0.75rem;
        border-radius: 6px;
    }
    .counter-card .cc-status {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .form-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .form-card h2 {
        font-family: 'Cinzel', serif;
        font-size: 0.95rem;
        color: var(--gold);
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border);
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .form-row.three-cols {
        grid-template-columns: 1fr 1fr 1fr;
    }
    .form-group label {
        display: block;
        font-size: 0.78rem;
        color: var(--text-dim);
        margin-bottom: 0.3rem;
        font-weight: 500;
    }
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.55rem 0.75rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text);
        font-family: inherit;
        font-size: 0.85rem;
        outline: none;
        transition: border-color 0.25s;
    }
    .form-group input:focus,
    .form-group select:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px var(--gold-dim);
    }
    .form-group .hint {
        font-size: 0.68rem;
        color: var(--text-dim);
        margin-top: 0.2rem;
    }
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .form-check label {
        font-size: 0.82rem;
        color: var(--text-dim);
        cursor: pointer;
    }
    .alert {
        padding: 0.65rem 1rem;
        border-radius: 8px;
        font-size: 0.82rem;
        margin-bottom: 1rem;
    }
    .alert-success {
        background: rgba(34, 197, 94, 0.12);
        border: 1px solid rgba(34, 197, 94, 0.25);
        color: var(--success);
    }
    .alert-error {
        background: rgba(239, 68, 68, 0.12);
        border: 1px solid rgba(239, 68, 68, 0.25);
        color: var(--danger);
    }
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-dim);
    }
    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        opacity: 0.4;
    }
    @media (max-width: 768px) {
        .form-row, .form-row.three-cols { grid-template-columns: 1fr; }
    }
</style>

<?php if ($success): ?>
    <div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php foreach ($errors as $e): ?>
    <div class="alert alert-error"><i class="fa-solid fa-exclamation-circle"></i> <?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>

<!-- Add/Edit Form -->
<div class="form-card">
    <h2><i class="fa-solid fa-<?= $edit_mode ? 'pen' : 'plus' ?>"></i> <?= $edit_mode ? 'Edit Counter' : 'Add New Counter' ?></h2>
    <form method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="save_counter">
        <?php if ($edit_mode): ?>
            <input type="hidden" name="id" value="<?= (int) $edit_row['id'] ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="label">Label *</label>
                <input type="text" id="label" name="label" value="<?= htmlspecialchars($edit_row['label']) ?>" placeholder="e.g. Projects Delivered">
            </div>
            <div class="form-group">
                <label for="value">Value</label>
                <input type="number" id="value" name="value" value="<?= (int) $edit_row['value'] ?>" placeholder="e.g. 15000">
            </div>
        </div>

        <div class="form-row three-cols">
            <div class="form-group">
                <label for="suffix">Suffix</label>
                <input type="text" id="suffix" name="suffix" value="<?= htmlspecialchars($edit_row['suffix']) ?>" placeholder="e.g. +">
                <div class="hint">Text after the number (e.g. +, %, K)</div>
            </div>
            <div class="form-group">
                <label for="icon">Font Awesome Icon</label>
                <input type="text" id="icon" name="icon" value="<?= htmlspecialchars($edit_row['icon']) ?>" placeholder="e.g. fa-layer-group">
                <div class="hint">Full class name without <code>fa-solid</code></div>
            </div>
            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" value="<?= (int) $edit_row['sort_order'] ?>" placeholder="0">
            </div>
        </div>

        <div class="form-check">
            <input type="checkbox" id="status" name="status" value="1" <?= $edit_row['status'] ? 'checked' : '' ?> style="width:auto;">
            <label for="status">Active</label>
        </div>

        <div style="display:flex;gap:0.5rem;">
            <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> <?= $edit_mode ? 'Update' : 'Save' ?> Counter</button>
            <?php if ($edit_mode): ?>
                <a href="stats.php" class="btn btn-ghost"><i class="fa-solid fa-times"></i> Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Counters Grid -->
<?php if (empty($counters)): ?>
    <div class="empty-state">
        <i class="fa-solid fa-chart-simple"></i>
        <p>No counters yet. Add your first counter above.</p>
    </div>
<?php else: ?>
    <div class="counter-grid">
        <?php foreach ($counters as $c): ?>
            <div class="counter-card">
                <div class="cc-status">
                    <?php if ($c['status']): ?>
                        <span class="badge badge-read" style="background:rgba(34,197,94,0.12);color:var(--success);border:1px solid rgba(34,197,94,0.25);">Active</span>
                    <?php else: ?>
                        <span class="badge badge-read" style="color:var(--text-dim);">Inactive</span>
                    <?php endif; ?>
                </div>
                <div class="cc-icon"><i class="fa-solid <?= htmlspecialchars($c['icon']) ?>"></i></div>
                <div class="cc-value"><?= number_format((int) $c['value']) ?><?= htmlspecialchars($c['suffix']) ?></div>
                <div class="cc-label"><?= htmlspecialchars($c['label']) ?></div>
                <div class="cc-meta">
                    <span class="cc-order"><i class="fa-solid fa-arrows-alt-v"></i> Order: <?= (int) $c['sort_order'] ?></span>
                </div>
                <div class="cc-actions">
                    <a href="stats.php?edit=<?= $c['id'] ?>" class="btn btn-ghost" style="padding:0.3rem 0.75rem;font-size:0.75rem;">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <a href="stats.php?delete=<?= $c['id'] ?>&csrf=<?= csrf_token() ?>"
                       class="btn btn-ghost"
                       style="padding:0.3rem 0.75rem;font-size:0.75rem;color:var(--danger);border-color:rgba(239,68,68,0.2);"
                       onclick="return confirm('Delete this counter?');">
                        <i class="fa-solid fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
