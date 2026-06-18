<?php
$pageName  = 'Testimonials';
$pageTitle = 'Patient Testimonials | Manthan Clinic – Hear from Our Patients';
$metaDesc  = 'Read genuine reviews and testimonials from patients at Manthan Clinic. Discover why Dr. Aakash Sharma is a trusted physician in Jaipur.';
$bp = defined('BASE_PATH') ? BASE_PATH : '';
require_once __DIR__.'/includes/header.php';
?>

<!-- ============================================================
     PAGE BANNER
     ============================================================ -->
<section class="page-banner">
  <div class="section-blob blob-1" style="top: -20%; right: -5%;"></div>
  <div class="section-blob blob-2" style="bottom: -20%; left: -5%;"></div>
  <div class="container-xl">
    <h1 data-aos="fade-up">Patient Testimonials</h1>
    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= $bp ?>/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
      </ol>
    </nav>
  </div>
</section>

<!-- ============================================================
     TESTIMONIALS GRID
     ============================================================ -->
<section class="section-padding">
  <div class="section-blob blob-3" style="top: 10%; right: -5%;"></div>
  <div class="floating-circle circle-1" style="bottom: 5%; left: 5%;"></div>
  <div class="container-xl">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">Patient Stories</span>
      <h2>What Our Patients Say About Us</h2>
      <p>We are proud of the trust our patients place in us. Here are some of their stories.</p>
    </div>

    <div class="row g-4" id="reviewsGrid">
      <?php
      $reviews = [
        [
          'img'   => 'https://randomuser.me/api/portraits/women/44.jpg',
          'name'  => 'Priya Patel',
          'date'  => 'Regular Patient for 3 years',
          'stars' => 5,
          'text'  => 'Dr. Sharma is incredibly thorough and compassionate. He takes the time to explain everything clearly, from diagnosis to treatment options. I never feel rushed during my visits. The clinic is always clean, and the staff is courteous. I have been coming here for three years and recommend him to everyone I know.',
        ],
        [
          'img'   => 'https://randomuser.me/api/portraits/men/32.jpg',
          'name'  => 'Ravi Kumar',
          'date'  => 'Diabetes Patient',
          'stars' => 5,
          'text'  => 'After struggling with diabetes management for years, Dr. Sharma helped me get my blood sugar under control. His personalized approach—combining medication adjustments with practical dietary changes—made all the difference. My HbA1c has dropped from 9.2 to 6.8 in just six months. Truly life-changing care.',
        ],
        [
          'img'   => 'https://randomuser.me/api/portraits/women/68.jpg',
          'name'  => 'Anita Singh',
          'date'  => 'Parent of two',
          'stars' => 5,
          'text'  => 'The best pediatric care in the city. My children, ages 4 and 7, actually look forward to their checkups. Dr. Sharma has a wonderful way with kids—patient, gentle, and reassuring. The vaccination schedule is well managed, and we always get timely reminders. Could not ask for a better doctor for my family.',
        ],
        [
          'img'   => 'https://randomuser.me/api/portraits/men/46.jpg',
          'name'  => 'Vikram Mehta',
          'date'  => 'Hypertension Patient',
          'stars' => 5,
          'text'  => 'Professional, knowledgeable, and always available when needed. Dr. Sharma helped me bring my blood pressure under control through a combination of lifestyle changes and the right medication. The online appointment system makes it very convenient to book and manage visits. Highly recommended for anyone with chronic health concerns.',
        ],
        [
          'img'   => 'https://randomuser.me/api/portraits/women/26.jpg',
          'name'  => 'Sneha Desai',
          'date'  => 'Annual Checkup',
          'stars' => 4,
          'text'  => 'I went for my annual preventive health checkup and was impressed by the thoroughness of the screening. The comprehensive blood panel, cardiac assessment, and lifestyle counseling were all handled in one visit. The results were explained to me in simple terms. Great experience overall.',
        ],
        [
          'img'   => 'https://randomuser.me/api/portraits/men/75.jpg',
          'name'  => 'Amit Verma',
          'date'  => 'General Patient',
          'stars' => 5,
          'text'  => 'I appreciate the modern approach to healthcare at Manthan Clinic. Digital prescriptions, online access to lab reports, and minimal waiting time. Dr. Sharma diagnosed a thyroid issue that had been missed by other doctors. His attention to detail is remarkable. The clinic truly sets a new standard for outpatient care.',
        ],
      ];

      foreach ($reviews as $idx => $r) {
        $stars = str_repeat('<i class="bi bi-star-fill"></i>', $r['stars']);
        if ($r['stars'] < 5) {
          $stars .= str_repeat('<i class="bi bi-star"></i>', 5 - $r['stars']);
        }

        $delay = $idx * 80;
        $floatDelay = $idx * 0.3;
        echo "
      <div class='col-md-6 col-lg-4 review-col' data-aos='fade-up' data-aos-delay='{$delay}'>
        <div class='review-card testimonial-float-card' style='animation-delay: {$floatDelay}s'>
          <div class='review-header'>
            <img src='{$r['img']}' alt='{$r['name']}' class='review-avatar' loading='lazy'>
            <div>
              <h6 class='review-name'>{$r['name']}</h6>
              <div class='review-date'>{$r['date']}</div>
              <div class='testimonial-stars mt-1'>{$stars}</div>
            </div>
          </div>
          <p class='review-text'>{$r['text']}</p>
        </div>
      </div>";
      }
      ?>
    </div>
  </div>
</section>

<!-- ============================================================
     VIDEO REVIEW PLACEHOLDER
     ============================================================ -->
<section class="section-padding light-bg">
  <div class="section-blob blob-1" style="bottom: -5%; right: -5%;"></div>
  <div class="floating-circle circle-2" style="top: 5%; left: 10%;"></div>
  <div class="container-xl">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">Video Reviews</span>
      <h2>Hear Directly from Our Patients</h2>
      <p>Watch video testimonials from patients sharing their experiences at Manthan Clinic.</p>
    </div>

    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up">
        <div class="video-placeholder">
          <i class="bi bi-play-circle"></i>
          <h6>Video Review 1</h6>
          <p>Patient shares their experience</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="video-placeholder">
          <i class="bi bi-play-circle"></i>
          <h6>Video Review 2</h6>
          <p>Patient shares their experience</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="video-placeholder">
          <i class="bi bi-play-circle"></i>
          <h6>Video Review 3</h6>
          <p>Patient shares their experience</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     CTA SECTION
     ============================================================ -->
<section class="stats-section">
  <div class="floating-circle circle-1" style="top: 8%; left: 8%; width: 60px; height: 60px; border-color: rgba(255,255,255,0.1);"></div>
  <div class="floating-circle circle-2" style="bottom: 12%; right: 10%; border-color: rgba(255,255,255,0.1);"></div>
  <div class="container-xl text-center">
    <h2 class="text-white mb-3" data-aos="fade-up">Share Your Experience</h2>
    <p class="text-white opacity-75 mb-4" data-aos="fade-up" data-aos-delay="100" style="max-width: 600px; margin-left: auto; margin-right: auto;">
      If you have had a positive experience at Manthan Clinic, we would love to hear from you. Your feedback helps others make informed healthcare decisions.
    </p>
    <div data-aos="fade-up" data-aos-delay="200">
      <a href="<?= $bp ?>/contact" class="btn btn-light btn-lg header-btn">
        <i class="bi bi-chat-dots me-1"></i>Share Your Feedback
      </a>
    </div>
  </div>
</section>

<?php require_once __DIR__.'/includes/footer.php'; ?>
