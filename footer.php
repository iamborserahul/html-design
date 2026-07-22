<?php
$footer_about = get_setting('footer_about_text') ?: '';
$footer_copyright = get_setting('footer_copyright_text') ?: '';
$site_email = get_setting('site_email') ?: '';
$site_phone = get_setting('site_phone') ?: '';
$site_phone2 = get_setting('site_phone_secondary') ?:'';
$site_address = get_setting('site_address') ?: '';
$site_name = get_setting('site_name') ?: 'Khodiyar Steel Industries';
$fb_url = get_setting('facebook_url') ?: '';
$ig_url = get_setting('instagram_url') ?: '';
$tw_url = get_setting('twitter_url') ?: '';
$yt_url = get_setting('youtube_url') ?: '';
$tk_url = get_setting('tiktok_url') ?: '';
$phone_digits = preg_replace('/\D/', '', $site_phone);
$phone2_digits = preg_replace('/\D/', '', $site_phone2);
?>
    <!-- Premium Styled & Unique Footer Section -->
    <footer class="aiero-footer" id="footer">
        <div class="aiero-footer-bg-text">KHODIYAR</div>
        <div class="aiero-footer-glow"></div>

        <div class="aiero-footer-container">
            <div class="aiero-footer-grid">

                <div class="aiero-footer-col">
                    <span class="aiero-footer-col-title">About <?= htmlspecialchars($site_name) ?></span>
                    <p class="aiero-footer-about-text"><?= htmlspecialchars($footer_about) ?></p>
                </div>

                <div class="aiero-footer-col">
                    <span class="aiero-footer-col-title">Explore</span>
                    <ul class="aiero-footer-links">
                        <li><a href="./" class="aiero-footer-link">Home</a></li>
                        <li><a href="about" class="aiero-footer-link">About Us</a></li>
                        <li><a href="products" class="aiero-footer-link">Products</a></li>
                        <li><a href="gallery" class="aiero-footer-link">Gallery</a></li>
                        <li><a href="./#services" class="aiero-footer-link">Services</a></li>
                        <li><a href="contact" class="aiero-footer-link">Contact</a></li>
                    </ul>
                </div>

                <div class="aiero-footer-col">
                    <span class="aiero-footer-col-title">Contact</span>
                    <div class="aiero-footer-contact-items">
                        <div class="aiero-footer-contact-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span><?= htmlspecialchars($site_address) ?></span>
                        </div>
                        <div class="aiero-footer-contact-item" style="display: flex; gap: 0.8rem; align-items: flex-start;">
                            <i class="fa-solid fa-phone" style="margin-top: 0.35rem;"></i>
                            <div style="display: flex; flex-direction: column; gap: 0.2rem;">
                                <a href="tel:<?= $phone_digits ?>"><?= htmlspecialchars($site_phone) ?></a>
                                <a href="tel:<?= $phone2_digits ?>" style="font-size: 0.85rem; opacity: 0.8;"><?= htmlspecialchars($site_phone2) ?></a>
                            </div>
                        </div>
                         <div class="aiero-footer-contact-item">
                            <i class="fa-solid fa-envelope"></i>
                            <a href="mailto:<?= htmlspecialchars($site_email) ?>"><?= htmlspecialchars($site_email) ?></a>
                        </div>
                    </div>
                    <?php if(!empty($ig_url) || !empty($tw_url) || !empty($yt_url) || !empty($fb_url) || !empty($tk_url)){ ?>
                    <div class="aiero-footer-socials">
                        <?php if(!empty($ig_url)){ ?>
                        <a href="<?= htmlspecialchars($ig_url) ?>" class="aiero-footer-social-btn" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <?php } ?>
                        <?php if(!empty($tw_url)){ ?>
                        <a href="<?= htmlspecialchars($tw_url) ?>" class="aiero-footer-social-btn" aria-label="Twitter X"><i class="fa-brands fa-twitter"></i></a>
                        <?php } ?>
                        <?php if(!empty($yt_url)){ ?>
                        <a href="<?= htmlspecialchars($yt_url) ?>" class="aiero-footer-social-btn" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <?php } ?>
                        <?php if(!empty($fb_url)){ ?>
                        <a href="<?= htmlspecialchars($fb_url) ?>" class="aiero-footer-social-btn" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <?php } ?>
                        <?php if(!empty($tk_url)){ ?>
                        <a href="<?= htmlspecialchars($tk_url) ?>" class="aiero-footer-social-btn" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                        <?php } ?>
                    </div>
                    <?php } ?>

                </div>

            </div>

            <div class="aiero-footer-line"></div>

            <div class="aiero-footer-bottom">
                <span class="aiero-footer-copy"><?= htmlspecialchars($footer_copyright) ?> | Powered By <a href="https://s2rash-technology.vercel.app/" target="_blank" rel="noopener" style="color: var(--color-primary-light); text-decoration: none; font-weight: 600;">S2Rash Technology</a></span>
                <button class="aiero-back-to-top" aria-label="Back to top" title="Back to Top">
                    <i class="fa-solid fa-arrow-up"></i>
                </button>
            </div>
            <div class="aiero-geom-shape shape-dark-node"></div>

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.19/bundled/lenis.min.js"></script>
    <script src="script.js?v=1.5"></script>
</body>

</html>
