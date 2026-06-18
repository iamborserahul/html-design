<?php
$pageName  = 'FAQ';
$pageTitle = 'Frequently Asked Questions | Manthan Clinic – Appointments, Insurance, Timings & More';
$metaDesc  = 'Find answers to common questions about Manthan Clinic: appointment booking, consultation fees, accepted insurance, clinic timings, and teleconsultation services.';
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
    <h1 data-aos="fade-up">Frequently Asked Questions</h1>
    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= $bp ?>/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">FAQ</li>
      </ol>
    </nav>
  </div>
</section>

<!-- ============================================================
     FAQ — Premium Split Layout
     ============================================================ -->
<section class="section-padding">
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
        <h2>Common Questions, Clear Answers</h2>
        <p class="faq-subtitle">We have compiled answers to the most frequently asked questions to help you get the information you need quickly.</p>

        <div class="faq-list" id="faqList">
          <?php
          $faqs = [
            ['q' => 'What are your clinic timings?', 'a' => 'Our clinic is open Monday through Friday from 9:00 AM to 7:00 PM, and on Saturdays from 9:00 AM to 2:00 PM. We remain closed on Sundays and public holidays. For urgent medical needs outside these hours, please call our emergency line at +91 98765 43210.'],
            ['q' => 'How do I book an appointment?', 'a' => 'Booking an appointment is simple and can be done in several ways: (1) Use the online booking form on our Contact page, (2) Call us directly at +91 98765 43210, (3) Send a message on WhatsApp, or (4) Visit the clinic in person. We typically confirm appointments within 2–4 hours during business hours.'],
            ['q' => 'Do you accept health insurance?', 'a' => 'Yes, we accept most major health insurance providers including NIA, Star Health, HDFC Ergo, ICICI Lombard, and New India Assurance. Please bring your insurance card and any relevant documents to your first visit. Contact our front desk for a complete and up-to-date list of accepted insurance plans.'],
            ['q' => 'What are the consultation charges?', 'a' => 'General consultation starts at ₹500. Specialized consultations and procedures are priced based on the specific service. We believe in transparent pricing with no hidden charges. Senior citizens and patients with chronic conditions may be eligible for discounted packages. Please contact us for a detailed fee structure.'],
            ['q' => 'Do you offer teleconsultation?', 'a' => 'Yes, we offer video and phone consultations for follow-up visits, prescription refills, and minor health concerns. Teleconsultations are available Monday through Friday from 10:00 AM to 4:00 PM. Please schedule your teleconsultation at least 24 hours in advance. You will receive a link to join the video call via email or WhatsApp.'],
            ['q' => 'What should I bring for my first visit?', 'a' => 'Please bring: (1) A valid government-issued photo ID (Aadhaar, PAN, Driver\'s License, or Passport), (2) Your health insurance card and policy documents, (3) Any previous medical records, lab reports, or prescription history, (4) A list of current medications including dosages, and (5) Any questions or concerns you would like to discuss. Arriving 15 minutes early will help us complete the registration smoothly.'],
            ['q' => 'How long does a typical consultation take?', 'a' => 'We believe in unhurried, thorough consultations. A typical first visit lasts 20–30 minutes, allowing ample time for history taking, examination, discussion, and questions. Follow-up visits are usually 10–15 minutes. Complex cases may require additional time, which we accommodate without rushing.'],
            ['q' => 'Do you provide emergency care?', 'a' => 'Manthan Clinic is primarily an outpatient clinic for non-emergency care. In case of a medical emergency, please call 108 (Emergency Services) or visit the nearest hospital emergency department. For urgent medical advice during clinic hours, call us at +91 98765 43210 and we will assist you promptly.'],
            ['q' => 'Can I get lab tests done at the clinic?', 'a' => 'Yes, we have a dedicated sample collection area where blood, urine, and other routine samples can be collected. Our partner diagnostic labs process the samples and deliver digital reports within 24–48 hours. We also offer home sample collection for elderly and differently-abled patients.'],
            ['q' => 'Do you provide digital prescriptions and reports?', 'a' => 'Absolutely. Manthan Clinic uses a modern digital health record system. All prescriptions are generated electronically and can be shared via email or WhatsApp. Lab reports, vaccination records, and consultation summaries are also available digitally, reducing paperwork and ensuring your health records are always accessible.'],
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
     STILL HAVE QUESTIONS?
     ============================================================ -->
<section class="section-padding light-bg">
  <div class="section-blob blob-2" style="top: -5%; right: -3%;"></div>
  <div class="floating-circle circle-1" style="bottom: 8%; left: 5%;"></div>
  <div class="container-xl text-center">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">Get In Touch</span>
      <h2>Still Have Questions?</h2>
      <p>We are happy to answer any additional questions you may have. Reach out to us directly.</p>
    </div>
    <div data-aos="fade-up" data-aos-delay="100">
      <a href="<?= $bp ?>/contact" class="btn btn-primary header-btn btn-lg me-2">
        <i class="bi bi-envelope me-1"></i>Contact Us
      </a>
      <a href="tel:+919876543210" class="btn btn-outline-primary header-btn btn-lg">
        <i class="bi bi-telephone me-1"></i>Call Now
      </a>
    </div>
  </div>
</section>

<?php require_once __DIR__.'/includes/footer.php'; ?>
