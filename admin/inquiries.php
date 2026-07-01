<?php
$current_page = 'inquiries';
$page_title = 'Inquiries';
require_once __DIR__ . '/includes/header.php';

$errors = [];
$success = '';
$search = trim($_GET['search'] ?? '');

// Handle Mark Read / Delete POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!isset($_POST['csrf_token']) || !verify_csrf($_POST['csrf_token'])) {
        $errors[] = 'Invalid security token.';
    } else {
        $id = (int) ($_POST['id'] ?? 0);
        try {
            if ($_POST['action'] === 'mark_read') {
                $stmt = $db->prepare("UPDATE inquiries SET is_read = 1 WHERE id = ?");
                $stmt->execute([$id]);
                $success = 'Inquiry marked as read.';
            } elseif ($_POST['action'] === 'mark_unread') {
                $stmt = $db->prepare("UPDATE inquiries SET is_read = 0 WHERE id = ?");
                $stmt->execute([$id]);
                $success = 'Inquiry marked as unread.';
            } elseif ($_POST['action'] === 'delete') {
                $stmt = $db->prepare("DELETE FROM inquiries WHERE id = ?");
                $stmt->execute([$id]);
                $success = 'Inquiry deleted successfully.';
            }
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

// Handle GET actions
foreach (['delete', 'mark_read', 'mark_unread'] as $act) {
    if (isset($_GET[$act]) && isset($_GET['csrf_token'])) {
        if (!verify_csrf($_GET['csrf_token'])) {
            $errors[] = 'Invalid security token.';
        } else {
            $id = (int) $_GET[$act];
            try {
                if ($act === 'delete') {
                    $stmt = $db->prepare("DELETE FROM inquiries WHERE id = ?");
                } elseif ($act === 'mark_read') {
                    $stmt = $db->prepare("UPDATE inquiries SET is_read = 1 WHERE id = ?");
                } elseif ($act === 'mark_unread') {
                    $stmt = $db->prepare("UPDATE inquiries SET is_read = 0 WHERE id = ?");
                }
                $stmt->execute([$id]);
                $success = $act === 'delete' ? 'Inquiry deleted.' : ($act === 'mark_read' ? 'Marked as read.' : 'Marked as unread.');
            } catch (PDOException $e) {
                $errors[] = 'Database error: ' . $e->getMessage();
            }
        }
        header('Location: inquiries.php' . ($search ? '?search=' . urlencode($search) : ''));
        exit;
    }
}

// CSV Export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    try {
        $rows = $db->query("SELECT * FROM inquiries ORDER BY created_at DESC")->fetchAll();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="inquiries-export-' . date('Y-m-d') . '.csv"');
        $output = fopen('php://output', 'w');
        fprintf($output, "\xEF\xBB\xBF");
        fputcsv($output, ['ID', 'Name', 'Email', 'Phone', 'Company', 'Subject', 'Message', 'Status', 'Date']);
        foreach ($rows as $r) {
            fputcsv($output, [$r['id'], $r['name'], $r['email'], $r['phone'], $r['company'] ?? '', $r['subject'] ?? '', $r['message'], $r['is_read'] ? 'Read' : 'Unread', $r['created_at']]);
        }
        fclose($output);
        exit;
    } catch (PDOException $e) {
        $errors[] = 'Export error: ' . $e->getMessage();
    }
}

// Stats + data
try {
    $stats = [];
    $stats['total'] = (int) $db->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();
    $stats['unread'] = (int) $db->query("SELECT COUNT(*) FROM inquiries WHERE is_read = 0")->fetchColumn();
    $stats['today'] = (int) $db->query("SELECT COUNT(*) FROM inquiries WHERE DATE(created_at) = CURDATE()")->fetchColumn();

    if ($search) {
        $stmt = $db->prepare("SELECT * FROM inquiries WHERE name LIKE ? OR email LIKE ? OR subject LIKE ? OR company LIKE ? ORDER BY is_read ASC, created_at DESC");
        $like = '%' . $search . '%';
        $stmt->execute([$like, $like, $like, $like]);
        $inquiries = $stmt->fetchAll();
    } else {
        $inquiries = $db->query("SELECT * FROM inquiries ORDER BY is_read ASC, created_at DESC")->fetchAll();
    }
} catch (PDOException $e) {
    $errors[] = 'Database error: ' . $e->getMessage();
    $inquiries = [];
    $stats = ['total' => 0, 'unread' => 0, 'today' => 0];
}

