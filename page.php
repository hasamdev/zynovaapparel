<?php
/**
 * The template for displaying all pages
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main za-page-main">
    <div class="za-page-header">
        <div class="za-container">
            <h1 class="za-page-title"><?php the_title(); ?></h1>
            <div class="za-heading-bar"></div>
        </div>
    </div>

    <?php zynova_breadcrumbs(); ?>

    <div class="za-container za-content-area">
        <div class="za-page-content-box">
            <?php
            while (have_posts()) :
                the_post();
                the_content();

                wp_link_pages([
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'zynova'),
                    'after'  => '</div>',
                ]);
            endwhile;
            ?>
        </div>
    </div>
</main>

<?php
get_footer();

