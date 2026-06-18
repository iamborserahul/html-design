<?php
require_once __DIR__.'/config.php';

$pageName   = isset($pageName)        ? $pageName        : 'Home';
$pageTitle  = isset($pageTitle)       ? $pageTitle       : 'Manthan Clinic | Dr. Aakash Sharma – Premium Healthcare';
$metaDesc   = isset($metaDesc)        ? $metaDesc        : 'Manthan Clinic offers world-class medical care led by Dr. Aakash Sharma. Book your appointment today for trusted, personalised healthcare.';
$canonical  = SITE_URL . $_SERVER['REQUEST_URI'];
$ogImage    = SITE_URL . '/assets/images/og-image.jpg';
$assets     = BASE_PATH . '/assets';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
  <meta name="keywords" content="doctor, clinic, healthcare, Dr Aakash Sharma, Manthan Clinic, general physician">
  <meta name="author" content="Manthan Clinic">
  <link rel="canonical" href="<?= $canonical ?>">

  <meta property="og:type"        content="website">
  <meta property="og:title"       content="<?= htmlspecialchars($pageTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($metaDesc) ?>">
  <meta property="og:image"       content="<?= $ogImage ?>">
  <meta property="og:url"         content="<?= $canonical ?>">
  <meta property="og:site_name"   content="Manthan Clinic">

  <meta name="twitter:card"        content="summary_large_image">
  <meta name="twitter:title"       content="<?= htmlspecialchars($pageTitle) ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($metaDesc) ?>">
  <meta name="twitter:image"       content="<?= $ogImage ?>">

  <link rel="icon" type="image/png" href="<?= $assets ?>/images/favicon.png">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
  <link href="<?= $assets ?>/css/style.css" rel="stylesheet">

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "MedicalClinic",
    "name": "Manthan Clinic",
    "description": "Premium healthcare services by Dr. Aakash Sharma",
    "url": "<?= SITE_URL ?>",
    "telephone": "+91-98765-43210",
    "email": "info@manthanclinic.com",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "42, Wellness Avenue, Sector 14",
      "addressLocality": "Jaipur",
      "addressRegion": "Rajasthan",
      "postalCode": "302001",
      "addressCountry": "IN"
    },
    "openingHours": ["Mo-Fr 09:00-19:00", "Sa 09:00-14:00"],
    "medicalSpecialty": "General Practice",
    "physician": {
      "@type": "Physician",
      "name": "Dr. Aakash Sharma",
      "jobTitle": "MBBS, MD – Internal Medicine"
    }
  }
  </script>
</head>
<body>

<header class="site-header" id="siteHeader">
  <div class="container-xl">
    <nav class="navbar navbar-expand-lg p-0" id="mainNav">

      <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_PATH ?>/" aria-label="Manthan Clinic Home">
        <div class="brand-icon">
          <i class="bi bi-heart-pulse-fill"></i>
        </div>
        <div class="brand-text">
          <span class="brand-name">Manthan Clinic</span>
          <span class="brand-tagline">Dr. Aakash Sharma</span>
        </div>
      </a>

      <button class="navbar-toggler border-0 ms-auto me-2" type="button"
              data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
              aria-controls="mobileMenu" aria-label="Open navigation menu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="desktopNav">
        <ul class="navbar-nav gap-1 align-items-center me-3">
          <li class="nav-item"><a class="nav-link <?= $pageName==='Home'?'active':'' ?>"          href="<?= BASE_PATH ?>/">Home</a></li>
          <li class="nav-item"><a class="nav-link <?= $pageName==='About'?'active':'' ?>"         href="<?= BASE_PATH ?>/about">About</a></li>
          <li class="nav-item"><a class="nav-link <?= $pageName==='Services'?'active':'' ?>"      href="<?= BASE_PATH ?>/services">Services</a></li>
          <li class="nav-item"><a class="nav-link <?= $pageName==='Gallery'?'active':'' ?>"       href="<?= BASE_PATH ?>/gallery">Gallery</a></li>
          <li class="nav-item"><a class="nav-link <?= $pageName==='Testimonials'?'active':'' ?>"  href="<?= BASE_PATH ?>/testimonials">Testimonials</a></li>
          <li class="nav-item"><a class="nav-link <?= $pageName==='FAQ'?'active':'' ?>"           href="<?= BASE_PATH ?>/faq">FAQ</a></li>
          <li class="nav-item"><a class="nav-link <?= $pageName==='Contact'?'active':'' ?>"       href="<?= BASE_PATH ?>/contact">Contact</a></li>
        </ul>
        <div class="d-flex gap-2">
          <a href="tel:+919876543210" class="btn btn-outline-primary btn-sm header-btn">
            <i class="bi bi-telephone-fill me-1"></i>Call Now
          </a>
          <a href="<?= BASE_PATH ?>/contact" class="btn btn-primary btn-sm header-btn">
            <i class="bi bi-calendar2-check-fill me-1"></i>Appointment
          </a>
        </div>
      </div>

    </nav>
  </div>
</header>

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header border-bottom py-4">
    <div class="d-flex align-items-center gap-2">
      <div class="brand-icon brand-icon--sm">
        <i class="bi bi-heart-pulse-fill"></i>
      </div>
      <div>
        <div class="fw-bold text-dark">Manthan Clinic</div>
        <small class="text-muted">Dr. Aakash Sharma</small>
      </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav mobile-nav gap-1">
      <li><a class="mobile-nav-link <?= $pageName==='Home'?'active':'' ?>"         href="<?= BASE_PATH ?>/"><i class="bi bi-house-door me-2"></i>Home</a></li>
      <li><a class="mobile-nav-link <?= $pageName==='About'?'active':'' ?>"        href="<?= BASE_PATH ?>/about"><i class="bi bi-person-circle me-2"></i>About Doctor</a></li>
      <li><a class="mobile-nav-link <?= $pageName==='Services'?'active':'' ?>"     href="<?= BASE_PATH ?>/services"><i class="bi bi-grid me-2"></i>Services</a></li>
      <li><a class="mobile-nav-link <?= $pageName==='Gallery'?'active':'' ?>"      href="<?= BASE_PATH ?>/gallery"><i class="bi bi-images me-2"></i>Gallery</a></li>
      <li><a class="mobile-nav-link <?= $pageName==='Testimonials'?'active':'' ?>" href="<?= BASE_PATH ?>/testimonials"><i class="bi bi-chat-quote me-2"></i>Testimonials</a></li>
      <li><a class="mobile-nav-link <?= $pageName==='FAQ'?'active':'' ?>"          href="<?= BASE_PATH ?>/faq"><i class="bi bi-question-circle me-2"></i>FAQ</a></li>
      <li><a class="mobile-nav-link <?= $pageName==='Contact'?'active':'' ?>"      href="<?= BASE_PATH ?>/contact"><i class="bi bi-envelope me-2"></i>Contact</a></li>
    </ul>
    <div class="mt-4 d-grid gap-2">
      <a href="tel:+919876543210" class="btn btn-outline-primary">
        <i class="bi bi-telephone-fill me-2"></i>Call Now
      </a>
      <a href="<?= BASE_PATH ?>/contact" class="btn btn-primary">
        <i class="bi bi-calendar2-check-fill me-2"></i>Book Appointment
      </a>
      <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>" target="_blank" class="btn btn-success">
        <i class="bi bi-whatsapp me-2"></i>WhatsApp Us
      </a>
    </div>
  </div>
</div>

<div class="header-spacer"></div>
