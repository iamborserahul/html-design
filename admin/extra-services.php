<?php
$current_page = 'extra-services';
$page_title = 'Extra Services';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/functions.php';

$errors  = [];
$success = '';
$uploads_dir = LOGO_PATH;

// --- Handle Delete ---
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    if (!isset($_GET['csrf']) || !verify_csrf($_GET['csrf'])) {
        $errors[] = 'Invalid security token.';
    } else {
        // Delete image file if not a default asset
        $row_del = $db->query("SELECT image FROM extra_services WHERE id = $id")->fetch();
        if ($row_del && $row_del['image'] && strpos($row_del['image'], 'assets/') !== 0) {
            $old_path = __DIR__ . '/../' . ltrim($row_del['image'], '/');
            if (file_exists($old_path)) @unlink($old_path);
        }
        $db->prepare("DELETE FROM extra_services WHERE id = ?")->execute([$id]);
        $success = 'Service card deleted successfully.';
    }
}

// --- Handle Toggle Status ---
if (isset($_GET['toggle'])) {
    $id = (int) $_GET['toggle'];
    if (!isset($_GET['csrf']) || !verify_csrf($_GET['csrf'])) {
        $errors[] = 'Invalid security token.';
    } else {
        $db->prepare("UPDATE extra_services SET status = NOT status WHERE id = ?")->execute([$id]);
        $success = 'Status updated.';
    }
}

// --- Defaults ---
$edit_mode = false;
$edit_row = [
    'id'         => '',
    'title'      => '',
    'prefix'     => '',
    'subtitle'   => '',
    'image'      => '',
    'spec_1'     => '',
    'spec_2'     => '',
    'spec_3'     => '',
    'spec_4'     => '',
    'sort_order' => 0,
    'status'     => 1,
];

// --- Load for Edit ---
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM extra_services WHERE id = ?");
    $stmt->execute([(int) $_GET['edit']]);
    $row = $stmt->fetch();
    if ($row) {
        $edit_mode = true;
        $edit_row  = $row;
    }
}

// --- Handle Save (Add / Edit) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_service') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token. Please reload the page.';
    } else {
        $title      = trim($_POST['title']      ?? '');
        $prefix     = trim($_POST['prefix']     ?? '');
        $subtitle   = trim($_POST['subtitle']   ?? '');
        $spec_1     = trim($_POST['spec_1']     ?? '');
        $spec_2     = trim($_POST['spec_2']     ?? '');
        $spec_3     = trim($_POST['spec_3']     ?? '');
        $spec_4     = trim($_POST['spec_4']     ?? '');
        $sort_order = (int) ($_POST['sort_order'] ?? 0);
        $status     = isset($_POST['status']) ? 1 : 0;
        $image_val  = trim($_POST['current_image'] ?? '');
        $item_id    = (int) ($_POST['id'] ?? 0);

        if ($title === '') $errors[] = 'Title is required.';

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $filename = upload_image($_FILES['image'], $uploads_dir);
            if ($filename) {
                // Delete old image if not a default asset
                if ($image_val && strpos($image_val, 'assets/') !== 0) {
                    $old_path = __DIR__ . '/../' . ltrim($image_val, '/');
                    if (file_exists($old_path)) @unlink($old_path);
                }
                $image_val = LOGO_URL . '/' . $filename;
            } else {
                $errors[] = 'Failed to upload image. Allowed: jpg, jpeg, png, gif, webp.';
            }
        }

        if (empty($errors)) {
            if ($item_id) {
                $stmt = $db->prepare("UPDATE extra_services SET title=?, prefix=?, subtitle=?, image=?, spec_1=?, spec_2=?, spec_3=?, spec_4=?, sort_order=?, status=? WHERE id=?");
                $stmt->execute([$title, $prefix, $subtitle, $image_val, $spec_1, $spec_2, $spec_3, $spec_4, $sort_order, $status, $item_id]);
                $success = 'Service card updated successfully.';
            } else {
                $stmt = $db->prepare("INSERT INTO extra_services (title, prefix, subtitle, image, spec_1, spec_2, spec_3, spec_4, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $prefix, $subtitle, $image_val, $spec_1, $spec_2, $spec_3, $spec_4, $sort_order, $status]);
                $success = 'Service card added successfully.';
            }
            $edit_mode = false;
            $edit_row  = ['id' => '', 'title' => '', 'prefix' => '', 'subtitle' => '', 'image' => '', 'spec_1' => '', 'spec_2' => '', 'spec_3' => '', 'spec_4' => '', 'sort_order' => 0, 'status' => 1];
        }
    }
}