$csrf = csrf_token();
?>
<style>
.inquiries-page { max-width: 1400px; }
.inq-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 24px; }
.inq-stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px 20px; display: flex; align-items: center; gap: 16px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.inq-stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); border-color: var(--border-light); }
.inq-stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.inq-stat-icon.gold { background: var(--accent-dim); color: var(--accent); }
.inq-stat-icon.blue { background: rgba(37,99,235,0.1); color: #2563eb; }
.inq-stat-icon.green { background: rgba(22,163,74,0.1); color: #16a34a; }
.inq-stat-icon.red { background: rgba(220,38,38,0.1); color: #dc2626; }
.inq-stat-info .inq-stat-num { font-size: 24px; font-weight: 700; line-height: 1.2; color: var(--text-primary); }
.inq-stat-info .inq-stat-label { font-size: 13px; color: var(--text-secondary); }
.search-bar-wrap { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
.search-bar-wrap .search-input-group { position: relative; flex: 1; min-width: 220px; }
.search-bar-wrap .search-input-group input { width: 100%; padding: 9px 36px 9px 14px; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 14px; color: var(--text-primary); outline: none; font-family: inherit; transition: border-color 0.2s; }
.search-bar-wrap .search-input-group input:focus { border-color: var(--accent); }
.search-bar-wrap .search-input-group .s-icon { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 13px; pointer-events: none; }
.table-container { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.table-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 12px; }
.table-header h3 { font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.table-scroll { overflow-x: auto; }
table.inq-table { width: 100%; border-collapse: collapse; font-size: 14px; }
table.inq-table thead th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); border-bottom: 1px solid var(--border); background: var(--bg-card-hover); white-space: nowrap; }
table.inq-table tbody td { padding: 14px 16px; border-bottom: 1px solid var(--border); vertical-align: middle; }
table.inq-table tbody tr:last-child td { border-bottom: none; }
table.inq-table tbody tr { transition: background 0.15s; }
table.inq-table tbody tr:hover td { background: var(--accent-dim); }
.inq-row-unread { background: rgba(184,134,11,0.03) !important; }
.inq-row-unread td { border-left: 3px solid var(--accent); }
.inq-name-cell { font-weight: 600; color: var(--text-primary); }
.inq-row-unread .inq-name-cell::before { content: '\f0e6'; font-family: 'Font Awesome 6 Free'; font-weight: 400; margin-right: 8px; color: var(--accent); font-size: 12px; }
.inq-subj { max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-secondary); }
.inq-date { white-space: nowrap; font-size: 13px; color: var(--text-secondary); }
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; white-space: nowrap; }
.badge-gold { background: var(--accent-dim); color: var(--accent); }
.badge-success { background: rgba(22,163,74,0.1); color: #16a34a; }
.badge-muted { background: #f3f4f6; color: var(--text-muted); }
.action-group { display: flex; gap: 4px; flex-wrap: nowrap; }
.action-group .btn-icon { width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-card); color: var(--text-secondary); display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size: 13px; text-decoration: none; }
.action-group .btn-icon:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-dim); }
.action-group .btn-icon.danger:hover { border-color: var(--danger); color: var(--danger); background: var(--danger-bg); }
.action-group .btn-icon.success:hover { border-color: var(--success); color: var(--success); background: var(--success-bg); }

/* Modal */
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.3); backdrop-filter: blur(4px); z-index: 1000; display: none; align-items: center; justify-content: center; padding: 20px; }
.modal-overlay.open { display: flex; }
.modal-box { background: #fff; border-radius: 16px; width: 100%; max-width: 640px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.15); animation: modalIn 0.2s ease; }
@keyframes modalIn { from { opacity: 0; transform: scale(0.96) translateY(8px); } to { opacity: 1; transform: scale(1) translateY(0); } }
.modal-box .mhead { display: flex; align-items: center; justify-content: space-between; padding: 18px 24px; border-bottom: 1px solid var(--border); }
.modal-box .mhead h3 { font-size: 16px; font-weight: 600; }
.modal-box .mhead .mclose { width: 32px; height: 32px; border: none; background: #f3f4f6; border-radius: 8px; font-size: 18px; cursor: pointer; color: var(--text-secondary); display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
.modal-box .mhead .mclose:hover { background: var(--danger-bg); color: var(--danger); }
.modal-box .mbody { padding: 24px; }
.modal-box .mfoot { display: flex; gap: 10px; justify-content: flex-end; padding: 16px 24px; border-top: 1px solid var(--border); }

.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.detail-grid .d-item { padding: 0; }
.detail-grid .d-item .d-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; color: var(--text-muted); margin-bottom: 2px; }
.detail-grid .d-item .d-value { font-size: 14px; color: var(--text-primary); word-break: break-word; }
.detail-grid .full { grid-column: 1 / -1; }
.msg-box { background: #f9fafb; border: 1px solid var(--border); border-radius: 10px; padding: 16px 18px; font-size: 14px; line-height: 1.8; color: var(--text-primary); white-space: pre-wrap; margin-top: 4px; }

.empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
.empty-state i { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
.empty-state p { font-size: 15px; }
.empty-state .hint { font-size: 13px; margin-top: 4px; }

@media (max-width: 768px) {
    .inq-stats { grid-template-columns: repeat(2, 1fr); }
    .search-bar-wrap { flex-direction: column; }
    .search-bar-wrap .search-input-group { min-width: 100%; }
    table.inq-table { font-size: 13px; }
    table.inq-table thead th, table.inq-table tbody td { padding: 10px 12px; }
    .modal-box { margin: 10px; max-height: 85vh; }
    .detail-grid { grid-template-columns: 1fr; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-modal]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            var target = document.querySelector(this.dataset.modal);
            if (target) target.classList.add('open');
        });
    });
    document.querySelectorAll('.modal-close').forEach(function (el) {
        el.addEventListener('click', function () {
            this.closest('.modal-overlay').classList.remove('open');
        });
    });
    document.querySelectorAll('.modal-overlay').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (e.target === this) this.classList.remove('open');
        });
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.open').forEach(function (m) { m.classList.remove('open'); });
        }
    });
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm(this.dataset.confirm)) e.preventDefault();
        });
    });
});
</script>

