<?php
/**
 * The template for displaying all single posts
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

    <div class="za-container za-content-area za-single-post">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="za-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="za-entry-content">
                    <?php
                    the_content();

                    wp_link_pages([
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'zynova'),
                        'after'  => '</div>',
                    ]);
                    ?>
                </div>

                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();

