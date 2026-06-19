/**
 * VÉRITÉ BEAUTY & SALON – Premium JavaScript
 * GSAP 3.12 | ScrollTrigger | Swiper 11 | AOS | Fancybox | jQuery UI
 */
(function($) {
  'use strict';

  // =============================================
  // PRELOADER
  // =============================================
  $(window).on('load', function() {
    setTimeout(function() {
      $('#preloader').addClass('loaded');
      $('body').css('overflow', 'visible');
      // Kick off hero after preloader
      setTimeout(initHeroAnimation, 200);
      ScrollTrigger.refresh();
    }, 2000);
  });

  // =============================================
  // CUSTOM CURSOR
  // =============================================
  const cursor = document.querySelector('.cursor');
  const follower = document.querySelector('.cursor-follower');

  if (cursor && follower) {
    let mouseX = 0, mouseY = 0;
    let curX = 0, curY = 0;

    document.addEventListener('mousemove', function(e) {
      mouseX = e.clientX;
      mouseY = e.clientY;
      cursor.style.left = mouseX + 'px';
      cursor.style.top = mouseY + 'px';
    });

    function animateFollower() {
      curX += (mouseX - curX) * 0.1;
      curY += (mouseY - curY) * 0.1;
      follower.style.left = curX + 'px';
      follower.style.top = curY + 'px';
      requestAnimationFrame(animateFollower);
    }
    animateFollower();

    const hoverTargets = 'a, button, .service-card, .social-card, .gallery-item, .team-card, .btn-luxury, .btn-luxury-outline, .membership-card, .offer-card, .contact-info-card, .service-detail-card';

    $(document).on('mouseenter', hoverTargets, function() {
      cursor.style.width = '10px';
      cursor.style.height = '10px';
      cursor.style.background = 'var(--gold-light)';
      follower.style.width = '60px';
      follower.style.height = '60px';
      follower.style.borderColor = 'var(--gold-light)';
      follower.style.background = 'rgba(201, 169, 110, 0.1)';
      follower.style.borderWidth = '2px';
    }).on('mouseleave', hoverTargets, function() {
      cursor.style.width = '6px';
      cursor.style.height = '6px';
      cursor.style.background = 'var(--gold)';
      follower.style.width = '44px';
      follower.style.height = '44px';
      follower.style.borderColor = 'rgba(201, 169, 110, 0.4)';
      follower.style.background = 'rgba(201, 169, 110, 0.05)';
      follower.style.borderWidth = '1px';
    });

    $(window).on('resize', function() {
      if ($(window).width() < 768) {
        $('.cursor, .cursor-follower').hide();
      } else { $('.cursor, .cursor-follower').show(); }
    }).trigger('resize');
  }

  // =============================================
  // HEADER
  // =============================================
  $(window).on('scroll', function() {
    if ($(this).scrollTop() > 80) { $('#header').addClass('scrolled'); }
    else { $('#header').removeClass('scrolled'); }

    // Back to top
    if ($(this).scrollTop() > 500) { $('#backToTop').addClass('visible'); }
    else { $('#backToTop').removeClass('visible'); }
  }).trigger('scroll');

  // =============================================
  // SMOOTH SCROLL
  // =============================================
  $(document).on('click', 'a[href^="#"]', function(e) {
    const target = $(this.getAttribute('href'));
    if (target.length) {
      e.preventDefault();
      $('html, body').animate({ scrollTop: target.offset().top - 80 }, 1200, 'easeInOutCubic');
    }
  });

  $('#backToTop').on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 }, 1000, 'easeInOutCubic');
  });

  $(document).on('click', '.navbar-collapse.show .nav-link', function() {
    $('.navbar-toggler').trigger('click');
  });

  // =============================================
  // AOS
  // =============================================
  AOS.init({
    duration: 900,
    once: true,
    offset: 80,
    easing: 'ease-out-cubic',
    disable: function() { return $(window).width() < 640; }
  });

  // =============================================
  // GSAP REGISTER
  // =============================================
  gsap.registerPlugin(ScrollTrigger, MotionPathPlugin);

  // =============================================
  // HERO – EPIC TIMELINE
  // =============================================
  function initHeroAnimation() {
    const tl = gsap.timeline({ delay: 0.3 });

    tl
      .from('.hero-tagline', {
        y: 50,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out'
      })
      .from('.hero-title .line-reveal', {
        y: 100,
        opacity: 0,
        duration: 1.1,
        stagger: 0.2,
        ease: 'power4.out'
      }, '-=0.7')
      .from('.hero-title .text-gold', {
        scale: 0.8,
        opacity: 0,
        duration: 1.0,
        ease: 'back.out(1.7)'
      }, '-=0.4')
      .from('.hero-subtitle', {
        y: 40,
        opacity: 0,
        duration: 0.9,
        ease: 'power3.out'
      }, '-=0.5')
      .from('.hero-buttons .btn-luxury', {
        y: 40,
        opacity: 0,
        duration: 0.8,
        stagger: 0.15,
        ease: 'back.out(1.7)'
      }, '-=0.4')
      .from('.hero-scroll-indicator', {
        y: 25,
        opacity: 0,
        duration: 0.8,
        ease: 'power2.out'
      }, '-=0.3');
  }

  if ($('.hero-section').length) {
    // Also animate floats
    $('.hero-float').each(function() {
      gsap.to(this, {
        y: 'random(-25, 25)',
        x: 'random(-20, 20)',
        rotation: 'random(-5, 5)',
        duration: 'random(6, 10)',
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });
    });
  }

  // =============================================
  // FLOATING ELEMENTS
  // =============================================
  $('.faq-float').each(function(i) {
    gsap.to(this, {
      y: i % 2 === 0 ? -18 : 18,
      x: i % 2 === 0 ? 12 : -12,
      rotation: i % 2 === 0 ? 6 : -6,
      duration: 7,
      repeat: -1,
      yoyo: true,
      ease: 'sine.inOut'
    });
  });

  // =============================================
  // COUNTERS
  // =============================================
  $('.stat-number').each(function() {
    const $this = $(this);
    const target = parseInt($this.data('count'));
    if (!target) return;

    ScrollTrigger.create({
      trigger: $this[0],
      start: 'top 85%',
      onEnter: function() {
        gsap.fromTo($this[0], { innerText: 0 }, {
          innerText: target,
          duration: 2.8,
          ease: 'power2.out',
          snap: { innerText: 1 },
          onUpdate: function() {
            $this[0].innerText = Math.round($this[0].innerText).toLocaleString();
          }
        });
      },
      once: true
    });
  });

  // =============================================
  // HORIZONTAL SCROLL SERVICES
  // =============================================
  function initHorizontalScroll() {
    const wrapper = document.querySelector('.horizontal-scroll-wrapper');
    const container = document.querySelector('.horizontal-scroll-content');
    if (!wrapper || !container) return;

    const cards = container.querySelectorAll('.service-card');
    if (!cards.length) return;

    function setupScroll() {
      const cardWidth = cards[0].offsetWidth;
      const gap = 30;
      const totalWidth = (cardWidth + gap) * cards.length - gap;
      const viewportWidth = wrapper.offsetWidth;
      const maxScroll = totalWidth - viewportWidth;

      if (maxScroll < 0) {
        ScrollTrigger.getById('horizontalScroll')?.kill();
        gsap.set(container, { x: 0 });
        return;
      }

      gsap.to(container, {
        x: -maxScroll,
        ease: 'none',
        scrollTrigger: {
          id: 'horizontalScroll',
          trigger: wrapper,
          pin: true,
          start: 'top top',
          end: function() { return '+=' + (totalWidth + viewportWidth * 0.3); },
          scrub: 1.5,
          invalidateOnRefresh: true,
          anticipatePin: 1
        }
      });
    }

    setupScroll();
    $(window).on('resize', function() { ScrollTrigger.refresh(); });
  }
  initHorizontalScroll();

  // =============================================
  // BEFORE/AFTER SLIDER
  // =============================================
  $('.comparison-slider').each(function() {
    const $slider = $(this);
    const $handle = $slider.find('.comparison-handle');
    const $before = $slider.find('.comparison-before');
    let isDragging = false;

    function setPosition(x) {
      const rect = $slider[0].getBoundingClientRect();
      let pos = (x - rect.left) / rect.width;
      pos = Math.max(0.05, Math.min(0.95, pos));
      $before.css('width', (pos * 100) + '%');
      $handle.css('left', (pos * 100) + '%');
    }

    $handle.on('mousedown touchstart', function(e) {
      isDragging = true;
      e.preventDefault();
    });

    $(document).on('mousemove touchmove', function(e) {
      if (!isDragging) return;
      const x = e.type === 'touchmove' ? e.originalEvent.touches[0].clientX : e.clientX;
      setPosition(x);
    });

    $(document).on('mouseup touchend', function() { isDragging = false; });

    $slider.on('click', function(e) {
      if (!isDragging) setPosition(e.clientX);
    });
  });

  // =============================================
  // SWIPER INIT
  // =============================================
  function initSwipers() {
    // Testimonials
    if ($('.testimonial-swiper').length) {
      new Swiper('.testimonial-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        speed: 800,
        pagination: { el: '.swiper-pagination', clickable: true },
        breakpoints: {
          768: { slidesPerView: 2 },
          1200: { slidesPerView: 3 }
        }
      });
    }

    // Social wall
    if ($('.social-swiper').length) {
      new Swiper('.social-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        speed: 700,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        breakpoints: {
          576: { slidesPerView: 2 },
          992: { slidesPerView: 3 },
          1200: { slidesPerView: 4 }
        }
      });
    }
  }
  initSwipers();

  // =============================================
  // SOCIAL VIDEO AUTOPLAY
  // =============================================
  const videos = document.querySelectorAll('.social-card video');
  if (videos.length) {
    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        const video = entry.target;
        if (entry.isIntersecting) { video.play().catch(function() {}); }
        else { video.pause(); }
      });
    }, { threshold: 0.5 });
    videos.forEach(function(v) { observer.observe(v); });
  }

  // =============================================
  // GALLERY FILTERS
  // =============================================
  $('.gallery-filter').on('click', function() {
    const filter = $(this).data('filter');
    $('.gallery-filter').removeClass('active');
    $(this).addClass('active');

    const items = $('.gallery-item');

    if (filter === '*') {
      items.each(function() {
        $(this).parent().show();
        gsap.fromTo(this, { opacity: 0, scale: 0.95 }, { opacity: 1, scale: 1, duration: 0.5, delay: Math.random() * 0.2, ease: 'power2.out' });
      });
    } else {
      items.each(function() {
        if ($(this).data('category') === filter) {
          $(this).parent().show();
          gsap.fromTo(this, { opacity: 0, scale: 0.95 }, { opacity: 1, scale: 1, duration: 0.5, ease: 'power2.out' });
        } else {
          $(this).parent().hide();
        }
      });
    }
  });

  $('.gallery-filter.active').trigger('click');

  // =============================================
  // FANCYBOX
  // =============================================
  $('[data-fancybox]').fancybox({
    buttons: ['zoom', 'slideShow', 'thumbs', 'close'],
    animationEffect: 'zoom-in-out',
    transitionEffect: 'slide',
    infobar: true,
    loop: true
  });

  // =============================================
  // COUNTDOWN
  // =============================================
  $('.countdown').each(function() {
    const $this = $(this);
    const endDate = $this.data('end') || new Date(Date.now() + 7 * 86400000).toISOString();
    const target = new Date(endDate).getTime();

    function update() {
      const diff = target - new Date().getTime();
      if (diff <= 0) { $this.html('<span class="text-gold font-serif fs-4">Offer Expired</span>'); return; }

      $this.find('.countdown-days').text(String(Math.floor(diff / 86400000)).padStart(2, '0'));
      $this.find('.countdown-hours').text(String(Math.floor((diff % 86400000) / 3600000)).padStart(2, '0'));
      $this.find('.countdown-mins').text(String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0'));
      $this.find('.countdown-secs').text(String(Math.floor((diff % 60000) / 1000)).padStart(2, '0'));
    }
    update();
    setInterval(update, 1000);
  });

  // =============================================
  // GSAP SCROLLTRIGGER – SECTION REVEALS
  // =============================================
  function initScrollReveals() {
    // Image zoom reveals
    gsap.utils.toArray('.intro-image img, .faq-image img, .environment-image, .team-card-image img').forEach(function(img) {
      gsap.from(img, {
        scale: 1.2,
        duration: 1.8,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: img,
          start: 'top 80%',
          toggleActions: 'play none none none'
        }
      });
    });

    // Service detail cards
    gsap.utils.toArray('.service-detail-card').forEach(function(card, i) {
      gsap.from(card, {
        y: 70,
        opacity: 0,
        duration: 0.8,
        delay: i * 0.1,
        ease: 'power3.out',
        scrollTrigger: { trigger: card, start: 'top 85%' }
      });
    });

    // Membership cards
    gsap.utils.toArray('.membership-card').forEach(function(card, i) {
      gsap.from(card, {
        y: 60,
        opacity: 0,
        duration: 0.8,
        delay: i * 0.12,
        ease: 'power3.out',
        scrollTrigger: { trigger: card, start: 'top 85%' }
      });
    });

    // Team cards
    gsap.utils.toArray('.team-card').forEach(function(card, i) {
      gsap.from(card, {
        y: 50,
        opacity: 0,
        duration: 0.7,
        delay: i * 0.08,
        ease: 'power2.out',
        scrollTrigger: { trigger: card, start: 'top 85%' }
      });
    });

    // Offer cards
    gsap.utils.toArray('.offer-card').forEach(function(card, i) {
      gsap.from(card, {
        y: 70,
        opacity: 0,
        duration: 0.9,
        delay: i * 0.15,
        ease: 'power3.out',
        scrollTrigger: { trigger: card, start: 'top 85%' }
      });
    });

    // Timeline steps
    gsap.utils.toArray('.process-step').forEach(function(step, i) {
      gsap.from(step, {
        x: -50,
        opacity: 0,
        duration: 0.7,
        delay: i * 0.15,
        ease: 'power2.out',
        scrollTrigger: { trigger: step, start: 'top 85%' }
      });
    });

    // Award items
    gsap.utils.toArray('.award-item').forEach(function(item, i) {
      gsap.from(item, {
        y: 40,
        opacity: 0,
        duration: 0.6,
        delay: i * 0.1,
        ease: 'power2.out',
        scrollTrigger: { trigger: item, start: 'top 85%' }
      });
    });

    // Contact info cards
    gsap.utils.toArray('.contact-info-card').forEach(function(card, i) {
      gsap.from(card, {
        x: -50,
        opacity: 0,
        duration: 0.7,
        delay: i * 0.1,
        ease: 'power3.out',
        scrollTrigger: { trigger: card, start: 'top 85%' }
      });
    });

    // Testimonial cards
    gsap.utils.toArray('.testimonial-card').forEach(function(card, i) {
      gsap.from(card, {
        y: 50,
        opacity: 0,
        duration: 0.6,
        delay: i * 0.05,
        ease: 'power2.out',
        scrollTrigger: { trigger: card, start: 'top 85%' }
      });
    });

    // Intro content
    gsap.utils.toArray('.intro-content .section-tag, .intro-content .section-title, .intro-content .section-subtitle, .intro-content .intro-signature').forEach(function(el, i) {
      gsap.from(el, {
        y: 40,
        opacity: 0,
        duration: 0.7,
        delay: i * 0.12,
        ease: 'power2.out',
        scrollTrigger: { trigger: el, start: 'top 85%' }
      });
    });

    // Section tag & title on dark sections
    gsap.utils.toArray('.before-after-section .section-tag, .before-after-section .section-title, .before-after-section .section-subtitle, .stats-section .stat-item, .social-wall .section-tag, .social-wall .section-title, .offers-section .section-tag, .offers-section .section-title, .awards-section .section-tag, .awards-section .section-title').forEach(function(el) {
      gsap.from(el, {
        y: 40,
        opacity: 0,
        duration: 0.7,
        ease: 'power2.out',
        scrollTrigger: { trigger: el, start: 'top 85%' }
      });
    });
  }
  initScrollReveals();

  // =============================================
  // PARALLAX
  // =============================================
  $('[data-parallax="scroll"]').each(function() {
    const $this = $(this);
    if ($(window).width() < 768) return;

    $(window).on('scroll', function() {
      const scrollTop = $(window).scrollTop();
      const offset = $this.offset().top;
      const windowH = $(window).height();
      if (scrollTop + windowH > offset && scrollTop < offset + $this.outerHeight()) {
        $this.css('backgroundPosition', 'center ' + ((scrollTop - offset) * 0.3 + 50) + '%');
      }
    });
  });

  // =============================================
  // CONTACT FORM
  // =============================================
  $('#contactForm').on('submit', function(e) {
    e.preventDefault();
    const $form = $(this);
    const $btn = $form.find('[type="submit"]');
    const original = $btn.text();

    // Simple client validation
    const name = $form.find('#name').val().trim();
    const email = $form.find('#email').val().trim();
    const message = $form.find('#message').val().trim();

    if (!name || !email || !message) {
      alert('Please fill in all required fields.');
      return;
    }

    $btn.prop('disabled', true).text('Sending...');

    $.ajax({
      url: $form.attr('action'),
      method: 'POST',
      data: $form.serialize(),
      dataType: 'json',
      success: function(resp) {
        if (resp.success) {
          $form.html('<div class="alert alert-success text-center py-5"><i class="fas fa-check-circle fa-3x mb-3" style="color:var(--gold)"></i><h4 class="font-serif">Thank You</h4><p class="mb-0">' + resp.message + '</p></div>');
        } else {
          alert(resp.message || 'Something went wrong.');
          $btn.prop('disabled', false).text(original);
        }
      },
      error: function() {
        alert('Unable to send. Please call us directly.');
        $btn.prop('disabled', false).text(original);
      }
    });
  });

  // =============================================
  // REFRESH ON RESIZE
  // =============================================
  let resizeTimer;
  $(window).on('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
      ScrollTrigger.refresh();
      AOS.refresh();
    }, 300);
  });

  setTimeout(function() { ScrollTrigger.refresh(); }, 3000);

})(jQuery);

$.easing.easeInOutCubic = function(x) {
  return x < 0.5 ? 4 * x * x * x : 1 - Math.pow(-2 * x + 2, 3) / 2;
};
