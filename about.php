<?php
$title = "About Us | Khodiyar Steel – Manufacturing Excellence Since 1998";
$description = "Read the story, journey, mission, and certifications of Khodiyar Steel, Surat's premier high-end steel furniture manufacturer.";
$page = "about";
include 'header.php';
?>

<!-- Subpage Hero Section with Parallax Background -->
    <section class="aiero-hero subpage-hero about-parallax-hero"
        style="height: 100vh; min-height: 500px; display: flex; align-items: center; justify-content: center; text-align: center; position: relative; overflow: hidden; background: url('assets/about-us-bg.png') center center / cover no-repeat fixed;">
        <!-- Dark Gradient Overlay -->
        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.4) 50%, rgba(10,10,10,0.8) 100%); z-index: 1;"></div>
        <!-- Subtle animated grain texture -->
        <div style="position: absolute; inset: 0; background: radial-gradient(ellipse at 30% 20%, rgba(255,194,41,0.08) 0%, transparent 60%); z-index: 2; pointer-events: none;"></div>
        <div class="aiero-slide-content"
            style="position: relative; z-index: 3; margin: 0; padding: 0 4%; max-width: 1000px; text-align: center; align-items: center;">
            <span class="aiero-slide-tagline" style="color: #FFC229; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">ESTABLISHED 1998</span>
            <h1 class="aiero-slide-title" style="transform: none; opacity: 1; color: #fff; text-shadow: 0 2px 15px rgba(0,0,0,0.6);">Our Story & Legacy</h1>
            <p class="aiero-slide-desc" style="transform: none; opacity: 1; max-width: 700px; margin: 0 auto; color: rgba(255,255,255,0.9); text-shadow: 0 1px 8px rgba(0,0,0,0.5);">Discover
                the values, precision engineering, and structural dedication that have fueled India’s leading
                metal manufacturer for over two decades.</p>
        </div>
    </section>

    <!-- Pinned Storytelling Section (Adapted from Landing Style) -->
    <section class="aiero-about" id="story" style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 6rem;">
        <div class="aiero-about-container" style="display: flex; flex-direction: column; gap: 4rem;">
            <div class="aiero-about-content" style="max-width: 1000px; margin: 0 auto; width: 100%;">
                <span class="aiero-about-tagline" style="color: #FFC229;">COMPANY HISTORY</span>
                <h2 class="aiero-about-title" style="font-size: 38px;">About Khodiyar<br>Steel Industries</h2>
                <div class="aiero-about-desc" style="font-size: 1.02rem; line-height: 1.8;">
                    <p>Founded in 1998 by Vimalbhai Sakariya, Khodiyar Steel Industries began with a clear vision: to
                        manufacture durable, high-quality steel furniture that customers could trust.</p>
                    <p>What started as a small manufacturing operation serving the Indian market has grown into an
                        established metal furniture manufacturer with more than 25 years of industry experience. In the
                        early years, we focused on producing steel cupboards, metal beds, and other household furniture,
                        earning a reputation for quality workmanship, durability, and customer satisfaction.</p>
                    <p>As our capabilities expanded, so did our reach. In the early 2010s, Khodiyar Steel Industries
                        entered international markets and began exporting to customers across the United States, Canada, UAE, Saudi Arabia, and other global regions. This expansion strengthened our manufacturing processes and reinforced
                        our commitment to delivering products that meet international expectations for quality and
                        reliability.</p>
                    <p>Today, Khodiyar Steel Industries is a trusted manufacturing partner for distributors, importers,
                        retailers, institutions, and project buyers. We currently manufacture 6,000–8,000 metal beds per
                        month, with production capacity of up to 20,000 beds per month through our expanded facilities.
                    </p>
                    <p
                        style="font-style: italic; color: #FFC229; font-weight: 600; border-left: 2px solid #FFC229; padding-left: 1rem; margin-top: 1.5rem;">
                        "Our success has been built on a simple philosophy: Quality products create lasting
                        relationships."</p>
                    <p>This belief is reflected in the long-term partnerships we have developed over the years. Many of
                        our customers continue to return to us because they know they can depend on our quality,
                        consistency, and commitment to service.</p>
                </div>
            </div>
            <!-- Founders & Team Row (Single Row) -->
            <div class="aiero-about-img-wrapper animate-img-right"
                style="display: flex; gap: 2rem; justify-content: center; align-items: stretch; width: 100%; flex-wrap: wrap; margin-top: 2rem;">

                <!-- Founder Card -->
                <div class="aiero-founder-card text-center" style="flex: 1; min-width: 280px; max-width: 360px; padding: 2.2rem 1.5rem;">
                    <div class="aiero-founder-img-wrapper aiero-founder-img-wrapper--square" style="width: 140px; height: 140px; margin-bottom: 1.5rem;">
                        <img src="assets/ceo.png" alt="Vimal Sakariya - Founder & MD of Khodiyar Steel"
                            class="aiero-founder-img aiero-founder-img--square">
                    </div>
                    <div class="aiero-founder-details">
                        <span class="aiero-founder-tag">FOUNDER &amp; MD</span>
                        <h3 class="aiero-founder-name" style="font-size: 1.2rem;">Mr. Vimalbhai Sakariya</h3>
                        <p class="aiero-founder-quote" style="font-size: 0.85rem;">"Manufacturing Quality. Building Trust. Since 1998."</p>
                    </div>
                </div>

                <!-- CEO Card -->
                <div class="aiero-founder-card text-center" style="flex: 1; min-width: 280px; max-width: 360px; padding: 2.2rem 1.5rem;">
                    <div class="aiero-founder-img-wrapper aiero-founder-img-wrapper--square" style="width: 140px; height: 140px; margin-bottom: 1.5rem;">
                        <img src="assets/manthan-sakariya-ceo.png" alt="CEO of Khodiyar Steel" class="aiero-founder-img aiero-founder-img--square">
                    </div>
                    <div class="aiero-founder-details">
                        <span class="aiero-founder-tag">CEO</span>
                        <h3 class="aiero-founder-name" style="font-size: 1.2rem;">Mr. Manthan Sakariya</h3>
                        <p class="aiero-founder-quote" style="font-size: 0.85rem;">"Technology drives our precision."</p>
                    </div>
                </div>

                <!-- COO Card -->
                <div class="aiero-founder-card text-center" style="flex: 1; min-width: 280px; max-width: 360px; padding: 2.2rem 1.5rem;">
                    <div class="aiero-founder-img-wrapper aiero-founder-img-wrapper--square" style="width: 140px; height: 140px; margin-bottom: 1.5rem;">
                        <img src="assets/nayan-patel-coo.png" alt="COO of Khodiyar Steel" class="aiero-founder-img aiero-founder-img--square">
                    </div>
                    <div class="aiero-founder-details">
                        <span class="aiero-founder-tag">COO</span>
                        <h3 class="aiero-founder-name" style="font-size: 1.2rem;">Mr. Nayan Patel</h3>
                        <p class="aiero-founder-quote" style="font-size: 0.85rem;">"Excellence in every operation."</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Mission, Vision & Journey Block -->
    <section class="aiero-creations" id="mission"
        style="padding: 6rem 8% 4rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="aiero-creations-container">
            <div class="aiero-creations-header" style="text-align: center; align-items: center; margin-bottom: 3.5rem;">
                <span class="aiero-creations-tagline">GUIDING VALUES</span>
                <h2 class="aiero-creations-title" style="font-size: 36px; text-align: center;">Mission, Vision & Values
                </h2>
            </div>

            <div class="aiero-creations-grid">
                <!-- Card 1: Mission -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-1" style="height: 380px;">
                        <div class="aiero-creation-content"
                            style="position: relative; padding: 2.5rem; background: none; justify-content: center; height: 100%;">
                            <i class="fa-solid fa-bullseye"
                                style="font-size: 2.5rem; color: #FFC229; margin-bottom: 1rem;"></i>
                            <span class="aiero-creation-label" style="font-size: 1.3rem;">Our Mission</span>
                            <p class="aiero-creation-desc"
                                style="font-size: 0.9rem; line-height: 1.7; margin-top: 0.5rem;">To provide durable,
                                affordable, and high-quality metal furniture products while building long-term
                                partnerships based on trust, integrity, and customer satisfaction.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Vision -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-2" style="height: 380px;">
                        <div class="aiero-creation-content"
                            style="position: relative; padding: 2.5rem; background: none; justify-content: center; height: 100%;">
                            <i class="fa-solid fa-eye"
                                style="font-size: 2.5rem; color: #FFC229; margin-bottom: 1rem;"></i>
                            <span class="aiero-creation-label" style="font-size: 1.3rem;">Our Vision</span>
                            <p class="aiero-creation-desc"
                                style="font-size: 0.9rem; line-height: 1.7; margin-top: 0.5rem;">To become a globally
                                recognized manufacturer of metal furniture by delivering exceptional quality, dependable
                                service, and innovative manufacturing solutions to customers worldwide.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Core Values -->
                <div class="aiero-creation-card-wrapper">
                    <div class="aiero-creation-card card-float-3" style="height: 380px;">
                        <div class="aiero-creation-content"
                            style="position: relative; padding: 2.5rem; background: none; justify-content: center; height: 100%;">
                            <i class="fa-solid fa-handshake"
                                style="font-size: 2.5rem; color: #FFC229; margin-bottom: 1rem;"></i>
                            <span class="aiero-creation-label" style="font-size: 1.3rem;">What We Stand For</span>
                            <ul class="aiero-creation-desc"
                                style="font-size: 0.85rem; line-height: 1.6; margin-top: 0.5rem; list-style-type: none; text-align: left; padding: 0; display: flex; flex-direction: column; gap: 0.4rem;">
                                <li><i class="fa-solid fa-check" style="color: #FFC229; margin-right: 0.5rem;"></i>
                                    Quality without compromise</li>
                                <li><i class="fa-solid fa-check" style="color: #FFC229; margin-right: 0.5rem;"></i>
                                    Reliable and scalable manufacturing</li>
                                <li><i class="fa-solid fa-check" style="color: #FFC229; margin-right: 0.5rem;"></i>
                                    Long-term customer relationships</li>
                                <li><i class="fa-solid fa-check" style="color: #FFC229; margin-right: 0.5rem;"></i>
                                    Continuous improvement & innovation</li>
                                <li><i class="fa-solid fa-check" style="color: #FFC229; margin-right: 0.5rem;"></i>
                                    Ethical business practices</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Milestone Journey Timeline -->
    <section class="aiero-faq-section" id="journey-timeline"
        style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 5rem;">
        <div style="max-width: 1000px; margin: 0 auto;">
            <div style="text-align: center; display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2.5rem;">
                <span class="aiero-creations-tagline">HISTORICAL MILESTONES</span>
                <h2 class="aiero-creations-title" style="font-size: 36px; text-align: center;">Our Entire Journey</h2>
            </div>

            <div class="aiero-journey-timeline">
                <!-- Milestone 1 -->
                <div class="aiero-timeline-node">
                    <div class="aiero-timeline-dot"></div>
                    <div class="aiero-timeline-card">
                        <div class="aiero-timeline-year">1998</div>
                        <h4 class="aiero-timeline-title">Foundation & Core Vision</h4>
                        <p class="aiero-timeline-desc">Founded by Vimal Sakariya with a clear vision: to manufacture
                            durable, high-quality steel furniture that customers could trust, serving the Indian market.
                        </p>
                    </div>
                </div>

                <!-- Milestone 2 -->
                <div class="aiero-timeline-node">
                    <div class="aiero-timeline-dot"></div>
                    <div class="aiero-timeline-card">
                        <div class="aiero-timeline-year">2005</div>
                        <h4 class="aiero-timeline-title">Earning Reputation</h4>
                        <p class="aiero-timeline-desc">Focused on producing high-durability steel cupboards, metal beds,
                            and household furniture, earning a strong reputation for quality workmanship and customer
                            satisfaction.</p>
                    </div>
                </div>

                <!-- Milestone 3 -->
                <div class="aiero-timeline-node">
                    <div class="aiero-timeline-dot"></div>
                    <div class="aiero-timeline-card">
                        <div class="aiero-timeline-year">2012</div>
                        <h4 class="aiero-timeline-title">Global Market Expansion</h4>
                        <p class="aiero-timeline-desc">Entered international markets and began exporting products to
                            buyers across the United States, Canada, UAE, Saudi Arabia, and other global regions, solidifying international
                            expectations.</p>
                    </div>
                </div>

                <!-- Milestone 4 -->
                <div class="aiero-timeline-node">
                    <div class="aiero-timeline-dot"></div>
                    <div class="aiero-timeline-card">
                        <div class="aiero-timeline-year">2018</div>
                        <h4 class="aiero-timeline-title">CNC Precision & Advanced Capacity</h4>
                        <p class="aiero-timeline-desc">Upgraded our facility with CNC bending and powder-coating
                            technologies, aligning our capabilities with scalable manufacturing requirements.</p>
                    </div>
                </div>

                <!-- Milestone 5 -->
                <div class="aiero-timeline-node">
                    <div class="aiero-timeline-dot"></div>
                    <div class="aiero-timeline-card">
                        <div class="aiero-timeline-year">2024</div>
                        <h4 class="aiero-timeline-title">Expanded Capacity (10k/Month)</h4>
                        <p class="aiero-timeline-desc">Reached a manufacturing capacity of 6,000–8,000 metal beds per
                            month, with full capabilities scaling up to 20,000 beds per month to serve distributors and
                            project buyers.</p>
                    </div>
                </div>

                <!-- Milestone 6 -->
                <div class="aiero-timeline-node aiero-timeline-node--active">
                    <div class="aiero-timeline-dot aiero-timeline-dot--active"></div>
                    <div class="aiero-timeline-card aiero-timeline-card--active">
                        <div class="aiero-timeline-year" style="color: #FFC229;">2026</div>
                        <h4 class="aiero-timeline-title">Digital Transformation &amp; New Verticals</h4>
                        <p class="aiero-timeline-desc">Launched a full digital product catalogue and strengthened our
                            online presence to connect directly with global buyers. Expanded our product range into
                            premium hospital furniture, outdoor gazebos, and bespoke steel furniture — positioning
                            Khodiyar Steel for the next decade of growth.</p>
                        <span style="display: inline-block; margin-top: 0.8rem; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.2em; color: #FFC229; text-transform: uppercase; background: rgba(255,194,41,0.1); border: 1px solid rgba(255,194,41,0.3); padding: 0.3rem 0.9rem; border-radius: 50px;"><i class="fa-solid fa-circle" style="font-size: 0.5rem; vertical-align: middle; margin-right: 0.4rem; animation: pulse-gold 1.5s infinite;"></i> Present Day</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us & Certifications -->
    <section class="aiero-about" id="why-us" style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding: 6rem 8%;">
        <div class="aiero-about-container" style="grid-template-columns: 1fr 1fr; gap: 5rem;">
            <div class="aiero-about-content">
                <span class="aiero-about-tagline" style="color: #FFC229;">WHY CHOOSE US</span>
                <h2 class="aiero-about-title" style="font-size: 38px;">High-Precision Engineering</h2>
                <div class="aiero-about-desc" style="font-size: 1rem; line-height: 1.8;">
                    <p>Choosing Khodiyar Steel means choosing a product built to outlast generations. Here is why we are
                        trusted across industries:</p>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                        <li style="display: flex; gap: 1rem; align-items: flex-start;">
                            <i class="fa-solid fa-circle-check" style="color: #FFC229; margin-top: 0.3rem;"></i>
                            <span><strong>Premium Structural Raw Materials</strong>: We utilize highest-grade structural
                                steel, rust-resistant treatments, and powder finishes.</span>
                        </li>
                        <li style="display: flex; gap: 1rem; align-items: flex-start;">
                            <i class="fa-solid fa-circle-check" style="color: #FFC229; margin-top: 0.3rem;"></i>
                            <span><strong>Certified Manufacturing Standards</strong>: Advanced quality control protocols
                                ensure each cabinet and bedframe meets load-bearing limits.</span>
                        </li>
                        <li style="display: flex; gap: 1rem; align-items: flex-start;">
                            <i class="fa-solid fa-circle-check" style="color: #FFC229; margin-top: 0.3rem;"></i>
                            <span><strong>Custom Architectural Outlines</strong>: We manufacture outdoor gazebos and recliners in
                                bespoke dimensional ratios for real estate developers.</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="aiero-about-content" style="justify-content: center; gap: 2rem;">
                <span class="aiero-about-tagline" style="color: #FFC229;">CERTIFICATIONS & TRUST</span>
                <h2 class="aiero-about-title" style="font-size: 38px;">Certified Quality</h2>
                <p style="opacity: 0.7; font-size: 1rem; line-height: 1.8;">Our manufacturing process adheres to strict
                    national standards. We hold standard industrial clearances for high-durability production, welding
                    certifications, and architectural structural manufacturing criteria, making our wardrobes,
                    hospital equipment, and outdoor gazebos highly reliable.</p>
                <div style="display: flex; gap: 2rem; align-items: center; margin-top: 1rem; flex-wrap: wrap;">
                    <div
                        style="display: flex; flex-direction: column; align-items: center; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); padding: 1.5rem 2rem; border-radius: 12px; width: 140px; text-align: center;">
                        <span
                            style="font-size: 2.2rem; font-weight: 800; color: #FFC229; font-family: 'Cinzel', serif;">ISO</span>
                        <span
                            style="font-size: 0.7rem; letter-spacing: 0.1em; opacity: 0.6; margin-top: 0.3rem;">COMPLIANT</span>
                    </div>
                    <div
                        style="display: flex; flex-direction: column; align-items: center; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); padding: 1.5rem 2rem; border-radius: 12px; width: 140px; text-align: center;">
                        <span
                            style="font-size: 2.2rem; font-weight: 800; color: #FFC229; font-family: 'Cinzel', serif;">25+</span>
                        <span style="font-size: 0.7rem; letter-spacing: 0.1em; opacity: 0.6; margin-top: 0.3rem;">YEARS
                            EXP</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

<?php
include 'footer.php';
?>