$services = $db->query("SELECT * FROM extra_services ORDER BY sort_order ASC, id ASC")->fetchAll();
?>

<style>
    .svc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.25rem;
    }
    .svc-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        transition: all 0.3s;
        position: relative;
    }
    .svc-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.3);
    }
    .svc-card-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        background: rgba(255,255,255,0.04);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .svc-card-img img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }
    .svc-card-img-placeholder {
        width: 100%;
        height: 160px;
        background: linear-gradient(135deg, rgba(255,194,41,0.06) 0%, rgba(255,255,255,0.02) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-dim);
        font-size: 2rem;
    }
    .svc-card-body { padding: 1.2rem; }
    .svc-card-prefix {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--gold);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        background: var(--gold-dim);
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        display: inline-block;
        margin-bottom: 0.5rem;
    }
    .svc-card-title {
        font-family: 'Cinzel', serif;
        font-size: 1rem;
        color: var(--text);
        margin-bottom: 0.25rem;
    }
    .svc-card-subtitle {
        font-size: 0.78rem;
        color: var(--text-dim);
        margin-bottom: 0.75rem;
    }
    .svc-card-specs {
        list-style: none;
        padding: 0;
        margin: 0 0 0.75rem 0;
    }
    .svc-card-specs li {
        font-size: 0.75rem;
        color: var(--text-dim);
        padding: 0.15rem 0;
        padding-left: 1rem;
        position: relative;
    }
    .svc-card-specs li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: var(--gold);
        font-weight: 700;
    }
    .svc-card-status {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .svc-card-actions {
        display: flex;
        gap: 0.5rem;
        padding: 0.75rem 1.2rem;
        border-top: 1px solid var(--border);
        background: rgba(255,255,255,0.02);
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
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .form-row.three-cols { grid-template-columns: 1fr 1fr 1fr; }
    .form-row.four-cols  { grid-template-columns: 1fr 1fr 1fr 1fr; }
    .form-row.one-col    { grid-template-columns: 1fr; }
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
        background: rgba(255,255,255,0.04);
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
    .form-check label { font-size: 0.82rem; color: var(--text-dim); cursor: pointer; }
    .img-preview-wrap {
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .img-preview-wrap img {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border);
    }
    .alert { padding: 0.65rem 1rem; border-radius: 8px; font-size: 0.82rem; margin-bottom: 1rem; }
    .alert-success { background: rgba(34,197,94,0.12); border: 1px solid rgba(34,197,94,0.25); color: var(--success); }
    .alert-error   { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.25); color: var(--danger); }
    .empty-state { text-align: center; padding: 3rem 1rem; color: var(--text-dim); }
    .empty-state i { font-size: 2.5rem; margin-bottom: 0.75rem; opacity: 0.4; }
    .file-input-wrap input[type=file] {
        width: 100%;
        padding: 0.5rem;
        background: rgba(255,255,255,0.04);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text-dim);
        font-size: 0.82rem;
    }
    .section-hint {
        font-size: 0.78rem;
        color: var(--text-dim);
        margin-bottom: 1rem;
        padding: 0.6rem 0.9rem;
        background: rgba(255,194,41,0.05);
        border: 1px solid rgba(255,194,41,0.15);
        border-radius: 8px;
    }
    @media (max-width: 768px) {
        .form-row, .form-row.three-cols, .form-row.four-cols { grid-template-columns: 1fr; }
    }
</style>

<?php if ($success): ?>
    <div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php foreach ($errors as $e): ?>
    <div class="alert alert-error"><i class="fa-solid fa-exclamation-circle"></i> <?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>

