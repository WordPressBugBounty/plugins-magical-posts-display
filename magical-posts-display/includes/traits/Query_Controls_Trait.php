<?php

/**
 * Query Controls Trait
 * 
 * Provides post position/offset controls for Elementor widgets
 * Allows users to display specific posts or offset the query
 * 
 * @package MagicalPostsDisplay
 * @since 1.2.55
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

trait Query_Controls_Trait
{
    /**
     * Get post position options for the SELECT control
     * 
     * @return array Options array for post position control
     */
    protected function get_post_position_options()
    {
        return [
            'all'         => esc_html__('All Posts', 'magical-posts-display'),
            'first_only'  => esc_html__('1st Post Only', 'magical-posts-display'),
            'second_only' => esc_html__('2nd Post Only', 'magical-posts-display'),
            'third_only'  => esc_html__('3rd Post Only', 'magical-posts-display'),
            'fourth_only' => esc_html__('4th Post Only', 'magical-posts-display'),
            'from_second' => esc_html__('Posts from 2nd', 'magical-posts-display'),
            'from_third'  => esc_html__('Posts from 3rd', 'magical-posts-display'),
            'from_fourth' => esc_html__('Posts from 4th', 'magical-posts-display'),
            'from_fifth'  => esc_html__('Posts from 5th', 'magical-posts-display'),
            'from_sixth'  => esc_html__('Posts from 6th', 'magical-posts-display'),
        ];
    }

    /**
     * Register post position control
     * 
     * Call this method after the posts count control in the query section
     * 
     * @param string $filter_control_id The ID of the filter control (e.g., 'mgpg_posts_filter')
     * @return void
     */
    protected function register_post_position_control($filter_control_id = 'mgpg_posts_filter')
    {
        $this->add_control(
            'mgp_post_position',
            [
                'label'       => esc_html__('Post Position', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'all',
                'options'     => $this->get_post_position_options(),
                'description' => esc_html__('Select which post(s) to display from the query results', 'magical-posts-display'),
                'condition'   => [
                    $filter_control_id . '!' => ['show_byid', 'show_byid_manually'],
                ],
            ]
        );
    }

    /**
     * Apply post position settings to WP_Query args
     * 
     * Call this method before creating a new WP_Query instance
     * 
     * @param array  $args     WP_Query arguments array
     * @param array  $settings Widget settings array
     * @param string $filter_key The settings key for the filter (e.g., 'mgpg_posts_filter')
     * @return array Modified WP_Query arguments
     */
    protected function apply_post_position_to_query($args, $settings, $filter_key = 'mgpg_posts_filter')
    {
        // Get filter value to check if we should skip
        $filter = isset($settings[$filter_key]) ? $settings[$filter_key] : 'recent';
        
        // Skip if using specific post IDs
        if (in_array($filter, ['show_byid', 'show_byid_manually'], true)) {
            return $args;
        }

        // Get post position setting
        $post_position = isset($settings['mgp_post_position']) ? $settings['mgp_post_position'] : 'all';

        // If 'all' is selected, return args unchanged
        if ($post_position === 'all') {
            return $args;
        }

        // Handle single post positions (*_only options)
        $single_positions = [
            'first_only'  => 0,
            'second_only' => 1,
            'third_only'  => 2,
            'fourth_only' => 3,
        ];

        if (isset($single_positions[$post_position])) {
            $args['posts_per_page'] = 1;
            $args['offset'] = $single_positions[$post_position];
            return $args;
        }

        // Handle offset positions (from_* options)
        $offset_positions = [
            'from_second' => 1,
            'from_third'  => 2,
            'from_fourth' => 3,
            'from_fifth'  => 4,
            'from_sixth'  => 5,
        ];

        if (isset($offset_positions[$post_position])) {
            $args['offset'] = $offset_positions[$post_position];
            return $args;
        }

        return $args;
    }
}
