<?php
$title = "Hospital Beds & Equipment | Khodiyar Steel";
$description = "Explore our highly sterile, durable hospital Fowler beds, ward plain beds, bedside cabinets, saline stands, and patient chairs manufactured by Khodiyar Steel.";
$page = "products";
include 'header.php';
?>

<!-- Subpage Hero Section -->
    <section class="aiero-hero subpage-hero" style="height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline">CATEGORY PROFILE</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1;">Hospital Beds & Equipment</h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto;">High-durability Fowler hospital beds, ICU adjustable units, bedside lockers, saline stands, and patient chairs engineered to meet extreme clinical standards.</p>
        </div>
    </section>

    <!-- Interactive Products Catalogue List -->
    <section class="aiero-about" style="padding: 6rem 8% 4rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-about-container" style="grid-template-columns: 1fr 1fr; gap: 5rem;">
            <div class="aiero-about-content">
                <span class="aiero-about-tagline" style="color: #FFC229;">PRODUCT FEATURES</span>
                <h2 class="aiero-about-title" style="font-size: 36px;">Precision Ward Equipment</h2>
                <p style="opacity: 0.7; font-size: 1.02rem; line-height: 1.8;">Our medical steel range is engineered for high sterility, chemical wash resistance, and rigorous load-bearing safety, using high-tensile seamless structural steel sections and anti-microbial epoxy finishes.</p>
                
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.4rem; color: var(--color-text); margin-top: 1.5rem;">Specific Model Outlines:</h3>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-hospital-user" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Standard Fowler Beds</strong>: Semi-fowler and full-fowler multi-position adjustable hospital beds with collapsing side railings.</span>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-notes-medical" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Clinical Storage Cabinets</strong>: Heavyward bedside almirahs, IV stands, stretchers, and medicine lockers for medical staffs.</span>
                    </li>
                </ul>
            </div>
            
            <!-- Download Catalogue Panel -->
            <div class="aiero-about-content" style="justify-content: center; gap: 2rem; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); padding: 3rem; border-radius: 20px; text-align: center; align-items: center;">
                <i class="fa-solid fa-file-pdf" style="font-size: 4rem; color: #ff3333; filter: drop-shadow(0 0 15px rgba(255,51,51,0.2));"></i>
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.8rem; color: var(--color-text);">Download Catalogues</h3>
                <p style="opacity: 0.6; font-size: 0.92rem; line-height: 1.6; max-width: 320px;">Download our official drafted PDF specification catalog containing hospital models, sizes, and layout requirements.</p>
                
                <div style="display: flex; flex-direction: column; gap: 1.2rem; width: 100%; max-width: 340px;">
                    <a href="ksi/Hospital Equipment and Furniture.pdf" download class="aiero-btn-discover" style="transform: none; opacity: 1; margin: 0 auto; width: 100%; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25);">
                        <i class="fa-solid fa-download"></i> Hospital Catalogue PDF
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Catalog Grid -->
    <section class="aiero-creations" id="products-list" style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 7rem;">
        <div class="aiero-creations-container">
            <div class="aiero-creations-header">
                <span class="aiero-creations-tagline">CLINICAL SELECTIONS</span>
                <h2 class="aiero-creations-title" style="font-size: 34px;">Hospital Ward Equipment</h2>
            </div>
            
            <div class="aiero-creations-grid">
                <!-- Card 1 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=icu-bed" class="aiero-creation-card card-float-1" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/hero.jpg');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">ICU FOWLER BED KH-01</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Multi-position mechanical cranks with collapsing side railings and locking caster grids.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=semi-fowler" class="aiero-creation-card card-float-2" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/project1.jpg');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">SEMI-FOWLER BED KH-02</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Single-crank backrest adjustability, heavy carbon-steel frame with epoxy finish.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 3 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=ward-bed" class="aiero-creation-card card-float-3" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/project4.jpg');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">WARD PLAIN BED KH-03</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Durable flat metal mesh top hospital bed. Heavy-duty pipes built for bulk ward setups.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 4 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=bedside-locker" class="aiero-creation-card card-float-1" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/hero.jpg');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">BEDSIDE CABINET KH-44</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Stainless steel bedside locker cupboard with single drawer, cabinet, and secure latches.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 5 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=saline-stand" class="aiero-creation-card card-float-2" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/project1.jpg');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">IV SALINE STAND KH-55</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Height adjustable chrome-plated steel stand with 4 hook hooks and rolling base wheels.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 6 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=stretcher" class="aiero-creation-card card-float-3" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/project4.jpg');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">TRANSPORT STRETCHER KH-77</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Removable stretcher top on strong tubular steel rolling trolley with safety bumper guides.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
