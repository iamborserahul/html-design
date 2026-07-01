<?php
$current_page = 'faqs';
$page_title = 'FAQs';
require_once __DIR__ . '/includes/header.php';

$errors = [];
$success = $_SESSION['flash_success'] ?? '';
$error = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_success'], $_SESSION['flash_error']);

$categories = ['General', 'Ordering', 'Products', 'Shipping', 'Support'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verify_csrf($_POST['csrf_token'])) {
        $errors[] = 'Invalid security token. Please try again.';
    } else {
        $action = $_POST['action'] ?? '';

        if (in_array($action, ['create', 'update'])) {
            $id = $action === 'update' ? (int)($_POST['id'] ?? 0) : 0;
            $question = trim($_POST['question'] ?? '');
            $answer = trim($_POST['answer'] ?? '');
            $category = trim($_POST['category'] ?? 'General');
            $sort_order = (int)($_POST['sort_order'] ?? 0);
            $status = isset($_POST['status']) ? 1 : 0;

            if ($question === '') $errors[] = 'Question is required.';
            if ($answer === '') $errors[] = 'Answer is required.';
            if (!in_array($category, $categories)) $category = 'General';

            if (empty($errors)) {
                try {
                    if ($action === 'create') {
                        $stmt = $db->prepare("INSERT INTO faqs (question, answer, category, sort_order, status) VALUES (?, ?, ?, ?, ?)");
                        $stmt->execute([$question, $answer, $category, $sort_order, $status]);
                        $_SESSION['flash_success'] = 'FAQ created successfully.';
                    } else {
                        $stmt = $db->prepare("UPDATE faqs SET question=?, answer=?, category=?, sort_order=?, status=? WHERE id=?");
                        $stmt->execute([$question, $answer, $category, $sort_order, $status, $id]);
                        $_SESSION['flash_success'] = 'FAQ updated successfully.';
                    }
                    header('Location: faqs.php');
                    exit;
                } catch (PDOException $e) {
                    $errors[] = 'Database error: ' . $e->getMessage();
                }
            }
        } elseif ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            $stmt = $db->prepare("DELETE FROM faqs WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->rowCount()) {
                $_SESSION['flash_success'] = 'FAQ deleted successfully.';
            } else {
                $_SESSION['flash_error'] = 'FAQ not found.';
            }
            header('Location: faqs.php');
            exit;
        }
    }
}

$search = trim($_GET['search'] ?? '');
$category_filter = trim($_GET['category'] ?? '');

$sql = "SELECT * FROM faqs WHERE 1=1";
$params = [];
if ($search !== '') {
    $sql .= " AND (question LIKE ? OR answer LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($category_filter !== '') {
    $sql .= " AND category = ?";
    $params[] = $category_filter;
}
$sql .= " ORDER BY sort_order ASC, id DESC";
$faqs = $db->prepare($sql);
$faqs->execute($params);
$faqs = $faqs->fetchAll();

$edit_row = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM faqs WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit_row = $stmt->fetch();
    if (!$edit_row) $errors[] = 'FAQ not found.';
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
textarea.form-control { resize: vertical; min-height: 120px; }
select.form-control { cursor: pointer; }
.form-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
.form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.form-check { display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem; }
.form-check input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--gold); cursor: pointer; }
.form-check label { margin: 0; cursor: pointer; }

.faq-row { cursor: pointer; }
.faq-row td { transition: background 0.15s; }
.faq-row .expand-icon { transition: transform 0.25s; color: var(--gold); font-size: 0.7rem; }
.faq-row.expanded .expand-icon { transform: rotate(90deg); }
.faq-answer-row { display: none; }
.faq-answer-row.open { display: table-row; }
.faq-answer-row td { padding: 0.75rem 1rem 1rem 2.5rem; background: rgba(255,194,41,0.03); }
.faq-answer-inner {
    font-size: 0.85rem;
    line-height: 1.7;
    color: var(--text-dim);
    white-space: pre-wrap;
}

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

