<?php
$pageName  = 'About';
$pageTitle = 'About Dr. Aakash Sharma | Manthan Clinic – Experienced Physician in Jaipur';
$metaDesc  = 'Learn about Dr. Aakash Sharma, a highly qualified physician with 15+ years of experience in internal medicine, diabetes management, and preventive healthcare at Manthan Clinic.';
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
    <h1 data-aos="fade-up">About Dr. Aakash Sharma</h1>
    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= $bp ?>/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">About Doctor</li>
      </ol>
    </nav>
  </div>
</section>

<!-- ============================================================
     DOCTOR BIOGRAPHY
     ============================================================ -->
<section class="section-padding">
  <div class="section-blob blob-3" style="top: 10%; right: -3%;"></div>
  <div class="container-xl">
    <div class="row g-5">
      <div class="col-lg-5" data-aos="fade-right">
        <div class="about-image-wrapper about-float-image">
          <img
            src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=500&q=80"
            alt="Dr. Aakash Sharma – Senior Physician"
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
        <span class="section-label">Biography</span>
        <h2>A Dedicated Healer with a Patient-First Approach</h2>

        <p>Dr. Aakash Sharma is a highly respected physician based in Jaipur, with over 15 years of clinical experience spanning internal medicine, chronic disease management, and preventive healthcare. He is the founder and lead consultant at Manthan Clinic, a modern medical practice built on the principles of compassion, integrity, and clinical excellence.</p>

        <p>Dr. Sharma earned his MBBS from the prestigious Sawai Man Singh Medical College in Jaipur, followed by an MD in Internal Medicine from the All India Institute of Medical Sciences (AIIMS), New Delhi. His rigorous training at two of India's top medical institutions gave him a strong foundation in diagnosing and managing complex medical conditions.</p>

        <p>Throughout his career, Dr. Sharma has remained committed to continuous learning. He holds advanced certifications in diabetes management, hypertension control, and cardiovascular risk assessment. He is an active member of the Indian Medical Association (IMA) and regularly participates in medical conferences and community health camps.</p>

        <p>In 2022, Dr. Sharma was honored with the "Excellence in Healthcare" award by the Rajasthan Medical Council for his outstanding contributions to patient care and community health awareness.</p>

        <p>At Manthan Clinic, Dr. Sharma believes in treating every patient as a member of his own family. His practice is characterized by thorough consultations, clear communication, and a genuine commitment to improving health outcomes for the Jaipur community.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     QUALIFICATIONS & CERTIFICATIONS
     ============================================================ -->
<section class="section-padding light-bg">
  <div class="section-blob blob-1" style="bottom: -5%; right: -5%;"></div>
  <div class="floating-circle circle-2" style="top: 8%; left: 5%;"></div>
  <div class="container-xl">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">Credentials</span>
      <h2>Qualifications &amp; Certifications</h2>
      <p>A distinguished academic and professional journey dedicated to medical excellence.</p>
    </div>

    <div class="row g-4 stagger-1">
      <div class="col-md-6" data-aos="fade-up">
        <div class="cert-badge">
          <i class="bi bi-mortarboard-fill"></i>
          <div>
            <h6>MBBS</h6>
            <span>Sawai Man Singh Medical College, Jaipur (2003–2008)</span>
          </div>
        </div>
      </div>

      <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="cert-badge">
          <i class="bi bi-mortarboard-fill"></i>
          <div>
            <h6>MD – Internal Medicine</h6>
            <span>AIIMS, New Delhi (2009–2012)</span>
          </div>
        </div>
      </div>

      <div class="col-md-6" data-aos="fade-up" data-aos-delay="150">
        <div class="cert-badge">
          <i class="bi bi-shield-fill-check"></i>
          <div>
            <h6>Certified Diabetes Educator</h6>
            <span>American Diabetes Association (2015)</span>
          </div>
        </div>
      </div>

      <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="cert-badge">
          <i class="bi bi-heart-pulse-fill"></i>
          <div>
            <h6>Advanced Cardiac Life Support (ACLS)</h6>
            <span>American Heart Association (2020)</span>
          </div>
        </div>
      </div>

      <div class="col-md-6" data-aos="fade-up" data-aos-delay="250">
        <div class="cert-badge">
          <i class="bi bi-trophy-fill"></i>
          <div>
            <h6>Excellence in Healthcare Award</h6>
            <span>Rajasthan Medical Council (2022)</span>
          </div>
        </div>
      </div>

      <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="cert-badge">
          <i class="bi bi-people-fill"></i>
          <div>
            <h6>Member – Indian Medical Association</h6>
            <span>IMA Lifetime Membership (2013–Present)</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     EXPERIENCE TIMELINE
     ============================================================ -->
