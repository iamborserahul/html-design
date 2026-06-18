<?php
$pageName  = 'Gallery';
$pageTitle = 'Photo Gallery | Manthan Clinic – See Our Premium Healthcare Facility';
$metaDesc  = 'Browse through our clinic gallery showcasing modern medical facilities, comfortable patient areas, and advanced treatment rooms at Manthan Clinic.';
$bp = defined('BASE_PATH') ? BASE_PATH : '';
require_once __DIR__.'/includes/header.php';
?>

<!-- ============================================================
     GALLERY HERO
     ============================================================ -->
<section class="gallery-hero">
  <div class="section-blob blob-1" style="top: -15%; right: -5%;"></div>
  <div class="section-blob blob-2" style="bottom: -15%; left: -5%;"></div>
  <div class="container-xl">
    <div class="hero-content" data-aos="fade-up">
      <h1>Our Clinic Gallery</h1>
      <p class="hero-sub">Step inside Manthan Clinic. Every detail of our facility has been thoughtfully designed to provide a comfortable, reassuring, and premium healthcare environment for you and your family.</p>
      <div class="hero-stat">
        <div>
          <strong>09</strong>
          <span>Featured Spaces</span>
        </div>
        <div>
          <strong>06</strong>
          <span>Treatment Areas</span>
        </div>
        <div>
          <strong>3,500+</strong>
          <span>sq. ft. Facility</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     GALLERY CONTENT
     ============================================================ -->
<section class="section-padding">
  <div class="section-blob blob-3" style="top: 20%; right: -5%;"></div>
  <div class="floating-circle circle-2" style="bottom: 5%; left: 5%;"></div>
  <div class="container-xl">

    <!-- Category Filters -->
    <div class="gallery-filter-wrap" data-aos="fade-up">
      <div class="gallery-filter-inner">
        <button class="filter-btn active" data-filter="all">All</button>
        <button class="filter-btn" data-filter="exterior">Clinic Exterior</button>
        <button class="filter-btn" data-filter="reception">Reception</button>
        <button class="filter-btn" data-filter="consultation">Consultation Rooms</button>
        <button class="filter-btn" data-filter="equipment">Equipment</button>
        <button class="filter-btn" data-filter="areas">Patient Areas</button>
        <button class="filter-btn" data-filter="facilities">Facilities</button>
      </div>
    </div>

    <!-- Masonry Grid -->
    <div class="gallery-masonry" id="galleryMasonry">
      <?php
      $galleryItems = [
        ['src' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?q=80&w=1332', 'label' => 'Clinic Exterior',      'cat' => 'exterior',     'cls' => 'featured'],
        ['src' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=600&q=80', 'label' => 'Reception Area',       'cat' => 'reception',    'cls' => ''],
        ['src' => 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?auto=format&fit=crop&w=600&q=80', 'label' => 'Consultation Room',    'cat' => 'consultation', 'cls' => 'tall'],
        ['src' => 'https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=600&q=80', 'label' => 'Medical Equipment',    'cat' => 'equipment',    'cls' => ''],
        ['src' => 'https://images.unsplash.com/photo-1584982751601-97dcc096659c?auto=format&fit=crop&w=600&q=80', 'label' => 'Patient Waiting Lounge','cat' => 'areas',        'cls' => 'wide'],
        ['src' => 'https://images.unsplash.com/photo-1559757175-5700dde675bc?auto=format&fit=crop&w=600&q=80', 'label' => 'Treatment Room',       'cat' => 'consultation', 'cls' => ''],
        ['src' => 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?auto=format&fit=crop&w=600&q=80', 'label' => 'Diagnostic Equipment',  'cat' => 'equipment',    'cls' => ''],
        ['src' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=600&q=80', 'label' => 'Patient Lounge',        'cat' => 'facilities',   'cls' => ''],
        ['src' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=600&q=80', 'label' => 'Building Front',        'cat' => 'exterior',     'cls' => ''],
      ];

      foreach ($galleryItems as $i => $item) {
        $cls = $item['cls'] ? ' ' . $item['cls'] : '';
        $num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        echo "
      <div class='gallery-filter-item visible gallery-item{$cls}' data-category='{$item['cat']}' data-aos='fade-up' data-aos-delay='" . (($i % 4) * 80) . "'>
        <a href='{$item['src']}' class='glightbox d-block h-100 w-100' data-gallery='clinic-gallery' data-description='{$item['label']}'>
          <div class='gallery-light-sweep' style='animation-duration: " . (8 + $i % 4) . "s;'></div>
          <img src='{$item['src']}' alt='{$item['label']} – Manthan Clinic' loading='lazy'>
          <div class='gallery-overlay'>
            <span class='gallery-badge'>{$num}</span>
            <div class='gallery-icon'><i class='bi bi-arrows-angle-expand'></i></div>
            <span class='gallery-label'>{$item['label']}</span>
            <span class='gallery-corner tl'></span>
            <span class='gallery-corner br'></span>
          </div>
        </a>
      </div>";
      }
      ?>
    </div>
  </div>
</section>

<!-- ============================================================
     CTA SECTION
     ============================================================ -->
<section class="stats-section">
  <div class="floating-circle circle-3" style="top: 10%; left: 15%; width: 80px; height: 80px; border-color: rgba(255,255,255,0.1);"></div>
  <div class="floating-circle circle-1" style="bottom: 15%; right: 10%; border-color: rgba(255,255,255,0.1);"></div>
  <div class="container-xl text-center">
    <h2 class="text-white mb-3" data-aos="fade-up">Experience Our Clinic in Person</h2>
    <p class="text-white opacity-75 mb-4" data-aos="fade-up" data-aos-delay="100" style="max-width: 600px; margin-left: auto; margin-right: auto;">
      We welcome you to visit Manthan Clinic for a personal tour. See our facilities and meet our team.
    </p>
    <div data-aos="fade-up" data-aos-delay="200">
      <a href="<?= $bp ?>/contact" class="btn btn-light btn-lg header-btn">
        <i class="bi bi-calendar2-check me-1"></i>Schedule a Visit
      </a>
    </div>
  </div>
</section>

<?php require_once __DIR__.'/includes/footer.php'; ?>
