<?php
$current_page = 'about-sections';
$page_title = 'Mission / Vision / Values';
require_once __DIR__ . '/includes/header.php';

$errors = [];
$success = $_SESSION['flash_success'] ?? '';
$error   = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_success'], $_SESSION['flash_error']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } else {
        $action = $_POST['action'] ?? '';

        if (in_array($action, ['create', 'update'])) {
            $id         = $action === 'update' ? (int)($_POST['id'] ?? 0) : 0;
            $type       = trim($_POST['type'] ?? 'mission');
            $icon       = trim($_POST['icon'] ?? 'fa-bullseye');
            $title      = trim($_POST['title'] ?? '');
            $content    = trim($_POST['content'] ?? '');
            $sort_order = (int)($_POST['sort_order'] ?? 0);
            $status     = isset($_POST['status']) ? 1 : 0;

            if ($title === '') $errors[] = 'Title is required.';

            if (empty($errors)) {
                try {
                    if ($action === 'create') {
                        $stmt = $db->prepare("INSERT INTO about_sections (type, icon, title, content, sort_order, status) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$type, $icon, $title, $content, $sort_order, $status]);
                        $_SESSION['flash_success'] = 'Section created successfully.';
                    } else {
                        $stmt = $db->prepare("UPDATE about_sections SET type=?, icon=?, title=?, content=?, sort_order=?, status=? WHERE id=?");
                        $stmt->execute([$type, $icon, $title, $content, $sort_order, $status, $id]);
                        $_SESSION['flash_success'] = 'Section updated successfully.';
                    }
                    header('Location: about-sections.php');
                    exit;
                } catch (PDOException $e) {
                    $errors[] = 'Database error: ' . $e->getMessage();
                }
            }
        } elseif ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            $db->prepare("DELETE FROM about_sections WHERE id = ?")->execute([$id]);
            $_SESSION['flash_success'] = 'Section deleted.';
            header('Location: about-sections.php');
            exit;
        }
    }
}

$rows = $db->query("SELECT * FROM about_sections ORDER BY sort_order ASC, id ASC")->fetchAll();

$edit_row = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM about_sections WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit_row = $stmt->fetch();
}

