<?php
$title = "Our Product Categories | Khodiyar Steel";
$description = "Explore our extensive industrial range of metal beds, hospital equip, cupboards, modular almirahs, dining sets, safety doors, and outdoor steel structures.";
$page = "products";
include 'header.php';
?>

<!-- Subpage Hero Section -->
    <section class="aiero-hero subpage-hero" style="height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content" style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline">PRODUCT PORTFOLIO</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1;">Our Product Categories</h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto;">Discover our specialized production lines engineered for ultimate durability, load strength, and premium architectural utility.</p>
        </div>
    </section>

    <!-- Categories Grid Section -->
    <section class="aiero-creations" id="categories" style="padding: 6rem 8% 8rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-creations-container">
            <div class="aiero-creations-grid">

                <!-- Category 1: Beds -->
                <div class="aiero-creation-card-wrapper">
                    <a href="category-beds" class="aiero-creation-card card-float-1" style="display: block;">
                        <div class="aiero-creation-img" style="background-image: url('assets/metal-bed-7201-01.webp');"></div>
                        <div class="aiero-creation-view-more">ENTER</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Metal Bed Frames</span>
                            <p class="aiero-creation-desc">Premium bedroom furniture, customizable heavy-duty bedframes, and roadside poolside metal loungers.</p>
                        </div>
                    </a>
                </div>

                <!-- Category 2: Hospital Beds -->
                <?php /*<div class="aiero-creation-card-wrapper">
                    <a href="category-hospital" class="aiero-creation-card card-float-2" style="display: block;">
                        <div class="aiero-creation-img" style="background-image: url('assets/icu-fowler-bed-01.webp');"></div>
                        <div class="aiero-creation-view-more">ENTER</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Hospital Equipment & Beds</span>
                            <p class="aiero-creation-desc">ICU Fowler beds, standard ward beds, medicine lockers, saline stands, and patient transport utilities.</p>
                        </div>
                    </a>
                </div> */ ?>

                <!-- Category 3: Cupboards -->
                <div class="aiero-creation-card-wrapper">
                    <a href="category-cupboards" class="aiero-creation-card card-float-3" style="display: block;">
                        <div class="aiero-creation-img" style="background-image: url('assets/household-wardrobe-02.webp');"></div>
                        <div class="aiero-creation-view-more">ENTER</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Steel Cupboards & Storage</span>
                            <p class="aiero-creation-desc">Premium household steel wardrobes, sliding modular almirahs, and secure office lockers.</p>
                        </div>
                    </a>
                </div>

                <!-- Category 4: Doors -->
                <div class="aiero-creation-card-wrapper">
                    <a href="category-doors" class="aiero-creation-card card-float-1" style="display: block;">
                        <div class="aiero-creation-img" style="background-image: url('assets/fire-safety-door-03.webp');"></div>
                        <div class="aiero-creation-view-more">ENTER</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Metal Doors & Safety Gates</span>
                            <p class="aiero-creation-desc">Custom entrance safety gates, double-plated fire doors, and secure metal frames.</p>
                        </div>
                    </a>
                </div>

                <!-- Category 5: Dining & Bathroom -->
                <div class="aiero-creation-card-wrapper">
                    <a href="category-dining-bathroom" class="aiero-creation-card card-float-2" style="display: block;">
                        <div class="aiero-creation-img" style="background-image: url('assets/dining-set-ds301-02.webp');"></div>
                        <div class="aiero-creation-view-more">ENTER</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Dining Sets & Bathroom Cabinets</span>
                            <p class="aiero-creation-desc">Modern stainless steel dining sets, modular wash basin vanity cabinets, and rust-proof mirrors.</p>
                        </div>
                    </a>
                </div>

                <!-- Category 6: Outdoor -->
                <div class="aiero-creation-card-wrapper">
                    <a href="category-outdoor" class="aiero-creation-card card-float-3" style="display: block;">
                        <div class="aiero-creation-img" style="background-image: url('assets/garden-steel-gazebo-02.webp');"></div>
                        <div class="aiero-creation-view-more">ENTER</div>
                        <div class="aiero-creation-content">
                            <span class="aiero-creation-label">Outdoor Metal Structures</span>
                            <p class="aiero-creation-desc">Premium garden gazebos and poolside recliners.</p>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
