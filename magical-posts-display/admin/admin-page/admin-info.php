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
        add_action('admin_notices', [__CLASS__, 'admin_notice_update_info']);
        add_action('admin_notices', [__CLASS__, 'admin_notice_minimum_php_version']);
        add_action('admin_notices', [__CLASS__, 'admin_notice_missing_main_plugin']);
        add_action('init', [__CLASS__, 'elementor_notice_hide_options']);
    }

    static function mp_display_admin_info_output()
    {

?>
        <div class="mgadin-hero">
            <div class="mge-info-content">
                <div class="mge-info-hello">
                    <?php
                    $addons_name = esc_html__('Magical Posts Display, ', 'magical-posts-display');
                    $current_user = wp_get_current_user();

                    $pro_link = esc_url('https://wpthemespace.com/product/magical-posts-display-pro/?add-to-cart=8239');
                    $pricing_link = esc_url('https://wpthemespace.com/product/magical-posts-display-pro/');

                    esc_html_e('Hey there, ', 'magical-posts-display');
                    echo esc_html($current_user->display_name);
                    ?>

                    <?php esc_html_e('�', 'magical-posts-display'); ?>
                </div>
                <div class="mge-info-desc">
                    <div><?php printf(esc_html__('Ready to SUPERCHARGE your content display? 🚀 Our PRO version transforms your website with advanced post layouts, lightning-fast AJAX filters, social sharing, reading time, and 50+ premium features that drive MORE engagement! ⚡', 'magical-posts-display'), esc_html($addons_name)); ?></div>
                    <div class="mge-offer"><?php printf(esc_html__('💥 LIMITED TIME: Get PRO for just $21 and unlock UNLIMITED possibilities! Join 10,000+ happy customers! �', 'magical-posts-display'), esc_html($addons_name)); ?></div>
                </div>
                <div class="mge-info-actions">
                    <a href="<?php echo esc_url($pro_link); ?>" target="_blank" class="button button-primary upgrade-btn">
                        <?php esc_html_e('🚀 GET PRO NOW - $21', 'magical-posts-display'); ?>
                    </a>
                    <a href="<?php echo esc_url($pricing_link); ?>" target="_blank" class="button button-primary demo-btn">
                        <?php esc_html_e('💎 See All Features', 'magical-posts-display'); ?>
                    </a>
                    <button class="button button-info mgad-dismiss mgade-notice-hide"><?php esc_html_e('Maybe Later', 'magical-posts-display') ?></button>
                </div>
            </div>

        </div>
    <?php
    }


    /**
     * Show update notice for new features
     *
     * @since 1.2.53
     * @access public
     */
    public static function admin_notice_update_info()
    {
        $hide_notice_update = get_option('mgpd_update_notice_1_2_53');
        if (!empty($hide_notice_update)) {
            return;
        }

        $dismiss_url = wp_nonce_url(
            add_query_arg('mgpd_update_hide', '1'),
            'mgpd_update_notice',
            '_wpnonce'
        );
    ?>
        <div class="notice notice-info is-dismissible mgpd-update-notice" style="border-left-color: #00a0d2; padding: 15px;">
            <h3 style="margin: 0 0 10px 0;"><?php echo esc_html__('🎉 Magical Posts Display v1.2.53 - Major Update!', 'magical-posts-display'); ?></h3>
            <p><strong><?php echo esc_html__('What\'s New:', 'magical-posts-display'); ?></strong></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><?php echo esc_html__('✨ Premium Features: Reading Time, View Count, and Social Share Buttons', 'magical-posts-display'); ?></li>
                <li><?php echo esc_html__('🎨 Three Display Styles: Default, Image Top, and Image Overlay positions', 'magical-posts-display'); ?></li>
                <li><?php echo esc_html__('📹 Advanced Media Support: Video, Gallery with priority fallback system', 'magical-posts-display'); ?></li>
                <li><?php echo esc_html__('🎭 Hover Effects: Zoom, Lift, Tilt animations for cards', 'magical-posts-display'); ?></li>
                <li><?php echo esc_html__('🔧 AJAX Optimization: Category filtering and infinite scroll improvements', 'magical-posts-display'); ?></li>
                <li><?php echo esc_html__('🎯 Filter Buttons: Complete styling controls in Style tab', 'magical-posts-display'); ?></li>
                <li><?php echo esc_html__('🔒 Security: Enhanced nonce verification and sanitization', 'magical-posts-display'); ?></li>
                <li><?php echo esc_html__('♻️ Code Quality: Refactored for better performance and maintainability', 'magical-posts-display'); ?></li>
            </ul>
            <p>
                <a href="<?php echo esc_url($dismiss_url); ?>" class="button button-primary"><?php echo esc_html__('Got it, thanks!', 'magical-posts-display'); ?></a>
                <a href="https://wpthemespace.com/product/magical-posts-display-pro/" target="_blank" class="button button-secondary" style="margin-left: 10px;"><?php echo esc_html__('Upgrade to Pro', 'magical-posts-display'); ?></a>
            </p>
        </div>
    <?php
    }

    public static function mp_display_admin_info()
    {

        $hide_date = get_option('mgpd_pro_info_text1');
        if (!empty($hide_date)) {
            $clickhide = round((time() - strtotime($hide_date)) / 24 / 60 / 60);
            if ($clickhide < 25) {
                return;
            }
        }

        $install_date = get_option('mgposte_install_date');
        if (!empty($install_date)) {
            $install_day = round((time() - strtotime($install_date)) / 24 / 60 / 60);
            if ($install_day < 5) {
                return;
            }
        }
    ?>
        <div class="mgadin-notice notice notice-success mgadin-theme-dashboard mgadin-theme-dashboard-notice mge is-dismissible meis-dismissible">
            <?php mgpAdminInfo::mp_display_admin_info_output(); ?>
        </div>

<?php


    }

    public static function mp_display_admin_info_init()
    {
        if (isset($_GET['mgrecnot']) && absint($_GET['mgrecnot']) === 1) {
            update_option('mgpd_pro_info_text1', current_time('mysql'));
        }

        // Hide update notice
        if (isset($_GET['mgpd_update_hide']) && absint($_GET['mgpd_update_hide']) === 1 && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'mgpd_update_notice')) {
            update_option('mgpd_update_notice_1_2_53', 1);
        }
    }

    /**
     * Hide Elementor notice options handler
     */
    public static function elementor_notice_hide_options()
    {
        // Security check with nonce verification
        if (isset($_GET['mgelhide']) && absint($_GET['mgelhide']) === 1 && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'mgpd_hide_notice')) {
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
        if (version_compare(PHP_VERSION, '5.6', '>=')) {
            return;
        }

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'magical-posts-display'),
            '<strong>' . esc_html__('Magical Posts Display', 'magical-posts-display') . '</strong>',
            '<strong>' . esc_html__('PHP', 'magical-posts-display') . '</strong>',
            '5.6'
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
