<?php
/**
 * Front Page Template for Zynova Apparel Theme
 * Aligned strictly with "Home Page Design.jpg"
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Fetch live category images from uploads or fallback to uploaded paths
$slider_slides = [
    [
        'title'    => 'GEAR UP. STAND OUT. PERFORM.',
        'subtitle' => 'Premium apparel, workwear, and accessories crafted for Motorsport, Fashion, Sport & Work.',
        'image'    => home_url('/wp-content/uploads/2026/10/Motorcycle-Racing-Gear.jpeg'),
        'cat_url'  => home_url('/product-category/motorcycle-racing-gear/'),
        'tag'      => 'MOTORSPORT & RACING',
    ],
    [
        'title'    => 'BUILT FOR EVERY RIDE',
        'subtitle' => 'Premium motorcycle gear designed for safety, performance, and uncompromising style.',
        'image'    => home_url('/wp-content/uploads/2026/10/2-Sportswear.jpeg'),
        'cat_url'  => home_url('/product-category/sportswear/'),
        'tag'      => 'PRO SPORTSWEAR',
    ],
    [
        'title'    => 'URBAN COMFORT & TIMELESS STYLE',
        'subtitle' => 'Engineered fashion apparel and premium jackets tailored for modern living.',
        'image'    => home_url('/wp-content/uploads/2026/10/3-Fashion-Wear.jpg'),
        'cat_url'  => home_url('/product-category/fashion-wear/'),
        'tag'      => 'FASHION & LEATHER',
    ],
    [
        'title'    => 'MAXIMUM PROTECTION ON DUTY',
        'subtitle' => 'Certified high-visibility workwear and PPE equipment engineered for extreme conditions.',
        'image'    => home_url('/wp-content/uploads/2026/10/4-Workwear-Safety.jpeg'),
        'cat_url'  => home_url('/product-category/workwear-safety-gear/'),
        'tag'      => 'WORKWEAR & SAFETY',
    ],
    [
        'title'    => 'DURABILITY FOR EVERY JOURNEY',
        'subtitle' => 'Handcrafted genuine leather travel duffels and gear bags designed to endure.',
        'image'    => home_url('/wp-content/uploads/2026/10/5-Bags.jpeg'),
        'cat_url'  => home_url('/product-category/bags/'),
        'tag'      => 'TRAVEL & RACING BAGS',
    ],
    [
        'title'    => 'PRECISION ESSENTIALS & ACCESSORIES',
        'subtitle' => 'Finest leather belts, wallets, caps, and protective sleeves crafted with care.',
        'image'    => home_url('/wp-content/uploads/2026/10/6-Accessories.jpg'),
        'cat_url'  => home_url('/product-category/accessories/'),
        'tag'      => 'PREMIUM ACCESSORIES',
    ],
];

$categories_grid = [
    [
        'name'     => 'MOTORCYCLE & RACING',
        'subtitle' => 'Racing jackets, gloves & gear',
        'url'      => home_url('/product-category/motorcycle-racing-gear/'),
        'image'    => home_url('/wp-content/uploads/2026/10/Motorcycle-Racing-Gear.jpeg'),
    ],
    [
        'name'     => 'SPORTSWEAR',
        'subtitle' => 'Performancewear & sport gear',
        'url'      => home_url('/product-category/sportswear/'),
        'image'    => home_url('/wp-content/uploads/2026/10/2-Sportswear.jpeg'),
    ],
    [
        'name'     => 'FASHION WEAR',
        'subtitle' => 'Streetwear, apparel & essentials',
        'url'      => home_url('/product-category/fashion-wear/'),
        'image'    => home_url('/wp-content/uploads/2026/10/3-Fashion-Wear.jpg'),
    ],
    [
        'name'     => 'WORKWEAR AND SAFETY',
        'subtitle' => 'Durable workwear & protective gear',
        'url'      => home_url('/product-category/workwear-safety-gear/'),
        'image'    => home_url('/wp-content/uploads/2026/10/4-Workwear-Safety.jpeg'),
    ],
    [
        'name'     => 'BAGS',
        'subtitle' => 'Duffels, backpacks & travel bags',
        'url'      => home_url('/product-category/bags/'),
        'image'    => home_url('/wp-content/uploads/2026/10/5-Bags.jpeg'),
    ],
    [
        'name'     => 'ACCESSORIES',
        'subtitle' => 'Caps, belts, wallets & more',
        'url'      => home_url('/product-category/accessories/'),
        'image'    => home_url('/wp-content/uploads/2026/10/6-Accessories.jpg'),
    ],
];
?>

<main id="primary" class="site-main za-home-page">

    <!-- HERO SLIDER SECTION -->
    <section class="za-hero-section" aria-label="Featured Collections Slider">
        <div class="za-hero-slider-wrap">
            <div class="za-hero-slider" id="za-hero-slider">
                <?php foreach ($slider_slides as $index => $slide) : ?>
                    <div class="za-slide <?php echo $index === 0 ? 'is-active' : ''; ?>" style="background-image: url('<?php echo esc_url($slide['image']); ?>');">
                        <div class="za-slide-overlay"></div>
                        <div class="za-container za-slide-container">
                            <div class="za-hero-content">
                                <div class="za-hero-gold-badge">
                                    <span class="za-gold-za">ZA</span>
                                </div>
                                <h1 class="za-hero-title"><?php echo esc_html($slide['title']); ?></h1>
                                <p class="za-hero-subtitle"><?php echo esc_html($slide['subtitle']); ?></p>
                                
                                <div class="za-hero-buttons">
                                    <a href="<?php echo esc_url($slide['cat_url']); ?>" class="za-btn za-btn-gold">
                                        <span>SHOP NOW</span>
                                    </a>
                                    <a href="#categories-section" class="za-btn za-btn-outline-light">
                                        <span>EXPLORE COLLECTIONS</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Slider Controls -->
            <button class="za-slider-arrow za-prev" id="za-slide-prev" aria-label="Previous Slide">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button class="za-slider-arrow za-next" id="za-slide-next" aria-label="Next Slide">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>

            <!-- Slider Dots -->
            <div class="za-slider-dots" id="za-slider-dots" role="tablist">
                <?php foreach ($slider_slides as $i => $s) : ?>
                    <button class="za-slider-dot <?php echo $i === 0 ? 'is-active' : ''; ?>" data-slide="<?php echo esc_attr($i); ?>" role="tab" aria-label="Slide <?php echo esc_attr($i + 1); ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- TRUST BADGES BAR -->
        <div class="za-trust-bar">
            <div class="za-container">
                <div class="za-trust-grid">
                    <div class="za-trust-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>FREE SHIPPING ON ORDERS $100+</span>
                    </div>
                    <div class="za-trust-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                        <span>30-DAY RETURNS</span>
                    </div>
                    <div class="za-trust-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        <span>SECURE PAYMENTS</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SHOP BY CATEGORY SECTION -->
    <section id="categories-section" class="za-section za-categories-section">
        <div class="za-container">
            <div class="za-section-header">
                <h2 class="za-section-title">SHOP BY CATEGORY</h2>
                <p class="za-section-subtitle">Explore our collections designed for every lifestyle and profession</p>
                <div class="za-heading-bar"></div>
            </div>

            <div class="za-category-grid">
                <?php foreach ($categories_grid as $cat) : ?>
                    <a href="<?php echo esc_url($cat['url']); ?>" class="za-cat-card">
                        <div class="za-cat-image-wrap">
                            <img src="<?php echo esc_url($cat['image']); ?>" alt="<?php echo esc_attr($cat['name']); ?>" loading="lazy">
                            <div class="za-cat-overlay"></div>
                        </div>
                        <div class="za-cat-info">
                            <h3 class="za-cat-title"><?php echo esc_html($cat['name']); ?></h3>
                            <div class="za-cat-subtitle">
                                <span><?php echo esc_html($cat['subtitle']); ?></span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE ZA SECTION -->
    <section class="za-why-choose-section">
        <div class="za-container">
            <div class="za-why-header">
                <h2 class="za-why-title">WHY CHOOSE ZA</h2>
                <p class="za-why-subtitle">Built for quality. Trusted for performance. Designed for you.</p>
            </div>

            <div class="za-why-grid">
                <div class="za-why-card">
                    <div class="za-why-icon-wrap">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                    </div>
                    <h3 class="za-why-item-title">PREMIUM QUALITY</h3>
                    <p class="za-why-item-desc">Crafted from high-grade materials for durability and style that lasts.</p>
                </div>

                <div class="za-why-card">
                    <div class="za-why-icon-wrap">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                    <h3 class="za-why-item-title">FAST DELIVERY</h3>
                    <p class="za-why-item-desc">Quick and reliable shipping across the country, delivered to your door.</p>
                </div>

                <div class="za-why-card">
                    <div class="za-why-icon-wrap">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <h3 class="za-why-item-title">TRUSTED BY THOUSANDS</h3>
                    <p class="za-why-item-desc">Join thousands of satisfied customers and professionals worldwide.</p>
                </div>

                <div class="za-why-card">
                    <div class="za-why-icon-wrap">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h3 class="za-why-item-title">SECURE PAYMENTS</h3>
                    <p class="za-why-item-desc">Safe checkout with secure payment options and buyer protection.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TOP PRODUCTS SECTION -->
    <section class="za-section za-products-section">
        <div class="za-container">
            <div class="za-section-header">
                <h2 class="za-section-title">TOP PRODUCTS</h2>
                <p class="za-section-subtitle">Bestsellers loved by our community — shop what's trending now</p>
                <div class="za-heading-bar"></div>
            </div>

            <div class="za-products-grid">
                <?php
                if (class_exists('WooCommerce')) {
                    $args = [
                        'post_type'      => 'product',
                        'posts_per_page' => 5,
                        'status'         => 'publish',
                    ];
                    $query = new WP_Query($args);

                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            global $product;
                            ?>
                            <div class="za-product-card">
                                <div class="za-product-badge"><?php the_title(); ?></div>
                                <div class="za-product-img-wrap">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('woocommerce_thumbnail'); ?>
                                        <?php else : ?>
                                            <img src="<?php echo esc_url(home_url('/wp-content/uploads/woocommerce-placeholder.webp')); ?>" alt="<?php the_title_attribute(); ?>">
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="za-product-info">
                                    <h3 class="za-product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="za-product-price"><?php echo $product ? $product->get_price_html() : ''; ?></div>
                                    <a href="<?php the_permalink(); ?>" class="za-btn za-btn-sm za-btn-primary">View Product</a>
                                </div>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                    } else {
                        // Fallback showcase cards matching Home Page Design.jpg
                        $showcase = [
                            ['title' => 'RACING JACKET PRO', 'img' => home_url('/wp-content/uploads/2026/10/Motorcycle-Racing-Gear.jpeg'), 'cat' => 'Motorcycle Gear'],
                            ['title' => 'PERFORMANCE HOODIE', 'img' => home_url('/wp-content/uploads/2026/10/Fashion-Hoodies-14.jpeg'), 'cat' => 'Sportswear'],
                            ['title' => 'TRAIL RUNNING SHOES', 'img' => home_url('/wp-content/uploads/2026/10/2-Sportswear.jpeg'), 'cat' => 'Footwear'],
                            ['title' => 'SAFETY HELMET PRO', 'img' => home_url('/wp-content/uploads/2026/10/4-Workwear-Safety.jpeg'), 'cat' => 'Workwear & Safety'],
                            ['title' => 'LEATHER DUFFEL BAG', 'img' => home_url('/wp-content/uploads/2026/10/5-Bags.jpeg'), 'cat' => 'Bags & Travel'],
                        ];

                        foreach ($showcase as $item) {
                            ?>
                            <div class="za-product-card">
                                <div class="za-product-badge"><?php echo esc_html($item['title']); ?></div>
                                <div class="za-product-img-wrap">
                                    <img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
                                </div>
                                <div class="za-product-info">
                                    <span class="za-product-cat-tag"><?php echo esc_html($item['cat']); ?></span>
                                    <h3 class="za-product-name"><?php echo esc_html($item['title']); ?></h3>
                                    <button type="button" class="za-btn za-btn-sm za-btn-primary za-open-quote-modal">Request Quote</button>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- B2B CUSTOM MANUFACTURING & SIALKOT FACTORY SECTION -->
    <section class="za-b2b-cta-section">
        <div class="za-container">
            <div class="za-b2b-content">
                <span class="za-b2b-badge">DIRECT FACTORY OEM & ODM</span>
                <h2 class="za-b2b-title">Custom Manufacturing & Bulk Orders</h2>
                <p class="za-b2b-desc">
                    Need customized teamwear, private label motorcycle gear, or certified workwear with custom branding? 
                    Our manufacturing unit in Sialkot, Pakistan delivers premium craftsmanship with fast international shipping.
                </p>
                <div class="za-b2b-actions">
                    <button type="button" class="za-btn za-btn-gold za-open-quote-modal">
                        <span>Get Instant Wholesale Quote</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="za-btn za-btn-outline-light">
                        <span>Contact Factory Support</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();

