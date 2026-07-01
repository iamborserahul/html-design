<?php
$current_page = 'team';
$page_title = 'Team Members';
require_once __DIR__ . '/includes/header.php';

$upload_path = __DIR__ . '/uploads/team/';
$upload_url = 'uploads/team/';
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
            $bio = trim($_POST['bio'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $sort_order = (int)($_POST['sort_order'] ?? 0);
            $status = isset($_POST['status']) ? 1 : 0;

            if ($name === '') $errors[] = 'Name is required.';
            if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';

            $image = '';
            if ($action === 'update' && $id > 0) {
                $stmt = $db->prepare("SELECT image FROM team_members WHERE id = ?");
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
                        $stmt = $db->prepare("INSERT INTO team_members (name, designation, bio, image, email, phone, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$name, $designation, $bio, $image, $email, $phone, $sort_order, $status]);
                        $_SESSION['flash_success'] = 'Team member created successfully.';
                    } else {
                        $stmt = $db->prepare("UPDATE team_members SET name=?, designation=?, bio=?, image=?, email=?, phone=?, sort_order=?, status=? WHERE id=?");
                        $stmt->execute([$name, $designation, $bio, $image, $email, $phone, $sort_order, $status, $id]);
                        $_SESSION['flash_success'] = 'Team member updated successfully.';
                    }
                    header('Location: team.php');
                    exit;
                } catch (PDOException $e) {
                    $errors[] = 'Database error: ' . $e->getMessage();
                }
            }
        } elseif ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            $stmt = $db->prepare("SELECT image FROM team_members WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) {
                if ($row['image']) delete_image($row['image'], $upload_path);
                $db->prepare("DELETE FROM team_members WHERE id = ?")->execute([$id]);
                $_SESSION['flash_success'] = 'Team member deleted successfully.';
            } else {
                $_SESSION['flash_error'] = 'Team member not found.';
            }
            header('Location: team.php');
            exit;
        }
    }
}

$members = $db->query("SELECT * FROM team_members ORDER BY sort_order ASC, id DESC")->fetchAll();

$edit_row = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM team_members WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit_row = $stmt->fetch();
    if (!$edit_row) $errors[] = 'Team member not found.';
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
.form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
.form-check { display: flex; align-items: center; gap: 0.5rem; }
.form-check input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--gold); cursor: pointer; }
.form-check label { margin: 0; cursor: pointer; }

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

.alert { padding: 0.65rem 1rem; border-radius: 8px; font-size: 0.82rem; margin-bottom: 1rem; }
.alert-success { background: rgba(34,197,94,0.12); color: var(--success); border: 1px solid rgba(34,197,94,0.2); }
.alert-danger { background: rgba(239,68,68,0.12); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }

.form-section { margin-bottom: 1.5rem; }

.current-img { margin-top: 0.5rem; display: flex; align-items: center; gap: 0.75rem; }
.current-img img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border); }

/* Team Cards Grid */
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1.25rem;
}
.team-card {
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.75rem 1.25rem 1.25rem;
    text-align: center;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}
.team-card:hover {
    background: var(--bg-card-hover);
    border-color: rgba(255,255,255,0.1);
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
}
.team-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
    opacity: 0;
    transition: opacity 0.3s;
}
.team-card:hover::before { opacity: 1; }

.team-card .card-img-wrap {
    width: 88px; height: 88px;
    margin: 0 auto 1rem;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--border);
    transition: border-color 0.3s;
    background: var(--bg);
}
.team-card:hover .card-img-wrap { border-color: var(--gold-dim); }
.team-card .card-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}
.team-card .card-img-wrap .card-img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: var(--gold-dim);
    color: var(--gold);
    font-size: 1.5rem;
    font-weight: 700;
    font-family: 'Cinzel', serif;
}
.team-card .card-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.2rem;
}
.team-card .card-desig {
    font-size: 0.8rem;
    color: var(--gold);
    font-weight: 400;
    margin-bottom: 0.15rem;
}
.team-card .card-email,
.team-card .card-phone {
    font-size: 0.72rem;
    color: var(--text-dim);
    display: flex; align-items: center; justify-content: center;
    gap: 0.35rem;
    margin-top: 0.15rem;
}
.team-card .card-status {
    margin-top: 0.5rem;
}
.team-card .card-actions {
    margin-top: 0.75rem;
    display: flex; justify-content: center; gap: 0.5rem;
    opacity: 0.4;
    transition: opacity 0.25s;
}
.team-card:hover .card-actions { opacity: 1; }
.team-card .card-order {
    position: absolute;
    top: 0.6rem; right: 0.75rem;
    font-size: 0.65rem;
    color: var(--text-dim);
    background: rgba(255,255,255,0.04);
    padding: 0.15rem 0.5rem;
    border-radius: 4px;
}

