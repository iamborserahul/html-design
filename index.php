<?php
$pageTitle = 'Vérité Beauty & Salon – Premium Luxury Salon in New York';
$pageDescription = 'Experience unparalleled luxury at Vérité Beauty & Salon. Expert hair styling, bridal makeup, skincare, nail art & spa therapy in NYC.';
require_once 'includes/header.php';
?>

<!-- ============================================
     HERO
     ============================================ -->
<section class="hero-section" id="home">
  <video class="hero-video" autoplay muted loop playsinline poster="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80">
    <source src="https://cdn.coverr.co/videos/coverr-woman-getting-her-hair-done-at-a-salon-5763/1080p.mp4" type="video/mp4">
  </video>
  <div class="hero-overlay"></div>

  <div class="hero-float hero-float-1"></div>
  <div class="hero-float hero-float-2"></div>
  <div class="hero-float hero-float-3"></div>

  <div class="container position-relative z-2">
    <div class="row">
      <div class="col-lg-8">
        <div class="hero-content">
          <span class="hero-tagline">New York's Finest Beauty Destination</span>
          <h1 class="hero-title">
            <span class="line-reveal">Where Elegance</span><br>
            <span class="line-reveal">Meets <span class="text-gold">Excellence</span></span>
          </h1>
          <p class="hero-subtitle">Step into a world of refined beauty and indulge in the ultimate luxury experience. Our world-class artisans craft perfection, one exquisite detail at a time.</p>
          <div class="hero-buttons mt-5">
            <a href="/contact.php" class="btn-luxury">Book Appointment <i class="fas fa-arrow-right ms-2"></i></a>
            <a href="/services.php" class="btn-luxury-outline-light">View Services</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="hero-scroll-indicator">
    <span>Discover</span>
    <div class="scroll-line"></div>
  </div>
</section>

<!-- ============================================
     INTRO
     ============================================ -->
<section class="intro-section" id="intro">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1200">
        <div class="intro-image">
          <img src="https://images.unsplash.com/photo-1633681926024-8ef6e8c5b182?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Vérité Beauty Salon Interior" loading="lazy">
        </div>
      </div>
      <div class="col-lg-6">
        <div class="intro-content">
          <span class="section-tag">Our Philosophy</span>
          <h2 class="section-title">Where Beauty Becomes <span class="text-gradient">Art</span></h2>
          <div class="gold-divider"></div>
          <p class="section-subtitle mt-4">At Vérité, we believe that true beauty is an art form. Nestled in the heart of Manhattan, our sanctuary offers an immersive experience where every treatment is a masterpiece, every detail is intentional, and every guest is treated to uncompromising luxury.</p>
          <p class="section-subtitle mt-3">From the moment you step through our doors, you'll be enveloped in an atmosphere of serene elegance — where soft lighting, curated scents, and the gentle hum of creativity set the stage for your transformation.</p>
          <div class="intro-signature">— Curated with love, delivered with precision.</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================
     STATISTICS
     ============================================ -->
<section class="stats-section" id="stats">
  <div class="container">
    <div class="row justify-content-center text-center mb-4">
      <div class="col-lg-8">
        <span class="section-tag text-center text-gold">By The Numbers</span>
        <h2 class="section-title text-light">A Legacy of <span class="text-gold">Excellence</span></h2>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-6 col-lg-3">
        <div class="stat-item" data-aos="zoom-in" data-aos-duration="800">
          <span class="stat-number" data-count="15000">0</span><span class="stat-plus">+</span>
          <span class="stat-label">Happy Clients</span>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-item" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="100">
          <span class="stat-number" data-count="45">0</span><span class="stat-plus">+</span>
          <span class="stat-label">Beauty Experts</span>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-item" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="200">
          <span class="stat-number" data-count="12">0</span><span class="stat-plus">+</span>
          <span class="stat-label">Years Experience</span>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-item" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="300">
          <span class="stat-number" data-count="85000">0</span><span class="stat-plus">+</span>
          <span class="stat-label">Treatments</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================
     SERVICES – HORIZONTAL SCROLL
     ============================================ -->
