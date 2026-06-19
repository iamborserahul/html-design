<?php
$pageTitle = 'Contact Vérité – Book Your Luxury Salon Appointment NYC';
$pageDescription = 'Contact Vérité Beauty & Salon. Book appointments, inquire about services, or visit our Madison Avenue luxury studio. Call (212) 555-0199.';

$formSuccess = false;
$formError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'contact') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $service = trim($_POST['service'] ?? '');
  $message = trim($_POST['message'] ?? '');

  $errors = [];
  if (empty($name)) $errors[] = 'Name is required.';
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
  if (empty($message)) $errors[] = 'Message is required.';

  if (empty($errors)) {
    $to = 'hello@veritebeauty.com';
    $subject = "New Booking Inquiry from $name";
    $body = "Name: $name\nEmail: $email\nPhone: $phone\nService: $service\n\nMessage:\n$message";
    $headers = "From: $email\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $body, $headers)) {
      $formSuccess = true;
    } else {
      $formError = 'Unable to send message. Please try again or call us directly.';
    }
  } else {
    $formError = implode(' ', $errors);
  }

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    if ($formSuccess) {
      echo json_encode(['success' => true, 'message' => 'We have received your inquiry and will respond within 24 hours.']);
    } else {
      echo json_encode(['success' => false, 'message' => $formError]);
    }
    exit;
  }
}

require_once 'includes/header.php';
?>

<!-- HERO BANNER -->
<section class="page-hero" style="height:50vh;min-height:400px;">
  <img class="page-hero-bg" src="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Contact" loading="lazy">
  <div class="page-hero-overlay"></div>
  <div class="container">
    <div class="page-hero-content text-center">
      <div class="page-hero-breadcrumb">
        <a href="/">Home</a> / Contact
      </div>
      <h1 class="page-hero-title">Get in <span class="text-gold">Touch</span></h1>
      <p class="text-light opacity-75 lead mt-3 max-w-600 mx-auto">Begin your luxury journey with Vérité. We look forward to welcoming you.</p>
    </div>
  </div>
</section>

<!-- CONTACT SECTION -->
<section class="contact-section" id="contact-main">
  <div class="container">
    <div class="row">
      <div class="col-lg-5">
        <!-- Contact Info -->
        <div class="contact-info-card" data-aos="fade-up">
          <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
          <h5>Visit Us</h5>
          <p>245 Madison Avenue, Suite 1200<br>New York, NY 10016</p>
        </div>
        <div class="contact-info-card" data-aos="fade-up" data-aos-delay="80">
          <div class="icon"><i class="fas fa-phone-alt"></i></div>
          <h5>Call Us</h5>
          <a href="tel:+12125550199">(212) 555-0199</a>
          <a href="https://wa.me/12125550199" target="_blank" rel="noopener">WhatsApp: (212) 555-0199</a>
        </div>
        <div class="contact-info-card" data-aos="fade-up" data-aos-delay="160">
          <div class="icon"><i class="fas fa-envelope"></i></div>
          <h5>Email Us</h5>
          <a href="mailto:hello@veritebeauty.com">hello@veritebeauty.com</a>
        </div>
        <div class="contact-info-card" data-aos="fade-up" data-aos-delay="240">
          <div class="icon"><i class="fas fa-clock"></i></div>
          <h5>Business Hours</h5>
          <div class="hours-grid">
            <span class="hours-day">Monday–Wednesday</span>
            <span class="hours-time">9AM–8PM</span>
            <span class="hours-day">Thursday–Friday</span>
            <span class="hours-time">9AM–9PM</span>
            <span class="hours-day">Saturday</span>
            <span class="hours-time">10AM–6PM</span>
            <span class="hours-day">Sunday</span>
            <span class="hours-time">Closed</span>
          </div>
        </div>
        <div class="contact-info-card" data-aos="fade-up" data-aos-delay="320">
          <div class="icon"><i class="fas fa-share-alt"></i></div>
          <h5>Follow Us</h5>
          <div class="footer-social mt-2">
            <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-link" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            <a href="#" class="social-link" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
            <a href="#" class="social-link" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="contact-form-wrap" data-aos="fade-up" data-aos-delay="100">
          <span class="section-tag">Book an Appointment</span>
          <h2 class="section-title mb-4">Reserve Your <span class="text-gradient">Experience</span></h2>

          <?php if ($formSuccess && !(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')): ?>
            <div class="alert alert-success py-4">
              <i class="fas fa-check-circle text-gold fa-2x mb-2"></i>
              <h4 class="font-serif">Thank You!</h4>
              <p class="mb-0">We have received your inquiry and will respond within 24 hours.</p>
            </div>
          <?php elseif ($formError && !(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')): ?>
            <div class="alert alert-danger py-3"><?= htmlspecialchars($formError) ?></div>
          <?php endif; ?>

          <form class="contact-form" id="contactForm" method="POST" action="/contact.php">
            <input type="hidden" name="action" value="contact">
            <div class="row">
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                  <label for="name">Your Name *</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                  <label for="email">Email Address *</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="tel" class="form-control" id="phone" name="phone" placeholder="Your Phone">
                  <label for="phone">Phone Number</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <select class="form-control" id="service" name="service">
                    <option value="">Select a service</option>
                    <option value="hair-styling">Hair Styling</option>
                    <option value="hair-coloring">Hair Coloring</option>
                    <option value="bridal-makeup">Bridal Makeup</option>
                    <option value="skin-treatment">Skin Treatment</option>
                    <option value="nail-art">Nail Art</option>
                    <option value="spa-therapy">Spa Therapy</option>
                    <option value="other">Other</option>
                  </select>
                  <label for="service">Service Interested In</label>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating">
                  <textarea class="form-control" id="message" name="message" placeholder="Your Message" style="min-height:140px" required></textarea>
                  <label for="message">Your Message *</label>
                </div>
              </div>
              <div class="col-12 mt-3">
                <button type="submit" class="btn-luxury">Send Inquiry <i class="fas fa-arrow-right ms-2"></i></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MAP -->
<section class="map-section">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.142293795864!2d-73.98720368459377!3d40.74844297932755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>

<?php require_once 'includes/footer.php'; ?>
