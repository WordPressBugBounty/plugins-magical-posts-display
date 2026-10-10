<?php

/**
 * 
 *  Admin info for Magical Addons For Elementor plugin
 * 
 * 
 * 
 */

class mgpAdminInfo
{
    public static function init()
    {
        add_action('admin_notices', [__CLASS__, 'mp_display_admin_info']);
        add_action('init', [__CLASS__, 'mp_display_admin_info_init']);
        add_action('wp_ajax_mgpd_hide_pro_notice', [__CLASS__, 'ajax_hide_pro_notice']);
        add_action('admin_notices', [__CLASS__, 'admin_notice_minimum_php_version']);
        add_action('admin_notices', [__CLASS__, 'admin_notice_missing_main_plugin']);
        add_action('init', [__CLASS__, 'elementor_notice_hide_options']);
    }

    /**
     * AJAX handler to snooze pro notice for 30 days
     */
    public static function ajax_hide_pro_notice()
    {
        check_ajax_referer('mgpd_hide_pro_notice', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => esc_html__('Permission denied.', 'magical-posts-display')));
        }

        update_option('mgpd_pro_info_text1', current_time('mysql'));
        wp_send_json_success(array('message' => esc_html__('Notice snoozed for 30 days.', 'magical-posts-display')));
    }

    public static function mp_display_admin_info_output()
    {
        $current_user = wp_get_current_user();
        $pro_link     = esc_url('https://wpthemespace.com/product/magical-posts-display-pro/?add-to-cart=8239');
        $pricing_link = esc_url('https://wpthemespace.com/product/magical-posts-display-pro/');
        $nonce        = wp_create_nonce('mgpd_hide_pro_notice');
        $ajax_url     = admin_url('admin-ajax.php');
        $user_name    = !empty($current_user->display_name) ? $current_user->display_name : esc_html__('there', 'magical-posts-display');
        ?>
        <div class="mgpd-pro-notice-wrap" data-nonce="<?php echo esc_attr($nonce); ?>" data-ajax-url="<?php echo esc_url($ajax_url); ?>">
            <div class="mgpd-pro-notice-left">
                <div class="mgpd-pro-notice-badge">
                    <span class="mgpd-badge-sparkle">✨</span>
                    <span class="mgpd-badge-title"><?php esc_html_e('MAGICAL POSTS PRO', 'magical-posts-display'); ?></span>
                    <span class="mgpd-badge-pill"><?php esc_html_e('SPECIAL 60% OFF', 'magical-posts-display'); ?></span>
                </div>

                <h3 class="mgpd-pro-notice-title">
                    <?php
                    /* translators: %s: Current user display name */
                    printf(esc_html__('Supercharge Your Post Layouts, %s! 👋', 'magical-posts-display'), esc_html($user_name));
                    ?>
                </h3>

                <p class="mgpd-pro-notice-desc">
                    <?php esc_html_e('Ready to create stunning magazine-style websites? Upgrade to PRO and unlock lightning-fast AJAX filters, reading time indicators, social share counters, and 50+ premium layout controls that keep visitors engaged!', 'magical-posts-display'); ?>
                </p>

                <div class="mgpd-pro-features-grid">
                    <div class="mgpd-pro-feature-item">
                        <span class="mgpd-feat-icon">⚡</span>
                        <span><?php esc_html_e('Instant AJAX Filter & Live Search', 'magical-posts-display'); ?></span>
                    </div>
                    <div class="mgpd-pro-feature-item">
                        <span class="mgpd-feat-icon">🎨</span>
                        <span><?php esc_html_e('50+ Pro Magazine & Grid Skins', 'magical-posts-display'); ?></span>
                    </div>
                    <div class="mgpd-pro-feature-item">
                        <span class="mgpd-feat-icon">📱</span>
                        <span><?php esc_html_e('Social Sharing & Reading Progress Bar', 'magical-posts-display'); ?></span>
                    </div>
                    <div class="mgpd-pro-feature-item">
                        <span class="mgpd-feat-icon">💎</span>
                        <span><?php esc_html_e('Unlimited Sites & Lifetime Priority Updates', 'magical-posts-display'); ?></span>
                    </div>
                </div>

                <div class="mgpd-pro-deal-banner">
                    <span class="mgpd-deal-flame">🔥</span>
                    <span class="mgpd-deal-text">
                        <strong><?php esc_html_e('LIMITED TIME DEAL:', 'magical-posts-display'); ?></strong>
                        <?php esc_html_e('Get Lifetime PRO for only $21 (Regular $49) — Join 10,000+ satisfied creators today!', 'magical-posts-display'); ?>
                    </span>
                </div>

                <div class="mgpd-pro-actions">
                    <a href="<?php echo esc_url($pro_link); ?>" target="_blank" class="button mgpd-btn-upgrade">
                        <span class="mgpd-btn-icon">🚀</span>
                        <span><?php esc_html_e('GET PRO NOW — $21', 'magical-posts-display'); ?></span>
                    </a>
                    <a href="<?php echo esc_url($pricing_link); ?>" target="_blank" class="button mgpd-btn-demo">
                        <span class="mgpd-btn-icon">💎</span>
                        <span><?php esc_html_e('See All Features', 'magical-posts-display'); ?></span>
                    </a>
                    <button type="button" class="button mgpd-btn-dismiss mgade-notice-hide" data-nonce="<?php echo esc_attr($nonce); ?>">
                        <span class="mgpd-btn-icon">⏰</span>
                        <span><?php esc_html_e('Maybe Later (30 Days)', 'magical-posts-display'); ?></span>
                    </button>
                </div>
            </div>

            <div class="mgpd-pro-notice-right">
                <div class="mgpd-pricing-card">
                    <div class="mgpd-pricing-card-badge"><?php esc_html_e('SPECIAL DEAL', 'magical-posts-display'); ?></div>
                    <div class="mgpd-pricing-val">
                        <span class="mgpd-currency">$</span>
                        <span class="mgpd-amount">21</span>
                        <span class="mgpd-term"><?php esc_html_e('/ one-time', 'magical-posts-display'); ?></span>
                    </div>
                    <div class="mgpd-pricing-save">
                        <?php esc_html_e('Regular Price:', 'magical-posts-display'); ?> <del>$49</del>
                    </div>
                    <ul class="mgpd-pricing-perks">
                        <li><span>✔</span> <?php esc_html_e('All 50+ Pro Features', 'magical-posts-display'); ?></li>
                        <li><span>✔</span> <?php esc_html_e('Zero Annual Renewals', 'magical-posts-display'); ?></li>
                        <li><span>✔</span> <?php esc_html_e('14-Day Money Back Guarantee', 'magical-posts-display'); ?></li>
                    </ul>
                    <a href="<?php echo esc_url($pro_link); ?>" target="_blank" class="mgpd-pricing-cta">
                        <?php esc_html_e('Claim Deal Now →', 'magical-posts-display'); ?>
                    </a>
                </div>
            </div>
        </div>
        <?php
    }

    public static function mp_display_admin_info()
    {
        // Don't show in Elementor editor or preview iframe
        if (isset($_GET['elementor-preview']) || (isset($_GET['action']) && $_GET['action'] === 'elementor')) {
            return;
        }

        $hide_date = get_option('mgpd_pro_info_text1');
        if (!empty($hide_date)) {
            $days_passed = round((time() - strtotime($hide_date)) / (24 * 60 * 60));
            if ($days_passed < 30) {
                return;
            }
        }

        $install_date = get_option('mgposte_install_date');
        if (!empty($install_date)) {
            $install_day = round((time() - strtotime($install_date)) / (24 * 60 * 60));
            if ($install_day < 5) {
                return;
            }
        }
        ?>
        <div class="notice mgadin-notice mgadin-pro-upsell-notice is-dismissible">
            <?php self::mp_display_admin_info_output(); ?>
        </div>
        <?php
    }

    public static function mp_display_admin_info_init()
    {
        if (isset($_GET['mgrecnot']) && absint($_GET['mgrecnot']) === 1 && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'mgpd_hide_pro_notice')) {
            update_option('mgpd_pro_info_text1', current_time('mysql'));
        }

        // Hide update notice
        if (isset($_GET['mgpd_update_hide']) && absint($_GET['mgpd_update_hide']) === 1 && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'mgpd_update_notice')) {
            update_option('mgpd_update_notice_1_2_53', 1);
        }
    }

    /**
     * Hide Elementor notice options handler
     */
    public static function elementor_notice_hide_options()
    {
        // Security check with nonce verification
        if (isset($_GET['mgelhide']) && absint($_GET['mgelhide']) === 1 && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'mgpd_hide_notice')) {
            update_option('mgelhide9', 1);
        }
    }

    /**
     * Admin notice for minimum PHP version
     * Warning when the site doesn't have a minimum required PHP version.
     */
    public static function admin_notice_minimum_php_version()
    {
        // Check if we should show this notice
        if (version_compare(PHP_VERSION, '7.4', '>=')) {
            return;
        }

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'magical-posts-display'),
            '<strong>' . esc_html__('Magical Posts Display', 'magical-posts-display') . '</strong>',
            '<strong>' . esc_html__('PHP', 'magical-posts-display') . '</strong>',
            '7.4'
        );

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
            wp_kses_post($message)
        );
    }

    /**
     * Admin notice for missing Elementor plugin
     * Warning when the site doesn't have Elementor installed or activated.
     */
    public static function admin_notice_missing_main_plugin()
    {
        if (get_option('mgelhide9')) {
            return;
        }

        // Only show on specific pages
        global $pagenow;
        if (!in_array($pagenow, array('plugins.php', 'admin.php'))) {
            return;
        }

        // Don't show if Elementor is loaded
        if (did_action('elementor/loaded')) {
            return;
        }

        if (isset($_GET['activate'])) unset($_GET['activate']);

        if (file_exists(WP_PLUGIN_DIR . '/elementor/elementor.php')) {
            $magial_eactive_url = wp_nonce_url('plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php');
            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
                esc_html__('%1$s Recommended %2$s plugin, which is currently NOT RUNNING  %3$s', 'magical-posts-display'),
                '<strong>' . esc_html__('Magical Posts Display', 'magical-posts-display') . '</strong>',
                '<strong>' . esc_html__('Elementor', 'magical-posts-display') . '</strong>',
                '<a class="button button-primary" style="margin-left:20px" href="' . $magial_eactive_url . '">' . __('Activate Elementor', 'magical-posts-display') . '</a>'
            );
        } else {
            $magial_einstall_url =  wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
                esc_html__('%1$s Recommended %2$s plugin for use all Elementor addons, which is currently NOT RUNNING  %3$s', 'magical-posts-display'),
                '<strong>' . esc_html__('Magical Posts Display', 'magical-posts-display') . '</strong>',
                '<strong>' . esc_html__('Elementor', 'magical-posts-display') . '</strong>',
                '<a class="button button-primary" style="margin-left:20px" href="' . $magial_einstall_url . '">' . __('Install Elementor', 'magical-posts-display') . '</a>'
            );
        }

        printf('<div class="notice notice-warning is-dismissible mgpd-notice"><p style="padding: 13px 0">%1$s</p></div>', wp_kses_post($message));
    }
}

// Initialize only if we're in admin and not in pro version
if (is_admin() && !mpd_check_plugin_active('magical-posts-display-pro/magical-posts-display-pro.php')) {
    mgpAdminInfo::init();
}