<section class="services-section" id="services">
  <div class="container mb-5">
    <div class="row align-items-end">
      <div class="col-lg-8">
        <span class="section-tag">Our Expertise</span>
        <h2 class="section-title">Indulge in <span class="text-gradient">Luxury</span> Services</h2>
        <div class="gold-divider"></div>
      </div>
      <div class="col-lg-4 text-lg-end" data-aos="fade-up" data-aos-delay="150">
        <a href="/services.php" class="btn-luxury-outline">Explore All <i class="fas fa-arrow-right ms-2"></i></a>
      </div>
    </div>
  </div>

  <div class="horizontal-scroll-wrapper">
    <div class="horizontal-scroll-content">
      <div class="service-card">
        <img class="service-card-image" src="https://images.unsplash.com/photo-1560869713-7d0a29430803?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Hair Styling" loading="lazy">
        <div class="service-card-overlay"></div>
        <div class="service-card-content">
          <div class="service-card-icon"><i class="fas fa-cut"></i></div>
          <h3 class="service-card-title">Hair Styling</h3>
          <p class="service-card-desc">Precision cuts and bespoke styling tailored to your unique vision.</p>
          <span class="service-card-price">From $180</span>
        </div>
      </div>
      <div class="service-card">
        <img class="service-card-image" src="https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Hair Coloring" loading="lazy">
        <div class="service-card-overlay"></div>
        <div class="service-card-content">
          <div class="service-card-icon"><i class="fas fa-palette"></i></div>
          <h3 class="service-card-title">Hair Coloring</h3>
          <p class="service-card-desc">Luxurious color treatments from subtle highlights to bold transformations.</p>
          <span class="service-card-price">From $250</span>
        </div>
      </div>
      <div class="service-card">
        <img class="service-card-image" src="https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Bridal Makeup" loading="lazy">
        <div class="service-card-overlay"></div>
        <div class="service-card-content">
          <div class="service-card-icon"><i class="fas fa-spa"></i></div>
          <h3 class="service-card-title">Bridal Makeup</h3>
          <p class="service-card-desc">Breathtaking bridal beauty for your most unforgettable day.</p>
          <span class="service-card-price">From $450</span>
        </div>
      </div>
      <div class="service-card">
        <img class="service-card-image" src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Skin Treatment" loading="lazy">
        <div class="service-card-overlay"></div>
        <div class="service-card-content">
          <div class="service-card-icon"><i class="fas fa-hand-sparkles"></i></div>
          <h3 class="service-card-title">Skin Treatment</h3>
          <p class="service-card-desc">Advanced facials and rejuvenating therapies for radiant skin.</p>
          <span class="service-card-price">From $200</span>
        </div>
      </div>
      <div class="service-card">
        <img class="service-card-image" src="https://images.unsplash.com/photo-1604654894610-df63bc536371?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Nail Art" loading="lazy">
        <div class="service-card-overlay"></div>
        <div class="service-card-content">
          <div class="service-card-icon"><i class="fas fa-hand-peace"></i></div>
          <h3 class="service-card-title">Nail Art</h3>
          <p class="service-card-desc">Exquisite nail designs crafted with precision and artistic flair.</p>
          <span class="service-card-price">From $90</span>
        </div>
      </div>
      <div class="service-card">
        <img class="service-card-image" src="https://images.unsplash.com/photo-1540555700478-4be289fbec6d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Spa Therapy" loading="lazy">
        <div class="service-card-overlay"></div>
        <div class="service-card-content">
          <div class="service-card-icon"><i class="fas fa-hot-tub"></i></div>
          <h3 class="service-card-title">Spa Therapy</h3>
          <p class="service-card-desc">Holistic wellness treatments to restore balance and harmony.</p>
          <span class="service-card-price">From $280</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================
     BEFORE & AFTER
     ============================================ -->
<section class="before-after-section" id="before-after">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <span class="section-tag text-center text-gold">Transformations</span>
        <h2 class="section-title text-light">Before & <span class="text-gold">After</span></h2>
        <div class="section-ornament">
          <span class="line"></span>
          <span class="diamond"></span>
          <span class="line"></span>
        </div>
        <p class="section-subtitle light mx-auto">Witness the artistry of our expert stylists through real transformations.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <div class="comparison-slider" data-aos="fade-up">
          <div class="comparison-after">
            <img src="https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="After transformation">
          </div>
          <div class="comparison-before">
            <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Before transformation">
          </div>
          <div class="comparison-handle"></div>
          <span class="comparison-label comparison-label-before">Before</span>
          <span class="comparison-label comparison-label-after">After</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================
     MEET OUR EXPERTS
     ============================================ -->
