<?php
$current_page = 'testimonials';
$page_title = 'Testimonials';
require_once __DIR__ . '/includes/header.php';

$upload_path = __DIR__ . '/uploads/testimonials/';
$upload_url = 'uploads/testimonials/';
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
            $name = trim($_POST['name'] ?? '');
            $designation = trim($_POST['designation'] ?? '');
            $company = trim($_POST['company'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $rating = min(5, max(1, (int)($_POST['rating'] ?? 5)));
            $sort_order = (int)($_POST['sort_order'] ?? 0);
            $status = isset($_POST['status']) ? 1 : 0;

            if ($name === '') $errors[] = 'Name is required.';
            if ($content === '') $errors[] = 'Content (testimonial text) is required.';

            $image = '';
            if ($action === 'update' && $id > 0) {
                $stmt = $db->prepare("SELECT image FROM testimonials WHERE id = ?");
                $stmt->execute([$id]);
                $existing = $stmt->fetch();
                $image = $existing ? $existing['image'] : '';
            }

            if (!empty($_FILES['image']['name'])) {
                $uploaded = upload_image($_FILES['image'], $upload_path);
                if ($uploaded) {
                    if ($image) delete_image($image, $upload_path);
                    $image = $uploaded;
                } else {
                    $errors[] = 'Image upload failed. Allowed: jpg, jpeg, png, gif, webp, svg.';
                }
            }

            if (empty($errors)) {
                try {
                    if ($action === 'create') {
                        $stmt = $db->prepare("INSERT INTO testimonials (name, designation, company, content, image, rating, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$name, $designation, $company, $content, $image, $rating, $sort_order, $status]);
                        $_SESSION['flash_success'] = 'Testimonial created successfully.';
                    } else {
                        $stmt = $db->prepare("UPDATE testimonials SET name=?, designation=?, company=?, content=?, image=?, rating=?, sort_order=?, status=? WHERE id=?");
                        $stmt->execute([$name, $designation, $company, $content, $image, $rating, $sort_order, $status, $id]);
                        $_SESSION['flash_success'] = 'Testimonial updated successfully.';
                    }
                    header('Location: testimonials.php');
                    exit;
                } catch (PDOException $e) {
                    $errors[] = 'Database error: ' . $e->getMessage();
                }
            }
        } elseif ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            $stmt = $db->prepare("SELECT image FROM testimonials WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) {
                if ($row['image']) delete_image($row['image'], $upload_path);
                $db->prepare("DELETE FROM testimonials WHERE id = ?")->execute([$id]);
                $_SESSION['flash_success'] = 'Testimonial deleted successfully.';
            } else {
                $_SESSION['flash_error'] = 'Testimonial not found.';
            }
            header('Location: testimonials.php');
            exit;
        }
    }
}

$testimonials = $db->query("SELECT * FROM testimonials ORDER BY sort_order ASC, id DESC")->fetchAll();

$edit_row = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM testimonials WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit_row = $stmt->fetch();
    if (!$edit_row) {
        $errors[] = 'Testimonial not found.';
    }
}
?>

<style>
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.8rem; font-weight: 500; color: var(--text-dim); margin-bottom: 0.35rem; }
.form-control {
    width: 100%;
    padding: 0.55rem 0.75rem;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--border);
    border-radius: 6px;
    color: var(--text);
    font-size: 0.85rem;
    font-family: inherit;
    transition: border-color 0.2s;
}
.form-control:focus { outline: none; border-color: var(--gold); }
.form-control::placeholder { color: rgba(232,230,227,0.3); }
textarea.form-control { resize: vertical; min-height: 100px; }
select.form-control { cursor: pointer; }
.form-control-file { font-size: 0.8rem; color: var(--text-dim); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.form-check { display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem; }
.form-check input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--gold); cursor: pointer; }
.form-check label { margin: 0; cursor: pointer; }

.avatar-thumb { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); background: var(--bg-card); }
.avatar-empty { width: 40px; height: 40px; border-radius: 50%; background: var(--gold-dim); color: var(--gold); display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 600; }
.stars-display { color: var(--gold); font-size: 0.8rem; letter-spacing: 1px; white-space: nowrap; }
.stars-display .star-empty { color: rgba(255,255,255,0.15); }

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

.content-col { max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.content-col p { margin: 0; }

.form-section { margin-bottom: 1.5rem; }
.current-img { margin-top: 0.5rem; display: flex; align-items: center; gap: 0.75rem; }
.current-img img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border); }

