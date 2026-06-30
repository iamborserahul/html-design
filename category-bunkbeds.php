<?php
$title = "Bunk Beds | Khodiyar Steel";
$description = "Explore our premium range of kids and home bunk beds — convertible, triple-decker, sofa bunks, and themed designs engineered for safety and durability by Khodiyar Steel.";
$page = "products";
include 'header.php';
?>

<!-- Subpage Hero Section -->
    <section class="aiero-hero subpage-hero"
        style="height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center;">
        <div class="aiero-slide-content"
            style="position: relative; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline">CATEGORY PROFILE</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1;">Bunk Beds</h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto;">Premium
                convertible bunk beds, themed kids bunks, sofa-convertible designs, and heavy-duty triple-deckers
                built for homes, hostels, and institutions.</p>
        </div>
    </section>

    <!-- Interactive Products Catalogue List -->
    <section class="aiero-about" style="padding: 6rem 8% 4rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-about-container" style="grid-template-columns: 1fr 1fr; gap: 5rem;">
            <div class="aiero-about-content">
                <span class="aiero-about-tagline" style="color: #FFC229;">PRODUCT FEATURES</span>
                <h2 class="aiero-about-title" style="font-size: 36px;">Premium Bunk Bed Designs</h2>
                <p style="opacity: 0.7; font-size: 1.02rem; line-height: 1.8;">Our bunk beds combine playful design
                    with industrial-grade engineering. Every model features concealed bolt joints, high-altitude safety
                    rails, fire-safe powder coatings, and flat-pack convenience for easy transport and assembly.</p>

                <h3
                    style="font-family: 'Cinzel', serif; font-size: 1.4rem; color: var(--color-text); margin-top: 1.5rem;">
                    Key Design Highlights:</h3>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-children" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Child-Safe Engineering</strong>: No exposed sharp bolts or edges — every joint
                            is rounded and concealed for maximum child safety.</span>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-arrows-rotate" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Convertible Frameworks</strong>: Most models split into two independent single
                            beds or convert into sofas, adapting as your needs change.</span>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-shield-halved" style="color: #FFC229; margin-top: 0.3rem;"></i>
                        <span><strong>Heavy-Duty Structure</strong>: Reinforced steel profiles and zero-rattle
                            welded joints built to handle energetic kids and hostel environments.</span>
                    </li>
                </ul>
            </div>

            <!-- Category Image Panel -->
            <div style="border-radius: 20px; overflow: hidden; min-height: 400px; background: url('assets/origami-bunk-bed-01.webp') center center / cover no-repeat; border: 1px solid rgba(255,255,255,0.06);"></div>
        </div>
    </section>

    <!-- Product Catalog Grid -->
    <section class="aiero-creations" id="products-list"
        style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 7rem;">
        <div class="aiero-creations-container">
            <div class="aiero-creations-header">
                <span class="aiero-creations-tagline">CATALOG SELECTIONS</span>
                <h2 class="aiero-creations-title" style="font-size: 34px;">Bunk Bed Models</h2>
            </div>

            <div class="aiero-creations-grid">
                <!-- Card 1: Origami Bunk Bed -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=bunk6115" class="aiero-creation-card card-float-1"
                        style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/origami-bunk-bed-01.webp');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">ORIGAMI BUNK BED</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Bunk bed
                                inspired by paper planes and boats. Splits into two separate beds when kids outgrow.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Nature Bunk Bed -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=bunk6114" class="aiero-creation-card card-float-2"
                        style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/nature-bunk-bed-01.webp');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">NATURE BUNK BED</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Double-bunk
                                frame with customized clouds/mountains patterns and anti-slip steps.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 3: Bucharest Sofa Bunk -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=sofabunk6094" class="aiero-creation-card card-float-3"
                        style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/bucharest-sofa-bunk-01.webp');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">BUCHAREST SOFA BUNK</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Curvy metallic
                                double-agent design that converts seamlessly into a large sofa.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 4: Vladivostok Bunk Bed -->
                <div class="aiero-creation-card-wrapper">
                    <a href="product-details?id=bunk6095" class="aiero-creation-card card-float-1"
                        style="display: block; height: 380px;">
                        <div class="aiero-creation-img" style="background-image: url('assets/vladivostok-bunk-bed-01.webp');"></div>
                        <div class="aiero-creation-view-more">VIEW DETAILS</div>
                        <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                            <span class="aiero-creation-label" style="font-size: 1.15rem;">VLADIVOSTOK BUNK</span>
                            <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">Sleeps three
                                with super-strong structural reinforcement profiles. Perfect for hostels.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Download Catalogues Section -->
    <section class="aiero-about" style="padding: 4rem 8% 6rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div style="display: flex; justify-content: center;">
            <div class="aiero-about-content"
                style="justify-content: center; gap: 2rem; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); padding: 3rem; border-radius: 20px; text-align: center; align-items: center; max-width: 500px;">
                <i class="fa-solid fa-file-pdf"
                    style="font-size: 4rem; color: #ff3333; filter: drop-shadow(0 0 15px rgba(255,51,51,0.2));"></i>
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.8rem; color: var(--color-text);">Download
                    Catalogues</h3>
                <p style="opacity: 0.6; font-size: 0.92rem; line-height: 1.6; max-width: 320px;">Download our official
                    drafted PDF specification catalogs containing models, color selections, and dimension sizes.</p>

                <div style="display: flex; flex-direction: column; gap: 1.2rem; width: 100%; max-width: 340px;">
                    <a href="ksi/Bedroom.pdf" download class="aiero-btn-discover"
                        style="transform: none; opacity: 1; margin: 0 auto; width: 100%; justify-content: center; background: #FFC229; box-shadow: 0 10px 20px rgba(255, 194, 41, 0.25);">
                        <i class="fa-solid fa-download"></i> Bunk Beds Catalogue PDF
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php
include 'footer.php';
?>
