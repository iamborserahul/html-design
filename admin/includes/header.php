<?php
ob_start();
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
$current_page = isset($current_page) ? $current_page : 'dashboard';
$page_title = isset($page_title) ? $page_title : 'Dashboard';

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/functions.php';
$db = getDB();
$site_name = get_setting('site_name') ?: 'Khodiyar Steel Industries';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> | Admin - <?= htmlspecialchars($site_name) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Cinzel:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: #f5f5f0;
            --bg-card: #ffffff;
            --bg-card-hover: #fafafa;
            --gold: #b8860b;
            --gold-dim: rgba(184,134,11,0.1);
            --gold-glow: rgba(184,134,11,0.06);
            --text: #1a1a1a;
            --text-dim: #6b7280;
            --border: #e5e7eb;
            --danger: #dc2626;
            --success: #16a34a;
            --sidebar-w: 250px;
            --header-h: 64px;
        }
        html { font-size: 15px; }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }
        a { color: var(--gold); text-decoration: none; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            position: fixed;
            left: 0; top: 0;
            background: #ffffff;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
            box-shadow: 2px 0 12px rgba(0,0,0,0.04);
        }
        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar-brand .brand-icon {
            width: 36px; height: 36px;
            background: var(--gold);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            font-family: 'Cinzel', serif;
        }
        .sidebar-brand .brand-text {
            font-family: 'Cinzel', serif;
            font-size: 0.85rem;
            line-height: 1.2;
            color: var(--gold);
        }
        .sidebar-brand .brand-text small {
            display: block;
            font-family: 'Outfit', sans-serif;
            font-size: 0.6rem;
            color: var(--text-dim);
            font-weight: 300;
        }
        .sidebar-nav { padding: 1rem 0; flex: 1; }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.5rem;
            color: var(--text-dim);
            font-size: 0.85rem;
            font-weight: 400;
            transition: all 0.25s;
            border-left: 3px solid transparent;
        }
        .sidebar-nav a i { width: 20px; text-align: center; font-size: 0.95rem; }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            color: var(--text);
            background: var(--gold-dim);
            border-left-color: var(--gold);
        }
        .sidebar-nav a.active { color: var(--gold); font-weight: 500; }
        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar-footer .user-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--gold-dim);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .sidebar-footer .user-info { flex: 1; overflow: hidden; }
        .sidebar-footer .user-info .name {
            font-size: 0.8rem;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-footer .user-info .role {
            font-size: 0.65rem;
            color: var(--text-dim);
            text-transform: capitalize;
        }
        .sidebar-footer .logout-btn {
            color: var(--text-dim);
            font-size: 1rem;
            transition: color 0.2s;
        }
        .sidebar-footer .logout-btn:hover { color: var(--danger); }

        /* Main */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
        }
        .topbar {
            height: var(--header-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            border-bottom: 1px solid var(--border);
            background: #ffffff;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .topbar h1 {
            font-family: 'Cinzel', serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gold);
        }
        .topbar .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .topbar .topbar-right .date-badge {
            font-size: 0.75rem;
            color: var(--text-dim);
            background: var(--bg-card);
            padding: 0.35rem 0.85rem;
            border-radius: 6px;
            border: 1px solid var(--border);
        }
        .content {
            padding: 1.5rem 2rem 2rem;
        }

        /* Glass card */
        .glass-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem;
            transition: all 0.3s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .glass-card:hover {
            background: var(--bg-card-hover);
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        /* Utility */
        .text-gold { color: var(--gold); }
        .text-dim { color: var(--text-dim); }
        .text-danger { color: var(--danger); }
        .text-success { color: var(--success); }
        .fw-500 { font-weight: 500; }
        .fs-small { font-size: 0.8rem; }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }
        .gap-1 { gap: 0.5rem; }
        .gap-2 { gap: 1rem; }
        .d-flex { display: flex; }
        .align-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .flex-wrap { flex-wrap: wrap; }
        .grid-2 { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }

        .table-wrap {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }
        table th {
            text-align: left;
            padding: 0.65rem 0.75rem;
            color: var(--text-dim);
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border);
        }
        table td {
            padding: 0.6rem 0.75rem;
            border-bottom: 1px solid var(--border);
        }
        table tr:last-child td { border-bottom: none; }
        table tr:hover td { background: var(--gold-dim); }

        .badge {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 500;
        }
        .badge-unread { background: var(--gold-dim); color: var(--gold); }
        .badge-read { background: #f3f4f6; color: var(--text-dim); }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1.1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.25s;
            font-family: inherit;
            text-decoration: none;
        }
        .btn-gold {
            background: var(--gold);
            color: #ffffff;
        }
        .btn-gold:hover {
            background: #a07a0a;
            box-shadow: 0 0 20px var(--gold-glow);
        }
        .btn-ghost {
            background: var(--bg-card);
            color: var(--text);
            border: 1px solid var(--border);
        }
        .btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: #d1d5db;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.2); }

        @media (max-width: 768px) {
            .sidebar { width: 60px; }
            .sidebar .brand-text, .sidebar-footer .user-info, .sidebar-nav a span { display: none; }
            .sidebar-brand { padding: 1rem 0.75rem; justify-content: center; }
            .sidebar-nav a { justify-content: center; padding: 0.65rem 0.75rem; }
            .sidebar-nav a i { width: auto; }
            .sidebar-footer { justify-content: center; padding: 0.75rem; }
            .sidebar-footer .user-avatar { display: none; }
            .sidebar-footer .logout-btn { font-size: 1.1rem; }
            .main { margin-left: 60px; }
            .topbar { padding: 0 1rem; }
            .content { padding: 1rem; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">KS</div>
        <div class="brand-text">
            <?= htmlspecialchars($site_name) ?>
            <small>Admin Panel</small>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php" class="<?= $current_page === 'dashboard' ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-pie"></i><span>Dashboard</span>
        </a>
        <a href="products.php" class="<?= $current_page === 'products' ? 'active' : '' ?>">
            <i class="fa-solid fa-box"></i><span>Products</span>
        </a>
        <a href="categories.php" class="<?= $current_page === 'categories' ? 'active' : '' ?>">
            <i class="fa-solid fa-tags"></i><span>Categories</span>
        </a>
        <a href="hero-slides.php" class="<?= $current_page === 'hero-slides' ? 'active' : '' ?>">
            <i class="fa-solid fa-images"></i><span>Hero Slides</span>
        </a>
        <a href="gallery.php" class="<?= $current_page === 'gallery' ? 'active' : '' ?>">
            <i class="fa-solid fa-photo-film"></i><span>Gallery</span>
        </a>
        <a href="inquiries.php" class="<?= $current_page === 'inquiries' ? 'active' : '' ?>">
            <i class="fa-solid fa-envelope"></i><span>Inquiries</span>
        </a>
        <a href="testimonials.php" class="<?= $current_page === 'testimonials' ? 'active' : '' ?>">
            <i class="fa-solid fa-star"></i><span>Testimonials</span>
        </a>
        <a href="faqs.php" class="<?= $current_page === 'faqs' ? 'active' : '' ?>">
            <i class="fa-solid fa-question-circle"></i><span>FAQs</span>
        </a>
        <a href="team.php" class="<?= $current_page === 'team' ? 'active' : '' ?>">
            <i class="fa-solid fa-users"></i><span>Team</span>
        </a>
        <a href="stats.php" class="<?= $current_page === 'stats' ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-simple"></i><span>Stats</span>
        </a>
        <a href="partners.php" class="<?= $current_page === 'partners' ? 'active' : '' ?>">
            <i class="fa-solid fa-handshake"></i><span>Partners</span>
        </a>
        <a href="settings.php" class="<?= $current_page === 'settings' ? 'active' : '' ?>">
            <i class="fa-solid fa-gear"></i><span>Settings</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-avatar"><?= strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?></div>
        <div class="user-info">
            <div class="name"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></div>
            <div class="role"><?= htmlspecialchars($_SESSION['admin_role'] ?? 'admin') ?></div>
        </div>
        <a href="logout.php" class="logout-btn" title="Logout"><i class="fa-solid fa-right-from-bracket"></i></a>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <h1><?= htmlspecialchars($page_title) ?></h1>
        <div class="topbar-right">
            <span class="date-badge"><i class="fa-regular fa-calendar"></i> <?= date('d M Y') ?></span>
        </div>
    </header>
    <div class="content">