<section class="team-section" id="team">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <span class="section-tag text-center">Our Artisans</span>
        <h2 class="section-title">Meet Our <span class="text-gradient">Experts</span></h2>
        <div class="section-ornament">
          <span class="line"></span>
          <span class="diamond"></span>
          <span class="line"></span>
        </div>
        <p class="section-subtitle mx-auto">Visionary artists dedicated to the pursuit of beauty excellence.</p>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="team-card" data-aos="fade-up" data-aos-delay="50">
          <div class="team-card-image">
            <img src="https://images.unsplash.com/photo-1580618672591-eb180b1a973f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Sophia Laurent" loading="lazy">
            <div class="team-card-overlay">
              <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
              <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
              <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
            </div>
          </div>
          <h4 class="team-card-name">Sophia Laurent</h4>
          <p class="team-card-role">Creative Director & Master Stylist</p>
          <span class="team-card-badge">18 Years Experience</span>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="team-card" data-aos="fade-up" data-aos-delay="100">
          <div class="team-card-image">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Marcus Chen" loading="lazy">
            <div class="team-card-overlay">
              <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
              <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
              <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
            </div>
          </div>
          <h4 class="team-card-name">Marcus Chen</h4>
          <p class="team-card-role">Color Specialist</p>
          <span class="team-card-badge">14 Years Experience</span>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="team-card" data-aos="fade-up" data-aos-delay="150">
          <div class="team-card-image">
            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Elena Voss" loading="lazy">
            <div class="team-card-overlay">
              <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
              <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
              <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
            </div>
          </div>
          <h4 class="team-card-name">Elena Voss</h4>
          <p class="team-card-role">Bridal & Makeup Artist</p>
          <span class="team-card-badge">10 Years Experience</span>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="team-card" data-aos="fade-up" data-aos-delay="200">
          <div class="team-card-image">
            <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="James Whitfield" loading="lazy">
            <div class="team-card-overlay">
              <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
              <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
              <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
            </div>
          </div>
          <h4 class="team-card-name">James Whitfield</h4>
          <p class="team-card-role">Skincare & Spa Director</p>
          <span class="team-card-badge">16 Years Experience</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================
     SOCIAL MEDIA WALL
     ============================================ -->
<section class="social-wall" id="social">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <span class="section-tag text-center text-gold">Follow Us</span>
        <h2 class="section-title text-light"><span class="text-gold">@Vérité</span> on Social</h2>
        <div class="section-ornament">
          <span class="line"></span>
          <span class="diamond"></span>
          <span class="line"></span>
        </div>
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
              <span class="social-card-label">Instagram Reel</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="social-card">
            <video loop muted playsinline poster="https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80">
              <source src="https://cdn.coverr.co/videos/coverr-woman-getting-her-hair-done-at-a-salon-5763/1080p.mp4" type="video/mp4">
            </video>
            <div class="social-card-overlay">
              <span class="social-card-icon"><i class="fab fa-facebook-f"></i></span>
              <span class="social-card-label">Facebook Video</span>
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
              <span class="social-card-label">YouTube Short</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="social-card">
            <video loop muted playsinline poster="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80">
              <source src="https://cdn.coverr.co/videos/coverr-woman-getting-her-hair-done-at-a-salon-5763/1080p.mp4" type="video/mp4">
            </video>
            <div class="social-card-overlay">
              <span class="social-card-icon"><i class="fab fa-tiktok"></i></span>
              <span class="social-card-label">TikTok Video</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="social-card">
            <video loop muted playsinline poster="https://images.unsplash.com/photo-1604654894610-df63bc536371?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80">
              <source src="https://cdn.coverr.co/videos/coverr-woman-getting-her-hair-done-at-a-salon-5763/1080p.mp4" type="video/mp4">
            </video>
            <div class="social-card-overlay">
              <span class="social-card-icon"><i class="fab fa-instagram"></i></span>
              <span class="social-card-label">Instagram Reel</span>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="social-card">
            <video loop muted playsinline poster="https://images.unsplash.com/photo-1540555700478-4be289fbec6d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80">
              <source src="https://cdn.coverr.co/videos/coverr-woman-getting-her-hair-done-at-a-salon-5763/1080p.mp4" type="video/mp4">
            </video>
            <div class="social-card-overlay">
              <span class="social-card-icon"><i class="fab fa-facebook-f"></i></span>
              <span class="social-card-label">Facebook Video</span>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination mt-4 position-relative"></div>
    </div>
  </div>
