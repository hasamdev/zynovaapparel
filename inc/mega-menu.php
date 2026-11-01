<?php
/**
 * Mega Menu Structure and Rendering Functions for Zynova Apparel
 * Strictly aligned with "Zynova Apparel - Web Sequence.txt" & "Zynova Apparel Navbar Design.png"
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Returns structured navigation hierarchy
 */
function zynova_get_navigation_tree() {
    $shop_url = wc_get_page_permalink('shop');
    if (!$shop_url) {
        $shop_url = home_url('/shop/');
    }

    $helper_link = function($slug) {
        if ($slug === 'motorcycle-racing-gear') {
            $slug = 'motorcycling';
        }
        $term = get_term_by('slug', $slug, 'product_cat');
        if ($term && !is_wp_error($term)) {
            return get_term_link($term);
        }
        return home_url('/product-category/' . sanitize_title($slug) . '/');
    };

    return [
        'home' => [
            'title' => 'Home',
            'url'   => home_url('/'),
            'type'  => 'link',
        ],
        'sportswear' => [
            'title' => 'Sportswear',
            'url'   => $helper_link('sportswear'),
            'type'  => 'mega',
            'columns' => [
                [
                    'heading' => 'SPORTS UNIFORMS',
                    'url'     => $helper_link('sports-uniforms'),
                    'items'   => [
                        ['title' => 'American Football Uniforms', 'url' => $helper_link('american-football-uniforms')],
                        ['title' => 'Baseball Uniforms', 'url' => $helper_link('baseball-uniforms')],
                        ['title' => 'Basketball Uniforms', 'url' => $helper_link('basketball-uniforms')],
                        ['title' => 'Football / Soccer Uniforms', 'url' => $helper_link('football-soccer-uniforms')],
                        ['title' => 'Lacrosse Uniforms', 'url' => $helper_link('lacrosse-uniforms')],
                        ['title' => 'Netball Uniforms', 'url' => $helper_link('netball-uniforms')],
                        ['title' => 'Rugby Uniforms', 'url' => $helper_link('rugby-uniforms')],
                        ['title' => 'Volleyball Uniforms', 'url' => $helper_link('volleyball-uniforms')],
                    ]
                ],
                [
                    'heading' => 'SPORTS APPAREL',
                    'url'     => $helper_link('sports-apparel'),
                    'items'   => [
                        ['title' => 'Sports Hoodies', 'url' => $helper_link('sports-hoodies')],
                        ['title' => 'Rash Guard Suits', 'url' => $helper_link('rash-guard-suits')],
                    ]
                ],
                [
                    'heading' => 'SPORTS GLOVES',
                    'url'     => $helper_link('sports-gloves'),
                    'items'   => [
                        ['title' => 'Baseball Gloves', 'url' => $helper_link('baseball-gloves')],
                        ['title' => 'Cricket Gloves', 'url' => $helper_link('cricket-gloves')],
                        ['title' => 'Cycling Gloves', 'url' => $helper_link('cycling-gloves')],
                        ['title' => 'Fitness Gloves', 'url' => $helper_link('fitness-gloves')],
                        ['title' => 'Golf Gloves', 'url' => $helper_link('golf-gloves')],
                        ['title' => 'Horse Riding Gloves', 'url' => $helper_link('horse-riding-gloves')],
                        ['title' => 'Lacrosse Gloves', 'url' => $helper_link('lacrosse-gloves')],
                    ]
                ],
            ]
        ],
        'fashion-wear' => [
            'title' => 'Fashion Wear',
            'url'   => $helper_link('fashion-wear'),
            'type'  => 'mega',
            'columns' => [
                [
                    'heading' => 'CASUAL & FASHION CLOTHING',
                    'url'     => $helper_link('casual-fashion-clothing'),
                    'items'   => [
                        ['title' => 'T-Shirts', 'url' => $helper_link('t-shirts')],
                        ['title' => 'Polo Shirts', 'url' => $helper_link('polo-shirts')],
                        ['title' => 'Fashion Hoodies', 'url' => $helper_link('fashion-hoodies')],
                        ['title' => 'Sweatshirts', 'url' => $helper_link('sweatshirts')],
                        ['title' => 'Sweatpants', 'url' => $helper_link('sweatpants')],
                        ['title' => 'Tracksuits', 'url' => $helper_link('tracksuits')],
                        ['title' => 'Leggings', 'url' => $helper_link('leggings')],
                    ]
                ],
                [
                    'heading' => 'FASHION JACKETS',
                    'url'     => $helper_link('fashion-jackets'),
                    'items'   => [
                        ['title' => 'Fashion Jackets', 'url' => $helper_link('fashion-jackets')],
                        ['title' => "Men's Fashion Leather Jackets", 'url' => $helper_link('mens-fashion-leather-jackets')],
                        ['title' => "Women's Fashion Leather Jackets", 'url' => $helper_link('womens-fashion-leather-jackets')],
                    ]
                ],
                [
                    'heading' => 'JACKETS BY STYLE',
                    'url'     => $helper_link('fashion-jackets'),
                    'items'   => [
                        ['title' => 'Bomber Jacket', 'url' => $helper_link('bomber-jacket')],
                        ['title' => 'Puffer Jacket', 'url' => $helper_link('puffer-jacket')],
                        ['title' => 'Waterproof / Rain Jacket', 'url' => $helper_link('waterproof-rain-jacket')],
                        ['title' => 'Softshell Jacket', 'url' => $helper_link('softshell-jacket')],
                        ['title' => 'Fleece Jacket', 'url' => $helper_link('fleece-jacket')],
                        ['title' => 'Varsity / Letterman Jacket', 'url' => $helper_link('varsity-letterman-jacket')],
                        ['title' => 'Denim / Trucker Jacket', 'url' => $helper_link('denim-trucker-jacket')],
                    ]
                ],
            ]
        ],
        'motorcycling' => [
            'title' => 'Motorcycling',
            'url'   => $helper_link('motorcycling'),
            'type'  => 'mega',
            'full_columns' => 6, // 6 columns strictly as designed in navbar snapshot
            'columns' => [
                [
                    'heading' => 'MOTORCYCLE RACING SUITS',
                    'url'     => $helper_link('motorcycle-leather-apparel'),
                    'items'   => [
                        ['title' => 'Leather Racing Suits 1-Piece', 'url' => $helper_link('motorcycle-leather-suit')],
                        ['title' => 'Leather Racing Suits 2-Piece', 'url' => $helper_link('motorcycle-leather-suit')],
                        ['title' => 'Textile Riding Suits', 'url' => $helper_link('motorcycle-textile-suit')],
                        ['title' => 'Rain Racing Suits', 'url' => $helper_link('motorcycle-textile-apparel')],
                    ]
                ],
                [
                    'heading' => 'MOTORCYCLE JACKETS & PANTS',
                    'url'     => $helper_link('motorcycle-leather-jackets'),
                    'items'   => [
                        ['title' => 'Leather Motorcycle Jackets', 'url' => $helper_link('motorcycle-leather-jackets')],
                        ['title' => 'Textile Riding Jackets', 'url' => $helper_link('motorcycle-textile-jackets')],
                        ['title' => 'Mesh Jackets', 'url' => $helper_link('motorcycle-textile-jackets')],
                        ['title' => 'Motorcycle Riding Pants', 'url' => $helper_link('motorcycle-leather-pants')],
                    ]
                ],
                [
                    'heading' => 'MOTOCROSS APPAREL',
                    'url'     => $helper_link('motocross-apparel'),
                    'items'   => [
                        ['title' => 'Motocross Suits', 'url' => $helper_link('motocross-apparel')],
                        ['title' => 'Motocross Jerseys', 'url' => $helper_link('motocross-jersey')],
                        ['title' => 'Motocross Gloves', 'url' => $helper_link('motocross-gloves')],
                    ]
                ],
                [
                    'heading' => 'MOTORCYCLE BOOTS & GLOVES',
                    'url'     => $helper_link('motorcycle-boots'),
                    'items'   => [
                        ['title' => 'Racing Boots', 'url' => $helper_link('motorcycle-racing-boot')],
                        ['title' => 'Touring Boots', 'url' => $helper_link('motorcycle-touring-boots')],
                        ['title' => 'Motorcycle Riding Gloves', 'url' => $helper_link('motorcycle-racing-gloves')],
                    ]
                ],
                [
                    'heading' => 'BODY PROTECTORS',
                    'url'     => $helper_link('motorcycle-body-protectors'),
                    'items'   => [
                        ['title' => 'Chest Protectors', 'url' => $helper_link('body-armors-jackets')],
                        ['title' => 'Back Protectors', 'url' => $helper_link('spine-protection')],
                        ['title' => 'Shoulder & Elbow Protectors', 'url' => $helper_link('knee-guard-elbow-guard')],
                        ['title' => 'Hip Protectors', 'url' => $helper_link('bikers-safety-short')],
                        ['title' => 'Protection Vests', 'url' => $helper_link('body-armor-vest')],
                        ['title' => 'Kidney Belts', 'url' => $helper_link('motorcycle-kidney-belts')],
                    ]
                ],
                [
                    'heading' => 'ACCESSORIES',
                    'url'     => $helper_link('motorcycling-accessories'),
                    'items'   => [
                        ['title' => 'Knee Sliders', 'url' => $helper_link('motorcycle-knee-sliders')],
                        ['title' => 'Toe Sliders', 'url' => $helper_link('motorcycle-knee-sliders')],
                        ['title' => 'Balaclavas', 'url' => $helper_link('accessories')],
                        ['title' => 'Racing Socks', 'url' => $helper_link('socks')],
                        ['title' => 'Racing Undersuits', 'url' => $helper_link('rash-guard-suits')],
                    ]
                ],
            ]
        ],
        'workwear-safety' => [
            'title' => 'Workwear & Safety',
            'url'   => $helper_link('workwear-safety-gear'),
            'type'  => 'mega',
            'columns' => [
                [
                    'heading' => 'WORKWEAR CLOTHING',
                    'url'     => $helper_link('workwear-clothing'),
                    'items'   => [
                        ['title' => 'Workwear Uniforms', 'url' => $helper_link('workwear-uniforms')],
                        ['title' => 'Work Jackets', 'url' => $helper_link('work-jackets')],
                        ['title' => 'Work Trousers', 'url' => $helper_link('work-trousers')],
                        ['title' => 'Work Coveralls / Overalls', 'url' => $helper_link('work-coveralls-overalls')],
                        ['title' => 'High-Visibility Safety Vests', 'url' => $helper_link('high-visibility-safety-vests')],
                        ['title' => 'Reflective Workwear', 'url' => $helper_link('reflective-workwear')],
                    ]
                ],
                [
                    'heading' => 'PERSONAL PROTECTIVE EQUIPMENT (PPE)',
                    'url'     => $helper_link('personal-protective-equipment-ppe'),
                    'items'   => [
                        ['title' => 'Safety Gloves', 'url' => $helper_link('safety-gloves')],
                        ['title' => 'Safety Helmets / Hard Hats', 'url' => $helper_link('safety-helmets-hard-hats')],
                        ['title' => 'Safety Glasses / Goggles', 'url' => $helper_link('safety-glasses-goggles')],
                        ['title' => 'Hearing Protection', 'url' => $helper_link('hearing-protection')],
                        ['title' => 'Protective Knee Pads', 'url' => $helper_link('protective-knee-pads')],
                        ['title' => 'Respiratory Protection Masks', 'url' => $helper_link('respiratory-protection-masks')],
                    ]
                ],
                [
                    'heading' => 'SAFETY FOOTWEAR',
                    'url'     => $helper_link('safety-footwear'),
                    'items'   => [
                        ['title' => 'Steel-Toe Safety Boots', 'url' => $helper_link('steel-toe-safety-boots')],
                        ['title' => 'Protective Work Shoes', 'url' => $helper_link('protective-work-shoes')],
                    ]
                ],
            ]
        ],
        'accessories' => [
            'title' => 'Accessories',
            'url'   => $helper_link('accessories'),
            'type'  => 'mega',
            'columns' => [
                [
                    'heading' => 'BELTS',
                    'url'     => $helper_link('belts'),
                    'items'   => [
                        ['title' => 'Leather Belts', 'url' => $helper_link('leather-belts')],
                        ['title' => 'Fashion Belts', 'url' => $helper_link('fashion-belts')],
                    ]
                ],
                [
                    'heading' => 'WALLETS',
                    'url'     => $helper_link('wallets'),
                    'items'   => [
                        ['title' => 'Leather Wallets', 'url' => $helper_link('leather-wallets')],
                        ['title' => 'Fashion Wallets', 'url' => $helper_link('fashion-wallets')],
                    ]
                ],
                [
                    'heading' => 'SPORTS & APPAREL ACCESSORIES',
                    'url'     => $helper_link('sports-apparel-accessories'),
                    'items'   => [
                        ['title' => 'Caps', 'url' => $helper_link('caps')],
                        ['title' => 'Sports Sleeves', 'url' => $helper_link('sports-sleeves')],
                        ['title' => 'Socks', 'url' => $helper_link('socks')],
                        ['title' => 'Wrist Wraps', 'url' => $helper_link('wrist-wraps')],
                    ]
                ],
            ]
        ],
        'bags' => [
            'title' => 'Bags',
            'url'   => $helper_link('bags'),
            'type'  => 'mega',
            'columns' => [
                [
                    'heading' => 'TRAVEL BAGS',
                    'url'     => $helper_link('travel-bags'),
                    'items'   => [
                        ['title' => 'Leather Travel Bags', 'url' => $helper_link('leather-travel-bags')],
                        ['title' => 'Rexine Travel Bags', 'url' => $helper_link('rexine-travel-bags')],
                        ['title' => 'Polyester Travel Bags', 'url' => $helper_link('polyester-travel-bags')],
                        ['title' => 'Nylon Travel Bags', 'url' => $helper_link('nylon-travel-bags')],
                        ['title' => 'Canvas Travel Bags', 'url' => $helper_link('canvas-travel-bags')],
                        ['title' => 'Racing Suit Carry Bags', 'url' => $helper_link('racing-suit-carry-bags')],
                    ]
                ],
                [
                    'heading' => 'SPORTS & RACING BAGS',
                    'url'     => $helper_link('sports-racing-bags'),
                    'items'   => [
                        ['title' => 'Racing Suit Carry Bags', 'url' => $helper_link('racing-suit-carry-bags')],
                        ['title' => 'Sports / Gym Bags', 'url' => $helper_link('sports-gym-bags')],
                    ]
                ],
            ]
        ],
        'contact' => [
            'title' => 'Contact',
            'url'   => home_url('/contact/'),
            'type'  => 'link',
        ],
    ];
}

