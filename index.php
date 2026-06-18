<?php
$pageName  = 'Home';
$pageTitle = 'Manthan Clinic | Dr. Aakash Sharma – Premium Healthcare in Jaipur';
$metaDesc  = 'Manthan Clinic offers world-class healthcare by Dr. Aakash Sharma, a leading physician with 15+ years of experience. Book your appointment today.';
$bp = defined('BASE_PATH') ? BASE_PATH : '';
require_once __DIR__.'/includes/header.php';
?>

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<section class="hero-section" id="home">
  <!-- Background blobs -->
  <div class="section-blob blob-1" style="top: -120px; right: -80px;"></div>
  <div class="section-blob blob-2" style="bottom: -60px; left: -60px;"></div>
  <div class="floating-circle circle-1" style="top: 15%; left: 8%; width: 80px; height: 80px;"></div>
  <div class="floating-circle circle-2" style="bottom: 20%; right: 12%;"></div>

  <div class="container-xl">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="hero-content">
          <div class="hero-badge" data-aos="fade-up" data-aos-delay="100">
            <i class="bi bi-shield-check"></i>
            <span>Trusted Healthcare Since 2009</span>
          </div>

          <h1 class="hero-title" data-aos="fade-up" data-aos-delay="200">
            Your Health Is Our<br>
            <span class="highlight">Greatest Priority</span>
          </h1>

          <p class="hero-text" data-aos="fade-up" data-aos-delay="300">
            Welcome to Manthan Clinic, where Dr. Aakash Sharma combines decades
            of clinical experience with compassionate, patient-centered care.
            From routine checkups to chronic disease management, we are here
            for every step of your wellness journey.
          </p>

          <div class="hero-actions" data-aos="fade-up" data-aos-delay="400">
            <a href="<?= $bp ?>/contact" class="btn-primary-custom hero-shimmer-btn">
              <i class="bi bi-calendar2-check"></i>
              Book Appointment
            </a>
            <a href="tel:+919876543210" class="btn-outline-custom">
              <i class="bi bi-telephone"></i>
              Call Now
            </a>
            <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>" target="_blank" class="btn-whatsapp-custom">
              <i class="bi bi-whatsapp"></i>
              WhatsApp
            </a>
          </div>

          <div class="hero-stats" data-aos="fade-up" data-aos-delay="500">
            <div class="hero-stat-item">
              <span class="stat-number">15+</span>
              <span class="stat-label">Years Experience</span>
            </div>
            <div class="hero-stat-item">
              <span class="stat-number">10K+</span>
              <span class="stat-label">Patients Treated</span>
            </div>
            <div class="hero-stat-item">
              <span class="stat-number">5★</span>
              <span class="stat-label">Patient Reviews</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="hero-image-wrapper hero-float-image" data-aos="fade-left" data-aos-delay="300">
          <!-- Glow behind image -->
          <div class="hero-glow-pulse" style="position:absolute;inset:-30px;background:radial-gradient(ellipse,var(--primary-light),transparent 70%);border-radius:50%;pointer-events:none;z-index:0;"></div>
          <img
            src="https://images.unsplash.com/photo-1612531386530-97286d97c2d2?q=80&w=800"
            alt="Dr. Aakash Sharma – Senior Physician at Manthan Clinic"
            loading="lazy"
            style="position:relative;z-index:1;"
          >
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     TRUST BAR
     ============================================================ -->
<section class="trust-bar">
  <div class="container-xl">
    <div class="row g-0">
      <div class="col-6 col-md-3">
        <div class="trust-item">
          <div class="trust-icon">
            <i class="bi bi-patch-check-fill"></i>
          </div>
          <h6>Experienced Doctor</h6>
          <p>15+ years of practice</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="trust-item">
          <div class="trust-icon">
            <i class="bi bi-shield-fill-check"></i>
          </div>
          <h6>Certified Specialist</h6>
          <p>MBBS, MD – Internal Medicine</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="trust-item">
          <div class="trust-icon">
            <i class="bi bi-heart-pulse-fill"></i>
          </div>
          <h6>Advanced Treatment</h6>
          <p>Modern medical technology</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="trust-item">
          <div class="trust-icon">
            <i class="bi bi-people-fill"></i>
          </div>
          <h6>Personalized Care</h6>
          <p>Tailored to your needs</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     ABOUT DOCTOR SECTION
     ============================================================ -->