</section>

<!-- ============================================
     FEATURED GALLERY
     ============================================ -->
<section class="gallery-section" id="gallery">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <span class="section-tag text-center">Portfolio</span>
        <h2 class="section-title">Our <span class="text-gradient">Gallery</span></h2>
        <div class="section-ornament">
          <span class="line"></span>
          <span class="diamond"></span>
          <span class="line"></span>
        </div>
      </div>
    </div>

    <div class="gallery-filters" data-aos="fade-up" data-aos-delay="100">
      <button class="gallery-filter active" data-filter="*">All</button>
      <button class="gallery-filter" data-filter="hair">Hair</button>
      <button class="gallery-filter" data-filter="makeup">Makeup</button>
      <button class="gallery-filter" data-filter="nails">Nails</button>
      <button class="gallery-filter" data-filter="spa">Spa</button>
    </div>

    <div class="masonry-grid" data-aos="fade-up" data-aos-delay="150">
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
        <a href="https://images.unsplash.com/photo-1540555700478-4be289fbec6d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Spa Therapy">
          <img src="https://images.unsplash.com/photo-1540555700478-4be289fbec6d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Spa" loading="lazy">
          <div class="gallery-item-overlay"><i class="fas fa-expand"></i></div>
        </a>
      </div>
      <div class="gallery-item" data-category="makeup">
        <a href="https://images.unsplash.com/photo-1519014816548-bf5fe059798b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" data-fancybox="gallery" data-caption="Editorial Makeup">
          <img src="https://images.unsplash.com/photo-1519014816548-bf5fe059798b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Makeup" loading="lazy">
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
    </div>

    <div class="text-center mt-5" data-aos="fade-up">
      <a href="/gallery.php" class="btn-luxury-outline">View Full Gallery <i class="fas fa-arrow-right ms-2"></i></a>
    </div>
  </div>
</section>

<!-- ============================================
     CLIENT TESTIMONIALS
     ============================================ -->
<section class="testimonials-section" id="testimonials">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <span class="section-tag text-center">Testimonials</span>
        <h2 class="section-title">What Our <span class="text-gradient">Clients Say</span></h2>
        <div class="section-ornament">
          <span class="line"></span>
          <span class="diamond"></span>
          <span class="line"></span>
        </div>
      </div>
    </div>

    <div class="swiper testimonial-swiper" data-aos="fade-up">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="testimonial-card">
            <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
            <p class="testimonial-text">"An absolutely transcendent experience. Sophia transformed my hair into a work of art. The attention to detail and the atmosphere is simply unmatched in New York."</p>
            <div class="testimonial-author">
              <img class="testimonial-avatar" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Victoria" loading="lazy">
              <div>
                <div class="testimonial-name">Victoria Hayes</div>
                <div class="testimonial-role">Regular Client</div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="testimonial-card">
            <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
            <p class="testimonial-text">"I trusted Marcus with a complete color transformation for my wedding and the result was breathtaking. Every single guest complimented my hair."</p>
            <div class="testimonial-author">
              <img class="testimonial-avatar" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Amanda" loading="lazy">
              <div>
                <div class="testimonial-name">Amanda Foster</div>
                <div class="testimonial-role">Bridal Client</div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="testimonial-card">
            <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
            <p class="testimonial-text">"The spa therapy at Vérité is pure bliss. James curated a personalized treatment that left my skin glowing for weeks. This is not just a salon — it's a sanctuary."</p>
            <div class="testimonial-author">
              <img class="testimonial-avatar" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="David" loading="lazy">
              <div>
                <div class="testimonial-name">David Park</div>
                <div class="testimonial-role">Spa Member</div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="testimonial-card">
            <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
            <p class="testimonial-text">"Elena did my bridal makeup and I have never felt so gorgeous. She perfectly understood my vision and enhanced my natural beauty. Absolutely perfect."</p>
            <div class="testimonial-author">
              <img class="testimonial-avatar" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Jessica" loading="lazy">
              <div>
                <div class="testimonial-name">Jessica Torres</div>
                <div class="testimonial-role">Bridal Client</div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="testimonial-card">
            <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
            <p class="testimonial-text">"I've been coming to Vérité for over 5 years and the consistency of excellence is remarkable. Every visit feels like a special occasion. Worth every penny."</p>
            <div class="testimonial-author">
              <img class="testimonial-avatar" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Michael" loading="lazy">
              <div>
                <div class="testimonial-name">Michael Chen</div>
                <div class="testimonial-role">Premium Member</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination mt-4 position-relative"></div>
    </div>
  </div>
