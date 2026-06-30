<?php
$title = "Metal Doors & Safety Gates | Khodiyar Steel";
$description = "Explore our highly secure double-plated steel safety doors, entrance security gates, and custom frames manufactured by Khodiyar Steel.";
$page = "products";
include 'header.php';
?>

<!-- Subpage Hero Section -->
    <section class="aiero-hero subpage-hero" style="height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline">CATEGORY PROFILE</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1;">Metal Doors & Safety Gates</h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto;">Premium entrance safety gates, double-plated fire safety doors, structural frames, and custom steel grilles.</p>
        </div>
    </section>

    <!-- Interactive Products Catalogue List -->
    <section class="aiero-about" style="padding: 6rem 8% 4rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-about-container" style="grid-template-columns: 1fr 1fr; gap: 5rem;">
            <div class="aiero-about-content">
                <span class="aiero-about-tagline" style="color: #FFC229;">PRODUCT FEATURES</span>
                <h2 class="aiero-about-title" style="font-size: 36px;">Precision Security Doors</h2>
                <p style="opacity: 0.7; font-size: 1.02rem; line-height: 1.8;">Our safety doors and structural entrance gates are custom fabricated from highest-grade steel tubes and cold-rolled sheets, utilizing secure heavy-duty hinges, multi-point lock boxes, and anti-corrosion primings.</p>
                
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.4rem; color: var(--color-text); margin-top: 1.5rem;">Specific Model Outlines:</h3>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-door-closed" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Double-Plated Safety Doors</strong>: Fire-safe modular double-plated sheet steel doors with soundproof internal fills and designer grooves.</span>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-shield-halved" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Main Security Gates</strong>: Bespoke designed decorative gates, safety grills, and customized frames.</span>
                    </li>
                </ul>
            </div>

            <!-- Category Image Panel -->
            <div style="border-radius: 20px; overflow: hidden; min-height: 400px; background: url('assets/fire-safety-door-03.webp') center center / cover no-repeat; border: 1px solid rgba(255,255,255,0.06);"></div>
        </div>
    </section>

    <!-- Product Catalog Grid -->
    <section class="aiero-creations" id="products-list" style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 7rem;">
        <div class="aiero-creations-container">
            <div class="aiero-creations-header">
                <span class="aiero-creations-tagline">PRODUCT SELECTIONS</span>
                <h2 class="aiero-creations-title" style="font-size: 34px;">Doors & Security Gates</h2>
            </div>
            
            <div class="aiero-creations-grid" style="grid-template-columns: repeat(3, 1fr);">
                <!-- Card 1 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=safety-door" class="aiero-creation-card card-float-1" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/fire-safety-door-03.webp');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">FIRE SAFETY DOOR</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Double-plated heavy sheet steel fire safety doors with structural reinforcement ribs.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=entrance-gate" class="aiero-creation-card card-float-2" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/main-entrance-gate-01.webp');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">MAIN ENTRANCE GATE</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Bespoke entrance security gates with geometric design lines.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 3 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=structural-frame" class="aiero-creation-card card-float-3" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/precision-metal-frame-01.webp');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">PRECISION METAL FRAME DOOR</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Custom structural iron grids, safety grilles, and building facade framing elements.</p>
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
                <p style="opacity: 0.6; font-size: 0.92rem; line-height: 1.6; max-width: 320px;">Download our official drafted PDF specification catalog containing door profiles, gate designs, and manufacturing tolerances.</p>
                
                <div style="display: flex; flex-direction: column; gap: 1.2rem; width: 100%; max-width: 340px;">
                    <a href="ksi/Door.pdf" download class="aiero-btn-discover" style="transform: none; opacity: 1; margin: 0 auto; width: 100%; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25);">
                        <i class="fa-solid fa-download"></i> Safety Door Catalogue PDF
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
