<?php
/**
 * Template Name: Contact Page
 *
 * @package Zynova_Apparel
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main za-page-main za-contact-page">
    <div class="za-page-header">
        <div class="za-container">
            <h1 class="za-page-title">Contact Zynova Apparel</h1>
            <p class="za-page-subtitle">Get in touch for custom apparel manufacturing, distribution partnerships & wholesale quotes</p>
            <div class="za-heading-bar"></div>
        </div>
    </div>

    <?php zynova_breadcrumbs(); ?>

    <div class="za-container za-content-area">
        <div class="za-contact-grid">
            <!-- Contact Information Cards -->
            <div class="za-contact-info-col">
                <div class="za-contact-card">
                    <div class="za-contact-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <h3>Headquarters & Manufacturing</h3>
                        <p>Sialkot, Punjab, Pakistan</p>
                        <span class="za-text-muted">Global Export Hub for Performance Apparel & Gear</span>
                    </div>
                </div>

                <div class="za-contact-card">
                    <div class="za-contact-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div>
                        <h3>Email Inquiries</h3>
                        <p><a href="mailto:info@zynovaapparel.com">info@zynovaapparel.com</a></p>
                        <span class="za-text-muted">Fast response within 24 hours</span>
                    </div>
                </div>

                <div class="za-contact-card">
                    <div class="za-contact-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div>
                        <h3>Direct Phone / WhatsApp</h3>
                        <p><a href="tel:+923001234567">+92 300 1234567</a></p>
                        <span class="za-text-muted">Direct factory communications</span>
                    </div>
                </div>

                <div class="za-contact-features">
                    <div class="za-feat-badge">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>Verified Manufacturing Facilities</span>
                    </div>
                    <div class="za-feat-badge">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>Reliable On-Time Global Dispatch</span>
                    </div>
                    <div class="za-feat-badge">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Custom OEM / Private Label Services</span>
                    </div>
                </div>
            </div>

            <!-- Interactive Inquiries Form -->
            <div class="za-contact-form-col">
                <div class="za-form-box">
                    <h2>Send Us a Message</h2>
                    <p>Whether you need a sample or have a custom manufacturing order, let us know how we can help.</p>

                    <form id="za-page-contact-form" class="za-quote-form" method="post">
                        <?php wp_nonce_field('za_quote_nonce_action', 'za_quote_nonce'); ?>
                        <input type="hidden" name="action" value="za_submit_quote_inquiry">

                        <div class="za-form-row">
                            <div class="za-form-group">
                                <label for="contact_name">Your Name *</label>
                                <input type="text" id="contact_name" name="name" required placeholder="Full Name">
                            </div>
                            <div class="za-form-group">
                                <label for="contact_email">Email Address *</label>
                                <input type="email" id="contact_email" name="email" required placeholder="name@domain.com">
                            </div>
                        </div>

                        <div class="za-form-row">
                            <div class="za-form-group">
                                <label for="contact_phone">Phone Number</label>
                                <input type="tel" id="contact_phone" name="phone" placeholder="+1...">
                            </div>
                            <div class="za-form-group">
                                <label for="contact_category">Product Category *</label>
                                <select id="contact_category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Motorcycle & Racing Gear">Motorcycle & Racing Gear</option>
                                    <option value="Sportswear">Sportswear</option>
                                    <option value="Fashion Wear">Fashion Wear</option>
                                    <option value="Workwear & Safety">Workwear & Safety</option>
                                    <option value="Bags">Bags</option>
                                    <option value="Accessories">Accessories</option>
                                    <option value="Other">Other / General Question</option>
                                </select>
                            </div>
                        </div>

                        <div class="za-form-group">
                            <label for="contact_message">Your Message *</label>
                            <textarea id="contact_message" name="message" rows="5" required placeholder="Tell us about your requirements..."></textarea>
                        </div>

                        <button type="submit" class="za-btn za-btn-primary za-btn-block">
                            <span>Send Message</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>
                        <div class="za-form-response" aria-live="polite"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();

