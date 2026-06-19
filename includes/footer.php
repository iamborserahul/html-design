<?php if (basename($_SERVER['SCRIPT_NAME']) !== 'contact.php'): ?>
<section class="cta-section" data-parallax="scroll" data-speed="0.3">
  <div class="cta-overlay"></div>
  <div class="container position-relative z-2">
    <div class="row justify-content-center text-center">
      <div class="col-lg-8">
        <span class="cta-tagline" data-aos="fade-up">Begin Your Transformation</span>
        <h2 class="cta-title display-3" data-aos="fade-up" data-aos-delay="100">Ready to Experience <br>True Luxury?</h2>
        <p class="cta-text lead" data-aos="fade-up" data-aos-delay="200">Book your appointment today and discover the Vérité difference. Your journey to radiant beauty begins with a single click.</p>
        <div class="cta-buttons mt-5" data-aos="fade-up" data-aos-delay="300">
          <a href="/contact.php" class="btn-luxury btn-luxury-light">Book Appointment <i class="fas fa-arrow-right ms-2"></i></a>
          <a href="/services.php" class="btn-luxury-outline-light ms-3">View Services</a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<footer class="luxury-footer" id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-4 col-md-6">
          <div class="footer-brand">
            <a href="/" class="footer-logo">VÉRITÉ</a>
            <p class="footer-desc mt-3">Where elegance meets excellence. Vérité Beauty & Salon is a premier luxury destination for discerning clients who demand the finest in beauty and wellness.</p>
            <div class="footer-social mt-4">
              <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
              <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
              <a href="#" class="social-link" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
              <a href="#" class="social-link" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
              <a href="#" class="social-link" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-6">
          <h5 class="footer-heading">Quick Links</h5>
          <ul class="footer-links">
            <li><a href="/">Home</a></li>
            <li><a href="/about.php">About</a></li>
            <li><a href="/services.php">Services</a></li>
            <li><a href="/gallery.php">Gallery</a></li>
            <li><a href="/contact.php">Contact</a></li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6">
          <h5 class="footer-heading">Services</h5>
          <ul class="footer-links">
            <li><a href="/services.php">Hair Styling</a></li>
            <li><a href="/services.php">Hair Coloring</a></li>
            <li><a href="/services.php">Bridal Makeup</a></li>
            <li><a href="/services.php">Skin Treatment</a></li>
            <li><a href="/services.php">Nail Art</a></li>
            <li><a href="/services.php">Spa Therapy</a></li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6">
          <h5 class="footer-heading">Contact</h5>
          <ul class="footer-contact">
            <li><i class="fas fa-map-marker-alt"></i> 245 Madison Ave, Suite 1200<br>New York, NY 10016</li>
            <li><i class="fas fa-phone-alt"></i> <a href="tel:+12125550199">(212) 555-0199</a></li>
            <li><i class="fas fa-envelope"></i> <a href="mailto:hello@veritebeauty.com">hello@veritebeauty.com</a></li>
            <li><i class="fas fa-clock"></i> Mon–Fri: 9AM–9PM<br>Sat: 10AM–6PM</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <p class="mb-0">&copy; <?= date('Y') ?> Vérité Beauty & Salon. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <a href="#" class="footer-bottom-link">Privacy Policy</a>
          <a href="#" class="footer-bottom-link ms-3">Terms of Service</a>
        </div>
      </div>
    </div>
  </div>
</footer>

</div>

<a href="#" class="back-to-top" id="backToTop">
  <i class="fas fa-chevron-up"></i>
</a>

<a href="https://wa.me/12125550199" target="_blank" class="whatsapp-float" rel="noopener" aria-label="WhatsApp">
  <i class="fab fa-whatsapp"></i>
</a>

<div class="mobile-bottom-bar d-xl-none">
  <a href="/contact.php" class="mobile-book-btn"><i class="fas fa-calendar-check me-2"></i>Book Appointment</a>
  <a href="tel:+12125550199" class="mobile-call-btn"><i class="fas fa-phone-alt me-2"></i>Call Now</a>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/MotionPathPlugin.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="/assets/js/main.js?v=1.0"></script>

<?php if (isset($extraJS)): ?>
<?= $extraJS ?>
<?php endif; ?>
</body>
</html>
