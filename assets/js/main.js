/**
 * MAIN.JS — Manthan Clinic | Premium Healthcare Website
 * Custom JavaScript for animations, interactions, and UI enhancements
 */

'use strict';

(function ($) {



  /* ==========================================================
     1. DOM READY
     ========================================================== */
  $(document).ready(function () {

    initAOS();
    initHeaderScroll();
    initCounters();
    initLightbox();
    initBackToTop();
    initGalleryFilter();
    initSmoothScroll();
    initTestimonialControls();
    initFormValidation();
    initContactForm();
    initReviewGrid();
    initFaqAccordion();
    initFloatingParticles();
    initMicroInteractions();
    initParallax();
    initMouseParallax();
    initServicesParallax();
    initParallaxBg();
    initMagneticButton();

  });

  /* ==========================================================
     2. AOS (ANIMATE ON SCROLL) INITIALIZATION
     ========================================================== */
  function initAOS() {
    if (typeof AOS !== 'undefined') {
      AOS.init({
        duration: 600,
        once: true,
        offset: 80,
        easing: 'ease-out-cubic',
      });
    }
  }

  /* ==========================================================
     3. HEADER SCROLL EFFECT
     ========================================================== */
  function initHeaderScroll() {
    var $header = $('#siteHeader');
    var scrollThreshold = 60;

    if (!$header.length) return;

    // Check initial scroll position
    checkHeaderScroll($header, scrollThreshold);

    // Throttled scroll handler
    var ticking = false;
    $(window).on('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(function () {
          checkHeaderScroll($header, scrollThreshold);
          ticking = false;
        });
        ticking = true;
      }
    });
  }

  function checkHeaderScroll($header, threshold) {
    var scrollY = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollY > threshold) {
      $header.addClass('scrolled');
    } else {
      $header.removeClass('scrolled');
    }
  }

  /* ==========================================================
     4. COUNTER ANIMATION
     ========================================================== */
  function initCounters() {
    var counters = document.querySelectorAll('.counter');

    if (!counters.length) return;

    var hasAnimated = new WeakMap();

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var el = entry.target;
          if (hasAnimated.get(el)) return;
          hasAnimated.set(el, true);

          animateCounter(el);
          observer.unobserve(el);
        }
      });
    }, { threshold: 0.5 });

    counters.forEach(function (el) {
      observer.observe(el);
    });
  }

  function animateCounter(el) {
    var target = parseInt(el.getAttribute('data-target'), 10);
    if (isNaN(target)) return;

    var suffix = el.getAttribute('data-suffix') || '';
    var duration = Math.min(2000, target * 15 + 500);
    var startTime = null;

    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      var progress = Math.min((timestamp - startTime) / duration, 1);
      // Ease-out quad
      var eased = 1 - (1 - progress) * (1 - progress);
      var current = Math.floor(eased * target);

      el.textContent = current.toLocaleString() + suffix;

      if (progress < 1) {
        window.requestAnimationFrame(step);
      } else {
        el.textContent = target.toLocaleString() + suffix;
      }
    }

    window.requestAnimationFrame(step);
  }

  /* ==========================================================
     5. GLIGHTBOX (GALLERY LIGHTBOX)
     ========================================================== */
  function initLightbox() {
    if (typeof GLightbox !== 'undefined') {
      GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        zoomable: true,
        draggable: true
      });
    }
  }

  /* ==========================================================
     6. BACK TO TOP BUTTON
     ========================================================== */
  function initBackToTop() {
    var $btn = $('#backToTop');

    if (!$btn.length) return;

    $(window).on('scroll', function () {
      if ($(this).scrollTop() > 400) {
        $btn.addClass('show');
      } else {
        $btn.removeClass('show');
      }
    });

    $btn.on('click', function () {
      $('html, body').animate({ scrollTop: 0 }, 500, 'swing');
    });
  }

  /* ==========================================================
      7. GALLERY FILTER — Premium Animated
      ========================================================== */
  function initGalleryFilter() {
    var $filterBtns = $('.filter-btn');
    var $items = $('.gallery-filter-item');

    if (!$filterBtns.length || !$items.length) return;

    $filterBtns.on('click', function () {
      var $btn = $(this);
      var filter = $btn.data('filter') || 'all';

      $filterBtns.removeClass('active');
      $btn.addClass('active');

      $items.each(function (i) {
        var $item = $(this);
        var cat = $item.data('category') || '';
        var matches = filter === 'all' || cat === filter;

        if (matches) {
          $item.removeClass('hidden').addClass('visible');
          $item.css({
            'animation-delay': (i * 0.04) + 's',
            'position': '',
            'width': '',
            'height': '',
            'overflow': '',
            'margin': ''
          });
        } else {
          $item.removeClass('visible').addClass('hidden');
        }
      });

      // Re-layout masonry after filter
      setTimeout(function () { $(window).trigger('resize'); }, 600);
    });
  }

  /* ==========================================================
     8. SMOOTH SCROLL FOR ANCHOR LINKS
     ========================================================== */
  function initSmoothScroll() {
    $(document).on('click', 'a[href^="#"]', function (e) {
      var href = $(this).attr('href');
      if (href === '#') return;

      var $target = $(href);
      if (!$target.length) return;

      e.preventDefault();
      var headerOffset = 80;
      var targetTop = $target.offset().top - headerOffset;

      $('html, body').animate({
        scrollTop: targetTop
      }, 600, 'swing');
    });
  }

  /* ==========================================================
      9. TESTIMONIAL — PREMIUM SLIDING CAROUSEL
      ========================================================== */
  function initTestimonialControls() {
    var $track = $('#testimonialTrack');
    if (!$track.length) return;

    var $wrapper = $track.closest('.testimonial-track-wrapper');
    var $slides = $track.find('.testimonial-slide');
    var $prevBtn = $('.testimonial-prev');
    var $nextBtn = $('.testimonial-next');
    var $dots = $('.testimonial-dot');

    var slideCount = $slides.length;
    var visibleCount = 3;
    var maxIndex = Math.max(0, slideCount - visibleCount);
    var currentIndex = 0;
    var autoplayTimer = null;
    var progressTimer = null;
    var autoplayInterval = 5000;
    var isPaused = false;

    function getSlideWidth() {
      var $first = $slides.first();
      var outerW = $first.outerWidth(true);
      return outerW || 0;
    }

    function updateDots() {
      $dots.each(function (i) {
        $(this).toggleClass('active', i === currentIndex);
      });
    }

    function goToSlide(index) {
      if (index < 0) index = maxIndex;
      if (index > maxIndex) index = 0;
      currentIndex = index;

      var slideWidth = getSlideWidth();
      if (slideWidth <= 0) return;

      var offset = -currentIndex * slideWidth;
      $track.css('transform', 'translateX(' + offset + 'px)');

      // Update active class
      $slides.removeClass('active');
      $slides.each(function (i) {
        if (i >= currentIndex && i < currentIndex + visibleCount) {
          $(this).addClass('active');
        }
      });

      updateDots();
    }

    function nextSlide() {
      goToSlide(currentIndex + 1);
    }

    function prevSlide() {
      goToSlide(currentIndex - 1);
    }

    function startAutoplay() {
      stopAutoplay();
      if (maxIndex <= 0) return;
      autoplayTimer = setTimeout(function tick() {
        if (!isPaused) {
          if (currentIndex >= maxIndex) {
            goToSlide(0);
          } else {
            nextSlide();
          }
        }
        autoplayTimer = setTimeout(tick, autoplayInterval);
      }, autoplayInterval);
    }

    function stopAutoplay() {
      if (autoplayTimer) {
        clearTimeout(autoplayTimer);
        autoplayTimer = null;
      }
      if (progressTimer) {
        clearInterval(progressTimer);
        progressTimer = null;
      }
    }

    // Prev/next buttons
    $prevBtn.on('click', function () {
      isPaused = true;
      prevSlide();
      setTimeout(function () { isPaused = false; }, autoplayInterval);
    });

    $nextBtn.on('click', function () {
      isPaused = true;
      nextSlide();
      setTimeout(function () { isPaused = false; }, autoplayInterval);
    });

    // Dot navigation
    $dots.on('click', function () {
      var idx = parseInt($(this).data('slide'), 10);
      if (!isNaN(idx)) {
        isPaused = true;
        goToSlide(idx);
        setTimeout(function () { isPaused = false; }, autoplayInterval);
      }
    });

    // Pause on hover
    $wrapper.on('mouseenter', function () {
      isPaused = true;
      $wrapper.addClass('paused');
    }).on('mouseleave', function () {
      isPaused = false;
      $wrapper.removeClass('paused');
    });

    // Handle resize
    var resizeTimer;
    $(window).on('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        goToSlide(currentIndex);
      }, 150);
    });

    // Init
    if (maxIndex > 0) {
      $dots.show();
    } else {
      $dots.hide();
    }

    goToSlide(0);
    startAutoplay();
  }

  /* ==========================================================
      9b. REVIEW GRID STAGGER (Testimonials Page)
      ========================================================== */
  function initReviewGrid() {
    var $cols = $('#reviewsGrid .review-col');
    if (!$cols.length) return;

    $cols.each(function (i) {
      var $el = $(this);
      $el.css({
        'opacity': '0',
        'transform': 'translateY(30px)',
        'transition': 'opacity 0.5s ease ' + (i * 0.08) + 's, transform 0.5s ease ' + (i * 0.08) + 's'
      });

      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            $el.css({ 'opacity': '1', 'transform': 'translateY(0)' });
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.15 });

      observer.observe($el[0]);
    });
  }

  /* ==========================================================
      9c. FAQ CUSTOM ACCORDION
      ========================================================== */
  function initFaqAccordion() {
    $('#faqList').on('click', '.faq-question', function () {
      var $item = $(this).closest('.faq-item');
      var $list = $item.closest('.faq-list');

      // Close others (accordion behavior: only one open)
      if ($item.hasClass('active')) {
        $item.removeClass('active');
      } else {
        $list.find('.faq-item.active').removeClass('active');
        $item.addClass('active');
      }
    });
  }

  /* ==========================================================
      10. FORM VALIDATION (Bootstrap 5)
     ========================================================== */
  function initFormValidation() {
    var forms = document.querySelectorAll('.needs-validation');

    if (!forms.length) return;

    Array.prototype.slice.call(forms).forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }

  /* ==========================================================
     11. CONTACT FORM AJAX HANDLER
     ========================================================== */
  function initContactForm() {
    var $form = $('.contact-form');

    $form.on('submit', function (e) {
      var actionUrl = $(this).attr('action') || '';
      if (actionUrl.indexOf('contact_process.php') === -1) return;

      e.preventDefault();

      if (!this.checkValidity()) {
        $(this).addClass('was-validated');
        return;
      }

      var $btn = $(this).find('button[type="submit"]');
      var originalText = $btn.html();

      $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Sending...');

      $.ajax({
        url: actionUrl,
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            $form[0].reset();
            $form.removeClass('was-validated');
            showFormMessage($form, 'success', response.message);
          } else {
            showFormMessage($form, 'danger', response.message);
          }
        },
        error: function (xhr) {
          var msg = 'An error occurred. Please try again later.';
          try {
            var resp = JSON.parse(xhr.responseText);
            if (resp.message) msg = resp.message;
          } catch (e) {}
          showFormMessage($form, 'danger', msg);
        },
        complete: function () {
          $btn.prop('disabled', false).html(originalText);
        }
      });
    });
  }

  function showFormMessage($form, type, text) {
    var $existing = $form.find('.alert-form');
    if ($existing.length) $existing.remove();

    var $msg = $('<div class="alert alert-form alert-' + type + ' mt-3">' + text + '</div>');
    $form.append($msg);

    setTimeout(function () {
      $msg.fadeOut(300, function () { $(this).remove(); });
    }, 6000);
  }

  /* ==========================================================
      12. WHATSAPP FLOATING TOOLTIP
      ========================================================== */
  // Handled via CSS :hover

  /* ==========================================================
     13. FLOATING PARTICLES — Global Background Motion
     ========================================================== */
  function initFloatingParticles() {
    if (window.innerWidth < 768) return;

    var symbols = ['♰', '+', '✦', '◇', '○'];
    var body = document.body;

    for (var i = 0; i < 8; i++) {
      var particle = document.createElement('div');
      particle.className = 'floating-medical-icon';
      particle.textContent = symbols[i % symbols.length];
      particle.style.left = (5 + Math.random() * 90) + '%';
      particle.style.top = (5 + Math.random() * 90) + '%';
      particle.style.fontSize = (1 + Math.random() * 1.5) + 'rem';
      particle.style.animationDuration = (18 + Math.random() * 12) + 's';
      particle.style.animationDelay = (Math.random() * -20) + 's';
      particle.style.opacity = 0.02 + Math.random() * 0.03;
      body.appendChild(particle);
    }
  }

  /* ==========================================================
     14. MICRO INTERACTIONS — Subtle hover motion
     ========================================================== */
  function initMicroInteractions() {
    // Button tilt on hover
    $('.btn-primary-custom, .btn-outline-custom, .btn-whatsapp-custom, .header-btn').each(function () {
      var $btn = $(this);
      if ($btn.closest('.hero-actions').length) return; // hero buttons handled differently

      $btn.on('mouseenter', function (e) {
        var rect = this.getBoundingClientRect();
        var x = e.clientX - rect.left;
        var y = e.clientY - rect.top;
        var centerX = rect.width / 2;
        var centerY = rect.height / 2;
        var rotateX = ((y - centerY) / centerY) * -3;
        var rotateY = ((x - centerX) / centerX) * 3;
        $(this).css('transform', 'perspective(400px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) translateY(-2px)');
      }).on('mouseleave', function () {
        $(this).css('transform', '');
      });
    });

    // Service card tilt
    $('.service-card, .service-detail-card, .feature-box, .review-card').each(function () {
      $(this).on('mouseenter', function (e) {
        var rect = this.getBoundingClientRect();
        var x = e.clientX - rect.left;
        var y = e.clientY - rect.top;
        var centerX = rect.width / 2;
        var centerY = rect.height / 2;
        var rotateX = ((y - centerY) / centerY) * -2;
        var rotateY = ((x - centerX) / centerX) * 2;
        $(this).css('transform', 'perspective(600px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) translateY(-4px)');
      }).on('mouseleave', function () {
        $(this).css('transform', '');
      });
    });
  }

  /* ==========================================================
     15. PARALLAX ON SCROLL — Hero image
     ========================================================== */
  function initParallax() {
    var $heroImages = $('.hero-image-wrapper img, .about-image-wrapper img, .faq-image-main img');
    if (!$heroImages.length) return;

    $(window).on('scroll', function () {
      var scrollY = window.pageYOffset || document.documentElement.scrollTop;
      $heroImages.each(function () {
        var $img = $(this);
        var offset = $img.offset().top;
        var windowH = window.innerHeight;
        if (scrollY + windowH > offset && scrollY < offset + windowH) {
          var speed = 0.08;
          var yPos = (scrollY - offset + windowH) * speed;
          $img.css('transform', 'translate3d(0, ' + yPos + 'px, 0)');
        }
      });
    });
  }

  /* ==========================================================
     16. MOUSE PARALLAX — Hero glow
     ========================================================== */
  function initMouseParallax() {
    var $heroGlow = $('.hero-glow-pulse');
    if (!$heroGlow.length) return;

    $(document).on('mousemove', function (e) {
      var xPos = (e.clientX / window.innerWidth - 0.5) * 20;
      var yPos = (e.clientY / window.innerHeight - 0.5) * 20;
      $heroGlow.css('transform', 'translate(' + xPos + 'px, ' + yPos + 'px)');
    });
  }

  /* ==========================================================
     17. SERVICES PARALLAX — Scroll depth effect
     ========================================================== */
  function initServicesParallax() {
    var $cards = $('.service-scroll-card');
    if (!$cards.length) return;

    var ticking = false;

    $(window).on('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(function () {
          var scrollY = window.pageYOffset || document.documentElement.scrollTop;
          var windowH = window.innerHeight;

          $cards.each(function () {
            var $card = $(this);
            var rect = this.getBoundingClientRect();
            var center = rect.top + rect.height / 2;
            var viewportCenter = windowH / 2;
            var distance = (center - viewportCenter) / windowH;
            var translateY = distance * -30;
            var rotateX = distance * -2;
            $card.css('transform', 'translate3d(0, ' + translateY + 'px, 0) rotateX(' + rotateX + 'deg)');
          });

          ticking = false;
        });
        ticking = true;
      }
    });
  }

  /* ==========================================================
     18. PARALLAX HIGHLIGHT — Background scroll effect
     ========================================================== */
  function initParallaxBg() {
    var $bgWrap = $('#parallaxBg');
    if (!$bgWrap.length) return;

    var ticking = false;
    var windowH = window.innerHeight;

    $(window).on('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(function () {
          var scrollY = window.pageYOffset || document.documentElement.scrollTop;
          var sectionTop = $bgWrap.closest('.services-parallax').offset().top;
          var sectionH = $bgWrap.closest('.services-parallax').outerHeight();
          var scrollProgress = (scrollY - sectionTop + windowH) / (sectionH + windowH);
          var offset = (scrollProgress - 0.5) * 60;
          $bgWrap.css('transform', 'translate3d(0, ' + offset + 'px, 0)');
          ticking = false;
        });
        ticking = true;
      }
    });
  }

  /* ==========================================================
     19. MAGNETIC BUTTON — CTA hover attraction
     ========================================================== */
  function initMagneticButton() {
    var $btn = $('#exploreServicesBtn');
    if (!$btn.length) return;

    $btn.on('mousemove', function (e) {
      var rect = this.getBoundingClientRect();
      var x = e.clientX - rect.left - rect.width / 2;
      var y = e.clientY - rect.top - rect.height / 2;
      var strength = 8;
      $(this).css('transform',
        'translate3d(' + (x / rect.width) * strength + 'px, ' + (y / rect.height) * strength + 'px, 0)'
      );
    });

    $btn.on('mouseleave', function () {
      $(this).css('transform', '');
    });
  }

})(jQuery);
