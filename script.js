document.addEventListener('DOMContentLoaded', () => {
    gsap.registerPlugin(ScrollTrigger);

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
            gsap.to(cursorRing, { width: 55, height: 55, borderColor: '#FFC229', backgroundColor: 'rgba(255, 194, 41, 0.08)' });
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

    if (slides.length > 0) {
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
            if (!progressBar) return;
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

        if (prevArrow) {
            prevArrow.addEventListener('click', () => {
                const prevIdx = (currentIndex - 1 + slides.length) % slides.length;
                goToSlide(prevIdx);
            });
        }

        if (nextArrow) {
            nextArrow.addEventListener('click', () => {
                const nextIdx = (currentIndex + 1) % slides.length;
                goToSlide(nextIdx);
            });
        }

        // Start first slide progression
        startProgressBar();
    }

    // 4. Custom Dark/Light theme toggle matching capsule button in screenshot
    const themeBtn = document.querySelector('.aiero-theme-btn');
    const body = document.body;

    // Load theme from localStorage (Defaults to 'light' to ensure a light background)
    const savedTheme = localStorage.getItem('site-theme') || 'light';
    if (savedTheme === 'dark') {
        body.classList.add('aiero-theme');
        if (themeBtn) themeBtn.innerHTML = '<i class="fa-solid fa-moon"></i>';
    } else {
        body.classList.remove('aiero-theme');
        if (themeBtn) themeBtn.innerHTML = '<i class="fa-solid fa-sun"></i>';
        localStorage.setItem('site-theme', 'light');
    }

    if (themeBtn) {
        themeBtn.addEventListener('click', () => {
            body.classList.toggle('aiero-theme');

            // Dynamically update the icon inside the button and save choice
            if (body.classList.contains('aiero-theme')) {
                // Dark theme active -> show Moon icon to switch/indicate state
                themeBtn.innerHTML = '<i class="fa-solid fa-moon"></i>';
                localStorage.setItem('site-theme', 'dark');
            } else {
                // Light theme active -> show Sun icon to switch/indicate state
                themeBtn.innerHTML = '<i class="fa-solid fa-sun"></i>';
                localStorage.setItem('site-theme', 'light');
            }
        });
    }

    // 5. Fullscreen Toggle
    const compressIcon = document.querySelector('.fa-compress');
    if (compressIcon) {
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
    }

    // 5b. Product Categories Dynamic Word Split & ScrollTrigger Animation Setup
    const categoriesTitle = document.querySelector('.aiero-categories-title');
    if (categoriesTitle) {
        const lines = categoriesTitle.innerHTML.split(/<br\s*\/?>/i);
        categoriesTitle.innerHTML = lines.map(line => {
            const words = line.trim().split(/\s+/);
            const lineContent = words.map(word => {
                return `<span class="reveal-wrapper"><span class="reveal-inner">${word}</span></span>`;
            }).join(' ');
            return `<div class="reveal-line-box">${lineContent}</div>`;
        }).join('');
    }

    const categoriesTl = gsap.timeline({
        scrollTrigger: {
            trigger: '.aiero-categories-section',
            start: 'top 75%',
            toggleActions: 'play none none none'
        }
    });

    categoriesTl.fromTo('.aiero-categories-tagline', {
        opacity: 0,
        x: -25
    }, {
        opacity: 1,
        x: 0,
        duration: 0.7,
        ease: 'power3.out'
    });

    categoriesTl.to('.aiero-categories-title .reveal-inner', {
        y: '0%',
        duration: 0.85,
        stagger: 0.05,
        ease: 'power3.out'
    }, "-=0.5");

    categoriesTl.fromTo('.aiero-category-card', {
        opacity: 0,
        y: 50,
        scale: 0.95
    }, {
        opacity: 1,
        y: 0,
        scale: 1,
        duration: 0.95,
        stagger: 0.1,
        ease: 'power3.out'
    }, "-=0.6");

    // Add dynamic cursor hover states for category cards
    const categoryCards = document.querySelectorAll('.aiero-category-card');
    categoryCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            if (typeof cursorRing !== 'undefined') {
                gsap.to(cursorRing, { width: 55, height: 55, borderColor: '#FFC229', backgroundColor: 'rgba(255, 194, 41, 0.08)' });
            }
        });
        card.addEventListener('mouseleave', () => {
            if (typeof cursorRing !== 'undefined') {
                gsap.to(cursorRing, { width: 40, height: 40, borderColor: 'var(--color-primary)', backgroundColor: 'transparent' });
            }
        });
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
            start: 'top 95%',
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
    creationsTl.fromTo('.aiero-creation-card-wrapper', {
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

    // 8. Back to Top smooth scroll & floating visibility
    const backToTopBtn = document.querySelector('.aiero-back-to-top');
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                backToTopBtn.classList.add('visible');
            } else {
                backToTopBtn.classList.remove('visible');
            }
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
        const totalPages = isDesktop ? Math.ceil(servicesCards.length / 2) : servicesCards.length;

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
        const gap = parseFloat(window.getComputedStyle(servicesTrack).columnGap) ||
            parseFloat(window.getComputedStyle(servicesTrack).gap) ||
            32;

        const maxSlide = Math.max(0, (servicesCards.length - cardsPerPage) * (cardWidth + gap));
        const slideAmount = Math.min(pageIndex * cardsPerPage * (cardWidth + gap), maxSlide);

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

    // 3. Swipe/Drag interaction using Pointer Events
    let startX = 0;
    let currentX = 0;
    let isDragging = false;
    let trackStartX = 0;
    const servicesSliderCol = document.querySelector('.aiero-services-slider-col');

    if (servicesSliderCol && servicesTrack && servicesCards.length > 0) {
        // Prevent default browser image dragging
        servicesTrack.querySelectorAll('.aiero-service-card-img').forEach(img => {
            img.addEventListener('dragstart', (e) => e.preventDefault());
        });

        const startDrag = (e) => {
            if (e.pointerType === 'mouse' && e.button !== 0) return;
            isDragging = true;
            startX = e.clientX;
            currentX = e.clientX;
            trackStartX = gsap.getProperty(servicesTrack, "x") || 0;

            servicesTrack.style.cursor = 'grabbing';
            servicesCards.forEach(card => card.style.cursor = 'grabbing');
        };

        const moveDrag = (e) => {
            if (!isDragging) return;
            currentX = e.clientX;
            const diffX = currentX - startX;
            let targetX = trackStartX + diffX;

            const isDesktop = window.innerWidth > 1100;
            const totalPages = isDesktop ? Math.ceil(servicesCards.length / 2) : servicesCards.length;
            const cardsPerPage = isDesktop ? 2 : 1;
            const cardWidth = servicesCards[0].offsetWidth;
            const gap = parseFloat(window.getComputedStyle(servicesTrack).columnGap) ||
                parseFloat(window.getComputedStyle(servicesTrack).gap) ||
                32;
            const maxSlide = Math.max(0, (servicesCards.length - cardsPerPage) * (cardWidth + gap));

            // Bounds constraints with elastic boundary resistance
            if (targetX > 0) {
                targetX = targetX * 0.35;
            } else if (targetX < -maxSlide) {
                const overflow = targetX + maxSlide;
                targetX = -maxSlide + overflow * 0.35;
            }

            gsap.set(servicesTrack, { x: targetX });

            // Premium drag horizontal skew/tilt micro-interaction
            const tilt = Math.min(Math.max(diffX * 0.04, -4), 4);
            servicesCards.forEach(card => {
                card.style.transform = `perspective(1000px) rotateY(${tilt}deg)`;
            });
        };

        const endDrag = (e) => {
            if (!isDragging) return;
            isDragging = false;

            servicesTrack.style.cursor = '';
            servicesCards.forEach(card => {
                card.style.cursor = 'grab';
                card.style.transform = '';
            });

            const isDesktop = window.innerWidth > 1100;
            const totalPages = isDesktop ? Math.ceil(servicesCards.length / 2) : servicesCards.length;
            const diffX = currentX - startX;
            const threshold = 50;

            let targetPage = servicesCurrentPage;
            if (diffX > threshold && servicesCurrentPage > 0) {
                targetPage = servicesCurrentPage - 1;
            } else if (diffX < -threshold && servicesCurrentPage < totalPages - 1) {
                targetPage = servicesCurrentPage + 1;
            }

            goToServicesPage(targetPage);
        };

        // Attach listeners
        servicesSliderCol.addEventListener('pointerdown', startDrag);
        window.addEventListener('pointermove', moveDrag);
        window.addEventListener('pointerup', endDrag);
        window.addEventListener('pointercancel', endDrag);

        // Let the browser handle vertical touch scroll, handle horizontal swipes natively
        servicesSliderCol.style.touchAction = 'pan-y';
    }

    // 4. 3D Hover Tilt Card Interaction
    servicesCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            if (isDragging) return;
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (centerY - y) / 15;
            const rotateY = (x - centerX) / 15;

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
        });

        card.addEventListener('mouseleave', () => {
            if (isDragging) return;
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
                gsap.to(cursorRing, { width: 55, height: 55, borderColor: '#FFC229', backgroundColor: 'rgba(255, 194, 41, 0.08)' });
            }
        });
        el.addEventListener('mouseleave', () => {
            if (typeof cursorRing !== 'undefined') {
                gsap.to(cursorRing, { width: 40, height: 40, borderColor: 'var(--color-primary)', backgroundColor: 'transparent' });
            }
        });
    });

    // ==========================================
    // PORTAL EXPANSION DYNAMIC SCRIPTS
    // ==========================================

    // 1. Collapsible FAQs Accordion Handler
    const faqItems = document.querySelectorAll('.aiero-faq-item');
    faqItems.forEach(item => {
        const trigger = item.querySelector('.aiero-faq-trigger');
        const panel = item.querySelector('.aiero-faq-panel');

        trigger.addEventListener('click', () => {
            const isActive = item.classList.contains('active');

            // Close other FAQ items
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.aiero-faq-trigger').setAttribute('aria-expanded', 'false');
                    otherItem.querySelector('.aiero-faq-panel').style.maxHeight = null;
                }
            });

            // Toggle current FAQ item
            item.classList.toggle('active', !isActive);
            trigger.setAttribute('aria-expanded', !isActive ? 'true' : 'false');

            if (!isActive) {
                panel.style.maxHeight = panel.scrollHeight + "px";
            } else {
                panel.style.maxHeight = null;
            }
        });
    });

    // 2. Counter Cards — Staggered Scale-Grow Entrance Animation
    const counterCards = document.querySelectorAll('.aiero-counter-card');
    if (counterCards.length > 0) {
        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const cards = entry.target.querySelectorAll('.aiero-counter-card');
                    cards.forEach((card, i) => {
                        // Staggered grow-in with 150ms per card
                        setTimeout(() => {
                            card.classList.add('is-visible');

                            // Icon bounces in after card grows
                            const icon = card.querySelector('.aiero-counter-icon');
                            if (icon) {
                                gsap.fromTo(icon,
                                    { scale: 0, opacity: 0, rotation: -20 },
                                    {
                                        scale: 1, opacity: 1, rotation: 0,
                                        duration: 0.55, ease: 'back.out(2.5)', delay: 0.25
                                    }
                                );
                            }

                            // Number underline slides in after card settles
                            const num = card.querySelector('.aiero-counter-number');
                            if (num) {
                                setTimeout(() => num.classList.add('underline-ready'), 500);
                            }
                        }, i * 150);
                    });
                    cardObserver.disconnect();
                }
            });
        }, { threshold: 0.15 });

        const grid = document.querySelector('.aiero-counters-grid');
        if (grid) cardObserver.observe(grid);
    }

    // 2b. GSAP ScrollTrigger Statistic Counter Numbers
    const counterNumbers = document.querySelectorAll('.aiero-counter-number');
    if (counterNumbers.length > 0) {
        counterNumbers.forEach(counter => {
            const targetVal = parseInt(counter.getAttribute('data-target'), 10);

            gsap.fromTo(counter, {
                textContent: 0
            }, {
                textContent: targetVal,
                duration: 2,
                ease: 'power2.out',
                snap: { textContent: 1 },
                scrollTrigger: {
                    trigger: counter,
                    start: 'top 90%',
                    toggleActions: 'play none none none'
                },
                onUpdate: function () {
                    // Append formatting labels
                    if (targetVal === 15000) {
                        counter.textContent = Math.floor(counter.textContent).toLocaleString() + "+";
                    } else if (targetVal === 500) {
                        counter.textContent = Math.floor(counter.textContent) + "+";
                    } else if (targetVal === 25) {
                        counter.textContent = Math.floor(counter.textContent) + "+";
                    }
                }
            });
        });
    }

    // 3. Dynamic Product Details Page Database & Router
    const productDatabase = {

        // Bed Frame (merged Platform + Tube Metal Bed)
        "bed-frame": {
            title: "BED FRAME",
            category: "Metal Beds Division",
            shortDesc: "Heavy-gauge structural steel bed frames built for maximum load capacity, noise-free welding, and premium powder-coated finishes. Available in platform and tubular designs with adjustable leg support systems.",
            specs: {
                "Bed Height": "16 inches standard",
                "Material": "Heavy-gauge structural steel & grooved paneling / Heavy-wall circular and rectangular steel tubes",
                "Weld Type": "Seamless anti-noise carbon dioxide welding",
                "Surface Coating": "Electrostatic thermal powder-coated (7-tank pretreatment)",
                "Support System": "Adjustable central legs with scratch-proof screw caps",
                "Packaging": "Full knock-down packing in compact flat boxes"
            },
            features: [
                "Water & fire proof panels styled in gorgeous wood-grain colors",
                "Noise-free bedframe engineering prevents metal squeaking",
                "Anti-rust pre-treatment survives humid and variable climates",
                "Extremely rigid double-column tubular side posts for high load",
                "Easy-assemble structure builds up in less than 20 minutes",
                "Highly customizable width and panel alignments on request"
            ],
            mainImg: "assets/metal-bed-7201-01.webp",
            thumbs: [
                "assets/metal-bed-7201-01.webp",
                "assets/metal-bed-7201-02.webp",
                "assets/metal-bed-7201-03.webp",
                "assets/metal-bed-7202-01.webp",
                "assets/metal-bed-7202-02.webp",
                "assets/metal-bed-7202-03.webp"
            ],
            pdf: "ksi/Bedframe.pdf",
            categoryPage: "products",
            categoryLabel: "Products"
        },

        // Bunk Bed (all 4 models consolidated)
        "bunk-bed": {
            title: "BUNK BED",
            category: "Metal Beds Division",
            shortDesc: "Premium convertible double-decker bunk beds, themed kids designs, and heavy-duty triple sleepers constructed with rounded profiles, high safety rails, and dynamic space-saving configurations.",
            specs: {
                "Dimensions": "198L x 98W x 175H cm standard (with double decker/triple decker options)",
                "Material": "Premium sheet and tubular structural carbon steel",
                "Theme Options": "Clouds, Mountains, Plane, or Boat designs",
                "Standard Colors": "Paris Scarlet, Bumblebee Yellow, Pepsi Blue, Ivory White, Charcoal, Graphite, Mulberry, Cappuccino",
                "Guard Rails": "High-altitude boundary safety bars on all sides",
                "Versatility": "Converts easily to two independent single beds or sofa layout"
            },
            features: [
                "Child-Safe Construction: Rounded profiles and concealed joints to protect playing children",
                "Convertible Framework: Splits seamlessly into two independent single beds as needs change",
                "Sofa Bunk Conversion: Seamlessly transitions into a spacious couch in under 30 seconds",
                "Triple Sleeper Layout: Super-reinforced frame built to support three adults safely",
                "Odorless & Fire-Safe Organic Coatings: Electrostatic powder coat baked for maximum durability"
            ],
            mainImg: "assets/origami-bunk-bed-01.webp",
            thumbs: [
                "assets/origami-bunk-bed-01.webp",
                "assets/origami-bunk-bed-02.webp",
                "assets/origami-bunk-bed-03.webp",
                "assets/nature-bunk-bed-01.webp",
                "assets/nature-bunk-bed-02.webp",
                "assets/nature-bunk-bed-03.webp",
                "assets/bucharest-sofa-bunk-01.webp",
                "assets/bucharest-sofa-bunk-02.webp",
                "assets/bucharest-sofa-bunk-03.webp",
                "assets/vladivostok-bunk-bed-01.webp",
                "assets/vladivostok-bunk-bed-02.webp",
                "assets/vladivostok-bunk-bed-03.webp"
            ],
            pdf: "ksi/Bedroom.pdf",
            categoryPage: "products",
            categoryLabel: "Products"
        },

        // Gazebo
        "gazebo": {
            title: "GARDEN STEEL GAZEBO",
            category: "Outdoor Metal Structures",
            shortDesc: "Extra-heavy weather-resistant garden structural steel gazebo pavilion. Engineered with high wind tolerances, luxury columns, and modular canopy arches.",
            specs: {
                "Size Range": "3m x 3m standard (Custom sizes up to 6m)",
                "Material": "Extra-gauge carbon structural steel columns",
                "Column Post": "Circular double posts with geometric brace panels",
                "Roof Style": "Curved high-pitch water draining canopy ribs",
                "Wind Load": "Certified to resist high storm wind speeds",
                "Surface Coating": "Multi-stage sandblasting + thick zinc primer + powder"
            },
            features: [
                "Acts as a beautiful, high-end visual center in garden lawns",
                "Thick zinc base primers prevent structural rust under intense rain",
                "Integrated bolt anchor foot plates secure gates directly to concrete",
                "Canopy structure supports standard waterproof tensile fabrics"
            ],
            mainImg: "assets/garden-steel-gazebo-02.webp",
            thumbs: ["assets/garden-steel-gazebo-02.webp", "assets/garden-steel-gazebo-03.webp"],
            pdf: "ksi/Gazebo.pdf",
            categoryPage: "products",
            categoryLabel: "Products"
        },

        // Locker
        "locker": {
            title: "STEEL LOCKER",
            category: "Steel Cupboards & Storage",
            shortDesc: "Heavy-duty multi-door steel office locker cabinet featuring individual secure key latches, index label slots, ventilation louvers, and modular space-saving designs for offices, schools, and institutions.",
            specs: {
                "Dimensions": "180H x 90W x 45D cm standard",
                "Locker doors": "6, 9, or 12 individual compartments",
                "Lock Class": "Secure individual locks with duplicate master keys",
                "Ventilation": "Laser-cut air ventilation louvers on doors",
                "Label Slot": "Integrated plastic card naming plate holders",
                "Coating": "Industrial scratch-proof light grey powder coat"
            },
            features: [
                "Provides secure temporary storage for staff, students, or visitors",
                "Durable structural steel doors stand up to millions of slams",
                "Air vents prevent internal moisture or odors from developing",
                "Modular vertical grids stack seamlessly side-by-side"
            ],
            mainImg: "assets/office-locker-cabinet-01.webp",
            thumbs: ["assets/office-locker-cabinet-01.webp"],
            pdf: "ksi/Cupboard.pdf",
            categoryPage: "products",
            categoryLabel: "Products"
        },

        // Dining Set
        "dining-set": {
            title: "DINING SET",
            category: "Dining & Bathroom Furniture",
            shortDesc: "High-end stainless steel dining set featuring premium mirror-polished tubes, 6 cushioned high-back steel chairs, and a heat-resistant tempered glass or marble top panel.",
            specs: {
                "Table Size": "180L x 90W x 75H cm (6-Seater standard)",
                "Chair Sizing": "45W x 45D x 95H cm standard",
                "Frame Material": "Grade 304 mirror-polished stainless steel tubes",
                "Top Board": "12mm tempered safety glass or luxury white marble",
                "Chair Padding": "High-density foam with leatherette upholstery",
                "Feet Pads": "Non-marking plastic floor gliding guides"
            },
            features: [
                "Grade 304 stainless steel frame ensures zero rust and lifetime polish",
                "Mirror-finish steel creates a luxurious, premium dining room aesthetic",
                "Tempered glass top panel is completely heat and scratch resistant",
                "Cushioned high-back steel chairs offer extreme seating comfort"
            ],
            mainImg: "assets/dining-set-ds301-02.webp",
            thumbs: ["assets/dining-set-ds301-02.webp", "assets/dining-set-ds301-01.webp", "assets/dining-set-ds301-03.webp"],
            pdf: "ksi/Dinning Set.pdf",
            categoryPage: "products",
            categoryLabel: "Products"
        },

        // Wardrobe
        "wardrobe": {
            title: "HOUSEHOLD WARDROBE",
            category: "Steel Cupboards & Storage",
            shortDesc: "Three-door luxury household steel wardrobe cupboard featuring multi-tier clothing sections, secure dual locking lockers, and high-gloss premium color panel layouts.",
            specs: {
                "Dimensions": "195H x 120W x 50D cm standard",
                "Material": "Cold-rolled high-strength sheet metal sheets",
                "Shelves": "5 interior racks, hanging rod, and security locker",
                "Lock System": "Three-way bullet locking bolt with key cylinders",
                "Internal Safe": "Secret secondary digital drawer locker compatibility",
                "Coating": "High-temperature baked textured enamel"
            },
            features: [
                "Durable three-way latch locks protect high-value household items",
                "Premium paint shades (Royal Blue, Chocolate, Ivory) available",
                "Oven-baked phosphating treatment ensures lifetime rust protection",
                "Integrated premium glass mirror pane on door face on request"
            ],
            mainImg: "assets/household-wardrobe-02.webp",
            thumbs: ["assets/household-wardrobe-02.webp"],
            pdf: "ksi/Cupboard.pdf",
            categoryPage: "products",
            categoryLabel: "Products"
        }
    };

    // Router execution logic
    if (window.location.pathname.includes("product-details")) {
        const urlParams = new URLSearchParams(window.location.search);
        let productId = urlParams.get("id");

        // Fallback default
        if (!productId || !productDatabase[productId]) {
            productId = "bed7201";
        }

        const data = productDatabase[productId];

        // 1. Populate text and titles
        document.title = `${data.title} | Khodiyar Steel`;
        const categoryTag = document.getElementById("details-category-tagline");
        const productTitle = document.getElementById("details-product-title");
        const shortDesc = document.getElementById("details-short-desc");
        const heroTitle = document.getElementById("details-hero-title");

        if (categoryTag) categoryTag.textContent = data.category.toUpperCase();
        if (productTitle) productTitle.textContent = data.title;
        if (shortDesc) shortDesc.textContent = data.shortDesc;
        if (heroTitle) heroTitle.textContent = data.title;

        // 2. Populate Breadcrumbs
        const breadcrumbs = document.getElementById("details-breadcrumbs");
        if (breadcrumbs) {
            breadcrumbs.innerHTML = `
                <li class="aiero-breadcrumb-item"><a href="./">Home</a></li>
                <li class="aiero-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></li>
                <li class="aiero-breadcrumb-item"><a href="${data.categoryPage}">${data.categoryLabel}</a></li>
                <li class="aiero-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></li>
                <li class="aiero-breadcrumb-item active">${data.title}</li>
            `;
        }

        // 3. Populate Gallery & Thumbs
        const mainImg = document.getElementById("details-main-img");
        const thumbsRow = document.getElementById("details-thumbs-row");

        if (mainImg) mainImg.setAttribute("src", data.mainImg);

        if (thumbsRow) {
            thumbsRow.innerHTML = data.thumbs.map((thumbSrc, index) => {
                const activeClass = index === 0 ? "active" : "";
                return `
                    <div class="aiero-gallery-thumb ${activeClass}" data-src="${thumbSrc}">
                        <img src="${thumbSrc}" alt="Thumbnail preview">
                    </div>
                `;
            }).join('');

            // Attach thumbnail click handlers
            const thumbs = thumbsRow.querySelectorAll('.aiero-gallery-thumb');
            thumbs.forEach(thumb => {
                thumb.addEventListener('click', () => {
                    thumbs.forEach(t => t.classList.remove('active'));
                    thumb.classList.add('active');
                    const targetSrc = thumb.getAttribute('data-src');
                    gsap.to(mainImg, {
                        opacity: 0,
                        duration: 0.25,
                        onComplete: () => {
                            mainImg.setAttribute('src', targetSrc);
                            gsap.to(mainImg, { opacity: 1, duration: 0.25 });
                        }
                    });
                });
            });
        }

        // 4. Populate Spec Table
        const specBody = document.getElementById("details-spec-body");
        if (specBody) {
            specBody.innerHTML = Object.entries(data.specs).map(([key, val]) => {
                return `
                    <tr>
                        <th>${key}</th>
                        <td>${val}</td>
                    </tr>
                `;
            }).join('');
        }

        // 5. Populate Features tab list
        const featuresList = document.getElementById("details-features-list");
        if (featuresList) {
            featuresList.innerHTML = data.features.map(feat => {
                return `
                    <li style="display: flex; gap: 0.8rem; align-items: flex-start;">
                        <i class="fa-solid fa-circle-check" style="color: #FFC229; margin-top: 0.2rem; font-size: 0.9rem;"></i>
                        <span>${feat}</span>
                    </li>
                `;
            }).join('');
        }

        // 6. Hook up Download and Inquire buttons
        const inquireBtn = document.getElementById("details-inquire-btn");
        const downloadBtn = document.getElementById("details-download-btn");

        if (inquireBtn) inquireBtn.setAttribute("href", `contact?product=${encodeURIComponent(data.title)}`);
        if (downloadBtn) downloadBtn.setAttribute("href", data.pdf);

        // 7. Tab Headers click switching handler
        const tabHeaders = document.querySelectorAll('.aiero-tab-header');
        const tabPanels = document.querySelectorAll('.aiero-tab-panel');

        tabHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const targetTab = header.getAttribute('data-tab');

                tabHeaders.forEach(h => h.classList.remove('active'));
                tabPanels.forEach(p => p.classList.remove('active'));

                header.classList.add('active');
                document.getElementById(targetTab).classList.add('active');
            });
        });

        // 8. Populate Related Products Grid (Select 3 alternative models)
        const relatedGrid = document.getElementById("details-related-grid");
        if (relatedGrid) {
            // Find products of same category excluding current
            const siblings = Object.entries(productDatabase)
                .filter(([id, sibling]) => sibling.category === data.category && id !== productId)
                .slice(0, 3);

            // Fallback to random products if siblings are sparse
            if (siblings.length < 3) {
                const extras = Object.entries(productDatabase)
                    .filter(([id, sibling]) => id !== productId && !siblings.find(([sId]) => sId === id))
                    .slice(0, 3 - siblings.length);
                siblings.push(...extras);
            }

            relatedGrid.innerHTML = siblings.map(([id, sib], index) => {
                const floatClass = `card-float-${(index % 3) + 1}`;
                return `
                    <div class="aiero-creation-card-wrapper">
                        <a href="product-details?id=${id}" class="aiero-creation-card ${floatClass}" style="display: block; height: 380px;">
                            <div class="aiero-creation-img" style="background-image: url('${sib.mainImg}');"></div>
                            <div class="aiero-creation-view-more">VIEW DETAILS</div>
                            <div class="aiero-creation-content" style="background: none; padding: 2rem;">
                                <span class="aiero-creation-label" style="font-size: 1.15rem;">${sib.title}</span>
                                <p class="aiero-creation-desc" style="font-size: 0.85rem; line-height: 1.5;">${sib.shortDesc.slice(0, 80)}...</p>
                            </div>
                        </a>
                    </div>
                `;
            }).join('');
        }
    }

    // 4. Contact Page Auto-fill Logic
    if (window.location.pathname.includes("contact")) {
        const urlParams = new URLSearchParams(window.location.search);
        const selectedProduct = urlParams.get("product");

        if (selectedProduct) {
            const categorySelect = document.getElementById("category");
            const messageArea = document.getElementById("message");

            // Set message prompt text
            if (messageArea) {
                messageArea.value = `Hello Khodiyar Steel team,\n\nI am inquiring regarding the "${selectedProduct}". I would like to request custom sizing parameters, available coloring boards, and bulk shipping pricing estimates to our location.\n\nThank you!`;
            }

            // Match select options based on product type
            if (categorySelect) {
                const prodLower = selectedProduct.toLowerCase();
                if (prodLower.includes("bed") || prodLower.includes("bunk")) {
                    categorySelect.value = "beds";
                } else if (prodLower.includes("ward") || prodLower.includes("locker") || prodLower.includes("cabinet") || prodLower.includes("stand") || prodLower.includes("stretcher")) {
                    // Check if it's hospital or storage wardrobe
                    if (prodLower.includes("wardrobe") || prodLower.includes("almirah") || prodLower.includes("tool")) {
                        categorySelect.value = "storage";
                    } else {
                        categorySelect.value = "hospital";
                    }
                } else if (prodLower.includes("door") || prodLower.includes("gate") || prodLower.includes("frame")) {
                    categorySelect.value = "doors";
                } else if (prodLower.includes("dining") || prodLower.includes("vanity") || prodLower.includes("mirror")) {
                    categorySelect.value = "dining";
                } else if (prodLower.includes("gazebo") || prodLower.includes("recliner")) {
                    categorySelect.value = "outdoor";
                }
            }
        }
    }

    // 5. Mobile Navigation Menu Toggle with GSAP Drawers
    const menuToggle = document.querySelector('.aiero-menu-toggle');
    const nav = document.querySelector('.aiero-nav');
    const menu = document.querySelector('.aiero-menu');

    if (menuToggle && nav && menu) {
        menuToggle.addEventListener('click', () => {
            const isActive = nav.classList.contains('mobile-menu-active');
            nav.classList.toggle('mobile-menu-active', !isActive);

            // Toggle icon
            const toggleIcon = menuToggle.querySelector('i');
            if (toggleIcon) {
                if (!isActive) {
                    toggleIcon.className = 'fa-solid fa-xmark';
                } else {
                    toggleIcon.className = 'fa-solid fa-bars';
                }
            }

            // Animate menu drawer height and opacity
            if (!isActive) {
                gsap.fromTo(menu, {
                    display: 'flex',
                    opacity: 0,
                    y: -20
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 0.45,
                    ease: 'power3.out'
                });
            } else {
                gsap.to(menu, {
                    opacity: 0,
                    y: -20,
                    duration: 0.35,
                    ease: 'power3.in',
                    onComplete: () => {
                        menu.style.display = 'none';
                    }
                });
            }
        });

        // Close mobile menu drawer on clicking links
        const menuLinks = menu.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (nav.classList.contains('mobile-menu-active')) {
                    nav.classList.remove('mobile-menu-active');
                    const toggleIcon = menuToggle.querySelector('i');
                    if (toggleIcon) toggleIcon.className = 'fa-solid fa-bars';

                    gsap.to(menu, {
                        opacity: 0,
                        y: -20,
                        duration: 0.35,
                        ease: 'power3.in',
                        onComplete: () => {
                            menu.style.display = 'none';
                        }
                    });
                }
            });
        });
    }

    // 7.5 Showcase Section Header Reveal Animation
    const showcaseTitle = document.querySelector('.showcase-title');
    if (showcaseTitle) {
        const words = showcaseTitle.innerText.trim().split(/\s+/);
        showcaseTitle.innerHTML = words.map(word => {
            return `<span class="reveal-wrapper"><span class="reveal-inner">${word}</span></span>`;
        }).join(' ');
    }

    const showcaseTl = gsap.timeline({
        scrollTrigger: {
            trigger: '.showcase-section',
            start: 'top 75%',
            toggleActions: 'play none none none'
        }
    });

    showcaseTl.fromTo('.showcase-subtitle', {
        opacity: 0,
        x: -25
    }, {
        opacity: 1,
        x: 0,
        duration: 0.7,
        ease: 'power3.out'
    });

    showcaseTl.to('.showcase-title .reveal-inner', {
        y: '0%',
        duration: 0.85,
        stagger: 0.06,
        ease: 'power3.out'
    }, "-=0.5");

    showcaseTl.fromTo('.showcase-desc-text', {
        opacity: 0,
        y: 30
    }, {
        opacity: 1,
        y: 0,
        duration: 0.8,
        ease: 'power3.out'
    }, "-=0.6");

    // 7.6 Premium Product Sticky Stacking Cards Scroll Listener
    const showcaseCards = document.querySelectorAll('.showcase-card');
    const showcaseStack = document.querySelector('.showcase-stack');

    if (showcaseCards.length > 0 && showcaseStack) {
        const handleCardStacking = () => {
            const viewportHeight = window.innerHeight;
            const stackRect = showcaseStack.getBoundingClientRect();

            showcaseCards.forEach((card, index) => {
                const nextCard = showcaseCards[index + 1];
                const contentCol = card.querySelector('.card-content-overlay');

                // Helper to update progress ring SVG of a card
                const updateProgressRing = (progressVal) => {
                    const indicator = card.querySelector('.card-scroll-indicator');
                    if (indicator) {
                        const ring = indicator.querySelector('.progress-ring__circle');
                        const textVal = indicator.querySelector('.progress-val');
                        if (ring && textVal) {
                            const percent = Math.round(progressVal * 100);
                            const circumference = 150.79; // 2 * pi * 24
                            const offset = circumference - (progressVal * circumference);
                            ring.style.strokeDashoffset = offset;
                            textVal.textContent = `${percent}%`;
                        }
                    }
                };

                // Use mathematically stable untransformed coordinates relative to stack parent
                // This prevents CSS scale transform shifts from feeding wrong values back into the bounding client rect top!
                const cardTop = stackRect.top + (index * viewportHeight);
                const nextCardTop = stackRect.top + ((index + 1) * viewportHeight);
                const stickyPoint = 10; // matching top: 10px buffer for subpixel scrolling
                const overlapStart = viewportHeight;
                const overlapEnd = stickyPoint;

                if (nextCard) {
                    if (nextCardTop < overlapStart && nextCardTop > overlapEnd) {
                        const progress = (overlapStart - nextCardTop) / (overlapStart - overlapEnd);
                        const scale = 1.0 - (progress * 0.40); // Scale from 1.0 down to 0.60
                        const translateY = progress * -50;   // Translate up up to -50px for optimal stacking depth
                        const opacity = 1.0 - (progress * 0.60);  // Slowly lowers opacity down to 0.40

                        card.style.transform = `scale(${scale}) translateY(${translateY}px)`;
                        card.style.opacity = opacity;
                        card.style.pointerEvents = 'auto';

                        // Fade out the text overlay completely as next card slides over
                        if (contentCol) {
                            contentCol.style.opacity = 1 - progress;
                            contentCol.style.transform = `translateY(${progress * -15}px)`;
                        }

                        // As card is being overlapped, its own scroll progress has finished (stays at 100%)
                        updateProgressRing(1);

                    } else if (nextCardTop <= overlapEnd) {
                        card.style.transform = `scale(0.60) translateY(-50px)`;
                        card.style.opacity = 0; // Hide completely once fully covered to prevent visual layering conflicts
                        card.style.pointerEvents = 'none';

                        if (contentCol) {
                            contentCol.style.opacity = 0;
                            contentCol.style.transform = 'translateY(-15px)';
                        }
                        updateProgressRing(1);
                    } else {
                        card.style.transform = `scale(1) translateY(0)`;
                        card.style.opacity = 1;
                        card.style.pointerEvents = 'auto';
                        if (contentCol) {
                            contentCol.style.opacity = 1;
                            contentCol.style.transform = 'translateY(0)';
                        }

                        // If it's not being overlapped, let's calculate its own entry progress!
                        if (index > 0) {
                            if (cardTop < overlapStart && cardTop > overlapEnd) {
                                const entryProgress = (overlapStart - cardTop) / (overlapStart - overlapEnd);
                                updateProgressRing(entryProgress);
                            } else if (cardTop <= overlapEnd) {
                                updateProgressRing(1);
                            } else {
                                updateProgressRing(0);
                            }
                        } else {
                            // First card is always 100% until it starts being covered by Card 2
                            updateProgressRing(1);
                        }
                    }
                } else {
                    // The last card (Card 4)
                    card.style.transform = `scale(1) translateY(0)`;
                    card.style.opacity = 1;
                    card.style.pointerEvents = 'auto';
                    if (contentCol) {
                        contentCol.style.opacity = 1;
                        contentCol.style.transform = 'translateY(0)';
                    }

                    // Update progress ring for the last card as it scrolls into its sticky position
                    if (cardTop < overlapStart && cardTop > overlapEnd) {
                        const entryProgress = (overlapStart - cardTop) / (overlapStart - overlapEnd);
                        updateProgressRing(entryProgress);
                    } else if (cardTop <= overlapEnd) {
                        updateProgressRing(1);
                    } else {
                        updateProgressRing(0);
                    }
                }
            });
        };

        window.addEventListener('scroll', handleCardStacking);
        handleCardStacking();
        window.addEventListener('resize', handleCardStacking);
    }

    // 8. Gallery Section Header Reveal Animation
    const galleryTitle = document.querySelector('.aiero-gallery-title');
    if (galleryTitle) {
        const words = galleryTitle.innerText.trim().split(/\s+/);
        galleryTitle.innerHTML = words.map(word => {
            return `<span class="reveal-wrapper"><span class="reveal-inner">${word}</span></span>`;
        }).join(' ');
    }

    const galleryTl = gsap.timeline({
        scrollTrigger: {
            trigger: '.aiero-gallery-section',
            start: 'top 75%',
            toggleActions: 'play none none none'
        }
    });

    galleryTl.fromTo('.aiero-gallery-subtitle', {
        opacity: 0,
        x: -25
    }, {
        opacity: 1,
        x: 0,
        duration: 0.7,
        ease: 'power3.out'
    });

    galleryTl.to('.aiero-gallery-title .reveal-inner', {
        y: '0%',
        duration: 0.85,
        stagger: 0.06,
        ease: 'power3.out'
    }, "-=0.5");

    galleryTl.fromTo('.aiero-gallery-desc', {
        opacity: 0,
        y: 30
    }, {
        opacity: 1,
        y: 0,
        duration: 0.8,
        ease: 'power3.out'
    }, "-=0.6");

    // 8.5 Gallery Section — dual-row horizontal sliding
    const galleryTopTrack = document.querySelector('.aiero-gallery-track--top');
    const galleryBottomTrack = document.querySelector('.aiero-gallery-track--bottom');

    if (galleryTopTrack && galleryBottomTrack) {
        const gallerySpeed = 35;

        const galleryTopTween = gsap.to(galleryTopTrack, {
            xPercent: -50,
            ease: 'none',
            duration: gallerySpeed,
            repeat: -1,
            paused: true
        });

        const galleryBottomTween = gsap.fromTo(galleryBottomTrack,
            { xPercent: -50 },
            {
                xPercent: 0,
                ease: 'none',
                duration: gallerySpeed,
                repeat: -1,
                paused: true
            }
        );

        const galleryRows = document.querySelectorAll('.aiero-gallery-row');
        galleryRows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                galleryTopTween.timeScale(0);
                galleryBottomTween.timeScale(0);
            });
            row.addEventListener('mouseleave', () => {
                galleryTopTween.timeScale(1);
                galleryBottomTween.timeScale(1);
            });
        });

        ScrollTrigger.create({
            trigger: '.aiero-gallery-section',
            start: 'top 85%',
            toggleActions: 'play none none none',
            onEnter: () => {
                galleryTopTween.play();
                galleryBottomTween.play();
            },
            onLeave: () => {
                galleryTopTween.pause();
                galleryBottomTween.pause();
            },
            onEnterBack: () => {
                galleryTopTween.play();
                galleryBottomTween.pause();
                galleryBottomTween.play();
            },
            onLeaveBack: () => {
                galleryTopTween.pause();
                galleryBottomTween.pause();
            }
        });
    }

});

window.addEventListener('load', () => {
    ScrollTrigger.refresh();
});
