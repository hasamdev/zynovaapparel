<?php
/**
 * Zynova Apparel Theme Functions and Definitions
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ZYNOVA_THEME_VERSION', '1.1.2');
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
        /* Single Product Screenshot Pixel-Perfect Layout */
        .za-single-product-container {
            max-width: 1040px !important;
            margin: 0 auto !important;
            padding: 0 20px !important;
            box-sizing: border-box !important;
        }
        .za-single-product-grid {
            display: grid !important;
            grid-template-columns: 430px 1fr !important;
            gap: 40px !important;
            align-items: start !important;
        }
        .za-main-img-box {
            background: #f4f5f7 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 12px !important;
            width: 100% !important;
            height: 460px !important;
            box-sizing: border-box !important;
        }
        .za-main-display-img {
            max-width: 100% !important;
            max-height: 100% !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
            object-position: center !important;
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
        @media (max-width: 991px) {
            .za-single-product-grid {
                grid-template-columns: 1fr !important;
                gap: 32px !important;
            }
            .za-main-img-box {
                height: 400px !important;
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
        echo '<span>' . esc_html(get_the_title()) . '</span>';
    }

    echo '</div></nav>';
}

/**
 * Product Importer REST API
 */
require_once ZYNOVA_THEME_DIR . '/inc/class-product-importer.php';


