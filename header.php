<?php
/**
 * Header template for Zynova Apparel Theme
 * Aligned strictly with "Zynova Apparel Navbar Design.png"
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'zynova'); ?></a>

    <!-- Main Navigation Header -->
    <header id="masthead" class="za-site-header">
        <div class="za-header-container">
            <!-- Brand Logo -->
            <div class="za-brand-wrap">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="za-brand-link" rel="home">
                    <div class="za-logo-icon">ZA</div>
                    <div class="za-brand-divider"></div>
                    <div class="za-brand-text">
                        <span class="za-brand-name">ZYNOVA APPAREL</span>
                        <span class="za-brand-tagline">Premium Apparel & Performance Gear</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation with Mega Menus -->
            <nav id="site-navigation" class="za-main-navigation" aria-label="<?php esc_attr_e('Primary Menu', 'zynova'); ?>">
                <?php zynova_render_desktop_navigation(); ?>
            </nav>

            <!-- Header Actions -->
            <div class="za-header-actions">
                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="za-header-cart-btn" title="<?php esc_attr_e('View Cart', 'zynova'); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        <?php 
                        $cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
                        if ($cart_count > 0) : ?>
                            <span class="za-cart-badge"><?php echo esc_html($cart_count); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <button type="button" class="za-btn za-btn-quote za-open-quote-modal">
                    <span>Request a Quote</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>

                <!-- Mobile Hamburger Toggle -->
                <button type="button" class="za-mobile-menu-trigger" aria-controls="mobile-navigation" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle mobile navigation menu', 'zynova'); ?>">
                    <span class="za-hamburger-box">
                        <span class="za-hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobile-navigation" class="za-mobile-drawer" aria-hidden="true">
            <div class="za-mobile-drawer-header">
                <div class="za-brand-text">
                    <span class="za-brand-name">ZYNOVA APPAREL</span>
                </div>
                <button type="button" class="za-mobile-drawer-close" aria-label="Close menu">&times;</button>
            </div>
            <div class="za-mobile-drawer-body">
                <?php zynova_render_mobile_navigation(); ?>
                
                <div class="za-mobile-cta">
                    <button type="button" class="za-btn za-btn-primary za-btn-block za-open-quote-modal">
                        <span>Request a Quote</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="za-header-spacer"></div>

