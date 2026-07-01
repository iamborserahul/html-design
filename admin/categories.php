<?php
$current_page = 'categories';
$page_title = 'Categories Management';
require_once __DIR__ . '/includes/header.php';

$db->exec("CREATE TABLE IF NOT EXISTS product_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(255) DEFAULT 'fa-tag',
    image VARCHAR(255),
    sort_order INT DEFAULT 0,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

$total_cats = (int) $db->query("SELECT COUNT(*) FROM product_categories")->fetchColumn();
$active_cats = (int) $db->query("SELECT COUNT(*) FROM product_categories WHERE status = 1")->fetchColumn();
$inactive_cats = $total_cats - $active_cats;

$form_errors = [];
$form_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf($token)) {
        $form_errors[] = 'Invalid security token. Please try again.';
    } else {
        $action = $_POST['action'] ?? 'create';

        if ($action === 'delete') {
            $delete_id = (int) ($_POST['id'] ?? 0);
            if ($delete_id <= 0) {
                $form_errors[] = 'Invalid category ID.';
            } else {
                $stmt = $db->prepare("SELECT id, name, image FROM product_categories WHERE id = ?");
                $stmt->execute([$delete_id]);
                $cat = $stmt->fetch();
                if (!$cat) {
                    $form_errors[] = 'Category not found.';
                } else {
                    $st = $db->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
                    $st->execute([$delete_id]);
                    $prod_count = (int) $st->fetchColumn();

                    if ($prod_count > 0) {
                        $form_errors[] = "Cannot delete: {$prod_count} product(s) are linked to this category. Reassign or delete those products first.";
                    } else {
                        if ($cat['image']) {
                            delete_image($cat['image'], __DIR__ . '/uploads/categories/');
                        }
                        $db->prepare("DELETE FROM product_categories WHERE id = ?")->execute([$delete_id]);
                        $form_success = "Category \"" . htmlspecialchars($cat['name']) . "\" deleted successfully.";
                    }
                }
            }
        } else {
            $id = (int) ($_POST['id'] ?? 0);
            $is_edit = $id > 0;
            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $icon = trim($_POST['icon'] ?? 'fa-tag');
            $sort_order = (int) ($_POST['sort_order'] ?? 0);
            $status = isset($_POST['status']) ? 1 : 0;

            if (empty($name)) {
                $form_errors[] = 'Category name is required.';
            }
            if (empty($slug)) {
                $slug = strtolower(trim(preg_replace('/[^a-z0-9-]+/', '-', $name), '-'));
            }

            if (empty($form_errors)) {
                $stmt = $db->prepare("SELECT id FROM product_categories WHERE slug = ?" . ($is_edit ? " AND id != ?" : ""));
                if ($is_edit) {
                    $stmt->execute([$slug, $id]);
                } else {
                    $stmt->execute([$slug]);
                }
                if ($stmt->fetch()) {
                    $form_errors[] = 'A category with this slug already exists.';
                }
            }

            if (empty($form_errors)) {
                $image = null;
                if ($is_edit) {
                    $st = $db->prepare("SELECT image FROM product_categories WHERE id = ?");
                    $st->execute([$id]);
                    $existing = $st->fetch();
                    $image = $existing ? $existing['image'] : null;
                }

                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploaded = upload_image($_FILES['image'], __DIR__ . '/uploads/categories/');
                    if ($uploaded) {
                        if ($image) {
                            delete_image($image, __DIR__ . '/uploads/categories/');
                        }
                        $image = $uploaded;
                    } else {
                        $form_errors[] = 'Failed to upload image. Allowed: jpg, jpeg, png, gif, webp, svg.';
                    }
                }

                if (empty($form_errors)) {
                    if ($is_edit) {
                        $db->prepare("UPDATE product_categories SET name=?, slug=?, description=?, icon=?, image=?, sort_order=?, status=? WHERE id=?")
                            ->execute([$name, $slug, $description, $icon, $image, $sort_order, $status, $id]);
                        $form_success = "Category \"" . htmlspecialchars($name) . "\" updated successfully.";
                    } else {
                        $db->prepare("INSERT INTO product_categories (name, slug, description, icon, image, sort_order, status) VALUES (?,?,?,?,?,?,?)")
                            ->execute([$name, $slug, $description, $icon, $image, $sort_order, $status]);
                        $form_success = "Category \"" . htmlspecialchars($name) . "\" created successfully.";
                    }
                }
            }
        }
    }
}

