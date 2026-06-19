<?php
$pageTitle = $pageTitle ?? 'Vérité Beauty & Salon – Premium Luxury Salon';
$pageDescription = $pageDescription ?? 'Experience luxury beauty at Vérité. Expert hair styling, bridal makeup, skincare, nail art & spa therapy in an elegant sanctuary.';
$pageImage = $pageImage ?? '/assets/images/og-image.jpg';
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?= htmlspecialchars($pageTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">

<meta property="og:type" content="website">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
<meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
<meta property="og:image" content="<?= htmlspecialchars($pageImage) ?>">
<meta property="og:url" content="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
<meta property="og:site_name" content="Vérité Beauty & Salon">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($pageImage) ?>">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BeautySalon",
  "name": "Vérité Beauty & Salon",
  "description": "Premium luxury salon offering hair styling, coloring, bridal makeup, skincare, nail art and spa therapy.",
  "url": "https://<?= $_SERVER['HTTP_HOST'] ?>",
  "telephone": "+1 (212) 555-0199",
  "email": "hello@veritebeauty.com",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "245 Madison Avenue, Suite 1200",
    "addressLocality": "New York",
    "addressRegion": "NY",
    "postalCode": "10016",
    "addressCountry": "US"
  },
  "openingHoursSpecification": [
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Monday", "opens": "09:00", "closes": "20:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Tuesday", "opens": "09:00", "closes": "20:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Wednesday", "opens": "09:00", "closes": "20:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Thursday", "opens": "09:00", "closes": "21:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Friday", "opens": "09:00", "closes": "21:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Saturday", "opens": "10:00", "closes": "18:00" }
  ],
  "image": "<?= htmlspecialchars($pageImage) ?>",
  "priceRange": "$$$$"
}
</script>

<link rel="canonical" href="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

<link rel="stylesheet" href="/assets/css/style.css?v=1.0">

<?php if (isset($extraCSS)): ?>
<?= $extraCSS ?>
<?php endif; ?>
</head>
<body>

<div id="preloader">
  <div class="preloader-inner">
    <div class="preloader-logo">VÉRITÉ</div>
    <div class="preloader-line"></div>
    <div class="preloader-sub">Beauty & Salon</div>
  </div>
</div>

<div class="cursor"></div>
<div class="cursor-follower"></div>

<div class="site-wrapper">

<header class="luxury-header" id="header">
  <div class="container-fluid px-4 px-xl-5">
    <nav class="navbar navbar-expand-xl px-0">
      <a class="navbar-brand d-flex align-items-center" href="/">
        <div>
          <span class="brand-logo">VÉRITÉ</span>
          <span class="brand-sub">Beauty & Salon</span>
        </div>
      </a>
      <button class="navbar-toggler hamburger" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span></span><span></span><span></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link <?= $currentPage === 'index.php' ? 'active' : '' ?>" href="/">Home</a></li>
          <li class="nav-item"><a class="nav-link <?= $currentPage === 'about.php' ? 'active' : '' ?>" href="/about.php">About</a></li>
          <li class="nav-item"><a class="nav-link <?= $currentPage === 'services.php' ? 'active' : '' ?>" href="/services.php">Services</a></li>
          <li class="nav-item"><a class="nav-link <?= $currentPage === 'gallery.php' ? 'active' : '' ?>" href="/gallery.php">Gallery</a></li>
          <li class="nav-item"><a class="nav-link <?= $currentPage === 'contact.php' ? 'active' : '' ?>" href="/contact.php">Contact</a></li>
        </ul>
        <div class="nav-actions d-flex align-items-center">
          <a href="/contact.php" class="btn-header-book">Book Appointment</a>
          <a href="tel:+12125550199" class="nav-phone ms-4 d-none d-xl-flex align-items-center"><i class="fas fa-phone-alt me-2"></i> (212) 555-0199</a>
        </div>
      </div>
    </nav>
  </div>
</header>
