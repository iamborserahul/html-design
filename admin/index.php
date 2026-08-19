<?php
$current_page = 'dashboard';
$page_title = 'Dashboard';
require_once __DIR__ . '/includes/header.php';

try {
    $counts = [];

    // $counts['products'] = (int) $db->query("SELECT COUNT(*) FROM products WHERE status = 1")->fetchColumn();
    // $counts['categories'] = (int) $db->query("SELECT COUNT(*) FROM product_categories WHERE status = 1")->fetchColumn();
    $counts['inquiries_total'] = (int) $db->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();
    $counts['inquiries_unread'] = (int) $db->query("SELECT COUNT(*) FROM inquiries WHERE is_read = 0")->fetchColumn();
    $counts['gallery'] = (int) $db->query("SELECT COUNT(*) FROM gallery_items WHERE status = 1")->fetchColumn();
    $counts['testimonials'] = (int) $db->query("SELECT COUNT(*) FROM testimonials WHERE status = 1")->fetchColumn();
    $counts['faqs'] = (int) $db->query("SELECT COUNT(*) FROM faqs WHERE status = 1")->fetchColumn();
    $counts['team'] = (int) $db->query("SELECT COUNT(*) FROM team_members WHERE status = 1")->fetchColumn();
    $counts['hero_slides'] = (int) $db->query("SELECT COUNT(*) FROM hero_slides WHERE status = 1")->fetchColumn();

    $recent_inquiries = $db->query("SELECT id, name, email, subject, is_read, created_at FROM inquiries ORDER BY created_at DESC LIMIT 5")->fetchAll();

    // $chart_data = $db->query("
    //     SELECT c.name AS category, COUNT(p.id) AS total
    //     FROM product_categories c
    //     LEFT JOIN products p ON p.category_id = c.id AND p.status = 1
    //     WHERE c.status = 1
    //     GROUP BY c.id, c.name
    //     ORDER BY c.sort_order ASC
    // ")->fetchAll();
    $chart_data = [];

} catch (PDOException $e) {
    $error = 'Database error: ' . $e->getMessage();
}
?>

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        border-top: 3px solid var(--gold);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 80px; height: 80px;
        background: radial-gradient(circle, var(--gold-glow) 0%, transparent 70%);
        opacity: 0.3;
        pointer-events: none;
    }
    .stat-card:hover {
        background: var(--bg-card-hover);
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.3);
    }
    .stat-card .stat-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        background: var(--gold-dim);
        color: var(--gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
    }
    .stat-card .stat-number {
        font-family: 'Cinzel', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gold);
        line-height: 1;
    }
    .stat-card .stat-label {
        font-size: 0.78rem;
        color: var(--text-dim);
        margin-top: 0.3rem;
    }
    .stat-card .stat-sub {
        font-size: 0.7rem;
        color: var(--text-dim);
        margin-top: 0.15rem;
    }
    .stat-card .stat-sub .highlight {
        color: var(--gold);
        font-weight: 500;
    }

    .chart-wrap {
        position: relative;
        height: 260px;
    }

    .inquiry-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0;
        border-bottom: 1px solid var(--border);
    }
    .inquiry-item:last-child { border-bottom: none; }
    .inquiry-item .inq-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--gold-dim);
        color: var(--gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 600;
        flex-shrink: 0;
    }
    .inquiry-item .inq-body { flex: 1; min-width: 0; }
    .inquiry-item .inq-body .inq-name {
        font-size: 0.82rem;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .inquiry-item .inq-body .inq-subject {
        font-size: 0.72rem;
        color: var(--text-dim);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .inquiry-item .inq-body .inq-time {
        font-size: 0.65rem;
        color: var(--text-dim);
        margin-top: 0.1rem;
    }

    .quick-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); }
    }
</style>

