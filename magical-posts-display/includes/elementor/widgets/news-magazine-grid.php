<?php

class mgpdNewsMagazineGrid extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     */
    public function get_name()
    {
        return 'mgposts_news_magazine_grid';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return __('News/Magazine Grid', 'magical-posts-display');
    }

    /**
     * Get widget icon.
     */
    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    /**
     * Get widget categories.
     */
    public function get_categories()
    {
        return ['mgp-mgposts'];
    }

    /**
     * Get widget keywords.
     */
    public function get_keywords()
    {
        return ['news', 'magazine', 'grid', 'posts', 'layout'];
    }

    /**
     * Get style depends.
     */
    public function get_style_depends()
    {
        // Enqueue the CSS file for this widget
        wp_enqueue_style('magical-news-magazine-grid');
        return ['magical-news-magazine-grid'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls()
    {
        $this->register_content_controls();
        $this->register_style_controls();
    }

    /**
     * Register content controls.
     */
    protected function register_content_controls()
    {
        // Posts Query Section
        $this->start_controls_section(
            'mgps_nmg_query',
            [
                'label' => __('Posts Query', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgps_nmg_post_type',
            [
                'label' => __('Post Type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'options' => mp_display_all_posts_type(),
            ]
        );

        $this->add_control(
            'mgps_nmg_posts_filter',
            [
                'label' => __('Filter By', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'recent',
                'options' => mp_display_post_filter(),
            ]
        );

        $this->add_control(
            'mgps_nmg_post_id',
            [
                'label' => __('Select Posts', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_posts_name(),
                'condition' => [
                    'mgps_nmg_posts_filter' => 'show_byid',
                ]
            ]
        );

        $this->add_control(
            'mgps_nmg_post_ids_manually',
            [
                'label' => __('Post IDs', 'magical-posts-display'),
                'description' => __('Separate IDs with commas', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'mgps_nmg_posts_filter' => 'show_byid_manually',
                ]
            ]
        );

        $this->add_control(
            'mgps_nmg_posts_count',
            [
                'label' => __('Posts Count', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 4,
                'max' => 6,
                'step' => 1,
                'description' => __('Total posts to show (4-6). 1 big post + 3-5 small posts', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgps_nmg_grid_categories',
            [
                'label' => __('Categories', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_taxonomy_list(),
                'condition' => [
                    'mgps_nmg_posts_filter!' => 'show_byid',
                    'mgps_nmg_post_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'mgps_nmg_custom_order',
            [
                'label' => __('Custom Order', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'mgps_nmg_orderby',
            [
                'label' => __('Order By', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'none' => __('None', 'magical-posts-display'),
                    'ID' => __('ID', 'magical-posts-display'),
                    'date' => __('Date', 'magical-posts-display'),
                    'name' => __('Name', 'magical-posts-display'),
                    'title' => __('Title', 'magical-posts-display'),
                    'comment_count' => __('Comment Count', 'magical-posts-display'),
                    'rand' => __('Random', 'magical-posts-display'),
                ],
                'condition' => [
                    'mgps_nmg_custom_order' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgps_nmg_order',
            [
                'label' => __('Order', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => __('Descending', 'magical-posts-display'),
                    'ASC' => __('Ascending', 'magical-posts-display'),
                ],
                'condition' => [
                    'mgps_nmg_custom_order' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        // Layout Settings Section
        $this->start_controls_section(
            'mgps_nmg_layout',
            [
                'label' => __('Layout Settings', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgps_nmg_layout_style',
            [
                'label' => __('Layout Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'style_4',
                'options' => [
                    'style_1' => __('Style 1 (Big Left + Small Right Stack)', 'magical-posts-display'),
                    'style_2' => __('Style 2 (Big Center + Small Left/Right Vertical)', 'magical-posts-display'),
                    'style_3' => __('Style 3 (Big Right + Small Left Stack)', 'magical-posts-display'),
                    'style_4' => __('Style 4 (Big Left + Small Right Grid)', 'magical-posts-display'),
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_grid_style',
            [
                'label' => __('Grid Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid_style_1',
                'options' => [
                    'grid_style_1' => __('Grid Style 1 (Category above title, meta below text)', 'magical-posts-display'),
                    'grid_style_2' => __('Grid Style 2 (Category overlay on image, content below)', 'magical-posts-display'),
                    'grid_style_3' => __('Grid Style 3 (Modern card design)', 'magical-posts-display'),
                ],
                'description' => __('Choose how content is arranged within each post card.', 'magical-posts-display'),
            ]
        );

        $this->end_controls_section();

        // Big Post Settings Section
        $this->start_controls_section(
            'mgps_nmg_big_post',
            [
                'label' => __('Big Post Settings', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_image',
            [
                'label' => __('Show Image', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_title',
            [
                'label' => __('Show Title', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_title_crop',
            [
                'label' => __('Title Word Limit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 8,
                'min' => 1,
                'condition' => [
                    'mgps_nmg_big_post_title' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_title_tag',
            [
                'label' => __('Title HTML Tag', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'condition' => [
                    'mgps_nmg_big_post_title' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_excerpt',
            [
                'label' => __('Show Excerpt', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_excerpt_crop',
            [
                'label' => __('Excerpt Word Limit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'min' => 1,
                'condition' => [
                    'mgps_nmg_big_post_excerpt' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_category',
            [
                'label' => __('Show Category', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_meta',
            [
                'label' => __('Show Meta (Date/Author)', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_big_post_text_align',
            [
                'label' => __('Text Alignment', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justify', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Small Posts Settings Section
        $this->start_controls_section(
            'mgps_nmg_small_posts',
            [
                'label' => __('Small Posts Settings', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_image',
            [
                'label' => __('Show Image', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_title',
            [
                'label' => __('Show Title', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_title_crop',
            [
                'label' => __('Title Word Limit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'condition' => [
                    'mgps_nmg_small_post_title' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_title_tag',
            [
                'label' => __('Title HTML Tag', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h5',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'condition' => [
                    'mgps_nmg_small_post_title' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_excerpt',
            [
                'label' => __('Show Excerpt', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_excerpt_crop',
            [
                'label' => __('Excerpt Word Limit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 12,
                'min' => 1,
                'condition' => [
                    'mgps_nmg_small_post_excerpt' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_category',
            [
                'label' => __('Show Category', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_meta',
            [
                'label' => __('Show Meta (Date/Author)', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_small_post_text_align',
            [
                'label' => __('Text Alignment', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justify', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register style controls.
     */
    protected function register_style_controls()
    {
        // Container Style
        $this->start_controls_section(
            'mgps_nmg_container_style',
            [
                'label' => __('Container', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_container_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-news-magazine-grid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_container_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-news-magazine-grid' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_container_bg',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-news-magazine-grid' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_gap',
            [
                'label' => __('Grid Gap', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-news-magazine-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Big Post Style
        $this->start_controls_section(
            'mgps_nmg_big_post_style',
            [
                'label' => __('Big Post Style', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_bg',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgps_nmg_big_post_border',
                'selector' => '{{WRAPPER}} .mgp-big-post',
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgps_nmg_big_post_shadow',
                'selector' => '{{WRAPPER}} .mgp-big-post',
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_title_style',
            [
                'label' => __('Title Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_title_color',
            [
                'label' => __('Title Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgp-big-post .mgp-post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_title_hover_color',
            [
                'label' => __('Title Hover Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgps_nmg_big_post_title_typography',
                'selector' => '{{WRAPPER}} .mgp-big-post .mgp-post-title',
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_big_post_title_margin',
            [
                'label' => __('Title Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_excerpt_style',
            [
                'label' => __('Excerpt Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_excerpt_color',
            [
                'label' => __('Excerpt Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgps_nmg_big_post_excerpt_typography',
                'selector' => '{{WRAPPER}} .mgp-big-post .mgp-post-excerpt',
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_big_post_excerpt_margin',
            [
                'label' => __('Excerpt Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_image_style',
            [
                'label' => __('Image Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_big_post_image_width',
            [
                'label' => __('Image Width', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_big_post_image_height',
            [
                'label' => __('Image Min Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_image_opacity',
            [
                'label' => __('Image Opacity', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_image_hover_opacity',
            [
                'label' => __('Image Hover Opacity', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post:hover .mgp-post-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgps_nmg_big_post_image_border',
                'selector' => '{{WRAPPER}} .mgp-big-post .mgp-post-image img',
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_image_border_radius',
            [
                'label' => __('Image Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgps_nmg_big_post_image_shadow',
                'selector' => '{{WRAPPER}} .mgp-big-post .mgp-post-image img',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'mgps_nmg_big_post_image_filters',
                'selector' => '{{WRAPPER}} .mgp-big-post .mgp-post-image img',
            ]
        );

        $this->add_control(
            'mgps_nmg_big_post_image_object_fit',
            [
                'label' => __('Object Fit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'fill' => __('Fill', 'magical-posts-display'),
                    'contain' => __('Contain', 'magical-posts-display'),
                    'cover' => __('Cover', 'magical-posts-display'),
                    'scale-down' => __('Scale Down', 'magical-posts-display'),
                    'none' => __('None', 'magical-posts-display'),
                ],
                'default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Small Posts Style
        $this->start_controls_section(
            'mgps_nmg_small_posts_style',
            [
                'label' => __('Small Posts Style', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
         $this->add_responsive_control(
            'mgps_nmg_small_post_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-posts-area .mgp-small-post,
{{WRAPPER}} .mgp-small-posts-grid,  
{{WRAPPER}} .mgp-left-posts-area .mgp-small-post:first-child, 
{{WRAPPER}} .mgp-right-posts-area .mgp-small-post:first-child{
} ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_bg',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgps_nmg_small_post_border',
                'selector' => '{{WRAPPER}} .mgp-small-post',
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgps_nmg_small_post_shadow',
                'selector' => '{{WRAPPER}} .mgp-small-post',
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_title_style',
            [
                'label' => __('Title Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_title_color',
            [
                'label' => __('Title Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgp-small-post .mgp-post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_title_hover_color',
            [
                'label' => __('Title Hover Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgps_nmg_small_post_title_typography',
                'selector' => '{{WRAPPER}} .mgp-small-post .mgp-post-title',
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_small_post_title_margin',
            [
                'label' => __('Title Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_image_style',
            [
                'label' => __('Image Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_small_post_image_width',
            [
                'label' => __('Image Width', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_small_post_image_height',
            [
                'label' => __('Image Min Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_image_opacity',
            [
                'label' => __('Image Opacity', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_image_hover_opacity',
            [
                'label' => __('Image Hover Opacity', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post:hover .mgp-post-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgps_nmg_small_post_image_border',
                'selector' => '{{WRAPPER}} .mgp-small-post .mgp-post-image img',
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_image_border_radius',
            [
                'label' => __('Image Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgps_nmg_small_post_image_shadow',
                'selector' => '{{WRAPPER}} .mgp-small-post .mgp-post-image img',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'mgps_nmg_small_post_image_filters',
                'selector' => '{{WRAPPER}} .mgp-small-post .mgp-post-image img',
            ]
        );

        $this->add_control(
            'mgps_nmg_small_post_image_object_fit',
            [
                'label' => __('Object Fit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'fill' => __('Fill', 'magical-posts-display'),
                    'contain' => __('Contain', 'magical-posts-display'),
                    'cover' => __('Cover', 'magical-posts-display'),
                    'scale-down' => __('Scale Down', 'magical-posts-display'),
                    'none' => __('None', 'magical-posts-display'),
                ],
                'default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Category Style
        $this->start_controls_section(
            'mgps_nmg_category_style',
            [
                'label' => __('Category Style', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgps_nmg_category_color',
            [
                'label' => __('Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-category' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgp-post-category a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_category_bg',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-category' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgps_nmg_category_typography',
                'selector' => '{{WRAPPER}} .mgp-post-category',
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_category_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_nmg_category_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Meta Style
        $this->start_controls_section(
            'mgps_nmg_meta_style',
            [
                'label' => __('Meta Style', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgps_nmg_meta_color',
            [
                'label' => __('Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-meta' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgp-post-meta a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgps_nmg_meta_typography',
                'selector' => '{{WRAPPER}} .mgp-post-meta',
            ]
        );

        $this->add_responsive_control(
            'mgps_nmg_meta_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        // Get settings
        $post_type = sanitize_text_field($settings['mgps_nmg_post_type']);
        $posts_count = absint($settings['mgps_nmg_posts_count']);
        $filter = $settings['mgps_nmg_posts_filter'];
        $custom_order = $settings['mgps_nmg_custom_order'];
        $grid_categories = $settings['mgps_nmg_grid_categories'];
        $orderby = $settings['mgps_nmg_orderby'];
        $order = $settings['mgps_nmg_order'];
        $layout_style = $settings['mgps_nmg_layout_style'];
        $grid_style = $settings['mgps_nmg_grid_style'];

        // Query Arguments
        $args = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => $posts_count,
        );

        // Filter logic
        switch ($filter) {
            case 'trending':
                $args['meta_key'] = 'mp_post_week_viewed';
                $args['orderby'] = 'meta_value_num';
                break;
            case 'popular':
                $args['meta_key'] = 'mp_post_post_viewed';
                $args['orderby'] = 'meta_value_num';
                break;
            case 'random_order':
                $args['orderby'] = 'rand';
                break;
            default:
                $args['orderby'] = 'date';
                $args['order'] = 'desc';
                break;
        }

        // Handle specific post selection
        if ($filter === 'show_byid' && !empty($settings['mgps_nmg_post_id'])) {
            $args['post__in'] = array_map('absint', $settings['mgps_nmg_post_id']);
        } elseif ($filter === 'show_byid_manually') {
            $post_ids = array_map('absint', explode(',', $settings['mgps_nmg_post_ids_manually']));
            $args['post__in'] = array_filter($post_ids);
        }

        // Custom order
        if ($custom_order == 'yes') {
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }

        // Category filter
        if (!(($filter == "show_byid") || ($filter == "show_byid_manually"))) {
            $post_cats = str_replace(' ', '', $grid_categories);
            if ("0" != $grid_categories && $post_type == 'post') {
                if (is_array($post_cats) && count($post_cats) > 0) {
                    $field_name = is_numeric($post_cats[0]) ? 'term_id' : 'slug';
                    $args['tax_query'][] = array(
                        array(
                            'taxonomy' => 'category',
                            'terms' => $post_cats,
                            'field' => $field_name,
                            'include_children' => false
                        )
                    );
                }
            }
        }

        $posts_query = new WP_Query($args);

        if ($posts_query->have_posts()) {
            $post_count = 0;
            $layout_class = 'mgp-layout-' . $layout_style . ' mgp-grid-' . $grid_style;
            
            echo '<div class="mgp-news-magazine-grid ' . esc_attr($layout_class) . '">';
            
            // Collect all posts
            $all_posts = array();
            while ($posts_query->have_posts()) {
                $posts_query->the_post();
                $all_posts[] = get_post();
            }
            
            // Render based on layout style
            if (!empty($all_posts)) {
                global $post;
                
                if ($layout_style === 'style_2') {
                    // Style 2: Big Center + Small Left/Right Vertical
                    $this->render_style_2_layout($all_posts, $settings);
                } elseif ($layout_style === 'style_4') {
                    // Style 4: Big Left + Small Right Grid
                    $this->render_style_4_layout($all_posts, $settings);
                } else {
                    // Style 1 & 3: Big Left/Right + Small Stack
                    $this->render_style_1_3_layout($all_posts, $settings, $layout_style);
                }
            }
            
            echo '</div>';
            
            wp_reset_postdata();
        } else {
            echo '<div class="mgp-no-posts">' . __('No posts found.', 'magical-posts-display') . '</div>';
        }
    }

    /**
     * Render big post.
     */
    private function render_big_post($settings)
    {
        $grid_style = $settings['mgps_nmg_grid_style'];
        
        echo '<div class="mgp-big-post">';
        
        if ($grid_style === 'grid_style_2') {
            // Grid Style 2: Category overlay on image, content below
            $this->render_big_post_style_2($settings);
        } elseif ($grid_style === 'grid_style_3') {
            // Grid Style 3: Modern card design
            $this->render_big_post_style_3($settings);
        } else {
            // Grid Style 1: Category above title, meta below text
            $this->render_big_post_style_1($settings);
        }
        
        echo '</div>';
    }

    /**
     * Render big post - Grid Style 1 (Category above title, meta below text).
     */
    private function render_big_post_style_1($settings)
    {
        // Post image
        if ($settings['mgps_nmg_big_post_image'] === 'yes' && has_post_thumbnail()) {
            echo '<div class="mgp-post-image">';
            echo '<a href="' . esc_url(get_permalink()) . '">';
            the_post_thumbnail('large');
            echo '</a>';
            echo '</div>';
        }
        
        echo '<div class="mgp-post-content">';
        
        // Category (above title)
        if ($settings['mgps_nmg_big_post_category'] === 'yes' && $settings['mgps_nmg_post_type'] === 'post') {
            $this->render_post_category();
        }
        
        // Title
        if ($settings['mgps_nmg_big_post_title'] === 'yes') {
            $title_tag = $settings['mgps_nmg_big_post_title_tag'];
            $title_crop = $settings['mgps_nmg_big_post_title_crop'];
            $title = get_the_title();
            if ($title_crop) {
                $title = wp_trim_words($title, $title_crop, '...');
            }
            
            echo '<' . esc_attr($title_tag) . ' class="mgp-post-title">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html($title) . '</a>';
            echo '</' . esc_attr($title_tag) . '>';
        }
        // Meta (below TITLE)
        if ($settings['mgps_nmg_big_post_meta'] === 'yes') {
            $this->render_post_meta();
        }
        
        // Excerpt
        if ($settings['mgps_nmg_big_post_excerpt'] === 'yes') {
            $excerpt_crop = $settings['mgps_nmg_big_post_excerpt_crop'];
            $excerpt = get_the_excerpt();
            if (!$excerpt) {
                $excerpt = get_the_content();
            }
            if ($excerpt_crop) {
                $excerpt = wp_trim_words($excerpt, $excerpt_crop, '...');
            }
            
            echo '<div class="mgp-post-excerpt">' . esc_html($excerpt) . '</div>';
        }
        
        
        
        echo '</div>';
    }

    /**
     * Render big post - Grid Style 2 (Category overlay on image, content below).
     */
    private function render_big_post_style_2($settings)
    {
        // Post image with overlay category
        if ($settings['mgps_nmg_big_post_image'] === 'yes' && has_post_thumbnail()) {
            echo '<div class="mgp-post-image mgp-image-overlay">';
            echo '<a href="' . esc_url(get_permalink()) . '">';
            the_post_thumbnail('large');
            echo '</a>';
            
            // Category overlay
            if ($settings['mgps_nmg_big_post_category'] === 'yes' && $settings['mgps_nmg_post_type'] === 'post') {
                echo '<div class="mgp-category-overlay">';
                $this->render_post_category();
                echo '</div>';
            }
            echo '</div>';
        }
        
        echo '<div class="mgp-post-content">';
        
        // Title
        if ($settings['mgps_nmg_big_post_title'] === 'yes') {
            $title_tag = $settings['mgps_nmg_big_post_title_tag'];
            $title_crop = $settings['mgps_nmg_big_post_title_crop'];
            $title = get_the_title();
            if ($title_crop) {
                $title = wp_trim_words($title, $title_crop, '...');
            }
            
            echo '<' . esc_attr($title_tag) . ' class="mgp-post-title">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html($title) . '</a>';
            echo '</' . esc_attr($title_tag) . '>';
        }
        
        // Excerpt
        if ($settings['mgps_nmg_big_post_excerpt'] === 'yes') {
            $excerpt_crop = $settings['mgps_nmg_big_post_excerpt_crop'];
            $excerpt = get_the_excerpt();
            if (!$excerpt) {
                $excerpt = get_the_content();
            }
            if ($excerpt_crop) {
                $excerpt = wp_trim_words($excerpt, $excerpt_crop, '...');
            }
            
            echo '<div class="mgp-post-excerpt">' . esc_html($excerpt) . '</div>';
        }
        
        // Meta (below text)
        if ($settings['mgps_nmg_big_post_meta'] === 'yes') {
            $this->render_post_meta();
        }
        
        echo '</div>';
    }

    /**
     * Render big post - Grid Style 3 (Modern card design).
     */
    private function render_big_post_style_3($settings)
    {
        echo '<div class="mgp-modern-card">';
        
        // Post image
        if ($settings['mgps_nmg_big_post_image'] === 'yes' && has_post_thumbnail()) {
            echo '<div class="mgp-post-image">';
            echo '<a href="' . esc_url(get_permalink()) . '">';
            the_post_thumbnail('large');
            echo '</a>';
            echo '</div>';
        }
        
        echo '<div class="mgp-post-content">';
        
        // Category only
        if ($settings['mgps_nmg_big_post_category'] === 'yes' && $settings['mgps_nmg_post_type'] === 'post') {
            $this->render_post_category();
        }
        
        // Title
        if ($settings['mgps_nmg_big_post_title'] === 'yes') {
            $title_tag = $settings['mgps_nmg_big_post_title_tag'];
            $title_crop = $settings['mgps_nmg_big_post_title_crop'];
            $title = get_the_title();
            if ($title_crop) {
                $title = wp_trim_words($title, $title_crop, '...');
            }
            
            echo '<' . esc_attr($title_tag) . ' class="mgp-post-title">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html($title) . '</a>';
            echo '</' . esc_attr($title_tag) . '>';
        }
        
        // Excerpt
        if ($settings['mgps_nmg_big_post_excerpt'] === 'yes') {
            $excerpt_crop = $settings['mgps_nmg_big_post_excerpt_crop'];
            $excerpt = get_the_excerpt();
            if (!$excerpt) {
                $excerpt = get_the_content();
            }
            if ($excerpt_crop) {
                $excerpt = wp_trim_words($excerpt, $excerpt_crop, '...');
            }
            
            echo '<div class="mgp-post-excerpt">' . esc_html($excerpt) . '</div>';
        }
        
        // Meta (at bottom for Grid Style 3)
        if ($settings['mgps_nmg_big_post_meta'] === 'yes') {
            $this->render_post_meta();
        }
        
        echo '</div>';
        echo '</div>';
    }

    /**
     * Render small post vertical (for Style 2).
     */
    private function render_small_post_vertical($settings)
    {
        $grid_style = $settings['mgps_nmg_grid_style'];
        
        echo '<div class="mgp-small-post mgp-small-post-vertical">';
        
        if ($grid_style === 'grid_style_2') {
            $this->render_small_post_vertical_style_2($settings);
        } elseif ($grid_style === 'grid_style_3') {
            $this->render_small_post_vertical_style_3($settings);
        } else {
            $this->render_small_post_vertical_style_1($settings);
        }
        
        echo '</div>';
    }

    /**
     * Render small post vertical - Grid Style 1.
     */
    private function render_small_post_vertical_style_1($settings)
    {
        // Post image on top
        if ($settings['mgps_nmg_small_post_image'] === 'yes' && has_post_thumbnail()) {
            echo '<div class="mgp-post-image">';
            echo '<a href="' . esc_url(get_permalink()) . '">';
            the_post_thumbnail('medium');
            echo '</a>';
            echo '</div>';
        }
        
        // Content below image
        echo '<div class="mgp-post-content">';
        
        // Category (above title)
        if ($settings['mgps_nmg_small_post_category'] === 'yes' && $settings['mgps_nmg_post_type'] === 'post') {
            $this->render_post_category();
        }
        
        // Title
        if ($settings['mgps_nmg_small_post_title'] === 'yes') {
            $title_tag = $settings['mgps_nmg_small_post_title_tag'];
            $title_crop = $settings['mgps_nmg_small_post_title_crop'];
            $title = get_the_title();
            if ($title_crop) {
                $title = wp_trim_words($title, $title_crop, '...');
            }
            
            echo '<' . esc_attr($title_tag) . ' class="mgp-post-title">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html($title) . '</a>';
            echo '</' . esc_attr($title_tag) . '>';
        }
        
        // Excerpt
        if ($settings['mgps_nmg_small_post_excerpt'] === 'yes') {
            $excerpt_crop = $settings['mgps_nmg_small_post_excerpt_crop'];
            $excerpt = get_the_excerpt();
            if (!$excerpt) {
                $excerpt = get_the_content();
            }
            if ($excerpt_crop) {
                $excerpt = wp_trim_words($excerpt, $excerpt_crop, '...');
            }
            
            echo '<div class="mgp-post-excerpt">' . esc_html($excerpt) . '</div>';
        }
        
        // Meta (below text)
        if ($settings['mgps_nmg_small_post_meta'] === 'yes') {
            $this->render_post_meta();
        }
        
        echo '</div>';
    }

    /**
     * Render small post vertical - Grid Style 2.
     */
    private function render_small_post_vertical_style_2($settings)
    {
        // Post image with overlay category
        if ($settings['mgps_nmg_small_post_image'] === 'yes' && has_post_thumbnail()) {
            echo '<div class="mgp-post-image mgp-image-overlay">';
            echo '<a href="' . esc_url(get_permalink()) . '">';
            the_post_thumbnail('medium');
            echo '</a>';
            
            // Category overlay
            if ($settings['mgps_nmg_small_post_category'] === 'yes' && $settings['mgps_nmg_post_type'] === 'post') {
                echo '<div class="mgp-category-overlay">';
                $this->render_post_category();
                echo '</div>';
            }
            echo '</div>';
        }
        
        // Content below image
        echo '<div class="mgp-post-content">';
        
        // Title
        if ($settings['mgps_nmg_small_post_title'] === 'yes') {
            $title_tag = $settings['mgps_nmg_small_post_title_tag'];
            $title_crop = $settings['mgps_nmg_small_post_title_crop'];
            $title = get_the_title();
            if ($title_crop) {
                $title = wp_trim_words($title, $title_crop, '...');
            }
            
            echo '<' . esc_attr($title_tag) . ' class="mgp-post-title">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html($title) . '</a>';
            echo '</' . esc_attr($title_tag) . '>';
        }
        
        // Excerpt
        if ($settings['mgps_nmg_small_post_excerpt'] === 'yes') {
            $excerpt_crop = $settings['mgps_nmg_small_post_excerpt_crop'];
            $excerpt = get_the_excerpt();
            if (!$excerpt) {
                $excerpt = get_the_content();
            }
            if ($excerpt_crop) {
                $excerpt = wp_trim_words($excerpt, $excerpt_crop, '...');
            }
            
            echo '<div class="mgp-post-excerpt">' . esc_html($excerpt) . '</div>';
        }
        
        // Meta (below text)
        if ($settings['mgps_nmg_small_post_meta'] === 'yes') {
            $this->render_post_meta();
        }
        
        echo '</div>';
    }

    /**
     * Render small post vertical - Grid Style 3.
     */
    private function render_small_post_vertical_style_3($settings)
    {
        echo '<div class="mgp-modern-card">';
        
        // Post image
        if ($settings['mgps_nmg_small_post_image'] === 'yes' && has_post_thumbnail()) {
            echo '<div class="mgp-post-image">';
            echo '<a href="' . esc_url(get_permalink()) . '">';
            the_post_thumbnail('medium');
            echo '</a>';
            echo '</div>';
        }
        
        echo '<div class="mgp-post-content">';
        
        // Category only
        if ($settings['mgps_nmg_small_post_category'] === 'yes' && $settings['mgps_nmg_post_type'] === 'post') {
            $this->render_post_category();
        }
        
        // Title
        if ($settings['mgps_nmg_small_post_title'] === 'yes') {
            $title_tag = $settings['mgps_nmg_small_post_title_tag'];
            $title_crop = $settings['mgps_nmg_small_post_title_crop'];
            $title = get_the_title();
            if ($title_crop) {
                $title = wp_trim_words($title, $title_crop, '...');
            }
            
            echo '<' . esc_attr($title_tag) . ' class="mgp-post-title">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html($title) . '</a>';
            echo '</' . esc_attr($title_tag) . '>';
        }
        
        // Excerpt
        if ($settings['mgps_nmg_small_post_excerpt'] === 'yes') {
            $excerpt_crop = $settings['mgps_nmg_small_post_excerpt_crop'];
            $excerpt = get_the_excerpt();
            if (!$excerpt) {
                $excerpt = get_the_content();
            }
            if ($excerpt_crop) {
                $excerpt = wp_trim_words($excerpt, $excerpt_crop, '...');
            }
            
            echo '<div class="mgp-post-excerpt">' . esc_html($excerpt) . '</div>';
        }
        
        // Meta (at bottom for Grid Style 3)
        if ($settings['mgps_nmg_small_post_meta'] === 'yes') {
            $this->render_post_meta();
        }
        
        echo '</div>';
        echo '</div>';
    }

    /**
     * Render small post horizontal (for Style 1, 3, 4).
     */
    private function render_small_post($settings)
    {
        $grid_style = $settings['mgps_nmg_grid_style'];
        
        echo '<div class="mgp-small-post">';
        
        if ($grid_style === 'grid_style_2') {
            $this->render_small_post_style_2($settings);
        } elseif ($grid_style === 'grid_style_3') {
            $this->render_small_post_style_3($settings);
        } else {
            $this->render_small_post_style_1($settings);
        }
        
        echo '</div>';
    }

    /**
     * Render small post horizontal - Grid Style 1.
     */
    private function render_small_post_style_1($settings)
    {
        // Post image
        if ($settings['mgps_nmg_small_post_image'] === 'yes' && has_post_thumbnail()) {
            echo '<div class="mgp-post-image">';
            echo '<a href="' . esc_url(get_permalink()) . '">';
            the_post_thumbnail('medium');
            echo '</a>';
            echo '</div>';
        }
        
        echo '<div class="mgp-post-content">';
        
        // Category (above title)
        if ($settings['mgps_nmg_small_post_category'] === 'yes' && $settings['mgps_nmg_post_type'] === 'post') {
            $this->render_post_category();
        }
        
        // Title
        if ($settings['mgps_nmg_small_post_title'] === 'yes') {
            $title_tag = $settings['mgps_nmg_small_post_title_tag'];
            $title_crop = $settings['mgps_nmg_small_post_title_crop'];
            $title = get_the_title();
            if ($title_crop) {
                $title = wp_trim_words($title, $title_crop, '...');
            }
            
            echo '<' . esc_attr($title_tag) . ' class="mgp-post-title">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html($title) . '</a>';
            echo '</' . esc_attr($title_tag) . '>';
        }
        
        // Excerpt
        if ($settings['mgps_nmg_small_post_excerpt'] === 'yes') {
            $excerpt_crop = $settings['mgps_nmg_small_post_excerpt_crop'];
            $excerpt = get_the_excerpt();
            if (!$excerpt) {
                $excerpt = get_the_content();
            }
            if ($excerpt_crop) {
                $excerpt = wp_trim_words($excerpt, $excerpt_crop, '...');
            }
            
            echo '<div class="mgp-post-excerpt">' . esc_html($excerpt) . '</div>';
        }
        
        // Meta (below text)
        if ($settings['mgps_nmg_small_post_meta'] === 'yes') {
            $this->render_post_meta();
        }
        
        echo '</div>';
    }

    /**
     * Render small post horizontal - Grid Style 2.
     */
    private function render_small_post_style_2($settings)
    {
        // Post image with overlay category
        if ($settings['mgps_nmg_small_post_image'] === 'yes' && has_post_thumbnail()) {
            echo '<div class="mgp-post-image mgp-image-overlay">';
            echo '<a href="' . esc_url(get_permalink()) . '">';
            the_post_thumbnail('medium');
            echo '</a>';
            
            // Category overlay
            if ($settings['mgps_nmg_small_post_category'] === 'yes' && $settings['mgps_nmg_post_type'] === 'post') {
                echo '<div class="mgp-category-overlay">';
                $this->render_post_category();
                echo '</div>';
            }
            echo '</div>';
        }
        
        echo '<div class="mgp-post-content">';
        
        // Title
        if ($settings['mgps_nmg_small_post_title'] === 'yes') {
            $title_tag = $settings['mgps_nmg_small_post_title_tag'];
            $title_crop = $settings['mgps_nmg_small_post_title_crop'];
            $title = get_the_title();
            if ($title_crop) {
                $title = wp_trim_words($title, $title_crop, '...');
            }
            
            echo '<' . esc_attr($title_tag) . ' class="mgp-post-title">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html($title) . '</a>';
            echo '</' . esc_attr($title_tag) . '>';
        }
        
        // Excerpt
        if ($settings['mgps_nmg_small_post_excerpt'] === 'yes') {
            $excerpt_crop = $settings['mgps_nmg_small_post_excerpt_crop'];
            $excerpt = get_the_excerpt();
            if (!$excerpt) {
                $excerpt = get_the_content();
            }
            if ($excerpt_crop) {
                $excerpt = wp_trim_words($excerpt, $excerpt_crop, '...');
            }
            
            echo '<div class="mgp-post-excerpt">' . esc_html($excerpt) . '</div>';
        }
        
        // Meta (below text)
        if ($settings['mgps_nmg_small_post_meta'] === 'yes') {
            $this->render_post_meta();
        }
        
        echo '</div>';
    }

    /**
     * Render small post horizontal - Grid Style 3.
     */
    private function render_small_post_style_3($settings)
    {
        echo '<div class="mgp-modern-card">';
        
        // Post image
        if ($settings['mgps_nmg_small_post_image'] === 'yes' && has_post_thumbnail()) {
            echo '<div class="mgp-post-image">';
            echo '<a href="' . esc_url(get_permalink()) . '">';
            the_post_thumbnail('medium');
            echo '</a>';
            echo '</div>';
        }
        
        echo '<div class="mgp-post-content">';
        
        // Category only
        if ($settings['mgps_nmg_small_post_category'] === 'yes' && $settings['mgps_nmg_post_type'] === 'post') {
            $this->render_post_category();
        }
        
        // Title
        if ($settings['mgps_nmg_small_post_title'] === 'yes') {
            $title_tag = $settings['mgps_nmg_small_post_title_tag'];
            $title_crop = $settings['mgps_nmg_small_post_title_crop'];
            $title = get_the_title();
            if ($title_crop) {
                $title = wp_trim_words($title, $title_crop, '...');
            }
            
            echo '<' . esc_attr($title_tag) . ' class="mgp-post-title">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html($title) . '</a>';
            echo '</' . esc_attr($title_tag) . '>';
        }
        
        // Excerpt
        if ($settings['mgps_nmg_small_post_excerpt'] === 'yes') {
            $excerpt_crop = $settings['mgps_nmg_small_post_excerpt_crop'];
            $excerpt = get_the_excerpt();
            if (!$excerpt) {
                $excerpt = get_the_content();
            }
            if ($excerpt_crop) {
                $excerpt = wp_trim_words($excerpt, $excerpt_crop, '...');
            }
            
            echo '<div class="mgp-post-excerpt">' . esc_html($excerpt) . '</div>';
        }
        
        // Meta (at bottom for Grid Style 3)
        if ($settings['mgps_nmg_small_post_meta'] === 'yes') {
            $this->render_post_meta();
        }
        
        echo '</div>';
        echo '</div>';
    }

    /**
     * Render post category.
     */
    private function render_post_category()
    {
        $categories = get_the_category();
        if ($categories) {
            echo '<div class="mgp-post-category">';
            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">';
            echo esc_html($categories[0]->name);
            echo '</a>';
            echo '</div>';
        }
    }

    /**
     * Render post meta.
     */
    private function render_post_meta()
    {
        echo '<div class="mgp-post-meta">';
        echo '<span class="mgp-post-date">' . esc_html(get_the_date()) . '</span>';
        echo '<span class="mgp-meta-separator"> • </span>';
        echo '<span class="mgp-post-author">' . esc_html(get_the_author()) . '</span>';
        echo '</div>';
    }

    /**
     * Render Style 1 & 3 Layout (Big Left/Right + Small Stack)
     */
    private function render_style_1_3_layout($all_posts, $settings, $layout_style)
    {
        global $post;
        
        // Render big post (first post)
        $post = $all_posts[0];
        setup_postdata($post);
        $this->render_big_post($settings);
        
        // Render small posts container
        if (count($all_posts) > 1) {
            echo '<div class="mgp-small-posts-area">';
            for ($i = 1; $i < count($all_posts); $i++) {
                $post = $all_posts[$i];
                setup_postdata($post);
                $this->render_small_post($settings);
            }
            echo '</div>';
        }
    }

    /**
     * Render Style 2 Layout (Big Center + Small Left/Right)
     */
    private function render_style_2_layout($all_posts, $settings)
    {
        global $post;
        
        // Calculate posts distribution
        $total_posts = count($all_posts);
        $small_posts = $total_posts - 1; // Exclude big post
        $left_posts = ceil($small_posts / 2);
        $right_posts = $small_posts - $left_posts;
        
        // Render left small posts
        if ($left_posts > 0) {
            echo '<div class="mgp-left-posts-area">';
            for ($i = 1; $i <= $left_posts; $i++) {
                if (isset($all_posts[$i])) {
                    $post = $all_posts[$i];
                    setup_postdata($post);
                    $this->render_small_post_vertical($settings);
                }
            }
            echo '</div>';
        }
        
        // Render big post (first post)
        $post = $all_posts[0];
        setup_postdata($post);
        $this->render_big_post($settings);
        
        // Render right small posts
        if ($right_posts > 0) {
            echo '<div class="mgp-right-posts-area">';
            for ($i = $left_posts + 1; $i < $total_posts; $i++) {
                if (isset($all_posts[$i])) {
                    $post = $all_posts[$i];
                    setup_postdata($post);
                    $this->render_small_post_vertical($settings);
                }
            }
            echo '</div>';
        }
    }

    /**
     * Render Style 4 Layout (Big Left + Small Right Grid)
     */
    private function render_style_4_layout($all_posts, $settings)
    {
        global $post;
        
        // Render big post (first post)
        $post = $all_posts[0];
        setup_postdata($post);
        $this->render_big_post($settings);
        
        // Render small posts in grid
        $small_posts_count = count($all_posts) - 1;
        if ($small_posts_count > 0) {
            echo '<div class="mgp-small-posts-grid">';
            for ($i = 1; $i < count($all_posts); $i++) {
                if (isset($all_posts[$i])) {
                    $post = $all_posts[$i];
                    setup_postdata($post);
                    $this->render_small_post($settings);
                }
            }
            echo '</div>';
        }
    }
}
