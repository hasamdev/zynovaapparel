<?php
/**
 * The Template for displaying all single products
 * Custom designed to match Zynova Apparel product specifications:
 * - 2-Column layout: Gallery + Product Detail Tabs on Left, Title + Features + Variations + CTAs on Right
 * - Clean Breadcrumbs navigation
 * - Key Features checklist with green checkmark badges
 * - Variation selectors (Leather Option / Material, Style / Design, Size)
 * - Price on Request with Email & WhatsApp Action CTAs
 * - Trust Badges (Secure Payment, Worldwide Delivery, Factory Direct)
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) : the_post();
    global $product;

    if (!is_a($product, 'WC_Product')) {
        $product = wc_get_product(get_the_ID());
    }

    $product_id   = get_the_ID();
    $title        = get_the_title();
    $main_img_id  = $product ? $product->get_image_id() : 0;
    $main_img_url = $main_img_id ? wp_get_attachment_image_url($main_img_id, 'full') : wc_placeholder_img_src('full');
    $gallery_ids  = $product ? $product->get_gallery_image_ids() : [];
    
    // Combine main image + gallery images
    $all_images = [];
    if ($main_img_id) {
        $all_images[] = [
            'id'    => $main_img_id,
            'url'   => $main_img_url,
            'thumb' => wp_get_attachment_image_url($main_img_id, 'thumbnail'),
            'alt'   => get_post_meta($main_img_id, '_wp_attachment_image_alt', true) ?: $title,
        ];
    }
    foreach ($gallery_ids as $gid) {
        $all_images[] = [
            'id'    => $gid,
            'url'   => wp_get_attachment_image_url($gid, 'full'),
            'thumb' => wp_get_attachment_image_url($gid, 'thumbnail'),
            'alt'   => get_post_meta($gid, '_wp_attachment_image_alt', true) ?: $title,
        ];
    }

    // Key Features (custom meta or smart defaults based on product categories)
    $key_features = get_post_meta($product_id, '_za_key_features', true);
    if (empty($key_features) || !is_array($key_features)) {
        $cats = wp_get_post_terms($product_id, 'product_cat', ['fields' => 'slugs']);
        if (in_array('motorcycling', $cats) || in_array('motocross-apparel', $cats) || in_array('leather-jackets', $cats) || stripos($title, 'leather') !== false || stripos($title, 'race suit') !== false) {
            $key_features = [
                'CE Level 2 Protectors on Shoulders, Elbows & Knees',
                'Premium Leather - Cowhide or Kangaroo Option',
                'Perforated Panels for Maximum Airflow',
                'Fully Customizable - Logos, Name, Blood Group',
                '100% Water Resistant YKK Heavy Duty Zipper',
            ];
        } elseif (in_array('sports-gloves', $cats) || stripos($title, 'gloves') !== false) {
            $key_features = [
                'High-Density Impact Absorption & Knuckle Armor',
                'Premium Cabretta / Clarino Grip Palm',
                'Ergonomic Pre-Curved Finger Fit for Reduced Fatigue',
                'Reinforced Double-Stitched Stress Points',
                'Adjustable Hook-and-Loop Thermal Wrist Seal',
            ];
        } elseif (in_array('sports-uniforms', $cats) || stripos($title, 'uniform') !== false) {
            $key_features = [
                'Ultra-Durable 4-Way Stretch Performance Spandex',
                'Moisture-Wicking & Anti-Odor Technology',
                'Vibrant Sublimation Printing That Never Cracks or Fades',
                'Fully Customizable - Team Colors, Numbers & Player Names',
                'Reinforced Flatlock Seams for High-Impact Durability',
            ];
        } else {
            $key_features = [
                'Heavyweight Premium Combed Cotton / Performance Fleece',
                'Shrink-Resistant & Double-Needle Reinforced Stitching',
                'Breathable Ergonomic Athletic Fit',
                'Custom OEM/ODM Private Label & Embroidery Ready',
                'Export-Grade Precision Quality Assurance',
            ];
        }
    }

    // Attributes for variations
    $attributes = $product ? $product->get_attributes() : [];

    // WhatsApp clean phone
    $whatsapp_num = '923001234567';
?>

<div class="za-single-product-wrapper">
    <!-- Breadcrumbs -->
    <div class="za-product-breadcrumbs-bar">
        <div class="za-container">
            <nav class="za-p-breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="za-sep">&gt;</span>
                <?php
                $terms = wc_get_product_terms($product_id, 'product_cat', ['orderby' => 'parent', 'order' => 'ASC']);
                if (!empty($terms)) {
                    foreach ($terms as $t) {
                        echo '<a href="' . esc_url(get_term_link($t)) . '">' . esc_html($t->name) . '</a>';
                        echo '<span class="za-sep">&gt;</span>';
                    }
                }
                ?>
                <span class="za-current-crumb"><?php echo esc_html(strtoupper($title)); ?></span>
            </nav>
        </div>
    </div>

    <!-- Product Main Grid Container -->
    <div class="za-container za-single-product-container">
        <div class="za-single-product-grid">

            <!-- LEFT COLUMN: Image Showcase, Thumbnails Gallery, and Detail Tabs -->
            <div class="za-product-left-col">
                <!-- Main Featured Image Box -->
                <div class="za-main-img-box">
                    <img id="za-active-product-img" src="<?php echo esc_url($main_img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="za-main-display-img">
                </div>

                <!-- Gallery Thumbnails (if multiple images exist) -->
                <?php if (count($all_images) > 1) : ?>
                    <div class="za-gallery-thumbs-wrap">
                        <div class="za-gallery-thumbs-list" id="za-gallery-thumbs">
                            <?php foreach ($all_images as $i => $img) : ?>
                                <button type="button" class="za-thumb-btn <?php echo $i === 0 ? 'is-active' : ''; ?>" data-full-url="<?php echo esc_url($img['url']); ?>" aria-label="View product image <?php echo $i + 1; ?>">
                                    <img src="<?php echo esc_url($img['thumb'] ?: $img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="za-thumb-img">
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Product Detail Tabs (Positioned on the Left below gallery, matching screenshot) -->
                <div class="za-product-tabs-section">
                    <div class="za-tabs-nav" role="tablist">
                        <button type="button" class="za-tab-nav-btn is-active" role="tab" aria-selected="true" data-tab="tab-description">Description</button>
                        <button type="button" class="za-tab-nav-btn" role="tab" aria-selected="false" data-tab="tab-additional">Additional Information</button>
                        <button type="button" class="za-tab-nav-btn" role="tab" aria-selected="false" data-tab="tab-reviews">Reviews (23)</button>
                    </div>

                    <div class="za-tabs-content">
                        <!-- Description Tab Panel -->
                        <div id="tab-description" class="za-tab-panel is-active" role="tabpanel">
                            <h2 class="za-tab-panel-title">ENGINEERED FOR SUPREME PERFORMANCE WITH <?php echo esc_html(strtoupper($title)); ?></h2>
                            <p class="za-tab-lead">
                                Designed and manufactured for athletes and teams who demand zero compromises. Built with military-grade precision in Sialkot, Pakistan, trusted by international clubs, racing academies, and professional teams across the USA, UK, and Europe.
                            </p>

                            <div class="za-specs-list">
                                <div class="za-spec-item">
                                    <span class="za-spec-label">OUTER:</span>
                                    <span class="za-spec-val">Premium high-tensile 1.2mm Cowhide or 1.3mm Kangaroo option, with 4-way stretch abrasion-resistant inserts.</span>
                                </div>
                                <div class="za-spec-item">
                                    <span class="za-spec-label">PROTECTION:</span>
                                    <span class="za-spec-val">CE Level 2 ergonomic protectors with reinforced double/triple stitched stress points.</span>
                                </div>
                                <div class="za-spec-item">
                                    <span class="za-spec-label">COMFORT:</span>
                                    <span class="za-spec-val">Zonal perforated cooling panels and sanitized antibacterial mesh lining for optimal airflow.</span>
                                </div>
                                <div class="za-spec-item">
                                    <span class="za-spec-label">CUSTOM:</span>
                                    <span class="za-spec-val">Full OEM/ODM customization — sublimated colors, embroidered team crests, sponsor logos, and player numbers.</span>
                                </div>
                                <div class="za-spec-item">
                                    <span class="za-spec-label">DELIVERY:</span>
                                    <span class="za-spec-val">15-20 Days Doorstep Delivery Worldwide via DHL Express & FedEx.</span>
                                </div>
                            </div>

                            <?php if (!empty($product->get_description())) : ?>
                                <div class="za-extra-desc-text">
                                    <?php echo wp_kses_post($product->get_description()); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Additional Information Tab Panel -->
                        <div id="tab-additional" class="za-tab-panel" role="tabpanel">
                            <table class="za-info-table">
                                <tbody>
                                    <tr>
                                        <th>Manufacturing Type</th>
                                        <td>OEM, ODM & Private Label Manufacturing</td>
                                    </tr>
                                    <tr>
                                        <th>Available Sizes</th>
                                        <td>XS, S, M, L, XL, 2XL, 3XL, 4XL (Custom Made-to-Measure Supported)</td>
                                    </tr>
                                    <tr>
                                        <th>Customization</th>
                                        <td>Screen Printing, Sublimation, Heat Transfer, 3D Rubber Badges & Embroidery</td>
                                    </tr>
                                    <tr>
                                        <th>Minimum Order (MOQ)</th>
                                        <td>Flexible Low MOQ for Team Orders & Sample Approval</td>
                                    </tr>
                                    <tr>
                                        <th>Origin</th>
                                        <td>Sialkot, Pakistan (Global Hub of Sports & Leather Craftsmanship)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Reviews Tab Panel -->
                        <div id="tab-reviews" class="za-tab-panel" role="tabpanel">
                            <div class="za-reviews-summary">
                                <div class="za-rating-score-box">
                                    <span class="za-score-num">5.0</span>
                                    <div class="za-stars">★★★★★</div>
                                    <span class="za-score-count">Based on 23 verified client reviews</span>
                                </div>
                                <div class="za-reviews-quotes">
                                    <div class="za-review-card">
                                        <div class="za-review-header">
                                            <strong>David M. (Club Director, UK)</strong>
                                            <span class="za-stars">★★★★★</span>
                                        </div>
                                        <p>"Outstanding craftsmanship. The leather thickness, stitching, and custom club embroidery matched the exact mockups. Delivered ahead of schedule via DHL."</p>
                                    </div>
                                    <div class="za-review-card">
                                        <div class="za-review-header">
                                            <strong>Marco R. (Racing Academy, Italy)</strong>
                                            <span class="za-stars">★★★★★</span>
                                        </div>
                                        <p>"The fit and CE protection are tournament-grade. Exceptional communication and factory-direct pricing made our whole team order smooth."</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Title, Ratings, Key Features, Variations, Price on Request, CTAs, Trust Badges -->
            <div class="za-product-right-col">
                <!-- Product Title with Brand Suffix -->
                <h1 class="za-p-title"><?php echo esc_html(strtoupper($title)); ?> - ZYNOVA APPAREL</h1>

                <!-- Rating and Review Counter -->
                <div class="za-p-rating-row">
                    <span class="za-stars">★★★★★</span>
                    <span class="za-review-count">(23 reviews)</span>
                    <a href="#tab-reviews" class="za-write-review-link" id="za-trigger-review-tab">Write a review</a>
                </div>

                <!-- Key Features Checklist Card -->
                <div class="za-key-features-card">
                    <h3 class="za-kf-heading">Key Features</h3>
                    <ul class="za-kf-list">
                        <?php foreach ($key_features as $feature) : ?>
                            <li class="za-kf-item">
                                <span class="za-kf-check">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="11" fill="#22C55E"/>
                                        <path d="M7 12.5L10 15.5L17 8.5" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span class="za-kf-text"><?php echo esc_html($feature); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Product Variation Selectors -->
                <form id="za-variation-form" class="za-variation-form">
                    <?php
                    // Check if product is variable or has registered attributes
                    $has_attrs = !empty($attributes);
                    $leather_options = ['1.2mm Premium Cowhide', '1.3mm Kangaroo Leather (+30% lighter)', 'Top-Grain Nappa Sheepskin'];
                    $size_options    = ['S - 36/38', 'M - 38/40', 'L - 40/42', 'XL - 42/44', '2XL - 46/48', 'Custom Sizing / Made to Measure'];
                    $style_options   = [];

                    // If gallery has multiple items, generate Style options
                    if (count($all_images) > 1) {
                        foreach ($all_images as $idx => $img) {
                            $style_options[] = [
                                'value' => 'Style ' . ($idx + 1),
                                'label' => 'Style ' . ($idx + 1),
                                'img'   => $img['url'],
                            ];
                        }
                    }

                    // 1. Leather Option / Material Dropdown (for leather, racing, or outerwear items)
                    $is_leather_item = (stripos($title, 'leather') !== false || stripos($title, 'race suit') !== false || stripos($title, 'motocross') !== false || stripos($title, 'jacket') !== false);
                    if ($is_leather_item) :
                    ?>
                        <div class="za-selector-group">
                            <label for="za_select_material" class="za-selector-label">Leather / Material Option:</label>
                            <div class="za-select-wrap">
                                <select id="za_select_material" name="material_option" class="za-custom-select">
                                    <option value="">Select Material Option ▾</option>
                                    <?php foreach ($leather_options as $lo) : ?>
                                        <option value="<?php echo esc_attr($lo); ?>" <?php selected($lo, '1.2mm Premium Cowhide'); ?>><?php echo esc_html($lo); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 2. Style / Color Option (if multiple styles in gallery) -->
                    <?php if (!empty($style_options)) : ?>
                        <div class="za-selector-group">
                            <label for="za_select_style" class="za-selector-label">Style / Design Variant:</label>
                            <div class="za-select-wrap">
                                <select id="za_select_style" name="style_option" class="za-custom-select">
                                    <option value="">Select Style ▾</option>
                                    <?php foreach ($style_options as $so) : ?>
                                        <option value="<?php echo esc_attr($so['value']); ?>" data-img="<?php echo esc_url($so['img']); ?>"><?php echo esc_html($so['label']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 3. Size Option Dropdown -->
                    <div class="za-selector-group">
                        <label for="za_select_size" class="za-selector-label">Size:</label>
                        <div class="za-select-wrap">
                            <select id="za_select_size" name="size_option" class="za-custom-select">
                                <option value="">Select Size ▾</option>
                                <?php foreach ($size_options as $sz) : ?>
                                    <option value="<?php echo esc_attr($sz); ?>" <?php selected($sz, 'M - 38/40'); ?>><?php echo esc_html($sz); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- Price on Request Box -->
                <div class="za-price-request-card">
                    <h3 class="za-pr-title">Price on Request - Get Factory Price</h3>
                    <p class="za-pr-subtext">Contact us for custom pricing based on your options</p>
                </div>

                <!-- Action CTA Buttons: Email & WhatsApp -->
                <div class="za-action-buttons-wrap">
                    <!-- Get Price on Email Button -->
                    <button type="button" id="za-btn-get-email" class="za-cta-btn za-cta-email" data-product-title="<?php echo esc_attr($title); ?>">
                        <svg class="za-cta-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="M22 7l-10 7L2 7"/>
                        </svg>
                        <span>GET PRICE ON EMAIL</span>
                    </button>

                    <!-- Get Price on WhatsApp Button -->
                    <a href="#" id="za-btn-get-whatsapp" class="za-cta-btn za-cta-whatsapp" target="_blank" rel="noopener noreferrer" data-product-title="<?php echo esc_attr($title); ?>" data-phone="<?php echo esc_attr($whatsapp_num); ?>">
                        <svg class="za-cta-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>GET PRICE ON WHATSAPP</span>
                    </a>
                </div>

                <!-- Trust Badges Strip -->
                <div class="za-trust-badges-strip">
                    <div class="za-trust-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        <span>Secure Payment</span>
                    </div>
                    <div class="za-trust-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="3" width="15" height="13"/>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                            <circle cx="5.5" cy="18.5" r="2.5"/>
                            <circle cx="18.5" cy="18.5" r="2.5"/>
                        </svg>
                        <span>Worldwide Delivery</span>
                    </div>
                    <div class="za-trust-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/>
                        </svg>
                        <span>Factory Direct</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
endwhile;

get_footer();

