<?php
$current_page = 'gallery';
$page_title = 'Gallery';
require_once __DIR__ . '/includes/header.php';

$errors = [];
$success = '';

$upload_path = __DIR__ . '/uploads/gallery/';
if (!is_dir($upload_path)) {
    mkdir($upload_path, 0755, true);
}

$categories = ['Beds', 'Cupboards', 'Dining', 'Doors', 'Hospital', 'Outdoor'];

$action = $_GET['action'] ?? 'list';
$edit_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$filter_category = trim($_GET['category'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verify_csrf($_POST['csrf_token'])) {
        $errors[] = 'Invalid security token.';
    } else {
        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $sort_order = (int) ($_POST['sort_order'] ?? 0);
        $status = isset($_POST['status']) ? 1 : 0;
        $item_id = (int) ($_POST['item_id'] ?? 0);

        if ($title === '') {
            $errors[] = 'Title is required.';
        }
        if ($category === '' || !in_array($category, $categories)) {
            $errors[] = 'Please select a valid category.';
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
                    if ($item_id > 0) {
                        if ($image_filename) {
                            $stmt = $db->prepare("SELECT image FROM gallery_items WHERE id = ?");
                            $stmt->execute([$item_id]);
                            $old = $stmt->fetch();
                            if ($old && $old['image']) {
                                delete_image($old['image'], $upload_path);
                            }
                            $stmt = $db->prepare("UPDATE gallery_items SET title=?, category=?, description=?, image=?, sort_order=?, status=? WHERE id=?");
                            $stmt->execute([$title, $category, $description, $image_filename, $sort_order, $status, $item_id]);
                        } else {
                            $stmt = $db->prepare("UPDATE gallery_items SET title=?, category=?, description=?, sort_order=?, status=? WHERE id=?");
                            $stmt->execute([$title, $category, $description, $sort_order, $status, $item_id]);
                        }
                        $success = 'Gallery item updated successfully.';
                    } else {
                        if (!$image_filename) {
                            $errors[] = 'Image is required.';
                        } else {
                            $stmt = $db->prepare("INSERT INTO gallery_items (title, category, description, image, sort_order, status) VALUES (?, ?, ?, ?, ?, ?)");
                            $stmt->execute([$title, $category, $description, $image_filename, $sort_order, $status]);
                            $success = 'Gallery item created successfully.';
                            $_POST = [];
                        }
                    }
                } catch (PDOException $e) {
                    $errors[] = 'Database error: ' . $e->getMessage();
                }
            }
        }
    }
}