<!-- Add / Edit Form -->
<div class="form-card">
    <h2><i class="fa-solid fa-<?= $edit_mode ? 'pen' : 'plus' ?>"></i> <?= $edit_mode ? 'Edit Service Card' : 'Add New Service Card' ?></h2>

    <p class="section-hint"><i class="fa-solid fa-circle-info" style="color:var(--gold);margin-right:0.4rem;"></i>
        Each card appears as a slide in the "Extra Services" liquid parallax section on the home page. Cards are displayed in sort order, only active cards are shown.
    </p>

    <form method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="save_service">
        <?php if ($edit_mode): ?>
            <input type="hidden" name="id" value="<?= (int) $edit_row['id'] ?>">
        <?php endif; ?>
        <input type="hidden" name="current_image" value="<?= htmlspecialchars($edit_row['image']) ?>">

        <!-- Row 1: Title, Prefix, Category Subtitle, Sort Order -->
        <div class="form-row four-cols">
            <div class="form-group">
                <label for="title">Card Title *</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($edit_row['title']) ?>" placeholder="e.g. Bathroom Rack" required>
            </div>
            <div class="form-group">
                <label for="prefix">Prefix / Code</label>
                <input type="text" id="prefix" name="prefix" value="<?= htmlspecialchars($edit_row['prefix']) ?>" placeholder="e.g. BR">
                <div class="hint">Short code shown as the badge (e.g. BR, TH, LT)</div>
            </div>
            <div class="form-group">
                <label for="subtitle">Category Label</label>
                <input type="text" id="subtitle" name="subtitle" value="<?= htmlspecialchars($edit_row['subtitle']) ?>" placeholder="e.g. Utility Storage">
            </div>
            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" value="<?= (int) $edit_row['sort_order'] ?>" placeholder="0">
                <div class="hint">Lower numbers appear first</div>
            </div>
        </div>

        <!-- Row 2: Specs -->
        <div class="form-row">
            <div class="form-group">
                <label for="spec_1">Feature 1</label>
                <input type="text" id="spec_1" name="spec_1" value="<?= htmlspecialchars($edit_row['spec_1']) ?>" placeholder="e.g. Wall-mounted & free-standing formats">
            </div>
            <div class="form-group">
                <label for="spec_2">Feature 2</label>
                <input type="text" id="spec_2" name="spec_2" value="<?= htmlspecialchars($edit_row['spec_2']) ?>" placeholder="e.g. Mild steel or stainless steel tube">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="spec_3">Feature 3</label>
                <input type="text" id="spec_3" name="spec_3" value="<?= htmlspecialchars($edit_row['spec_3']) ?>" placeholder="e.g. Powder-coated & chrome-look finishes">
            </div>
            <div class="form-group">
                <label for="spec_4">Feature 4</label>
                <input type="text" id="spec_4" name="spec_4" value="<?= htmlspecialchars($edit_row['spec_4']) ?>" placeholder="e.g. KD or semi-KD export packing">
            </div>
        </div>

        <!-- Row 3: Image Upload -->
        <div class="form-row one-col">
            <div class="form-group">
                <label for="image">Card Image</label>
                <div class="file-input-wrap">
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                <?php if ($edit_row['image']): ?>
                    <div class="img-preview-wrap">
                        <img src="../<?= htmlspecialchars(ltrim($edit_row['image'], '/')) ?>" alt="Current Image">
                        <span class="hint">Current: <?= htmlspecialchars($edit_row['image']) ?></span>
                    </div>
                <?php endif; ?>
                <div class="hint">Recommended: Square or landscape image, min 400×300px. Allowed: jpg, jpeg, png, webp, gif.</div>
            </div>
        </div>

        <!-- Active toggle -->
        <div class="form-check">
            <input type="checkbox" id="status" name="status" value="1" <?= $edit_row['status'] ? 'checked' : '' ?> style="width:auto;">
            <label for="status">Active (show on website)</label>
        </div>

        <div style="display:flex;gap:0.5rem;">
            <button type="submit" class="btn btn-gold">
                <i class="fa-solid fa-save"></i> <?= $edit_mode ? 'Update Card' : 'Add Card' ?>
            </button>
            <?php if ($edit_mode): ?>
                <a href="extra-services.php" class="btn btn-ghost"><i class="fa-solid fa-times"></i> Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Services Cards Grid -->
