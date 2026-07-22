<?php
$current_page = 'brochures';
$page_title = 'Category Brochures';
require_once __DIR__ . '/includes/header.php';

$upload_path = __DIR__ . '/../uploads/brochures/';
if (!is_dir($upload_path)) {
    mkdir($upload_path, 0777, true);
}
$upload_url = '../uploads/brochures/';
$errors = [];
$success = $_SESSION['flash_success'] ?? '';
$error = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_success'], $_SESSION['flash_error']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verify_csrf($_POST['csrf_token'])) {
        $errors[] = 'Invalid security token. Please try again.';
    } else {
        $action = $_POST['action'] ?? '';

        if (in_array($action, ['create', 'update'])) {
            $id = $action === 'update' ? (int)($_POST['id'] ?? 0) : 0;
            $category_id = (int)($_POST['category_id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $bg_color = trim($_POST['bg_color'] ?? '#FFC229');
            $sort_order = (int)($_POST['sort_order'] ?? 0);

            if ($category_id <= 0) $errors[] = 'Category is required.';
            if ($name === '') $errors[] = 'Brochure name is required.';

            $file_path = '';
            if ($action === 'update' && $id > 0) {
                $stmt = $db->prepare("SELECT file_path FROM category_brochures WHERE id = ?");
                $stmt->execute([$id]);
                $existing = $stmt->fetch();
                $file_path = $existing ? $existing['file_path'] : '';
            }

            if (!empty($_FILES['file_path']['name'])) {
                $file = $_FILES['file_path'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if ($ext !== 'pdf') {
                    $errors[] = 'Only PDF files are allowed.';
                } else {
                    $new_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9.-]/', '_', $file['name']);
                    if (move_uploaded_file($file['tmp_name'], $upload_path . $new_name)) {
                        if ($file_path && file_exists($upload_path . $file_path)) {
                            unlink($upload_path . $file_path);
                        }
                        $file_path = $new_name;
                    } else {
                        $errors[] = 'Failed to upload PDF file.';
                    }
                }
            }

            if ($action === 'create' && empty($file_path)) {
                $errors[] = 'PDF file is required for new brochures.';
            }

            if (empty($errors)) {
                try {
                    if ($action === 'create') {
                        $stmt = $db->prepare("INSERT INTO category_brochures (category_id, name, file_path, bg_color, sort_order) VALUES (?, ?, ?, ?, ?)");
                        $stmt->execute([$category_id, $name, $file_path, $bg_color, $sort_order]);
                        $_SESSION['flash_success'] = 'Brochure added successfully.';
                    } else {
                        $stmt = $db->prepare("UPDATE category_brochures SET category_id=?, name=?, file_path=?, bg_color=?, sort_order=? WHERE id=?");
                        $stmt->execute([$category_id, $name, $file_path, $bg_color, $sort_order, $id]);
                        $_SESSION['flash_success'] = 'Brochure updated successfully.';
                    }
                    header('Location: brochures.php');
                    exit;
                } catch (PDOException $e) {
                    $errors[] = 'Database error: ' . $e->getMessage();
                }
            }
        } elseif ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            $stmt = $db->prepare("SELECT file_path FROM category_brochures WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) {
                if ($row['file_path'] && file_exists($upload_path . $row['file_path'])) {
                    unlink($upload_path . $row['file_path']);
                }
                $db->prepare("DELETE FROM category_brochures WHERE id = ?")->execute([$id]);
                $_SESSION['flash_success'] = 'Brochure deleted successfully.';
            } else {
                $_SESSION['flash_error'] = 'Brochure not found.';
            }
            header('Location: brochures.php');
            exit;
        }
    }
}

$brochures = $db->query("SELECT cb.*, pc.name as category_name 
                         FROM category_brochures cb 
                         JOIN product_categories pc ON cb.category_id = pc.id 
                         ORDER BY pc.name ASC, cb.sort_order ASC, cb.id DESC")->fetchAll();

$categories = $db->query("SELECT id, name FROM product_categories ORDER BY name ASC")->fetchAll();

$edit_row = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM category_brochures WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit_row = $stmt->fetch();
    if (!$edit_row) {
        $errors[] = 'Brochure not found.';
    }
}
?>

