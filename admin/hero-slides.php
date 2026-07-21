<?php
$current_page = 'hero-slides';
$page_title = 'Hero Slides';
require_once __DIR__ . '/includes/header.php';

$errors = [];
$success = '';

$upload_path = SLIDER_PATH;
if (!is_dir($upload_path)) {
    mkdir($upload_path, 0755, true);
}

$action = $_GET['action'] ?? 'list';
$edit_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verify_csrf($_POST['csrf_token'])) {
        $errors[] = 'Invalid security token.';
    } else {
        $title = trim($_POST['title'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $button_text = trim($_POST['button_text'] ?? '');
        $button_link = trim($_POST['button_link'] ?? '');
        $sort_order = (int) ($_POST['sort_order'] ?? 0);
        $status = isset($_POST['status']) ? 1 : 0;
        $slide_id = (int) ($_POST['slide_id'] ?? 0);

        if ($title === '') {
            $errors[] = 'Title is required.';
        }

        if (empty($errors)) {
            $image_filename = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploaded = upload_image($_FILES['image'], $upload_path);
                if ($uploaded === false) {
                    $errors[] = 'Image upload failed. Allowed: jpg, jpeg, png, gif, webp, svg.';
                } else {
                    $image_filename = $uploaded;
                }
            }

            if (empty($errors)) {
                try {
                    if ($slide_id > 0) {
                        // Update existing
                        if ($image_filename) {
                            // Delete old image
                            $stmt = $db->prepare("SELECT image FROM hero_slides WHERE id = ?");
                            $stmt->execute([$slide_id]);
                            $old = $stmt->fetch();
                            if ($old && $old['image']) {
                                delete_image($old['image'], $upload_path);
                            }
                            $stmt = $db->prepare("UPDATE hero_slides SET title=?, subtitle=?, description=?, image=?, btn_text=?, btn_link=?, sort_order=?, status=? WHERE id=?");
                            $stmt->execute([$title, $subtitle, $description, $image_filename, $button_text, $button_link, $sort_order, $status, $slide_id]);
                        } else {
                            $stmt = $db->prepare("UPDATE hero_slides SET title=?, subtitle=?, description=?, btn_text=?, btn_link=?, sort_order=?, status=? WHERE id=?");
                            $stmt->execute([$title, $subtitle, $description, $button_text, $button_link, $sort_order, $status, $slide_id]);
                        }
                        $success = 'Slide updated successfully.';
                    } else {
                        // Insert new
                        if (!$image_filename) {
                            $errors[] = 'Image is required.';
                        } else {
                            $stmt = $db->prepare("INSERT INTO hero_slides (title, subtitle, description, image, btn_text, btn_link, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmt->execute([$title, $subtitle, $description, $image_filename, $button_text, $button_link, $sort_order, $status]);
                            $success = 'Slide created successfully.';
                            $_POST = []; // clear form
                        }
                    }
                } catch (PDOException $e) {
                    $errors[] = 'Database error: ' . $e->getMessage();
                }
            }
        }
    }
}

// Handle delete
if (isset($_GET['delete']) && isset($_GET['csrf_token'])) {
    if (verify_csrf($_GET['csrf_token'])) {
        $id = (int) $_GET['delete'];
        try {
            $stmt = $db->prepare("SELECT image FROM hero_slides WHERE id = ?");
            $stmt->execute([$id]);
            $slide = $stmt->fetch();
            if ($slide) {
                if ($slide['image']) {
                    delete_image($slide['image'], $upload_path);
                }
                $stmt = $db->prepare("DELETE FROM hero_slides WHERE id = ?");
                $stmt->execute([$id]);
                $success = 'Slide deleted successfully.';
            }
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    } else {
        $errors[] = 'Invalid security token.';
    }
    // Redirect to clean URL
    header('Location: hero-slides.php?msg=' . urlencode($success ?: ''));
    exit;
}

// Handle reorder (move up/down)
if (isset($_GET['move']) && isset($_GET['dir']) && isset($_GET['csrf_token'])) {
    if (verify_csrf($_GET['csrf_token'])) {
        $id = (int) $_GET['move'];
        $dir = $_GET['dir'] === 'up' ? 'up' : 'down';
        try {
            $stmt = $db->prepare("SELECT id, sort_order FROM hero_slides WHERE id = ?");
            $stmt->execute([$id]);
            $current = $stmt->fetch();
            if ($current) {
                $current_order = (int) $current['sort_order'];
                if ($dir === 'up') {
                    $stmt = $db->prepare("SELECT id, sort_order FROM hero_slides WHERE sort_order < ? ORDER BY sort_order DESC LIMIT 1");
                } else {
                    $stmt = $db->prepare("SELECT id, sort_order FROM hero_slides WHERE sort_order > ? ORDER BY sort_order ASC LIMIT 1");
                }
                $stmt->execute([$current_order]);
                $swap = $stmt->fetch();
                if ($swap) {
                    $db->prepare("UPDATE hero_slides SET sort_order = ? WHERE id = ?")->execute([$swap['sort_order'], $current['id']]);
                    $db->prepare("UPDATE hero_slides SET sort_order = ? WHERE id = ?")->execute([$current_order, $swap['id']]);
                    $success = 'Reordered successfully.';
                }
            }
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    } else {
        $errors[] = 'Invalid security token.';
    }
    header('Location: hero-slides.php?msg=' . urlencode($success ?: ''));
    exit;
}

// Fetch data for editing
$edit_slide = null;
if ($action === 'edit' && $edit_id > 0) {
    $stmt = $db->prepare("SELECT * FROM hero_slides WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_slide = $stmt->fetch();
    if (!$edit_slide) {
        $action = 'list';
    }
}

// Fetch all slides
$slides = $db->query("SELECT * FROM hero_slides ORDER BY sort_order ASC, id ASC")->fetchAll();

// Handle msg on redirect
if (isset($_GET['msg']) && $_GET['msg'] !== '') {
    $success = htmlspecialchars($_GET['msg']);
}

// Stats for UI cards
$hero_stats = [];
try {
    $hero_stats['total'] = (int) $db->query("SELECT COUNT(*) FROM hero_slides")->fetchColumn();
    $hero_stats['active'] = (int) $db->query("SELECT COUNT(*) FROM hero_slides WHERE status = 1")->fetchColumn();
    $hero_stats['inactive'] = (int) $db->query("SELECT COUNT(*) FROM hero_slides WHERE status = 0")->fetchColumn();
} catch (PDOException $e) {
    $hero_stats = ['total' => 0, 'active' => 0, 'inactive' => 0];
}
?>
<style>
.hero-page { max-width: 1400px; }
.hero-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 24px; }
.hero-stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px 20px; display: flex; align-items: center; gap: 16px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.hero-stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); border-color: var(--border-light); }
.hero-stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.hero-stat-icon.gold { background: var(--gold-dim); color: var(--gold); }
.hero-stat-icon.green { background: rgba(22,163,74,0.1); color: #16a34a; }
.hero-stat-icon.red { background: rgba(220,38,38,0.1); color: #dc2626; }
.hero-stat-info .hero-stat-num { font-size: 24px; font-weight: 700; line-height: 1.2; color: var(--text-primary); }
.hero-stat-info .hero-stat-label { font-size: 13px; color: var(--text-dim); }
.table-container { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.table-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 12px; }
.table-header h3 { font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.table-scroll { overflow-x: auto; }
table.hero-table { width: 100%; border-collapse: collapse; font-size: 14px; }
table.hero-table thead th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); border-bottom: 1px solid var(--border); background: var(--bg-card-hover); white-space: nowrap; }
table.hero-table tbody td { padding: 14px 16px; border-bottom: 1px solid var(--border); vertical-align: middle; }
table.hero-table tbody tr:last-child td { border-bottom: none; }
table.hero-table tbody tr { transition: background 0.15s; }
table.hero-table tbody tr:hover td { background: var(--gold-dim); }
.hero-thumb { width: 64px; height: 44px; border-radius: 6px; object-fit: cover; background: var(--bg-input); display: block; }
.hero-thumb-placeholder { width: 64px; height: 44px; border-radius: 6px; background: var(--bg-input); display: flex; align-items: center; justify-content: center; font-size: 16px; color: var(--text-muted); }
.hero-title-cell { font-weight: 600; color: var(--text-primary); }
.hero-subtitle { max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-dim); font-size: 13px; }
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; white-space: nowrap; }
.badge-gold { background: var(--gold-dim); color: var(--gold); }
.badge-success { background: rgba(22,163,74,0.1); color: #16a34a; }
.badge-danger { background: rgba(220,38,38,0.1); color: #dc2626; }
.action-group { display: flex; gap: 4px; flex-wrap: nowrap; }
.action-group .btn-icon { width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-card); color: var(--text-dim); display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size: 13px; text-decoration: none; }
.action-group .btn-icon:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }
.action-group .btn-icon.danger:hover { border-color: var(--danger); color: var(--danger); background: var(--danger-bg); }
.action-group .btn-icon.order-up:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }
.action-group .btn-icon.order-down:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }
.order-btn-group { display: flex; flex-direction: column; gap: 2px; align-items: center; }
.order-btn-group .btn-icon { width: 28px; height: 20px; border-radius: 4px; font-size: 10px; }
.empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
.empty-state i { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
.empty-state p { font-size: 15px; }

/* Form enhancements */
.form-section { max-width: 720px; }
.form-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.form-card .fhead { display: flex; align-items: center; justify-content: space-between; padding: 18px 24px; border-bottom: 1px solid var(--border); }
.form-card .fhead h3 { font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.form-card .fbody { padding: 24px; }
.form-card .ffoot { display: flex; align-items: center; gap: 10px; padding: 16px 24px; border-top: 1px solid var(--border); }
.form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; font-size: 13px; font-weight: 500; color: var(--text-dim); margin-bottom: 6px; }
.form-group label .required { color: var(--danger); }
.form-control { width: 100%; padding: 10px 14px; background: var(--bg-input); border: 1px solid var(--border); border-radius: 8px; color: var(--text-primary); font-family: inherit; font-size: 14px; outline: none; transition: border-color 0.2s; }
.form-control:focus { border-color: var(--gold); box-shadow: 0 0 0 3px var(--gold-dim); }
.form-control::placeholder { color: var(--text-muted); }
textarea.form-control { resize: vertical; min-height: 100px; }
select.form-control { cursor: pointer; }
.form-control[type="file"] { padding: 8px; }
.form-hint { font-size: 12px; color: var(--text-muted); margin-top: 4px; }
.form-check { display: flex; align-items: center; gap: 10px; padding: 8px 0; }
.form-check input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--gold); cursor: pointer; }
.form-check label { font-size: 14px; color: var(--text-dim); cursor: pointer; margin: 0; }
.image-preview { width: 120px; height: 120px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border); background: var(--bg-input); display: flex; align-items: center; justify-content: center; margin-top: 10px; }
.image-preview img { width: 100%; height: 100%; object-fit: cover; }
.image-preview .placeholder-icon { font-size: 28px; color: var(--text-muted); }