<?php if (empty($services)): ?>
    <div class="empty-state">
        <i class="fa-solid fa-screwdriver-wrench"></i>
        <p>No service cards yet. Add your first card above.</p>
    </div>
<?php else: ?>
    <div style="margin-bottom:0.75rem; font-size:0.82rem; color:var(--text-dim);">
        <i class="fa-solid fa-circle-info" style="margin-right:0.3rem;"></i>
        <?= count($services) ?> service card(s) — ordered by sort order
    </div>
    <div class="svc-grid">
        <?php foreach ($services as $s): ?>
            <div class="svc-card">
                <!-- Status Badge -->
                <div class="svc-card-status">
                    <?php if ($s['status']): ?>
                        <span class="badge" style="background:rgba(34,197,94,0.12);color:var(--success);border:1px solid rgba(34,197,94,0.25);padding:0.2rem 0.5rem;border-radius:4px;font-size:0.7rem;">Active</span>
                    <?php else: ?>
                        <span class="badge" style="background:rgba(255,255,255,0.06);color:var(--text-dim);border:1px solid var(--border);padding:0.2rem 0.5rem;border-radius:4px;font-size:0.7rem;">Inactive</span>
                    <?php endif; ?>
                </div>

                <!-- Image -->
                <?php if ($s['image']): ?>
                    <div class="svc-card-img">
                        <img src="../<?= htmlspecialchars(ltrim($s['image'], '/')) ?>" alt="<?= htmlspecialchars($s['title']) ?>">
                    </div>
                <?php else: ?>
                    <div class="svc-card-img-placeholder"><i class="fa-solid fa-image"></i></div>
                <?php endif; ?>

                <div class="svc-card-body">
                    <?php if ($s['prefix']): ?>
                        <span class="svc-card-prefix"><?= htmlspecialchars($s['prefix']) ?></span>
                    <?php endif; ?>
                    <div class="svc-card-title"><?= htmlspecialchars($s['title']) ?></div>
                    <?php if ($s['subtitle']): ?>
                        <div class="svc-card-subtitle">/ <?= htmlspecialchars($s['subtitle']) ?></div>
                    <?php endif; ?>
                    <ul class="svc-card-specs">
                        <?php foreach (['spec_1','spec_2','spec_3','spec_4'] as $spec): ?>
                            <?php if (!empty($s[$spec])): ?>
                                <li><?= htmlspecialchars($s[$spec]) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <div style="font-size:0.72rem;color:var(--text-dim);">
                        <i class="fa-solid fa-arrows-alt-v" style="margin-right:0.3rem;"></i>Order: <?= (int) $s['sort_order'] ?>
                    </div>
                </div>

                <div class="svc-card-actions">
                    <a href="extra-services.php?edit=<?= $s['id'] ?>" class="btn btn-ghost" style="padding:0.3rem 0.75rem;font-size:0.75rem;">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <a href="extra-services.php?toggle=<?= $s['id'] ?>&csrf=<?= csrf_token() ?>"
                       class="btn btn-ghost"
                       style="padding:0.3rem 0.75rem;font-size:0.75rem;<?= $s['status'] ? 'color:var(--text-dim);' : 'color:var(--success);' ?>"
                       title="<?= $s['status'] ? 'Deactivate' : 'Activate' ?>">
                        <i class="fa-solid fa-<?= $s['status'] ? 'eye-slash' : 'eye' ?>"></i> <?= $s['status'] ? 'Deactivate' : 'Activate' ?>
                    </a>
                    <a href="extra-services.php?delete=<?= $s['id'] ?>&csrf=<?= csrf_token() ?>"
                       class="btn btn-ghost"
                       style="padding:0.3rem 0.75rem;font-size:0.75rem;color:var(--danger);border-color:rgba(239,68,68,0.2);"
                       onclick="return confirm('Delete this service card? This cannot be undone.');">
                        <i class="fa-solid fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
