<?php


class mgpdEAwesomePostsList extends \Elementor\Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve Blank widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'mgposts_dlist_awesome';
    }

    /**
     * Get widget title.
     *
     * Retrieve Blank widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return __('Magical Awesome Posts List', 'magical-posts-display');
    }

    /**
     * Get widget icon.
     *
     * Retrieve Blank widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-post-list';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Blank widget belongs to.
     *
     * @return array Widget categories.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_categories()
    {
        return ['mgp-mgposts'];
    }

    public function get_keywords()
    {
        return ['magic', 'post', 'list', 'card', 'category'];
    }
    /**
     * Register Blank widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {

        $this->register_content_controls();
        $this->register_style_controls();
    }

    /**
     * Register Blank widget content ontrols.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    function register_content_controls()
    {

        $this->start_controls_section(
            'mgpl_query',
            [
                'label' => esc_html__('Posts Query', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpg_post_type',
            [
                'label' => __('Post type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_all_posts_type(),
            ]
        );

        $this->add_control(
            'mgpl_posts_filter',
            [
                'label' => esc_html__('Filter By', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'recent',
                'options' => mp_display_post_filter(),
            ]
        );

        $this->add_control(
            'mgpl_post_id',
            [
                'label' => __('Select posts', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_posts_name(),
                'condition' => [
                    'mgpl_posts_filter' => 'show_byid',
                ]
            ]
        );

        $this->add_control(
            'mgpl_post_ids_manually',
            [
                'label' => __('posts IDs', 'magical-posts-display'),
                'description' => __('Separate IDs with commas', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'mgpl_posts_filter' => 'show_byid_manually',
                ]
            ]
        );

        $this->add_control(
            'mgpl_posts_count',
            [
                'label'   => __('posts Limit', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'mgpl_grid_categories',
            [
                'label' => esc_html__('posts Categories', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_taxonomy_list(),
                'condition' => [
                    'mgpl_posts_filter!' => 'show_byid',
                    'mgpg_post_type' => 'post',

                ]
            ]
        );

        $this->add_control(
            'mgpl_custom_order',
            [
                'label' => esc_html__('Custom order', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Orderby', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
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
                    'mgpl_custom_order' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('order', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC'  => esc_html__('Descending', 'magical-posts-display'),
                    'ASC'   => esc_html__('Ascending', 'magical-posts-display'),
                ],
                'condition' => [
                    'mgpl_custom_order' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpl_hitem',
            [
                'label' => esc_html__('List Highlighted Item', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpl_post_style',
            [
                'label'   => __('Select Highlighted Style', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'show_img',
                'options' => [
                    'show_date'   => __('Show Highlighted date', 'magical-posts-display'),
                    'show_img'  => __('Show Highlighted Image', 'magical-posts-display'),
                    'hide'  => __('Hide Highlighted Items', 'magical-posts-display'),
                ]
            ]
        );
        $this->add_control(
            'mgpl_post_img_position',
            [
                'label' => __('Position', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-posts-display'),
                        'icon' => 'eicon-arrow-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-posts-display'),
                        'icon' => 'eicon-arrow-right',
                    ],

                ],
                'default' => 'left',
                'toggle' => false,
                // 'prefix_class' => 'mg-card-img-',
                // 'style_transfer' => true,
            ]

        );
        $this->add_control(
            'mgpl_post_inline',
            [
                'label'     => __('Item Inline', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'mgpl_content_align',
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

                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .mpdl-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpl_post_img_size',
            [
                'label'   => __('Image Size', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'thumbnail',
                'options' => [
                    'thumbnail' => __('Thumbnail (150*150)', 'magical-posts-display'),
                    'medium' => __('Medium (300*300)', 'magical-posts-display'),
                    'card-List' => __('List Card (600*900)', 'magical-posts-display'),
                    'card-list' => __('List card (600*700)', 'magical-posts-display'),
                    'medium_large' => __('Medium large (768*0)', 'magical-posts-display'),
                    'large' => __('Large ( 1024*1024)', 'magical-posts-display'),
                    'full' => __('Orginal size', 'magical-posts-display'),
                ],
                'condition' => [
                    'mgpl_post_style' => 'show_img',
                ]
            ]
        );
        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpl_content',
            [
                'label' => esc_html__('Content Settings', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpl_show_title',
            [
                'label'     => __('Show Posts Title', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpl_post_catshow',
            [
                'label'     => __('Show Posts Category', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'mgpg_post_type' => 'post',
                ],
            ]
        );
        $this->add_control(
            'mgpl_show_author',
            [
                'label'     => __('Show posts Author', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );

        $this->add_control(
            'mgpl_crop_title',
            [
                'label'   => __('Crop Title By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'placeholder' => 5,
                'condition' => [
                    'mgpl_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpl_date_show',
            [
                'label'     => __('Show posts Date', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'

            ]
        );
        $this->add_control(
            'mgpl_list_show',
            [
                'label'     => __('Show List style', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => ''

            ]
        );

        $this->end_controls_section();

        if (empty(mp_display_check_main_ok())) {
            $this->start_controls_section(
                'mgpl_gopro',
                [
                    'label' => esc_html__('Upgrade Pro', 'magical-posts-display'),
                ]
            );
            $this->add_control(
                'mgpl__pro',
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => mp_go_pro_template([
                        'title' => esc_html__('Get All Pro Features', 'elementor'),
                        'massage' => esc_html__('More options waiting for you. So upgrade pro today!! it\'s lifetime Deal!!!', 'elementor'),
                        'link' => 'https://wpthemespace.com/product/magical-posts-display-pro/',
                    ]),
                ]
            );
            $this->end_controls_section();
        }
    }

    /**
     * Register Blank widget style ontrols.
     *
     * Adds different input fields in the style tab to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_style_controls()
    {

        $this->start_controls_section(
            'mgpl_style',
            [
                'label' => __('List Item style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpl_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-list li.mgpdl-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpl_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-list li.mgpdl-list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpl_bg_color',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .mgpdl-list li.mgpdl-list-item',
            ]
        );

        $this->add_control(
            'mgpl_border_radius',
            [
                'label' => __('Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-list li.mgpdl-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpl_content_border',
                'selector' => '{{WRAPPER}} .mgpdl-list li.mgpdl-list-item.mgbb',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpl_content_shadow',
                'selector' => '{{WRAPPER}} .mgpdl-list li.mgpdl-list-item.mgbb',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgpl_img_style',
            [
                'label' => __('Image style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

            ]
        );
        $this->add_responsive_control(
            'image_width_set',
            [
                'label' => __('Width', 'magical-posts-display'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-list-item .mpdl-img img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .row.mgpo-yes .col-sm-auto:first-child' => 'flex: 0 0 {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpl_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-posts-display'),
                'label_off' => __('Off', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'mgpl_img_height',
            [
                'label' => __('Image Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'condition' => [
                    'mgpl_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-list-item .mpdl-img img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpl_imgbg_height',
            [
                'label' => __('Image div Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'condition' => [
                    'mgpl_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-list-item .mpdl-img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpl_img_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-list-item .mpdl-img img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpl_img_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-list-item .mpdl-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpl_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-list-item .mpdl-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpl_img_bgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mgpdl-list-item .mpdl-img img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpl_img_border',
                'selector' => '{{WRAPPER}} .mgpdl-list-item .mpdl-img img',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpl_highlight_style',
            [
                'label' => __('Highlighted Items Style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'highlight_width',
            [
                'label' => __('Highlighted Items Width', 'magical-posts-display'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .row.mgpo-yes .col-sm-auto:first-child' => 'flex: 0 0 {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mpdl-img,{{WRAPPER}} .mpdl-date' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpl_highlight_margin',
            [
                'label' => __('Highlighted Items Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-date.bg-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpl_highlight_dhead',
            [
                'label' => __('Highlighted Date', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'mgpl_highlight_dpadding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-date span.mp-day' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpl_highlight_dcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpdl-date span.mp-day' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpl_highlight_dbgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mpdl-date span.mp-day',
            ]
        );
        $this->add_control(
            'mgpl_highlight_mhead',
            [
                'label' => __('Highlighted Month', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'mgpl_highlight_mpadding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-date span.mp-month' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpl_highlight_mcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpdl-date span.mp-month' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpl_highlight_mbgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mpdl-date span.mp-month',
            ]
        );
        $this->add_control(
            'mgpl_highlight_yhead',
            [
                'label' => __('Highlighted Year', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'mgpl_highlight_ypadding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-date span.mp-year' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpl_highlight_ycolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpdl-date span.mp-year' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpl_highlight_ybgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mpdl-date span.mp-year',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mgpl_title_style',
            [
                'label' => __('posts Title', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpl_title_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-text .mpdl-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpl_title_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-text .mpdl-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpl_title_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpdl-text .mpdl-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpl_title_typography',
                'selector' => '{{WRAPPER}} .mpdl-text .mpdl-title a',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpl_meta_style',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mgpl_meta_cat',
            [
                'label' => __('Category style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',

            ]
        );

        $this->add_responsive_control(
            'mgpl_meta_cat_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-meta.cat-list a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpl_post_catshow' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpl_meta_cat_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-meta.cat-list a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpl_post_catshow' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpl_meta_cat_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta.cat-list a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpl_post_catshow' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpl_meta_cat_typography',
                'selector' => '{{WRAPPER}} .mp-meta.cat-list a',
                'condition' => [
                    'mgpl_post_catshow' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mgpl_meta_cat_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta.cat-list a' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpl_post_catshow' => 'yes',
                ],

            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpl_cat_border',
                'selector' => '{{WRAPPER}} .mp-meta.cat-list a',
                'condition' => [
                    'mgpl_post_catshow' => 'yes',
                ],

            ]
        );

        $this->add_control(
            'mgpl_cat_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-meta.cat-list a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpl_post_catshow' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mgpl_meta_author',
            [
                'label' => __('Posts Author', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',


            ]
        );

        $this->add_responsive_control(
            'mgpl_meta_author_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-text .byline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'mgpl_meta_author_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-text .byline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            'mgpl_meta_author_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpdl-text .byline a, {{WRAPPER}} .mpdl-text .byline i' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_control(
            'mgpl_meta_author_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpdl-text .byline' => 'background-color: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpl_meta_author_typography',
                'selector' => '{{WRAPPER}} .mpdl-text .byline a',

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpl_author_border',
                'selector' => '{{WRAPPER}} .mpdl-text .byline',

            ]
        );

        $this->add_control(
            'mgpl_author_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-text .byline' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'mgpl_meta_date',
            [
                'label' => __('Date Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpl_date_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpl_meta_date_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-mdate' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpl_date_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpl_meta_date_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-mdate' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpl_date_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpl_meta_date_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpdl-mdate, {{WRAPPER}} .mpdl-mdate i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpl_date_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpl_meta_date_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpdl-mdate' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpl_date_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpl_meta_date_typography',
                'selector' => '{{WRAPPER}} .mpdl-mdate',
                'condition' => [
                    'mgpl_date_show' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpl_date_border',
                'selector' => '{{WRAPPER}} .mpdl-mdate',
                'condition' => [
                    'mgpl_date_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpl_author_date_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdl-mdate' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpl_date_show' => 'yes',
                ],
            ]
        );
    }

    /**
     * Render Blank widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {

        $rand_num = wp_rand(6252948, 8952146);

        $settings = $this->get_settings_for_display();
        $mgpg_post_type = isset($settings['mgpg_post_type']) ? $settings['mgpg_post_type'] : 'post';
        $mgpg_post_type = sanitize_text_field($mgpg_post_type);
        $mgpl_posts_count = absint($this->get_settings('mgpl_posts_count'));

        $mgpl_filter = $this->get_settings('mgpl_posts_filter');
        $mgpl_custom_order = $this->get_settings('mgpl_custom_order');
        $mgpl_grid_categories = $this->get_settings('mgpl_grid_categories');
        $mgpl_list_show = $this->get_settings('mgpl_list_show');
        $orderby = $this->get_settings('orderby');
        $order = $this->get_settings('order');
        $mgpl_post_img_position = $this->get_settings('mgpl_post_img_position');
        $mgpl_post_img_size = $this->get_settings('mgpl_post_img_size');
        $mgpl_post_style = $this->get_settings('mgpl_post_style');
        $mgpl_show_title = $this->get_settings('mgpl_show_title');
        $mgpl_crop_title = $this->get_settings('mgpl_crop_title');

?>
        <div class="mgpd mp-display-list mgpdl mgpdl<?php echo esc_attr($rand_num); ?> mgpdl-h<?php echo esc_attr($mgpl_post_style); ?> ">


            <ul class="mgpdl-list <?php if (empty($mgpl_list_show)) : ?>mgpdl-hstyle<?php endif; ?>">
                <?php


                if (is_front_page()) {
                    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
                } else {
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                }
                // Query Argument
                $args = array(
                    'post_type'             => $mgpg_post_type,
                    'post_status'           => 'publish',
                    'ignore_sticky_posts'   => 1,
                    'posts_per_page'        => $mgpl_posts_count,
                );

                switch ($mgpl_filter) {
                    case 'trending':
                        $args['meta_key']    = 'mp_post_week_viewed';
                        $args['orderby']      = 'rand';
                        break;

                    case 'popular':
                        $args['meta_key']    = 'mp_post_post_viewed';
                        $args['orderby']      = 'meta_value_num';
                        break;

                    case 'random_order':
                        $args['orderby']    = 'rand';
                        break;

                    default: /* Recent */
                        $args['orderby']    = 'date';
                        $args['order']      = 'desc';
                        break;
                }
                if ($mgpl_filter === 'show_byid' && !empty($settings['mgpl_post_id'])) {
                    $args['post__in'] = array_map('absint', $settings['mgpl_post_id']);
                } elseif ($mgpl_filter === 'show_byid_manually') {
                    $post_ids = array_map('absint', explode(',', $settings['mgpl_post_ids_manually']));
                    $args['post__in'] = array_filter($post_ids);
                }


                // Custom Order
                if ($mgpl_custom_order == 'yes') {
                    $args['orderby'] = $orderby;
                    $args['order'] = $order;
                }

                if (!(($mgpl_filter == "show_byid") || ($mgpl_filter == "show_byid_manually"))) {

                    $post_cats = str_replace(' ', '', $mgpl_grid_categories);
                    if ("0" != $mgpl_grid_categories && $mgpg_post_type == 'post') {
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



                $mp_loop = new WP_Query($args);
                if ($mp_loop->have_posts()) :
                    while ($mp_loop->have_posts()) :  $mp_loop->the_post();
                        $mpdl_column = 'auto';
                        $mpdl_column_meta = 'auto';
                ?>
                        <li class="mgpdl-list-item mgbb mb-1 pb-1 text-<?php if ($mgpl_post_img_position == 'right') : ?>right<?php else : ?>left<?php endif; ?>">
                            <div class="row mgpo-<?php echo esc_attr($settings['mgpl_post_inline']);
                                                    if ($mgpl_post_img_position == 'right') : ?> mgpdl-hright<?php endif; ?>">
                                <?php if ($mgpl_post_style != 'hide') : ?>
                                    <?php if ($mgpl_post_style == 'show_date' || !has_post_thumbnail()) : ?>
                                        <div class="col-sm-<?php echo esc_attr($mpdl_column_meta); ?>">
                                            <div class="mpdl-date bg-info text-center">
                                                <span class="mp-day"><?php echo esc_html(get_the_date('l')); ?></span>
                                                <span class="mp-month"><?php echo esc_html(get_the_date('M j')); ?></span>
                                                <span class="mp-year"><?php echo esc_html(get_the_date('Y')); ?></span>
                                            </div>
                                        </div>
                                    <?php
                                    else :
                                    ?>
                                        <div class="col-sm-<?php echo esc_attr($mpdl_column_meta); ?>">
                                            <div class="mpdl-img">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail($mgpl_post_img_size); ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?php
                                    endif; // check post meta or image 
                                    ?>
                                <?php endif; ?>
                                <div class="col-sm-<?php echo esc_attr($mpdl_column); ?>">
                                    <div class="mpdl-text">
                                        <?php if ($settings['mgpl_post_catshow'] && $mgpg_post_type == 'post') : ?>
                                            <div class="mp-meta cat-list">
                                                <?php
                                                mpd_one_cat(get_the_ID());
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($mgpl_show_title) : ?>
                                            <h3 class="mpdl-title">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php
                                                    if ($mgpl_crop_title) {
                                                        echo esc_html(wp_trim_words(get_the_title(), $mgpl_crop_title, '..'));
                                                    } else {
                                                        the_title();
                                                    }
                                                    ?>
                                                </a>
                                            </h3>
                                        <?php endif; ?>
                                        <?php if ($settings['mgpl_show_author'] || $settings['mgpl_date_show']) : ?>
                                            <div class="mp-meta bottom-meta mb-2">
                                                <?php
                                                if ($settings['mgpl_show_author']) {
                                                    mp_display_posted_by();
                                                }
                                                ?>
                                                <span class="mpdl-mdate">
                                                    <?php
                                                    if ($settings['mgpl_date_show']) {
                                                        echo '<i class="icon-mp-clock"></i> ';
                                                        echo esc_html(get_the_date());
                                                    }
                                                    ?>
                                                </span>
                                                <?php
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>

                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                <?php else :
                    mp_display_posts_not_found($settings['mgpg_post_type']);
                endif; ?>
            </ul>
        </div>
<?php
    }
}
