<?php
/**
 * Zynova Apparel Theme Functions and Definitions
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ZYNOVA_THEME_VERSION', '1.0.7');
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