</section>

<!-- ============================================
     MEMBERSHIP PLANS
     ============================================ -->
<section class="membership-section" id="membership">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <span class="section-tag text-center">Membership</span>
        <h2 class="section-title">Choose Your <span class="text-gradient">Plan</span></h2>
        <div class="section-ornament">
          <span class="line"></span>
          <span class="diamond"></span>
          <span class="line"></span>
        </div>
        <p class="section-subtitle mx-auto">Exclusive benefits reserved for our discerning clientele.</p>
      </div>
    </div>
    <div class="row g-4 align-items-center">
      <div class="col-lg-4">
        <div class="membership-card" data-aos="fade-up" data-aos-delay="50">
          <div class="membership-name">Silver</div>
          <div class="membership-price">
            <span class="membership-price-currency">$</span>
            <span class="membership-price-amount">199</span>
            <span class="membership-price-period">per month</span>
          </div>
          <ul class="membership-features">
            <li><i class="fas fa-check"></i> 2 Signature Services per Month</li>
            <li><i class="fas fa-check"></i> 15% Off Additional Services</li>
            <li><i class="fas fa-check"></i> Priority Booking</li>
            <li><i class="fas fa-check"></i> Birthday Treatment</li>
            <li><i class="fas fa-check"></i> Complimentary Welcome Drink</li>
          </ul>
          <a href="/contact.php" class="btn-luxury-outline">Select Plan</a>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="membership-card featured" data-aos="fade-up" data-aos-delay="100">
          <span class="membership-badge">Most Popular</span>
          <div class="membership-name">Gold</div>
          <div class="membership-price">
            <span class="membership-price-currency">$</span>
            <span class="membership-price-amount">349</span>
            <span class="membership-price-period">per month</span>
          </div>
          <ul class="membership-features">
            <li><i class="fas fa-check"></i> 4 Signature Services per Month</li>
            <li><i class="fas fa-check"></i> 20% Off Additional Services</li>
            <li><i class="fas fa-check"></i> VIP Priority Booking</li>
            <li><i class="fas fa-check"></i> Birthday Treatment + Gift</li>
            <li><i class="fas fa-check"></i> Complimentary Drink & Snack</li>
            <li><i class="fas fa-check"></i> Seasonal Product Sample Kit</li>
          </ul>
          <a href="/contact.php" class="btn-luxury">Select Plan <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="membership-card" data-aos="fade-up" data-aos-delay="150">
          <div class="membership-name">Platinum</div>
          <div class="membership-price">
            <span class="membership-price-currency">$</span>
            <span class="membership-price-amount">599</span>
            <span class="membership-price-period">per month</span>
          </div>
          <ul class="membership-features">
            <li><i class="fas fa-check"></i> 6 Signature Services per Month</li>
            <li><i class="fas fa-check"></i> 25% Off All Services</li>
            <li><i class="fas fa-check"></i> Concierge Priority Booking</li>
            <li><i class="fas fa-check"></i> Birthday Luxury Gifting</li>
            <li><i class="fas fa-check"></i> Premium Drink & Gourmet Menu</li>
            <li><i class="fas fa-check"></i> Quarterly VIP Events Access</li>
            <li><i class="fas fa-check"></i> Complimentary Valet Parking</li>
          </ul>
          <a href="/contact.php" class="btn-luxury-outline">Select Plan</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================
     CURRENT OFFERS
     ============================================ -->