@media (max-width: 768px) {
    .form-row { grid-template-columns: 1fr; }
}
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
        <i class="fa-solid fa-star"></i> Manage Testimonials
    </h2>
    <a href="testimonials.php" class="btn btn-gold <?= !$edit_row ? '' : '' ?>">
        <i class="fa-solid fa-plus"></i> Add New
    </a>
</div>

<?php if ($edit_row || isset($_GET['add'])): ?>
<div class="glass-card form-section">
    <h3 style="font-size:0.9rem;color:var(--gold);margin-bottom:1rem;">
        <?= $edit_row ? '<i class="fa-solid fa-pen"></i> Edit Testimonial' : '<i class="fa-solid fa-plus"></i> Add Testimonial' ?>
    </h3>
    <form method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="<?= $edit_row ? 'update' : 'create' ?>">
        <?php if ($edit_row): ?>
            <input type="hidden" name="id" value="<?= $edit_row['id'] ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($edit_row['name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" id="designation" name="designation" class="form-control" value="<?= htmlspecialchars($edit_row['designation'] ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="company">Company</label>
                <input type="text" id="company" name="company" class="form-control" value="<?= htmlspecialchars($edit_row['company'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="rating">Rating</label>
                <select id="rating" name="rating" class="form-control">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>" <?= ($edit_row['rating'] ?? 5) == $i ? 'selected' : '' ?>>
                            <?= str_repeat('★', $i) . str_repeat('☆', 5 - $i) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="content">Testimonial Content *</label>
            <textarea id="content" name="content" class="form-control" rows="4" required><?= htmlspecialchars($edit_row['content'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="image">Avatar Image</label>
                <input type="file" id="image" name="image" class="form-control form-control-file" accept="image/*">
                <?php if ($edit_row && $edit_row['image']): ?>
                    <div class="current-img">
                        <img src="<?= $upload_url . htmlspecialchars($edit_row['image']) ?>" alt="">
                        <span class="fs-small text-dim"><?= htmlspecialchars($edit_row['image']) ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <div class="form-row" style="grid-template-columns:1fr 1fr;">
                    <div class="form-group">
                        <label for="sort_order">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= (int)($edit_row['sort_order'] ?? 0) ?>" min="0">
                    </div>
                    <div class="form-check" style="margin-top:1.75rem;">
                        <input type="checkbox" id="status" name="status" value="1" <?= !isset($edit_row) || $edit_row['status'] ? 'checked' : '' ?>>
                        <label for="status">Active</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-1" style="margin-top:0.5rem;">
            <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> <?= $edit_row ? 'Update' : 'Create' ?></button>
            <a href="testimonials.php" class="btn btn-ghost"><i class="fa-solid fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
<?php endif; ?>

<div class="glass-card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:50px;">Image</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Company</th>
                    <th>Content</th>
                    <th style="width:100px;">Rating</th>
                    <th style="width:60px;">Order</th>
                    <th style="width:60px;">Status</th>
                    <th style="width:80px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($testimonials)): ?>
                    <tr><td colspan="9" class="text-dim fs-small" style="text-align:center;padding:2rem;">No testimonials found. <a href="?add=1">Add one</a>.</td></tr>
                <?php else: ?>
                    <?php foreach ($testimonials as $t): ?>
                        <tr>
                            <td>
                                <?php if ($t['image']): ?>
                                    <img src="<?= $upload_url . htmlspecialchars($t['image']) ?>" alt="" class="avatar-thumb">
                                <?php else: ?>
                                    <span class="avatar-empty"><?= strtoupper(substr($t['name'], 0, 1)) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-500"><?= htmlspecialchars($t['name']) ?></td>
                            <td class="text-dim"><?= htmlspecialchars($t['designation'] ?? '') ?></td>
                            <td class="text-dim"><?= htmlspecialchars($t['company'] ?? '') ?></td>
                            <td><div class="content-col"><?= htmlspecialchars(truncate($t['content'], 80)) ?></div></td>
                            <td>
                                <div class="stars-display">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="<?= $i <= $t['rating'] ? 'fa-solid fa-star' : 'fa-regular fa-star star-empty' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </td>
                            <td class="text-dim"><?= $t['sort_order'] ?></td>
                            <td>
                                <?php if ($t['status']): ?>
                                    <span class="badge badge-unread">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-read">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="?edit=<?= $t['id'] ?>" class="btn-icon edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <form method="post" style="display:inline;" onsubmit="return confirm('Delete this testimonial?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                        <button type="submit" class="btn-icon delete" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
