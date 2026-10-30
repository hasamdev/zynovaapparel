/**
 * Zynova Apparel Theme Interactive Scripts
 * Handles Hero Slider, Mega Menu, Mobile Drawer, and Quote Modal
 */

(function ($) {
  'use strict';

  $(document).ready(function () {
    /* ======================================================================
       1. STICKY HEADER SCROLL STATE
       ====================================================================== */
    var $header = $('#masthead');
    $(window).on('scroll', function () {
      if ($(window).scrollTop() > 30) {
        $header.addClass('is-scrolled');
      } else {
        $header.removeClass('is-scrolled');
      }
    });

    /* ======================================================================
       2. HERO SLIDER AUTO-ROTATION & CONTROLS
       ====================================================================== */
    var $slider = $('#za-hero-slider');
    var $slides = $slider.find('.za-slide');
    var $dots = $('#za-slider-dots .za-slider-dot');
    var currentSlide = 0;
    var totalSlides = $slides.length;
    var slideInterval;

    function goToSlide(index) {
      if (index >= totalSlides) {
        index = 0;
      } else if (index < 0) {
        index = totalSlides - 1;
      }
      currentSlide = index;

      $slides.removeClass('is-active').eq(currentSlide).addClass('is-active');
      $dots.removeClass('is-active').eq(currentSlide).addClass('is-active');
    }

    function startAutoSlide() {
      stopAutoSlide();
      slideInterval = setInterval(function () {
        goToSlide(currentSlide + 1);
      }, 6000);
    }

    function stopAutoSlide() {
      if (slideInterval) {
        clearInterval(slideInterval);
      }
    }

    if (totalSlides > 1) {
      $('#za-slide-next').on('click', function () {
        goToSlide(currentSlide + 1);
        startAutoSlide();
      });

      $('#za-slide-prev').on('click', function () {
        goToSlide(currentSlide - 1);
        startAutoSlide();
      });

      $dots.on('click', function () {
        var idx = parseInt($(this).data('slide'), 10);
        goToSlide(idx);
        startAutoSlide();
      });

      $slider.hover(stopAutoSlide, startAutoSlide);
      startAutoSlide();
    }

    /* ======================================================================
       3. MOBILE NAVIGATION ACCORDION & DRAWER + ADAPTIVE PRIORITY NAVIGATION
       ====================================================================== */
    var $mobileTrigger = $('.za-mobile-menu-trigger');
    var $mobileDrawer = $('#mobile-navigation');
    var $drawerClose = $('.za-mobile-drawer-close');

    $mobileTrigger.on('click', function () {
      var isExpanded = $(this).attr('aria-expanded') === 'true';
      $(this).attr('aria-expanded', !isExpanded);
      $mobileDrawer.toggleClass('is-open', !isExpanded);
      $('body').toggleClass('za-menu-locked', !isExpanded);
    });

    $drawerClose.on('click', function () {
      $mobileTrigger.attr('aria-expanded', 'false');
      $mobileDrawer.removeClass('is-open');
      $('body').removeClass('za-menu-locked');
    });

    // Close drawer when clicking outside
    $(document).on('click', function (e) {
      if ($mobileDrawer.hasClass('is-open') && !$(e.target).closest('#mobile-navigation, .za-mobile-menu-trigger').length) {
        $mobileTrigger.attr('aria-expanded', 'false');
        $mobileDrawer.removeClass('is-open');
        $('body').removeClass('za-menu-locked');
      }
    });

    // Submenu Accordion in Mobile
    $('.za-mobile-toggle-btn').on('click', function (e) {
      e.preventDefault();
      var $parent = $(this).closest('.za-mobile-nav-item');
      $parent.toggleClass('is-expanded');
    });

    /* --- Adaptive Header Priority Navigation --- */
    function zaUpdateAdaptiveHeader() {
      var $header = $('#masthead');
      var $container = $header.find('.za-header-container');
      var $brand = $header.find('.za-brand-wrap');
      var $nav = $('#site-navigation');
      var $navList = $nav.find('.za-nav-list');
      var $items = $navList.children('.za-nav-item');
      var $actions = $header.find('.za-header-actions');
      var $trigger = $actions.find('.za-mobile-menu-trigger');
      var $drawer = $('#mobile-navigation');
      var $banner = $drawer.find('.za-drawer-adaptive-banner');
      var $drawerItems = $drawer.find('.za-mobile-nav-item');

      if (!$container.length || !$items.length) {
        return;
      }

      var windowWidth = $(window).width();

      // For tablet/mobile screens (<= 992px), standard mobile navigation
      if (windowWidth <= 992) {
        $nav.hide();
        $trigger.css('display', 'inline-flex');
        $header.addClass('is-mobile-nav').removeClass('has-adaptive-nav');
        $items.removeClass('is-extra-hidden').css('display', '');
        $drawerItems.show().removeClass('is-priority-extra is-priority-dimmed');
        $banner.hide();
        return;
      }

      // On desktop screens (> 992px):
      $header.removeClass('is-mobile-nav');
      $nav.show();

      // Temporarily ensure all items are visible to measure their natural widths accurately
      $items.removeClass('is-extra-hidden').css('display', '');
      $trigger.hide();

      var containerWidth = $container.innerWidth() || $container.width();
      var brandWidth = $brand.outerWidth(true) || 0;

      // Sum visible actions excluding the hamburger trigger
      var actionsWidth = 0;
      $actions.children().not('.za-mobile-menu-trigger').each(function () {
        if ($(this).is(':visible')) {
          actionsWidth += $(this).outerWidth(true);
        }
      });

      var triggerReservedWidth = 48; // reserved width for hamburger trigger + spacing
      var safetyGap = 24; // safety margin to prevent any possibility of line wrap or overflow

      var availableWidthForNav = containerWidth - brandWidth - actionsWidth - safetyGap;

      // Calculate width of each top-level nav item
      var totalItemsWidth = 0;
      var itemWidths = [];
      $items.each(function () {
        var w = $(this).outerWidth(true);
        itemWidths.push(w);
        totalItemsWidth += w;
      });

      // Check if all items fit comfortably
      if (totalItemsWidth <= availableWidthForNav) {
        // Everything fits! Hamburger is hidden
        $trigger.hide();
        $header.removeClass('has-adaptive-nav');
        $items.removeClass('is-extra-hidden').css('display', '');
        $drawerItems.show().removeClass('is-priority-extra is-priority-dimmed');
        $banner.hide();
      } else {
        // Extra items need to move inside the hamburger!
        var availableWithTrigger = availableWidthForNav - triggerReservedWidth;
        $trigger.css('display', 'inline-flex');
        $header.addClass('has-adaptive-nav');

        var currentAccumulatedWidth = 0;
        var extraKeys = [];
        var extraCount = 0;

        $items.each(function (idx) {
          currentAccumulatedWidth += itemWidths[idx];
          // Keep at least the first item (Home), hide subsequent items that exceed available space
          if (idx > 0 && currentAccumulatedWidth > availableWithTrigger) {
            $(this).addClass('is-extra-hidden').css('display', 'none');
            var key = $(this).data('nav-key');
            if (key) {
              extraKeys.push(key);
            }
            extraCount++;
          } else {
            $(this).removeClass('is-extra-hidden').css('display', '');
          }
        });

        // Update drawer items: highlight the extra items that were moved into hamburger
        if (extraCount > 0) {
          $banner.show();
          $drawerItems.each(function () {
            var key = $(this).data('nav-key');
            if (extraKeys.indexOf(key) !== -1) {
              $(this).addClass('is-priority-extra').removeClass('is-priority-dimmed').show();
            } else {
              $(this).removeClass('is-priority-extra').addClass('is-priority-dimmed').show();
            }
          });
        } else {
          $banner.hide();
          $drawerItems.removeClass('is-priority-extra is-priority-dimmed').show();
        }
      }
    }

    // Run adaptive header on DOM ready, window load, and debounced resize
    zaUpdateAdaptiveHeader();
    $(window).on('load', zaUpdateAdaptiveHeader);

    var zaHeaderResizeTimer;
    $(window).on('resize orientationchange', function () {
      clearTimeout(zaHeaderResizeTimer);
      zaHeaderResizeTimer = setTimeout(zaUpdateAdaptiveHeader, 50);
    });

    /* ======================================================================
       4. REQUEST A QUOTE MODAL & AJAX FORM
       ====================================================================== */
    var $modal = $('#za-quote-modal');
    var $modalClose = $('.za-modal-close');

    // Open Modal Triggers
    $(document).on('click', '.za-open-quote-modal', function (e) {
      e.preventDefault();
      $modal.addClass('is-open').attr('aria-hidden', 'false');
      $('body').addClass('za-modal-locked');

      // Pre-fill Category if clicked from specific category
      var preCat = $(this).data('category');
      if (preCat && $('#za_quote_category').length) {
        $('#za_quote_category').val(preCat);
      }
    });

    // Close Modal
    function closeModal() {
      $modal.removeClass('is-open').attr('aria-hidden', 'true');
      $('body').removeClass('za-modal-locked');
    }

    $modalClose.on('click', closeModal);

    $modal.on('click', function (e) {
      if ($(e.target).is($modal)) {
        closeModal();
      }
    });

    $(document).on('keydown', function (e) {
      if (e.key === 'Escape' && $modal.hasClass('is-open')) {
        closeModal();
      }
    });

    // AJAX Submission
    function handleQuoteSubmit($form) {
      var $response = $form.find('.za-form-response');
      var $submitBtn = $form.find('button[type="submit"]');
      var originalBtnHtml = $submitBtn.html();

      $response.removeClass('is-success is-error').text('');
      $submitBtn.prop('disabled', true).html('<span>Sending inquiry...</span>');

      var formData = $form.serialize();

      $.ajax({
        url: zynovaData.ajaxurl,
        type: 'POST',
        data: formData,
        success: function (res) {
          $submitBtn.prop('disabled', false).html(originalBtnHtml);
          if (res.success) {
            $response.addClass('is-success').text(res.data.message);
            $form[0].reset();
            setTimeout(function () {
              if ($modal.hasClass('is-open')) {
                closeModal();
                $response.text('').removeClass('is-success');
              }
            }, 3500);
          } else {
            $response.addClass('is-error').text(res.data ? res.data.message : 'An error occurred. Please try again.');
          }
        },
        error: function () {
          $submitBtn.prop('disabled', false).html(originalBtnHtml);
          $response.addClass('is-error').text('Network error. Please try again or email us directly.');
        }
      });
    }

    $('#za-quote-form').on('submit', function (e) {
      e.preventDefault();
      handleQuoteSubmit($(this));
    });

    $('#za-page-contact-form').on('submit', function (e) {
      e.preventDefault();
      handleQuoteSubmit($(this));
    });

    /* ======================================================================
       5. SINGLE PRODUCT PAGE INTERACTIONS: ZOOM, LIGHTBOX & VARIATIONS
       ====================================================================== */
    var $mainImgBox = $('#za-main-img-box');
    var $activeImg = $('#za-active-product-img');
    var $lightbox = $('#za-image-lightbox');
    var $lightboxImg = $('#za-lightbox-img');
    var galleryData = [];
    var currentImgIndex = 0;

    // Load gallery data if present
    var $galleryJsonEl = $('#za-gallery-json');
    if ($galleryJsonEl.length) {
      try {
        galleryData = JSON.parse($galleryJsonEl.attr('data-gallery') || '[]');
      } catch (err) {
        galleryData = [];
      }
    }

    // 1. Interactive Hover Zoom on Main Image Box
    $mainImgBox.on('mousemove', function (e) {
      var offset = $(this).offset();
      var width = $(this).width();
      var height = $(this).height();
      if (!width || !height) return;

      var x = ((e.pageX - offset.left) / width) * 100;
      var y = ((e.pageY - offset.top) / height) * 100;

      x = Math.max(0, Math.min(100, x));
      y = Math.max(0, Math.min(100, y));

      $activeImg.css({
        'transform-origin': x + '% ' + y + '%',
        'transform': 'scale(1.65)'
      });
    }).on('mouseleave', function () {
      $activeImg.css({
        'transform-origin': 'center center',
        'transform': 'scale(1)'
      });
    });

    // Helper: update active product image and sync lightbox
    function setActiveImage(index, url) {
      currentImgIndex = index;
      var targetUrl = url;
      if (!targetUrl && galleryData[index]) {
        targetUrl = galleryData[index].url;
      }
      if (targetUrl) {
        $activeImg.attr('src', targetUrl);
        $lightboxImg.attr('src', targetUrl);
      }
      $mainImgBox.attr('data-active-index', currentImgIndex);

      // Sync active state on thumbnails
      $('.za-thumb-btn').removeClass('is-active').filter(function () {
        return parseInt($(this).data('index'), 10) === currentImgIndex || $(this).data('full-url') === targetUrl;
      }).addClass('is-active');
    }

    // 2. Click to Enlarge / Lightbox Functionality
    $mainImgBox.on('click', function (e) {
      e.preventDefault();
      var currentSrc = $activeImg.attr('src');
      $lightboxImg.attr('src', currentSrc);
      $lightbox.addClass('is-open').attr('aria-hidden', 'false');
      $('body').addClass('za-lightbox-locked');
    });

    function closeLightbox() {
      $lightbox.removeClass('is-open').attr('aria-hidden', 'true');
      $('body').removeClass('za-lightbox-locked');
    }

    $lightbox.on('click', '.za-lightbox-close, .za-lightbox-backdrop', function (e) {
      e.preventDefault();
      closeLightbox();
    });

    // Lightbox Previous / Next Navigation
    function prevLightboxImage() {
      if (galleryData.length <= 1) return;
      var newIndex = (currentImgIndex - 1 + galleryData.length) % galleryData.length;
      setActiveImage(newIndex);
    }

    function nextLightboxImage() {
      if (galleryData.length <= 1) return;
      var newIndex = (currentImgIndex + 1) % galleryData.length;
      setActiveImage(newIndex);
    }

    $lightbox.on('click', '.za-lightbox-prev', function (e) {
      e.preventDefault();
      prevLightboxImage();
    });

    $lightbox.on('click', '.za-lightbox-next', function (e) {
      e.preventDefault();
      nextLightboxImage();
    });

    // Keyboard support for Lightbox
    $(document).on('keydown', function (e) {
      if ($lightbox.hasClass('is-open')) {
        if (e.key === 'Escape') {
          closeLightbox();
        } else if (e.key === 'ArrowLeft') {
          prevLightboxImage();
        } else if (e.key === 'ArrowRight') {
          nextLightboxImage();
        }
      }
    });

    // Gallery Thumbnail Click
    $(document).on('click', '.za-thumb-btn', function (e) {
      e.preventDefault();
      var idx = parseInt($(this).data('index'), 10);
      if (isNaN(idx)) idx = $(this).index();
      var fullUrl = $(this).data('full-url');
      setActiveImage(idx, fullUrl);
    });

    // Style Variant Dropdown Sync with Gallery
    $('#za_select_style').on('change', function () {
      var selectedImg = $(this).find('option:selected').data('img');
      if (selectedImg && $('#za-active-product-img').length) {
        $('#za-active-product-img').attr('src', selectedImg);
        // Also highlight matching thumbnail if found
        $('.za-thumb-btn').removeClass('is-active').filter(function () {
          return $(this).data('full-url') === selectedImg;
        }).addClass('is-active');
      }
    });

    // Product Detail Tabs Switcher
    $(document).on('click', '.za-tab-nav-btn', function (e) {
      e.preventDefault();
      var targetTab = $(this).data('tab');

      $('.za-tab-nav-btn').removeClass('is-active').attr('aria-selected', 'false');
      $(this).addClass('is-active').attr('aria-selected', 'true');

      $('.za-tab-panel').removeClass('is-active');
      $('#' + targetTab).addClass('is-active');
    });

    // Write a Review link opens review tab
    $('#za-trigger-review-tab').on('click', function (e) {
      e.preventDefault();
      $('.za-tab-nav-btn[data-tab="tab-reviews"]').trigger('click');
      $('html, body').animate({
        scrollTop: $('.za-product-tabs-section').offset().top - 90
      }, 500);
    });

    // GET PRICE ON EMAIL - Open Quote Modal with Pre-filled Details
    $('#za-btn-get-email').on('click', function (e) {
      e.preventDefault();
      var prodTitle = $(this).data('product-title') || $('h1.za-p-title').text();
      var material = $('#za_select_material').val() || 'Standard Spec';
      var style = $('#za_select_style').val() || '';
      var size = $('#za_select_size').val() || 'Standard Size';

      var details = 'Inquiry for Product: ' + prodTitle + '\n' +
        'Selected Options:\n' +
        (material ? '- Material/Leather: ' + material + '\n' : '') +
        (style ? '- Style Variant: ' + style + '\n' : '') +
        (size ? '- Size: ' + size + '\n' : '') +
        'Product URL: ' + window.location.href + '\n\n' +
        'Please provide factory wholesale pricing, turnaround time, and MOQ requirements.';

      $('#za_quote_message').val(details);

      // Preselect category if available
      var firstCat = $('.za-p-breadcrumbs a').eq(1).text();
      if (firstCat && $('#za_quote_category').length) {
        $('#za_quote_category').val(firstCat);
      }

      $modal.addClass('is-open').attr('aria-hidden', 'false');
      $('body').addClass('za-modal-locked');
    });

    // GET PRICE ON WHATSAPP - Direct WhatsApp Chat
    $('#za-btn-get-whatsapp').on('click', function (e) {
      e.preventDefault();
      var prodTitle = $(this).data('product-title') || $('h1.za-p-title').text();
      var phone = $(this).data('phone') || '923001234567';
      var material = $('#za_select_material').val() || '';
      var style = $('#za_select_style').val() || '';
      var size = $('#za_select_size').val() || '';

      var msg = 'Hello Zynova Apparel,\nI would like to get factory price quotation for:\n' +
        '*' + prodTitle + '*\n' +
        (material ? '• Material: ' + material + '\n' : '') +
        (style ? '• Style: ' + style + '\n' : '') +
        (size ? '• Size: ' + size + '\n' : '') +
        'Link: ' + window.location.href + '\n\n' +
        'Please share wholesale pricing and order details.';

      var waUrl = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(msg);
      window.open(waUrl, '_blank');
    });
  });
})(jQuery);