.q-col { max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

.search-bar { display: flex; gap: 0.75rem; align-items: end; flex-wrap: wrap; }
.search-bar .form-group { margin-bottom: 0; min-width: 180px; }

.form-section { margin-bottom: 1.5rem; }

@media (max-width: 768px) {
    .form-row, .form-row-2 { grid-template-columns: 1fr; }
    .search-bar { flex-direction: column; align-items: stretch; }
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
        <i class="fa-solid fa-question-circle"></i> Manage FAQs
    </h2>
    <a href="faqs.php?add=1" class="btn btn-gold">
        <i class="fa-solid fa-plus"></i> Add New
    </a>
</div>

<?php if ($edit_row || isset($_GET['add'])): ?>
<div class="glass-card form-section">
    <h3 style="font-size:0.9rem;color:var(--gold);margin-bottom:1rem;">
        <?= $edit_row ? '<i class="fa-solid fa-pen"></i> Edit FAQ' : '<i class="fa-solid fa-plus"></i> Add FAQ' ?>
    </h3>
    <form method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="<?= $edit_row ? 'update' : 'create' ?>">
        <?php if ($edit_row): ?>
            <input type="hidden" name="id" value="<?= $edit_row['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="question">Question *</label>
            <input type="text" id="question" name="question" class="form-control" value="<?= htmlspecialchars($edit_row['question'] ?? '') ?>" required maxlength="500">
        </div>

        <div class="form-group">
            <label for="answer">Answer *</label>
            <textarea id="answer" name="answer" class="form-control" rows="5" required><?= htmlspecialchars($edit_row['answer'] ?? '') ?></textarea>
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-control">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat ?>" <?= ($edit_row['category'] ?? 'General') === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;align-items:end;">
                <div class="form-group">
                    <label for="sort_order">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= (int)($edit_row['sort_order'] ?? 0) ?>" min="0">
                </div>
                <div class="form-check" style="margin-top:0;">
                    <input type="checkbox" id="status" name="status" value="1" <?= !isset($edit_row) || $edit_row['status'] ? 'checked' : '' ?>>
                    <label for="status">Active</label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-1" style="margin-top:0.5rem;">
            <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> <?= $edit_row ? 'Update' : 'Create' ?></button>
            <a href="faqs.php" class="btn btn-ghost"><i class="fa-solid fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
<?php endif; ?>

<div class="glass-card mb-2">
    <form method="get" class="search-bar">
        <div class="form-group">
            <label for="search">Search Questions / Answers</label>
            <input type="text" id="search" name="search" class="form-control" placeholder="Type to search..." value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="form-group">
            <label for="category_filter">Category</label>
            <select id="category_filter" name="category" class="form-control">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat ?>" <?= $category_filter === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-gold" style="margin-bottom:0;"><i class="fa-solid fa-search"></i> Filter</button>
        <?php if ($search !== '' || $category_filter !== ''): ?>
            <a href="faqs.php" class="btn btn-ghost" style="margin-bottom:0;"><i class="fa-solid fa-times"></i> Clear</a>
        <?php endif; ?>
    </form>
</div>

<div class="glass-card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:30px;"></th>
                    <th>Question</th>
                    <th style="width:130px;">Category</th>
                    <th style="width:60px;">Order</th>
                    <th style="width:70px;">Status</th>
                    <th style="width:80px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($faqs)): ?>
                    <tr><td colspan="6" class="text-dim fs-small" style="text-align:center;padding:2rem;">No FAQs found. <a href="?add=1">Add one</a>.</td></tr>
                <?php else: ?>
                    <?php foreach ($faqs as $f): ?>
                        <tr class="faq-row" data-faq-id="<?= $f['id'] ?>">
                            <td><span class="expand-icon"><i class="fa-solid fa-chevron-right"></i></span></td>
                            <td><div class="q-col fw-500"><?= htmlspecialchars($f['question']) ?></div></td>
                            <td><span class="badge badge-unread" style="font-size:0.7rem;"><?= htmlspecialchars($f['category']) ?></span></td>
                            <td class="text-dim"><?= $f['sort_order'] ?></td>
                            <td>
                                <?php if ($f['status']): ?>
                                    <span class="badge badge-unread">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-read">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="actions" onclick="event.stopPropagation();">
                                    <a href="?edit=<?= $f['id'] ?>" class="btn-icon edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <form method="post" style="display:inline;" onsubmit="return confirm('Delete this FAQ?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $f['id'] ?>">
                                        <button type="submit" class="btn-icon delete" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr class="faq-answer-row" data-faq-id="<?= $f['id'] ?>">
                            <td></td>
                            <td colspan="5">
                                <div class="faq-answer-inner"><?= htmlspecialchars($f['answer']) ?></div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.faq-row').forEach(function (row) {
        row.addEventListener('click', function () {
            const id = this.dataset.faqId;
            const answerRow = document.querySelector('.faq-answer-row[data-faq-id="' + id + '"]');
            if (answerRow) {
                answerRow.classList.toggle('open');
                this.classList.toggle('expanded');
            }
        });
    });

    <?php if ($edit_row): ?>
    document.getElementById('question')?.focus();
    <?php endif; ?>
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
