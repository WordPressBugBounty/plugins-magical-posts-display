<?php

/**
 * AJAX Handler Class
 * 
 * Handles all AJAX requests for the plugin
 * 
 * @package Magical Posts Display
 * @since 1.2.54
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MPD_Ajax_Handler
{
    /**
     * Initialize the AJAX handler
     */
    public static function init()
    {
        // AJAX handlers for premium features
        add_action('wp_ajax_mgpd_ajax_filter_posts', [__CLASS__, 'handle_ajax_filter_posts']);
        add_action('wp_ajax_nopriv_mgpd_ajax_filter_posts', [__CLASS__, 'handle_ajax_filter_posts']);
        add_action('wp_ajax_mgpd_infinite_scroll_posts', [__CLASS__, 'handle_ajax_infinite_scroll']);
        add_action('wp_ajax_nopriv_mgpd_infinite_scroll_posts', [__CLASS__, 'handle_ajax_infinite_scroll']);
    }

    /**
     * Ensure Elementor is loaded before loading widget class
     */
    private static function ensure_elementor_loaded()
    {
        // Check if Elementor is loaded
        if (!did_action('elementor/loaded')) {
            // Elementor not loaded yet, but we can still use the static methods
            // since they don't need Elementor's widget rendering
        }
        
        // Load traits if not already loaded
        if (!trait_exists('SVG_Icons_Trait') && file_exists(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/SVG_Icons_Trait.php')) {
            require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/SVG_Icons_Trait.php');
        }
        if (!trait_exists('Advanced_Media_Trait') && file_exists(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/Advanced_Media_Trait.php')) {
            require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/Advanced_Media_Trait.php');
        }
    }

    /**
     * AJAX wrapper for filter posts
     * Ensures widget class is loaded before calling static method
     */
    public static function handle_ajax_filter_posts()
    {
        self::ensure_elementor_loaded();
        
        // Load widget class if not already loaded
        if (!class_exists('mgpdEPostsGrid')) {
            require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/elementor/widgets/posts-grid.php');
        }

        // Call the static method in widget class
        if (class_exists('mgpdEPostsGrid') && method_exists('mgpdEPostsGrid', 'ajax_filter_posts')) {
            mgpdEPostsGrid::ajax_filter_posts();
        } else {
            wp_send_json_error('Method not found');
        }
    }

    /**
     * AJAX wrapper for infinite scroll
     * Ensures widget class is loaded before calling static method
     */
    public static function handle_ajax_infinite_scroll()
    {
        self::ensure_elementor_loaded();
        
        // Load widget class if not already loaded
        if (!class_exists('mgpdEPostsGrid')) {
            require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/elementor/widgets/posts-grid.php');
        }

        // Call the static method in widget class
        if (class_exists('mgpdEPostsGrid') && method_exists('mgpdEPostsGrid', 'ajax_infinite_scroll')) {
            mgpdEPostsGrid::ajax_infinite_scroll();
        } else {
            wp_send_json_error('Method not found');
        }
    }
}
