<?php
$pageTitle = 'Premium Salon Services – Vérité Beauty & Salon NYC';
$pageDescription = 'Explore our luxury services: precision haircuts, color mastery, bridal makeup, skincare, nail art & spa therapy. Book your experience today.';
require_once 'includes/header.php';
?>

<section class="page-hero">
  <img class="page-hero-bg" src="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Luxury Services" loading="lazy">
  <div class="page-hero-overlay"></div>
  <div class="container">
    <div class="page-hero-content text-center">
      <div class="page-hero-breadcrumb"><a href="/">Home</a> / Services</div>
      <h1 class="page-hero-title">Our <span class="text-gold">Services</span></h1>
      <p class="text-light opacity-75 lead mt-3 mx-auto max-w-600">Exquisite beauty experiences, meticulously crafted for the discerning.</p>
    </div>
  </div>
</section>

<section class="service-detail-section" id="service-list">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <span class="section-tag text-center">What We Offer</span>
        <h2 class="section-title">Complete <span class="text-gradient">Beauty Solutions</span></h2>
        <div class="section-ornament"><span class="line"></span><span class="diamond"></span><span class="line"></span></div>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="service-detail-card" data-aos="fade-up">
          <div class="service-icon"><i class="fas fa-cut"></i></div>
          <h3>Hair Styling</h3>
          <div class="price">$180+</div>
          <p>Precision haircuts, bespoke blowouts, and editorial styling by master artisans. Every shape is sculpted to complement your unique features.</p>
          <ul class="list-unstyled mt-3">
            <li><i class="fas fa-check text-gold me-2"></i>Women's Cut & Style – $180</li>
            <li><i class="fas fa-check text-gold me-2"></i>Men's Cut & Style – $95</li>
            <li><i class="fas fa-check text-gold me-2"></i>Blowout & Styling – $120</li>
            <li><i class="fas fa-check text-gold me-2"></i>Formal Updo – $250</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="service-detail-card" data-aos="fade-up" data-aos-delay="50">
          <div class="service-icon"><i class="fas fa-palette"></i></div>
          <h3>Hair Coloring</h3>
          <div class="price">$250+</div>
          <p>Luxurious color transformations using premium Oribe and Kerastase. From subtle balayage to bold fashion colors.</p>
          <ul class="list-unstyled mt-3">
            <li><i class="fas fa-check text-gold me-2"></i>Full Color – $250</li>
            <li><i class="fas fa-check text-gold me-2"></i>Balayage – $350</li>
            <li><i class="fas fa-check text-gold me-2"></i>Highlights – $280</li>
            <li><i class="fas fa-check text-gold me-2"></i>Color Correction – $500+</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="service-detail-card" data-aos="fade-up" data-aos-delay="100">
          <div class="service-icon"><i class="fas fa-spa"></i></div>
          <h3>Bridal Makeup</h3>
          <div class="price">$450+</div>
          <p>Breathtaking bridal beauty using luxury products. Including trial session, full bridal party coordination, and touch-up kit.</p>
          <ul class="list-unstyled mt-3">
            <li><i class="fas fa-check text-gold me-2"></i>Bridal Trial – $200</li>
            <li><i class="fas fa-check text-gold me-2"></i>Bridal Makeup – $450</li>
            <li><i class="fas fa-check text-gold me-2"></i>Bridal Party (per person) – $250</li>
            <li><i class="fas fa-check text-gold me-2"></i>Hair & Makeup Package – $650</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="service-detail-card" data-aos="fade-up" data-aos-delay="150">
          <div class="service-icon"><i class="fas fa-hand-sparkles"></i></div>
          <h3>Skin Treatment</h3>
          <div class="price">$200+</div>
          <p>Advanced clinical facials and holistic skincare therapies using La Mer and professional-grade cosmeceuticals.</p>
          <ul class="list-unstyled mt-3">
            <li><i class="fas fa-check text-gold me-2"></i>Signature Facial – $200</li>
            <li><i class="fas fa-check text-gold me-2"></i>HydraGlow Treatment – $320</li>
            <li><i class="fas fa-check text-gold me-2"></i>Microdermabrasion – $280</li>
            <li><i class="fas fa-check text-gold me-2"></i>Chemical Peel – $350</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="service-detail-card" data-aos="fade-up" data-aos-delay="200">
          <div class="service-icon"><i class="fas fa-hand-peace"></i></div>
          <h3>Nail Art</h3>
          <div class="price">$90+</div>
          <p>Exquisite hand and foot treatments featuring premium CND and OPI products. Custom nail art by our resident artists.</p>
          <ul class="list-unstyled mt-3">
            <li><i class="fas fa-check text-gold me-2"></i>Classic Manicure – $90</li>
            <li><i class="fas fa-check text-gold me-2"></i>Gel Manicure – $130</li>
            <li><i class="fas fa-check text-gold me-2"></i>Nail Art Design – $150+</li>
            <li><i class="fas fa-check text-gold me-2"></i>Luxury Pedicure – $140</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="service-detail-card" data-aos="fade-up" data-aos-delay="250">
          <div class="service-icon"><i class="fas fa-hot-tub"></i></div>
          <h3>Spa Therapy</h3>
          <div class="price">$280+</div>
          <p>Holistic wellness journeys combining ancient techniques with modern luxury. Restore balance and harmonize body and mind.</p>
          <ul class="list-unstyled mt-3">
            <li><i class="fas fa-check text-gold me-2"></i>Swedish Massage – $280</li>
            <li><i class="fas fa-check text-gold me-2"></i>Hot Stone Therapy – $350</li>
            <li><i class="fas fa-check text-gold me-2"></i>Aromatherapy – $320</li>
            <li><i class="fas fa-check text-gold me-2"></i>Body Wrap – $400</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="before-after-section" id="process">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <span class="section-tag text-center text-gold">Your Journey</span>
        <h2 class="section-title text-light">The <span class="text-gold">Vérité</span> Experience</h2>
        <div class="section-ornament"><span class="line"></span><span class="diamond"></span><span class="line"></span></div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="process-timeline" data-aos="fade-up">
          <div class="process-step">
            <span class="process-step-number">01</span>
            <h4 class="text-light">Consultation & Discovery</h4>
            <p>Begin with a personalized consultation where we listen to your desires and assess your unique beauty profile.</p>
          </div>
          <div class="process-step">
            <span class="process-step-number">02</span>
            <h4 class="text-light">Bespoke Treatment Plan</h4>
            <p>Our experts design a tailored treatment plan, selecting the finest products and techniques for your specific needs.</p>
          </div>
          <div class="process-step">
            <span class="process-step-number">03</span>
            <h4 class="text-light">The Luxury Experience</h4>
            <p>Surrender to an indulgent experience in our serene environment, complete with premium amenities and personalized attention.</p>
          </div>
          <div class="process-step">
            <span class="process-step-number">04</span>
            <h4 class="text-light">Aftercare & Follow-Up</h4>
            <p>We provide expert aftercare guidance and product recommendations to ensure your beauty lasts long after your visit.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="faq-section" id="faq">
  <div class="container">
    <div class="row">
      <div class="col-lg-5">
        <div class="faq-image" data-aos="fade-right">
          <img src="https://images.unsplash.com/photo-1633681926024-8ef6e8c5b182?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="FAQ" loading="lazy">
          <div class="faq-float faq-float-1"><i class="fas fa-question"></i></div>
          <div class="faq-float faq-float-2"><i class="fas fa-star"></i></div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="ps-lg-5">
          <span class="section-tag">Service FAQ</span>
          <h2 class="section-title">Service <span class="text-gradient">Questions</span></h2>
          <div class="gold-divider"></div>
          <div class="faq-accordion mt-5" data-aos="fade-up">
            <div class="accordion" id="faqAccordion">
              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">How long does a typical service take?</button>
                </h3>
                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">Service times vary: haircuts 45–60 min, color services 1.5–3 hours, facials 60–75 min, spa treatments 60–90 min. Bridal packages may require 2–3 hours.</div>
                </div>
              </div>
              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">Do you offer gift certificates?</button>
                </h3>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">Yes, we offer elegant gift certificates in any denomination, presented in a luxury keepsake box. Perfect for those who deserve the finest.</div>
                </div>
              </div>
              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">What safety measures do you follow?</button>
                </h3>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">We maintain the highest standards of hygiene and sanitation. All tools are sterilized, stations are disinfected between guests, and our team follows rigorous health protocols.</div>
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