$search = trim($_GET['search'] ?? '');
if ($search) {
    $stmt = $db->prepare("
        SELECT c.*, COUNT(p.id) AS product_count
        FROM product_categories c
        LEFT JOIN products p ON p.category_id = c.id
        WHERE c.name LIKE ?
        GROUP BY c.id
        ORDER BY c.sort_order ASC, c.name ASC
    ");
    $stmt->execute(["%{$search}%"]);
} else {
    $stmt = $db->query("
        SELECT c.*, COUNT(p.id) AS product_count
        FROM product_categories c
        LEFT JOIN products p ON p.category_id = c.id
        GROUP BY c.id
        ORDER BY c.sort_order ASC, c.name ASC
    ");
}
$categories = $stmt->fetchAll();
?>

<style>
.cat-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 24px; }
.cat-stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; padding: 18px 20px; display: flex; align-items: center; gap: 16px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.cat-stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
.cat-stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.cat-stat-icon.gold { background: var(--gold-dim); color: var(--gold); }
.cat-stat-icon.green { background: rgba(22,163,74,0.1); color: #16a34a; }
.cat-stat-icon.red { background: rgba(220,38,38,0.1); color: #dc2626; }
.cat-stat-info .cat-stat-num { font-size: 24px; font-weight: 700; line-height: 1.2; color: var(--text); }
.cat-stat-info .cat-stat-label { font-size: 13px; color: var(--text-dim); }

.table-container { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.table-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 12px; }
.table-header h3 { font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.table-search { position: relative; flex: 1; min-width: 200px; }
.table-search input { width: 100%; padding: 9px 14px 9px 38px; background: var(--bg); border: 1px solid var(--border); border-radius: 8px; font-size: 13px; color: var(--text); outline: none; font-family: inherit; transition: border-color 0.2s; }
.table-search input:focus { border-color: var(--gold); }
.table-search .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-dim); font-size: 13px; pointer-events: none; }
.table-actions-wrap { display: flex; gap: 10px; align-items: center; }
.table-scroll { overflow-x: auto; }
table.cat-table { width: 100%; border-collapse: collapse; font-size: 14px; }
table.cat-table thead th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-dim); border-bottom: 1px solid var(--border); background: var(--bg-card-hover); white-space: nowrap; }
table.cat-table tbody td { padding: 12px 16px; border-bottom: 1px solid var(--border); vertical-align: middle; }
table.cat-table tbody tr:last-child td { border-bottom: none; }
table.cat-table tbody tr { transition: background 0.15s; }
table.cat-table tbody tr:hover td { background: var(--gold-dim); }

.cat-icon-box { width: 36px; height: 36px; border-radius: 8px; background: var(--gold-dim); color: var(--gold); display: inline-flex; align-items: center; justify-content: center; font-size: 15px; }
.cat-name-cell { font-weight: 600; color: var(--text); }
.cat-slug-cell { font-family: 'Courier New', monospace; font-size: 0.78rem; color: var(--text-dim); }
.cat-desc-cell { max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-dim); font-size: 13px; }
.cat-sort-cell { color: var(--text-dim); font-size: 13px; }

.badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; white-space: nowrap; }
.badge-gold { background: var(--gold-dim); color: var(--gold); }
.badge-success { background: rgba(22,163,74,0.1); color: #16a34a; }
.badge-danger { background: rgba(220,38,38,0.1); color: #dc2626; }
.badge-muted { background: #f3f4f6; color: var(--text-dim); }

.action-group { display: flex; gap: 4px; flex-wrap: nowrap; }
.action-group .btn-icon { width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-card); color: var(--text-dim); display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size: 13px; text-decoration: none; }
.action-group .btn-icon:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }
.action-group .btn-icon.danger:hover { border-color: var(--danger); color: var(--danger); background: rgba(220,38,38,0.1); }

.empty-state { text-align: center; padding: 60px 20px; color: var(--text-dim); }
.empty-state i { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
.empty-state p { font-size: 15px; }

.alert-box { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 10px; font-size: 14px; margin-bottom: 20px; }
.alert-box.success { background: rgba(22,163,74,0.08); color: #16a34a; border: 1px solid rgba(22,163,74,0.15); }
.alert-box.error { background: rgba(220,38,38,0.08); color: #dc2626; border: 1px solid rgba(220,38,38,0.15); }

.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.3); backdrop-filter: blur(4px); z-index: 1000; display: none; align-items: center; justify-content: center; padding: 20px; }
.modal-overlay.open { display: flex; }
.modal-box { background: #fff; border-radius: 16px; width: 100%; max-width: 640px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.15); animation: modalIn 0.2s ease; }
@keyframes modalIn { from { opacity: 0; transform: scale(0.96) translateY(8px); } to { opacity: 1; transform: scale(1) translateY(0); } }
.modal-box .mhead { display: flex; align-items: center; justify-content: space-between; padding: 18px 24px; border-bottom: 1px solid var(--border); }
.modal-box .mhead h3 { font-size: 16px; font-weight: 600; }
.modal-box .mhead .mclose { width: 32px; height: 32px; border: none; background: #f3f4f6; border-radius: 8px; font-size: 18px; cursor: pointer; color: var(--text-dim); display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
.modal-box .mhead .mclose:hover { background: rgba(220,38,38,0.1); color: var(--danger); }
.modal-box .mbody { padding: 24px; }
.modal-box .mfoot { display: flex; gap: 10px; justify-content: flex-end; padding: 16px 24px; border-top: 1px solid var(--border); }

.form-group { margin-bottom: 16px; }
.form-group .form-label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 4px; color: var(--text); }
.form-group .form-label .required { color: var(--danger); }
.form-group .form-control { width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; color: var(--text); background: #fff; outline: none; font-family: inherit; transition: border-color 0.2s; }
.form-group .form-control:focus { border-color: var(--gold); }
.form-group .form-control::placeholder { color: #adb5bd; }
.form-group textarea.form-control { resize: vertical; }
.form-group .form-hint { font-size: 12px; color: var(--text-dim); margin-top: 3px; }
.form-row-half { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-check { display: flex; align-items: center; gap: 8px; padding-top: 4px; }
.form-check input[type="checkbox"] { width: 17px; height: 17px; accent-color: var(--gold); cursor: pointer; }
.form-check label { font-size: 14px; cursor: pointer; user-select: none; }
.image-preview { margin-top: 8px; }
.image-preview img { width: 80px; height: 80px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border); }
.image-preview .placeholder-icon { width: 80px; height: 80px; border-radius: 8px; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-dim); font-size: 24px; }
.image-preview .placeholder-icon i { font-size: 24px; }

.btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 500; border: none; cursor: pointer; transition: all 0.25s; font-family: inherit; text-decoration: none; }
.btn-primary { background: var(--gold); color: #fff; }
.btn-primary:hover { background: #a07a0a; box-shadow: 0 0 20px var(--gold-glow); }
.btn-secondary { background: var(--bg); color: var(--text); border: 1px solid var(--border); }
.btn-secondary:hover { background: var(--bg-card-hover); border-color: #d1d5db; }

@media (max-width: 768px) {
    .cat-stats { grid-template-columns: repeat(2, 1fr); }
    .table-header { flex-direction: column; align-items: stretch; }
    .table-search { min-width: 100%; }
    .table-actions-wrap { justify-content: flex-end; }
    .form-row-half { grid-template-columns: 1fr; }
    .modal-box { margin: 10px; max-height: 85vh; }
    table.cat-table { font-size: 13px; }
    table.cat-table thead th, table.cat-table tbody td { padding: 10px 12px; }
}
</style>

<?php if ($form_errors): ?>
    <div class="alert-box error"><i class="fas fa-exclamation-circle"></i> <?= implode('<br>', array_map('htmlspecialchars', $form_errors)) ?></div>
<?php elseif ($form_success): ?>
    <div class="alert-box success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($form_success) ?></div>
<?php endif; ?>

<div class="cat-stats">
    <div class="cat-stat-card">
        <div class="cat-stat-icon gold"><i class="fas fa-tags"></i></div>
        <div class="cat-stat-info">
            <div class="cat-stat-num"><?= $total_cats ?></div>
            <div class="cat-stat-label">Total Categories</div>
        </div>
    </div>
    <div class="cat-stat-card">
        <div class="cat-stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div class="cat-stat-info">
            <div class="cat-stat-num"><?= $active_cats ?></div>
            <div class="cat-stat-label">Active</div>
        </div>
    </div>
    <div class="cat-stat-card">
        <div class="cat-stat-icon red"><i class="fas fa-times-circle"></i></div>
        <div class="cat-stat-info">
            <div class="cat-stat-num"><?= $inactive_cats ?></div>
            <div class="cat-stat-label">Inactive</div>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="table-header">
        <div class="table-search">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" placeholder="Search categories..." value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="table-actions-wrap">
            <button type="button" class="btn btn-primary" id="addCategoryBtn">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </div>
    </div>

    <?php if (empty($categories)): ?>
        <div class="empty-state">
            <i class="fas fa-tags"></i>
            <p>No categories found. Click "Add Category" to create one.</p>
        </div>
    <?php else: ?>
        <div class="table-scroll">
            <table class="cat-table">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Sort</th>
                        <th>Products</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $c): ?>
                    <?php
                    $pc = (int) ($c['product_count'] ?? 0);
                    ?>
                    <tr data-id="<?= (int) $c['id'] ?>"
                        data-name="<?= htmlspecialchars($c['name'], ENT_QUOTES) ?>"
                        data-slug="<?= htmlspecialchars($c['slug'], ENT_QUOTES) ?>"
                        data-icon="<?= htmlspecialchars($c['icon'] ?: 'fa-tag', ENT_QUOTES) ?>"
                        data-description="<?= htmlspecialchars($c['description'] ?? '', ENT_QUOTES) ?>"
                        data-sort="<?= (int) $c['sort_order'] ?>"
                        data-status="<?= (int) $c['status'] ?>"
                        data-image="<?= htmlspecialchars($c['image'] ?? '', ENT_QUOTES) ?>"
                        data-count="<?= $pc ?>">
                        <td>
                            <span class="cat-icon-box">
                                <i class="fas <?= htmlspecialchars($c['icon'] ?: 'fa-tag') ?>"></i>
                            </span>
                        </td>
                        <td><span class="cat-name-cell"><?= htmlspecialchars($c['name']) ?></span></td>
                        <td><span class="cat-slug-cell"><?= htmlspecialchars($c['slug']) ?></span></td>
                        <td><span class="cat-desc-cell"><?= htmlspecialchars(truncate($c['description'] ?? '', 60)) ?></span></td>
                        <td>
                            <span class="badge <?= $c['status'] ? 'badge-success' : 'badge-danger' ?>">
                                <i class="fas fa-<?= $c['status'] ? 'check-circle' : 'times-circle' ?>"></i>
                                <?= $c['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td><span class="cat-sort-cell"><?= (int) $c['sort_order'] ?></span></td>
                        <td>
                            <span class="badge <?= $pc > 0 ? 'badge-gold' : 'badge-muted' ?>">
                                <?= $pc ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <button type="button" class="btn-icon edit-cat-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="post" style="display:inline;" data-confirm-form="Delete category &quot;<?= htmlspecialchars($c['name'], ENT_QUOTES) ?>&quot; permanently?<?= $pc > 0 ? ' Warning: This category has ' . $pc . ' product(s).' : '' ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                    <button type="submit" class="btn-icon danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
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

<div class="modal-overlay" id="categoryModal">
    <div class="modal-box">
        <div class="mhead">
            <h3 id="modalTitle">Add Category</h3>
            <button class="mclose modal-close">&times;</button>
        </div>
        <form method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="action" id="formAction" value="create">
            <input type="hidden" name="id" id="categoryId" value="0">

            <div class="mbody">
                <div class="form-group">
                    <label class="form-label">Name <span class="required">*</span></label>
                    <input type="text" name="name" id="fieldName" class="form-control" required>
                </div>

                <div class="form-row-half">
                    <div class="form-group">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" id="fieldSlug" class="form-control">
                        <div class="form-hint">Auto-generated from name if left empty.</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Icon (Font Awesome class)</label>
                        <input type="text" name="icon" id="fieldIcon" class="form-control" placeholder="fa-tag">
                        <div class="form-hint">e.g. fa-industry, fa-tools, fa-fire</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" id="fieldDescription" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <div class="form-hint">Allowed: jpg, jpeg, png, gif, webp, svg</div>
                    <div class="image-preview" id="imagePreview">
                        <div class="placeholder-icon"><i class="fas fa-image"></i></div>
                    </div>
                </div>

                <div class="form-row-half">
                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" min="0" name="sort_order" id="fieldSortOrder" class="form-control" value="0">
                    </div>
                    <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:4px;">
                        <div class="form-check">
                            <input type="checkbox" name="status" id="fieldStatus" value="1" checked>
                            <label for="fieldStatus">Active</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mfoot">
                <button type="button" class="btn btn-secondary modal-close">Cancel</button>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i> <span id="submitLabel">Create Category</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('fieldName');
    const slugInput = document.getElementById('fieldSlug');
    if (nameInput && slugInput) {
        nameInput.addEventListener('blur', function () {
            if (!slugInput.value.trim()) {
                slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            }
        });
    }

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                const q = this.value.trim();
                window.location.href = q ? '?search=' + encodeURIComponent(q) : 'categories.php';
            }
        });
    }

    function openModal() {
        document.getElementById('categoryModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('categoryModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('#categoryModal .modal-close').forEach(function (el) {
        el.addEventListener('click', closeModal);
    });

    document.getElementById('categoryModal').addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            var modal = document.getElementById('categoryModal');
            if (modal.classList.contains('open')) closeModal();
        }
    });

    document.getElementById('addCategoryBtn').addEventListener('click', function () {
        document.getElementById('formAction').value = 'create';
        document.getElementById('categoryId').value = '0';
        document.getElementById('fieldName').value = '';
        document.getElementById('fieldSlug').value = '';
        document.getElementById('fieldIcon').value = 'fa-tag';
        document.getElementById('fieldDescription').value = '';
        document.getElementById('fieldSortOrder').value = '0';
        document.getElementById('fieldStatus').checked = true;
        document.getElementById('modalTitle').textContent = 'Add Category';
        document.getElementById('submitLabel').textContent = 'Create Category';
        document.getElementById('imagePreview').innerHTML = '<div class="placeholder-icon"><i class="fas fa-image"></i></div>';
        openModal();
    });

    document.querySelectorAll('.edit-cat-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var row = this.closest('tr');
            document.getElementById('formAction').value = 'update';
            document.getElementById('categoryId').value = row.getAttribute('data-id');
            document.getElementById('fieldName').value = row.getAttribute('data-name');
            document.getElementById('fieldSlug').value = row.getAttribute('data-slug');
            document.getElementById('fieldIcon').value = row.getAttribute('data-icon') || 'fa-tag';
            document.getElementById('fieldDescription').value = row.getAttribute('data-description') || '';
            document.getElementById('fieldSortOrder').value = row.getAttribute('data-sort') || '0';
            document.getElementById('fieldStatus').checked = row.getAttribute('data-status') === '1';
            document.getElementById('modalTitle').textContent = 'Edit Category';
            document.getElementById('submitLabel').textContent = 'Update Category';

            var imgPreview = document.getElementById('imagePreview');
            var imgFile = row.getAttribute('data-image');
            if (imgFile) {
                imgPreview.innerHTML = '<img src="uploads/categories/' + encodeURIComponent(imgFile) + '" alt="Current">';
            } else {
                imgPreview.innerHTML = '<div class="placeholder-icon"><i class="fas fa-image"></i></div>';
            }
            openModal();
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
