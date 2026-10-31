<?php
/**
 * Zynova Apparel Theme Functions and Definitions
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ZYNOVA_THEME_VERSION', '1.2.2');
define('ZYNOVA_THEME_DIR', get_template_directory());
define('ZYNOVA_THEME_URI', get_template_directory_uri());

// Include Core Components
require_once ZYNOVA_THEME_DIR . '/inc/mega-menu.php';
require_once ZYNOVA_THEME_DIR . '/inc/quote-modal.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function zynova_theme_setup() {
    // Make theme available for translation.
    load_theme_textdomain('zynova', ZYNOVA_THEME_DIR . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // Add support for core custom logo.
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 220,
        'flex-width'  => true,
        'flex-height' => true,
    ]);

    // WooCommerce Support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Register Navigation Menus
    register_nav_menus([
        'primary'           => esc_html__('Primary Menu', 'zynova'),
        'footer-categories' => esc_html__('Footer Categories', 'zynova'),
        'footer-company'    => esc_html__('Footer Company Links', 'zynova'),
    ]);

    // Purge LiteSpeed cache on theme update
    if (has_action('litespeed_purge_all')) {
        do_action('litespeed_purge_all');
    }
}
add_action('after_setup_theme', 'zynova_theme_setup');

/**
 * Enqueue scripts and styles.
 */
