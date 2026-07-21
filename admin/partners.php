<?php
$current_page = 'partners';
$page_title = 'Collaboration Partners';
require_once __DIR__ . '/includes/header.php';

$errors = [];
$success = '';

// --- Handle Delete ---
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    if (!isset($_GET['csrf']) || !verify_csrf($_GET['csrf'])) {
        $errors[] = 'Invalid security token.';
    } else {
        $stmt = $db->prepare("DELETE FROM partners WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Partner deleted successfully.';
    }
}

// --- Handle Add / Edit ---
$edit_mode = false;
$edit_row = [
    'id' => '', 'name' => '', 'icon' => 'fa-solid fa-handshake', 'sort_order' => '0', 'status' => '1',
];

if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM partners WHERE id = ?");
    $stmt->execute([(int) $_GET['edit']]);
    $row = $stmt->fetch();
    if ($row) {
        $edit_mode = true;
        $edit_row = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_partner') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token. Please reload the page.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $icon = trim($_POST['icon'] ?? 'fa-solid fa-handshake');
        $sort_order = (int) ($_POST['sort_order'] ?? 0);
        $status = isset($_POST['status']) ? 1 : 0;

        if ($name === '') {
            $errors[] = 'Partner name is required.';
        }
        if ($icon === '') {
            $errors[] = 'Icon class is required.';
        }

        if (empty($errors)) {
            if (!empty($_POST['id'])) {
                $stmt = $db->prepare("UPDATE partners SET name=?, icon=?, sort_order=?, status=? WHERE id=?");
                $stmt->execute([$name, $icon, $sort_order, $status, (int) $_POST['id']]);
                $success = 'Partner updated successfully.';
            } else {
                $stmt = $db->prepare("INSERT INTO partners (name, icon, sort_order, status) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $icon, $sort_order, $status]);
                $success = 'Partner added successfully.';
            }
            $edit_mode = false;
            $edit_row = ['id' => '', 'name' => '', 'icon' => 'fa-solid fa-handshake', 'sort_order' => '0', 'status' => '1'];
        }
    }
}

$partners = $db->query("SELECT * FROM partners ORDER BY sort_order ASC, id ASC")->fetchAll();
?>

<style>
    .partner-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.25rem;
    }
    .partner-card {
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
    .partner-card:hover {
        background: var(--bg-card-hover);
        border-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    }
    .partner-card .pc-icon {
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
    .partner-card .pc-name {
        font-family: 'Cinzel', serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--gold);
        line-height: 1.2;
        margin-top: 0.5rem;
    }
    .partner-card .pc-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 0.6rem;
        font-size: 0.7rem;
    }
    .partner-card .pc-order {
        color: var(--text-dim);
        background: rgba(255, 255, 255, 0.04);
        padding: 0.15rem 0.5rem;
        border-radius: 4px;
    }
    .partner-card .pc-actions {
        margin-top: 1rem;
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        border-top: 1px solid var(--border);
        padding-top: 0.75rem;
    }
    .partner-card .pc-actions a {
        font-size: 0.75rem;
        padding: 0.3rem 0.75rem;
        border-radius: 6px;
    }
    .partner-card .pc-status {
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
    <h2><i class="fa-solid fa-<?= $edit_mode ? 'pen' : 'plus' ?>"></i> <?= $edit_mode ? 'Edit Partner' : 'Add New Partner' ?></h2>
    <form method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="save_partner">
        <?php if ($edit_mode): ?>
            <input type="hidden" name="id" value="<?= (int) $edit_row['id'] ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="name">Partner Name *</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($edit_row['name']) ?>" placeholder="e.g. Apex Hospital Group">
            </div>
            <div class="form-group">
                <label for="icon">Font Awesome Icon *</label>
                <input type="text" id="icon" name="icon" value="<?= htmlspecialchars($edit_row['icon']) ?>" placeholder="e.g. fa-solid fa-hospital">
                <div class="hint">Full class name (e.g. <code>fa-solid fa-hospital</code> or <code>fa-solid fa-hotel</code>)</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" value="<?= (int) $edit_row['sort_order'] ?>" placeholder="0">
            </div>
            <div class="form-group" style="display:flex; align-items:flex-end;">
                <div class="form-check" style="margin-bottom: 0.5rem;">
                    <input type="checkbox" id="status" name="status" value="1" <?= $edit_row['status'] ? 'checked' : '' ?> style="width:auto;">
                    <label for="status">Active</label>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:0.5rem;">
            <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> <?= $edit_mode ? 'Update' : 'Save' ?> Partner</button>
            <?php if ($edit_mode): ?>
                <a href="partners.php" class="btn btn-ghost"><i class="fa-solid fa-times"></i> Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Partners Grid -->
<?php if (empty($partners)): ?>
    <div class="empty-state">
        <i class="fa-solid fa-handshake"></i>
        <p>No partners yet. Add your first partner above.</p>
    </div>
<?php else: ?>
    <div class="partner-grid">
        <?php foreach ($partners as $p): ?>
            <div class="partner-card">
                <div class="pc-status">
                    <?php if ($p['status']): ?>
                        <span class="badge badge-read" style="background:rgba(34,197,94,0.12);color:var(--success);border:1px solid rgba(34,197,94,0.25);">Active</span>
                    <?php else: ?>
                        <span class="badge badge-read" style="color:var(--text-dim);">Inactive</span>
                    <?php endif; ?>
                </div>
                <div class="pc-icon"><i class="<?= htmlspecialchars($p['icon']) ?>"></i></div>
                <div class="pc-name"><?= htmlspecialchars($p['name']) ?></div>
                <div class="pc-meta">
                    <span class="pc-order"><i class="fa-solid fa-arrows-alt-v"></i> Order: <?= (int) $p['sort_order'] ?></span>
                </div>
                <div class="pc-actions">
                    <a href="partners.php?edit=<?= $p['id'] ?>" class="btn btn-ghost" style="padding:0.3rem 0.75rem;font-size:0.75rem;">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <a href="partners.php?delete=<?= $p['id'] ?>&csrf=<?= csrf_token() ?>"
                       class="btn btn-ghost"
                       style="padding:0.3rem 0.75rem;font-size:0.75rem;color:var(--danger);border-color:rgba(239,68,68,0.2);"
                       onclick="return confirm('Delete this partner?');">
                       <i class="fa-solid fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
