<?php
$current_page = 'products';
$page_title = 'Products Management';
require_once __DIR__ . '/includes/header.php';

$total_products = (int) $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
$active_products = (int) $db->query("SELECT COUNT(*) FROM products WHERE status = 1")->fetchColumn();
$featured_products = (int) $db->query("SELECT COUNT(*) FROM products WHERE featured = 1 AND status = 1")->fetchColumn();
$out_of_stock = (int) $db->query("SELECT COUNT(*) FROM products WHERE stock <= 0")->fetchColumn();

$page = max(1, (int) ($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

try {
    $total = (int) $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $total_pages = max(1, ceil($total / $limit));

    $stmt = $db->prepare("
        SELECT p.*, c.name AS category_name
        FROM products p
        LEFT JOIN product_categories c ON c.id = p.category_id
        ORDER BY p.id DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Database error: ' . $e->getMessage();
}
?>

<style>
.prod-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 24px; }
.prod-stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; padding: 18px 20px; display: flex; align-items: center; gap: 16px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.prod-stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
.prod-stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.prod-stat-icon.gold { background: var(--gold-dim); color: var(--gold); }
.prod-stat-icon.green { background: rgba(22,163,74,0.1); color: #16a34a; }
.prod-stat-icon.blue { background: rgba(37,99,235,0.1); color: #2563eb; }
.prod-stat-icon.red { background: rgba(220,38,38,0.1); color: #dc2626; }
.prod-stat-info .prod-stat-num { font-size: 24px; font-weight: 700; line-height: 1.2; color: var(--text); }
.prod-stat-info .prod-stat-label { font-size: 13px; color: var(--text-dim); }

.table-container { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.table-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 12px; }
.table-header h3 { font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.table-search { position: relative; flex: 1; min-width: 200px; }
.table-search input { width: 100%; padding: 9px 14px 9px 38px; background: var(--bg); border: 1px solid var(--border); border-radius: 8px; font-size: 13px; color: var(--text); outline: none; font-family: inherit; transition: border-color 0.2s; }
.table-search input:focus { border-color: var(--gold); }
.table-search .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-dim); font-size: 13px; pointer-events: none; }
.table-actions-wrap { display: flex; gap: 10px; align-items: center; }
.table-scroll { overflow-x: auto; }
table.prod-table { width: 100%; border-collapse: collapse; font-size: 14px; }
table.prod-table thead th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-dim); border-bottom: 1px solid var(--border); background: var(--bg-card-hover); white-space: nowrap; }
table.prod-table tbody td { padding: 12px 16px; border-bottom: 1px solid var(--border); vertical-align: middle; }
table.prod-table tbody tr:last-child td { border-bottom: none; }
table.prod-table tbody tr { transition: background 0.15s; }
table.prod-table tbody tr:hover td { background: var(--gold-dim); }

.prod-thumb { width: 44px; height: 44px; border-radius: 8px; object-fit: cover; background: var(--bg); }
.prod-thumb-placeholder { width: 44px; height: 44px; border-radius: 8px; border: 1px solid var(--border); display: inline-flex; align-items: center; justify-content: center; color: var(--text-dim); font-size: 16px; background: var(--bg); }
.prod-name-cell { font-weight: 600; color: var(--text); }
.prod-cat-cell { color: var(--text-dim); font-size: 13px; }
.prod-price-cell { color: var(--gold); font-weight: 600; font-family: 'Cinzel', serif; font-size: 14px; }
.prod-price-cell .old-price { font-size: 12px; color: var(--text-dim); text-decoration: line-through; font-family: 'Outfit', sans-serif; font-weight: 400; display: block; }
.prod-stock-cell { font-weight: 600; font-size: 14px; }
.prod-stock-cell.in { color: #16a34a; }
.prod-stock-cell.low { color: #f59e0b; }
.prod-stock-cell.out { color: var(--danger); }

.badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; white-space: nowrap; }
.badge-success { background: rgba(22,163,74,0.1); color: #16a34a; }
.badge-danger { background: rgba(220,38,38,0.1); color: #dc2626; }
.badge-gold { background: var(--gold-dim); color: var(--gold); }
.badge-muted { background: #f3f4f6; color: var(--text-dim); }

.action-group { display: flex; gap: 4px; flex-wrap: nowrap; }
.action-group .btn-icon { width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-card); color: var(--text-dim); display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size: 13px; text-decoration: none; }
.action-group .btn-icon:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }
.action-group .btn-icon.danger:hover { border-color: var(--danger); color: var(--danger); background: rgba(220,38,38,0.1); }

.pagination-wrap { display: flex; align-items: center; justify-content: center; gap: 6px; padding: 16px 20px; border-top: 1px solid var(--border); }
.pagination-wrap .page-item { min-width: 34px; height: 34px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-card); color: var(--text-dim); display: inline-flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.pagination-wrap .page-item:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }
.pagination-wrap .page-item.active { background: var(--gold); color: #fff; border-color: var(--gold); }
.pagination-wrap .page-item.disabled { opacity: 0.4; pointer-events: none; }

.empty-state { text-align: center; padding: 60px 20px; color: var(--text-dim); }
.empty-state i { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
.empty-state p { font-size: 15px; }

.alert-box { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 10px; font-size: 14px; margin-bottom: 20px; }
.alert-box.error { background: rgba(220,38,38,0.08); color: #dc2626; border: 1px solid rgba(220,38,38,0.15); }

.btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 500; border: none; cursor: pointer; transition: all 0.25s; font-family: inherit; text-decoration: none; }
.btn-primary { background: var(--gold); color: #fff; }
.btn-primary:hover { background: #a07a0a; box-shadow: 0 0 20px var(--gold-glow); }

@media (max-width: 768px) {
    .prod-stats { grid-template-columns: repeat(2, 1fr); }
    .table-header { flex-direction: column; align-items: stretch; }
    .table-search { min-width: 100%; }
    .table-actions-wrap { justify-content: flex-end; }
    table.prod-table { font-size: 13px; }
    table.prod-table thead th, table.prod-table tbody td { padding: 10px 12px; }
}
</style>

<?php if (isset($error)): ?>
    <div class="alert-box error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="prod-stats">
    <div class="prod-stat-card">
        <div class="prod-stat-icon gold"><i class="fas fa-box"></i></div>
        <div class="prod-stat-info">
            <div class="prod-stat-num"><?= $total_products ?></div>
            <div class="prod-stat-label">Total Products</div>
        </div>
    </div>
    <div class="prod-stat-card">
        <div class="prod-stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div class="prod-stat-info">
            <div class="prod-stat-num"><?= $active_products ?></div>
            <div class="prod-stat-label">Active</div>
        </div>
    </div>
    <div class="prod-stat-card">
        <div class="prod-stat-icon blue"><i class="fas fa-star"></i></div>
        <div class="prod-stat-info">
            <div class="prod-stat-num"><?= $featured_products ?></div>
            <div class="prod-stat-label">Featured</div>
        </div>
    </div>
    <div class="prod-stat-card">
        <div class="prod-stat-icon red"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="prod-stat-info">
            <div class="prod-stat-num"><?= $out_of_stock ?></div>
            <div class="prod-stat-label">Out of Stock</div>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="table-header">
        <div class="table-search">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" placeholder="Search products...">
        </div>
        <div class="table-actions-wrap">
            <a href="product-form.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <!-- already handled above -->
    <?php elseif (empty($products)): ?>
        <div class="empty-state">
            <i class="fas fa-box"></i>
            <p>No products found. Click "Add Product" to create one.</p>
        </div>
    <?php else: ?>
        <div class="table-scroll">
            <table class="prod-table" id="productsTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <?php
                        $img = $p['featured_image'] ? '../admin/uploads/' . htmlspecialchars($p['featured_image']) : '';
                        $stock_class = $p['stock'] <= 0 ? 'out' : ($p['stock'] <= 5 ? 'low' : 'in');
                        ?>
                        <tr>
                            <td>
                                <?php if ($img): ?>
                                    <img src="<?= $img ?>" alt="" class="prod-thumb">
                                <?php else: ?>
                                    <span class="prod-thumb-placeholder"><i class="fas fa-image"></i></span>
                                <?php endif; ?>
                            </td>
                            <td><span class="prod-name-cell"><?= htmlspecialchars($p['name']) ?></span></td>
                            <td><span class="prod-cat-cell"><?= htmlspecialchars($p['category_name'] ?? '—') ?></span></td>
                            <td>
                                <span class="prod-price-cell">
                                    ₹<?= number_format((float) ($p['sale_price'] ?: $p['price']), 2) ?>
                                    <?php if ($p['sale_price']): ?>
                                        <span class="old-price">₹<?= number_format((float) $p['price'], 2) ?></span>
                                    <?php endif; ?>
                                </span>
                            </td>
                            <td><span class="prod-stock-cell <?= $stock_class ?>"><?= (int) $p['stock'] ?></span></td>
                            <td>
                                <span class="badge <?= $p['status'] ? 'badge-success' : 'badge-danger' ?>">
                                    <i class="fas fa-<?= $p['status'] ? 'check-circle' : 'times-circle' ?>"></i>
                                    <?= $p['status'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= $p['featured'] ? 'badge-gold' : 'badge-muted' ?>">
                                    <i class="fas fa-star"></i>
                                    <?= $p['featured'] ? 'Yes' : 'No' ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="product-form.php?id=<?= $p['id'] ?>" class="btn-icon" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="product-delete.php?id=<?= $p['id'] ?>&csrf_token=<?= csrf_token() ?>" class="btn-icon danger" data-confirm="Delete this product permanently?" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1): ?>
            <div class="pagination-wrap">
                <a href="?page=<?= max(1, $page - 1) ?>" class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="page-item <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
                <a href="?page=<?= min($total_pages, $page + 1) ?>" class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#productsTable tbody tr');
            rows.forEach(function (row) {
                row.style.display = q === '' ? '' : (row.textContent.toLowerCase().indexOf(q) > -1 ? '' : 'none');
            });
        });
    }
});
</script>

<?php
$msg = $_GET['msg'] ?? '';
$type = $_GET['type'] ?? 'success';
if ($msg):
?>
<div class="alert-box success" style="margin-top:20px;"><i class="fas fa-check-circle"></i> <?= htmlspecialchars(htmlspecialchars_decode($msg)) ?></div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
