<?php
$pageName  = 'Services';
$pageTitle = 'Medical Services | Manthan Clinic – General Medicine, Diabetes, Hypertension & More';
$metaDesc  = 'Explore the comprehensive medical services at Manthan Clinic: general consultation, diabetes management, hypertension treatment, child care, women\'s health, and preventive checkups.';
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
    <h1 data-aos="fade-up">Our Medical Services</h1>
    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= $bp ?>/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Services</li>
      </ol>
    </nav>
  </div>
</section>

<!-- ============================================================
     SERVICES OVERVIEW
     ============================================================ -->
<section class="section-padding">
  <div class="section-blob blob-3" style="top: 5%; left: -5%;"></div>
  <div class="floating-circle circle-1" style="bottom: 8%; right: 6%;"></div>
  <div class="container-xl">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">What We Offer</span>
      <h2>Complete Healthcare Under One Roof</h2>
      <p>From preventive screenings to chronic disease management, our clinic provides comprehensive medical care for you and your family.</p>
    </div>

    <div class="row g-4">
      <?php
      $services = [
        [
          'icon'       => 'bi-heart-pulse',
          'title'      => 'General Consultation',
          'desc'       => 'Comprehensive health evaluations for patients of all ages. Our thorough consultations include medical history review, physical examination, and personalized treatment plans.',
          'benefits'   => [
            'Detailed medical history assessment',
            'Complete physical examination',
            'Personalized treatment plan',
            'Follow-up care and monitoring',
            'Health education and counseling',
          ],
        ],
        [
          'icon'       => 'bi-droplet-half',
          'title'      => 'Diabetes Management',
          'desc'       => 'Specialized care for Type 1 and Type 2 diabetes. Our evidence-based approach combines medication management, dietary guidance, and lifestyle modifications.',
          'benefits'   => [
            'Blood sugar monitoring and analysis',
            'Personalized diet and exercise plans',
            'Medication optimization',
            'HbA1c tracking and management',
            'Prevention of diabetes complications',
          ],
        ],
        [
          'icon'       => 'bi-activity',
          'title'      => 'Hypertension Treatment',
          'desc'       => 'Effective management of high blood pressure to reduce the risk of heart disease, stroke, and kidney damage. We develop customized treatment strategies for each patient.',
          'benefits'   => [
            'Blood pressure monitoring and tracking',
            'Lifestyle modification guidance',
            'Medication management',
            'Cardiovascular risk assessment',
            'Regular follow-up and adjustment',
          ],
        ],
        [
          'icon'       => 'bi-cup-hot',
          'title'      => 'Child Healthcare',
          'desc'       => 'Gentle and comprehensive pediatric care from infancy through adolescence. We partner with parents to ensure every child reaches their full health potential.',
          'benefits'   => [
            'Growth and development monitoring',
            'Immunization programs',
            'Nutritional guidance',
            'Common illness management',
            'Developmental screening',
          ],
        ],
        [
          'icon'       => 'bi-flower1',
          'title'      => "Women's Healthcare",
          'desc'       => 'Dedicated healthcare services for women at every stage of life, from adolescence through menopause and beyond.',
          'benefits'   => [
            'Annual wellness exams',
            'Reproductive health counseling',
            'Menstrual health management',
            'Menopause guidance',
            'Preventive screenings',
          ],
        ],
        [
          'icon'       => 'bi-shield-plus',
          'title'      => 'Preventive Checkups',
          'desc'       => 'Comprehensive health screening programs designed to detect potential health issues early, when they are most treatable.',
          'benefits'   => [
            'Complete blood panel analysis',
            'Cardiac risk assessment',
            'Cancer screening referrals',
            'Vaccination programs',
            'Personalized prevention plan',
          ],
        ],
      ];

      $aosTypes = ['fade-up', 'zoom-in', 'fade-up', 'zoom-in', 'fade-up', 'flip-up'];
      foreach ($services as $i => $s) {
        $delay = ($i % 3) * 100;
        $benefits = '';
        foreach ($s['benefits'] as $b) {
          $benefits .= "<li><i class='bi bi-check2-circle'></i>{$b}</li>";
        }

        $floatDelay = $i * 0.6;
        $aosType = $aosTypes[$i];
        echo "
      <div class='col-md-6 col-lg-4' data-aos='{$aosType}' data-aos-delay='{$delay}'>
        <div class='service-detail-card service-card-float' style='animation-delay: {$floatDelay}s'>
          <div class='service-icon-lg'>
            <i class='bi {$s['icon']}'></i>
          </div>
          <h4>{$s['title']}</h4>
          <p>{$s['desc']}</p>
          <ul class='benefits-list'>{$benefits}</ul>
          <a href='{$bp}/contact' class='btn btn-primary header-btn btn-sm'>
            <i class='bi bi-calendar2-check me-1'></i>Book Appointment
          </a>
        </div>
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
  <div class="floating-circle circle-1" style="top: 8%; left: 8%; width: 60px; height: 60px; border-color: rgba(255,255,255,0.1);"></div>
  <div class="floating-circle circle-2" style="bottom: 12%; right: 10%; border-color: rgba(255,255,255,0.1);"></div>
  <div class="container-xl text-center">
    <h2 class="text-white mb-3" data-aos="fade-up">Not Sure Which Service You Need?</h2>
    <p class="text-white opacity-75 mb-4" data-aos="fade-up" data-aos-delay="100" style="max-width: 600px; margin-left: auto; margin-right: auto;">
      Contact us for a free consultation. We will help you understand which medical service is right for your condition.
    </p>
    <div data-aos="fade-up" data-aos-delay="200">
      <a href="tel:+919876543210" class="btn btn-light btn-lg header-btn me-2">
        <i class="bi bi-telephone me-1"></i>Call +91 98765 43210
      </a>
      <a href="<?= $bp ?>/contact" class="btn btn-outline-light btn-lg header-btn">
        <i class="bi bi-envelope me-1"></i>Send Inquiry
      </a>
    </div>
  </div>
</section>

<?php require_once __DIR__.'/includes/footer.php'; ?>
