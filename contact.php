<?php
$pageName  = 'Contact';
$pageTitle = 'Contact Us | Manthan Clinic – Book an Appointment in Jaipur';
$metaDesc  = 'Get in touch with Manthan Clinic. Call, email, WhatsApp, or visit us at our Jaipur clinic. Book your appointment with Dr. Aakash Sharma today.';
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
    <h1 data-aos="fade-up">Contact Us</h1>
    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= $bp ?>/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contact</li>
      </ol>
    </nav>
  </div>
</section>

<!-- ============================================================
     CONTACT SECTION
     ============================================================ -->
<section class="section-padding">
  <div class="section-blob blob-3" style="top: 10%; right: -5%;"></div>
  <div class="floating-circle circle-1" style="bottom: 8%; left: 5%;"></div>
  <div class="container-xl">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">Get In Touch</span>
      <h2>We Are Here to Help You</h2>
      <p>Whether you need to book an appointment, have a medical question, or want to learn more about our services, do not hesitate to reach out.</p>
    </div>

    <div class="row g-5">
      <div class="col-lg-7" data-aos="fade-right">
        <div class="contact-form-wrapper">
          <h4 class="mb-4" style="font-family: var(--font-primary);">Send Us a Message</h4>
          <form action="<?= $bp ?>/contact_process.php" method="post" class="contact-form needs-validation" novalidate>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label" for="cname">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="cname" name="name" required placeholder="Enter your full name">
                <div class="invalid-feedback">Please enter your name.</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="cemail">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="cemail" name="email" required placeholder="Enter your email">
                <div class="invalid-feedback">Please enter a valid email address.</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="cphone">Phone Number</label>
                <input type="tel" class="form-control" id="cphone" name="phone" placeholder="Enter your phone number">
              </div>
              <div class="col-md-6">
                <label class="form-label" for="csubject">Subject</label>
                <input type="text" class="form-control" id="csubject" name="subject" placeholder="e.g. Appointment, Inquiry">
              </div>
              <div class="col-12">
                <label class="form-label" for="cmessage">Message <span class="text-danger">*</span></label>
                <textarea class="form-control" id="cmessage" name="message" rows="6" required placeholder="Tell us how we can assist you..."></textarea>
                <div class="invalid-feedback">Please write a message (minimum 10 characters).</div>
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
              <h6>Clinic Address</h6>
              <p>42, Wellness Avenue, Sector 14<br>Jaipur, Rajasthan – 302001</p>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-telephone-fill"></i></div>
            <div>
              <h6>Phone Number</h6>
              <a href="tel:+919876543210">+91 98765 43210</a>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-envelope-fill"></i></div>
            <div>
              <h6>Email Address</h6>
              <a href="mailto:info@manthanclinic.com">info@manthanclinic.com</a>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-whatsapp"></i></div>
            <div>
              <h6>WhatsApp</h6>
              <a href="https://wa.me/919876543210" target="_blank">+91 98765 43210</a>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-clock-fill"></i></div>
            <div>
              <h6>Working Hours</h6>
              <p>
                Monday – Friday: 9:00 AM – 7:00 PM<br>
                Saturday: 9:00 AM – 2:00 PM<br>
                <span class="text-muted">Sunday: Closed</span>
              </p>
            </div>
          </div>

          <div class="mt-3">
            <a href="https://wa.me/919876543210" target="_blank" class="btn btn-success header-btn w-100">
              <i class="bi bi-whatsapp me-1"></i>Chat on WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     MAP SECTION
     ============================================================ -->
<section class="section-padding light-bg">
  <div class="section-blob blob-2" style="bottom: -5%; left: -5%;"></div>
  <div class="floating-circle circle-2" style="top: 5%; right: 10%;"></div>
  <div class="container-xl">
    <div class="section-header" data-aos="fade-up">
      <span class="section-label">Find Us</span>
      <h2>Visit Our Clinic</h2>
      <p>We are conveniently located in the heart of Jaipur. Use the map below to find directions to our clinic.</p>
    </div>

    <div class="map-wrapper" data-aos="fade-up">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28447.632019581022!2d75.787902!3d26.912434!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db7b1b8b8b8b1%3A0xac2b3e1c5d5c5bec!2sJaipur%2C%20Rajasthan!5e0!3m2!1sen!2sin!4v1"
        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
        title="Manthan Clinic Location Map">
      </iframe>
    </div>
  </div>
</section>

<?php require_once __DIR__.'/includes/footer.php'; ?>
