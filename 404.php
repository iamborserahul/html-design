<?php
http_response_code(404);
$pageTitle = 'Page Not Found – Vérité Beauty & Salon';
$pageDescription = 'The page you are looking for does not exist. Please return to our homepage.';
require_once 'includes/header.php';
?>

<section class="page-hero" style="height:80vh;min-height:500px;">
  <img class="page-hero-bg" src="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="404" loading="lazy">
  <div class="page-hero-overlay"></div>
  <div class="container">
    <div class="page-hero-content text-center">
      <h1 class="display-1 text-gold fw-light" style="font-family:var(--font-serif);font-size:clamp(5rem,12vw,10rem);">404</h1>
      <h2 class="text-light display-5 mb-3" style="font-family:var(--font-serif);">Page Not Found</h2>
      <p class="text-light opacity-75 lead mb-5">The page you are looking for has moved or does not exist.<br>Let us guide you back to elegance.</p>
      <a href="/" class="btn-luxury">Return Home <i class="fas fa-arrow-right ms-2"></i></a>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
