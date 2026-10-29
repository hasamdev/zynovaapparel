<?php
/**
 * The template for displaying archive pages
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
            <?php the_archive_title('<h1 class="za-page-title">', '</h1>'); ?>
            <div class="za-heading-bar"></div>
            <?php the_archive_description('<div class="za-archive-desc">', '</div>'); ?>
        </div>
    </div>

    <?php zynova_breadcrumbs(); ?>

    <div class="za-container za-content-area">
        <div class="za-blog-grid">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('za-post-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="za-post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="za-post-body">
                            <h2 class="za-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="za-post-excerpt"><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="za-post-readmore">Read More &rarr;</a>
                        </div>
                    </article>
                    <?php
                endwhile;

                the_posts_pagination();
            else :
                echo '<p>' . esc_html__('No articles found.', 'zynova') . '</p>';
            endif;
            ?>
        </div>
    </div>
</main>

<?php
get_footer();
