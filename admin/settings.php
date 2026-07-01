<?php
$current_page = 'settings';
$page_title = 'Site Settings';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/functions.php';

$errors = [];
$success = '';
$uploads_dir = __DIR__ . '/uploads';

$tab_labels = [
    'general' => 'General',
    'social'  => 'Social Media',
    'seo'     => 'SEO',
    'footer'  => 'Footer',
    'logo'    => 'Logo & Favicon',
];

$tab_icons = [
    'general' => 'fa-building',
    'social'  => 'fa-share-nodes',
    'seo'     => 'fa-magnifying-glass',
    'footer'  => 'fa-shoe-prints',
    'logo'    => 'fa-image',
];

// Handle save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_settings') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token. Please reload the page.';
    } else {
        $tab = $_POST['settings_tab'] ?? 'general';

        // Handle logo upload
        if ($tab === 'logo') {
            if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                $filename = upload_image($_FILES['site_logo'], $uploads_dir);
                if ($filename) {
                    $_POST['site_logo'] = 'admin/uploads/' . $filename;
                    $old = get_setting('site_logo');
                    if ($old) {
                        $old_path = __DIR__ . '/../' . ltrim($old, '/');
                        if (file_exists($old_path)) @unlink($old_path);
                    }
                } else {
                    $errors[] = 'Failed to upload logo. Allowed: jpg, jpeg, png, gif, webp, svg.';
                }
            }
            if (isset($_FILES['site_favicon']) && $_FILES['site_favicon']['error'] === UPLOAD_ERR_OK) {
                $filename = upload_image($_FILES['site_favicon'], $uploads_dir);
                if ($filename) {
                    $_POST['site_favicon'] = 'admin/uploads/' . $filename;
                    $old = get_setting('site_favicon');
                    if ($old) {
                        $old_path = __DIR__ . '/../' . ltrim($old, '/');
                        if (file_exists($old_path)) @unlink($old_path);
                    }
                } else {
                    $errors[] = 'Failed to upload favicon. Allowed: jpg, jpeg, png, gif, webp, svg.';
                }
            }
        }

        if (empty($errors)) {
            $upsert = $db->prepare("INSERT INTO site_settings (`key`, `value`, `group`) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), updated_at = CURRENT_TIMESTAMP");

            foreach ($_POST as $key => $val) {
                if (in_array($key, ['action', 'csrf_token', 'settings_tab'])) continue;
                $upsert->execute([$key, $val, $tab]);
            }
            $success = 'Settings saved successfully.';
        }
    }
}

// Fetch all settings grouped
$all_settings = $db->query("SELECT * FROM site_settings ORDER BY `group`, `key`")->fetchAll();
$grouped = [];
foreach ($all_settings as $s) {
    $grouped[$s['group']][$s['key']] = $s['value'];
}
$active_tab = $_GET['tab'] ?? 'general';
if (!isset($tab_labels[$active_tab])) $active_tab = 'general';
?>