if (isset($_GET['delete']) && isset($_GET['csrf_token'])) {
    if (verify_csrf($_GET['csrf_token'])) {
        $id = (int) $_GET['delete'];
        try {
            $stmt = $db->prepare("SELECT image FROM gallery_items WHERE id = ?");
            $stmt->execute([$id]);
            $item = $stmt->fetch();
            if ($item) {
                if ($item['image']) {
                    delete_image($item['image'], $upload_path);
                }
                $stmt = $db->prepare("DELETE FROM gallery_items WHERE id = ?");
                $stmt->execute([$id]);
                $success = 'Gallery item deleted successfully.';
            }
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    } else {
        $errors[] = 'Invalid security token.';
    }
    header('Location: gallery.php?msg=' . urlencode($success ?: '') . ($filter_category ? '&category=' . urlencode($filter_category) : ''));
    exit;
}

$edit_item = null;
if ($action === 'edit' && $edit_id > 0) {
    $stmt = $db->prepare("SELECT * FROM gallery_items WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_item = $stmt->fetch();
    if (!$edit_item) {
        $action = 'list';
    }
}

try {
    if ($filter_category) {
        $stmt = $db->prepare("SELECT * FROM gallery_items WHERE category = ? ORDER BY sort_order ASC, id DESC");
        $stmt->execute([$filter_category]);
        $items = $stmt->fetchAll();
    } else {
        $items = $db->query("SELECT * FROM gallery_items ORDER BY sort_order ASC, id DESC")->fetchAll();
    }
} catch (PDOException $e) {
    $errors[] = 'Database error: ' . $e->getMessage();
    $items = [];
}

if (isset($_GET['msg']) && $_GET['msg'] !== '') {
    $success = htmlspecialchars($_GET['msg']);
}

// Stats for UI cards
$gallery_stats = [];
try {
    $gallery_stats['total'] = (int) $db->query("SELECT COUNT(*) FROM gallery_items")->fetchColumn();
    $gallery_stats['active'] = (int) $db->query("SELECT COUNT(*) FROM gallery_items WHERE status = 1")->fetchColumn();
    $gallery_stats['inactive'] = (int) $db->query("SELECT COUNT(*) FROM gallery_items WHERE status = 0")->fetchColumn();
    $gallery_stats['categories'] = count($categories);
} catch (PDOException $e) {
    $gallery_stats = ['total' => 0, 'active' => 0, 'inactive' => 0, 'categories' => count($categories)];
}
?>
<style>
.gal-page { max-width: 1400px; }
.gal-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 24px; }
.gal-stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px 20px; display: flex; align-items: center; gap: 16px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.gal-stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); border-color: var(--border-light); }
.gal-stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.gal-stat-icon.gold { background: var(--gold-dim); color: var(--gold); }
.gal-stat-icon.blue { background: rgba(37,99,235,0.1); color: #2563eb; }
.gal-stat-icon.green { background: rgba(22,163,74,0.1); color: #16a34a; }
.gal-stat-icon.purple { background: rgba(168,85,247,0.1); color: #a855f7; }
.gal-stat-info .gal-stat-num { font-size: 24px; font-weight: 700; line-height: 1.2; color: var(--text-primary); }
.gal-stat-info .gal-stat-label { font-size: 13px; color: var(--text-dim); }
.filter-pills { display: flex; gap: 6px; flex-wrap: wrap; }
.filter-pill { display: inline-flex; align-items: center; gap: 4px; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 500; background: var(--bg-card); border: 1px solid var(--border); color: var(--text-dim); cursor: pointer; transition: all 0.2s; text-decoration: none; }
.filter-pill:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }
.filter-pill.active { background: var(--gold); border-color: var(--gold); color: #fff; }
.table-container { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.table-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 12px; }
.table-header h3 { font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.table-scroll { overflow-x: auto; }
table.gal-table { width: 100%; border-collapse: collapse; font-size: 14px; }
table.gal-table thead th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); border-bottom: 1px solid var(--border); background: var(--bg-card-hover); white-space: nowrap; }
table.gal-table tbody td { padding: 14px 16px; border-bottom: 1px solid var(--border); vertical-align: middle; }
table.gal-table tbody tr:last-child td { border-bottom: none; }
table.gal-table tbody tr { transition: background 0.15s; }
table.gal-table tbody tr:hover td { background: var(--gold-dim); }
.gal-thumb { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; background: var(--bg-input); display: block; }
.gal-thumb-placeholder { width: 48px; height: 48px; border-radius: 8px; background: var(--bg-input); display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--text-muted); }
.gal-title-cell { font-weight: 600; color: var(--text-primary); }
.gal-desc { max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-dim); font-size: 13px; }
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; white-space: nowrap; }
.badge-gold { background: var(--gold-dim); color: var(--gold); }
.badge-success { background: rgba(22,163,74,0.1); color: #16a34a; }
.badge-danger { background: rgba(220,38,38,0.1); color: #dc2626; }
.action-group { display: flex; gap: 4px; flex-wrap: nowrap; }
.action-group .btn-icon { width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-card); color: var(--text-dim); display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size: 13px; text-decoration: none; }
.action-group .btn-icon:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }
.action-group .btn-icon.danger:hover { border-color: var(--danger); color: var(--danger); background: var(--danger-bg); }
.empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
.empty-state i { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
.empty-state p { font-size: 15px; }
.search-bar-wrap { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
.search-bar-wrap .search-input-group { position: relative; flex: 1; min-width: 220px; }
.search-bar-wrap .search-input-group input { width: 100%; padding: 9px 36px 9px 14px; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 14px; color: var(--text-primary); outline: none; font-family: inherit; transition: border-color 0.2s; }
.search-bar-wrap .search-input-group input:focus { border-color: var(--gold); }
.search-bar-wrap .search-input-group .s-icon { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 13px; pointer-events: none; }

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
    .gal-stats { grid-template-columns: repeat(2, 1fr); }
    .search-bar-wrap { flex-direction: column; }
    .search-bar-wrap .search-input-group { min-width: 100%; }
    .filter-pills { justify-content: flex-start; }
    .form-row-2 { grid-template-columns: 1fr; }
    table.gal-table { font-size: 13px; }
    table.gal-table thead th, table.gal-table tbody td { padding: 10px 12px; }
    .form-card .fbody { padding: 16px; }
}
</style>

<?php if ($action === 'add' || $action === 'edit'): ?>
    <?php $item = $edit_item; ?>
    <div class="form-section">
        <div class="form-card">
            <div class="fhead">
                <h3><i class="fa-solid fa-image" style="color:var(--gold);"></i> <?= $action === 'add' ? 'Add Gallery Item' : 'Edit Gallery Item' ?></h3>
                <a href="gallery.php<?= $filter_category ? '?category=' . urlencode($filter_category) : '' ?>" class="btn btn-ghost" style="padding:8px 14px;border-radius:8px;font-size:13px;text-decoration:none;"><i class="fa-solid fa-arrow-left"></i> Back</a>
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
                    <?php if ($item): ?>
                        <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                    <?php endif; ?>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label>Title <span class="required">*</span></label>
                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($item['title'] ?? $_POST['title'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Category <span class="required">*</span></label>
                            <select name="category" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat) ?>" <?= (($item['category'] ?? $_POST['category'] ?? '') === $cat) ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($item['description'] ?? $_POST['description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label>Image <?= $item ? '' : '<span class="required">*</span>' ?></label>
                            <input type="file" name="image" class="form-control" data-preview="#imagePreview" accept="image/*">
                            <div class="form-hint">Allowed: jpg, jpeg, png, gif, webp, svg</div>
                            <div class="image-preview" id="imagePreview">
                                <?php if ($item && $item['image']): ?>
                                    <img src="uploads/gallery/<?= htmlspecialchars($item['image']) ?>" alt="Preview">
                                <?php else: ?>
                                    <i class="fa-solid fa-image placeholder-icon"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="<?= (int) ($item['sort_order'] ?? $_POST['sort_order'] ?? 0) ?>" min="0">
                        </div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="status" id="status" value="1" <?= (isset($item) && $item['status']) || !isset($item) ? 'checked' : '' ?>>
                        <label for="status">Active</label>
                    </div>

                    <div style="margin-top:24px;display:flex;gap:10px;">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> <?= $item ? 'Update Item' : 'Create Item' ?></button>
                        <a href="gallery.php<?= $filter_category ? '?category=' . urlencode($filter_category) : '' ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="gal-page">
        <!-- Stats Cards -->
        <div class="gal-stats">
            <div class="gal-stat-card">
                <div class="gal-stat-icon blue"><i class="fa-solid fa-images"></i></div>
                <div class="gal-stat-info">
                    <div class="gal-stat-num"><?= $gallery_stats['total'] ?></div>
                    <div class="gal-stat-label">Total Items</div>
                </div>
            </div>
            <div class="gal-stat-card">
                <div class="gal-stat-icon green"><i class="fa-solid fa-check-circle"></i></div>
                <div class="gal-stat-info">
                    <div class="gal-stat-num"><?= $gallery_stats['active'] ?></div>
                    <div class="gal-stat-label">Active</div>
                </div>
            </div>
            <div class="gal-stat-card">
                <div class="gal-stat-icon" style="background:rgba(220,38,38,0.1);color:#dc2626;"><i class="fa-solid fa-ban"></i></div>
                <div class="gal-stat-info">
                    <div class="gal-stat-num"><?= $gallery_stats['inactive'] ?></div>
                    <div class="gal-stat-label">Inactive</div>
                </div>
            </div>
            <div class="gal-stat-card">
                <div class="gal-stat-icon purple"><i class="fa-solid fa-tags"></i></div>
                <div class="gal-stat-info">
                    <div class="gal-stat-num"><?= $gallery_stats['categories'] ?></div>
                    <div class="gal-stat-label">Categories</div>
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
                <h3><i class="fa-solid fa-photo-film" style="color:var(--gold);"></i> Gallery Items <span style="color:var(--text-muted);font-weight:400;font-size:13px;">(<?= count($items) ?>)</span></h3>
                <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                    <div class="filter-pills">
                        <a href="gallery.php" class="filter-pill <?= $filter_category === '' ? 'active' : '' ?>">All</a>
                        <?php foreach ($categories as $cat): ?>
                            <a href="gallery.php?category=<?= urlencode($cat) ?>" class="filter-pill <?= $filter_category === $cat ? 'active' : '' ?>"><?= htmlspecialchars($cat) ?></a>
                        <?php endforeach; ?>
                    </div>
                    <div style="display:flex;gap:8px;align-items:center;">
                        <div class="search-bar-wrap">
                            <div class="search-input-group">
                                <input type="text" placeholder="Search gallery..." id="gallerySearch">
                                <i class="fa-solid fa-search s-icon"></i>
                            </div>
                        </div>
                        <a href="gallery.php?action=add<?= $filter_category ? '&category=' . urlencode($filter_category) : '' ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Add New</a>
                    </div>
                </div>
            </div>
            <div class="table-scroll">
                <table class="gal-table">
                    <thead>
                        <tr>
                            <th style="width:64px;">Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th style="width:60px;">Sort</th>
                            <th style="width:90px;">Status</th>
                            <th style="width:80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fa-solid fa-image"></i>
                                        <p><?= $filter_category ? 'No items found in this category.' : 'No gallery items found.' ?></p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $csrf = csrf_token(); ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <?php if ($item['image']): ?>
                                            <img src="uploads/gallery/<?= htmlspecialchars($item['image']) ?>" alt="" class="gal-thumb">
                                        <?php else: ?>
                                            <div class="gal-thumb-placeholder"><i class="fa-solid fa-image"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="gal-title-cell"><?= htmlspecialchars($item['title']) ?></td>
                                    <td><span class="badge badge-gold"><i class="fa-regular fa-folder"></i> <?= htmlspecialchars($item['category']) ?></span></td>
                                    <td><span class="gal-desc"><?= htmlspecialchars(truncate($item['description'] ?? '', 60)) ?></span></td>
                                    <td style="text-align:center;"><?= (int) $item['sort_order'] ?></td>
                                    <td>
                                        <?php if ($item['status']): ?>
                                            <span class="badge badge-success"><i class="fa-solid fa-circle" style="font-size:6px;"></i> Active</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger"><i class="fa-solid fa-circle" style="font-size:6px;"></i> Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <a href="gallery.php?action=edit&id=<?= $item['id'] ?><?= $filter_category ? '&category=' . urlencode($filter_category) : '' ?>" class="btn-icon" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                            <a href="?delete=<?= $item['id'] ?>&csrf_token=<?= $csrf ?><?= $filter_category ? '&category=' . urlencode($filter_category) : '' ?>" class="btn-icon danger" data-confirm="Delete this gallery item permanently?" title="Delete"><i class="fa-solid fa-trash"></i></a>
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
        const searchInput = document.getElementById('gallerySearch');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const q = this.value.toLowerCase().trim();
                document.querySelectorAll('.gal-table tbody tr').forEach(function (row) {
                    row.style.display = q === '' ? '' : row.textContent.toLowerCase().indexOf(q) > -1 ? '' : 'none';
                });
            });
        }
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