<section class="section-padding about-section" id="about">
  <div class="section-blob blob-3" style="top: 20%; right: -5%;"></div>
  <div class="container-xl">
    <div class="row g-5 align-items-center">
      <div class="col-lg-5" data-aos="fade-right">
        <div class="about-image-wrapper about-float-image">
          <img
            src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=500&q=80"
            alt="Dr. Aakash Sharma – Physician at Manthan Clinic"
            class="img-fluid"
            loading="lazy"
          >
          <div class="about-exp-badge about-float-badge d-none d-md-block">
            <span class="years">15+</span>
            <span class="label">Years of Excellence</span>
          </div>
        </div>
      </div>

      <div class="col-lg-7" data-aos="fade-left">
        <span class="section-label">About Doctor</span>
        <h2>Meet Dr. Aakash Sharma</h2>
        <p class="text-secondary mb-3">
          <strong>MBBS, MD – Internal Medicine</strong>
        </p>
        <p class="text-secondary">
          Dr. Aakash Sharma is a highly respected physician with over 15 years of
          clinical experience in internal medicine, chronic disease management, and
          preventive healthcare. After earning his MBBS from Sawai Man Singh Medical
          College and his MD in Internal Medicine from AIIMS Delhi, he founded
          Manthan Clinic with a vision to deliver accessible, compassionate,
          and world-class medical care.
        </p>

        <ul class="about-info-list">
          <li>
            <i class="bi bi-award-fill"></i>
            <span><strong>MBBS</strong> – Sawai Man Singh Medical College, Jaipur</span>
          </li>
          <li>
            <i class="bi bi-award-fill"></i>
            <span><strong>MD (Internal Medicine)</strong> – AIIMS, New Delhi</span>
          </li>
          <li>
            <i class="bi bi-shield-check"></i>
            <span><strong>Certified</strong> – Diabetes &amp; Hypertension Management</span>
          </li>
          <li>
            <i class="bi bi-people"></i>
            <span><strong>Member</strong> – Indian Medical Association (IMA)</span>
          </li>
          <li>
            <i class="bi bi-trophy"></i>
            <span><strong>Recipient</strong> – Excellence in Healthcare Award 2022</span>
          </li>
        </ul>

        <a href="<?= $bp ?>/about" class="btn btn-primary header-btn">
          <i class="bi bi-arrow-right me-1"></i>Read Full Biography
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SERVICES SECTION
     ============================================================ -->
 

<!-- ============================================================
     SERVICES PARALLAX HIGHLIGHT — Full-Width Premium Showcase
     ============================================================ -->
<section class="services-parallax" id="parallax-services">
  <!-- Background layers -->
  <div class="parallax-bg-wrap" id="parallaxBg">
    <div class="parallax-bg-inner">
      <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=1920&q=80"
           alt="Medical consultation at Manthan Clinic" loading="lazy">
    </div>
  </div>
  <div class="parallax-overlay"></div>

  <!-- Decorative elements -->
  <span class="parallax-deco deco-icon">♰</span>
  <span class="parallax-deco deco-icon">+</span>
  <span class="parallax-deco deco-icon">✦</span>
  <span class="parallax-deco deco-icon">◇</span>
  <div class="parallax-deco glow-spot"></div>
  <div class="parallax-deco glow-spot"></div>
  <div class="parallax-deco float-circle"></div>
  <div class="parallax-deco float-circle"></div>

  <div class="container-xl parallax-content" data-aos="fade-up" data-aos-duration="800">
    <span class="parallax-label">Our Medical Services</span>
    <h2 class="parallax-title">Comprehensive Healthcare Solutions For Every Stage Of Life</h2>
    <p class="parallax-desc">From preventive screenings to specialized treatments, our expert team delivers world-class medical care tailored to your unique health needs.</p>

    <div class="parallax-cards-grid">
      <?php
      $parallaxServices = [
        ['icon' => 'bi-heart-pulse',  'title' => 'General Consultation', 'desc' => 'Expert medical evaluations & diagnosis'],
        ['icon' => 'bi-droplet-half', 'title' => 'Diabetes Care',        'desc' => 'Advanced diabetes management plans'],
        ['icon' => 'bi-cup-hot',      'title' => 'Child Healthcare',     'desc' => 'Gentle pediatric care for all ages'],
        ['icon' => 'bi-shield-plus',  'title' => 'Preventive Checkups',  'desc' => 'Annual screenings & wellness exams'],
      ];

      $cardDelays = [0, -1.5, -3, -4.5];
      foreach ($parallaxServices as $i => $ps) {
        echo '
        <div class="parallax-service-card" style="animation-delay: ' . $cardDelays[$i] . 's">
          <div class="ps-icon"><i class="bi ' . $ps['icon'] . '"></i></div>
          <h5>' . $ps['title'] . '</h5>
          <p>' . $ps['desc'] . '</p>
        </div>';
      }
      ?>
    </div>

    <div class="parallax-cta">
      <a href="<?= $bp ?>/services" class="btn-explore-services" id="exploreServicesBtn">
        Explore All Services <i class="bi bi-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- ============================================================
     WHY CHOOSE US
     ============================================================ -->
