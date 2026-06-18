<?php
$title = "Contact Us | Khodiyar Steel";
$description = "Get in touch with Khodiyar Steel in Surat, Gujarat. Submit an inquiry for luxury metal wardrobes, custom steel safety doors, ICUs ward equipment, or structural swings.";
$page = "contact";
include 'header.php';
?>

<!-- Subpage Hero Section -->
    <section class="aiero-hero subpage-hero" style="height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline">GET IN TOUCH</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1;">Connect With Our Experts</h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto;">Connect with Khodiyar Steel today. Our specialized engineering division is standing by to assist with your residential, hospital, or commercial fabrication needs.</p>
        </div>
    </section>

    <!-- Contact details and Inquiry Form -->
    <section class="aiero-about" style="padding: 6rem 8% 4rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-about-container" style="grid-template-columns: 0.95fr 1.05fr; gap: 5rem; align-items: start;">
            
            <!-- Left Side: Contact Information Cards -->
            <div class="aiero-about-content" style="gap: 2.2rem;">
                <span class="aiero-about-tagline" style="color: #FFC229;">OFFICE & HQ</span>
                <h2 class="aiero-about-title" style="font-size: 38px;">Contact Details</h2>
                <p style="opacity: 0.7; font-size: 1rem; line-height: 1.8;">Our manufacturing plant is located in Surat, Gujarat, equipped with state-of-the-art sheet slitting, seamless bending, standard powder coating, and structural iron welding grids.</p>
                
                <div style="display: flex; flex-direction: column; gap: 1.8rem; margin-top: 1rem;">
                    <!-- Address Card -->
                    <div class="aiero-contact-info-card">
                        <i class="fa-solid fa-location-dot" style="font-size: 1.5rem; color: #FFC229; margin-top: 0.2rem;"></i>
                        <div>
                            <h4 style="font-family: 'Cinzel', serif; font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.4rem;">Corporate Address</h4>
                            <p style="opacity: 0.7; font-size: 0.95rem; line-height: 1.6;">Khodiyar Steel Industries<br>Block no 9, Rd Number 5, Udhana GIDC,<br>Udhna Udhyog Nagar, Udhana,<br>Surat, Gujarat 394210</p>
                        </div>
                    </div>

                    <!-- Email & General Inquiries -->
                    <div class="aiero-contact-info-card">
                        <i class="fa-solid fa-envelope" style="font-size: 1.5rem; color: #FFC229; margin-top: 0.2rem;"></i>
                        <div>
                            <h4 style="font-family: 'Cinzel', serif; font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.4rem;">Digital Inquiries</h4>
                            <a href="mailto:nayannitinpatel@gmail.com" style="opacity: 0.7; font-size: 0.95rem; line-height: 1.6;">nayannitinpatel@gmail.com</a>
                        </div>
                    </div>

                    <!-- Phone Active CTA -->
                    <div class="aiero-about-phone" style="margin-top: 1rem;">
                        <div class="aiero-phone-icon">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="aiero-phone-details">
                            <span class="aiero-phone-label">Reservation / Sales</span>
                            <a href="tel:9825186385" class="aiero-phone-num">98251 86385</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Luxury Glassmorphic Inquiry Form -->
            <div class="aiero-contact-form-card">
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.8rem; color: var(--color-text); margin-bottom: 0.5rem; text-align: left;">Inquiry Form</h3>
                <p style="opacity: 0.6; font-size: 0.9rem; line-height: 1.6; margin-bottom: 2rem; text-align: left;">Please fill out the details below. Our technical engineering division will respond to your blueprint or almirah layouts within 24 hours.</p>
                
                <form action="#" method="POST" style="display: flex; flex-direction: column; gap: 1.6rem; text-align: left;">
                    <div class="aiero-contact-form-row">
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label for="name" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.8; font-weight: 600;">Full Name</label>
                            <input type="text" id="name" required placeholder="e.g. Rahul Patel" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); color: var(--color-text); padding: 0.9rem 1.2rem; border-radius: 8px; font-family: inherit; font-size: 0.92rem; transition: border-color 0.3s;">
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label for="email" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.8; font-weight: 600;">Email Address</label>
                            <input type="email" id="email" required placeholder="e.g. rahul@gmail.com" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); color: var(--color-text); padding: 0.9rem 1.2rem; border-radius: 8px; font-family: inherit; font-size: 0.92rem; transition: border-color 0.3s;">
                        </div>
                    </div>

                    <div class="aiero-contact-form-row">
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label for="phone" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.8; font-weight: 600;">Mobile Number</label>
                            <input type="tel" id="phone" required placeholder="e.g. +91 92650 XXXXX" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); color: var(--color-text); padding: 0.9rem 1.2rem; border-radius: 8px; font-family: inherit; font-size: 0.92rem; transition: border-color 0.3s;">
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label for="category" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.8; font-weight: 600;">Product Category</label>
                            <select id="category" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); color: var(--color-text); padding: 0.9rem 1.2rem; border-radius: 8px; font-family: inherit; font-size: 0.92rem; transition: border-color 0.3s; cursor: pointer; color-scheme: dark;">
                                <option value="" disabled selected style="background:#111;">Select category...</option>
                                <option value="beds" style="background:#111;">Metal & Adjustable Beds</option>
                                <option value="hospital" style="background:#111;">Hospital Beds & Equipment</option>
                                <option value="storage" style="background:#111;">Cupboards & Storage Almirahs</option>
                                <option value="doors" style="background:#111;">Safety Doors & Fabrication</option>
                                <option value="dining" style="background:#111;">Dining & Bathroom Units</option>
                                <option value="outdoor" style="background:#111;">Outdoor Swings & Gazebos</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="message" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.8; font-weight: 600;">Blueprints or Custom Message</label>
                        <textarea id="message" rows="4" required placeholder="Describe your dimensional custom sizing or cabinet requirements..." style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); color: var(--color-text); padding: 0.9rem 1.2rem; border-radius: 8px; font-family: inherit; font-size: 0.92rem; transition: border-color 0.3s; resize: none;"></textarea>
                    </div>

                    <button type="submit" class="aiero-btn-discover" style="transform: none; opacity: 1; margin: 0.5rem 0 0; width: 100%; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25);">
                        <i class="fa-solid fa-paper-plane"></i> Send Inquiry Details
                    </button>
                </form>
            </div>
            
        </div>
    </section>

    <!-- Google Map Interactive Iframe Section -->
    <section id="map" style="padding: 0 8% 6rem; border-top: 1px solid rgba(255, 255, 255, 0.05); text-align: center;">
        <div style="max-width: 1400px; margin: 0 auto; border-radius: 24px; overflow: hidden; border: 1px solid rgba(255,255,255,0.06); box-shadow: 0 30px 60px rgba(0,0,0,0.3); height: 450px; background: rgba(255,255,255,0.01);">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d391.07629854968985!2d72.84733935547972!3d21.16967374995095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04f835b331f5b%3A0x7a3f94eaced756c1!2sKhodiyar%20Steel%20Industries!5e0!3m2!1sen!2sin!4v1781706553496!5m2!1sen!2sin" 
                width="100%" height="100%"  allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="border: 0;"></iframe>
        </div>
    </section>

    <!-- Contact Tailored FAQs Section -->
    <section class="aiero-faq-section" id="contact-faq" style="padding-top: 0; padding-bottom: 6rem;">
        <div class="aiero-faq-wrapper">
            <div style="text-align: center; display: flex; flex-direction: column; gap: 1rem; margin-bottom: 3.5rem;">
                <span class="aiero-creations-tagline">ORDERING & SHIPPING FAQs</span>
                <h2 class="aiero-creations-title" style="font-size: 36px; text-align: center;">Frequently Asked Questions</h2>
            </div>
            
            <div class="aiero-faq-item">
                <button class="aiero-faq-trigger" aria-expanded="false">
                    <span class="aiero-faq-question">How can I request a quote for custom dimensional steel furniture?</span>
                    <i class="fa-solid fa-chevron-down aiero-faq-icon"></i>
                </button>
                <div class="aiero-faq-panel">
                    <div class="aiero-faq-content">
                        You can easily submit custom dimensions, quantities, or specific color requests through our Inquiry Form. Alternatively, email your layout drawings directly to nayannitinpatel@gmail.com. Our pricing division will return a formal commercial quotation within 24 hours.
                    </div>
                </div>
            </div>

            <div class="aiero-faq-item">
                <button class="aiero-faq-trigger" aria-expanded="false">
                    <span class="aiero-faq-question">Do you provide CAD shop drawings or architectural approval drawings?</span>
                    <i class="fa-solid fa-chevron-down aiero-faq-icon"></i>
                </button>
                <div class="aiero-faq-panel">
                    <div class="aiero-faq-content">
                        No, we do not create or supply CAD shop drawings, architectural drawings, or engineering layouts. However, if you already have approved CAD drawings or design specifications from your architect, designer, or project consultant, we can review them and confirm whether the design is suitable for manufacturing and installation. This helps ensure the final product aligns with your project requirements, dimensions, and material specifications before production begins.
                    </div>
                </div>
            </div>

            <div class="aiero-faq-item">
                <button class="aiero-faq-trigger" aria-expanded="false">
                    <span class="aiero-faq-question">What are your logistical shipping ranges and freight configurations?</span>
                    <i class="fa-solid fa-chevron-down aiero-faq-icon"></i>
                </button>
                <div class="aiero-faq-panel">
                    <div class="aiero-faq-content">
                        We ship nationwide across India. Catalog models (like beds, lockers, and wardrobes) are packed in heavy-duty knock-down forms with secure bubble wrapping and corrugated edge-protectors to prevent transit damage. Assembly instructions and fittings are fully included. Bulk institutional shipping is dispatched via specialized freight networks.
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