<style>
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.8rem; font-weight: 500; color: var(--text-dim); margin-bottom: 0.35rem; }
.form-control {
    width: 100%; padding: 0.55rem 0.75rem; background: rgba(255,255,255,0.05);
    border: 1px solid var(--border); border-radius: 6px; color: var(--text);
    font-size: 0.85rem; font-family: inherit; transition: border-color 0.2s;
}
.form-control:focus { outline: none; border-color: var(--gold); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.btn-icon {
    display: inline-flex; align-items: center; justify-content: center;
    width: 32px; height: 32px; border-radius: 6px;
    background: var(--bg-card); border: 1px solid var(--border);
    color: var(--text-dim); cursor: pointer; font-size: 0.8rem;
    transition: all 0.2s; text-decoration: none;
}
.btn-icon:hover { background: var(--bg-card-hover); color: var(--text); }
.btn-icon.edit:hover { border-color: var(--gold); color: var(--gold); }
.btn-icon.delete:hover { border-color: var(--danger); color: var(--danger); }
.actions { display: flex; gap: 0.4rem; }
.alert { padding: 0.65rem 1rem; border-radius: 8px; font-size: 0.82rem; margin-bottom: 1rem; }
.alert-success { background: rgba(34,197,94,0.12); color: var(--success); border: 1px solid rgba(34,197,94,0.2); }
.alert-danger { background: rgba(239,68,68,0.12); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
.color-preview { display: inline-block; width: 16px; height: 16px; border-radius: 4px; border: 1px solid var(--border); vertical-align: middle; margin-right: 5px; }
</style>

<?php if ($success): ?>
    <div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-danger"><i class="fa-solid fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <i class="fa-solid fa-exclamation-circle"></i> 
        <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="d-flex align-center justify-between mb-2">
    <h2 style="font-family:'Cinzel',serif;font-size:0.95rem;color:var(--gold);">
        <i class="fa-solid fa-file-pdf"></i> Manage Category Brochures
    </h2>
    <a href="?add=1" class="btn btn-gold <?= !$edit_row ? '' : '' ?>">
        <i class="fa-solid fa-plus"></i> Add New
    </a>
</div>

<?php if ($edit_row || isset($_GET['add'])): ?>
<div class="glass-card form-section mb-2">
    <h3 style="font-size:0.9rem;color:var(--gold);margin-bottom:1rem;">
        <?= $edit_row ? '<i class="fa-solid fa-pen"></i> Edit Brochure' : '<i class="fa-solid fa-plus"></i> Add Brochure' ?>
    </h3>
    <form method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="<?= $edit_row ? 'update' : 'create' ?>">
        <?php if ($edit_row): ?>
            <input type="hidden" name="id" value="<?= $edit_row['id'] ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">-- Select Category --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($edit_row['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Brochure Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($edit_row['name'] ?? '') ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="file_path">PDF File <?= $edit_row ? '' : '*' ?></label>
                <input type="file" id="file_path" name="file_path" class="form-control" accept=".pdf" <?= $edit_row ? '' : 'required' ?>>
                <?php if ($edit_row && $edit_row['file_path']): ?>
                    <div style="margin-top:0.5rem;font-size:0.8rem;color:var(--text-dim);">
                        Current file: <a href="<?= $upload_url . htmlspecialchars($edit_row['file_path']) ?>" target="_blank"><?= htmlspecialchars($edit_row['file_path']) ?></a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-row" style="grid-template-columns:1fr 1fr;">
                <div class="form-group">
                    <label for="bg_color">Button Color</label>
                    <input type="color" id="bg_color" name="bg_color" class="form-control" value="<?= htmlspecialchars($edit_row['bg_color'] ?? '#FFC229') ?>" style="padding: 2px 4px; height: 35px;">
                </div>
                <div class="form-group">
                    <label for="sort_order">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= (int)($edit_row['sort_order'] ?? 0) ?>" min="0">
                </div>
            </div>
        </div>

        <div class="d-flex gap-1" style="margin-top:0.5rem;">
            <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> <?= $edit_row ? 'Update' : 'Create' ?></button>
            <a href="?" class="btn btn-ghost"><i class="fa-solid fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
<?php endif; ?>

<div class="glass-card">
    <?php if (empty($brochures)): ?>
        <div style="padding:2rem;text-align:center;color:var(--text-dim);">
            <i class="fa-solid fa-file-pdf" style="font-size:2rem;margin-bottom:1rem;opacity:0.5;"></i>
            <p>No brochures found. Click "Add New" to upload a PDF brochure.</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:25%">Category</th>
                        <th style="width:35%">Brochure Name</th>
                        <th style="width:15%">Color</th>
                        <th style="width:10%;text-align:center;">Sort</th>
                        <th style="width:15%;text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($brochures as $brochure): ?>
                        <tr>
                            <td><?= htmlspecialchars($brochure['category_name']) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($brochure['name']) ?></strong><br>
                                <a href="<?= $upload_url . htmlspecialchars($brochure['file_path']) ?>" target="_blank" style="font-size:0.75rem;"><i class="fa-solid fa-link"></i> View PDF</a>
                            </td>
                            <td>
                                <span class="color-preview" style="background-color: <?= htmlspecialchars($brochure['bg_color']) ?>;"></span>
                                <span style="font-size:0.8rem;"><?= htmlspecialchars($brochure['bg_color']) ?></span>
                            </td>
                            <td style="text-align:center;"><?= $brochure['sort_order'] ?></td>
                            <td style="text-align:right;">
                                <div class="actions justify-content-end">
                                    <a href="?edit=<?= $brochure['id'] ?>" class="btn-icon edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <form method="post" style="display:inline;" onsubmit="return confirm('Delete this brochure?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $brochure['id'] ?>">
                                        <button type="submit" class="btn-icon delete" title="Delete"><i class="fa-solid fa-trash"></i></button>
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

<?php require_once __DIR__ . '/includes/footer.php'; ?>
