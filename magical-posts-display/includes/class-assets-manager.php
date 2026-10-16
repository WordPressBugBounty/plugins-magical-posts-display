<?php

/**
 * Assets Manager Class
 * 
 * Handles conditional CSS and JS registration and enqueuing for the plugin
 * 
 * @package Magical Posts Display
 * @since 1.2.54
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MPD_Assets_Manager
{
    /**
     * Initialize the assets manager
     */
    public static function init()
    {
        add_action('admin_enqueue_scripts', [__CLASS__, 'admin_scripts']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'register_frontend_assets'], 10);
        add_action('elementor/frontend/after_register_styles', [__CLASS__, 'register_frontend_styles'], 10);
        add_action('elementor/frontend/after_register_scripts', [__CLASS__, 'register_frontend_scripts'], 10);
        add_action('enqueue_block_editor_assets', [__CLASS__, 'block_editor_scripts']);
    }

    /**
     * Add style and scripts for admin
     */
    public static function admin_scripts($hook = '')
    {
        // Strictly prevent loading any Magical Posts Display assets on WooCommerce admin screens
        if (isset($_GET['page']) && (strpos(sanitize_text_field($_GET['page']), 'wc') === 0 || strpos(sanitize_text_field($_GET['page']), 'woocommerce') === 0)) {
            return;
        }
        if (!empty($hook) && (strpos($hook, 'woocommerce') !== false || strpos($hook, 'wc-') !== false)) {
            return;
        }

        if (isset($_GET['page']) && sanitize_text_field($_GET['page']) === 'mgpd-page') {
            wp_enqueue_style(
                'mp-admin-page',
                MAGICAL_POSTS_DISPLAY_URL . '/assets/css/mgadmin-page.css',
                array(),
                MAGICAL_POSTS_DISPLAY_VERSION,
                'all'
            );
            wp_enqueue_style(
                'venobox.min',
                MAGICAL_POSTS_DISPLAY_URL . '/assets/css/venobox.min.css',
                array(),
                MAGICAL_POSTS_DISPLAY_VERSION,
                'all'
            );
            wp_enqueue_script(
                'venobox-js',
                MAGICAL_POSTS_DISPLAY_URL . '/assets/js/venobox.min.js',
                array('jquery'),
                MAGICAL_POSTS_DISPLAY_VERSION,
                true
            );
        }

        // Admin notice styles & snooze script (Only enqueue when Pro is not active)
        if (!mpd_check_plugin_active('magical-posts-display-pro/magical-posts-display-pro.php')) {
            wp_enqueue_style(
                'mp-admin-style',
                MAGICAL_POSTS_DISPLAY_URL . '/assets/css/admin-style.css',
                array(),
                MAGICAL_POSTS_DISPLAY_VERSION,
                'all'
            );

            wp_enqueue_script(
                'mgntc-js',
                MAGICAL_POSTS_DISPLAY_URL . '/assets/js/mgntc.js',
                array('jquery'),
                MAGICAL_POSTS_DISPLAY_VERSION,
                true
            );

            wp_localize_script(
                'mgntc-js',
                'mgpd_notice_data',
                array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce'    => wp_create_nonce('mgpd_hide_pro_notice'),
                )
            );
        }
    }

    /**
     * Register all frontend styles and scripts.
     * Only enqueued conditionally by widgets or when inside Elementor editor.
     */
    public static function register_frontend_assets()
    {
        self::register_frontend_styles();
        self::register_frontend_scripts();

        // Enqueue preview assets only when in Elementor editor or preview mode
        if (did_action('elementor/loaded')) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()) {
                self::enqueue_editor_preview_assets();
            }
        }
    }

    /**
     * Register frontend styles
     */
    public static function register_frontend_styles()
    {
        if (!wp_style_is('swiper', 'registered')) {
            wp_register_style(
                'swiper',
                MAGICAL_POSTS_DISPLAY_URL . '/assets/css/swiper.min.css',
                [],
                '8.4.5',
                'all'
            );
        }

        wp_register_style(
            'venobox.min',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/venobox.min.css',
            array(),
            '1.0.0',
            'all'
        );

        wp_register_style(
            'mpd-fonts',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/fontello.css',
            array(),
            MAGICAL_POSTS_DISPLAY_VERSION,
            'all'
        );

        wp_register_style(
            'mpd-style',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/mp-style.css',
            array(),
            MAGICAL_POSTS_DISPLAY_VERSION,
            'all'
        );

        wp_register_style(
            'mp-accordion-style',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/widget-style/mp-accordion.css',
            array(),
            MAGICAL_POSTS_DISPLAY_VERSION,
            'all'
        );

        wp_register_style(
            'mp-tab-style',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/widget-style/mp-tabs.css',
            array(),
            MAGICAL_POSTS_DISPLAY_VERSION,
            'all'
        );

        wp_register_style(
            'magical-news-magazine-grid',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/news-magazine-grid.css',
            array(),
            MAGICAL_POSTS_DISPLAY_VERSION,
            'all'
        );

        wp_register_style(
            'magical-news-magazine-img-grid',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/news-magazine-img-grid.css',
            array(),
            MAGICAL_POSTS_DISPLAY_VERSION,
            'all'
        );

        wp_register_style(
            'mgpd-theme-builder-widgets',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/theme-builder-widgets.css',
            array(),
            MAGICAL_POSTS_DISPLAY_VERSION,
            'all'
        );
    }

    /**
     * Register frontend scripts
     */
    public static function register_frontend_scripts()
    {
        if (!wp_script_is('swiper', 'registered')) {
            wp_register_script(
                'swiper',
                MAGICAL_POSTS_DISPLAY_URL . '/assets/js/swiper.min.js',
                [],
                '8.4.5',
                true
            );
        }

        wp_register_script(
            'jquery.easy-ticker',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/jquery.easy-ticker.min.js',
            ['jquery'],
            '3.1.0',
            true
        );

        wp_register_script(
            'venobox-js',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/venobox.min.js',
            array('jquery'),
            '1.0.0',
            true
        );

        wp_register_script(
            'mgp-bootstrap',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/mgp-bootstrap.js',
            array('jquery'),
            MAGICAL_POSTS_DISPLAY_VERSION,
            true
        );

        wp_register_script(
            'mpd-main',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/main.js',
            array('jquery', 'masonry', 'imagesloaded'),
            MAGICAL_POSTS_DISPLAY_VERSION,
            true
        );

        wp_register_script(
            'mgpd-premium-features',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/mgpd-premium-features.js',
            array('jquery', 'masonry', 'imagesloaded'),
            MAGICAL_POSTS_DISPLAY_VERSION,
            true
        );

        wp_register_script(
            'mpd-slider-script-active',
            MAGICAL_POSTS_DISPLAY_ASSETS . 'js/widgets-active/post-slider-active.js',
            ['jquery', 'swiper'],
            MAGICAL_POSTS_DISPLAY_VERSION,
            true
        );

        wp_register_script(
            'mpd-pcarousel-active',
            MAGICAL_POSTS_DISPLAY_ASSETS . 'js/widgets-active/posts-carousel-active.js',
            ['jquery', 'swiper'],
            MAGICAL_POSTS_DISPLAY_VERSION,
            true
        );

        wp_register_script(
            'mpd-ticker-script-js',
            MAGICAL_POSTS_DISPLAY_ASSETS . 'js/widgets-active/posts-ticker-active.js',
            ['jquery', 'jquery.easy-ticker'],
            MAGICAL_POSTS_DISPLAY_VERSION,
            true
        );

        wp_register_script(
            'mgpd-theme-builder',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/theme-builder.js',
            ['jquery'],
            MAGICAL_POSTS_DISPLAY_VERSION,
            true
        );

        wp_localize_script(
            'mgpd-theme-builder',
            'mgpdThemeBuilder',
            [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('mgpd_theme_nonce'),
                'i18n'    => [
                    'error'    => __('Something went wrong. Please try again.', 'magical-posts-display'),
                    'loading'  => __('Loading...', 'magical-posts-display'),
                    'loadMore' => __('Load More', 'magical-posts-display'),
                ],
            ]
        );
    }

    /**
     * Enqueue assets inside Elementor Editor preview frame
     */
    public static function enqueue_editor_preview_assets()
    {
        wp_enqueue_style('mpd-fonts');
        wp_enqueue_style('mpd-style');
        wp_enqueue_style('mp-accordion-style');
        wp_enqueue_style('mp-tab-style');
        wp_enqueue_style('magical-news-magazine-grid');
        wp_enqueue_style('magical-news-magazine-img-grid');
        wp_enqueue_style('mgpd-theme-builder-widgets');

        wp_enqueue_script('mpd-main');
        wp_enqueue_script('mgp-bootstrap');
        wp_enqueue_script('mpd-slider-script-active');
        wp_enqueue_script('mpd-pcarousel-active');
        wp_enqueue_script('mpd-ticker-script-js');
        wp_enqueue_script('mgpd-theme-builder');
    }

    /**
     * Compatibility stubs for legacy calls
     */
    public static function block_styles()
    {
        self::register_frontend_styles();
    }

    public static function block_scripts()
    {
        self::register_frontend_scripts();
    }

    /**
     * Add styles and scripts for Gutenberg block editor
     */
    public static function block_editor_scripts()
    {
        wp_enqueue_style(
            'mp-admin-block',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/mgblock-admin.css',
            array(),
            '1.0.0',
            'all'
        );
    }
}
