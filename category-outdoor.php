<?php
$title = "Outdoor Metal Furniture & Structures | Khodiyar Steel";
$description = "Explore our high-end garden gazebos, heavy structural poolside loungers, patio swings, and landscape metal products manufactured by Khodiyar Steel.";
$page = "products";
include 'header.php';
?>

<!-- Subpage Hero Section -->
    <section class="aiero-hero subpage-hero" style="height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline">CATEGORY PROFILE</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1;">Outdoor Metal Structures</h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto;">Premium garden steel gazebos, heavy structural swings, poolside loungers, and custom outdoor architectural metal pavilions.</p>
        </div>
    </section>

    <!-- Interactive Products Catalogue List -->
    <section class="aiero-about" style="padding: 6rem 8% 4rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-about-container" style="grid-template-columns: 1fr 1fr; gap: 5rem;">
            <div class="aiero-about-content">
                <span class="aiero-about-tagline" style="color: #FFC229;">PRODUCT FEATURES</span>
                <h2 class="aiero-about-title" style="font-size: 36px;">Precision Landscape Structures</h2>
                <p style="opacity: 0.7; font-size: 1.02rem; line-height: 1.8;">Our outdoor and garden architectural steel range is fabricated from extra-heavy structural steel, undergoing multi-stage sandblasting, rust inhibitors, and high-performance weather-proof powder treatments designed to withstand sun and rain.</p>
                
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.4rem; color: var(--color-text); margin-top: 1.5rem;">Specific Model Outlines:</h3>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-umbrella" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Garden Gazebos & Pavilions</strong>: Premium structural steel gazebos with high wind resistance, custom roof contours, and columns.</span>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-chair" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Poolside Recliners & Swings</strong>: Heavyward structural poolside metal recliners and double-anchor garden swing sets.</span>
                    </li>
                </ul>
            </div>

            <!-- Category Image Panel -->
            <div style="border-radius: 20px; overflow: hidden; min-height: 400px; background: url('assets/garden-steel-gazebo-02.webp') center center / cover no-repeat; border: 1px solid rgba(255,255,255,0.06);"></div>
        </div>
    </section>

    <!-- Product Catalog Grid -->
    <section class="aiero-creations" id="products-list" style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 7rem;">
        <div class="aiero-creations-container">
            <div class="aiero-creations-header">
                <span class="aiero-creations-tagline">LANDSCAPE SELECTIONS</span>
                <h2 class="aiero-creations-title" style="font-size: 34px;">Outdoor Structures & Swings</h2>
            </div>
            
            <div class="aiero-creations-grid" style="grid-template-columns: repeat(3, 1fr);">
                <!-- Card 1 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=gazebo" class="aiero-creation-card card-float-1" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/garden-steel-gazebo-02.webp');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">GARDEN STEEL GAZEBO</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Heavy-gauge weather-proof structural steel gazebo with custom columns and arches.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=poolside-recliner" class="aiero-creation-card card-float-2" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/poolside-recliner-chair-01.webp');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">POOLSIDE RECLINER</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Folding poolside steel lounger with multi-level adjustment and high weather durability.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 3 -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=outdoor-swing" class="aiero-creation-card card-float-3" style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/architectural-steel-swing-01.webp');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">ARCHITECTURAL SWING</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Double-anchor heavy metal garden swing set with rust-resistant powder coatings.</p>
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
                <p style="opacity: 0.6; font-size: 0.92rem; line-height: 1.6; max-width: 320px;">Download our official drafted PDF catalogs containing structural gazebo sizing, poolside recliner specifications, and swinger models.</p>
                
                <div style="display: flex; flex-direction: column; gap: 1.2rem; width: 100%; max-width: 340px;">
                    <a href="ksi/Gazebo.pdf" download class="aiero-btn-discover" style="transform: none; opacity: 1; margin: 0 auto; width: 100%; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25);">
                        <i class="fa-solid fa-download"></i> Gazebo Catalogue PDF
                    </a>
                    <a href="ksi/Adjustable Bed & Poolside Chair.pdf" download class="aiero-btn-discover" style="transform: none; opacity: 1; margin: 0 auto; width: 100%; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25);">
                        <i class="fa-solid fa-download"></i> Poolside Chair Specs PDF
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
