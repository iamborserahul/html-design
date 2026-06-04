<?php
// Set default page variables if not defined
$title = isset($title) ? $title : "Khodiyar Steel – High-End Luxury Steel & Precision Metal Fabrication";
$description = isset($description) ? $description : "Transforming spaces with high-end luxury steel furniture, premium storage solutions, and state-of-the-art structural metal fabrication.";
$page = isset($page) ? $page : "home";

// Resolve dynamic URL helper variables for SEO tags
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$project_dir = str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
$og_image_url = $protocol . $_SERVER['HTTP_HOST'] . $project_dir . "assets/project1.jpg";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/logo.png" type="image/png">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($current_url); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($og_image_url); ?>">
    <meta property="og:site_name" content="Khodiyar Steel">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo htmlspecialchars($current_url); ?>">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($og_image_url); ?>">

    <!-- Schema.org JSON-LD Markup -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Khodiyar Steel Industries",
      "image": "<?php echo htmlspecialchars($og_image_url); ?>",
      "@id": "<?php echo htmlspecialchars($current_url); ?>",
      "url": "<?php echo htmlspecialchars($protocol . $_SERVER['HTTP_HOST'] . $project_dir); ?>",
      "telephone": "+918551004444",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Industrial Zone",
        "addressLocality": "Surat",
        "addressRegion": "Gujarat",
        "postalCode": "395003",
        "addressCountry": "IN"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 21.1702,
        "longitude": 72.8311
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday"
        ],
        "opens": "09:00",
        "closes": "18:00"
      },
      "sameAs": [
        "https://www.facebook.com/khodiyarsteel",
        "https://www.instagram.com/khodiyarsteel"
      ]
    }
    </script>

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
            <a href="./" class="aiero-logo">
                <img src="assets/logo.png" alt="Khodiyar Steel Industries">
            </a>
            <ul class="aiero-menu">
                <li><a href="./" class="aiero-menu-link<?php echo ($page === 'home') ? ' active' : ''; ?>">Home</a></li>
                <li><a href="about" class="aiero-menu-link<?php echo ($page === 'about') ? ' active' : ''; ?>">About Us</a></li>
                <li><a href="products" class="aiero-menu-link<?php echo ($page === 'products') ? ' active' : ''; ?>">Products</a></li>
                <li><a href="gallery" class="aiero-menu-link<?php echo ($page === 'gallery') ? ' active' : ''; ?>">Gallery</a></li>
                <li><a href="./#services" class="aiero-menu-link<?php echo ($page === 'services') ? ' active' : ''; ?>">Services</a></li>
                <li><a href="contact" class="aiero-menu-link<?php echo ($page === 'contact') ? ' active' : ''; ?>">Contact</a></li>
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
                <a href="<?php echo ($page === 'home') ? '#contact' : 'contact'; ?>" class="aiero-btn-capsule">Get in Touch</a>
            </div>
        </div>
    </nav>
