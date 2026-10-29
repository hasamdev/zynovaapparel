<?php
/**
 * Request a Quote Modal and AJAX Handler
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the Quote Modal markup
 */
function zynova_render_quote_modal() {
    ?>
    <div id="za-quote-modal" class="za-modal-backdrop" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="za-quote-title">
        <div class="za-modal-container">
            <div class="za-modal-header">
                <div class="za-modal-brand">
                    <span class="za-badge-za">ZA</span>
                    <div>
                        <h3 id="za-quote-title">Request a Custom Quote</h3>
                        <p class="za-modal-subtitle">OEM/ODM Manufacturing & Custom Gear Inquiries</p>
                    </div>
                </div>
                <button type="button" class="za-modal-close" aria-label="Close dialog">&times;</button>
            </div>

            <form id="za-quote-form" class="za-quote-form" method="post">
                <?php wp_nonce_field('za_quote_nonce_action', 'za_quote_nonce'); ?>
                <input type="hidden" name="action" value="za_submit_quote_inquiry">

                <div class="za-form-row">
                    <div class="za-form-group">
                        <label for="za_quote_name">Full Name *</label>
                        <input type="text" id="za_quote_name" name="name" required placeholder="Your full name">
                    </div>
                    <div class="za-form-group">
                        <label for="za_quote_email">Email Address *</label>
                        <input type="email" id="za_quote_email" name="email" required placeholder="your.name@company.com">
                    </div>
                </div>

                <div class="za-form-row">
                    <div class="za-form-group">
                        <label for="za_quote_phone">Phone / WhatsApp</label>
                        <input type="tel" id="za_quote_phone" name="phone" placeholder="+1 (555) 000-0000">
                    </div>
                    <div class="za-form-group">
                        <label for="za_quote_category">Category of Interest *</label>
                        <select id="za_quote_category" name="category" required>
                            <option value="">Select a category</option>
                            <option value="Motorcycle & Racing Gear">Motorcycle & Racing Gear</option>
                            <option value="Sportswear & Team Uniforms">Sportswear & Team Uniforms</option>
                            <option value="Fashion Wear & Jackets">Fashion Wear & Jackets</option>
                            <option value="Workwear & Safety Gear">Workwear & Safety Gear</option>
                            <option value="Bags & Duffels">Bags & Duffels</option>
                            <option value="Accessories & Gloves">Accessories & Gloves</option>
                            <option value="Custom OEM/ODM Bulk Project">Custom OEM/ODM Bulk Project</option>
                        </select>
                    </div>
                </div>

                <div class="za-form-row">
                    <div class="za-form-group">
                        <label for="za_quote_quantity">Estimated Quantity (Units)</label>
                        <input type="number" id="za_quote_quantity" name="quantity" min="1" placeholder="e.g. 50, 100, 500+">
                    </div>
                    <div class="za-form-group">
                        <label for="za_quote_country">Country / Delivery Destination</label>
                        <input type="text" id="za_quote_country" name="country" placeholder="e.g. United States, UK, Germany">
                    </div>
                </div>

                <div class="za-form-group">
                    <label for="za_quote_message">Project Details / Specifications *</label>
                    <textarea id="za_quote_message" name="message" rows="4" required placeholder="Describe your product requirements, custom branding, materials, or target delivery timeframe..."></textarea>
                </div>

                <div class="za-form-footer">
                    <button type="submit" class="za-btn za-btn-primary za-btn-block">
                        <span>Submit Quote Request</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                    <div class="za-form-response" aria-live="polite"></div>
                </div>
            </form>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'zynova_render_quote_modal');

/**
 * Handle AJAX quote request
 */
function zynova_ajax_quote_handler() {
    check_ajax_referer('za_quote_nonce_action', 'za_quote_nonce');

    $name     = sanitize_text_field($_POST['name'] ?? '');
    $email    = sanitize_email($_POST['email'] ?? '');
    $phone    = sanitize_text_field($_POST['phone'] ?? '');
    $category = sanitize_text_field($_POST['category'] ?? '');
    $quantity = sanitize_text_field($_POST['quantity'] ?? '');
    $country  = sanitize_text_field($_POST['country'] ?? '');
    $message  = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(['message' => 'Please fill in all required fields.']);
    }

    $to = get_option('admin_email');
    $subject = "New Quote Request from Zynova Apparel Website: " . $name;
    $body = "Name: $name\nEmail: $email\nPhone: $phone\nCategory: $category\nQuantity: $quantity\nCountry: $country\n\nProject Details:\n$message\n";
    $headers = ['Content-Type: text/plain; charset=UTF-8', "Reply-To: $name <$email>"];

    wp_mail($to, $subject, $body, $headers);

    wp_send_json_success(['message' => 'Thank you! Your quote request has been received. Our team will contact you within 24 hours.']);
}
add_action('wp_ajax_za_submit_quote_inquiry', 'zynova_ajax_quote_handler');
add_action('wp_ajax_nopriv_za_submit_quote_inquiry', 'zynova_ajax_quote_handler');