<div class="inquiries-page">
    <!-- Stats Cards -->
    <div class="inq-stats">
        <div class="inq-stat-card">
            <div class="inq-stat-icon blue"><i class="fa-solid fa-envelope"></i></div>
            <div class="inq-stat-info">
                <div class="inq-stat-num"><?= $stats['total'] ?></div>
                <div class="inq-stat-label">Total Inquiries</div>
            </div>
        </div>
        <div class="inq-stat-card">
            <div class="inq-stat-icon gold"><i class="fa-solid fa-envelope-open-text"></i></div>
            <div class="inq-stat-info">
                <div class="inq-stat-num"><?= $stats['unread'] ?></div>
                <div class="inq-stat-label">Unread</div>
            </div>
        </div>
        <div class="inq-stat-card">
            <div class="inq-stat-icon green"><i class="fa-solid fa-calendar-day"></i></div>
            <div class="inq-stat-info">
                <div class="inq-stat-num"><?= $stats['today'] ?></div>
                <div class="inq-stat-label">Received Today</div>
            </div>
        </div>
        <div class="inq-stat-card">
            <div class="inq-stat-icon red"><i class="fa-solid fa-check-circle"></i></div>
            <div class="inq-stat-info">
                <div class="inq-stat-num"><?= $stats['total'] - $stats['unread'] ?></div>
                <div class="inq-stat-label">Read</div>
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
            <h3><i class="fa-regular fa-message" style="color:var(--accent);"></i> Inquiries <span style="color:var(--text-muted);font-weight:400;font-size:13px;">(<?= count($inquiries) ?>)</span></h3>
            <div class="search-bar-wrap">
                <form method="get" action="" style="display:flex;gap:8px;align-items:center;">
                    <div class="search-input-group">
                        <input type="text" name="search" placeholder="Search name, email, subject..." value="<?= htmlspecialchars($search) ?>">
                        <i class="fa-solid fa-search s-icon"></i>
                    </div>
                    <button type="submit" class="btn btn-gold" style="padding:9px 16px;border-radius:8px;font-size:13px;">Search</button>
                    <?php if ($search): ?>
                        <a href="inquiries.php" class="btn btn-ghost" style="padding:9px 16px;border-radius:8px;font-size:13px;">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <div class="table-scroll">
            <table class="inq-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inquiries)): ?>
                        <tr><td colspan="7">
                            <div class="empty-state">
                                <i class="fa-regular fa-envelope-open-text"></i>
                                <p><?= $search ? 'No results match your search.' : 'No inquiries received yet.' ?></p>
                                <?php if ($search): ?><div class="hint">Try a different search term.</div><?php endif; ?>
                            </div>
                        </td></tr>
                    <?php else: ?>
                        <?php foreach ($inquiries as $inq): ?>
                            <tr class="<?= !$inq['is_read'] ? 'inq-row-unread' : '' ?>">
                                <td><span class="inq-name-cell"><?= htmlspecialchars($inq['name']) ?></span></td>
                                <td><a href="mailto:<?= htmlspecialchars($inq['email']) ?>" style="color:var(--text-secondary);font-size:13px;"><?= htmlspecialchars($inq['email']) ?></a></td>
                                <td><?= $inq['phone'] ? '<span style="font-size:13px;">' . htmlspecialchars($inq['phone']) . '</span>' : '<span style="color:var(--text-muted);font-size:12px;">—</span>' ?></td>
                                <td><span class="inq-subj"><?= htmlspecialchars($inq['subject'] ?? 'No subject') ?></span></td>
                                <td><span class="inq-date"><?= date('d M Y', strtotime($inq['created_at'])) ?></span></td>
                                <td>
                                    <?php if ($inq['is_read']): ?>
                                        <span class="badge badge-muted"><i class="fa-regular fa-circle-check"></i> Read</span>
                                    <?php else: ?>
                                        <span class="badge badge-gold"><i class="fa-regular fa-envelope"></i> New</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="#" data-modal="#viewModal<?= $inq['id'] ?>" class="btn-icon" title="View"><i class="fa-solid fa-eye"></i></a>
                                        <?php if (!$inq['is_read']): ?>
                                            <a href="?mark_read=<?= $inq['id'] ?>&csrf_token=<?= $csrf ?>" class="btn-icon success" title="Mark Read"><i class="fa-solid fa-check"></i></a>
                                        <?php else: ?>
                                            <a href="?mark_unread=<?= $inq['id'] ?>&csrf_token=<?= $csrf ?>" class="btn-icon" title="Mark Unread"><i class="fa-regular fa-envelope"></i></a>
                                        <?php endif; ?>
                                        <a href="?delete=<?= $inq['id'] ?>&csrf_token=<?= $csrf ?>" class="btn-icon danger" data-confirm="Delete this inquiry permanently?" title="Delete"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>

                            <!-- View Modal -->
                            <div class="modal-overlay" id="viewModal<?= $inq['id'] ?>">
                                <div class="modal-box">
                                    <div class="mhead">
                                        <h3><i class="fa-regular fa-envelope" style="color:var(--accent);margin-right:8px;"></i> Inquiry from <?= htmlspecialchars($inq['name']) ?></h3>
                                        <button class="mclose modal-close">&times;</button>
                                    </div>
                                    <div class="mbody">
                                        <div class="detail-grid">
                                            <div class="d-item">
                                                <div class="d-label">Name</div>
                                                <div class="d-value" style="font-weight:600;"><?= htmlspecialchars($inq['name']) ?></div>
                                            </div>
                                            <div class="d-item">
                                                <div class="d-label">Email</div>
                                                <div class="d-value"><a href="mailto:<?= htmlspecialchars($inq['email']) ?>" style="color:var(--accent);"><?= htmlspecialchars($inq['email']) ?></a></div>
                                            </div>
                                            <div class="d-item">
                                                <div class="d-label">Phone</div>
                                                <div class="d-value"><?= htmlspecialchars($inq['phone'] ?? '—') ?></div>
                                            </div>
                                            <div class="d-item">
                                                <div class="d-label">Company</div>
                                                <div class="d-value"><?= htmlspecialchars($inq['company'] ?? '—') ?></div>
                                            </div>
                                            <div class="d-item full">
                                                <div class="d-label">Subject</div>
                                                <div class="d-value" style="font-weight:600;"><?= htmlspecialchars($inq['subject'] ?? '—') ?></div>
                                            </div>
                                            <div class="d-item full">
                                                <div class="d-label">Message</div>
                                                <div class="msg-box"><?= htmlspecialchars($inq['message']) ?></div>
                                            </div>
                                            <div class="d-item">
                                                <div class="d-label">Received</div>
                                                <div class="d-value"><?= date('d M Y, h:i A', strtotime($inq['created_at'])) ?></div>
                                            </div>
                                            <div class="d-item">
                                                <div class="d-label">Status</div>
                                                <div class="d-value">
                                                    <?php if ($inq['is_read']): ?>
                                                        <span class="badge badge-muted"><i class="fa-regular fa-circle-check"></i> Read</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-gold"><i class="fa-regular fa-envelope"></i> Unread</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mfoot">
                                        <a href="mailto:<?= htmlspecialchars($inq['email']) ?>?subject=Re: <?= urlencode($inq['subject'] ?? 'Inquiry') ?>" class="btn btn-gold" style="padding:9px 18px;border-radius:8px;font-size:13px;text-decoration:none;"><i class="fa-solid fa-reply"></i> Reply via Email</a>
                                        <?php if (!$inq['is_read']): ?>
                                            <form method="post" style="display:inline;">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="action" value="mark_read">
                                                <input type="hidden" name="id" value="<?= $inq['id'] ?>">
                                                <button type="submit" class="btn btn-ghost" style="padding:9px 16px;border-radius:8px;font-size:13px;"><i class="fa-solid fa-check"></i> Mark Read</button>
                                            </form>
                                        <?php endif; ?>
                                        <button class="btn btn-ghost modal-close" style="padding:9px 16px;border-radius:8px;font-size:13px;">Close</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
