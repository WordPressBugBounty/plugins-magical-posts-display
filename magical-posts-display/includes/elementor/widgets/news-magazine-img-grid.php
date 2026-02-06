<?php

class mgpdNewsMagazineImgGrid extends \Elementor\Widget_Base
{
    use Query_Controls_Trait;
    /**
     * Get widget name.
     */
    public function get_name()
    {
        return 'mgposts_news_magazine_img_grid';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return __('News/Magazine Image Grid', 'magical-posts-display');
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
        return ['news', 'magazine', 'image', 'grid', 'posts', 'layout'];
    }

    /**
     * Get style depends.
     */
    public function get_style_depends()
    {
        // Enqueue the CSS file for this widget
        wp_enqueue_style('magical-news-magazine-img-grid');
        return ['magical-news-magazine-img-grid'];
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
            'mgpnig_query_section',
            [
                'label' => esc_html__('Posts Query', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpnig_post_type',
            [
                'label' => __('Post Type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'label_block' => true,
                'options' => mp_display_all_posts_type(),
            ]
        );

        $this->add_control(
            'mgpnig_posts_filter',
            [
                'label' => esc_html__('Filter By', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'recent',
                'options' => mp_display_post_filter(),
            ]
        );

        $this->add_control(
            'mgpnig_post_id',
            [
                'label' => __('Select Posts', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_posts_name(),
                'condition' => [
                    'mgpnig_posts_filter' => 'show_byid',
                ]
            ]
        );

        $this->add_control(
            'mgpnig_post_ids_manually',
            [
                'label' => __('Posts IDs', 'magical-posts-display'),
                'description' => __('Separate IDs with commas', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'mgpnig_posts_filter' => 'show_byid_manually',
                ]
            ]
        );

        $this->add_control(
            'mgpnig_posts_count',
            [
                'label'   => __('Posts Count', 'magical-posts-display'),
                'description' => __('Total posts to display (1 big + 3-5 small)', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 4,
                'min' => 2,
                'max' => 6,
                'step'    => 1,
            ]
        );

        // Post Position Control
        $this->register_post_position_control('mgpnig_posts_filter');

        $this->add_control(
            'mgpnig_grid_categories',
            [
                'label' => esc_html__('Posts Categories', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_taxonomy_list(),
                'condition' => [
                    'mgpnig_posts_filter!' => ['show_byid', 'show_byid_manually'],
                    'mgpnig_post_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'mgpnig_custom_order',
            [
                'label' => esc_html__('Custom Order', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'mgpnig_orderby',
            [
                'label' => esc_html__('Order By', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'none'          => esc_html__('None', 'magical-posts-display'),
                    'ID'            => esc_html__('ID', 'magical-posts-display'),
                    'date'          => esc_html__('Date', 'magical-posts-display'),
                    'name'          => esc_html__('Name', 'magical-posts-display'),
                    'title'         => esc_html__('Title', 'magical-posts-display'),
                    'comment_count' => esc_html__('Comment count', 'magical-posts-display'),
                    'rand'          => esc_html__('Random', 'magical-posts-display'),
                ],
                'condition' => [
                    'mgpnig_custom_order' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgpnig_order',
            [
                'label' => esc_html__('Order', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__('Descending', 'magical-posts-display'),
                    'ASC'  => esc_html__('Ascending', 'magical-posts-display'),
                ],
                'condition' => [
                    'mgpnig_custom_order' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        // Layout Settings Sectionl
        $this->start_controls_section(
            'mgpnig_layout_section',
            [
                'label' => esc_html__('Layout Settings', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpnig_layout_style',
            [
                'label' => esc_html__('Layout Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__('Style 1 - Classic Magazine', 'magical-posts-display'),
                    'style2' => esc_html__('Style 2 - Grid Layout', 'magical-posts-display'),
                    'style3' => esc_html__('Style 3 - Compact Grid', 'magical-posts-display'),
                    'style4' => esc_html__('Style 4 - Featured Focus', 'magical-posts-display'),
                    'style5' => esc_html__('Style 5 - Equal Heights', 'magical-posts-display'),
                ],
            ]
        );

        $this->add_control(
            'mgpnig_small_posts_columns',
            [
                'label' => esc_html__('Small Posts Columns', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__('1 Column', 'magical-posts-display'),
                    '2' => esc_html__('2 Columns', 'magical-posts-display'),
                ],
                'condition' => [
                    'mgpnig_layout_style' => ['style2', 'style3', 'style5'],
                ]
            ]
        );

        $this->add_responsive_control(
            'mgpnig_big_post_height',
            [
                'label' => esc_html__('Big Post Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 250,
                        'max' => 600,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 400,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpnig_small_post_height',
            [
                'label' => esc_html__('Small Posts Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 80,
                        'max' => 250,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 120,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Big Post Settings Section
        $this->start_controls_section(
            'mgpnig_big_post_section',
            [
                'label' => esc_html__('Big Post Settings', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpnig_big_show_image',
            [
                'label' => esc_html__('Show Image', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgpnig_big_show_title',
            [
                'label' => esc_html__('Show Title', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgpnig_big_title_word_limit',
            [
                'label' => esc_html__('Title Word Limit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'mgpnig_big_show_title' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgpnig_big_title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'magical-posts-display'),
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
                    'mgpnig_big_show_title' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgpnig_big_show_excerpt',
            [
                'label' => esc_html__('Show Excerpt', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgpnig_big_excerpt_word_limit',
            [
                'label' => esc_html__('Excerpt Word Limit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'condition' => [
                    'mgpnig_big_show_excerpt' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgpnig_big_show_category',
            [
                'label' => esc_html__('Show Category', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgpnig_big_show_meta',
            [
                'label' => esc_html__('Show Meta', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Small Posts Settings Section
        $this->start_controls_section(
            'mgpnig_small_posts_section',
            [
                'label' => esc_html__('Small Posts Settings', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpnig_small_show_image',
            [
                'label' => esc_html__('Show Image', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgpnig_small_show_title',
            [
                'label' => esc_html__('Show Title', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgpnig_small_title_word_limit',
            [
                'label' => esc_html__('Title Word Limit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'mgpnig_small_show_title' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgpnig_small_title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h4',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'condition' => [
                    'mgpnig_small_show_title' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgpnig_small_show_excerpt',
            [
                'label' => esc_html__('Show Excerpt', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'mgpnig_small_excerpt_word_limit',
            [
                'label' => esc_html__('Excerpt Word Limit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 15,
                'condition' => [
                    'mgpnig_small_show_excerpt' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgpnig_small_show_category',
            [
                'label' => esc_html__('Show Category', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'mgpnig_small_show_meta',
            [
                'label' => esc_html__('Show Meta', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
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
            'mgpnig_container_style',
            [
                'label' => esc_html__('Container Style', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpnig_container_padding',
            [
                'label' => esc_html__('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-news-magazine-img-grid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpnig_container_margin',
            [
                'label' => esc_html__('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-news-magazine-img-grid' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpnig_container_background',
            [
                'label' => esc_html__('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-news-magazine-img-grid' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpnig_grid_gap',
            [
                'label' => esc_html__('Grid Gap', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-news-magazine-img-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Big Post Style
        $this->start_controls_section(
            'mgpnig_big_post_style',
            [
                'label' => esc_html__('Big Post Style', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgpnig_big_post_background',
            [
                'label' => esc_html__('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpnig_big_post_border',
                'selector' => '{{WRAPPER}} .mgp-big-post',
            ]
        );

        $this->add_responsive_control(
            'mgpnig_big_post_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-posts-display'),
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
                'name' => 'mgpnig_big_post_box_shadow',
                'selector' => '{{WRAPPER}} .mgp-big-post',
            ]
        );

        // Big Post Title Style
        $this->add_control(
            'mgpnig_big_title_heading',
            [
                'label' => esc_html__('Title', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mgpnig_big_title_color',
            [
                'label' => esc_html__('Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpnig_big_title_hover_color',
            [
                'label' => esc_html__('Hover Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpnig_big_title_typography',
                'selector' => '{{WRAPPER}} .mgp-big-post .mgp-post-title',
            ]
        );

        $this->add_responsive_control(
            'mgpnig_big_title_margin',
            [
                'label' => esc_html__('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Big Post Excerpt Style
        $this->add_control(
            'mgpnig_big_excerpt_heading',
            [
                'label' => esc_html__('Excerpt', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mgpnig_big_excerpt_color',
            [
                'label' => esc_html__('Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpnig_big_excerpt_typography',
                'selector' => '{{WRAPPER}} .mgp-big-post .mgp-post-excerpt',
            ]
        );

        $this->add_responsive_control(
            'mgpnig_big_excerpt_margin',
            [
                'label' => esc_html__('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Big Post Image Style
        $this->add_control(
            'mgpnig_big_image_heading',
            [
                'label' => esc_html__('Image', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'mgpnig_big_image_width',
            [
                'label' => esc_html__('Image Width', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image img' => 'width: 100%;',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpnig_big_image_height',
            [
                'label' => esc_html__('Image Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 800,
                        'step' => 10,
                    ],
                    'vh' => [
                        'min' => 20,
                        'max' => 80,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 400,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image img' => 'height: 100%;',
                ],
            ]
        );

        $this->add_control(
            'mgpnig_big_image_object_fit',
            [
                'label' => esc_html__('Object Fit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover', 'magical-posts-display'),
                    'contain' => esc_html__('Contain', 'magical-posts-display'),
                    'fill' => esc_html__('Fill', 'magical-posts-display'),
                    'none' => esc_html__('None', 'magical-posts-display'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpnig_big_image_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .mgp-big-post .mgp-post-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Small Posts Style
        $this->start_controls_section(
            'mgpnig_small_posts_style',
            [
                'label' => esc_html__('Small Posts Style', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgpnig_small_post_background',
            [
                'label' => esc_html__('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpnig_small_post_border',
                'selector' => '{{WRAPPER}} .mgp-small-post',
            ]
        );

        $this->add_responsive_control(
            'mgpnig_small_post_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-posts-display'),
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
                'name' => 'mgpnig_small_post_box_shadow',
                'selector' => '{{WRAPPER}} .mgp-small-post',
            ]
        );

        // Small Posts Title Style
        $this->add_control(
            'mgpnig_small_title_heading',
            [
                'label' => esc_html__('Title', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mgpnig_small_title_color',
            [
                'label' => esc_html__('Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpnig_small_title_hover_color',
            [
                'label' => esc_html__('Hover Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpnig_small_title_typography',
                'selector' => '{{WRAPPER}} .mgp-small-post .mgp-post-title',
            ]
        );

        $this->add_responsive_control(
            'mgpnig_small_title_margin',
            [
                'label' => esc_html__('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Small Posts Image Style
        $this->add_control(
            'mgpnig_small_image_heading',
            [
                'label' => esc_html__('Image', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'mgpnig_small_image_width',
            [
                'label' => esc_html__('Image Width', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 80,
                        'max' => 500,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image img' => 'width: 100%;',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpnig_small_image_height',
            [
                'label' => esc_html__('Image Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 120,
                        'max' => 400,
                        'step' => 10,
                    ],
                    'vh' => [
                        'min' => 15,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image img' => 'height: 100%;',
                ],
            ]
        );

        $this->add_control(
            'mgpnig_small_image_object_fit',
            [
                'label' => esc_html__('Object Fit', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover', 'magical-posts-display'),
                    'contain' => esc_html__('Contain', 'magical-posts-display'),
                    'fill' => esc_html__('Fill', 'magical-posts-display'),
                    'none' => esc_html__('None', 'magical-posts-display'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpnig_small_image_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .mgp-small-post .mgp-post-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Category Style
        $this->start_controls_section(
            'mgpnig_category_style',
            [
                'label' => esc_html__('Category Style', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgpnig_category_color',
            [
                'label' => esc_html__('Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-category a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpnig_category_background',
            [
                'label' => esc_html__('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-category a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpnig_category_typography',
                'selector' => '{{WRAPPER}} .mgp-post-category',
            ]
        );

        $this->add_responsive_control(
            'mgpnig_category_padding',
            [
                'label' => esc_html__('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpnig_category_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Meta Style
        $this->start_controls_section(
            'mgpnig_meta_style',
            [
                'label' => esc_html__('Meta Style', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgpnig_meta_color',
            [
                'label' => esc_html__('Color', 'magical-posts-display'),
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
                'name' => 'mgpnig_meta_typography',
                'selector' => '{{WRAPPER}} .mgp-post-meta',
            ]
        );

        $this->add_responsive_control(
            'mgpnig_meta_margin',
            [
                'label' => esc_html__('Margin', 'magical-posts-display'),
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
     * Render widget output.
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // Build query arguments
        $query_args = $this->build_query_args($settings);

        // Apply post position settings
        $query_args = $this->apply_post_position_to_query($query_args, $settings, 'mgpnig_posts_filter');

        // Get posts
        $posts_query = new WP_Query($query_args);

        if (!$posts_query->have_posts()) {
            echo '<p>' . esc_html__('No posts found.', 'magical-posts-display') . '</p>';
            return;
        }

        $posts = $posts_query->posts;
        $big_post = array_shift($posts); // First post is the big one
        $small_posts = $posts; // Remaining posts are small ones

        // Layout classes
        $layout_class = 'mgp-layout-' . esc_attr($settings['mgpnig_layout_style']);
        $columns_class = '';

        if (in_array($settings['mgpnig_layout_style'], ['style2', 'style3', 'style5'])) {
            $columns_class = 'mgp-' . esc_attr($settings['mgpnig_small_posts_columns']) . '-columns';
        }

?>
        <div class="mgp-news-magazine-img-grid <?php echo esc_attr($layout_class . ' ' . $columns_class); ?>">
            <?php if ($big_post) : ?>
                <div class="mgp-big-post">
                    <?php $this->render_post($big_post, 'big', $settings); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($small_posts)) : ?>
                <div class="mgp-small-posts-area">
                    <?php foreach ($small_posts as $post) : ?>
                        <div class="mgp-small-post">
                            <?php $this->render_post($post, 'small', $settings); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php

        wp_reset_postdata();
    }

    /**
     * Build query arguments
     */
    private function build_query_args($settings)
    {
        $args = [
            'post_type' => esc_attr($settings['mgpnig_post_type']),
            'posts_per_page' => absint($settings['mgpnig_posts_count']),
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key' => '_thumbnail_id',
                    'compare' => 'EXISTS'
                ]
            ]
        ];

        // Handle post filtering
        switch ($settings['mgpnig_posts_filter']) {
            case 'show_byid':
                if (!empty($settings['mgpnig_post_id'])) {
                    $args['post__in'] = mp_display_resolve_post_ids($settings['mgpnig_post_id'], 'post');
                    $args['orderby'] = 'post__in';
                }
                break;

            case 'show_byid_manually':
                if (!empty($settings['mgpnig_post_ids_manually'])) {
                    $manual_ids = array_map('trim', explode(',', $settings['mgpnig_post_ids_manually']));
                    $args['post__in'] = mp_display_resolve_post_ids($manual_ids, 'post');
                    $args['orderby'] = 'post__in';
                }
                break;

            case 'popular':
                $args['meta_key'] = 'mp_post_views_count';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;

            case 'trending':
                $args['date_query'] = [
                    [
                        'after' => '1 month ago',
                    ],
                ];
                $args['meta_key'] = 'mp_post_views_count';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;

            case 'random':
                $args['orderby'] = 'rand';
                break;

            default:
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
        }

        // Categories - support both term_id and slug
        if (!empty($settings['mgpnig_grid_categories']) && $settings['mgpnig_post_type'] === 'post') {
            $post_cats = $settings['mgpnig_grid_categories'];
            if (is_array($post_cats) && count($post_cats) > 0) {
                $field_name = is_numeric($post_cats[0]) ? 'term_id' : 'slug';
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'category',
                        'terms' => $post_cats,
                        'field' => $field_name,
                        'include_children' => false
                    )
                );
            }
        }

        // Custom order
        if ($settings['mgpnig_custom_order'] === 'yes') {
            $args['orderby'] = esc_attr($settings['mgpnig_orderby']);
            $args['order'] = esc_attr($settings['mgpnig_order']);
        }

        return $args;
    }

    /**
     * Render individual post
     */
    private function render_post($post, $size, $settings)
    {
        $show_image = $settings['mgpnig_' . $size . '_show_image'] === 'yes';
        $show_title = $settings['mgpnig_' . $size . '_show_title'] === 'yes';
        $show_excerpt = $settings['mgpnig_' . $size . '_show_excerpt'] === 'yes';
        $show_category = $settings['mgpnig_' . $size . '_show_category'] === 'yes';
        $show_meta = $settings['mgpnig_' . $size . '_show_meta'] === 'yes';

        $title_word_limit = absint($settings['mgpnig_' . $size . '_title_word_limit']);
        $excerpt_word_limit = absint($settings['mgpnig_' . $size . '_excerpt_word_limit']);
        $title_tag = esc_attr($settings['mgpnig_' . $size . '_title_tag']);

    ?>
        <div class="mgp-post-item">
            <div class="mgp-post-image">
                <?php if ($show_image && has_post_thumbnail($post->ID)) : ?>
                    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
                        <?php echo get_the_post_thumbnail($post->ID, $size === 'big' ? 'large' : 'medium', ['class' => 'img-fluid']); ?>
                    </a>
                <?php endif; ?>
                <?php if ($show_category) : ?>
                    <div class="mgp-post-category">
                        <?php
                        $categories = get_the_category($post->ID);
                        if (!empty($categories)) {
                            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
                        }
                        ?>
                    </div>
                <?php endif; ?>
                <div class="mgp-post-content">
                    <?php if ($show_title) :
                        $title = get_the_title($post->ID);
                        if ($title_word_limit > 0) {
                            $title = wp_trim_words($title, $title_word_limit, '...');
                        }
                    ?>
                        <<?php echo mpd_validate_html_tag($title_tag); ?> class="mgp-post-title">
                            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
                                <?php echo esc_html($title); ?>
                            </a>
                        </<?php echo mpd_validate_html_tag($title_tag); ?>>
                    <?php endif; ?>

                    <?php if ($show_excerpt) :
                        $excerpt = get_the_excerpt($post->ID);
                        if ($excerpt_word_limit > 0) {
                            $excerpt = wp_trim_words($excerpt, $excerpt_word_limit, '...');
                        }
                    ?>
                        <div class="mgp-post-excerpt">
                            <?php echo esc_html($excerpt); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_meta) : ?>
                        <div class="mgp-post-meta">
                            <span class="mgp-post-date"><?php echo esc_html(get_the_date('', $post->ID)); ?></span>
                            <span class="mgp-meta-separator"> • </span>
                            <span class="mgp-post-author">
                                <a href="<?php echo esc_url(get_author_posts_url(get_post_field('post_author', $post->ID))); ?>">
                                    <?php echo esc_html(get_the_author_meta('display_name', get_post_field('post_author', $post->ID))); ?>
                                </a>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>



        </div>
<?php
    }
}
