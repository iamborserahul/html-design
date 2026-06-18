<?php
$title = "Dining Sets & Bathroom Cabinets | Khodiyar Steel";
$description = "Explore our modern steel dining table sets, high-end chairs, modular stainless steel bathroom vanity cabinets, and moisture-proof mirrors manufactured by Khodiyar Steel.";
$page = "products";
include 'header.php';
?>

<!-- Subpage Hero Section -->
    <section class="aiero-hero subpage-hero" style="height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline">CATEGORY PROFILE</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1;">Dining Sets & Bathroom Cabinets</h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto;">Luxury stainless steel dining table sets, ergonomic metal chairs, rust-proof bathroom vanity cabinets, and illuminated mirrors.</p>
        </div>
    </section>

    <!-- Interactive Products Catalogue List -->
    <section class="aiero-about" style="padding: 6rem 8% 4rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-about-container" style="grid-template-columns: 1fr 1fr; gap: 5rem;">
            <div class="aiero-about-content">
                <span class="aiero-about-tagline" style="color: #FFC229;">PRODUCT FEATURES</span>
                <h2 class="aiero-about-title" style="font-size: 36px;">Precision Dining & Bathroom Units</h2>
                <p style="opacity: 0.7; font-size: 1.02rem; line-height: 1.8;">Our premium dining tables and wet-area utility cabinets are built with rust-resistant grades of stainless steel and carbon steel, featuring moisture-proof powder primings, polished steel accents, and heat-resistant glass or marble overlays.</p>
                
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.4rem; color: var(--color-text); margin-top: 1.5rem;">Specific Model Outlines:</h3>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-utensils" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Modern Dining Sets</strong>: Luxury 4, 6, and 8-seater stainless steel dining tables paired with cushioned high-back steel chairs.</span>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-sink" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Stainless Steel Vanity Cabinets</strong>: Rust-proof vanity frames, freestanding bathroom cupboards, and high-clarity bathroom utilities.</span>
                    </li>
                </ul>
            </div>

            <!-- Category Image Panel -->
            <div style="border-radius: 20px; overflow: hidden; min-height: 400px; background: url('assets/project4.jpg') center center / cover no-repeat; border: 1px solid rgba(255,255,255,0.06);"></div>
        </div>
    </section>

    <!-- Product Catalog Grid -->
    <section class="aiero-creations" id="products-list" style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 7rem;">
        <div class="aiero-creations-container">
            <div class="aiero-creations-header">
                <span class="aiero-creations-tagline">INTERIOR SELECTIONS</span>
                <h2 class="aiero-creations-title" style="font-size: 34px;">Dining Sets & Bathroom Cabinets</h2>
            </div>
            
            <div class="aiero-creations-grid" style="grid-template-columns: repeat(3, 1fr);">
                <!-- Card 1 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=dining-set" class="aiero-creation-card card-float-1" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/project4.jpg');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">STAINLESS STEEL DINING SET</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Luxury 6-seater dining set with premium mirror-polish tubes and glass/marble top panels.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=vanity-cabinet" class="aiero-creation-card card-float-2" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/project1.jpg');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">MODULAR VANITY CABINET</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Moisture-resistant under-basin cupboards with soft-close hinges. Ideal for bathrooms.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 3 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=mirror-frame" class="aiero-creation-card card-float-3" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/project4.jpg');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">STRUCTURAL MIRROR FRAME</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Elegant rust-proof stainless steel decorative frames for premium mirrors and bathroom styling.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Download Catalogues Section -->
    <section class="aiero-about" style="padding: 4rem 8% 6rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div style="display: flex; justify-content: center;">
            <div class="aiero-about-content" style="justify-content: center; gap: 2rem; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); padding: 3rem; border-radius: 20px; text-align: center; align-items: center;">
                <i class="fa-solid fa-file-pdf" style="font-size: 4rem; color: #ff3333; filter: drop-shadow(0 0 15px rgba(255,51,51,0.2));"></i>
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.8rem; color: var(--color-text);">Download Catalogues</h3>
                <p style="opacity: 0.6; font-size: 0.92rem; line-height: 1.6; max-width: 320px;">Download our official drafted PDF catalogs containing dining set measurements, bathroom vanity models, and color options.</p>
                
                <div style="display: flex; flex-direction: column; gap: 1.2rem; width: 100%; max-width: 340px;">
                    <a href="ksi/Dinning Set.pdf" download class="aiero-btn-discover" style="transform: none; opacity: 1; margin: 0 auto; width: 100%; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25);">
                        <i class="fa-solid fa-download"></i> Dining Sets Catalogue
                    </a>
                    <a href="ksi/Bathroom Cabinet.pdf" download class="aiero-btn-discover" style="transform: none; opacity: 1; margin: 0 auto; width: 100%; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25);">
                        <i class="fa-solid fa-download"></i> Bathroom Cabinet PDF
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
