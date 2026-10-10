<?php

/**
 * Modern Admin Dashboard & Widgets Controller
 *
 * @package Magical Posts Display
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('mgpDisplayWelcomePage')) :
    class mgpDisplayWelcomePage
    {
        function __construct()
        {
            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'admin_menu'));
            add_action('wp_ajax_mgpd_install_activate_addons', array($this, 'ajax_install_activate_addons'));
            add_action('wp_ajax_mgpd_save_elements', array($this, 'ajax_save_elements'));
        }

        function admin_init()
        {
            $this->maybe_save_elements();
        }

        public function ajax_save_elements()
        {
            check_ajax_referer('mgpd_save_elements', 'nonce');

            if (!current_user_can('manage_options')) {
                wp_send_json_error(array('message' => esc_html__('Permission denied.', 'magical-posts-display')));
            }

            $defaults        = function_exists('mpd_get_default_elements') ? mpd_get_default_elements() : array();
            $posted_elements = isset($_POST['elements']) && is_array($_POST['elements']) ? map_deep(wp_unslash($_POST['elements']), 'sanitize_text_field') : array();

            $new_elements = array();
            foreach ($defaults as $key => $val) {
                $new_elements[$key] = isset($posted_elements[$key]) ? 1 : 0;
            }

            update_option('mgpd_active_elements', $new_elements);

            wp_send_json_success(array(
                'message'      => esc_html__('Widget settings saved successfully!', 'magical-posts-display'),
                'active_count' => count(array_filter($new_elements)),
            ));
        }

        public function ajax_install_activate_addons()
        {
            check_ajax_referer('mgpd_admin_nonce', 'nonce');

            if (!current_user_can('activate_plugins')) {
                wp_send_json_error(array('message' => esc_html__('Permission denied.', 'magical-posts-display')));
            }

            $plugin_slug = 'magical-addons-for-elementor';
            $plugin_file = 'magical-addons-for-elementor/magical-addons-for-elementor.php';

            if (!function_exists('is_plugin_active')) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }

            if (is_plugin_active($plugin_file) || function_exists('mg_tb') || class_exists('MgTB')) {
                wp_send_json_success(array(
                    'message'      => esc_html__('Magical Addons is already active!', 'magical-posts-display'),
                    'redirect_url' => admin_url('admin.php?page=magical-addons#/theme-builder'),
                ));
            }

            if (!file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
                if (!current_user_can('install_plugins')) {
                    wp_send_json_error(array('message' => esc_html__('Permission denied to install plugins.', 'magical-posts-display')));
                }

                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

                $api = plugins_api('plugin_information', array(
                    'slug'   => $plugin_slug,
                    'fields' => array(
                        'short_description' => false,
                        'sections'          => false,
                        'requires'          => false,
                        'rating'            => false,
                        'ratings'           => false,
                        'downloaded'        => false,
                        'last_updated'      => false,
                        'added'             => false,
                        'tags'              => false,
                        'compatibility'     => false,
                        'homepage'          => false,
                        'donate_link'       => false,
                    ),
                ));

                if (is_wp_error($api)) {
                    wp_send_json_error(array('message' => $api->get_error_message()));
                }

                $skin     = new Automatic_Upgrader_Skin();
                $upgrader = new Plugin_Upgrader($skin);
                $result   = $upgrader->install($api->download_link);

                if (is_wp_error($result)) {
                    wp_send_json_error(array('message' => $result->get_error_message()));
                }

                if (!$result) {
                    wp_send_json_error(array('message' => esc_html__('Plugin installation failed.', 'magical-posts-display')));
                }
            }

            $activate_result = activate_plugin($plugin_file);

            if (is_wp_error($activate_result)) {
                wp_send_json_error(array('message' => $activate_result->get_error_message()));
            }

            wp_send_json_success(array(
                'message'      => esc_html__('Magical Addons activated successfully!', 'magical-posts-display'),
                'redirect_url' => admin_url('admin.php?page=magical-addons#/theme-builder'),
            ));
        }

        function maybe_save_elements()
        {
            if (isset($_POST['mgpd_save_elements_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mgpd_save_elements_nonce'])), 'mgpd_save_elements')) {
                if (!current_user_can('manage_options')) {
                    wp_die(esc_html__('Sorry, you are not allowed to edit these settings.', 'magical-posts-display'));
                }

                $defaults        = function_exists('mpd_get_default_elements') ? mpd_get_default_elements() : array();
                $posted_elements = isset($_POST['mgpd_elements']) && is_array($_POST['mgpd_elements']) ? map_deep(wp_unslash($_POST['mgpd_elements']), 'sanitize_text_field') : array();

                $new_elements = array();
                foreach ($defaults as $key => $val) {
                    $new_elements[$key] = isset($posted_elements[$key]) ? 1 : 0;
                }

                update_option('mgpd_active_elements', $new_elements);
                add_settings_error('mgpd_elements_notices', 'mgpd_elements_saved', __('Widget settings saved successfully!', 'magical-posts-display'), 'updated');
            }
        }

        function admin_menu()
        {
            $menu_text = class_exists('magicalPostDisplayPro') ? esc_html__('Magical Posts Display Pro', 'magical-posts-display') : esc_html__('Magical Posts Display', 'magical-posts-display');

            add_menu_page($menu_text, $menu_text, 'manage_options', 'mgpd-page', array($this, 'plugin_page'), 'dashicons-tickets-alt', 20);

            add_submenu_page('mgpd-page', esc_html__("Dashboard", 'magical-posts-display'), esc_html__("Dashboard", 'magical-posts-display'), "manage_options", 'mgpd-page', array($this, 'plugin_page'));
            add_submenu_page('mgpd-page', esc_html__("Widgets Manager", 'magical-posts-display'), esc_html__("Widgets Manager", 'magical-posts-display'), "manage_options", 'mgpd-page#magical_ptab_elements', array($this, 'plugin_page'));
            add_submenu_page('mgpd-page', esc_html__("Presets & Guide", 'magical-posts-display'), esc_html__("Presets & Guide", 'magical-posts-display'), "manage_options", 'mgpd-page#magical_ptab_presets', array($this, 'plugin_page'));
        }

        // Overview / Dashboard tab
        function magical_welcome_tabs()
        {
            include MAGICAL_POSTS_DISPLAY_DIR . 'admin/admin-page/welcome-page.php';
        }

        // Elements Manager tab
        function magical_elements_tabs()
        {
            include MAGICAL_POSTS_DISPLAY_DIR . 'admin/admin-page/elements-manager.php';
        }

        // Presets & Guide tab
        function magical_presets_tabs()
        {
            include MAGICAL_POSTS_DISPLAY_DIR . 'admin/admin-page/presets-guide.php';
        }

        function plugin_page()
        {
            ?>
            <div class="wrap magical-posts-wrap">
                <h1 class="wp-heading-inline screen-reader-text"><?php esc_html_e('Magical Posts Display', 'magical-posts-display'); ?></h1>
                <hr class="wp-header-end">

                <nav class="nav-tab-wrapper mgpd-nav-tab-wrapper" aria-label="<?php esc_attr_e('Magical Posts Display Navigation', 'magical-posts-display'); ?>">
                    <a href="#magical_ptab_home" class="nav-tab nav-tab-active" id="magical_ptab_home-tab">
                        <span class="dashicons dashicons-dashboard" style="margin-right:4px;"></span><?php esc_html_e('Dashboard', 'magical-posts-display'); ?>
                    </a>
                    <a href="#magical_ptab_elements" class="nav-tab" id="magical_ptab_elements-tab">
                        <span class="dashicons dashicons-admin-generic" style="margin-right:4px;"></span><?php esc_html_e('Widgets Manager', 'magical-posts-display'); ?>
                    </a>
                    <a href="#magical_ptab_presets" class="nav-tab" id="magical_ptab_presets-tab">
                        <span class="dashicons dashicons-art" style="margin-right:4px;"></span><?php esc_html_e('Presets & Guide', 'magical-posts-display'); ?>
                    </a>
                </nav>

                <div class="mgpd-tab-contents">
                    <div id="magical_ptab_home" class="mgpd-tab-panel mgpd-tab-active" style="display: block;">
                        <?php $this->magical_welcome_tabs(); ?>
                    </div>
                    <div id="magical_ptab_elements" class="mgpd-tab-panel" style="display: none;">
                        <?php $this->magical_elements_tabs(); ?>
                    </div>
                    <div id="magical_ptab_presets" class="mgpd-tab-panel" style="display: none;">
                        <?php $this->magical_presets_tabs(); ?>
                    </div>
                </div>

                <script type="text/javascript">
                var mgpdAdmin = {
                    ajax_url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                    nonce: '<?php echo esc_js(wp_create_nonce('mgpd_admin_nonce')); ?>'
                };

                jQuery(document).ready(function($) {
                    function activateTab(targetHash) {
                        if (!targetHash || !$(targetHash).length) {
                            targetHash = '#magical_ptab_home';
                        }
                        $('.mgpd-nav-tab-wrapper .nav-tab').removeClass('nav-tab-active');
                        $(targetHash + '-tab').addClass('nav-tab-active');
                        $('.mgpd-tab-panel').hide();
                        $(targetHash).fadeIn(120);
                        if (typeof(localStorage) !== 'undefined') {
                            localStorage.setItem('mgpd_active_tab', targetHash);
                        }
                    }

                    // Check initial active tab
                    var initialTab = window.location.hash;
                    if (!initialTab && typeof(localStorage) !== 'undefined') {
                        var stored = localStorage.getItem('mgpd_active_tab');
                        if (stored && $(stored).length) {
                            initialTab = stored;
                        }
                    }
                    if (initialTab && $(initialTab).length) {
                        activateTab(initialTab);
                    }

                    // On tab click
                    $('.mgpd-nav-tab-wrapper .nav-tab, .mgpd-tab-trigger').on('click', function(e) {
                        var href = $(this).attr('href');
                        if (href && href.indexOf('#magical_ptab_') === 0) {
                            e.preventDefault();
                            activateTab(href);
                            if (history.pushState) {
                                history.pushState(null, null, href);
                            } else {
                                window.location.hash = href;
                            }
                        }
                    });

                    // On hashchange
                    $(window).on('hashchange', function() {
                        if (window.location.hash && $(window.location.hash).length) {
                            activateTab(window.location.hash);
                        }
                    });
                });
                </script>
            </div>
            <?php
        }
    }
endif;

new mgpDisplayWelcomePage();