<style>
    .tabs-nav {
        display: flex;
        gap: 0.25rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
        padding-bottom: 0;
        flex-wrap: wrap;
    }
    .tabs-nav .tab-btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.82rem;
        font-weight: 500;
        font-family: inherit;
        background: transparent;
        border: none;
        color: var(--text-dim);
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: all 0.25s;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        border-radius: 8px 8px 0 0;
    }
    .tabs-nav .tab-btn:hover {
        color: var(--text);
        background: var(--gold-dim);
    }
    .tabs-nav .tab-btn.active {
        color: var(--gold);
        border-bottom-color: var(--gold);
        background: var(--gold-dim);
    }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    .settings-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.5rem;
    }
    .settings-card h3 {
        font-family: 'Cinzel', serif;
        font-size: 0.9rem;
        color: var(--gold);
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border);
    }
    .s-form-row {
        margin-bottom: 1.1rem;
    }
    .s-form-row label {
        display: block;
        font-size: 0.78rem;
        color: var(--text-dim);
        margin-bottom: 0.3rem;
        font-weight: 500;
    }
    .s-form-row input,
    .s-form-row textarea {
        width: 100%;
        padding: 0.55rem 0.75rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text);
        font-family: inherit;
        font-size: 0.85rem;
        outline: none;
        transition: border-color 0.25s;
    }
    .s-form-row input:focus,
    .s-form-row textarea:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px var(--gold-dim);
    }
    .s-form-row textarea {
        resize: vertical;
        min-height: 80px;
    }
    .s-form-row .hint {
        font-size: 0.68rem;
        color: var(--text-dim);
        margin-top: 0.2rem;
    }

    .logo-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1.25rem;
    }
    .logo-preview .preview-box {
        text-align: center;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 1rem;
    }
    .logo-preview .preview-box img {
        max-width: 200px;
        max-height: 80px;
        display: block;
        margin: 0 auto 0.5rem;
        object-fit: contain;
    }
    .logo-preview .preview-box .label {
        font-size: 0.7rem;
        color: var(--text-dim);
    }
    .logo-preview .preview-box.favicon img {
        max-width: 48px;
        max-height: 48px;
    }
    .file-input-wrap {
        position: relative;
    }
    .file-input-wrap input[type="file"] {
        padding: 0.55rem 0.75rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text);
        font-size: 0.82rem;
        width: 100%;
        cursor: pointer;
    }
    .file-input-wrap input[type="file"]::file-selector-button {
        background: var(--gold-dim);
        color: var(--gold);
        border: 1px solid rgba(255, 194, 41, 0.2);
        padding: 0.3rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-family: inherit;
        cursor: pointer;
        margin-right: 0.75rem;
    }
    .inline-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    @media (max-width: 768px) {
        .inline-grid-2 { grid-template-columns: 1fr; }
        .tabs-nav .tab-btn { font-size: 0.75rem; padding: 0.5rem 0.85rem; }
    }
</style>

<?php if ($success): ?>
    <div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php foreach ($errors as $e): ?>
    <div class="alert alert-error"><i class="fa-solid fa-exclamation-circle"></i> <?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>

<!-- Tabs -->
<div class="tabs-nav" id="tabNav">
    <?php foreach ($tab_labels as $key => $label): ?>
        <button class="tab-btn <?= $active_tab === $key ? 'active' : '' ?>" data-tab="<?= $key ?>">
            <i class="fa-solid <?= $tab_icons[$key] ?>"></i> <?= $label ?>
        </button>
    <?php endforeach; ?>
</div>

