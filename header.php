<?php
// Set default page variables if not defined
$title = isset($title) ? $title : "Khodiyar Steel – High-End Luxury Steel & Precision Metal Fabrication";
$description = isset($description) ? $description : "Transforming spaces with high-end luxury steel furniture, premium storage solutions, and state-of-the-art structural metal fabrication.";
$page = isset($page) ? $page : "home";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;600;700;800&family=Cinzel:wght@600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Style Sheets -->
    <link rel="stylesheet" href="style.css?v=1.1">
</head>

<body>

    <!-- Abstract Wavy Background Gradient -->
    <div class="aiero-bg-glow">
        <div class="aiero-bg-wave"></div>
        <?php if ($page !== 'home'): ?>
            <div class="aiero-floating-shape shape-1"></div>
            <div class="aiero-floating-shape shape-2"></div>
            <div class="aiero-floating-shape shape-3"></div>
            <div class="aiero-floating-shape shape-4"></div>
        <?php endif; ?>
    </div>

    <!-- Mouse follow Spotlight light -->
    <div class="aiero-spotlight"></div>

    <!-- Custom Cursor -->
    <div class="luxury-cursor">
        <div class="cursor-dot"></div>
        <div class="cursor-ring"></div>
    </div>

    <!-- AIERO Glassmorphic Capsule Header Nav -->
    <nav class="aiero-nav">
        <div class="aiero-nav-container">
            <a href="index.php" class="aiero-logo">
                <img src="assets/logo.png" alt="Khodiyar Steel Industries">
            </a>
            <ul class="aiero-menu">
                <li><a href="index.php" class="aiero-menu-link<?php echo ($page === 'home') ? ' active' : ''; ?>">Home</a></li>
                <li><a href="about.php" class="aiero-menu-link<?php echo ($page === 'about') ? ' active' : ''; ?>">About Us</a></li>
                <li><a href="products.php" class="aiero-menu-link<?php echo ($page === 'products') ? ' active' : ''; ?>">Products</a></li>
                <li><a href="gallery.php" class="aiero-menu-link<?php echo ($page === 'gallery') ? ' active' : ''; ?>">Gallery</a></li>
                <li><a href="index.php#services" class="aiero-menu-link<?php echo ($page === 'services') ? ' active' : ''; ?>">Services</a></li>
                <li><a href="contact.php" class="aiero-menu-link<?php echo ($page === 'contact') ? ' active' : ''; ?>">Contact</a></li>
            </ul>
            <button class="aiero-menu-toggle" aria-label="Toggle Menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="aiero-right-controls">
                <?php if ($page !== 'home'): ?>
                    <div class="aiero-search-login">
                        <button class="aiero-search-btn" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <a href="#" class="aiero-login-link"><i class="fa-regular fa-user"></i> Login</a>
                    </div>
                <?php endif; ?>
                <a href="<?php echo ($page === 'home') ? '#contact' : 'contact.php'; ?>" class="aiero-btn-capsule">Get in Touch</a>
            </div>
        </div>
    </nav>
