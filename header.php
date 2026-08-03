<?php
require_once __DIR__ . '/config/app.php';

$site_name = get_setting('site_name') ?: 'Khodiyar Steel Industries';
$meta_title = get_setting('meta_title') ?: 'Khodiyar Steel – High-End Steel Furniture & Precision Metal Products';
$meta_desc = get_setting('meta_description') ?: 'Transforming spaces with high-end steel furniture and premium storage solutions.';
$site_logo = get_setting('site_logo') ?: 'assets/logo.png';
$site_favicon = get_setting('site_favicon') ?: 'assets/logo.png';
$og_img = get_setting('og_image') ?: 'assets/metal-bed-7201-01.webp';

$title = isset($title) ? $title : $meta_title;
$description = isset($description) ? $description : $meta_desc;
$page = isset($page) ? $page : "home";

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$project_dir = str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
$og_image_url = $protocol . $_SERVER['HTTP_HOST'] . $project_dir . $og_img;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?= $project_dir ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= htmlspecialchars($site_favicon) ?>" type="image/png">

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
<?php
$schema_name = get_setting('site_name') ?: 'Khodiyar Steel Industries';
$schema_phone = get_setting('site_phone') ?: '+919099999266';
$schema_address = get_setting('site_address') ?: 'Block no 9, Rd Number 5, Udhana GIDC, Surat, Gujarat 394210';
$schema_hours = get_setting('working_hours') ?: 'Mon-Sat: 9:00 AM - 6:00 PM';
$schema_fb = get_setting('facebook_url') ?: 'https://www.facebook.com/khodiyarsteel';
$schema_ig = get_setting('instagram_url') ?: 'https://www.instagram.com/khodiyarsteel';
preg_match('/\d{1,2}:\d{2}\s*(AM|PM)/i', $schema_hours, $opens_match);
$opens_time = $opens_match[0] ?? '09:00 AM';
preg_match('/\d{1,2}:\d{2}\s*(AM|PM)/i', substr($schema_hours, strpos($schema_hours, '-') + 1), $closes_match);
$closes_time = $closes_match[0] ?? '06:00 PM';
$opens_24 = date('H:i', strtotime($opens_time));
$closes_24 = date('H:i', strtotime($closes_time));
?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "<?= htmlspecialchars($schema_name) ?>",
      "image": "<?= htmlspecialchars($og_image_url) ?>",
      "@id": "<?= htmlspecialchars($current_url) ?>",
      "url": "<?= htmlspecialchars($protocol . $_SERVER['HTTP_HOST'] . $project_dir) ?>",
      "telephone": "<?= htmlspecialchars($schema_phone) ?>",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?= htmlspecialchars($schema_address) ?>",
        "addressLocality": "Surat",
        "addressRegion": "Gujarat",
        "postalCode": "394210",
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
        "opens": "<?= $opens_24 ?>",
        "closes": "<?= $closes_24 ?>"
      },
      "sameAs": [
        "<?= htmlspecialchars($schema_fb) ?>",
        "<?= htmlspecialchars($schema_ig) ?>"
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
    <link rel="stylesheet" href="style.css?v=1.6">
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
                <img src="<?= htmlspecialchars($site_logo) ?>" alt="<?= htmlspecialchars($site_name) ?>">
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
                <a href="<?php echo ($page === 'home') ? '#contact' : 'contact'; ?>" class="aiero-btn-capsule">Get in Touch</a>
            </div>
        </div>
    </nav>
