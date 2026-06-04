<?php
$title = "Product Gallery | Khodiyar Steel";
$description = "View high-resolution product photos of modular wardrobes, ICU hospital beds, poolside recliners, safety gates, and landscape gazebos manufactured by Khodiyar Steel.";
$page = "gallery";
include 'header.php';
?>

<!-- Subpage Hero Section -->
    <section class="aiero-hero subpage-hero" style="height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline">VISUAL ARCHIVE</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1;">Product Gallery</h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto;">Browse through our high-end luxury fabrications, custom structural safety gates, ICU modular hospital beds, and modern almirahs.</p>
        </div>
    </section>

    <!-- filterable Portfolio section -->
    <section class="aiero-creations" id="gallery-container" style="padding: 6rem 8% 8rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-creations-container">
            
            <!-- Category Filter Buttons -->
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; margin-bottom: 4rem;">
                <button class="aiero-btn-capsule" style="background: #FFC229; border-color: #FFC229; color: var(--color-text); padding: 0.6rem 1.6rem; font-size: 0.75rem;">All Works</button>
                <button class="aiero-btn-capsule" style="padding: 0.6rem 1.6rem; font-size: 0.75rem;">Beds</button>
                <button class="aiero-btn-capsule" style="padding: 0.6rem 1.6rem; font-size: 0.75rem;">Hospital</button>
                <button class="aiero-btn-capsule" style="padding: 0.6rem 1.6rem; font-size: 0.75rem;">Storage</button>
                <button class="aiero-btn-capsule" style="padding: 0.6rem 1.6rem; font-size: 0.75rem;">Doors</button>
                <button class="aiero-btn-capsule" style="padding: 0.6rem 1.6rem; font-size: 0.75rem;">Dining</button>
                <button class="aiero-btn-capsule" style="padding: 0.6rem 1.6rem; font-size: 0.75rem;">Outdoor</button>
            </div>

            <!-- Staggered Card Grid -->
            <div class="aiero-creations-grid">

                <!-- Item 1: beds -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-1">
                        <div class="aiero-creation-img" style="background-image: url('assets/project1.jpg');"></div>
                        <div class="aiero-creation-view-more">ZOOM</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Luxury Metal Bed</span>
                            <p class="aiero-creation-desc">Bespoke luxury headboard and structural bedframe finish.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 2: cupboards -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-2">
                        <div class="aiero-creation-img" style="background-image: url('assets/project2.jpg');"></div>
                        <div class="aiero-creation-view-more">ZOOM</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Modular Almirah Wardrobe</span>
                            <p class="aiero-creation-desc">Textured sliding metal cupboard with triple drawers and lockers.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 3: doors -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-3">
                        <div class="aiero-creation-img" style="background-image: url('assets/project3.jpg');"></div>
                        <div class="aiero-creation-view-more">ZOOM</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Plated Safety Door</span>
                            <p class="aiero-creation-desc">Double-plated soundproof safety door with secure multi-lock box.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 4: hospital -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-1">
                        <div class="aiero-creation-img" style="background-image: url('assets/hero.jpg');"></div>
                        <div class="aiero-creation-view-more">ZOOM</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Fowler ICU Medical Bed</span>
                            <p class="aiero-creation-desc">Precision mechanical positioning Fowler hospital ward bed.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 5: dining-bathroom -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-2">
                        <div class="aiero-creation-img" style="background-image: url('assets/project4.jpg');"></div>
                        <div class="aiero-creation-view-more">ZOOM</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Stainless Steel Dining Set</span>
                            <p class="aiero-creation-desc">6-seater premium steel dining table paired with high-back chairs.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 6: outdoor -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-3">
                        <div class="aiero-creation-img" style="background-image: url('assets/project5.jpg');"></div>
                        <div class="aiero-creation-view-more">ZOOM</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Garden Gazebo Structure</span>
                            <p class="aiero-creation-desc">Heavy-duty structural outdoor gazebo pavilion with windproofing.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