<section class="section-padding" id="why-choose">
  <div class="section-blob blob-1" style="top: -10%; right: -5%;"></div>
  <div class="floating-circle circle-2" style="top: 15%; left: 10%;"></div>
  <div class="container-xl">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">Why Choose Us</span>
      <h2>Why Patients Trust Manthan Clinic</h2>
      <p>We are committed to providing the highest standard of medical care in a warm and welcoming environment.</p>
    </div>

    <div class="row g-4">
      <?php
      $features = [
        ['icon' => 'bi-person-check', 'title' => 'Experienced Doctor', 'desc' => 'Over 15 years of clinical expertise in internal medicine.'],
        ['icon' => 'bi-building', 'title' => 'Modern Facilities', 'desc' => 'Well-equipped clinic with advanced diagnostic technology.'],
        ['icon' => 'bi-heart', 'title' => 'Personalized Care', 'desc' => 'Every treatment plan is tailored to the individual patient.'],
        ['icon' => 'bi-calendar-check', 'title' => 'Easy Appointment', 'desc' => 'Online booking, minimal wait times, and flexible scheduling.'],
        ['icon' => 'bi-cash-coin', 'title' => 'Affordable Treatment', 'desc' => 'High-quality care at reasonable, transparent prices.'],
        ['icon' => 'bi-star', 'title' => 'Trusted by Patients', 'desc' => 'Consistently high ratings and heartfelt patient testimonials.'],
      ];

      $aosTypes = ['fade-up', 'flip-up', 'fade-up', 'zoom-in', 'fade-up', 'flip-up'];
      foreach ($features as $i => $f) {
        $delay = ($i % 3) * 100;
        $num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $aosType = $aosTypes[$i];
        echo "
        <div class='col-md-6 col-lg-4' data-aos='{$aosType}' data-aos-delay='{$delay}'>
          <div class='feature-box'>
            <span class='feature-number feature-number-pulse'>{$num}</span>
            <div class='feature-icon feature-float-icon'>
              <i class='bi {$f['icon']}'></i>
            </div>
            <h5>{$f['title']}</h5>
            <p>{$f['desc']}</p>
          </div>
        </div>";
      }
      ?>
    </div>
  </div>
</section>

<!-- ============================================================
     STATISTICS SECTION
     ============================================================ -->
