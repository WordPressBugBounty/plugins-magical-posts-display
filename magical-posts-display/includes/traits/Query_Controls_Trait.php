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
    protected function register_post_position_control($filter_control_id = 'mgpg_posts_filter', $source_control_id = '')
    {
        $condition = [
            $filter_control_id . '!' => ['show_byid', 'show_byid_manually'],
        ];
        if (!empty($source_control_id)) {
            $condition[$source_control_id] = 'custom';
        }

        $this->add_control(
            'mgp_post_position',
            [
                'label'       => esc_html__('Post Position', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'all',
                'options'     => $this->get_post_position_options(),
                'description' => esc_html__('Select which post(s) to display from the query results', 'magical-posts-display'),
                'condition'   => $condition,
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

    /**
     * Get current Elementor document template type.
     *
     * @return string
     */
    protected function get_current_document_template_type()
    {
        $post_id = 0;
        if (!empty($_GET['post'])) {
            $post_id = absint($_GET['post']);
        } elseif (!empty($_POST['editor_post_id'])) {
            $post_id = absint($_POST['editor_post_id']);
        } elseif (!empty($_GET['elementor-preview'])) {
            $post_id = absint($_GET['elementor-preview']);
        } elseif (class_exists('\Elementor\Plugin') && isset(\Elementor\Plugin::$instance->documents)) {
            $doc = \Elementor\Plugin::$instance->documents->get_current();
            if ($doc) {
                $post_id = $doc->get_main_id();
            }
        }

        if ($post_id) {
            $type = get_post_meta($post_id, '_elementor_template_type', true);
            if ($type) {
                return $type;
            }
        }

        return '';
    }

    /**
     * Register Query Source control (Archive vs Custom)
     *
     * @param string $source_key Control key for query source.
     * @param string $notice_key Control key for the archive notice.
     * @param string $per_page_key Control key for archive posts per page.
     * @return void
     */
    protected function register_query_source_controls($source_key = 'mgp_query_source', $notice_key = 'mgp_query_auto_notice', $per_page_key = 'mgp_archive_posts_per_page')
    {
        $is_archive_template = ($this->get_current_document_template_type() === 'archive');
        $default_source = $is_archive_template ? 'archive' : 'custom';

        $this->add_control(
            $source_key,
            [
                'label'       => esc_html__('Query Source', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => $default_source,
                'options'     => [
                    'archive' => esc_html__('Current Query / Archive', 'magical-posts-display'),
                    'custom'  => esc_html__('Custom Query', 'magical-posts-display'),
                ],
                'description' => esc_html__('Select "Current Query / Archive" for Blog & Archive templates, or "Custom Query" for specific posts.', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            $notice_key,
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw'  => '<div style="background: #f0fdf4; border-left: 3px solid #22c55e; padding: 10px 12px; font-size: 12px; line-height: 1.4; color: #166534; border-radius: 4px; margin-bottom: 12px;">' . esc_html__('⚡ Current Archive Query Active: Posts are automatically pulled from the current archive (Category, Tag, Author, Date, Search, or Blog index) with full pagination.', 'magical-posts-display') . '</div>',
                'condition' => [
                    $source_key => 'archive',
                ],
            ]
        );

        $this->add_control(
            $per_page_key,
            [
                'label'       => esc_html__('Posts Per Page', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => '',
                'min'         => 1,
                'max'         => 100,
                'placeholder' => sprintf(esc_html__('Default (%d)', 'magical-posts-display'), get_option('posts_per_page', 10)),
                'description' => esc_html__('Number of posts to display per page. Leave empty to use WordPress Reading settings.', 'magical-posts-display'),
                'condition'   => [
                    $source_key => 'archive',
                ],
            ]
        );
    }

    /**
     * Register posts pagination controls with smart archive detection and Pro locks.
     *
     * @param string $source_key Setting key for query source ('mgpl_query_source', 'mgpg_query_source', etc.)
     * @return void
     */
    protected function register_pagination_section_controls($source_key = 'mgpg_query_source')
    {
        $is_archive_template = ($this->get_current_document_template_type() === 'archive');

        $section_label = $is_archive_template
            ? esc_html__('Posts Pagination', 'magical-posts-display')
            : sprintf('%s %s', esc_html__('Posts Pagination', 'magical-posts-display'), mp_display__pro_only_text());

        $this->start_controls_section(
            'mgpg_pagination',
            [
                'label' => $section_label,
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        if (empty(mp_display_check_main_ok())) {
            $this->add_control(
                'mgpg_pagination_info',
                [
                    'label'     => sprintf('<span style="color:red">%s</span>', esc_html__('The Section only work with pro version.', 'magical-posts-display')),
                    'type'      => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        $source_key => 'custom',
                    ],
                ]
            );
        }

        $this->add_control(
            'mgpg_pagination_show',
            [
                'label'       => esc_html__('Show Pagination', 'magical-posts-display'),
                'description' => esc_html__('Pagination only use the page for perfect display.', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::SWITCHER,
                'label_on'    => esc_html__('Yes', 'magical-posts-display'),
                'label_off'   => esc_html__('No', 'magical-posts-display'),
                'default'     => $is_archive_template ? 'yes' : '',
            ]
        );

        $this->add_control(
            'mgpg_pagination_type',
            [
                'label'     => esc_html__('Pagination Type', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'numbers',
                'options'   => [
                    'numbers'   => esc_html__('Numbers (Standard)', 'magical-posts-display'),
                    'load_more' => sprintf('%s %s', esc_html__('AJAX Load More', 'magical-posts-display'), mp_display__pro_only_text()),
                    'infinite'  => sprintf('%s %s', esc_html__('Infinite Scroll', 'magical-posts-display'), mp_display__pro_only_text()),
                ],
                'condition' => [
                    'mgpg_pagination_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpg_pagination_style',
            [
                'label'     => esc_html__('Pagination Style', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'options'   => [
                    'style1' => esc_html__('style One', 'magical-posts-display'),
                    'style2' => esc_html__('Style Two', 'magical-posts-display'),
                ],
                'default'   => 'style1',
                'condition' => [
                    'mgpg_pagination_show' => 'yes',
                    'mgpg_pagination_type' => 'numbers',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_pagination_align',
            [
                'label'     => esc_html__('Pagination Alignment', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'magical-posts-display'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'magical-posts-display'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'magical-posts-display'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'mgpg_pagination_show' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Determine whether pagination should be displayed.
     *
     * In archive context: Free standard pagination is enabled if switcher is 'yes' (or unset/new widget).
     * In custom query context: Pagination requires Pro.
     *
     * @param array  $settings Widget settings.
     * @param string $source_key Setting key for query source.
     * @param string $pagination_key Setting key for pagination switcher ('mgpg_pagination_show').
     * @return bool
     */
    protected function should_show_pagination($settings, $source_key = 'mgpg_query_source', $pagination_key = 'mgpg_pagination_show')
    {
        $is_archive = $this->should_use_archive_query($settings, $source_key);

        if ($is_archive) {
            // If explicitly toggled off in settings, respect user choice
            if (isset($settings[$pagination_key]) && '' === $settings[$pagination_key]) {
                return false;
            }
            // If 'yes', return true
            if (!empty($settings[$pagination_key]) && 'yes' === $settings[$pagination_key]) {
                return true;
            }
            // If unset (new widget dropped in archive), default to true
            return true;
        }

        // Custom query (normal page): Pro check
        if (mp_display_check_main_ok() || mp_display_author_namet() == 'wptheme space pro') {
            return !empty($settings[$pagination_key]) && 'yes' === $settings[$pagination_key];
        }

        return false;
    }

    /**
     * Check if currently in an archive or blog context.
     *
     * @return bool
     */
    protected function is_archive_context()
    {
        global $wp_query;

        // 1. Frontend check: standard WordPress archive, blog home, search, etc.
        if (is_archive() || is_home() || is_search()) {
            return true;
        }

        // 2. Elementor Editor / Preview check: editing a Theme Builder archive template
        if ($this->get_current_document_template_type() === 'archive') {
            return true;
        }

        // 3. Theme Builder Location check (if MgTB is active)
        if (class_exists('MgTB_Locations') && method_exists('MgTB_Locations', 'detect_location')) {
            $location = \MgTB_Locations::detect_location();
            if (in_array($location, ['archive', 'search'], true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if archive query should be used based on setting and context.
     *
     * @param array  $settings   Widget settings array.
     * @param string $source_key Setting key for query source.
     * @return bool
     */
    protected function should_use_archive_query($settings, $source_key = 'mgp_query_source')
    {
        $source = isset($settings[$source_key]) ? $settings[$source_key] : '';

        if ('archive' === $source) {
            return true;
        }

        if ('custom' === $source) {
            return false;
        }

        // If not set, check context
        return $this->is_archive_context();
    }

    /**
     * Inherit current WordPress archive query variables into $args.
     *
     * @param array $args Original WP_Query arguments.
     * @return array Modified WP_Query arguments with archive parameters.
     */
    protected function apply_archive_query_args($args)
    {
        global $wp_query;

        if ($wp_query instanceof \WP_Query && (is_archive() || is_home() || is_search())) {
            $allowed = [
                'post_type',
                'cat',
                'category_name',
                'tag',
                'tag_id',
                'tax_query',
                's',
                'year',
                'monthnum',
                'day',
                'author',
                'author_name',
                'orderby',
                'order',
            ];

            foreach ($allowed as $key) {
                if (isset($wp_query->query_vars[$key]) && '' !== $wp_query->query_vars[$key] && [] !== $wp_query->query_vars[$key]) {
                    $args[$key] = $wp_query->query_vars[$key];
                }
            }
        }

        // Ensure post_type is set (default to 'post' if empty)
        if (empty($args['post_type'])) {
            $args['post_type'] = 'post';
        }

        return $args;
    }
}

