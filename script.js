document.addEventListener('DOMContentLoaded', () => {

    // 1. Cursor Follow
    const cursorDot = document.querySelector('.cursor-dot');
    const cursorRing = document.querySelector('.cursor-ring');
    document.addEventListener('mousemove', (e) => {
        gsap.to(cursorDot, { x: e.clientX, y: e.clientY, duration: 0.05 });
        gsap.to(cursorRing, { x: e.clientX, y: e.clientY, duration: 0.18 });
    });

    // Hover updates
    const hoverables = document.querySelectorAll('a, button, .aiero-nav-dot, .aiero-video-thumbnail, .aiero-tab-icon');
    hoverables.forEach(el => {
        el.addEventListener('mouseenter', () => {
            gsap.to(cursorRing, { width: 55, height: 55, borderColor: '#00a0ff', backgroundColor: 'rgba(0, 160, 255, 0.08)' });
        });
        el.addEventListener('mouseleave', () => {
            gsap.to(cursorRing, { width: 40, height: 40, borderColor: 'var(--color-primary)', backgroundColor: 'transparent' });
        });
    });

    // 2. Spotlight tracking mouse
    const spotlight = document.querySelector('.aiero-spotlight');
    document.addEventListener('mousemove', (e) => {
        gsap.to(spotlight, { x: e.clientX, y: e.clientY, duration: 0.3 });
    });

    // 3. 2D Full-Width GSAP Slider Logic
    const slides = document.querySelectorAll('.aiero-slide-2d');
    const dots = document.querySelectorAll('.aiero-nav-dot');
    const progressBar = document.querySelector('.aiero-progress-bar');
    let currentIndex = 0;
    const slideDuration = 6000; // 6 seconds auto progress
    let progressTween = null;
    let isAnimating = false;

    // Pre-set all non-active slides to scale 1.15 and invisible
    slides.forEach((slide, idx) => {
        if (idx !== 0) {
            gsap.set(slide, { opacity: 0, visibility: 'hidden' });
            gsap.set(slide.querySelector('.aiero-slide-img'), { scale: 1.15 });
        } else {
            gsap.set(slide, { opacity: 1, visibility: 'visible' });
            gsap.set(slide.querySelector('.aiero-slide-img'), { scale: 1 });
        }
    });

    // On initial load, animate first slide content
    gsap.fromTo(slides[0].querySelectorAll('.aiero-slide-title, .aiero-slide-desc, .aiero-btn-discover, .aiero-video-card'), {
        y: 60,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 1,
        stagger: 0.08,
        ease: 'power3.out',
        delay: 0.3
    });

    function goToSlide(index) {
        if (index === currentIndex || isAnimating) return;
        isAnimating = true;

        // Stop progress timeline immediately
        if (progressTween) progressTween.kill();
        gsap.set(progressBar, { width: '0%' });

        const activeSlide = slides[currentIndex];
        const nextSlide = slides[index];
        currentIndex = index;

        // Update navigation dots active indicators
        dots.forEach((dot, idx) => {
            dot.classList.toggle('active', idx === index);
        });

        const tl = gsap.timeline({
            onComplete: () => {
                activeSlide.classList.remove('active');
                gsap.set(activeSlide, { visibility: 'hidden', opacity: 0 });
                nextSlide.classList.add('active');
                isAnimating = false;
                startProgressBar(); // Restart progress bar only after animation finishes
            }
        });

        // 1. Outgoing slide animations
        tl.to(activeSlide.querySelectorAll('.aiero-slide-title, .aiero-slide-desc, .aiero-btn-discover, .aiero-video-card'), {
            y: -40,
            opacity: 0,
            duration: 0.5,
            stagger: 0.05,
            ease: 'power3.in'
        });

        // Zoom out active background slightly as it fades
        tl.to(activeSlide.querySelector('.aiero-slide-img'), {
            scale: 0.95,
            duration: 0.8,
            ease: 'power2.inOut'
        }, "-=0.3");

        // Crossfade slides
        tl.set(nextSlide, { visibility: 'visible', opacity: 0 }, "-=0.2");

        tl.to(activeSlide, {
            opacity: 0,
            duration: 0.8,
            ease: 'power2.inOut'
        }, "-=0.8");

        tl.to(nextSlide, {
            opacity: 1,
            duration: 0.8,
            ease: 'power2.inOut'
        }, "-=0.8");

        // Zoom in incoming background
        const nextImg = nextSlide.querySelector('.aiero-slide-img');
        tl.fromTo(nextImg, {
            scale: 1.15
        }, {
            scale: 1,
            duration: 1.4,
            ease: 'power2.out'
        }, "-=0.8");

        // 2. Incoming content animations
        tl.fromTo(nextSlide.querySelectorAll('.aiero-slide-title, .aiero-slide-desc, .aiero-btn-discover, .aiero-video-card'), {
            y: 60,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            stagger: 0.08,
            ease: 'power3.out'
        }, "-=0.8");
    }

    // Progress timeline animations
    function startProgressBar() {
        gsap.set(progressBar, { width: '0%' });
        progressTween = gsap.to(progressBar, {
            width: '100%',
            duration: slideDuration / 1000,
            ease: 'none',
            onComplete: () => {
                const nextIdx = (currentIndex + 1) % slides.length;
                goToSlide(nextIdx);
            }
        });
    }

    // Bind click events to navigation dots
    dots.forEach((dot, idx) => {
        dot.addEventListener('click', () => {
            goToSlide(idx);
        });
    });

    // Bind click events to navigation arrows
    const prevArrow = document.querySelector('.aiero-arrow.btn-prev');
    const nextArrow = document.querySelector('.aiero-arrow.btn-next');

    prevArrow.addEventListener('click', () => {
        const prevIdx = (currentIndex - 1 + slides.length) % slides.length;
        goToSlide(prevIdx);
    });

    nextArrow.addEventListener('click', () => {
        const nextIdx = (currentIndex + 1) % slides.length;
        goToSlide(nextIdx);
    });

    // Start first slide progression
    startProgressBar();

    // 4. Custom Dark/Light theme toggle matching capsule button in screenshot
    const themeBtn = document.querySelector('.aiero-theme-btn');
    themeBtn.addEventListener('click', () => {
        const body = document.body;
        if (body.classList.contains('aiero-theme')) {
            body.classList.remove('aiero-theme');
            body.style.background = '#f4f5f8';
            body.style.color = '#03030b';
            document.querySelector('.aiero-logo').style.color = '#03030b';
            themeBtn.innerHTML = '<i class="fa-solid fa-sun"></i>';
            themeBtn.style.background = '#00a0ff';
            themeBtn.style.color = '#fff';

            // Dark theme overlays
            document.querySelectorAll('.aiero-slide-title').forEach(el => el.style.color = '#03030b');
            document.querySelectorAll('.aiero-slide-desc').forEach(el => el.style.color = '#555566');
            document.querySelector('.aiero-nav').style.background = 'rgba(240, 240, 248, 0.7)';
            document.querySelector('.aiero-nav').style.borderColor = 'rgba(0, 0, 0, 0.08)';
            document.querySelectorAll('.aiero-menu-link').forEach(el => el.style.color = '#555566');

            // About section overrides
            document.querySelectorAll('.aiero-about-title').forEach(el => el.style.color = '#03030b');
            document.querySelectorAll('.aiero-about-desc p').forEach(el => el.style.color = '#555566');
            document.querySelectorAll('.aiero-phone-label').forEach(el => el.style.color = 'rgba(0, 0, 0, 0.5)');

            // Creations section overrides
            document.querySelectorAll('.aiero-creations-title').forEach(el => el.style.color = '#03030b');
            document.querySelectorAll('.aiero-creation-desc').forEach(el => el.style.color = '#555566');
            document.querySelectorAll('.aiero-creation-view-more').forEach(el => {
                el.style.color = '#03030b';
                el.style.borderColor = 'rgba(3, 3, 11, 0.4)';
                el.style.background = 'rgba(255, 255, 255, 0.8)';
            });

            // Footer overrides
            document.querySelectorAll('.aiero-footer').forEach(el => el.style.background = '#f4f5f8');
            document.querySelectorAll('.aiero-footer-col-title').forEach(el => el.style.color = '#03030b');
            document.querySelectorAll('.aiero-footer-about-text, .aiero-footer-link, .aiero-footer-contact-item').forEach(el => el.style.color = '#555566');
            document.querySelectorAll('.aiero-footer-copy').forEach(el => el.style.color = 'rgba(3, 3, 11, 0.5)');
        } else {
            body.classList.add('aiero-theme');
            body.style.background = '#03030b';
            body.style.color = '#fff';
            document.querySelector('.aiero-logo').style.color = '#fff';
            themeBtn.innerHTML = '<i class="fa-solid fa-moon"></i>';
            themeBtn.style.background = '#03030b';
            themeBtn.style.color = '#fff';

            // Light theme overlays
            document.querySelectorAll('.aiero-slide-title').forEach(el => el.style.color = '#fff');
            document.querySelectorAll('.aiero-slide-desc').forEach(el => el.style.color = 'rgba(255, 255, 255, 0.6)');
            document.querySelector('.aiero-nav').style.background = 'rgba(10, 10, 25, 0.35)';
            document.querySelector('.aiero-nav').style.borderColor = 'rgba(255, 255, 255, 0.08)';
            document.querySelectorAll('.aiero-menu-link').forEach(el => el.style.color = 'rgba(255, 255, 255, 0.8)');

            // About section overrides
            document.querySelectorAll('.aiero-about-title').forEach(el => el.style.color = '#fff');
            document.querySelectorAll('.aiero-about-desc p').forEach(el => el.style.color = 'rgba(255, 255, 255, 0.6)');
            document.querySelectorAll('.aiero-phone-label').forEach(el => el.style.color = 'rgba(255, 255, 255, 0.4)');

            // Creations section overrides
            document.querySelectorAll('.aiero-creations-title').forEach(el => el.style.color = '#fff');
            document.querySelectorAll('.aiero-creation-desc').forEach(el => el.style.color = 'rgba(255, 255, 255, 0.5)');
            document.querySelectorAll('.aiero-creation-view-more').forEach(el => {
                el.style.color = '#fff';
                el.style.borderColor = 'rgba(255, 255, 255, 0.35)';
                el.style.background = 'rgba(10, 10, 25, 0.25)';
            });

            // Footer overrides
            document.querySelectorAll('.aiero-footer').forEach(el => el.style.background = 'rgba(3, 3, 11, 0.95)');
            document.querySelectorAll('.aiero-footer-col-title').forEach(el => el.style.color = '#fff');
            document.querySelectorAll('.aiero-footer-about-text, .aiero-footer-contact-item').forEach(el => el.style.color = 'rgba(255, 255, 255, 0.5)');
            document.querySelectorAll('.aiero-footer-link').forEach(el => el.style.color = 'rgba(255, 255, 255, 0.6)');
            document.querySelectorAll('.aiero-footer-copy').forEach(el => el.style.color = 'rgba(255, 255, 255, 0.4)');
        }
    });

    // 5. Fullscreen Toggle
    const compressIcon = document.querySelector('.fa-compress');
    compressIcon.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            compressIcon.className = 'fa-solid fa-expand aiero-tab-icon';
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
                compressIcon.className = 'fa-solid fa-compress aiero-tab-icon';
            }
        }
    });

    // 6. About Us Dynamic Word Split & ScrollTrigger Animation Setup
    gsap.registerPlugin(ScrollTrigger);

    const aboutTitle = document.querySelector('.aiero-about-title');
    if (aboutTitle) {
        const lines = aboutTitle.innerHTML.split(/<br\s*\/?>/i);
        aboutTitle.innerHTML = lines.map(line => {
            const words = line.trim().split(/\s+/);
            const lineContent = words.map(word => {
                return `<span class="reveal-wrapper"><span class="reveal-inner">${word}</span></span>`;
            }).join(' ');
            return `<div class="reveal-line-box">${lineContent}</div>`;
        }).join('');
    }

    const aboutTl = gsap.timeline({
        scrollTrigger: {
            trigger: '.aiero-about',
            start: 'top 75%',
            toggleActions: 'play none none none'
        }
    });

    // Stars stagger scale & reveal
    aboutTl.fromTo('.aiero-about-stars i', {
        opacity: 0,
        scale: 0.4
    }, {
        opacity: 1,
        scale: 1,
        duration: 0.55,
        stagger: 0.07,
        ease: 'back.out(1.7)'
    });

    // Subtitle tagline reveal
    aboutTl.fromTo('.aiero-about-tagline', {
        opacity: 0,
        x: -25
    }, {
        opacity: 1,
        x: 0,
        duration: 0.7,
        ease: 'power3.out'
    }, "-=0.35");

    // Title character reveal
    aboutTl.to('.aiero-about-title .reveal-inner', {
        y: '0%',
        duration: 0.85,
        stagger: 0.05,
        ease: 'power3.out'
    }, "-=0.6");

    // Description stagger reveal
    aboutTl.fromTo('.aiero-about-desc p', {
        opacity: 0,
        y: 35
    }, {
        opacity: 1,
        y: 0,
        duration: 0.8,
        stagger: 0.12,
        ease: 'power3.out'
    }, "-=0.65");

    // Booking phone block reveal
    aboutTl.fromTo('.aiero-about-phone', {
        opacity: 0,
        y: 30
    }, {
        opacity: 1,
        y: 0,
        duration: 0.8,
        ease: 'power3.out'
    }, "-=0.65");

    // Left staggered image card reveal
    aboutTl.fromTo('.animate-img-left', {
        opacity: 0,
        y: 80,
        scale: 0.95
    }, {
        opacity: 1,
        y: 0,
        scale: 1,
        duration: 1.1,
        ease: 'power4.out'
    }, "-=0.95");

    // Right shifted image card reveal
    aboutTl.fromTo('.animate-img-right', {
        opacity: 0,
        y: 130,
        scale: 0.95
    }, {
        opacity: 1,
        y: 0,
        scale: 1,
        duration: 1.3,
        ease: 'power4.out'
    }, "-=1.05");

    // Image dynamic scale down
    aboutTl.to('.aiero-about-img-box img', {
        scale: 1,
        duration: 1.6,
        ease: 'power2.out'
    }, "-=1.1");

    // 7. Creations Dynamic Word Split & ScrollTrigger Animation Setup
    const creationsTitle = document.querySelector('.aiero-creations-title');
    if (creationsTitle) {
        const lines = creationsTitle.innerHTML.split(/<br\s*\/?>/i);
        creationsTitle.innerHTML = lines.map(line => {
            const words = line.trim().split(/\s+/);
            const lineContent = words.map(word => {
                return `<span class="reveal-wrapper"><span class="reveal-inner">${word}</span></span>`;
            }).join(' ');
            return `<div class="reveal-line-box">${lineContent}</div>`;
        }).join('');
    }

    const creationsTl = gsap.timeline({
        scrollTrigger: {
            trigger: '.aiero-creations',
            start: 'top 75%',
            toggleActions: 'play none none none'
        }
    });

    // Tagline reveal
    creationsTl.fromTo('.aiero-creations-tagline', {
        opacity: 0,
        x: -25
    }, {
        opacity: 1,
        x: 0,
        duration: 0.7,
        ease: 'power3.out'
    });

    // Title word reveal
    creationsTl.to('.aiero-creations-title .reveal-inner', {
        y: '0%',
        duration: 0.85,
        stagger: 0.05,
        ease: 'power3.out'
    }, "-=0.5");

    // Grid cards stagger reveal
    creationsTl.fromTo('.aiero-creation-card', {
        opacity: 0,
        y: 60,
        scale: 0.95
    }, {
        opacity: 1,
        y: 0,
        scale: 1,
        duration: 1,
        stagger: 0.12,
        ease: 'power3.out'
    }, "-=0.6");

    // 8. Back to Top smooth scroll
    const backToTopBtn = document.querySelector('.aiero-back-to-top');
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // 9. Footer ScrollTrigger Animation
    const footerTl = gsap.timeline({
        scrollTrigger: {
            trigger: '.aiero-footer',
            start: 'top 85%',
            toggleActions: 'play none none none'
        }
    });

    // Background outline text reveal
    footerTl.fromTo('.aiero-footer-bg-text', {
        opacity: 0,
        y: 40
    }, {
        opacity: 1,
        y: 0,
        duration: 1.2,
        ease: 'power3.out'
    });

    // Footer columns stagger slide in
    footerTl.fromTo('.aiero-footer-col', {
        opacity: 0,
        y: 45
    }, {
        opacity: 1,
        y: 0,
        duration: 0.85,
        stagger: 0.12,
        ease: 'power3.out'
    }, "-=0.9");

    // Footer lines scale-X
    footerTl.fromTo('.aiero-footer-line', {
        scaleX: 0
    }, {
        scaleX: 1,
        duration: 0.95,
        ease: 'power2.inOut'
    }, "-=0.5");

    // Footer bottom bar elements
    footerTl.fromTo('.aiero-footer-bottom', {
        opacity: 0,
        y: 15
    }, {
        opacity: 1,
        y: 0,
        duration: 0.75,
        ease: 'power3.out'
    }, "-=0.55");

    // ==========================================
    // AIERO EXTRA SERVICES SLIDER & ANIMATIONS
    // ==========================================

    // 1. Text Wrap & Reveal Animation
    const servicesTitle = document.querySelector('.aiero-services-title');
    if (servicesTitle) {
        const words = servicesTitle.innerText.trim().split(/\s+/);
        servicesTitle.innerHTML = words.map(word => {
            return `<span class="reveal-wrapper"><span class="reveal-inner">${word}</span></span>`;
        }).join(' ');
    }

    const servicesTl = gsap.timeline({
        scrollTrigger: {
            trigger: '.aiero-services-section',
            start: 'top 75%',
            toggleActions: 'play none none none'
        }
    });

    servicesTl.fromTo('.aiero-services-subtitle', {
        opacity: 0,
        x: -25
    }, {
        opacity: 1,
        x: 0,
        duration: 0.7,
        ease: 'power3.out'
    });

    servicesTl.to('.aiero-services-title .reveal-inner', {
        y: '0%',
        duration: 0.85,
        stagger: 0.06,
        ease: 'power3.out'
    }, "-=0.5");

    servicesTl.fromTo('.aiero-services-desc p', {
        opacity: 0,
        y: 30
    }, {
        opacity: 1,
        y: 0,
        duration: 0.8,
        stagger: 0.12,
        ease: 'power3.out'
    }, "-=0.6");

    servicesTl.fromTo('.aiero-services-contact', {
        opacity: 0,
        y: 25
    }, {
        opacity: 1,
        y: 0,
        duration: 0.8,
        ease: 'power3.out'
    }, "-=0.65");

    servicesTl.fromTo('.aiero-service-card', {
        opacity: 0,
        y: 50,
        scale: 0.96
    }, {
        opacity: 1,
        y: 0,
        scale: 1,
        duration: 1,
        stagger: 0.12,
        ease: 'power4.out'
    }, "-=0.8");

    // 2. Liquid Parallax Depth Slider Logic
    const servicesTrack = document.querySelector('.aiero-services-slider-track');
    const servicesCards = document.querySelectorAll('.aiero-service-card');
    const servicesDotsContainer = document.querySelector('.aiero-services-nav-controls');
    let servicesCurrentPage = 0;

    function buildServicesDots() {
        if (!servicesDotsContainer) return;
        const isDesktop = window.innerWidth > 1100;
        const totalPages = isDesktop ? 2 : 4;

        servicesDotsContainer.innerHTML = '';
        for (let i = 0; i < totalPages; i++) {
            const dot = document.createElement('span');
            dot.classList.add('aiero-services-dot');
            if (i === 0) dot.classList.add('active');
            dot.setAttribute('data-page', i);
            dot.addEventListener('click', () => {
                goToServicesPage(i);
            });
            servicesDotsContainer.appendChild(dot);
        }

        // Reset track position on resize/build
        goToServicesPage(0, true);
    }

    function goToServicesPage(pageIndex, immediate = false) {
        const isDesktop = window.innerWidth > 1100;
        const cardsPerPage = isDesktop ? 2 : 1;
        const cardWidth = servicesCards[0].offsetWidth;
        const gap = 32; // 2rem gap

        const slideAmount = pageIndex * cardsPerPage * (cardWidth + gap);

        // Active dot update
        const serviceDots = document.querySelectorAll('.aiero-services-dot');
        if (serviceDots.length > 0) {
            serviceDots.forEach((dot, idx) => {
                dot.classList.toggle('active', idx === pageIndex);
            });
        }

        const prevPage = servicesCurrentPage;
        servicesCurrentPage = pageIndex;

        if (immediate) {
            gsap.set(servicesTrack, { x: -slideAmount });
            // Set default parallax state
            servicesCards.forEach((card) => {
                const img = card.querySelector('.aiero-service-card-img');
                gsap.set(img, { x: 0 });
            });
        } else {
            const direction = pageIndex > prevPage ? 1 : -1;

            // Skew animation on the whole track
            gsap.timeline()
                .to(servicesTrack, {
                    x: -slideAmount,
                    duration: 0.85,
                    ease: 'power3.out'
                })
                .fromTo(servicesCards, {
                    skewX: 0
                }, {
                    skewX: -2.5 * direction,
                    duration: 0.4,
                    ease: 'power1.out',
                    stagger: 0.05
                }, 0)
                .to(servicesCards, {
                    skewX: 0,
                    duration: 0.45,
                    ease: 'power2.out',
                    stagger: 0.05
                }, 0.35);

            // Parallax shift inside the card images
            servicesCards.forEach((card) => {
                const img = card.querySelector('.aiero-service-card-img');
                gsap.to(img, {
                    x: 20 * direction,
                    duration: 0.4,
                    ease: 'power1.out'
                });
                gsap.to(img, {
                    x: 0,
                    duration: 0.45,
                    ease: 'power2.out',
                    delay: 0.35
                });
            });
        }
    }

    // 3. 3D Tilt Card Interaction
    servicesCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (centerY - y) / 15; // horizontal tilt
            const rotateY = (x - centerX) / 15; // vertical tilt

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
        });
    });

    // Initialize dynamic pagination and track behaviors
    buildServicesDots();
    window.addEventListener('resize', buildServicesDots);

    // Add dynamic cursor hover states for new slider controls
    const servicesHoverables = document.querySelectorAll('.aiero-services-dot, .aiero-services-contact-num, .aiero-service-card');
    servicesHoverables.forEach(el => {
        el.addEventListener('mouseenter', () => {
            if (typeof cursorRing !== 'undefined') {
                gsap.to(cursorRing, { width: 55, height: 55, borderColor: '#e5c158', backgroundColor: 'rgba(229, 193, 88, 0.08)' });
            }
        });
        el.addEventListener('mouseleave', () => {
            if (typeof cursorRing !== 'undefined') {
                gsap.to(cursorRing, { width: 40, height: 40, borderColor: 'var(--color-primary)', backgroundColor: 'transparent' });
            }
        });
    });

});
