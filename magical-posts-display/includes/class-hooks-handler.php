<?php

/**
 * Hooks Handler Class
 * 
 * Manages all WordPress hooks and actions for the plugin
 * 
 * @package Magical Posts Display
 * @since 1.2.54
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MPD_Hooks_Handler
{
    /**
     * Initialize all hooks
     */
    public static function init()
    {
        // Plugin activation/deactivation hooks
        register_activation_hook(MAGICAL_POSTS_DISPLAY_FILE, [__CLASS__, 'activation_setup']);
        register_deactivation_hook(MAGICAL_POSTS_DISPLAY_FILE, [__CLASS__, 'deactivation_setup']);

        // WordPress core hooks
        add_action('wp_head', [__CLASS__, 'count_post_visits']);
        add_image_size('slider-bg', 1600, 600, true);
        add_image_size('card-grid', 600, 900, true);
        add_image_size('card-list', 600, 700, true);
    }

    /**
     * Plugin activation setup
     */
    public static function activation_setup()
    {
        // Trigger our function that registers the custom post type
        if (function_exists('mp_display_post_type')) {
            mp_display_post_type();
        }

        // Clear the permalinks after the post type has been registered
        flush_rewrite_rules();

        // Add new administrator role
        if (function_exists('mp_display_admin_role')) {
            mp_display_admin_role();
        }
    }

    /**
     * Plugin deactivation setup
     */
    public static function deactivation_setup()
    {
        // Clear the permalinks to remove our post type's rules
        flush_rewrite_rules();

        // Remove administrator role
        if (function_exists('mp_display_admin_role_remove')) {
            mp_display_admin_role_remove();
        }
    }

    /**
     * Count post visits
     */
    public static function count_post_visits()
    {
        if (is_single()) {
            global $post;
            $views = get_post_meta($post->ID, 'mpd_my_post_viewed', true);
            if ($views == '') {
                update_post_meta($post->ID, 'mpd_my_post_viewed', '1');
            } else {
                $views_no = intval($views);
                update_post_meta($post->ID, 'mpd_my_post_viewed', ++$views_no);
            }
        }
    }
}