function zynova_scripts() {
    // Google Fonts: Outfit & Inter
    wp_enqueue_style(
        'zynova-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap',
        [],
        null
    );

    // Theme Main Stylesheet
    wp_enqueue_style(
        'zynova-style',
        get_stylesheet_uri(),
        [],
        ZYNOVA_THEME_VERSION
    );

    // Theme Custom Component Styles
    wp_enqueue_style(
        'zynova-main-css',
        ZYNOVA_THEME_URI . '/assets/css/main.css',
        ['zynova-style'],
        ZYNOVA_THEME_VERSION
    );

    // Injected critical CSS overrides to guarantee immediate cache-free rendering
    $critical_css = "
        /* Header Layout & Middle Alignment */
        .za-site-header {
            overflow-x: clip !important;
        }
        .za-header-container {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            height: var(--za-header-height) !important;
            max-width: var(--za-max-w) !important;
            margin: 0 auto !important;
            padding: 0 24px !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }
        .za-site-header .za-brand-wrap {
            display: flex !important;
            align-items: center !important;
            height: 100% !important;
            flex-shrink: 0 !important;
        }
        .za-site-header .za-brand-link {
            display: inline-flex !important;
            align-items: center !important;
            height: 100% !important;
            text-decoration: none !important;
            line-height: 1 !important;
        }
        .za-logo-img {
            height: 48px !important;
            width: auto !important;
            max-width: 170px !important;
            object-fit: contain !important;
            display: block !important;
            filter: drop-shadow(0 0 1px #ffffff) drop-shadow(0 0 3px rgba(200, 155, 60, 0.45)) !important;
            transition: transform 0.2s ease !important;
        }
        .za-main-navigation {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 100% !important;
            flex: 1 1 auto !important;
            min-width: 0 !important;
            margin: 0 14px !important;
        }
        .za-nav-list {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 100% !important;
            gap: 4px !important;
            flex-wrap: nowrap !important;
        }
        .za-nav-item {
            display: flex !important;
            align-items: center !important;
            height: 100% !important;
            flex-shrink: 0 !important;
        }
        .za-nav-link {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 100% !important;
            white-space: nowrap !important;
            padding: 0 10px !important;
            font-size: 0.88rem !important;
            gap: 4px !important;
        }
        .za-slider-dots {
            display: none !important;
        }
        .za-cat-card {
            width: 80% !important;
            max-width: 80% !important;
            margin: 0 auto !important;
        }
        .za-header-actions {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            height: 100% !important;
            gap: 14px !important;
            flex-shrink: 0 !important;
        }
        .za-header-cart-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 40px !important;
            height: 40px !important;
            flex-shrink: 0 !important;
        }
        .za-btn-quote {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            height: 40px !important;
            padding: 0 18px !important;
            font-size: 0.88rem !important;
            font-weight: 600 !important;
            box-sizing: border-box !important;
            line-height: 1 !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
        }
        .za-btn-quote-text {
            display: inline !important;
        }
        .za-btn-quote-short {
            display: none !important;
        }
        .za-mobile-menu-trigger {
            display: none;
            align-items: center !important;
            justify-content: center !important;
            width: 42px !important;
            height: 42px !important;
            background: rgba(200, 155, 60, 0.12) !important;
            border: 1.5px solid rgba(200, 155, 60, 0.45) !important;
            border-radius: 8px !important;
            color: var(--za-accent-gold) !important;
            padding: 0 !important;
            box-sizing: border-box !important;
            flex-shrink: 0 !important;
            transition: all 0.2s ease !important;
        }
        .za-mobile-menu-trigger[aria-expanded='true'] {
            background: var(--za-accent-gold) !important;
            border-color: var(--za-accent-gold) !important;
            color: var(--za-primary-dark) !important;
        }
        .za-hamburger-box {
            width: 22px !important;
            height: 16px !important;
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 auto !important;
        }
        .za-hamburger-inner,
        .za-hamburger-inner::before,
        .za-hamburger-inner::after {
            position: absolute !important;
            width: 20px !important;
            height: 2px !important;
            background-color: currentColor !important;
            border-radius: 2px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            transition: all 0.25s ease-in-out !important;
        }
        .za-hamburger-inner {
            top: 50% !important;
            transform: translate(-50%, -50%) !important;
        }
        .za-hamburger-inner::before {
            content: '' !important;
            top: -6px !important;
        }
        .za-hamburger-inner::after {
            content: '' !important;
            top: 6px !important;
            bottom: auto !important;
        }
        .za-mobile-menu-trigger[aria-expanded='true'] .za-hamburger-inner {
            background-color: transparent !important;
        }
        .za-mobile-menu-trigger[aria-expanded='true'] .za-hamburger-inner::before {
            top: 50% !important;
            transform: translate(-50%, -50%) rotate(45deg) !important;
        }
        .za-mobile-menu-trigger[aria-expanded='true'] .za-hamburger-inner::after {
            top: 50% !important;
            transform: translate(-50%, -50%) rotate(-45deg) !important;
        }
        @media (max-width: 1260px) {
            .za-nav-link { padding: 0 6px !important; font-size: 0.80rem !important; gap: 3px !important; }
        }
        @media (max-width: 992px) {
            .za-main-navigation { display: none !important; }
            .za-mobile-menu-trigger { display: inline-flex !important; }
        }
        @media (max-width: 768px) {
            :root { --za-header-height: 64px !important; }
            .za-site-header { height: 64px !important; }
            .za-header-container { height: 64px !important; padding: 0 14px !important; }
            .za-logo-img, .za-footer-brand .za-logo-img { height: 40px !important; max-width: 140px !important; }
            .za-header-actions { gap: 8px !important; }
            .za-header-cart-btn { width: 36px !important; height: 36px !important; }
            .za-btn-quote { height: 36px !important; padding: 0 12px !important; font-size: 0.8rem !important; gap: 6px !important; }
            .za-btn-quote-text { display: none !important; }
            .za-btn-quote-short { display: inline !important; }
            .za-mobile-menu-trigger { width: 38px !important; height: 38px !important; }
            .za-cat-card { flex: 0 0 60% !important; max-width: 232px !important; }
        }
        @media (max-width: 420px) {
            .za-header-container { padding: 0 10px !important; }
            .za-header-actions { gap: 6px !important; }
            .za-logo-img, .za-footer-brand .za-logo-img { height: 34px !important; max-width: 120px !important; }
            .za-header-cart-btn { width: 34px !important; height: 34px !important; }
            .za-btn-quote { height: 34px !important; padding: 0 9px !important; font-size: 0.76rem !important; gap: 4px !important; }
            .za-btn-quote-icon { width: 12px !important; height: 12px !important; }
            .za-mobile-menu-trigger { width: 34px !important; height: 34px !important; }
        }
        .za-mega-dropdown ul, .za-mega-dropdown ol, .za-mega-dropdown li,
        ul.za-mega-links, ul.za-mega-links li {
            list-style: none !important;
            list-style-type: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .za-mega-inner {
            display: flex !important;
            flex-direction: row !important;
            align-items: stretch !important;
            width: 100% !important;
            gap: 0 !important;
        }
        .za-cols-2 .za-mega-col { flex: 0 0 50% !important; max-width: 50% !important; }
        .za-cols-3 .za-mega-col { flex: 0 0 33.333333% !important; max-width: 33.333333% !important; }
        .za-cols-6 .za-mega-col { flex: 0 0 16.666667% !important; max-width: 16.666667% !important; }
        .za-mega-col {
            position: relative !important;
            padding: 0 22px !important;
            box-sizing: border-box !important;
            border-right: 1px solid #edf2f7 !important;
        }
        .za-mega-col:first-child { padding-left: 0 !important; }
        .za-mega-col:last-child { padding-right: 0 !important; border-right: none !important; }
        .za-mega-col-heading {
            display: block !important;
            font-family: var(--za-font-heading) !important;
            font-size: 0.84rem !important;
            font-weight: 800 !important;
            color: #0b161e !important;
            text-transform: uppercase !important;
            letter-spacing: 0.03em !important;
            line-height: 1.35 !important;
            min-height: 36px !important;
            margin-bottom: 4px !important;
            text-decoration: none !important;
        }
        .za-mega-col-bar {
            display: block !important;
            width: 32px !important;
            height: 2px !important;
            background-color: var(--za-accent-gold) !important;
            border-radius: 2px !important;
            margin-top: 4px !important;
        }
        .za-mega-links li {
            display: block !important;
            margin: 0 0 10px 0 !important;
            padding: 0 !important;
            line-height: 1.4 !important;
        }
        .za-mega-links a {
            display: inline-block !important;
            font-family: var(--za-font-body) !important;
            font-size: 0.86rem !important;
            color: #475569 !important;
            line-height: 1.4 !important;
            text-decoration: none !important;
        }
        .za-mega-links a:hover {
            color: var(--za-accent-gold) !important;
            transform: translateX(3px) !important;
        }
        .za-footer-strip {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            gap: 20px !important;
            padding: 24px 44px !important;
            background-color: rgba(255, 255, 255, 0.025) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: var(--za-radius-md) !important;
            margin: 0 16px 28px 16px !important;
        }
        @media (max-width: 1200px) {
            .za-cols-6 .za-mega-inner { flex-wrap: wrap !important; }
            .za-cols-6 .za-mega-col { flex: 0 0 33.333333% !important; max-width: 33.333333% !important; }
        }
        @media (max-width: 768px) {
            .za-footer-strip {
                flex-direction: column !important;
                text-align: center !important;
                gap: 14px !important;
                padding: 20px 22px !important;
                margin: 0 0 24px 0 !important;
            }
        }
        /* Single Product Screenshot Pixel-Perfect Layout - Matching Overall Website Width */
        .za-single-product-container {
            max-width: var(--za-max-w) !important;
            width: 100% !important;
            margin: 0 auto !important;
            padding: 0 24px !important;
            box-sizing: border-box !important;
        }
        .za-single-product-grid {
            display: grid !important;
            grid-template-columns: minmax(0, 520px) 1fr !important;
            gap: 48px !important;
            align-items: start !important;
        }
        .za-main-img-box {
            background: #f4f5f7 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            overflow: hidden !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            width: 100% !important;
            height: 520px !important;
            position: relative !important;
            cursor: zoom-in !important;
            box-sizing: border-box !important;
            user-select: none !important;
        }
        .za-main-display-img {
            width: 100% !important;
            height: 100% !important;
            max-width: none !important;
            max-height: none !important;
            object-fit: cover !important;
            object-position: center !important;
            display: block !important;
            transition: transform 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
            pointer-events: none !important;
        }
        .za-zoom-badge {
            position: absolute !important;
            bottom: 14px !important;
            right: 14px !important;
            background: rgba(11, 22, 30, 0.78) !important;
            color: #ffffff !important;
            padding: 6px 14px !important;
            border-radius: 20px !important;
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            pointer-events: none !important;
            backdrop-filter: blur(6px) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
            transition: opacity 0.25s ease, transform 0.25s ease !important;
            z-index: 2 !important;
        }
        .za-main-img-box:hover .za-zoom-badge {
            opacity: 0.25 !important;
        }
        .za-gallery-thumbs-grid {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 12px !important;
            margin-top: 14px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .za-thumb-btn {
            width: 100% !important;
            aspect-ratio: 1 / 1 !important;
            border: 1.5px solid #e5e7eb !important;
            border-radius: 6px !important;
            background: #f4f5f7 !important;
            cursor: pointer !important;
            padding: 4px !important;
            box-sizing: border-box !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
        }
        .za-thumb-btn.is-active, .za-thumb-btn:hover {
            border: 2px solid #111827 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
        }
        .za-thumb-img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            border-radius: 4px !important;
            display: block !important;
        }
        .za-product-tabs-section {
            margin-top: 28px !important;
            width: 100% !important;
        }
        .za-tabs-nav {
            display: flex !important;
            gap: 8px !important;
            margin-bottom: 22px !important;
            align-items: center !important;
        }
        .za-tab-nav-btn {
            background: #f3f4f6 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 6px !important;
            padding: 9px 16px !important;
            font-family: var(--za-font-heading) !important;
            font-size: 0.92rem !important;
            font-weight: 600 !important;
            color: #4b5563 !important;
            cursor: pointer !important;
        }
        .za-tab-nav-btn.is-active {
            background: #ffffff !important;
            color: #111827 !important;
            border-color: #d1d5db !important;
            border-bottom: 3px solid #111827 !important;
            font-weight: 700 !important;
        }
        .za-p-title {
            font-family: var(--za-font-heading) !important;
            font-size: 1.78rem !important;
            font-weight: 800 !important;
            color: #111827 !important;
            text-transform: uppercase !important;
            line-height: 1.22 !important;
            margin: 0 0 10px 0 !important;
            letter-spacing: -0.01em !important;
        }
        .za-p-rating-row {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            margin-bottom: 24px !important;
            font-size: 0.94rem !important;
        }
        .za-stars {
            color: #f59e0b !important;
            font-size: 1.1rem !important;
            letter-spacing: 2px !important;
        }
        .za-review-count {
            color: #4b5563 !important;
            font-weight: 500 !important;
        }
        .za-write-review-link {
            color: #111827 !important;
            text-decoration: underline !important;
            font-weight: 600 !important;
            margin-left: 2px !important;
        }
        .za-key-features-card {
            margin-bottom: 24px !important;
        }
        .za-kf-heading {
            font-family: var(--za-font-heading) !important;
            font-size: 1.15rem !important;
            font-weight: 800 !important;
            color: #111827 !important;
            margin: 0 0 12px 0 !important;
        }
        .za-kf-list {
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
        }
        .za-kf-item {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            font-size: 0.94rem !important;
            color: #1f2937 !important;
            font-weight: 500 !important;
            line-height: 1.4 !important;
        }
        .za-selector-label {
            display: block !important;
            font-family: var(--za-font-heading) !important;
            font-size: 0.94rem !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin-bottom: 6px !important;
        }
        .za-custom-select {
            width: 100% !important;
            height: 46px !important;
            border: 1.5px solid #d1d5db !important;
            border-radius: 6px !important;
            padding: 0 36px 0 14px !important;
            font-family: var(--za-font-body) !important;
            font-size: 0.92rem !important;
            font-weight: 500 !important;
            color: #111827 !important;
            background-color: #ffffff !important;
        }
        .za-pr-title {
            font-family: var(--za-font-heading) !important;
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            color: #111827 !important;
            margin: 0 0 4px 0 !important;
        }
        .za-pr-subtext {
            font-size: 0.92rem !important;
            color: #64748b !important;
            margin: 0 !important;
        }
        .za-cta-btn {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 10px !important;
            width: 100% !important;
            height: 50px !important;
            border-radius: 6px !important;
            font-family: var(--za-font-heading) !important;
            font-size: 0.95rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.04em !important;
            border: none !important;
            cursor: pointer !important;
        }
        .za-cta-email {
            background-color: #373a40 !important;
            color: #ffffff !important;
        }
        .za-cta-whatsapp {
            background-color: #25D366 !important;
            color: #ffffff !important;
        }
        .za-trust-badges-strip {
            background-color: #f4f5f7 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            padding: 14px 16px !important;
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 10px !important;
            box-sizing: border-box !important;
            margin-top: 0 !important;
        }
        .za-trust-item {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            gap: 6px !important;
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
        }
        .za-trust-icon {
            color: #111827 !important;
            width: 22px !important;
            height: 22px !important;
        }
        /* Lightbox Modal */
        .za-lightbox-modal {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 99999 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: opacity 0.3s ease, visibility 0.3s ease !important;
        }
        .za-lightbox-modal.is-open {
            opacity: 1 !important;
            visibility: visible !important;
        }
        body.za-lightbox-locked {
            overflow: hidden !important;
        }
        .za-lightbox-backdrop {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: rgba(11, 22, 30, 0.94) !important;
            backdrop-filter: blur(8px) !important;
            cursor: pointer !important;
        }
        .za-lightbox-container {
            position: relative !important;
            z-index: 2 !important;
            max-width: 92vw !important;
            max-height: 90vh !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .za-lightbox-content {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            max-width: 100% !important;
            max-height: 100% !important;
        }
        .za-lightbox-display-img {
            max-width: 86vw !important;
            max-height: 78vh !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
            border-radius: 8px !important;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6) !important;
            background: #0f172a !important;
        }
        .za-lightbox-caption {
            margin-top: 14px !important;
            color: #ffffff !important;
            font-family: var(--za-font-heading) !important;
            font-size: 0.95rem !important;
            font-weight: 600 !important;
            letter-spacing: 0.04em !important;
            text-align: center !important;
        }
        .za-lightbox-close {
            position: absolute !important;
            top: -48px !important;
            right: 0 !important;
            background: rgba(255, 255, 255, 0.15) !important;
            border: none !important;
            color: #ffffff !important;
            width: 42px !important;
            height: 42px !important;
            border-radius: 50% !important;
            font-size: 2rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            line-height: 1 !important;
            transition: all 0.2s ease !important;
        }
        .za-lightbox-close:hover {
            background: var(--za-accent-gold) !important;
            color: #0b161e !important;
            transform: scale(1.08) !important;
        }
        .za-lightbox-arrow {
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            background: rgba(255, 255, 255, 0.15) !important;
            border: none !important;
            color: #ffffff !important;
            width: 50px !important;
            height: 50px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            z-index: 3 !important;
        }
        .za-lightbox-arrow:hover {
            background: var(--za-accent-gold) !important;
            color: #0b161e !important;
            transform: translateY(-50%) scale(1.08) !important;
        }
        .za-lightbox-prev { left: -65px !important; }
        .za-lightbox-next { right: -65px !important; }
        @media (max-width: 1100px) {
            .za-single-product-grid { grid-template-columns: 460px 1fr !important; gap: 36px !important; }
        }
        @media (max-width: 991px) {
            .za-single-product-grid {
                grid-template-columns: 1fr !important;
                gap: 32px !important;
            }
            .za-main-img-box {
                height: 440px !important;
            }
            .za-lightbox-prev { left: 10px !important; }
            .za-lightbox-next { right: 10px !important; }
            .za-lightbox-close { top: 10px !important; right: 10px !important; }
        }
        @media (max-width: 640px) {
            .za-main-img-box { height: 380px !important; }
        }
        @media (max-width: 480px) {
            .za-main-img-box { height: 320px !important; }
        }

        /* Trust Bar White Text Guarantee */
        .za-trust-grid .za-trust-item,
        .za-trust-grid .za-trust-item span {
            color: #ffffff !important;
        }
        .za-trust-grid .za-trust-item svg {
            color: var(--za-accent-gold) !important;
        }

        /* Footer Layout & Full Responsiveness */
        .za-site-footer {
            overflow-x: hidden !important;
            width: 100% !important;
        }
        .za-footer-main {
            display: grid !important;
            grid-template-columns: minmax(320px, 420px) 220px 200px !important;
            justify-content: space-between !important;
            align-items: start !important;
            gap: 48px !important;
            padding-bottom: 36px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .za-footer-brand-col {
            max-width: 420px !important;
        }
        .za-footer-brand {
            display: block !important;
            height: auto !important;
            margin: 0 0 18px 0 !important;
            padding: 0 !important;
        }
        .za-footer-brand-link {
            display: inline-block !important;
            height: auto !important;
            text-decoration: none !important;
            line-height: 1 !important;
        }
        .za-footer-logo-img {
            height: 52px !important;
            width: auto !important;
            max-width: 175px !important;
            object-fit: contain !important;
            display: block !important;
            filter: drop-shadow(0 0 1px #ffffff) drop-shadow(0 0 3px rgba(200, 155, 60, 0.45)) !important;
            transition: transform 0.2s ease !important;
        }
        .za-footer-brand-link:hover .za-footer-logo-img {
            transform: scale(1.03) !important;
        }
        .za-footer-desc {
            font-size: 0.92rem !important;
            color: #94a3b8 !important;
            line-height: 1.6 !important;
            margin: 0 0 20px 0 !important;
            padding: 0 !important;
            max-width: 360px !important;
        }
        .za-social-links {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .za-social-icon {
            width: 38px !important;
            height: 38px !important;
            border-radius: 50% !important;
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid rgba(200, 155, 60, 0.35) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: var(--za-accent-gold) !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            flex-shrink: 0 !important;
        }
        .za-social-icon:hover {
            background: var(--za-accent-gold) !important;
            color: #07111a !important;
            border-color: var(--za-accent-gold) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(200, 155, 60, 0.35) !important;
        }
        .za-footer-col:not(.za-footer-brand-col) {
            width: 100% !important;
            max-width: 220px !important;
        }
        .za-footer-col-title {
            font-family: inherit !important;
            font-size: 1.15rem !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            margin: 0 0 6px 0 !important;
        }
        .za-footer-col-bar {
            display: block !important;
            width: 32px !important;
            height: 2px !important;
            background-color: #c89b3c !important;
            border-radius: 2px !important;
            margin: 0 0 16px 0 !important;
        }
        .za-footer-links {
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .za-footer-links li {
            margin-bottom: 9px !important;
        }
        .za-footer-links a {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 3px 0 !important;
            font-size: 0.92rem !important;
            color: #94a3b8 !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
        }
        .za-footer-links a svg {
            flex-shrink: 0 !important;
            margin-left: 12px !important;
        }
        .za-footer-links a:hover {
            color: #c89b3c !important;
            transform: translateX(3px) !important;
        }
        .za-footer-strip {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            gap: 20px !important;
            padding: 16px 28px !important;
            background-color: rgba(255, 255, 255, 0.025) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 8px !important;
            font-size: 0.88rem !important;
            color: #94a3b8 !important;
            margin: 36px 0 24px 0 !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .za-strip-contact {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 16px !important;
        }
        .za-strip-item {
            display: inline-flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 8px !important;
            white-space: nowrap !important;
        }
        .za-strip-item svg {
            color: #c89b3c !important;
            flex-shrink: 0 !important;
            width: 16px !important;
            height: 16px !important;
        }
        .za-strip-item span,
        .za-strip-item a {
            color: #94a3b8 !important;
            font-size: 0.88rem !important;
            text-decoration: none !important;
            transition: color 0.2s ease !important;
        }
        .za-strip-item a:hover {
            color: #c89b3c !important;
        }
        .za-strip-divider {
            display: inline-block !important;
            width: 1px !important;
            height: 16px !important;
            background-color: rgba(255, 255, 255, 0.2) !important;
            flex-shrink: 0 !important;
        }
        .za-strip-values {
            display: inline-flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 10px !important;
            color: #cbd5e1 !important;
            font-weight: 500 !important;
            white-space: nowrap !important;
        }
        .za-strip-values svg {
            color: #c89b3c !important;
            flex-shrink: 0 !important;
            width: 16px !important;
            height: 16px !important;
        }
        .za-dot {
            color: rgba(255, 255, 255, 0.25) !important;
        }
        @media (max-width: 992px) {
            .za-footer-main {
                grid-template-columns: 1fr 1fr !important;
                justify-content: start !important;
                gap: 32px 24px !important;
            }
            .za-footer-brand-col {
                grid-column: 1 / -1 !important;
                max-width: 100% !important;
            }
            .za-footer-desc {
                max-width: 520px !important;
            }
        }
        @media (max-width: 768px) {
            .za-site-footer {
                padding-top: 36px !important;
            }
            .za-footer-main {
                grid-template-columns: 1fr 1fr !important;
                gap: 28px 20px !important;
                padding-bottom: 24px !important;
            }
            .za-footer-logo-img {
                height: 44px !important;
                max-width: 150px !important;
            }
            .za-footer-desc {
                font-size: 0.88rem !important;
                line-height: 1.55 !important;
                margin-bottom: 16px !important;
                max-width: 100% !important;
            }
            .za-footer-col:not(.za-footer-brand-col) {
                max-width: 100% !important;
            }
            .za-footer-links a {
                font-size: 0.86rem !important;
                padding: 3px 0 !important;
            }
            .za-footer-strip {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                gap: 14px !important;
                padding: 16px 18px !important;
                margin: 24px 0 16px 0 !important;
            }
            .za-strip-contact {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: center !important;
                flex-wrap: wrap !important;
                gap: 8px 16px !important;
                width: 100% !important;
            }
            .za-strip-item {
                display: inline-flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: center !important;
                font-size: 0.82rem !important;
                white-space: nowrap !important;
            }
            .za-strip-divider {
                display: inline-block !important;
                width: 1px !important;
                height: 14px !important;
                background-color: rgba(255, 255, 255, 0.2) !important;
                flex-shrink: 0 !important;
            }
            .za-strip-values {
                display: inline-flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: center !important;
                font-size: 0.82rem !important;
                gap: 8px !important;
                flex-wrap: wrap !important;
                width: 100% !important;
            }
            .za-footer-bottom {
                padding: 12px 0 24px 0 !important;
                font-size: 0.82rem !important;
            }
        }
        @media (max-width: 480px) {
            .za-footer-main {
                grid-template-columns: 1fr 1fr !important;
                gap: 24px 14px !important;
            }
            .za-footer-logo-img {
                height: 38px !important;
                max-width: 130px !important;
            }
            .za-footer-col-title {
                font-size: 0.98rem !important;
            }
            .za-footer-col-bar {
                width: 24px !important;
                margin-bottom: 10px !important;
            }
            .za-footer-links a {
                font-size: 0.82rem !important;
                gap: 4px !important;
            }
            .za-footer-links a svg {
                width: 12px !important;
                height: 12px !important;
                margin-left: 4px !important;
            }
            .za-strip-contact {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: center !important;
                flex-wrap: wrap !important;
                gap: 6px 12px !important;
            }
            .za-strip-item {
                display: inline-flex !important;
                flex-direction: row !important;
                align-items: center !important;
                font-size: 0.78rem !important;
                gap: 5px !important;
                white-space: nowrap !important;
            }
            .za-strip-divider {
                display: inline-block !important;
                width: 1px !important;
                height: 12px !important;
                background-color: rgba(255, 255, 255, 0.2) !important;
                flex-shrink: 0 !important;
            }
            .za-strip-values {
                display: inline-flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: center !important;
                font-size: 0.76rem !important;
                gap: 6px !important;
                flex-wrap: wrap !important;
                width: 100% !important;
            }
        }
        @media (max-width: 360px) {
            .za-footer-main {
                grid-template-columns: 1fr !important;
                gap: 22px !important;
            }
        }

        /* WooCommerce Product Grids Overhaul (Shop, Categories, Related) */
        .woocommerce ul.products::before,
        .woocommerce ul.products::after,
        .woocommerce-page ul.products::before,
        .woocommerce-page ul.products::after,
        .za-woocommerce-content ul.products::before,
        .za-woocommerce-content ul.products::after,
        .related.products ul.products::before,
        .related.products ul.products::after,
        .upsells.products ul.products::before,
        .upsells.products ul.products::after {
            content: none !important;
            display: none !important;
        }
        .woocommerce ul.products,
        .woocommerce-page ul.products,
        .za-shop-main .za-woocommerce-content ul.products,
        .za-woocommerce-content ul.products,
        .related.products ul.products,
        .upsells.products ul.products {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 24px !important;
            margin: 0 0 40px 0 !important;
            padding: 0 !important;
            list-style: none !important;
            clear: both !important;
            width: 100% !important;
        }
        .woocommerce ul.products li.product,
        .woocommerce-page ul.products li.product,
        .za-woocommerce-content ul.products li.product,
        .related.products ul.products li.product,
        .upsells.products ul.products li.product {
            float: none !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            margin: 0 !important;
            clear: none !important;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 16px !important;
            box-sizing: border-box !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            text-align: center !important;
            position: relative !important;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
        }
        .woocommerce ul.products li.product:hover,
        .woocommerce-page ul.products li.product:hover,
        .za-woocommerce-content ul.products li.product:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.1) !important;
            border-color: #c89b3c !important;
        }
        .woocommerce ul.products li.product .woocommerce-LoopProduct-link,
        .woocommerce-page ul.products li.product .woocommerce-LoopProduct-link,
        .za-woocommerce-content ul.products li.product .woocommerce-LoopProduct-link {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-decoration: none !important;
            color: inherit !important;
            width: 100% !important;
            flex-grow: 1 !important;
        }
        .woocommerce ul.products li.product a img,
        .woocommerce-page ul.products li.product a img,
        .za-woocommerce-content ul.products li.product a img {
            width: 100% !important;
            height: 220px !important;
            object-fit: contain !important;
            background-color: #f8fafc !important;
            border-radius: 6px !important;
            padding: 12px !important;
            margin: 0 0 14px 0 !important;
            display: block !important;
            transition: transform 0.25s ease !important;
        }
        .woocommerce ul.products li.product:hover a img {
            transform: scale(1.03) !important;
        }
        .woocommerce ul.products li.product .woocommerce-loop-product__title,
        .woocommerce-page ul.products li.product .woocommerce-loop-product__title,
        .za-woocommerce-content ul.products li.product .woocommerce-loop-product__title {
            font-family: inherit !important;
            font-size: 0.95rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            line-height: 1.4 !important;
            min-height: 2.8em !important;
            margin: 0 0 8px 0 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            padding: 0 !important;
        }
        .woocommerce ul.products li.product .price,
        .woocommerce-page ul.products li.product .price,
        .za-woocommerce-content ul.products li.product .price {
            color: #c89b3c !important;
            font-weight: 700 !important;
            font-size: 1.05rem !important;
            margin: 0 0 14px 0 !important;
            display: block !important;
        }
        .woocommerce ul.products li.product .button,
        .woocommerce-page ul.products li.product .button,
        .za-woocommerce-content ul.products li.product .button {
            width: 100% !important;
            height: 42px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: #0b161e !important;
            color: #ffffff !important;
            border-radius: 6px !important;
            font-size: 0.84rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            text-decoration: none !important;
            padding: 0 16px !important;
            margin: auto 0 0 0 !important;
            border: 1px solid #0b161e !important;
            transition: all 0.2s ease !important;
            box-sizing: border-box !important;
        }
        .woocommerce ul.products li.product .button:hover,
        .woocommerce-page ul.products li.product .button:hover,
        .za-woocommerce-content ul.products li.product .button:hover {
            background: #c89b3c !important;
            color: #0b161e !important;
            border-color: #c89b3c !important;
        }
        @media (max-width: 992px) {
            .woocommerce ul.products,
            .woocommerce-page ul.products,
            .za-woocommerce-content ul.products {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 18px !important;
            }
        }
        @media (max-width: 540px) {
            .woocommerce ul.products,
            .woocommerce-page ul.products,
            .za-woocommerce-content ul.products {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 12px !important;
            }
            .woocommerce ul.products li.product,
            .woocommerce-page ul.products li.product,
            .za-woocommerce-content ul.products li.product {
                padding: 10px !important;
            }
            .woocommerce ul.products li.product a img,
            .woocommerce-page ul.products li.product a img,
            .za-woocommerce-content ul.products li.product a img {
                height: 150px !important;
                padding: 8px !important;
                margin-bottom: 8px !important;
            }
            .woocommerce ul.products li.product .woocommerce-loop-product__title,
            .woocommerce-page ul.products li.product .woocommerce-loop-product__title,
            .za-woocommerce-content ul.products li.product .woocommerce-loop-product__title {
                font-size: 0.82rem !important;
                min-height: 2.6em !important;
            }
            .woocommerce ul.products li.product .button,
            .woocommerce-page ul.products li.product .button,
            .za-woocommerce-content ul.products li.product .button {
                height: 36px !important;
                font-size: 0.74rem !important;
                padding: 0 8px !important;
            }
        }
        @media (max-width: 360px) {
            .woocommerce ul.products,
            .woocommerce-page ul.products,
            .za-woocommerce-content ul.products {
                grid-template-columns: 1fr !important;
            }
        }
    ";
    wp_add_inline_style('zynova-main-css', $critical_css);

    // Theme Custom Scripts
    wp_enqueue_script(
        'zynova-main-js',
        ZYNOVA_THEME_URI . '/assets/js/main.js',
        ['jquery'],
        ZYNOVA_THEME_VERSION,
        true
    );

    // Pass AJAX and localized variables
    wp_localize_script('zynova-main-js', 'zynovaData', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('za_quote_nonce_action'),
        'siteUrl' => home_url('/'),
    ]);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'zynova_scripts');

/**
 * WooCommerce Custom Content Wrappers
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function zynova_woocommerce_wrapper_before() {
    echo '<main id="primary" class="site-main za-shop-container"><div class="za-container">';
}
add_action('woocommerce_before_main_content', 'zynova_woocommerce_wrapper_before', 10);

function zynova_woocommerce_wrapper_after() {
    echo '</div></main>';
}
add_action('woocommerce_after_main_content', 'zynova_woocommerce_wrapper_after', 10);

/**
 * Breadcrumb Helper
 */
function zynova_breadcrumbs() {
    if (is_front_page()) {
        return;
    }

    echo '<nav class="za-breadcrumbs" aria-label="Breadcrumb"><div class="za-container">';
    echo '<a href="' . esc_url(home_url('/')) . '">Home</a>';
    echo '<span class="za-bc-sep">/</span>';

    if (is_home()) {
        echo '<span>Blog</span>';
    } elseif (is_singular('product')) {
        $terms = wc_get_product_terms(get_the_ID(), 'product_cat', ['orderby' => 'parent', 'order' => 'DESC']);
        if ($terms) {
            $main_term = $terms[0];
            echo '<a href="' . esc_url(get_term_link($main_term)) . '">' . esc_html($main_term->name) . '</a>';
            echo '<span class="za-bc-sep">/</span>';
        }
        the_title('<span>', '</span>');
    } elseif (is_page()) {
        the_title('<span>', '</span>');
    } elseif (is_category() || is_tax()) {
        single_term_title('<span>', '</span>');
    } elseif (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
            echo '<span class="za-bc-sep">/</span>';
        }
        the_title('<span>', '</span>');
    } elseif (is_post_type_archive('product')) {
        echo '<span>Shop Catalog</span>';
    } else {
        echo '<span>' . esc_html(wp_strip_all_tags(html_entity_decode(html_entity_decode(get_the_title(), ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES | ENT_HTML5, 'UTF-8'))) . '</span>';
    }

    echo '</div></nav>';
}

/**
 * Product Importer REST API
 */
require_once ZYNOVA_THEME_DIR . '/inc/class-product-importer.php';


