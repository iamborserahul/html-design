<?php
$title = "Product Details | Khodiyar Steel";
$description = "View exhaustive dimensional plans, material grades, assembly instructions, and technical specifications for our precision steel products.";
$page = "products";
include 'header.php';
?>

<!-- Subpage Hero Section (Compact) -->
    <section class="aiero-hero subpage-hero" style="height: 45vh; min-height: 300px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <ul class="aiero-breadcrumbs" id="details-breadcrumbs">
                <!-- Breadcrumbs populated dynamically -->
            </ul>
            <h1 class="aiero-slide-title" id="details-hero-title" style="transform: none; opacity: 1; font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 0.5rem;">Precision Model Details</h1>
            <p class="aiero-slide-desc" id="details-hero-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto; font-size: 0.95rem;">Exhaustive structural plans, dimensional limits, and engineering specifications directly transcribed from our official catalogs.</p>
        </div>
    </section>

    <!-- Dynamic Product Details Section -->
    <section class="aiero-about" style="padding: 4rem 8% 6rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-about-container aiero-details-grid">
            
            <!-- Left Side: Interactive Image Gallery -->
            <div class="aiero-details-gallery">
                <div class="aiero-gallery-main">
                    <img id="details-main-img" src="assets/metal-bed-7201-01.webp" alt="Selected model preview">
                </div>
                <div class="aiero-gallery-thumbs" id="details-thumbs-row">
                    <!-- Populated dynamically -->
                </div>
            </div>

            <!-- Right Side: Model Specifications & Highlights -->
            <div class="aiero-about-content" style="gap: 1.5rem;">
                <span class="aiero-about-tagline" id="details-category-tagline" style="color: #FFC229;">METAL BEDS DIVISION</span>
                <h2 class="aiero-about-title" id="details-product-title" style="font-size: clamp(2rem, 3.2vw, 2.6rem); line-height: 1.25; margin-bottom: 0.5rem;">Platform Metal Bed</h2>
                
                <p id="details-short-desc" style="opacity: 0.7; font-size: 1.02rem; line-height: 1.8;">Water & fire proof design with elegant groove design panels, premium emboss outlines, and an adjustable screw-cap leg support grid designed to maximize comfort and structural longevity.</p>
                
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.25rem; color: var(--color-text); margin-top: 1rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 0.5rem;"><i class="fa-solid fa-list-check" style="color:#FFC229; margin-right:0.6rem;"></i>Technical Specifications</h3>
                
                <table class="aiero-spec-table">
                    <tbody id="details-spec-body">
                        <!-- Populated dynamically -->
                    </tbody>
                </table>

                <!-- Interactive Tab Panels -->
                <div class="aiero-tabs">
                    <div class="aiero-tabs-headers">
                        <button class="aiero-tab-header active" data-tab="tab-desc">Features</button>
                        <button class="aiero-tab-header" data-tab="tab-engineering">Engineering</button>
                        <button class="aiero-tab-header" data-tab="tab-custom">Custom Sizing</button>
                    </div>
                    
                    <div class="aiero-tab-panel active" id="tab-desc">
                        <ul id="details-features-list" style="list-style: none; display: flex; flex-direction: column; gap: 0.8rem;">
                            <!-- Populated dynamically -->
                        </ul>
                    </div>
                    
                    <div class="aiero-tab-panel" id="tab-engineering">
                        <p id="details-eng-info" style="opacity: 0.8; font-size: 0.95rem; line-height: 1.7;">All joints are joined via seamless carbon dioxide welding grids, ensuring standard structural integrity and a perfect load limit. Surface coatings use standard industrial pre-treatments, acid cleaning, phosphating, and oven-baked polyester powder coating.</p>
                    </div>
                    
                    <div class="aiero-tab-panel" id="tab-custom">
                        <p id="details-custom-info" style="opacity: 0.8; font-size: 0.95rem; line-height: 1.7;">Custom dimensional width parameters, height setups, and alternative coloring sheets (such as standard chocolate, charcoal, metallic grey, gold, and white) can be requested during quotation.</p>
                    </div>
                </div>

                <!-- Call to Actions -->
                <div style="display: flex; gap: 1.5rem; margin-top: 2.2rem; width: 100%;">
                    <a href="#" id="details-inquire-btn" class="aiero-btn-discover" style="transform: none; opacity: 1; margin: 0; flex: 1.2; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25);">
                        <i class="fa-solid fa-paper-plane"></i> Submit Inquiry Quote
                    </a>
                    <a href="#" id="details-download-btn" download class="aiero-btn-discover" style="transform: none; opacity: 1; margin: 0; flex: 0.8; justify-content: center; background: transparent; border: 1px solid rgba(255,255,255,0.15); box-shadow: none;">
                        <i class="fa-solid fa-file-pdf" style="color: #ff3333;"></i> Download Spec
                    </a>
                </div>
            </div>
            
        </div>
    </section>

    <!-- Related Products Carousel -->
    <section class="aiero-creations" id="related-products" style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 7rem;">
        <div class="aiero-creations-container">
            <div class="aiero-creations-header">
                <span class="aiero-creations-tagline">ALTERNATIVE SELECTIONS</span>
                <h2 class="aiero-creations-title" style="font-size: 34px;">Related Products</h2>
            </div>
            
            <div class="aiero-creations-grid" id="details-related-grid">
                <!-- Related cards populated dynamically -->
            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