@media (max-width: 768px) {
    .hero-stats { grid-template-columns: repeat(2, 1fr); }
    .form-row-2 { grid-template-columns: 1fr; }
    table.hero-table { font-size: 13px; }
    table.hero-table thead th, table.hero-table tbody td { padding: 10px 12px; }
    .form-card .fbody { padding: 16px; }
}
</style>

<?php if ($action === 'add' || $action === 'edit'): ?>
    <?php $slide = $edit_slide; ?>
    <div class="form-section">
        <div class="form-card">
            <div class="fhead">
                <h3><i class="fa-solid fa-sliders-h" style="color:var(--gold);"></i> <?= $action === 'add' ? 'Add New Slide' : 'Edit Slide' ?></h3>
                <a href="hero-slides.php" class="btn btn-ghost" style="padding:8px 14px;border-radius:8px;font-size:13px;text-decoration:none;"><i class="fa-solid fa-arrow-left"></i> Back</a>
            </div>
            <div class="fbody">
                <?php if (!empty($errors)): ?>
                    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:14px;color:#dc2626;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <?php foreach ($errors as $e): ?><div style="margin-top:4px;"><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?php if ($slide): ?>
                        <input type="hidden" name="slide_id" value="<?= $slide['id'] ?>">
                    <?php endif; ?>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label>Title <span class="required">*</span></label>
                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($slide['title'] ?? $_POST['title'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Subtitle</label>
                            <input type="text" name="subtitle" class="form-control" value="<?= htmlspecialchars($slide['subtitle'] ?? $_POST['subtitle'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($slide['description'] ?? $_POST['description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label>Button Text</label>
                            <input type="text" name="button_text" class="form-control" value="<?= htmlspecialchars($slide['btn_text'] ?? $_POST['button_text'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Button Link</label>
                            <input type="text" name="button_link" class="form-control" value="<?= htmlspecialchars($slide['btn_link'] ?? $_POST['button_link'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label>Image <?= $slide ? '' : '<span class="required">*</span>' ?></label>
                            <input type="file" name="image" class="form-control" data-preview="#imagePreview" accept="image/*">
                            <div class="form-hint">Allowed: jpg, jpeg, png, gif, webp, svg</div>
                            <div class="image-preview" id="imagePreview">
                                <?php if ($slide && $slide['image']): ?>
                                    <img src="../uploads/slider/<?= htmlspecialchars($slide['image']) ?>" alt="Preview">
                                <?php else: ?>
                                    <i class="fa-solid fa-image placeholder-icon"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="<?= (int) ($slide['sort_order'] ?? $_POST['sort_order'] ?? 0) ?>" min="0">
                        </div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="status" id="status" value="1" <?= (isset($slide) && $slide['status']) || !isset($slide) ? 'checked' : '' ?>>
                        <label for="status">Active</label>
                    </div>

                    <div style="margin-top:24px;display:flex;gap:10px;">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> <?= $slide ? 'Update Slide' : 'Create Slide' ?></button>
                        <a href="hero-slides.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="hero-page">
        <!-- Stats Cards -->
        <div class="hero-stats">
            <div class="hero-stat-card">
                <div class="hero-stat-icon gold"><i class="fa-solid fa-images"></i></div>
                <div class="hero-stat-info">
                    <div class="hero-stat-num"><?= $hero_stats['total'] ?></div>
                    <div class="hero-stat-label">Total Slides</div>
                </div>
            </div>
            <div class="hero-stat-card">
                <div class="hero-stat-icon green"><i class="fa-solid fa-check-circle"></i></div>
                <div class="hero-stat-info">
                    <div class="hero-stat-num"><?= $hero_stats['active'] ?></div>
                    <div class="hero-stat-label">Active</div>
                </div>
            </div>
            <div class="hero-stat-card">
                <div class="hero-stat-icon red"><i class="fa-solid fa-ban"></i></div>
                <div class="hero-stat-info">
                    <div class="hero-stat-num"><?= $hero_stats['inactive'] ?></div>
                    <div class="hero-stat-label">Inactive</div>
                </div>
            </div>
        </div>

        <?php if ($success): ?>
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;color:#16a34a;"><i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:14px;color:#dc2626;">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Table -->
        <div class="table-container">
            <div class="table-header">
                <h3><i class="fa-solid fa-sliders-h" style="color:var(--gold);"></i> Hero Slides <span style="color:var(--text-muted);font-weight:400;font-size:13px;">(<?= count($slides) ?>)</span></h3>
                <a href="hero-slides.php?action=add" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Add New</a>
            </div>
            <div class="table-scroll">
                <table class="hero-table">
                    <thead>
                        <tr>
                            <th style="width:60px;">Order</th>
                            <th style="width:80px;">Image</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th style="width:60px;">Sort</th>
                            <th style="width:90px;">Status</th>
                            <th style="width:80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($slides)): ?>
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fa-solid fa-images"></i>
                                        <p>No slides found. Create your first slide!</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $csrf = csrf_token(); ?>
                            <?php foreach ($slides as $s): ?>
                                <tr>
                                    <td>
                                        <div class="order-btn-group">
                                            <a href="?move=<?= $s['id'] ?>&dir=up&csrf_token=<?= $csrf ?>" class="btn-icon order-up" title="Move Up"><i class="fa-solid fa-chevron-up"></i></a>
                                            <a href="?move=<?= $s['id'] ?>&dir=down&csrf_token=<?= $csrf ?>" class="btn-icon order-down" title="Move Down"><i class="fa-solid fa-chevron-down"></i></a>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($s['image']): ?>
                                            <img src="../uploads/slider/<?= htmlspecialchars($s['image']) ?>" alt="" class="hero-thumb">
                                        <?php else: ?>
                                            <div class="hero-thumb-placeholder"><i class="fa-solid fa-image"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="hero-title-cell"><?= htmlspecialchars($s['title']) ?></td>
                                    <td><span class="hero-subtitle"><?= htmlspecialchars(mb_substr($s['subtitle'] ?? '', 0, 50)) ?></span></td>
                                    <td style="text-align:center;"><?= (int) $s['sort_order'] ?></td>
                                    <td>
                                        <?php if ($s['status']): ?>
                                            <span class="badge badge-success"><i class="fa-solid fa-circle" style="font-size:6px;"></i> Active</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger"><i class="fa-solid fa-circle" style="font-size:6px;"></i> Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <a href="hero-slides.php?action=edit&id=<?= $s['id'] ?>" class="btn-icon" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                            <a href="?delete=<?= $s['id'] ?>&csrf_token=<?= $csrf ?>" class="btn-icon danger" data-confirm="Delete this slide permanently?" title="Delete"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-confirm]').forEach(function (el) {
            el.addEventListener('click', function (e) {
                if (!confirm(this.dataset.confirm)) e.preventDefault();
            });
        });
        document.querySelectorAll('input[data-preview]').forEach(function (input) {
            input.addEventListener('change', function () {
                var preview = document.querySelector(this.dataset.preview);
                if (preview && this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    });
    </script>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
