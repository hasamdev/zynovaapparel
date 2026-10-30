<?php
/**
 * The template for displaying WooCommerce pages
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

if (is_singular('product') || is_product()) {
    require ZYNOVA_THEME_DIR . '/single-product.php';
    return;
}

get_header();
?>

<main id="primary" class="site-main za-page-main za-woocommerce-page">
    <div class="za-page-header">
        <div class="za-container">
            <h1 class="za-page-title">
                <?php
                if (is_shop()) {
                    woocommerce_page_title();
                } elseif (is_product_category() || is_product_tag()) {
                    single_term_title();
                } elseif (is_product()) {
                    the_title();
                } else {
                    woocommerce_page_title();
                }
                ?>
            </h1>
            <div class="za-heading-bar"></div>
        </div>
    </div>

    <?php zynova_breadcrumbs(); ?>

    <div class="za-container za-content-area">
        <div class="za-woocommerce-content">
            <?php woocommerce_content(); ?>
        </div>
    </div>
</main>

<?php
get_footer();

