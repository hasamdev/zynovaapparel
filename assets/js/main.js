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
       3. MOBILE NAVIGATION ACCORDION & DRAWER
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

    // Submenu Accordion in Mobile
    $('.za-mobile-toggle-btn').on('click', function (e) {
      e.preventDefault();
      var $parent = $(this).closest('.za-mobile-nav-item');
      $parent.toggleClass('is-expanded');
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
  });
})(jQuery);
