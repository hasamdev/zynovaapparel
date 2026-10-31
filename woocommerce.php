<?php
/**
 * The template for displaying WooCommerce pages
 * Includes Left Sidebar with Product Categories and Top Rated Products matching ioniasports.com reference
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
                } else {
                    woocommerce_page_title();
                }
                ?>
            </h1>
            <div class="za-heading-bar"></div>
        </div>
    </div>

    <?php zynova_breadcrumbs(); ?>

    <div class="za-container za-shop-container">
        <!-- Mobile Sidebar Toggle -->
        <button type="button" class="za-shop-filter-toggle" id="za-shop-filter-toggle">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
            <span>Filter Categories & Products</span>
        </button>

        <div class="za-shop-layout">
            <!-- Left Sidebar (Aligned with ioniasports.com) -->
            <aside id="secondary" class="za-shop-sidebar" aria-label="<?php esc_attr_e('Shop Sidebar', 'zynova'); ?>">
                <!-- Widget 1: Product categories -->
                <div class="za-shop-widget za-widget-categories">
                    <h3 class="za-widget-title">Product categories</h3>
                    <ul class="za-product-categories-tree">
                        <?php
                        $current_term_id = (is_tax('product_cat')) ? get_queried_object_id() : 0;
                        $parent_cats = get_terms([
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => false,
                            'parent'     => 0,
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                        ]);

                        if (!empty($parent_cats) && !is_wp_error($parent_cats)) {
                            foreach ($parent_cats as $pcat) {
                                if ($pcat->slug === 'uncategorized') {
                                    continue;
                                }
                                $is_current_p = ($current_term_id === $pcat->term_id);
                                $subcats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'hide_empty' => false,
                                    'parent'     => $pcat->term_id,
                                    'orderby'    => 'name',
                                    'order'      => 'ASC',
                                ]);
                                $has_children = !empty($subcats) && !is_wp_error($subcats);
                                $is_active_tree = $is_current_p;
                                if ($has_children && !$is_active_tree) {
                                    foreach ($subcats as $sc) {
                                        if ($sc->term_id === $current_term_id) {
                                            $is_active_tree = true;
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <li class="za-cat-item <?php echo $has_children ? 'cat-parent' : ''; ?> <?php echo $is_active_tree ? 'is-expanded' : ''; ?> <?php echo $is_current_p ? 'is-current' : ''; ?>">
                                    <div class="za-cat-row">
                                        <a href="<?php echo esc_url(get_term_link($pcat)); ?>" class="za-cat-link">
                                            <span><?php echo esc_html($pcat->name); ?></span>
                                            <span class="za-cat-count">(<?php echo esc_html($pcat->count); ?>)</span>
                                        </a>
                                        <?php if ($has_children) : ?>
                                            <button type="button" class="za-cat-toggle-btn" aria-label="Toggle <?php echo esc_attr($pcat->name); ?> subcategories">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($has_children) : ?>
                                        <ul class="za-children-list">
                                            <?php foreach ($subcats as $scat) : 
                                                $is_current_s = ($current_term_id === $scat->term_id);
                                                ?>
                                                <li class="za-subcat-item <?php echo $is_current_s ? 'is-current' : ''; ?>">
                                                    <a href="<?php echo esc_url(get_term_link($scat)); ?>" class="za-subcat-link">
                                                        <span><?php echo esc_html($scat->name); ?></span>
                                                        <span class="za-cat-count">(<?php echo esc_html($scat->count); ?>)</span>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>

                <!-- Widget 2: Top rated products -->
                <div class="za-shop-widget za-widget-top-rated">
                    <h3 class="za-widget-title">Top rated products</h3>
                    <ul class="za-top-rated-products">
                        <?php
                        $top_query = new WP_Query([
                            'post_type'      => 'product',
                            'post_status'    => 'publish',
                            'posts_per_page' => 5,
                            'orderby'        => 'meta_value_num',
                            'meta_key'       => '_price',
                            'order'          => 'DESC',
                        ]);

                        if (!$top_query->have_posts()) {
                            $top_query = new WP_Query([
                                'post_type'      => 'product',
                                'post_status'    => 'publish',
                                'posts_per_page' => 5,
                                'orderby'        => 'date',
                                'order'          => 'DESC',
                            ]);
                        }

                        if ($top_query->have_posts()) :
                            while ($top_query->have_posts()) :
                                $top_query->the_post();
                                global $product;
                                ?>
                                <li class="za-top-product-card">
                                    <a href="<?php the_permalink(); ?>" class="za-top-product-img-link" aria-label="<?php the_title_attribute(); ?>">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('woocommerce_thumbnail'); ?>
                                        <?php else : ?>
                                            <img src="<?php echo esc_url(home_url('/wp-content/uploads/woocommerce-placeholder.webp')); ?>" alt="<?php the_title_attribute(); ?>">
                                        <?php endif; ?>
                                    </a>
                                    <div class="za-top-product-details">
                                        <a href="<?php the_permalink(); ?>" class="za-top-product-title">
                                            <?php the_title(); ?>
                                        </a>
                                        <div class="za-top-product-stars" aria-label="5 out of 5 stars">
                                            <span class="za-star">★</span><span class="za-star">★</span><span class="za-star">★</span><span class="za-star">★</span><span class="za-star">★</span>
                                        </div>
                                        <div class="za-top-product-price">
                                            <?php 
                                            if ($product && $product->get_price_html()) {
                                                echo $product->get_price_html();
                                            } else {
                                                echo '<span class="za-price-request">Price on Request</span>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </ul>
                </div>
            </aside>

            <!-- Main Products Content Area -->
            <div class="za-shop-main">
                <div class="za-woocommerce-content">
                    <?php woocommerce_content(); ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();

