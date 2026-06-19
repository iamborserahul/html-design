<?php
$pageTitle = 'Luxury Salon Gallery – Vérité Beauty & Salon NYC';
$pageDescription = 'Explore our portfolio of transformations. Hair, makeup, nails, and spa gallery showcasing the artistry of Vérité Beauty & Salon.';
require_once 'includes/header.php';
?>

<!-- HERO BANNER -->
<section class="page-hero">
  <img class="page-hero-bg" src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Gallery" loading="lazy">
  <div class="page-hero-overlay"></div>
  <div class="container">
    <div class="page-hero-content text-center">
      <div class="page-hero-breadcrumb"><a href="/">Home</a> / Gallery</div>
      <h1 class="page-hero-title">Our <span class="text-gold">Portfolio</span></h1>
      <p class="text-light opacity-75 lead mt-3 mx-auto max-w-600">A visual journey through our finest transformations and artistic expressions.</p>
    </div>
  </div>
</section>

<!-- MASONRY GALLERY -->
<section class="gallery-section" id="gallery-main">
  <div class="container">
    <div class="gallery-filters" data-aos="fade-up">
      <button class="gallery-filter active" data-filter="*">All</button>
      <button class="gallery-filter" data-filter="hair">Hair</button>
      <button class="gallery-filter" data-filter="makeup">Makeup</button>
      <button class="gallery-filter" data-filter="nails">Nails</button>
      <button class="gallery-filter" data-filter="spa">Spa</button>
      <button class="gallery-filter" data-filter="behind">Behind the Scenes</button>
    </div>

    <div class="masonry-grid" data-aos="fade-up" data-aos-delay="100">
      <div class="gallery-item" data-category="hair">
        <a href="https://images.unsplash.com/photo-1560869713-7d0a29430803?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Precision Haircut">
          <img src="https://images.unsplash.com/photo-1560869713-7d0a29430803?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Hair" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="makeup">
        <a href="https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Bridal Makeup">
          <img src="https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Makeup" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="nails">
        <a href="https://images.unsplash.com/photo-1604654894610-df63bc536371?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Luxury Nail Art">
          <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Nails" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="hair">
        <a href="https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Color Transformation">
          <img src="https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Color" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="spa">
        <a href="https://images.unsplash.com/photo-1540555700478-4be289fbec6d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Spa Therapy Room">
          <img src="https://images.unsplash.com/photo-1540555700478-4be289fbec6d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Spa" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="behind">
        <a href="https://images.unsplash.com/photo-1633681926024-8ef6e8c5b182?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Salon Interior">
          <img src="https://images.unsplash.com/photo-1633681926024-8ef6e8c5b182?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Salon" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="makeup">
        <a href="https://images.unsplash.com/photo-1519014816548-bf5fe059798b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Editorial Makeup">
          <img src="https://images.unsplash.com/photo-1519014816548-bf5fe059798b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Editorial" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="nails">
        <a href="https://images.unsplash.com/photo-1610992015732-2449b76344bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Nail Design">
          <img src="https://images.unsplash.com/photo-1610992015732-2449b76344bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Nails" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="hair">
        <a href="https://images.unsplash.com/photo-1521590832167-161aceb3b0f0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Blowout Style">
          <img src="https://images.unsplash.com/photo-1521590832167-161aceb3b0f0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Blowout" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="spa">
        <a href="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Facial Treatment">
          <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Facial" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="behind">
        <a href="https://images.unsplash.com/photo-1559357430-7e16d5cc2a6a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Our Team">
          <img src="https://images.unsplash.com/photo-1559357430-7e16d5cc2a6a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Team" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="makeup">
        <a href="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Glam Makeup">
          <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Glam" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- BEFORE & AFTER SHOWCASE -->
<section class="before-after-section" id="before-after">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <span class="section-tag text-center text-gold" data-aos="fade-up">Real Results</span>
        <h2 class="section-title text-light" data-aos="fade-up" data-aos-delay="80">Before & <span class="text-gold">After</span></h2>
        <div class="section-ornament"><span class="line"></span><span class="diamond"></span><span class="line"></span></div>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="comparison-slider" data-aos="fade-up">
          <div class="comparison-after">
            <img src="https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="After">
          </div>
          <div class="comparison-before">
            <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Before">
          </div>
          <div class="comparison-handle"></div>
          <span class="comparison-label comparison-label-before">Before</span>
          <span class="comparison-label comparison-label-after">After</span>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="comparison-slider" data-aos="fade-up" data-aos-delay="100">
          <div class="comparison-after">
            <img src="https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="After">
          </div>
          <div class="comparison-before">
            <img src="https://images.unsplash.com/photo-1519014816548-bf5fe059798b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Before">
          </div>
          <div class="comparison-handle"></div>
          <span class="comparison-label comparison-label-before">Before</span>
          <span class="comparison-label comparison-label-after">After</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SOCIAL MEDIA REELS SECTION -->
<section class="social-wall" id="social-reels">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <span class="section-tag text-center text-gold" data-aos="fade-up">Social Feeds</span>
        <h2 class="section-title text-light" data-aos="fade-up" data-aos-delay="80">Follow Us @<span class="text-gold">Vérité</span></h2>
        <div class="section-ornament"><span class="line"></span><span class="diamond"></span><span class="line"></span></div>
      </div>
    </div>
    <div class="swiper social-swiper" data-aos="fade-up">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="social-card">
            <video loop muted playsinline poster="https://images.unsplash.com/photo-1560869713-7d0a29430803?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80">
              <source src="https://cdn.coverr.co/videos/coverr-woman-getting-her-hair-done-at-a-salon-5763/1080p.mp4" type="video/mp4">
            </video>
            <div class="social-card-overlay">
              <span class="social-card-icon"><i class="fab fa-instagram"></i></span>
              <span class="social-card-label">Instagram</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="social-card">
            <video loop muted playsinline poster="https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80">
              <source src="https://cdn.coverr.co/videos/coverr-woman-getting-her-hair-done-at-a-salon-5763/1080p.mp4" type="video/mp4">
            </video>
            <div class="social-card-overlay">
              <span class="social-card-icon"><i class="fab fa-tiktok"></i></span>
              <span class="social-card-label">TikTok</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="social-card">
            <video loop muted playsinline poster="https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80">
              <source src="https://cdn.coverr.co/videos/coverr-woman-getting-her-hair-done-at-a-salon-5763/1080p.mp4" type="video/mp4">
            </video>
            <div class="social-card-overlay">
              <span class="social-card-icon"><i class="fab fa-youtube"></i></span>
              <span class="social-card-label">YouTube</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="social-card">
            <video loop muted playsinline poster="https://images.unsplash.com/photo-1604654894610-df63bc536371?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80">
              <source src="https://cdn.coverr.co/videos/coverr-woman-getting-her-hair-done-at-a-salon-5763/1080p.mp4" type="video/mp4">
            </video>
            <div class="social-card-overlay">
              <span class="social-card-icon"><i class="fab fa-facebook-f"></i></span>
              <span class="social-card-label">Facebook</span>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination mt-4 position-relative"></div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