<section class="stats-section" id="statistics">
  <div class="floating-circle circle-3" style="top: 12%; left: 5%; width: 100px; height: 100px;"></div>
  <div class="floating-circle circle-1" style="bottom: 15%; right: 8%;"></div>
  <div class="section-blob blob-3" style="top: 50%; left: 50%;"></div>
  <div class="container-xl">
    <div class="row g-4">
      <?php
      $stats = [
        ['target' => 10000, 'suffix' => '+', 'label' => 'Patients Treated'],
        ['target' => 15,    'suffix' => '+', 'label' => 'Years Experience'],
        ['target' => 5000,  'suffix' => '+', 'label' => 'Positive Reviews'],
        ['target' => 98,    'suffix' => '%', 'label' => 'Patient Satisfaction'],
      ];

      foreach ($stats as $i => $st) {
        $pulseDelay = $i * 0.8;
        echo "
        <div class='col-6 col-lg-3' data-aos='zoom-in' data-aos-delay='" . ($i * 150) . "'>
          <div class='stat-item stat-pulse' style='animation-delay: {$pulseDelay}s'>
            <span class='stat-number'>
              <span class='counter' data-target='{$st['target']}' data-suffix='{$st['suffix']}'>0</span>
            </span>
            <span class='stat-label'>{$st['label']}</span>
          </div>
        </div>";
      }
      ?>
    </div>
  </div>
</section>

<!-- ============================================================
     GALLERY SECTION — Magazine Showcase
     ============================================================ -->
