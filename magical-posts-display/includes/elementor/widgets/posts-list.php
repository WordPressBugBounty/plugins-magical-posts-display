<?php


class mgpdEPostsList extends \Elementor\Widget_Base
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
        return 'mgposts_list';
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
        return __('Magical Posts List', 'magical-posts-display');
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
        return ['magic', 'post', 'grid', 'list', 'category'];
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
            'mgpla_post_type',
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
                'options' => [
                    'recent' => esc_html__('Recent Posts', 'magical-posts-display'),
                    'popular' => esc_html__('Popular Posts(Pro Only)', 'magical-posts-display'),
                    'trending' => esc_html__('Trending posts(Pro Only)', 'magical-posts-display'),
                    'random_order' => esc_html__('Random Posts', 'magical-posts-display'),
                    'show_byid' => esc_html__('Show By Id', 'magical-posts-display'),
                    'show_byid_manually' => esc_html__('Add ID Manually', 'magical-posts-display'),
                ],
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
                    'mgpla_post_type' => 'post',
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
                'default' => 3,
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
                    'mgpla_post_type' => 'post',
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
            'mgpl_layout',
            [
                'label' => esc_html__('List Layout', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpl_post_style',
            [
                'label'   => __('List Style', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'   => __('Style One', 'magical-posts-display'),
                    '2'  => __('Style Two', 'magical-posts-display'),
                ]
            ]
        );
        $this->add_control(
            'mgpl_post_img_position',
            [
                'label' => __('Image position', 'magical-posts-display'),
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
                'prefix_class' => 'mgl-img-',
                'style_transfer' => true,
            ]

        );
        $this->add_control(
            'mgpl_wrap',
            [
                'label' => __('Active No Wrap?', 'magical-posts-display'),
                'description' => __('No Wrap Only work less than 768px layouts', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => '',
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
            'mgpl_post_img_show',
            [
                'label'     => __('Show Posts image', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpl_show_title',
            [
                'label'     => __('Show posts Title', 'magical-posts-display'),
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
                'default' => 5,
                'condition' => [
                    'mgpl_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpl_title_tag',
            [
                'label' => __('Title HTML Tag', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h4',
                'condition' => [
                    'mgpl_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpl_desc_show',
            [
                'label'     => __('Show posts Description', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'

            ]
        );
        $this->add_control(
            'mgpl_crop_desc',
            [
                'label'   => __('Crop Description By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 20,
                'condition' => [
                    'mgpl_desc_show' => 'yes',
                ]

            ]
        );

        $this->add_responsive_control(
            'mgpl_content_align',
            [
                'label' => __('Alignment', 'magical-posts-display'),
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
                'classes' => 'flex-{{VALUE}}',
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .card-body.mgpdl-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpl_meta_section',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'default' => '',
            ]
        );
        $this->add_control(
            'mgpl_date_show',
            [
                'label'     => __('Show Date', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpl_category_show',
            [
                'label'     => __('Show Category', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'mgpla_post_type' => 'post',
                ]

            ]
        );
        $this->add_control(
            'mgpl_cat_type',
            [
                'label' => __('Category type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'all' => __('Show all categories', 'magical-posts-display'),
                    'one' => __('Show first category', 'magical-posts-display'),
                ],
                'default' => 'one',
                'condition' => [
                    'mgpl_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_control(
            'mgpl_author_show',
            [
                'label'     => __('Show Author', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpl_tag_show',
            [
                'label'     => __('Show Tags', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',

            ]
        );
        $this->add_control(
            'mgpl_comment_show',
            [
                'label'     => __('Show Comment', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',

            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'mgpl_button',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgpl_post_btn',
            [
                'label' => __('Use post link?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgpl_link_type',
            [
                'label' => __('Link type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'link1' => 'Link style one',
                    'btn btn-outline-dark' => 'Link style two',
                    'btn btn-info' => 'Button',
                ],
                'default' => 'link1',
            ]
        );

        $this->add_control(
            'mgpl_btn_title',
            [
                'label'       => __('Link Title', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Read More', 'magical-posts-display'),
                'default'     => __('Read More', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpl_btn_target',
            [
                'label' => __('Link Target', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '_self' => 'self',
                    '_blank' => 'Blank',
                ],
                'default' => '_self',
            ]
        );

        $this->add_control(
            'mgpl_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => '',
            ]
        );

        $this->add_control(
            'mgpl_btn_icon',
            [
                'label' => __('Choose Icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mgpl_usebtn_icon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpl_btn_icon_position',
            [
                'label' => __('Icon Position', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-posts-display'),
                        'icon' => 'fas fa-arrow-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-posts-display'),
                        'icon' => 'fas fa-arrow-right',
                    ],

                ],
                'default' => 'right',
                'condition' => [
                    'mgpl_usebtn_icon' => 'yes',
                ],

            ]
        );
        $this->add_responsive_control(
            'mgpl_cardbtn_iconspace',
            [
                'label' => __('Icon Spacing', 'magical-posts-display'),
                'type' => Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],

                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'condition' => [
                    'mgpl_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .mp-post-btn i.left,{{WRAPPER}} .mgpdl-item .mp-post-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgpdl-item .mp-post-btn i.right, {{WRAPPER}} .mgpdl-item .mp-post-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpg_pagination',
            [
                'label' => sprintf('%s %s', __('Posts Pagination', 'magical-posts-display'), mp_display__pro_only_text()),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        if (empty(mp_display_check_main_ok())) {
            $this->add_control(
                'mgpg_pagination_info',
                [
                    'label' => sprintf('<span style="color:red">%s</span>', __('The Section only work with pro version.', 'magical-posts-display')),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
        }
        $this->add_control(
            'mgpg_pagination_show',
            [
                'label' => __('Show Pagination', 'magical-posts-display'),
                'description'   => __('Pagination only use the page for perfect display.', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => '',
            ]
        );
        $this->add_control(
            'mgpg_pagination_style',
            [
                'label' => __('Pagination Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'style1' => __('style One', 'magical-posts-display'),
                    'style2' => __('Style Two', 'magical-posts-display'),
                ],
                'default' => 'style1',
            ]
        );
        $this->add_responsive_control(
            'mgpg_pagination_align',
            [
                'label' => __('Pagination Alignment', 'magical-posts-display'),
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination' => 'text-align: {{VALUE}};',
                ],
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
                        'massage' => esc_html__('Posts Video, QR Code, Reading Time Calculator, Total Word Count, Share Icons, Pagination And More style & options waiting for you. So upgrade pro today!! it\'s lifetime Deal!!!', 'magical-posts-display'),
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
                'label' => __('List Items style', 'magical-posts-display'),
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
                    '{{WRAPPER}} .mgpdl .mgpdl-items .mgpdl-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgpdl .mgpdl-items .mgpdl-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpl_bg_color',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .mgpdl .mgpdl-items .mgpdl-item, {{WRAPPER}} .mgpdl .mgpdl-items .mgpdl-item .mgpdl-card',
            ]
        );

        $this->add_control(
            'mgpl_border_radius',
            [
                'label' => __('Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl .mgpdl-items .mgpdl-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpl_content_border',
                'selector' => '{{WRAPPER}} .mgpdl .mgpdl-items .mgpdl-item',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpl_content_shadow',
                'selector' => '{{WRAPPER}} .mgpdl .mgpdl-items .mgpdl-item',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgpl_img_style',
            [
                'label' => __('Image style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mgpl_post_img_show' => 'yes',
                ]
            ]
        );
        $this->add_responsive_control(
            'image_width_set',
            [
                'label' => __('Width', 'magical-posts-display'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'desktop_default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-img' => 'flex: 0 0 {{SIZE}}{{UNIT}};',

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
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'condition' => [
                    'mgpl_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-card figure img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpl_imgbg_height',
            [
                'label' => __('Image div Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
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
                    '{{WRAPPER}} .mgpdl-card figure' => 'height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgpdl-card figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgpdl-card figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgpdl-card figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpl_img_bgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mgpdl-card figure img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpl_img_border',
                'selector' => '{{WRAPPER}} .mgpdl-card figure img',
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
                    '{{WRAPPER}} .mgpdl-item .mgp-ptitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgpdl-item .mgp-ptitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpl_title_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item a.mgp-title-link,{{WRAPPER}} .mgpdl-item .mgp-ptitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpl_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .mgp-ptitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpl_descb_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .mgp-ptitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpl_title_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpdl-item .mgp-ptitle',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpl_description_style',
            [
                'label' => __('Description', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpl_description_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .mgpdl-card .mgpdl-text p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpl_description_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .mgpdl-card .mgpdl-text p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpl_description_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .mgpdl-card .mgpdl-text p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpl_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .mgpdl-card .mgpdl-text p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpl_description_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .mgpdl-card .mgpdl-text p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpl_description_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpdl-item .mgpdl-card .mgpdl-text p',
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
                'condition' => [
                    'mgpl_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpl_meta_cat_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-post-cat .mgp-post-cats' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpl_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_control(
            'mgpl_meta_cat_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mppost-cats.mp-post-cat i,{{WRAPPER}} .mppost-cats.mp-post-cat a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpl_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpl_meta_cat_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-post-cat .mgp-post-cats a, {{WRAPPER}} .mp-post-cat .mgp-post-cats',
                'condition' => [
                    'mgpl_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
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
                    '{{WRAPPER}} .mp-meta .byline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'mgpl_meta_author_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline i, {{WRAPPER}} .mp-meta .byline a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpl_author_show' => 'yes',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpl_meta_author_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-meta .byline a',
                'condition' => [
                    'mgpl_author_show' => 'yes',
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
                    '{{WRAPPER}} .mgp-time,{{WRAPPER}} .mp-posts-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgp-time, {{WRAPPER}} .mgp-time i,{{WRAPPER}} .mp-posts-date,{{WRAPPER}} .mp-posts-date i' => 'color: {{VALUE}};',
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
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-posts-date,{{WRAPPER}} .mgp-time',
                'condition' => [
                    'mgpl_date_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpl_meta_tag',
            [
                'label' => __('Tags style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpl_tag_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpl_meta_tag_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpl_tag_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpl_meta_tag_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links a, {{WRAPPER}} .mpg-tags-links i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpl_tag_show' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpl_meta_tag_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mpg-tags-links a',
                'condition' => [
                    'mgpl_date_show' => 'yes',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpl_btn_style',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpl_btn_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-card a.mp-post-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpl_btn_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-card a.mp-post-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpl_btn_typography',
                'selector' => '{{WRAPPER}} .mgpdl-card a.mp-post-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpl_btn_border',
                'selector' => '{{WRAPPER}} .mgpdl-card a.mp-post-btn',
            ]
        );

        $this->add_control(
            'mgpl_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-card a.mp-post-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpl_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mgpdl-card a.mp-post-btn',
            ]
        );
        $this->add_control(
            'mgpl_button_color',
            [
                'label' => __('Button color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('mgpl_btn_tabs');

        $this->start_controls_tab(
            'mgpl_btn_normal_style',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpl_btn_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-card a.mp-post-btn' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgpl_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-card a.mp-post-btn' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpl_btn_hover_style',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpl_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} .mgpdl-card a.mp-post-btn:hover',
            ]
        );

        $this->add_control(
            'mgpl_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-card a.mp-post-btn:hover, {{WRAPPER}} .mgpdl-card a.mp-post-btn:focus' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgpl_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-card a.mp-post-btn:hover, {{WRAPPER}} .mgpdl-card a.mp-post-btn:focus' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgpl_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgpl_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-card a.mp-post-btn:hover, {{WRAPPER}} .mgpdl-card a.mp-post-btn:focus' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        //pagination style
        $this->start_controls_section(
            'mgpg_pagi_style',
            [
                'label' => sprintf('%s %s', __('Pagination Style', 'magical-posts-display'), mp_display__pro_only_text()),

                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mgpg_pagination_show' => 'yes',
                ]
            ]
        );
        if (empty(mp_display_check_main_ok())) {
            $this->add_control(
                'mgpg_pagination_sinfo',
                [
                    'label' => sprintf('<span style="color:red">%s</span>', __('The Section only work with pro version.', 'magical-posts-display')),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
        }

        $this->add_responsive_control(
            'mgpg_pagination_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination a.page-numbers,{{WRAPPER}} .mp-pagination span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_pagination_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination a.page-numbers,{{WRAPPER}} .mp-pagination span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_pagination_typography',
                'selector' => '{{WRAPPER}} .mp-pagination a.page-numbers,{{WRAPPER}} .mp-pagination span',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_pagination_border',
                'selector' => '{{WRAPPER}} .mp-pagination a.page-numbers,{{WRAPPER}} .mp-pagination span',
            ]
        );

        $this->add_control(
            'mgpg_pagination_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination a.page-numbers,{{WRAPPER}} .mp-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_pagination_box_shadow',
                'selector' => '{{WRAPPER}} .mp-pagination a.page-numbers,{{WRAPPER}} .mp-pagination span',
            ]
        );


        $this->start_controls_tabs('mgpg_pagination_tabs');

        $this->start_controls_tab(
            'mgpg_pagination_normal_style',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpg_pagination_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination a.page-numbers,{{WRAPPER}} .mp-pagination span' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgpg_pagination_bg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination a.page-numbers,{{WRAPPER}} .mp-pagination span' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpg_pagination_hover_style',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_pagihover_boxshadow',
                'selector' => '{{WRAPPER}} .mp-pagination a.page-numbers:hover,{{WRAPPER}} .mp-pagination span:hover',
            ]
        );

        $this->add_control(
            'mgpg_pagination_hcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination a.page-numbers:hover,{{WRAPPER}} .mp-pagination span:hover' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgpg_pagination_hbg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination a.page-numbers:hover,{{WRAPPER}} .mp-pagination span:hover' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgpg_pagination_hborder_color',
            [
                'label' => __('Border Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgpg_pagination_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination a.page-numbers:hover,{{WRAPPER}} .mp-pagination span:hover' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->start_controls_tab(
            'mgpg_pagination_act_style',
            [
                'label' => __('Active', 'magical-posts-display'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_btnact_boxshadow',
                'selector' => '{{WRAPPER}} .mp-pagination span.current,{{WRAPPER}} .mp-pagination a.page-numbers:focus,{{WRAPPER}} .mp-pagination span:focus',
            ]
        );

        $this->add_control(
            'mgpg_pagination_accolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination span.current,{{WRAPPER}} .mp-pagination a.page-numbers:focus,{{WRAPPER}} .mp-pagination span:focus' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgpg_pagination_acbg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination span.current,{{WRAPPER}} .mp-pagination a.page-numbers:focus,{{WRAPPER}} .mp-pagination span:focus' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgpg_pagination_acborder_color',
            [
                'label' => __('Border Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgpg_pagination_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mp-pagination span.current,{{WRAPPER}} .mp-pagination a.page-numbers:focus,{{WRAPPER}} .mp-pagination span:focus' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
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

        $settings = $this->get_settings_for_display();
        $mgpla_post_type = isset($settings['mgpla_post_type']) ? $settings['mgpla_post_type'] : 'post';
        $mgpla_post_type = sanitize_text_field($mgpla_post_type);
        $mgpl_posts_count = absint($this->get_settings('mgpl_posts_count'));


        $mgpl_filter = $this->get_settings('mgpl_posts_filter');
        $mgpl_posts_count = $this->get_settings('mgpl_posts_count');
        $mgpl_custom_order = $this->get_settings('mgpl_custom_order');
        $mgpl_grid_categories = $this->get_settings('mgpl_grid_categories');
        $orderby = $this->get_settings('orderby');
        $order = $this->get_settings('order');

        if (mp_display_check_main_ok() || mp_display_author_namet() == 'wptheme space pro') {
            $mgpg_pagination_show = $settings['mgpg_pagination_show'];
        } else {
            $mgpg_pagination_show = '';
        }

        //pagination
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

        // Query Argument
        $args = array(
            'post_type'             => $mgpla_post_type,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $mgpl_posts_count,
        );
        if ($mgpg_pagination_show) {
            $args['paged'] = $paged;
        }

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

            case 'show_byid':
                $args['post__in'] = $settings['mgpl_post_id'];
                break;

            case 'show_byid_manually':
                $args['post__in'] = explode(',', $settings['mgpl_post_ids_manually']);
                break;

            default: /* Recent */
                $args['orderby']    = 'date';
                $args['order']      = 'desc';
                break;
        }



        // Custom Order
        if ($mgpl_custom_order == 'yes') {
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }

        if (!(($mgpl_filter == "show_byid") || ($mgpl_filter == "show_byid_manually"))) {

            $post_cats = str_replace(' ', '', $mgpl_grid_categories);
            if ("0" != $mgpl_grid_categories && $mgpla_post_type == 'post') {
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

        //grid layout
        $image_width_set = $this->get_settings('image_width_set');
        $mgpl_post_style = $this->get_settings('mgpl_post_style');
        // grid content
        $mgpl_post_img_show = $this->get_settings('mgpl_post_img_show');
        $mgpl_show_title = $this->get_settings('mgpl_show_title');
        $mgpl_crop_title = $this->get_settings('mgpl_crop_title');
        $mgpl_title_tag = $this->get_settings('mgpl_title_tag');
        $mgpl_desc_show = $this->get_settings('mgpl_desc_show');
        $mgpl_crop_desc = $this->get_settings('mgpl_crop_desc');
        $mgpl_post_btn = $this->get_settings('mgpl_post_btn');
        $mgpl_category_show = $this->get_settings('mgpl_category_show');
        $mgpl_usebtn_icon = $this->get_settings('mgpl_usebtn_icon');
        $mgpl_btn_title = $this->get_settings('mgpl_btn_title');
        $mgpl_btn_target = $this->get_settings('mgpl_btn_target');
        $mgpl_btn_icon = $this->get_settings('mgpl_btn_icon');
        $mgpl_btn_icon_position = $this->get_settings('mgpl_btn_icon_position');
        $mgpl_wrap = $this->get_settings('mgpl_wrap');


        $mgpl_posts = new WP_Query($args);

        if ($mgpl_posts->have_posts()) :
?>
            <div id="mglp-items" class="mgpd mp-display-list mgpdl style<?php echo esc_attr($mgpl_post_style); ?>">
                <div class="mgpdl-items">
                    <?php while ($mgpl_posts->have_posts()) : $mgpl_posts->the_post(); ?>
                        <div class="mgpdl-item mgpd-list mb-4 <?php if (has_post_thumbnail() && $mgpl_post_img_show) : ?>mgpdl-hasimg<?php endif; ?>">
                            <div class="card mgpdl-card <?php if ($mgpl_wrap) : ?>no-wrap<?php endif; ?>">
                                <?php if (has_post_thumbnail() && $mgpl_post_img_show) : ?>
                                    <div class="mgpdl-img">
                                        <figure>
                                            <a href="<?php the_permalink(); ?>" target="<?php echo esc_attr($mgpl_btn_target); ?>">
                                                <?php the_post_thumbnail(); ?>
                                            </a>
                                        </figure>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body mgpdl-text">
                                    <?php
                                    // display category
                                    if ($mgpla_post_type == 'post') {
                                        mp_post_cat_display($mgpl_category_show, $settings['mgpl_cat_type'], ', ');
                                    }
                                    // Display Title 
                                    mp_post_title($mgpl_show_title, $mgpl_title_tag, $mgpl_crop_title);
                                    // display authr and date meta
                                    if ($mgpl_post_style == '1') {
                                        mpd_posts_meta($settings['mgpl_author_show'], $settings['mgpl_date_show'], $settings['mgpl_comment_show']);
                                    }

                                    ?>

                                    <?php if ($mgpl_desc_show) : ?>
                                        <p>
                                            <?php
                                            if (has_excerpt()) {
                                                echo esc_html(wp_trim_words(get_the_excerpt(), $mgpl_crop_desc, '...'));
                                            } else {
                                                echo esc_html(wp_trim_words(get_the_content(), $mgpl_crop_desc, '...'));
                                            }
                                            ?></p>
                                    <?php endif; ?>
                                    <?php
                                    // display button
                                    if ($mgpl_post_btn) {
                                        mp_post_btn(
                                            $text = $mgpl_btn_title,
                                            $icon_show = $mgpl_usebtn_icon,
                                            $icon = $mgpl_btn_icon,
                                            $icon_position = $mgpl_btn_icon_position,
                                            $target = $mgpl_btn_target,
                                            $class = $settings['mgpl_link_type']
                                        );
                                    }

                                    if ($mgpl_post_style == '2') {
                                        mpd_posts_meta_author_date($settings['mgpl_author_show'], $settings['mgpl_date_show'], 'text-right mpls2');
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_query();
                    wp_reset_postdata();
                    ?>
                </div>
            </div>

            <?php
            if ($mgpg_pagination_show) {
                mp_display_pagination($paged, $mgpl_posts, $settings['mgpg_pagination_style']);
            }
            ?>
<?php else :
            mp_display_posts_not_found($settings['mgpla_post_type']);
        endif;
    }
}