@media (max-width: 768px) {
    .form-row, .form-row-3 { grid-template-columns: 1fr; }
    .team-grid { grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); }
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
        <i class="fa-solid fa-users"></i> Manage Team
    </h2>
    <a href="team.php?add=1" class="btn btn-gold">
        <i class="fa-solid fa-plus"></i> Add Member
    </a>
</div>

<?php if ($edit_row || isset($_GET['add'])): ?>
<div class="glass-card form-section">
    <h3 style="font-size:0.9rem;color:var(--gold);margin-bottom:1rem;">
        <?= $edit_row ? '<i class="fa-solid fa-pen"></i> Edit Team Member' : '<i class="fa-solid fa-plus"></i> Add Team Member' ?>
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

        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea id="bio" name="bio" class="form-control" rows="4"><?= htmlspecialchars($edit_row['bio'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($edit_row['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($edit_row['phone'] ?? '') ?>">
            </div>
        </div>

        <div class="form-row-3">
            <div class="form-group">
                <label for="image">Photo</label>
                <input type="file" id="image" name="image" class="form-control form-control-file" accept="image/*">
                <?php if ($edit_row && $edit_row['image']): ?>
                    <div class="current-img">
                        <img src="<?= $upload_url . htmlspecialchars($edit_row['image']) ?>" alt="">
                        <span class="fs-small text-dim"><?= htmlspecialchars($edit_row['image']) ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= (int)($edit_row['sort_order'] ?? 0) ?>" min="0">
            </div>
            <div class="form-check" style="margin-top:1.75rem;">
                <input type="checkbox" id="status" name="status" value="1" <?= !isset($edit_row) || $edit_row['status'] ? 'checked' : '' ?>>
                <label for="status">Active</label>
            </div>
        </div>

        <div class="d-flex gap-1" style="margin-top:0.5rem;">
            <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> <?= $edit_row ? 'Update' : 'Create' ?></button>
            <a href="team.php" class="btn btn-ghost"><i class="fa-solid fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
<?php endif; ?>

<div class="team-grid">
    <?php if (empty($members)): ?>
        <div class="glass-card" style="grid-column:1/-1;text-align:center;padding:3rem;">
            <p class="text-dim">No team members yet. <a href="?add=1">Add one</a>.</p>
        </div>
    <?php else: ?>
        <?php foreach ($members as $m): ?>
            <div class="team-card">
                <div class="card-order">#<?= $m['sort_order'] ?></div>
                <div class="card-img-wrap">
                    <?php if ($m['image']): ?>
                        <img src="<?= $upload_url . htmlspecialchars($m['image']) ?>" alt="<?= htmlspecialchars($m['name']) ?>">
                    <?php else: ?>
                        <div class="card-img-placeholder"><?= strtoupper(substr($m['name'], 0, 1)) ?></div>
                    <?php endif; ?>
                </div>
                <div class="card-name"><?= htmlspecialchars($m['name']) ?></div>
                <div class="card-desig"><?= htmlspecialchars($m['designation'] ?? '') ?></div>
                <?php if ($m['email']): ?>
                    <div class="card-email"><i class="fa-regular fa-envelope"></i> <?= htmlspecialchars($m['email']) ?></div>
                <?php endif; ?>
                <?php if ($m['phone']): ?>
                    <div class="card-phone"><i class="fa-solid fa-phone"></i> <?= htmlspecialchars($m['phone']) ?></div>
                <?php endif; ?>
                <div class="card-status">
                    <?php if ($m['status']): ?>
                        <span class="badge badge-unread">Active</span>
                    <?php else: ?>
                        <span class="badge badge-read">Inactive</span>
                    <?php endif; ?>
                </div>
                <div class="card-actions">
                    <a href="?edit=<?= $m['id'] ?>" class="btn-icon edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                    <form method="post" style="display:inline;" onsubmit="return confirm('Delete this team member?');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $m['id'] ?>">
                        <button type="submit" class="btn-icon delete" title="Delete"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
