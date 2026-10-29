<?php
/**
 * The main template file
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
            <h1 class="za-page-title"><?php single_post_title(); ?></h1>
            <div class="za-heading-bar"></div>
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
                            <div class="za-post-meta">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                            </div>
                            <h2 class="za-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="za-post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="za-post-readmore">
                                <span>Read More</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </article>
                    <?php
                endwhile;

                the_posts_pagination([
                    'prev_text' => '&larr; Previous',
                    'next_text' => 'Next &rarr;',
                ]);
            else :
                ?>
                <p><?php esc_html_e('No posts found.', 'zynova'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
get_footer();