<form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save_settings">
    <input type="hidden" name="settings_tab" id="settingsTab" value="<?= $active_tab ?>">

    <!-- Tab: General -->
    <div class="tab-panel <?= $active_tab === 'general' ? 'active' : '' ?>" data-panel="general">
        <div class="settings-card">
            <h3><i class="fa-solid fa-building"></i> General Settings</h3>
            <div class="inline-grid-2">
                <div class="s-form-row">
                    <label for="site_name">Site Name</label>
                    <input type="text" id="site_name" name="site_name" value="<?= htmlspecialchars($grouped['general']['site_name'] ?? '') ?>">
                </div>
                <div class="s-form-row">
                    <label for="site_tagline">Site Tagline</label>
                    <input type="text" id="site_tagline" name="site_tagline" value="<?= htmlspecialchars($grouped['general']['site_tagline'] ?? '') ?>">
                </div>
            </div>
            <div class="inline-grid-2">
                <div class="s-form-row">
                    <label for="site_email">Site Email</label>
                    <input type="email" id="site_email" name="site_email" value="<?= htmlspecialchars($grouped['general']['site_email'] ?? '') ?>">
                </div>
                <div class="s-form-row">
                    <label for="site_phone">Site Phone</label>
                    <input type="text" id="site_phone" name="site_phone" value="<?= htmlspecialchars($grouped['general']['site_phone'] ?? '') ?>">
                </div>
            </div>
            <div class="inline-grid-2">
                <div class="s-form-row">
                    <label for="site_phone_secondary">Site Phone (Secondary)</label>
                    <input type="text" id="site_phone_secondary" name="site_phone_secondary" value="<?= htmlspecialchars($grouped['general']['site_phone_secondary'] ?? '') ?>">
                </div>
                <div class="s-form-row">
                    <label for="working_hours">Working Hours</label>
                    <input type="text" id="working_hours" name="working_hours" value="<?= htmlspecialchars($grouped['general']['working_hours'] ?? '') ?>">
                </div>
            </div>
            <div class="s-form-row">
                <label for="site_address">Site Address</label>
                <textarea id="site_address" name="site_address" rows="3"><?= htmlspecialchars($grouped['general']['site_address'] ?? '') ?></textarea>
            </div>
            <div style="margin-top:1rem;">
                <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> Save Settings</button>
            </div>
        </div>
    </div>

    <!-- Tab: Social Media -->
    <div class="tab-panel <?= $active_tab === 'social' ? 'active' : '' ?>" data-panel="social">
        <div class="settings-card">
            <h3><i class="fa-solid fa-share-nodes"></i> Social Media Links</h3>
            <div class="s-form-row">
                <label for="facebook_url"><i class="fa-brands fa-facebook text-gold"></i> Facebook URL</label>
                <input type="url" id="facebook_url" name="facebook_url" value="<?= htmlspecialchars($grouped['social']['facebook_url'] ?? '') ?>" placeholder="https://facebook.com/...">
            </div>
            <div class="s-form-row">
                <label for="instagram_url"><i class="fa-brands fa-instagram text-gold"></i> Instagram URL</label>
                <input type="url" id="instagram_url" name="instagram_url" value="<?= htmlspecialchars($grouped['social']['instagram_url'] ?? '') ?>" placeholder="https://instagram.com/...">
            </div>
            <div class="s-form-row">
                <label for="twitter_url"><i class="fa-brands fa-twitter text-gold"></i> Twitter URL</label>
                <input type="url" id="twitter_url" name="twitter_url" value="<?= htmlspecialchars($grouped['social']['twitter_url'] ?? '') ?>" placeholder="https://twitter.com/...">
            </div>
            <div class="s-form-row">
                <label for="youtube_url"><i class="fa-brands fa-youtube text-gold"></i> YouTube URL</label>
                <input type="url" id="youtube_url" name="youtube_url" value="<?= htmlspecialchars($grouped['social']['youtube_url'] ?? '') ?>" placeholder="https://youtube.com/@...">
            </div>
            <div class="s-form-row">
                <label for="tiktok_url"><i class="fa-brands fa-tiktok text-gold"></i> TikTok URL</label>
                <input type="url" id="tiktok_url" name="tiktok_url" value="<?= htmlspecialchars($grouped['social']['tiktok_url'] ?? '') ?>" placeholder="https://tiktok.com/@...">
            </div>
            <div style="margin-top:1rem;">
                <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> Save Settings</button>
            </div>
        </div>
    </div>

    <!-- Tab: SEO -->
    <div class="tab-panel <?= $active_tab === 'seo' ? 'active' : '' ?>" data-panel="seo">
        <div class="settings-card">
            <h3><i class="fa-solid fa-magnifying-glass"></i> SEO Settings</h3>
            <div class="s-form-row">
                <label for="meta_title">Meta Title</label>
                <input type="text" id="meta_title" name="meta_title" value="<?= htmlspecialchars($grouped['seo']['meta_title'] ?? '') ?>">
                <div class="hint">Browser tab title & search engine title</div>
            </div>
            <div class="s-form-row">
                <label for="meta_description">Meta Description</label>
                <textarea id="meta_description" name="meta_description" rows="4"><?= htmlspecialchars($grouped['seo']['meta_description'] ?? '') ?></textarea>
                <div class="hint">Recommended: 150-160 characters</div>
            </div>
            <div class="s-form-row">
                <label for="meta_keywords">Meta Keywords</label>
                <input type="text" id="meta_keywords" name="meta_keywords" value="<?= htmlspecialchars($grouped['seo']['meta_keywords'] ?? '') ?>">
                <div class="hint">Comma-separated keywords</div>
            </div>
            <div style="margin-top:1rem;">
                <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> Save Settings</button>
            </div>
        </div>
    </div>

    <!-- Tab: Footer -->
    <div class="tab-panel <?= $active_tab === 'footer' ? 'active' : '' ?>" data-panel="footer">
        <div class="settings-card">
            <h3><i class="fa-solid fa-shoe-prints"></i> Footer Settings</h3>
            <div class="s-form-row">
                <label for="footer_about_text">Footer About Text</label>
                <textarea id="footer_about_text" name="footer_about_text" rows="4"><?= htmlspecialchars($grouped['footer']['footer_about_text'] ?? '') ?></textarea>
                <div class="hint">Short description about the company</div>
            </div>
            <div class="s-form-row">
                <label for="footer_copyright_text">Footer Copyright Text</label>
                <input type="text" id="footer_copyright_text" name="footer_copyright_text" value="<?= htmlspecialchars($grouped['footer']['footer_copyright_text'] ?? '') ?>">
            </div>
            <div style="margin-top:1rem;">
                <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> Save Settings</button>
            </div>
        </div>
    </div>

    <!-- Tab: Logo & Favicon -->
    <div class="tab-panel <?= $active_tab === 'logo' ? 'active' : '' ?>" data-panel="logo">
        <div class="settings-card">
            <h3><i class="fa-solid fa-image"></i> Logo & Favicon</h3>

            <div class="logo-preview">
                <div class="preview-box">
                    <?php $logo = $grouped['logo']['site_logo'] ?? ''; ?>
                    <?php if ($logo): ?>
                        <img src="/<?= ltrim($logo, '/') ?>" alt="Current Logo">
                    <?php else: ?>
                        <div style="width:200px;height:80px;display:flex;align-items:center;justify-content:center;color:var(--text-dim);font-size:0.75rem;border:1px dashed var(--border);border-radius:6px;margin:0 auto 0.5rem;">
                            No logo uploaded
                        </div>
                    <?php endif; ?>
                    <div class="label">Current Logo</div>
                </div>
                <div class="preview-box favicon">
                    <?php $favicon = $grouped['logo']['site_favicon'] ?? ''; ?>
                    <?php if ($favicon): ?>
                        <img src="/<?= ltrim($favicon, '/') ?>" alt="Current Favicon">
                    <?php else: ?>
                        <div style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;color:var(--text-dim);font-size:0.75rem;border:1px dashed var(--border);border-radius:6px;margin:0 auto 0.5rem;">
                            None
                        </div>
                    <?php endif; ?>
                    <div class="label">Current Favicon</div>
                </div>
            </div>

            <div class="inline-grid-2">
                <div class="s-form-row">
                    <label for="site_logo">Upload New Logo</label>
                    <div class="file-input-wrap">
                        <input type="file" id="site_logo" name="site_logo" accept="image/*">
                    </div>
                    <div class="hint">Recommended: PNG or SVG. Max dimensions: 400x120px.</div>
                </div>
                <div class="s-form-row">
                    <label for="site_favicon">Upload New Favicon</label>
                    <div class="file-input-wrap">
                        <input type="file" id="site_favicon" name="site_favicon" accept="image/*">
                    </div>
                    <div class="hint">Recommended: PNG, 32x32px or 16x16px.</div>
                </div>
            </div>

            <div style="margin-top:1rem;">
                <button type="submit" class="btn btn-gold"><i class="fa-solid fa-save"></i> Save Settings</button>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');
    const tabInput = document.getElementById('settingsTab');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const tab = this.dataset.tab;
            tabInput.value = tab;

            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            panels.forEach(p => p.classList.remove('active'));
            const panel = document.querySelector(`[data-panel="${tab}"]`);
            if (panel) panel.classList.add('active');

            // Update URL without reload
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.replaceState({}, '', url);
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