$type_options = [
    'mission' => 'Our Mission',
    'vision'  => 'Our Vision',
    'values'  => 'What We Stand For',
];
?>
<style>
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.8rem; font-weight: 500; color: var(--text-dim); margin-bottom: 0.35rem; }
.form-control { width: 100%; padding: 0.55rem 0.75rem; background: rgba(255,255,255,0.05); border: 1px solid var(--border); border-radius: 6px; color: var(--text); font-size: 0.85rem; font-family: inherit; transition: border-color 0.2s; }
.form-control:focus { outline: none; border-color: var(--gold); }
.form-control::placeholder { color: rgba(232,230,227,0.3); }
textarea.form-control { resize: vertical; min-height: 120px; }
select.form-control { cursor: pointer; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
.form-check { display: flex; align-items: center; gap: 0.5rem; }
.form-check input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--gold); cursor: pointer; }
.btn-icon { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 6px; background: var(--bg-card); border: 1px solid var(--border); color: var(--text-dim); cursor: pointer; font-size: 0.8rem; transition: all 0.2s; text-decoration: none; }
.btn-icon:hover { background: var(--bg-card-hover); color: var(--text); }
.btn-icon.edit:hover { border-color: var(--gold); color: var(--gold); }
.btn-icon.delete:hover { border-color: var(--danger); color: var(--danger); }
.alert { padding: 0.65rem 1rem; border-radius: 8px; font-size: 0.82rem; margin-bottom: 1rem; }
.alert-success { background: rgba(34,197,94,0.12); color: var(--success); border: 1px solid rgba(34,197,94,0.2); }
.alert-danger { background: rgba(239,68,68,0.12); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
.sections-table { width: 100%; border-collapse: collapse; }
.sections-table th, .sections-table td { padding: 0.7rem 1rem; text-align: left; border-bottom: 1px solid var(--border); font-size: 0.83rem; }
.sections-table th { color: var(--text-dim); font-weight: 500; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
.sections-table tr:hover td { background: rgba(255,255,255,0.02); }
.type-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; background: rgba(255,194,41,0.1); color: var(--gold); }
</style>

<?php if ($success): ?>
    <div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-danger"><i class="fa-solid fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="d-flex align-center justify-between mb-2">
    <h2 style="font-family:'Cinzel',serif;font-size:0.95rem;color:var(--gold);">
        <i class="fa-solid fa-bullseye"></i> Mission / Vision / Values
    </h2>
    <a href="about-sections.php?add=1" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Add Section</a>
</div>

<?php if ($edit_row || isset($_GET['add'])): ?>
<div class="glass-card" style="margin-bottom:1.5rem;padding:1.5rem;">
    <h3 style="font-size:0.9rem;color:var(--gold);margin-bottom:1rem;">
        <?= $edit_row ? '<i class="fa-solid fa-pen"></i> Edit Section' : '<i class="fa-solid fa-plus"></i> Add Section' ?>
    </h3>
    <form method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="<?= $edit_row ? 'update' : 'create' ?>">
        <?php if ($edit_row): ?>
            <input type="hidden" name="id" value="<?= $edit_row['id'] ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label>Section Type</label>
                <select name="type" class="form-control">
                    <?php foreach ($type_options as $val => $label): ?>
                        <option value="<?= $val ?>" <?= ($edit_row['type'] ?? 'mission') === $val ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Font Awesome Icon Class (e.g. fa-bullseye)</label>
                <input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($edit_row['icon'] ?? 'fa-bullseye') ?>" placeholder="fa-bullseye">
            </div>
        </div>

        <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($edit_row['title'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Content (use new lines or HTML &lt;li&gt; for bullet points)</label>
            <textarea name="content" class="form-control" rows="6"><?= htmlspecialchars($edit_row['content'] ?? '') ?></textarea>
            <div style="font-size:0.7rem;color:var(--text-dim);margin-top:0.25rem;">For "Values": write each item on a new line. For Mission/Vision: write a paragraph.</div>
        </div>

        <div class="form-row-3">
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="<?= (int)($edit_row['sort_order'] ?? 0) ?>" min="0">
            </div>
            <div class="form-check" style="margin-top:1.75rem;">
                <input type="checkbox" id="status" name="status" value="1" <?= !isset($edit_row) || $edit_row['status'] ? 'checked' : '' ?>>
                <label for="status">Active</label>
            </div>
        </div>

        <div class="d-flex gap-1" style="margin-top:0.5rem;">
            <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> <?= $edit_row ? 'Update' : 'Create' ?></button>
            <a href="about-sections.php" class="btn btn-ghost"><i class="fa-solid fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
<?php endif; ?>

<div class="glass-card" style="padding:0;overflow:hidden;">
    <?php if (empty($rows)): ?>
        <div style="padding:3rem;text-align:center;color:var(--text-dim);">
            No sections yet. <a href="?add=1" style="color:var(--gold);">Add one</a>.
        </div>
    <?php else: ?>
    <table class="sections-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Icon</th>
                <th>Title</th>
                <th>Order</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><span class="type-badge"><?= htmlspecialchars($type_options[$r['type']] ?? $r['type']) ?></span></td>
                <td><i class="fa-solid <?= htmlspecialchars($r['icon']) ?>"></i> <small><?= htmlspecialchars($r['icon']) ?></small></td>
                <td><?= htmlspecialchars($r['title']) ?></td>
                <td><?= $r['sort_order'] ?></td>
                <td><?= $r['status'] ? '<span class="badge badge-unread">Active</span>' : '<span class="badge badge-read">Inactive</span>' ?></td>
                <td>
                    <a href="?edit=<?= $r['id'] ?>" class="btn-icon edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                    <form method="post" style="display:inline;" onsubmit="return confirm('Delete this section?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <button type="submit" class="btn-icon delete" title="Delete"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