<section class="section-padding">
  <div class="floating-circle circle-1" style="top: 20%; left: 5%;"></div>
  <div class="floating-circle circle-3" style="bottom: 10%; right: 8%;"></div>
  <div class="container-xl">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">Timeline</span>
      <h2>Professional Journey</h2>
      <p>Over a decade and a half of dedication to patient care and medical advancement.</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="timeline">
          <?php
          $timeline = [
            ['year' => '2003–2008', 'title' => 'MBBS Degree',          'desc' => 'Graduated from Sawai Man Singh Medical College, Jaipur with distinction.'],
            ['year' => '2009–2012', 'title' => 'MD – Internal Medicine', 'desc' => 'Completed postgraduate residency at AIIMS, New Delhi.'],
            ['year' => '2012–2014', 'title' => 'Senior Resident',       'desc' => 'Worked as a senior resident at SMS Hospital, Jaipur, managing complex internal medicine cases.'],
            ['year' => '2014–2016', 'title' => 'Consultant Physician',  'desc' => 'Served as a consultant physician at a multispecialty hospital in Jaipur.'],
            ['year' => '2016',      'title' => 'Founded Manthan Clinic', 'desc' => 'Established Manthan Clinic with a vision to provide personalized, high-quality healthcare.'],
            ['year' => '2022',      'title' => 'Excellence Award',      'desc' => 'Received the Excellence in Healthcare Award from Rajasthan Medical Council.'],
          ];

          foreach ($timeline as $i => $t) {
            $active = $i === 4 ? ' active' : '';
            echo "
          <div class='timeline-item{$active}'>
            <span class='timeline-year'>{$t['year']}</span>
            <h5>{$t['title']}</h5>
            <p>{$t['desc']}</p>
          </div>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     CTA SECTION
     ============================================================ -->
<section class="stats-section">
  <div class="floating-circle circle-1" style="top: 10%; left: 10%; width: 60px; height: 60px; border-color: rgba(255,255,255,0.1);"></div>
  <div class="floating-circle circle-2" style="bottom: 15%; right: 12%; border-color: rgba(255,255,255,0.1);"></div>
  <div class="container-xl text-center">
    <h2 class="text-white mb-3" data-aos="fade-up">Ready to Experience Better Healthcare?</h2>
    <p class="text-white opacity-75 mb-4" data-aos="fade-up" data-aos-delay="100" style="max-width: 600px; margin-left: auto; margin-right: auto;">
      Schedule a consultation with Dr. Aakash Sharma and take the first step towards a healthier life.
    </p>
    <div data-aos="fade-up" data-aos-delay="200">
      <a href="<?= $bp ?>/contact" class="btn btn-light btn-lg header-btn me-2">
        <i class="bi bi-calendar2-check me-1"></i>Book Appointment
      </a>
      <a href="tel:+919876543210" class="btn btn-outline-light btn-lg header-btn">
        <i class="bi bi-telephone me-1"></i>Call Now
      </a>
    </div>
  </div>
</section>

<?php require_once __DIR__.'/includes/footer.php'; ?>
