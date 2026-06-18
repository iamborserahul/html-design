<?php
$assets = defined('BASE_PATH') ? BASE_PATH . '/assets' : '/assets';
?>

<!-- ============================================================
     PREMIUM FOOTER
     ============================================================ -->
<footer class="site-footer">
  <!-- Top wave divider -->
  <div class="footer-wave">
    <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#0b1a2e"/>
    </svg>
  </div>

  <div class="footer-body">
    <div class="container-xl">
      <div class="row g-5">

        <!-- Column 1: About -->
        <div class="col-lg-4 col-md-6">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div class="brand-icon brand-icon--white">
              <i class="bi bi-heart-pulse-fill"></i>
            </div>
            <div>
              <div class="footer-brand-name">Manthan Clinic</div>
              <small class="text-muted-light">Dr. Aakash Sharma</small>
            </div>
          </div>
          <p class="footer-about">
            Delivering compassionate, world-class healthcare since 2009.
            Our mission is to keep every patient healthy, informed, and empowered.
          </p>
          <!-- Social Links -->
          <div class="footer-socials d-flex gap-3 mt-3">
            <a href="#" class="social-link" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="social-link" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="social-link" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="social-link" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
            <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>" class="social-link social-link--wa" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
          </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="col-lg-2 col-md-6 col-6">
          <h6 class="footer-heading">Quick Links</h6>
          <ul class="footer-links">
            <li><a href="<?= BASE_PATH ?>/">Home</a></li>
            <li><a href="<?= BASE_PATH ?>/about">About Doctor</a></li>
            <li><a href="<?= BASE_PATH ?>/services">Services</a></li>
            <li><a href="<?= BASE_PATH ?>/gallery">Gallery</a></li>
            <li><a href="<?= BASE_PATH ?>/testimonials">Testimonials</a></li>
            <li><a href="<?= BASE_PATH ?>/faq">FAQ</a></li>
            <li><a href="<?= BASE_PATH ?>/contact">Contact</a></li>
          </ul>
        </div>

        <!-- Column 3: Services -->
        <div class="col-lg-2 col-md-6 col-6">
          <h6 class="footer-heading">Our Services</h6>
          <ul class="footer-links">
            <li><a href="<?= BASE_PATH ?>/services">General Consultation</a></li>
            <li><a href="<?= BASE_PATH ?>/services">Diabetes Management</a></li>
            <li><a href="<?= BASE_PATH ?>/services">Hypertension Care</a></li>
            <li><a href="<?= BASE_PATH ?>/services">Child Healthcare</a></li>
            <li><a href="<?= BASE_PATH ?>/services">Women's Health</a></li>
            <li><a href="<?= BASE_PATH ?>/services">Preventive Checkups</a></li>
          </ul>
        </div>

        <!-- Column 4: Contact Info -->
        <div class="col-lg-4 col-md-6">
          <h6 class="footer-heading">Get In Touch</h6>
          <ul class="footer-contact-list">
            <li>
              <span class="footer-contact-icon"><i class="bi bi-geo-alt-fill"></i></span>
              <span>42, Wellness Avenue, Sector 14,<br>Jaipur, Rajasthan – 302001</span>
            </li>
            <li>
              <span class="footer-contact-icon"><i class="bi bi-telephone-fill"></i></span>
              <a href="tel:+919876543210">+91 98765 43210</a>
            </li>
            <li>
              <span class="footer-contact-icon"><i class="bi bi-envelope-fill"></i></span>
              <a href="mailto:info@manthanclinic.com">info@manthanclinic.com</a>
            </li>
            <li>
              <span class="footer-contact-icon"><i class="bi bi-clock-fill"></i></span>
              <span>Mon–Fri: 9:00 AM – 7:00 PM<br>Sat: 9:00 AM – 2:00 PM</span>
            </li>
          </ul>
        </div>

      </div><!-- /.row -->
    </div><!-- /.container -->
  </div><!-- /.footer-body -->

  <!-- Footer Bottom Bar -->
  <div class="footer-bottom">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start">
          <p class="mb-0">&copy; <?= date('Y') ?> Manthan Clinic. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
          <p class="mb-0 text-muted-light">Designed with <i class="bi bi-heart-fill text-danger"></i> for better health</p>
        </div>
      </div>
    </div>
  </div>

</footer>

<!-- ============================================================
     WHATSAPP FLOATING BUTTON
     ============================================================ -->
<a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=<?= urlencode(WHATSAPP_MESSAGE) ?>"
   class="wa-float" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
  <i class="bi bi-whatsapp"></i>
  <span class="wa-tooltip">Chat with us</span>
</a>

<!-- ============================================================
     BACK TO TOP BUTTON
     ============================================================ -->
<button id="backToTop" class="back-to-top" aria-label="Back to top">
  <i class="bi bi-arrow-up-short"></i>
</button>

<!-- ============================================================
     SCRIPTS (loaded at bottom for performance)
     ============================================================ -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Bootstrap 5 Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<!-- GLightbox -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<!-- Custom JS -->
<script src="<?= $assets ?>/js/main.js"></script>

</body>
</html>
