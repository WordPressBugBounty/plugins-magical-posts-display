<?php

/**
 * Assets Manager Class
 * 
 * Handles all CSS and JS enqueuing for the plugin
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
        add_action('enqueue_block_assets', [__CLASS__, 'block_styles']);
        add_action('enqueue_block_assets', [__CLASS__, 'block_scripts']);
        add_action('enqueue_block_editor_assets', [__CLASS__, 'block_editor_scripts']);
    }

    /**
     * Add style and scripts for admin
     * Add the plugin style and scripts for editor only
     */
    public static function admin_scripts()
    {
        global $pagenow;

        wp_enqueue_style(
            'mp-admin-style',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/admin-style.css',
            array(),
            MAGICAL_POSTS_DISPLAY_VERSION,
            'all'
        );

        // CMB2 conditional logic removed - no longer needed without CMB2

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

        wp_enqueue_script(
            'mgntc-js',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/mgntc.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }

    /**
     * Add frontend block styles
     */
    public static function block_styles()
    {
        wp_register_style(
            'swiper',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/swiper.min.css',
            [],
            '8.4.5',
            'all'
        );

        wp_enqueue_style(
            'venobox.min',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/venobox.min.css',
            array(),
            '1.0.0',
            'all'
        );

        // Bootstrap removed - using custom grid system in mp-style.css

        wp_enqueue_style(
            'mpd-fonts',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/fontello.css',
            array(),
            MAGICAL_POSTS_DISPLAY_VERSION,
            'all'
        );

        wp_enqueue_style(
            'mpd-style',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/css/mp-style.css',
            array(),
            MAGICAL_POSTS_DISPLAY_VERSION,
            'all'
        );
    }

    /**
     * Add frontend block scripts
     */
    public static function block_scripts()
    {
        wp_register_script(
            'mg-swiper',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/swiper.min.js',
            ['jquery'],
            '8.4.5',
            true
        );

        wp_register_script(
            'jquery.easy-ticker',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/jquery.easy-ticker.min.js',
            ['jquery'],
            '3.1.0',
            true
        );

        wp_enqueue_script('masonry');
        wp_enqueue_script('imagesloaded');

        wp_enqueue_script(
            'venobox-js',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/venobox.min.js',
            array('jquery'),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'mgp-bootstrap',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/mgp-bootstrap.js',
            array('jquery'),
            MAGICAL_POSTS_DISPLAY_VERSION,
            true
        );

        wp_enqueue_script(
            'mpd-main',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/main.js',
            array('jquery', 'masonry', 'imagesloaded'),
            MAGICAL_POSTS_DISPLAY_VERSION,
            true
        );

        // Enqueue premium features script
        wp_enqueue_script(
            'mgpd-premium-features',
            MAGICAL_POSTS_DISPLAY_URL . '/assets/js/mgpd-premium-features.js',
            array('jquery', 'masonry', 'imagesloaded'),
            MAGICAL_POSTS_DISPLAY_VERSION,
            true
        );
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
