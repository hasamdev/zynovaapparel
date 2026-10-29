<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main za-page-main">
    <div class="za-container za-content-area">
        <div class="za-404-wrap">
            <span class="za-404-code">404</span>
            <h1 class="za-404-title">Page Not Found</h1>
            <p class="za-404-desc">The page you were looking for doesn't exist, has been moved, or is temporarily unavailable.</p>
            <div class="za-404-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="za-btn za-btn-primary">Return Home</a>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop') ?: home_url('/shop/')); ?>" class="za-btn za-btn-outline">Browse Catalog</a>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();