<section class="offers-section" id="offers">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <span class="section-tag text-center text-gold">Limited Time</span>
        <h2 class="section-title text-light">Current <span class="text-gold">Offers</span></h2>
        <div class="section-ornament">
          <span class="line"></span>
          <span class="diamond"></span>
          <span class="line"></span>
        </div>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="offer-card" data-aos="fade-up">
          <div class="offer-discount">30%<span class="offer-discount-label">Off</span></div>
          <h3 class="offer-title">Summer Glow Package</h3>
          <p class="offer-desc">Indulge in our signature facial, hydrating mask, and rejuvenating scalp massage. The ultimate summer refresh.</p>
          <div class="countdown" data-end="<?= date('Y-m-d\TH:i:s', strtotime('+7 days')) ?>">
            <div class="countdown-item"><span class="countdown-number countdown-days">00</span><span class="countdown-label">Days</span></div>
            <div class="countdown-item"><span class="countdown-number countdown-hours">00</span><span class="countdown-label">Hours</span></div>
            <div class="countdown-item"><span class="countdown-number countdown-mins">00</span><span class="countdown-label">Minutes</span></div>
            <div class="countdown-item"><span class="countdown-number countdown-secs">00</span><span class="countdown-label">Seconds</span></div>
          </div>
          <a href="/contact.php" class="btn-luxury mt-3">Book Now <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="offer-card" data-aos="fade-up" data-aos-delay="150">
          <div class="offer-discount">20%<span class="offer-discount-label">Off</span></div>
          <h3 class="offer-title">Bridal Beauty Consult</h3>
          <p class="offer-desc">Complimentary bridal consultation plus exclusive discount on full bridal package. Your dream look awaits.</p>
          <div class="countdown" data-end="<?= date('Y-m-d\TH:i:s', strtotime('+14 days')) ?>">
            <div class="countdown-item"><span class="countdown-number countdown-days">00</span><span class="countdown-label">Days</span></div>
            <div class="countdown-item"><span class="countdown-number countdown-hours">00</span><span class="countdown-label">Hours</span></div>
            <div class="countdown-item"><span class="countdown-number countdown-mins">00</span><span class="countdown-label">Minutes</span></div>
            <div class="countdown-item"><span class="countdown-number countdown-secs">00</span><span class="countdown-label">Seconds</span></div>
          </div>
          <a href="/contact.php" class="btn-luxury mt-3">Book Now <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================
     FAQ
     ============================================ -->
<section class="faq-section" id="faq">
  <div class="container">
    <div class="row">
      <div class="col-lg-5">
        <div class="faq-image" data-aos="fade-right">
          <img src="https://images.unsplash.com/photo-1633681926024-8ef6e8c5b182?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Vérité Salon" loading="lazy">
          <div class="faq-float faq-float-1"><i class="fas fa-question"></i></div>
          <div class="faq-float faq-float-2"><i class="fas fa-star"></i></div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="ps-lg-5">
          <span class="section-tag">FAQ</span>
          <h2 class="section-title">Frequently Asked <span class="text-gradient">Questions</span></h2>
          <div class="gold-divider"></div>
          <div class="faq-accordion mt-5" data-aos="fade-up" data-aos-delay="150">
            <div class="accordion" id="faqAccordion">
              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">What should I expect during my first visit?</button>
                </h3>
                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">From the moment you arrive, you'll be welcomed with a complimentary beverage and a personalized consultation. Our experts take time to understand your needs before crafting a bespoke treatment plan tailored just for you.</div>
                </div>
              </div>
              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">How do I book an appointment?</button>
                </h3>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">You can book through our online form, call us at (212) 555-0199, or reach out via WhatsApp. We recommend booking at least 48 hours in advance for preferred time slots.</div>
                </div>
              </div>
              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">What is your cancellation policy?</button>
                </h3>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">We kindly request 24-hour notice for cancellations or rescheduling. Late cancellations may incur a 50% service fee. Our team values your time and asks for the same courtesy.</div>
                </div>
              </div>
              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">Do you offer bridal trial sessions?</button>
                </h3>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">Absolutely! We strongly recommend a bridal trial session 4–6 weeks before your event. This allows us to perfect your look and ensure everything is flawless for your special day.</div>
                </div>
              </div>
              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">What products do you use?</button>
                </h3>
                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">We exclusively use premium, professional-grade products from luxury brands including Oribe, Kerastase, GHD, and La Mer. Every product is selected for its superior quality.</div>
                </div>
              </div>
              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">Is parking available?</button>
                </h3>
                <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">Yes, we offer valet parking for our Platinum members and validated parking at the adjacent garage for all guests. Our concierge team can assist with any transportation needs.</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