/**
 * Renders the Desktop Mega Menu
 */
function zynova_render_desktop_navigation() {
    $tree = zynova_get_navigation_tree();
    $current_url = home_url(add_query_arg([], $GLOBALS['wp']->request ?? ''));

    echo '<ul class="za-nav-list" role="menubar">';
    foreach ($tree as $key => $item) {
        $has_mega = ($item['type'] === 'mega' && !empty($item['columns']));
        $is_active = (is_front_page() && $key === 'home') || ($item['url'] === $current_url);
        
        $li_classes = ['za-nav-item', 'item-' . sanitize_html_class($key)];
        if ($has_mega) $li_classes[] = 'has-mega-menu';
        if ($is_active) $li_classes[] = 'is-active';

        echo '<li class="' . esc_attr(implode(' ', $li_classes)) . '" data-nav-key="' . esc_attr($key) . '" data-nav-title="' . esc_attr($item['title']) . '" role="none">';
        
        echo '<a href="' . esc_url($item['url']) . '" class="za-nav-link" role="menuitem">';
        echo esc_html($item['title']);
        if ($has_mega) {
            echo ' <svg class="za-chevron-down" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        }
        echo '</a>';

        if ($has_mega) {
            $col_count = count($item['columns']);
            $custom_cols = isset($item['full_columns']) ? $item['full_columns'] : $col_count;
            
            echo '<div class="za-mega-dropdown za-cols-' . esc_attr($custom_cols) . '" role="menu" aria-label="' . esc_attr($item['title']) . ' Submenu">';
            echo '<div class="za-mega-inner">';
            
            foreach ($item['columns'] as $col) {
                echo '<div class="za-mega-col">';
                echo '<div class="za-mega-heading-wrap">';
                echo '<a href="' . esc_url($col['url']) . '" class="za-mega-col-heading">' . esc_html($col['heading']) . '</a>';
                echo '<span class="za-mega-col-bar"></span>';
                echo '</div>';
                
                echo '<ul class="za-mega-links">';
                foreach ($col['items'] as $sub) {
                    echo '<li><a href="' . esc_url($sub['url']) . '">' . esc_html($sub['title']) . '</a></li>';
                }
                echo '</ul>';
                echo '</div>'; // .za-mega-col
            }
            
            echo '</div>'; // .za-mega-inner
            echo '</div>'; // .za-mega-dropdown
        }

        echo '</li>';
    }
    echo '</ul>';
}

/**
 * Renders Mobile Accordion Navigation
 */
function zynova_render_mobile_navigation() {
    $tree = zynova_get_navigation_tree();

    echo '<ul class="za-mobile-nav-list">';
    foreach ($tree as $key => $item) {
        $has_mega = ($item['type'] === 'mega' && !empty($item['columns']));

        $m_classes = ['za-mobile-nav-item', 'item-' . sanitize_html_class($key)];
        if ($has_mega) $m_classes[] = 'has-accordion';

        echo '<li class="' . esc_attr(implode(' ', $m_classes)) . '" data-nav-key="' . esc_attr($key) . '">';
        
        echo '<div class="za-mobile-item-row">';
        echo '<a href="' . esc_url($item['url']) . '" class="za-mobile-link">' . esc_html($item['title']) . '</a>';
        if ($has_mega) {
            echo '<button type="button" class="za-mobile-toggle-btn" aria-label="Toggle Submenu">';
            echo '<svg width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            echo '</button>';
        }
        echo '</div>';

        if ($has_mega) {
            echo '<div class="za-mobile-accordion-content">';
            foreach ($item['columns'] as $col) {
                echo '<div class="za-mobile-subgroup">';
                echo '<span class="za-mobile-subheading">' . esc_html($col['heading']) . '</span>';
                echo '<ul class="za-mobile-sublinks">';
                foreach ($col['items'] as $sub) {
                    echo '<li><a href="' . esc_url($sub['url']) . '">' . esc_html($sub['title']) . '</a></li>';
                }
                echo '</ul>';
                echo '</div>';
            }
            echo '</div>';
        }

        echo '</li>';
    }
    echo '</ul>';
}