<div class="row g-3 mb-4">
    <!-- Products stat card hidden -->
    <!--
    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon"><i class="fa-solid fa-box"></i></div>
            <div class="stat-number" data-count="0">0</div>
            <div class="stat-label">Total Products</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon"><i class="fa-solid fa-tags"></i></div>
            <div class="stat-number" data-count="0">0</div>
            <div class="stat-label">Total Categories</div>
        </div>
    </div>
    -->
    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon"><i class="fa-solid fa-envelope"></i></div>
            <div class="stat-number" data-count="<?= $counts['inquiries_total'] ?>">0</div>
            <div class="stat-label">Total Inquiries</div>
            <?php if ($counts['inquiries_unread'] > 0): ?>
                <div class="stat-sub"><span class="highlight"><?= $counts['inquiries_unread'] ?> unread</span></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon"><i class="fa-solid fa-images"></i></div>
            <div class="stat-number" data-count="<?= $counts['gallery'] ?>">0</div>
            <div class="stat-label">Gallery Items</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon"><i class="fa-solid fa-star"></i></div>
            <div class="stat-number" data-count="<?= $counts['testimonials'] ?>">0</div>
            <div class="stat-label">Testimonials</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon"><i class="fa-solid fa-question-circle"></i></div>
            <div class="stat-number" data-count="<?= $counts['faqs'] ?>">0</div>
            <div class="stat-label">FAQs</div>
        </div>
    </div>
    <?php /*
    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
            <div class="stat-number" data-count="<?= $counts['team'] ?>">0</div>
            <div class="stat-label">Team Members</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon"><i class="fa-solid fa-sliders-h"></i></div>
            <div class="stat-number" data-count="<?= $counts['hero_slides'] ?>">0</div>
            <div class="stat-label">Hero Slides</div>
        </div>
    </div> */?>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-8">
    <!-- Products per Category chart hidden -->
    <!--
    <div class="glass-card mb-4 h-auto">
        <div class="d-flex align-center justify-between mb-2">
            <h2 style="font-family:'Cinzel',serif;font-size:0.95rem;color:var(--gold);">Products per Category</h2>
        </div>
        <div class="chart-wrap">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
    -->
        <div class="glass-card">
            <div class="d-flex align-center justify-between mb-2">
                <h2 style="font-family:'Cinzel',serif;font-size:0.95rem;color:var(--gold);">Quick Actions</h2>
            </div>
            <div class="quick-actions">
                <!-- <a href="products.php?action=add" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Add Product</a> -->
                <a href="inquiries.php" class="btn btn-ghost"><i class="fa-solid fa-envelope"></i> View Inquiries</a>
                <a href="gallery.php?action=add" class="btn btn-ghost"><i class="fa-solid fa-plus"></i> Add Gallery</a>
                <a href="../" class="btn btn-ghost" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Site</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="glass-card h-100">
            <div class="d-flex align-center justify-between mb-2">
                <h2 style="font-family:'Cinzel',serif;font-size:0.95rem;color:var(--gold);">Recent Inquiries</h2>
                <?php if ($counts['inquiries_unread'] > 0): ?>
                    <span class="badge badge-unread"><?= $counts['inquiries_unread'] ?> new</span>
                <?php endif; ?>
            </div>
            <?php if (empty($recent_inquiries)): ?>
                <p class="text-dim fs-small">No inquiries yet.</p>
            <?php else: ?>
                <?php foreach ($recent_inquiries as $inq): ?>
                    <div class="inquiry-item">
                        <div class="inq-avatar"><?= strtoupper(substr($inq['name'], 0, 1)) ?></div>
                        <div class="inq-body">
                            <div class="inq-name"><?= htmlspecialchars($inq['name']) ?>
                                <?php if (!$inq['is_read']): ?>
                                    <span class="badge badge-unread" style="margin-left:0.4rem;">New</span>
                                <?php endif; ?>
                            </div>
                            <div class="inq-subject"><?= htmlspecialchars($inq['subject'] ?: 'No Subject') ?></div>
                            <div class="inq-time"><?= date('d M Y, h:i A', strtotime($inq['created_at'])) ?></div>
                        </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.stat-number[data-count]').forEach(el => {
        const target = parseInt(el.getAttribute('data-count'));
        if (isNaN(target)) return;
        const duration = 800;
        const start = performance.now();
        const animate = (now) => {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(eased * target);
            if (progress < 1) requestAnimationFrame(animate);
        };
        requestAnimationFrame(animate);
    });

    const ctx = document.getElementById('categoryChart');
    if (ctx) {
        const labels = <?= json_encode(array_column($chart_data, 'category')) ?>;
        const data = <?= json_encode(array_map('intval', array_column($chart_data, 'total'))) ?>;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Products',
                    data: data,
                    backgroundColor: 'rgba(255,194,41,0.2)',
                    borderColor: '#FFC229',
                    borderWidth: 2,
                    borderRadius: 4,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: {
                        ticks: { color: 'rgba(232,230,227,0.5)', font: { size: 11 } },
                        grid: { color: 'rgba(255,255,255,0.04)' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'rgba(232,230,227,0.5)',
                            font: { size: 11 },
                            stepSize: 1,
                        },
                        grid: { color: 'rgba(255,255,255,0.04)' }
                    }
                }
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
