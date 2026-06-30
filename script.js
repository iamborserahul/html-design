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
        // Bed Division
        "bed7201": {
            title: "Platform Metal Bed",
            category: "Metal Beds Division",
            shortDesc: "Water & fire proof design with elegant grooved wood color panels, premium emboss details, and an adjustable leg support screw system constructed for comfort and long structural life.",
            specs: {
                "Bed Height": "16 inches standard",
                "Material": "Heavy-gauge structural steel & grooved paneling",
                "Weld Type": "Seamless anti-noise carbon dioxide welding",
                "Surface Coating": "Electrostatic thermal powder-coated (7-tank pretreatment)",
                "Support System": "Adjustable central legs with scratch-proof screw caps",
                "Packaging": "Full knock-down packing in compact flat boxes"
            },
            features: [
                "Water & fire proof panels styled in gorgeous wood-grain colors",
                "Noise-free bedframe engineering prevents metal squeaking",
                "Anti-rust pre-treatment survives humid and variable climates",
                "Highly customizable width and panel alignments on request"
            ],
            mainImg: "assets/metal-bed-7201-01.webp",
            thumbs: ["assets/metal-bed-7201-01.webp", "assets/metal-bed-7201-02.webp", "assets/metal-bed-7201-03.webp"],
            pdf: "ksi/Bedframe.pdf",
            categoryPage: "category-beds",
            categoryLabel: "Metal Beds"
        },
        "bed7202": {
            title: "TUBE METAL BED",
            category: "Metal Beds Division",
            shortDesc: "Double-reinforced heavy tubular structural bedstead with width-extending rails, full flat sheet tops, and high load capacity, perfect for residential, commercial, or hostel projects.",
            specs: {
                "Bed Height": "16 inches standard",
                "Material": "Heavy-wall circular and rectangular steel tubes",
                "Weld Type": "Fully welded rigid seam joints",
                "Surface Coating": "Scratch-resistant textured powder finish",
                "Top Board Support": "Supports heavy wood board or direct mattress placement",
                "Extender Kit": "Includes 6-inch side edge wideners"
            },
            features: [
                "Extremely rigid double-column tubular side posts for high load",
                "Easy-assemble structure builds up in less than 20 minutes",
                "Non-skid base pads protect structural bedroom tile floors",
                "Durable textured black powder coat prevents daily scratching"
            ],
            mainImg: "assets/metal-bed-7202-01.webp",
            thumbs: ["assets/metal-bed-7202-01.webp", "assets/metal-bed-7202-02.webp", "assets/metal-bed-7202-03.webp"],
            pdf: "ksi/Bedframe.pdf",
            categoryPage: "category-beds",
            categoryLabel: "Metal Beds"
        },
        "bunk6115": {
            title: "ORIGAMI BUNK BED",
            category: "Home & Bunk Beds Edition",
            shortDesc: "Beautiful double bunk bed inspired by paper planes and boats, specifically designed to spark the imagination of kids. Splits easily into two fully independent standard single beds.",
            specs: {
                "Dimensions": "198L x 98W x 175H cm",
                "Material": "Premium sheet steel with curved safety posts",
                "Theme Options": "Clouds, Mountains, Plane, or Boat designs",
                "Standard Colors": "Paris Scarlet, Bumblebee Yellow, Pepsi Blue, Ivory White",
                "Steps Guard": "Anti-slip ribbed steel flat stairs",
                "Guard Rails": "High-altitude boundary safety bars on all sides"
            },
            features: [
                "Fully convertible dual-conversion bunk bed framework",
                "No visible sharp bolts or joints to protect playful kids",
                "Completely fire-safe and odorless organic powder coatings",
                "Flat-pack boxing ensures easy shipment and transport"
            ],
            mainImg: "assets/origami-bunk-bed-01.webp",
            thumbs: ["assets/origami-bunk-bed-01.webp", "assets/origami-bunk-bed-02.webp", "assets/origami-bunk-bed-03.webp"],
            pdf: "ksi/Bedroom.pdf",
            categoryPage: "category-bunkbeds",
            categoryLabel: "Bunk Beds"
        },
        "bunk6114": {
            title: "NATURE BUNK BED",
            category: "Home & Bunk Beds Edition",
            shortDesc: "Double decker bed inspired by scenic drawings, offering customized clouds or mountains pattern frames. Seamlessly separates into two single beds as children grow.",
            specs: {
                "Dimensions": "198L x 98W x 175H cm",
                "Material": "High-strength seamless carbon steel profiles",
                "Panels": "Acoustic insulated grooved decorative sheets",
                "Available Shades": "Multi-shade pastel color palettes",
                "Weld Class": "Zero-rattle structural joints",
                "Ladder": "Integrated vertical structural steel ladder"
            },
            features: [
                "Whimsical child-friendly patterns laser-etched onto side guards",
                "Rigid heavy-post structure prevents structural shaking",
                "Durable and completely scratch-proof enamel baked finishes",
                "Engineered for easy assembly and dismantling"
            ],
            mainImg: "assets/nature-bunk-bed-01.webp",
            thumbs: ["assets/nature-bunk-bed-01.webp", "assets/nature-bunk-bed-02.webp", "assets/nature-bunk-bed-03.webp"],
            pdf: "ksi/Bedroom.pdf",
            categoryPage: "category-bunkbeds",
            categoryLabel: "Bunk Beds"
        },
        "sofabunk6094": {
            title: "BUCHAREST SOFA BUNK",
            category: "Home & Bunk Beds Edition",
            shortDesc: "The ultimate double agent furniture piece. High-end curvy modern double bunk bed that converts seamlessly into a large luxurious couch, perfect for dynamic space-saving.",
            specs: {
                "Dimensions": "198L x 98W x 174H cm",
                "Material": "Bending grade heavy steel tubes",
                "Mechanism": "Premium hinge counterweight slider system",
                "Mattress Fit": "Standard 4-inch padding compatibility",
                "Load Capacity": "Up to 150kg on top deck, 220kg on lower sofa level",
                "Coating": "Metallic charcoal, MULBERRY, or CAPPUCCINO colors"
            },
            features: [
                "Converts from standard sofa to bunk bed in under 30 seconds",
                "Curved side guards act as armrests in sofa configuration",
                "Perfect for modern penthouses and guest sleeping suites",
                "Rigid locking safety locks ensure stable bed placement"
            ],
            mainImg: "assets/bucharest-sofa-bunk-01.webp",
            thumbs: ["assets/bucharest-sofa-bunk-01.webp", "assets/bucharest-sofa-bunk-02.webp", "assets/bucharest-sofa-bunk-03.webp"],
            pdf: "ksi/Bedroom.pdf",
            categoryPage: "category-bunkbeds",
            categoryLabel: "Bunk Beds"
        },
        "bunk6095": {
            title: "VLADIVOSTOK BUNK BED",
            category: "Home & Bunk Beds Edition",
            shortDesc: "Triple-capacity bunk bed built for ultimate durability. Perfect for energetic kids pillow fights and bulk hostel environments requiring maximum strength.",
            specs: {
                "Dimensions": "198L x 155W x 170H cm",
                "Lower Deck Fit": "Standard double bed sizing (155cm width)",
                "Upper Deck Fit": "Standard single bed sizing (98cm width)",
                "Material": "Reinforced thick-wall steel tubing grid",
                "Weight limit": "Supports three adults safely",
                "Colors": "Charcoal Black, Graphite, Mulberry, Ivory"
            },
            features: [
                "Bunk bed structure fits three sleeper capacities comfortably",
                "Rigid double post anchors prevent shaking under heavy motion",
                "Epoxy powder pre-treatments prevent paint cracking",
                "Wide-step ladders prevent foot fatigue while climbing"
            ],
            mainImg: "assets/vladivostok-bunk-bed-01.webp",
            thumbs: ["assets/vladivostok-bunk-bed-01.webp", "assets/vladivostok-bunk-bed-02.webp", "assets/vladivostok-bunk-bed-03.webp"],
            pdf: "ksi/Bedroom.pdf",
            categoryPage: "category-bunkbeds",
            categoryLabel: "Bunk Beds"
        },

        // Hospital Division
        "icu-bed": {
            title: "ICU FOWLER BED",
            category: "Hospital Equipment & Beds",
            shortDesc: "Rigid multi-position adjustable clinical ICU bed featuring independent hand cranks for backrest and knee rest, collapsing steel side railings, and medical locking wheel grids.",
            specs: {
                "Dimensions": "205L x 90W x 60H cm standard",
                "Material": "Thick-walled seamless tubes & steel mesh top",
                "Positioning": "Dual-crank fowler system (backrest 75°, knee-rest 45°)",
                "Finishing": "Anti-microbial epoxy-polyester powder coating",
                "Side Rails": "Collapsible heavy-duty side guard grills",
                "Casters": "4 wheels, 125mm size with dual lock foot brakes"
            },
            features: [
                "Anti-microbial surface treatment survives rigorous sanitization",
                "Heavy cranking gears operate smoothly with minimum force",
                "Includes corner buffer wheels and telescoping IV stand mounts",
                "Engineered to withstand heavy clinical ward loads up to 250kg"
            ],
            mainImg: "assets/icu-fowler-bed-01.webp",
            thumbs: ["assets/icu-fowler-bed-01.webp"],
            pdf: "ksi/Hospital Equipment and Furniture.pdf",
            categoryPage: "category-hospital",
            categoryLabel: "Hospital Beds"
        },
        "semi-fowler": {
            title: "SEMI-FOWLER BED",
            category: "Hospital Equipment & Beds",
            shortDesc: "Standard ward semi-fowler bed with single mechanical crank for smooth backrest adjustment, durable head and foot boards, and anti-corrosive powder finish.",
            specs: {
                "Dimensions": "200L x 90W x 55H cm",
                "Material": "Rectangular structural carbon steel section",
                "Adjustment": "Single crank (backrest elevation up to 70°)",
                "Panel Guards": "Bespoke laminated head/foot boards",
                "Finish": "Oven-baked anti-microbial paint layer",
                "Mounts": "Integrated IV pole insertion sockets"
            },
            features: [
                "Extremely reliable and basic ward model with zero maintenance",
                "High chemical resistance to clinical washing and disinfectants",
                "Smooth cranking mechanism prevents patient jarring during use",
                "Laminated boards offer a clean aesthetic on hospital floors"
            ],
            mainImg: "assets/semi-fowler-bed-01.webp",
            thumbs: ["assets/semi-fowler-bed-01.webp"],
            pdf: "ksi/Hospital Equipment and Furniture.pdf",
            categoryPage: "category-hospital",
            categoryLabel: "Hospital Beds"
        },
        "ward-bed": {
            title: "WARD PLAIN BED",
            category: "Hospital Equipment & Beds",
            shortDesc: "Basic plain hospital ward bed engineered with high-gauge steel pipes and flat steel mesh panels. Perfect for high-capacity medical setups and clinic wards.",
            specs: {
                "Dimensions": "195L x 90W x 50H cm",
                "Material": "Seamless steel pipe outline",
                "Deck Panel": "Four-section rigid steel mesh board",
                "Load Capacity": "Supports up to 200kg static load",
                "Coating": "Anti-static epoxy white powder finish",
                "Assembly": "Knock-down configuration with fast hook locks"
            },
            features: [
                "Designed for quick bulk ward deployment under flat-pack shipping",
                "Zero mechanical components ensures unlimited service life",
                "Strong tubular posts survive heavy usage without bending",
                "Anti-rust pretreatment prevents damage under daily cleanings"
            ],
            mainImg: "assets/ward-bed-01.webp",
            thumbs: ["assets/ward-bed-01.webp"],
            pdf: "ksi/Hospital Equipment and Furniture.pdf",
            categoryPage: "category-hospital",
            categoryLabel: "Hospital Beds"
        },
        "bedside-locker": {
            title: "BEDSIDE LOCKER CABINET",
            category: "Hospital Equipment & Beds",
            shortDesc: "Rust-proof, high-durability medical bedside locker cupboard featuring a single drawer, spacious bottom cabinet, and integrated towel rails for patient convenience.",
            specs: {
                "Dimensions": "40L x 40W x 80H cm standard",
                "Material": "Premium sheet metal with polished steel handles",
                "Shelves": "Single top drawer and bottom cabinet with middle shelf",
                "Accessories": "Dual side towel bars & secure lock keys",
                "Finishing": "Anti-microbial chemical-resistant white powder coat",
                "Base support": "Scratch-resistant thick rubber buffer feet"
            },
            features: [
                "Provides bedside utility storage for medicine and patient records",
                "Stainless steel cabinet top provides high hygiene surface",
                "Easy-clean interior panels with zero corner dust traps",
                "Rigid locks protect clinical items and patient belongings"
            ],
            mainImg: "assets/bedside-locker-01.webp",
            thumbs: ["assets/bedside-locker-01.webp"],
            pdf: "ksi/Hospital Equipment and Furniture.pdf",
            categoryPage: "category-hospital",
            categoryLabel: "Hospital Beds"
        },
        "saline-stand": {
            title: "IV SALINE STAND",
            category: "Hospital Equipment & Beds",
            shortDesc: "Height adjustable chrome-plated steel IV saline stand with four utility hooks, locking telescoping shafts, and rolling caster base wheels.",
            specs: {
                "Height Range": "135 cm to 230 cm adjustable",
                "Material": "Chrome-plated stainless steel telescoping rod",
                "Hooks": "4 anti-slip hanging loops",
                "Lock System": "Ergonomic compression screw locking cap",
                "Base Grid": "5-legged weighted rolling base caster wheels",
                "Casters": "50mm high-grade nylon wheels"
            },
            features: [
                "Smooth height sliding allows quick setups for medical staff",
                "Weighted star-pattern base prevents tipping under heavy drip bag load",
                "Standard medical-grade chrome resists biological stains and rust",
                "Nylon casters roll silently across hospital tile grids"
            ],
            mainImg: "assets/saline-stand-03.webp",
            thumbs: ["assets/saline-stand-03.webp"],
            pdf: "ksi/Hospital Equipment and Furniture.pdf",
            categoryPage: "category-hospital",
            categoryLabel: "Hospital Beds"
        },
        "stretcher": {
            title: "PATIENT TRANSPORT STRETCHER",
            category: "Hospital Equipment & Beds",
            shortDesc: "High-grade patient transport trolley featuring a removable canvas or metal stretcher top, heavy steel support pipes, and rotating wheels with bumpers.",
            specs: {
                "Dimensions": "190L x 60W x 80H cm standard",
                "Material": "Carbon-steel structural pipe trolley",
                "Stretcher Top": "Removable steel sheet stretcher with carrying handles",
                "Casters": "150mm rotating medical wheels (two brake lock)",
                "Bumper": "Corner circular rubber protection bumper pads",
                "Oxygen Mount": "Integrated cylinder holder ring at bottom"
            },
            features: [
                "Removable stretcher allows quick and safe transport transfers",
                "Thick bumper wheels protect hospital walls from mechanical impacts",
                "High-capacity trolley framework handles up to 180kg patient load",
                "Polyester baked finish ensures chemical sterilization resistance"
            ],
            mainImg: "assets/stretcher-01.webp",
            thumbs: ["assets/stretcher-01.webp"],
            pdf: "ksi/Hospital Equipment and Furniture.pdf",
            categoryPage: "category-hospital",
            categoryLabel: "Hospital Beds"
        },

        // Cupboard Division
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
            categoryPage: "category-cupboards",
            categoryLabel: "Storage Cabinets"
        },
        "sliding-almirah": {
            title: "SLIDING MODULAR ALMIRAH",
            category: "Steel Cupboards & Storage",
            shortDesc: "Premium sliding-door modular steel almirah featuring ultra-smooth ball-bearing tracks, space-saving layouts, and textured modern wood color panels.",
            specs: {
                "Dimensions": "198H x 135W x 55D cm",
                "Material": "High-gauge structural carbon steel framing sheets",
                "Sliding Track": "High-precision dust-proof steel tracks",
                "Drawer count": "3 internal utility drawers and locker",
                "Hanger Rod": "Dual chrome-plated steel hanging pipes",
                "Finishing": "Multi-shade textured styling overlays"
            },
            features: [
                "Sliding door design maximizes usable floor room in bedrooms",
                "Double-cushioned door edges prevent mechanical clattering noises",
                "Fully adjustable shelf heights to arrange clothing sizes",
                "Ultra-sleek modern handle profiles with premium safety latch"
            ],
            mainImg: "assets/sliding-almirah-01.webp",
            thumbs: ["assets/sliding-almirah-01.webp"],
            pdf: "ksi/Cupboard.pdf",
            categoryPage: "category-cupboards",
            categoryLabel: "Storage Cabinets"
        },
        "office-locker": {
            title: "SECURE OFFICE LOCKER",
            category: "Steel Cupboards & Storage",
            shortDesc: "Heavy-duty multi-door steel office locker cabinet featuring individual secure key latches, index label slots, and modular space-saving designs.",
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
            categoryPage: "category-cupboards",
            categoryLabel: "Storage Cabinets"
        },
        "tool-cabinet": {
            title: "INDUSTRIAL TOOL CABINET",
            category: "Steel Cupboards & Storage",
            shortDesc: "High-load industrial tooling rack cabinet designed with reinforced door ribs, massive load capacities per shelf, and multi-latch mechanical lock handles.",
            specs: {
                "Dimensions": "185H x 100W x 50D cm",
                "Sheet Gauge": "Thick 1.2mm structural steel sheets",
                "Load per shelf": "Up to 120kg weight capacity per panel",
                "Door reinforcement": "Welded internal double steel hat sections",
                "Lock Mechanism": "Heavy-handle three-point rod locking grid",
                "Finishing": "High-durability hammer-tone powder coating"
            },
            features: [
                "Massive loading capacity safely stores heavy machine tools",
                "Reinforced double-hat door bars prevent doors from warping",
                "Industrial powder finishes are immune to engine oil or grease",
                "Adjustable shelf sections adapt to variable storage sizes"
            ],
            mainImg: "assets/industrial-tool-cabinet-new.jpg",
            thumbs: ["assets/industrial-tool-cabinet-new.jpg"],
            pdf: "ksi/Cupboard.pdf",
            categoryPage: "category-cupboards",
            categoryLabel: "Storage Cabinets"
        },

        // Doors Division
        "safety-door": {
            title: "FIRE SAFETY DOOR",
            category: "Metal Doors & Safety Gates",
            shortDesc: "Heavy double-plated steel fire safety door designed with acoustic insulated mineral fills, solid structural steel frame rebated hinges, and multi-point secure lock systems.",
            specs: {
                "Standard Sizing": "210H x 95W cm (Customizable ratios)",
                "Sheet Thickness": "1.2mm outer skin, 1.5mm inner frame steel",
                "Core Infills": "Fire-resistant rockwool or mineral soundproof fill",
                "Lock box": "Three-point mechanical safety locking system",
                "Hinges": "Heavy-duty steel pivot hinges",
                "Finish": "Industrial anti-corrosive prime baked paint"
            },
            features: [
                "Double-plated construction ensures high fire and smoke seals",
                "Soundproof acoustic core significantly deadens structural corridor noise",
                "Reinforced strike panels prevent forced mechanical entry",
                "Bespoke designs can be laser cut to fit specialized frame grids"
            ],
            mainImg: "assets/fire-safety-door-03.webp",
            thumbs: ["assets/fire-safety-door-03.webp"],
            pdf: "ksi/Door.pdf",
            categoryPage: "category-doors",
            categoryLabel: "Metal Doors"
        },
        "entrance-gate": {
            title: "MAIN ENTRANCE GATE",
            category: "Metal Doors & Safety Gates",
            shortDesc: "Bespoke structural entrance security gates designed with gorgeous modern geometric grilles, heavy steel hollow sections, and custom weather-proof styling.",
            specs: {
                "Dimensions": "Custom fabricated to entrance layouts",
                "Frame Material": "Extra-gauge square hollow steel tube profiles",
                "Infill rods": "Laser-cut sheet grilles and steel panels",
                "Hinge System": "Large industrial ball-bearing gate hinges",
                "Lock Type": "Deadbolt locking box with secondary latch mount",
                "Surface Coating": "Multi-stage epoxy primer + premium outer enamel"
            },
            features: [
                "Custom visual outline matches modern architectural frontages",
                "Industrial hinges ensure smooth opening swing with zero sag",
                "Extremely tough fabrication resists physical impacts and wind",
                "High weather-resistance survives intense monsoon and summer sun"
            ],
            mainImg: "assets/main-entrance-gate-01.webp",
            thumbs: ["assets/main-entrance-gate-01.webp", "assets/main-entrance-gate-02.webp", "assets/main-entrance-gate-03.webp"],
            pdf: "ksi/Door.pdf",
            categoryPage: "category-doors",
            categoryLabel: "Metal Doors"
        },
        "structural-frame": {
            title: "PRECISION METAL FRAME DOOR",
            category: "Metal Doors & Safety Gates",
            shortDesc: "Custom precision steel facade framing grids, security window bars, and structural iron grilles built to order for commercial or residential architectural layouts.",
            specs: {
                "Sizing Limits": "Fabricated to builder cad blueprint values",
                "Tube Grades": "Standard structural carbon steel tubes",
                "Welding Standard": "Seamless full-penetration structural welds",
                "Finish Option": "Hot-dip galvanizing or primer coating",
                "Anchor Style": "Heavy anchor plates for concrete installation",
                "Tensile Strength": "High load structural capacity certifications"
            },
            features: [
                "Fabricated with extreme dimensional tolerances to fit building grids",
                "Full-penetration welds guarantee unlimited load resistance",
                "Perfect for high-altitude architectural grilles and safety windows",
                "Available with thermal rust-inhibitor galvanizing treatments"
            ],
            mainImg: "assets/precision-metal-frame-01.webp",
            thumbs: ["assets/precision-metal-frame-01.webp", "assets/precision-metal-frame-02.webp", "assets/precision-metal-frame-03.webp"],
            pdf: "ksi/Door.pdf",
            categoryPage: "category-doors",
            categoryLabel: "Metal Doors"
        },

        // Dining & Bathroom Division
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
            categoryPage: "category-dining-bathroom",
            categoryLabel: "Dining & Bathroom"
        },
        "vanity-cabinet": {
            title: "MODULAR VANITY CABINET",
            category: "Dining & Bathroom Furniture",
            shortDesc: "Rust-proof and moisture-resistant stainless steel under-basin bathroom vanity cabinet featuring soft-close hinges, modular shelving, and a sleek glossy finish.",
            specs: {
                "Dimensions": "80W x 50D x 60H cm (Custom sizing)",
                "Material": "Rust-proof sheet stainless steel with powder finish",
                "Door Hinges": "Premium hydraulic soft-close damping hinges",
                "Internal Rack": "Modular storage shelf with plumbing passage cut",
                "Coating": "Damp-proof polyester white/grey paint layers",
                "Handle Type": "Integrated invisible finger-pull grooves"
            },
            features: [
                "Specially engineered to resist high humidity and direct splashing",
                "Soft-close damping hinges prevent doors from slamming in wet areas",
                "Integrated plumbing slot fits standard sink pipes cleanly",
                "Polished steel surface rejects hard water stains and soap scale"
            ],
            mainImg: "assets/modular-vanity-cabinet-01.webp",
            thumbs: ["assets/modular-vanity-cabinet-01.webp", "assets/modular-vanity-cabinet-02.webp", "assets/modular-vanity-cabinet-03.webp"],
            pdf: "ksi/Bathroom Cabinet.pdf",
            categoryPage: "category-dining-bathroom",
            categoryLabel: "Dining & Bathroom"
        },
        "mirror-frame": {
            title: "BATHROOM CABINET",
            category: "Dining & Bathroom Furniture",
            shortDesc: "Elegant rust-proof stainless steel wall-mounted mirror frames. Perfect for premium hotel guest suites and luxury household bathroom decors.",
            specs: {
                "Dimensions": "75 cm diameter or 80 x 60 cm rectangular",
                "Frame Width": "5 cm standard rim",
                "Material": "Mirror-polish or brush-finished stainless steel rim",
                "Mirror type": "High-clarity 5mm silver backing glass",
                "Mounting": "Heavy wall-hanging keyhole anchor tabs",
                "Rust Proof": "Standard moisture barrier backing sheets"
            },
            features: [
                "Provides a beautiful sleek metal outline around bathroom mirrors",
                "Grade 304 steel guarantees zero rust spots behind vanity sinks",
                "Integrated damp-proof backing prevents silvering damage on glass",
                "Simple, strong keyhole brackets allow secure and level mounting"
            ],
            mainImg: "assets/structural-mirror-frame-03.webp",
            thumbs: ["assets/structural-mirror-frame-03.webp"],
            pdf: "ksi/Bathroom Cabinet.pdf",
            categoryPage: "category-dining-bathroom",
            categoryLabel: "Dining & Bathroom"
        },

        // Outdoor Division
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
            categoryPage: "category-outdoor",
            categoryLabel: "Outdoor Structures"
        },
        "poolside-recliner": {
            title: "POOLSIDE RECLINER CHAIR",
            category: "Outdoor Metal Structures",
            shortDesc: "All-weather folding poolside recliner chair featuring multi-level backrest reclining angles, sturdy steel framing, and premium anti-rust styling overlays.",
            specs: {
                "Dimensions": "185L x 60W x 35H cm standard",
                "Material": "High-gauge structural hollow steel profiles",
                "Reclining angles": "4 adjustable reclining slots",
                "Weight limit": "Supports up to 160kg safely",
                "Coating": "Thermoset high-weather polyester powder coating",
                "Mesh Fit": "Supports structural waterproof mesh fabric panels"
            },
            features: [
                "Multi-level back adjustability allows relaxing resting poses",
                "Rust-proof powder finishes survive chlorinated pool splasings",
                "Lightweight structural engineering allows easy deck moving",
                "Folding post design stacks compactly for off-season storage"
            ],
            mainImg: "assets/poolside-recliner-chair-01.webp",
            thumbs: ["assets/poolside-recliner-chair-01.webp"],
            pdf: "ksi/Adjustable Bed & Poolside Chair.pdf",
            categoryPage: "category-outdoor",
            categoryLabel: "Outdoor Structures"
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