<section class="section-padding" id="gallery">
  <div class="section-blob blob-1" style="bottom: -5%; right: -5%;"></div>
  <div class="floating-circle circle-2" style="top: 10%; left: 5%;"></div>
  <div class="container-xl">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">Gallery</span>
      <h2>Inside Our Clinic</h2>
      <p>Take a virtual tour of our state-of-the-art medical facility designed for your comfort and well-being.</p>
    </div>

    <div class="gallery-showcase gallery-float-item" data-aos="fade-up" data-aos-delay="50">
      <?php
      $showcase = [
        ['src' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?q=80&w=1332', 'label' => 'Clinic Exterior',   'num' => '01'],
        ['src' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=600&q=80', 'label' => 'Reception Area',    'num' => '02'],
        ['src' => 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?auto=format&fit=crop&w=600&q=80', 'label' => 'Consultation Room', 'num' => '03'],
      ];
      ?>
      <a href="<?= $showcase[0]['src'] ?>" class="showcase-featured glightbox" data-gallery="clinic-gallery">
        <div class="gallery-light-sweep"></div>
        <img src="<?= $showcase[0]['src'] ?>" alt="<?= $showcase[0]['label'] ?>" loading="lazy">
        <div class="gallery-overlay">
          <span class="gallery-badge"><?= $showcase[0]['num'] ?></span>
          <div class="gallery-icon"><i class="bi bi-arrows-angle-expand"></i></div>
          <span class="gallery-label"><?= $showcase[0]['label'] ?></span>
          <span class="gallery-corner tl"></span>
          <span class="gallery-corner br"></span>
        </div>
      </a>
      <div class="showcase-grid">
        <?php for ($i = 1; $i <= 2; $i++): ?>
        <a href="<?= $showcase[$i]['src'] ?>" class="showcase-grid-item glightbox" data-gallery="clinic-gallery">
          <div class="gallery-light-sweep" style="animation-duration: 10s;"></div>
          <img src="<?= $showcase[$i]['src'] ?>" alt="<?= $showcase[$i]['label'] ?>" loading="lazy">
          <div class="gallery-overlay">
            <span class="gallery-badge"><?= $showcase[$i]['num'] ?></span>
            <div class="gallery-icon"><i class="bi bi-arrows-angle-expand"></i></div>
            <span class="gallery-label"><?= $showcase[$i]['label'] ?></span>
            <span class="gallery-corner tl"></span>
            <span class="gallery-corner br"></span>
          </div>
        </a>
        <?php endfor; ?>
      </div>
    </div>

    <div class="gallery-strip">
      <?php
      $strip = [
        ['src' => 'https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=600&q=80', 'label' => 'Medical Equipment', 'num' => '04'],
        ['src' => 'https://images.unsplash.com/photo-1584982751601-97dcc096659c?auto=format&fit=crop&w=600&q=80', 'label' => 'Waiting Lounge',     'num' => '05'],
        ['src' => 'https://images.unsplash.com/photo-1559757175-5700dde675bc?auto=format&fit=crop&w=600&q=80', 'label' => 'Treatment Room',    'num' => '06'],
      ];
      foreach ($strip as $i => $s):
      ?>
      <a href="<?= $s['src'] ?>" class="strip-item glightbox gallery-float-item" data-gallery="clinic-gallery">
        <div class="gallery-light-sweep" style="animation-duration: 12s;"></div>
        <img src="<?= $s['src'] ?>" alt="<?= $s['label'] ?>" loading="lazy">
        <div class="gallery-overlay">
          <span class="gallery-badge"><?= $s['num'] ?></span>
          <div class="gallery-icon"><i class="bi bi-arrows-angle-expand"></i></div>
          <span class="gallery-label"><?= $s['label'] ?></span>
          <span class="gallery-corner tl"></span>
          <span class="gallery-corner br"></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <div class="gallery-cta" data-aos="fade-up" data-aos-delay="350">
      <a href="<?= $bp ?>/gallery" class="btn-gallery">
        View Full Gallery <i class="bi bi-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- ============================================================
     TESTIMONIALS SECTION — Premium Showcase
     ============================================================ -->
<section class="section-padding light-bg" id="testimonials">
  <div class="section-blob blob-2" style="top: -5%; right: -3%;"></div>
  <div class="section-blob blob-1" style="bottom: -5%; left: -3%;"></div>
  <div class="container-xl">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">Testimonials</span>
      <h2>What Our Patients Say</h2>
      <p>Hear from the patients who have experienced the Manthan Clinic difference firsthand.</p>
    </div>

    <?php
    $testimonials = [
      [
        'img'  => 'https://randomuser.me/api/portraits/women/44.jpg',
        'name' => 'Priya Patel',
        'role' => 'Regular Patient',
        'text' => 'Dr. Sharma is incredibly thorough and compassionate. He takes the time to explain everything clearly. I have been coming here for years and highly recommend him.',
        'stars' => 5,
      ],
      [
        'img'  => 'https://randomuser.me/api/portraits/men/32.jpg',
        'name' => 'Ravi Kumar',
        'role' => 'Diabetes Patient',
        'text' => 'After struggling with diabetes management for years, Dr. Sharma helped me get my blood sugar under control with a personalized treatment plan. Truly life-changing.',
        'stars' => 5,
      ],
      [
        'img'  => 'https://randomuser.me/api/portraits/women/68.jpg',
        'name' => 'Anita Singh',
        'role' => 'Parent',
        'text' => 'The best pediatric care in the city. My children love visiting Dr. Sharma. The staff is friendly and the clinic is always clean and welcoming.',
        'stars' => 5,
      ],
      [
        'img'  => 'https://randomuser.me/api/portraits/men/46.jpg',
        'name' => 'Vikram Mehta',
        'role' => 'Hypertension Patient',
        'text' => 'Professional, knowledgeable, and always available when needed. Dr. Sharma helped me bring my blood pressure under control through a combination of lifestyle changes and the right medication.',
        'stars' => 5,
      ],
      [
        'img'  => 'https://randomuser.me/api/portraits/women/26.jpg',
        'name' => 'Sneha Desai',
        'role' => 'Annual Checkup',
        'text' => 'I went for my annual preventive health checkup and was impressed by the thoroughness of the screening. The results were explained in simple terms. Great experience overall.',
        'stars' => 4,
      ],
      [
        'img'  => 'https://randomuser.me/api/portraits/men/75.jpg',
        'name' => 'Amit Verma',
        'role' => 'General Patient',
        'text' => 'I appreciate the modern approach to healthcare at Manthan Clinic. Digital prescriptions, online access to lab reports, and minimal waiting time. Truly remarkable.',
        'stars' => 5,
      ],
    ];
    ?>

    <div class="testimonial-carousel-wrap" data-aos="fade-up" data-aos-delay="100">
      <div class="testimonial-track-wrapper">
        <div class="testimonial-track" id="testimonialTrack">
          <?php foreach ($testimonials as $i => $t):
            $stars = str_repeat('<i class="bi bi-star-fill"></i>', $t['stars']);
            if ($t['stars'] < 5) $stars .= str_repeat('<i class="bi bi-star"></i>', 5 - $t['stars']);
          ?>
          <div class="testimonial-slide<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>">
            <div class="testimonial-card testimonial-float-card" style="animation-delay: <?= $i * 0.5 ?>s">
              <span class="quote-icon testimonial-float-quote">&ldquo;</span>
              <img src="<?= $t['img'] ?>" alt="<?= $t['name'] ?>" class="testimonial-avatar" loading="lazy">
              <div class="testimonial-stars"><?= $stars ?></div>
              <p><?= $t['text'] ?></p>
              <h6><?= $t['name'] ?></h6>
              <span class="patient-role"><?= $t['role'] ?></span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="testimonial-controls">
        <button class="testimonial-prev" type="button" aria-label="Previous">
          <i class="bi bi-chevron-left"></i>
        </button>
        <div class="testimonial-dots" id="testimonialDots">
          <?php for ($d = 0; $d < max(1, count($testimonials) - 2); $d++): ?>
          <button class="testimonial-dot<?= $d === 0 ? ' active' : '' ?>" data-slide="<?= $d ?>"></button>
          <?php endfor; ?>
        </div>
        <button class="testimonial-next" type="button" aria-label="Next">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     FAQ SECTION — Premium Split Layout
     ============================================================ -->
<section class="section-padding light-bg" id="faq">
  <div class="section-blob blob-1" style="top: -5%; left: -3%;"></div>
  <div class="floating-circle circle-3" style="bottom: 10%; right: 6%;"></div>
  <div class="container-xl">
    <div class="faq-split">
      <!-- Left: Image Composition -->
      <div class="faq-visual" data-aos="fade-right" data-aos-delay="50">
        <div class="faq-image-main">
          <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=700&q=80"
               alt="Dr. Aakash Sharma consulting a patient at Manthan Clinic" loading="lazy">
        </div>
        <div class="faq-badge badge-1 faq-float-badge">
          <div class="badge-icon"><i class="bi bi-award"></i></div>
          <div class="badge-text">
            15+ Years
            <small>Clinical Experience</small>
          </div>
        </div>
        <div class="faq-badge badge-2 faq-float-badge" style="animation-delay: -1.5s;">
          <div class="badge-icon"><i class="bi bi-people"></i></div>
          <div class="badge-text">
            10,000+
            <small>Happy Patients</small>
          </div>
        </div>
        <div class="faq-badge badge-3 faq-float-badge" style="animation-delay: -3s;">
          <div class="badge-icon"><i class="bi bi-shield-check"></i></div>
          <div class="badge-text">
            Trusted
            <small>Healthcare Provider</small>
          </div>
        </div>
      </div>

      <!-- Right: FAQ Content -->
      <div class="faq-content" data-aos="fade-left" data-aos-delay="100">
        <span class="section-label">FAQ</span>
        <h2>Frequently Asked Questions</h2>
        <p class="faq-subtitle">We understand patients often have questions before visiting our clinic. Here are answers to some of the most common inquiries.</p>

        <div class="faq-list" id="faqList">
          <?php
          $faqs = [
            ['q' => 'What are your clinic timings?', 'a' => 'Our clinic is open Monday through Friday from 9:00 AM to 7:00 PM, and on Saturdays from 9:00 AM to 2:00 PM. We remain closed on Sundays and public holidays. For urgent medical needs outside these hours, please call our emergency line.'],
            ['q' => 'Do I need an appointment before visiting?', 'a' => 'While walk-in patients are welcome, we strongly recommend booking an appointment to ensure minimal waiting time. You can easily schedule a visit through our online booking form, call us at +91 98765 43210, or send a message on WhatsApp.'],
            ['q' => 'Do you offer preventive health checkups?', 'a' => 'Yes, we offer comprehensive annual health checkup packages that include blood tests, cardiac assessment, and lifestyle counseling. Our preventive care programs are designed to detect potential health issues early and keep you healthy.'],
            ['q' => 'What insurance plans do you accept?', 'a' => 'We accept most major health insurance providers including NIA, Star Health, HDFC Ergo, ICICI Lombard, and New India Assurance. Please bring your insurance card to your first visit. Contact us for a complete list of accepted plans.'],
            ['q' => 'Is emergency consultation available?', 'a' => 'Manthan Clinic is primarily an outpatient clinic. In case of a medical emergency, please call 108 or visit the nearest hospital emergency department. For urgent medical advice during clinic hours, call us at +91 98765 43210.'],
            ['q' => 'What should I bring for my first visit?', 'a' => 'Please bring a valid government-issued photo ID, your health insurance card (if applicable), any previous medical records, and a list of current medications. Arriving 15 minutes early helps us complete the registration smoothly.'],
            ['q' => 'How can I contact the clinic?', 'a' => 'You can reach us by phone at +91 98765 43210, email at info@manthanclinic.com, or via WhatsApp. Our front desk is available during business hours to assist with appointments, inquiries, and prescription refills.'],
          ];

          foreach ($faqs as $i => $f) {
            $active = $i === 0 ? ' active' : '';
            echo "
          <div class='faq-item{$active}'>
            <button class='faq-question' type='button'>
              <span class='q-text'>{$f['q']}</span>
              <span class='q-icon'></span>
            </button>
            <div class='faq-answer-wrap'>
              <div class='faq-answer'>
                <div class='faq-answer-inner'>{$f['a']}</div>
              </div>
            </div>
          </div>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     CONTACT SECTION
     ============================================================ -->
<section class="section-padding light-bg" id="contact">
  <div class="section-blob blob-2" style="top: -3%; right: -3%;"></div>
  <div class="floating-circle circle-1" style="bottom: 8%; left: 5%;"></div>
  <div class="container-xl">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">Contact</span>
      <h2>Get In Touch</h2>
      <p>We are here to help. Reach out to us for appointments, inquiries, or any healthcare assistance you may need.</p>
    </div>

    <div class="row g-5">
      <div class="col-lg-7" data-aos="fade-right">
        <div class="contact-form-wrapper">
          <form action="<?= $bp ?>/contact_process.php" method="post" class="contact-form needs-validation" novalidate>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label" for="cname">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="cname" name="name" required placeholder="Your full name">
                <div class="invalid-feedback">Please enter your name.</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="cemail">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="cemail" name="email" required placeholder="Your email address">
                <div class="invalid-feedback">Please enter a valid email.</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="cphone">Phone Number</label>
                <input type="tel" class="form-control" id="cphone" name="phone" placeholder="Your phone number">
              </div>
              <div class="col-md-6">
                <label class="form-label" for="csubject">Subject</label>
                <input type="text" class="form-control" id="csubject" name="subject" placeholder="e.g. Appointment booking">
              </div>
              <div class="col-12">
                <label class="form-label" for="cmessage">Message <span class="text-danger">*</span></label>
                <textarea class="form-control" id="cmessage" name="message" rows="5" required placeholder="How can we help you?"></textarea>
                <div class="invalid-feedback">Please write a message.</div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary header-btn">
                  <i class="bi bi-send me-1"></i>Send Message
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="col-lg-5" data-aos="fade-left">
        <div class="contact-info-card contact-float-card">
          <h4 class="mb-4" style="font-family: var(--font-primary);">Contact Information</h4>

          <div class="contact-info-item">
            <div class="contact-info-icon contact-pulse-marker"><i class="bi bi-geo-alt-fill"></i></div>
            <div>
              <h6>Address</h6>
              <p>42, Wellness Avenue, Sector 14<br>Jaipur, Rajasthan – 302001</p>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-telephone-fill"></i></div>
            <div>
              <h6>Phone</h6>
              <a href="tel:+919876543210">+91 98765 43210</a>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-envelope-fill"></i></div>
            <div>
              <h6>Email</h6>
              <a href="mailto:info@manthanclinic.com">info@manthanclinic.com</a>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-clock-fill"></i></div>
            <div>
              <h6>Working Hours</h6>
              <p>Mon–Fri: 9:00 AM – 7:00 PM<br>Sat: 9:00 AM – 2:00 PM</p>
            </div>
          </div>

          <div class="mt-4 map-wrapper">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28447.632019581022!2d75.787902!3d26.912434!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db7b1b8b8b8b1%3A0xac2b3e1c5d5c5bec!2sJaipur%2C%20Rajasthan!5e0!3m2!1sen!2sin!4v1"
              width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"
              title="Manthan Clinic Location Map">
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__.'/includes/footer.php'; ?>
