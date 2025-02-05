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
    }

    static function mp_display_admin_info_output()
    {

?>
        <div class="mgadin-hero">
            <div class="mge-info-content">
                <div class="mge-info-hello">
                    <?php
                    $addons_name = esc_html__('Magical Addons, ', 'magical-addons-for-elementor');
                    $current_user = wp_get_current_user();

                    $pro_link = esc_url('https://wpthemespace.com/product/magical-posts-display-pro/?add-to-cart=8239');
                    $pricing_link = esc_url('https://wpthemespace.com/product/magical-posts-display-pro/');

                    esc_html_e('Hello, ', 'magical-addons-for-elementor');
                    echo esc_html($current_user->display_name);
                    ?>

                    <?php esc_html_e('👋🏻', 'magical-addons-for-elementor'); ?>
                </div>
                <div class="mge-info-desc">
                    <div><?php printf(esc_html__('Thank you for choosing Magical Posts Display! ✨ We\'re excited to share that our Pro version is now available, with all custom posts display features. Plus, Pagination, QR code, Share button, reading time, wordcount, filters,popup, lightbox and more 🔥', 'magical-addons-for-elementor'), esc_html($addons_name)); ?></div>
                    <div class="mge-offer"><?php printf(esc_html__('Upgrade to Magical Posts Display Pro today and Display your posts the way you want just $21! 🚀', 'magical-addons-for-elementor'), esc_html($addons_name)); ?></div>
                </div>
                <div class="mge-info-actions">
                    <a href="<?php echo esc_url($pro_link); ?>" target="_blank" class="button button-primary upgrade-btn">
                        <?php esc_html_e('Upgrade Now', 'magical-addons-for-elementor'); ?>
                    </a>
                    <a href="<?php echo esc_url($pricing_link); ?>" target="_blank" class="button button-primary demo-btn">
                        <?php esc_html_e('View Details', 'magical-addons-for-elementor'); ?>
                    </a>
                    <button class="button button-info mgad-dismiss mgade-notice-hide"><?php esc_html_e('Dismiss this notice', 'magical-addons-for-elementor') ?></button>
                </div>
            </div>

        </div>
    <?php
    }




    public static function mp_display_admin_info()
    {

        $hide_date = get_option('mgpd_info_protext');
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
        if (isset($_GET['mgrecnot']) && $_GET['mgrecnot'] == 1) {
            update_option('mgpd_info_protext', current_time('mysql'));
        }
    }
}
mgpAdminInfo::init();
