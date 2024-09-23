<?php


class mgPosts_carousel extends \Elementor\Widget_Base
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
        return 'mgposts_carousel';
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
        return __('Magical Posts Carousel', 'magical-posts-display');
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
        return 'eicon-carousel';
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
        return ['mmagic', 'post', 'posts', 'carousel', 'slider'];
    }

    public function get_style_depends()
    {
        return [
            'swiper',
        ];
    }
    public function get_script_depends()
    {
        return [
            'mg-swiper',
            'mpd-pcarousel-active',
        ];
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
        $this->register_advanced_controls();
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
            'mgpcar_query',
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
            'mgpcar_posts_filter',
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
            'mgpcar_post_id',
            [
                'label' => __('Select Post', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_posts_name(),
                'condition' => [
                    'mgpcar_posts_filter' => 'show_byid',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_post_ids_manually',
            [
                'label' => __('Post IDs', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'mgpcar_posts_filter' => 'show_byid_manually',
                ]
            ]
        );

        $this->add_control(
            'mgpcar_posts_count',
            [
                'label'   => __('Post Limit', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 10,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'mgpcar_grid_categories',
            [
                'label' => esc_html__('Post Categories', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_taxonomy_list(),
                'condition' => [
                    'mgpcar_posts_filter!' => 'show_byid',
                    'mgpla_post_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'mgpcar_custom_order',
            [
                'label' => esc_html__('Custom order', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'no',
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
                    'mgpcar_custom_order' => 'yes',
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
                    'mgpcar_custom_order' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpcar_layout',
            [
                'label' => esc_html__('Carousel Layout', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpcar_post_style',
            [
                'label'   => __('Grid Style', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'   => __('Style One', 'magical-posts-display'),
                    '2'  => __('Style Two', 'magical-posts-display'),
                ]
            ]
        );
        $this->add_control(
            'mgpcar_rownumber',
            [
                'label'   => __('Show Posts Per Row', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'step'    => 1,
            ]
        );
        $this->end_controls_section();
        // carousel settings
        $this->start_controls_section(
            'mgpcar_settings_section',
            [
                'label' => __('Carousel Settings', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgpcar_posts_number',
            [
                'label' => __('Carousel Items', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'step' => 1,
                'max' => 100,
                'default' => 3,
                'description' => __('Enter How many items show at a time in the carousel', 'magical-posts-display'),
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'mgpcar_posts_margin',
            [
                'label' => __('Between Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'size' => 30,
                ],
            ]
        );
        /*
            $this->add_control(
                'mgpcar_slide_direction',
                [
                    'label' => __( 'Slide Direction', 'magical-posts-display' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        'horizontal' => __( 'Horizontal', 'magical-posts-display' ),
                        'vertical' => __( 'Vertical', 'magical-posts-display' ),
                    ],
                    'default' => 'horizontal',
                    'frontend_available' => true,
                    'style_transfer' => true,
                ]
            );
            */

        $this->add_control(
            'mgpcar_autoplay',
            [
                'label' => __('Autoplay?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'mgpcar_autoplay_delay',
            [
                'label' => __('Autoplay Delay', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 1,
                'max' => 50000,
                'default' => 2500,
                'description' => __('Autoplay Delay in milliseconds', 'magical-posts-display'),
                'frontend_available' => true,
                'condition' => [
                    'mgpcar_autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_autoplay_speed',
            [
                'label' => __('Autoplay Speed', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 100,
                'max' => 10000,
                'default' => 500,
                'description' => __('Autoplay speed in milliseconds', 'magical-posts-display'),
                'condition' => [
                    'mgpcar_autoplay' => 'yes'
                ],
                'frontend_available' => 'true',
            ]
        );

        $this->add_control(
            'mgpcar_loop',
            [
                'label' => __('Infinite Loop?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'mgpcar_auto_height',
            [
                'label' => __('Auto Height?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'mgpcar_grab_cursor',
            [
                'label' => __('Grab Cursor?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->end_controls_section();
        // Post image
        $this->start_controls_section(
            'mgpcar_img_section',
            [
                'label' => esc_html__('Posts Image', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpcar_post_img_show',
            [
                'label'     => __('Show Posts image', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpcar_img_size',
            [
                'label' => esc_html__('Image Size', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'medium_large',
                'options' => [
                    'thumbnail'  => esc_html__('Thumbnail (150px x 150px max)', 'magical-posts-display'),
                    'medium'   => esc_html__('Medium (300px x 300px max)', 'magical-posts-display'),
                    'medium_large'   => esc_html__('Large (768px x 0px max)', 'magical-posts-display'),
                    'large'   => esc_html__('Large (1024px x 1024px max)', 'magical-posts-display'),
                    'full'   => esc_html__('Full Size (Original image size)', 'magical-posts-display'),
                ],
                'condition' => [
                    'mgpcar_post_img_show' => 'yes',
                ]

            ]
        );
        /*
        $this->add_control(
            'mgpcar_img_effects',
            [
                'label' => esc_html__( 'Image Hover Effects', 'magical-posts-display' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'mgpr-hvr-shine',
                'options' => [
                    'mgpr-default'  => esc_html__('No Effects','magical-posts-display'),
                    'mgpr-hvr-circle'   => esc_html__('Circle Effect','magical-posts-display'),
                    'mgpr-hvr-shine'   => esc_html__('Shine Effect','magical-posts-display'),
                    'mgpr-hvr-flashing'   => esc_html__('Flashing Effect','magical-posts-display'),
                    'mgpr-hvr-hover'   => esc_html__('Opacity Effect','magical-posts-display'),
                    'mgpr-hvr-blur'   => esc_html__('Blur Effect','magical-posts-display'),
                    'mgpr-hvr-rotate'   => esc_html__('Rotate Effect','magical-posts-display'),
                    'mgpr-hvr-slide'   => esc_html__('Slide Effect','magical-posts-display'),
                    'mgpr-hvr-zoom-out'   => esc_html__('Zoom Out Effect','magical-posts-display'),
                    'mgpr-hvr-zoom-in'   => esc_html__('Zoom In Effect','magical-posts-display'),
                ],
                'condition' => [
                    'mgpcar_post_img_show' => 'yes',
                ]
                
            ]
        );
        */
        $this->end_controls_section();

        // posts Content
        $this->start_controls_section(
            'mgpcar_content',
            [
                'label' => esc_html__('Content Settings', 'magical-posts-display'),
            ]
        );


        $this->add_control(
            'mgpcar_show_title',
            [
                'label'     => __('Show posts Title', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpcar_crop_title',
            [
                'label'   => __('Crop Title By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 5,
                'condition' => [
                    'mgpcar_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpcar_title_tag',
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
                    'mgpcar_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpcar_desc_show',
            [
                'label'     => __('Show posts Description', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'

            ]
        );
        $this->add_control(
            'mgpcar_crop_desc',
            [
                'label'   => __('Crop Description By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 20,
                'condition' => [
                    'mgpcar_desc_show' => 'yes',
                ]

            ]
        );

        $this->add_responsive_control(
            'mgpcar_content_align',
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
                    '{{WRAPPER}} .mgp-card .mg-card-text.card-body' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_meta_section',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'default' => '',
            ]
        );
        $this->add_control(
            'mgpcar_category_show',
            [
                'label'     => __('Show Category', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'mgpla_post_type' => 'post',
                ],

            ]
        );
        $this->add_control(
            'mgpcar_caticon_show',
            [
                'label'     => __('Show Category Icon', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'mgpcar_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],

            ]
        );
        $this->add_control(
            'mgpcar_cat_type',
            [
                'label' => __('Category type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'all' => __('Show all categories', 'magical-posts-display'),
                    'one' => __('Show first category', 'magical-posts-display'),
                ],
                'default' => 'one',
                'condition' => [
                    'mgpcar_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_date_show',
            [
                'label'     => __('Show Date', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpcar_author_show',
            [
                'label'     => __('Show Author', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpcar_comment_icon_show',
            [
                'label'     => __('Show Comment Icon', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpcar_tag_show',
            [
                'label'     => __('Show Tags', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',

            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'mgpcar_button',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgpcar_post_btn',
            [
                'label' => __('Use post link?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpcar_link_type',
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
            'mgpcar_btn_title',
            [
                'label'       => __('Link Title', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Read More', 'magical-posts-display'),
                'default'     => __('Read More', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpcar_btn_target',
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
            'mgpcar_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => '',
            ]
        );

        $this->add_control(
            'mgpcar_btn_icon',
            [
                'label' => __('Choose Icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mgpcar_usebtn_icon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_btn_icon_position',
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
                    'mgpcar_usebtn_icon' => 'yes',
                ],

            ]
        );
        $this->add_responsive_control(
            'mgpcar_cardbtn_iconspace',
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
                    'mgpcar_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-card .mp-post-btn i.left,{{WRAPPER}} .mg-card .mp-post-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-card .mp-post-btn i.right, {{WRAPPER}} .mg-card .mp-post-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();



        // nava & dots settings
        $this->start_controls_section(
            'mgpcar_navdots_section',
            [
                'label' => __('Nav & Dots', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgpcar_dots',
            [
                'label' => __('Slider Dots?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpcar_navigation',
            [
                'label' => __('Slider Navigation?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->add_control(
            'mgpcar_nav_prev_icon',
            [
                'label' => __('Choose Prev Icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-left',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'arrow-alt-circle-left',
                        'arrow-circle-left',
                        'arrow-left',
                        'long-arrow-alt-left',
                        'angle-left',
                        'chevron-circle-left',
                        'fa-chevron-left',
                        'angle-double-left',
                    ],
                    'fa-regular' => [
                        'hand-point-left',
                        'arrow-alt-circle-left',
                        'caret-square-left',
                    ],
                ],
                'condition' => [
                    'mgpcar_navigation' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mgpcar_nav_next_icon',
            [
                'label' => __('Choose Next Icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-right',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'arrow-alt-circle-right',
                        'arrow-circle-right',
                        'arrow-right',
                        'long-arrow-alt-right',
                        'angle-right',
                        'chevron-circle-right',
                        'fa-chevron-right',
                        'angle-double-right',
                    ],
                    'fa-regular' => [
                        'hand-point-right',
                        'arrow-alt-circle-right',
                        'caret-square-right',
                    ],
                ],
                'condition' => [
                    'mgpcar_navigation' => 'yes',
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
            'mgpcar_style',
            [
                'label' => __('Carousel Items Style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'mgpcar_min_height',
            [
                'label' => __('Minimum Grid Height', 'magical-posts-display'),
                'type' => Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card' => 'min-height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpcar_bg_color',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .mgpc-pcarousel .mgp-card',
            ]
        );

        $this->add_control(
            'mgpcar_border_radius',
            [
                'label' => __('Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpcar_content_border',
                'selector' => '{{WRAPPER}} .mgpc-pcarousel .mgp-card',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpcar_content_shadow',
                'selector' => '{{WRAPPER}} .mgpc-pcarousel .mgp-card',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_img_style',
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

                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card figure img' => 'flex: 0 0 {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );

        $this->add_control(
            'mgpcar_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-posts-display'),
                'label_off' => __('Off', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpcar_img_height',
            [
                'label' => __('Image Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'condition' => [
                    'mgpcar_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card figure img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_imgbg_height',
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
                'default' => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'condition' => [
                    'mgpcar_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card figure' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_img_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card, {{WRAPPER}} .mgpc-pcarousel .mgp-card figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_img_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpcar_img_bgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mgpc-pcarousel .mgp-card, {{WRAPPER}} .mgpc-pcarousel .mgp-card figure img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpcar_img_border',
                'selector' => '{{WRAPPER}} .mgpc-pcarousel .mgp-card figure img',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_desc_style',
            [
                'label' => __('Post Title', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpcar_title_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card .mgp-ptitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_title_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card .mgp-ptitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_title_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card .mgp-ptitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card .mgp-ptitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_descb_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mgp-card .mgp-ptitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_title_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpc-pcarousel .mgp-card .mgp-ptitle',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_description_style',
            [
                'label' => __('Description', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpcar_description_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mg-card-text p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_description_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mg-card-text p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_description_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mg-card-text p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mg-card-text p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_description_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpc-pcarousel .mg-card-text p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_description_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpc-pcarousel .mg-card-text p',
            ]
        );

        $this->end_controls_section();
        // Posts meta    
        $this->start_controls_section(
            'mgpcar_meta_style',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mgpcar_meta_cat',
            [
                'label' => __('Category style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpcar_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_meta_cat_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mppost-cats' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpcar_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_meta_cat_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mppost-cats' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpcar_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpcar_catmeta_bg',
                'label' => esc_html__('Category Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .mppost-cats',
                'condition' => [
                    'mgpcar_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_meta_cat_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mppost-cats, {{WRAPPER}} .mppost-cats a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpcar_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_meta_cat_bradius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mppost-cats' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpcar_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_meta_cat_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mppost-cats, {{WRAPPER}} .mppost-cats a',
                'condition' => [
                    'mgpcar_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_meta_author',
            [
                'label' => __('Posts Author', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpcar_author_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_meta_author_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpcar_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_meta_author_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline i, {{WRAPPER}} .mp-meta .byline a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpcar_author_show' => 'yes',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_meta_author_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-meta .byline a',
                'condition' => [
                    'mgpcar_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_meta_date',
            [
                'label' => __('Date Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpcar_date_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_meta_date_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-time,{{WRAPPER}} .mp-posts-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpcar_date_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_meta_date_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-time, {{WRAPPER}} .mgp-time i,{{WRAPPER}} .mp-posts-date,{{WRAPPER}} .mp-posts-date i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpcar_date_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_meta_date_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-posts-date,{{WRAPPER}} .mgp-time',
                'condition' => [
                    'mgpcar_date_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_meta_tag',
            [
                'label' => __('Tags style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpcar_tag_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_meta_tag_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpcar_tag_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_meta_tag_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links a, {{WRAPPER}} .mpg-tags-links i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpcar_tag_show' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_meta_tag_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mpg-tags-links a',
                'condition' => [
                    'mgpcar_date_show' => 'yes',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_btn_style',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpcar_btn_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text a.mp-post-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_btn_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text a.mp-post-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_btn_typography',
                'selector' => '{{WRAPPER}} .mg-card-text a.mp-post-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpcar_btn_border',
                'selector' => '{{WRAPPER}} .mg-card-text a.mp-post-btn',
            ]
        );

        $this->add_control(
            'mgpcar_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text a.mp-post-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpcar_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mg-card-text a.mp-post-btn',
            ]
        );
        $this->add_control(
            'mgpcar_button_color',
            [
                'label' => __('Button color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('infobox_btn_tabs');

        $this->start_controls_tab(
            'mgpcar_btn_normal_style',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpcar_btn_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text a.mp-post-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text a.mp-post-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpcar_btn_hover_style',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpcar_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} .mg-card-text a.mp-post-btn:hover',
            ]
        );

        $this->add_control(
            'mgpcar_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text a.mp-post-btn:hover,{{WRAPPER}} .mg-card-text a.mp-post-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text a.mp-post-btn:hover,{{WRAPPER}} .mg-card-text a.mp-post-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgpcar_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text a.mp-post-btn:hover,{{WRAPPER}} .mg-card-text a.mp-post-btn:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_section_style_arrow',
            [
                'label' => __('Navigation - Arrow', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgpcar_arrow_position_toggle',
            [
                'label' => __('Position', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __('None', 'magical-posts-display'),
                'label_on' => __('Custom', 'magical-posts-display'),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'mgpcar_arrow_positiony',
            [
                'label' => __('Vertical', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 500,
                    ],

                ],

                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next,{{WRAPPER}} .swiper-button-prev' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_arrow_position_x',
            [
                'label' => __('Horizontal', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                // 'condition' => [
                //     'arrow_position_toggle' => 'yes'
                // ],
                'range' => [
                    'px' => [
                        'min' => -10,
                        'max' => 250,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-container-rtl .swiper-button-next' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-button-next,{{WRAPPER}} .swiper-container-rtl .swiper-button-prev' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();
        $this->add_responsive_control(
            'mgpcar_arrow_border',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};width:inherit;height:inherit',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpcar_arrow_border',
                'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
            ]
        );

        $this->add_responsive_control(
            'mgpcar_arrow_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->start_controls_tabs('mgpcar_tabs_arrow');

        $this->start_controls_tab(
            'mgpcar_tab_arrow_normal',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_responsive_control(
            'mgpcar_arrow_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next i,{{WRAPPER}} .swiper-button-prev i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-button-next svg, {{WRAPPER}} .swiper-button-prev svg,' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_arrow_bg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpcar_tab_arrow_hover',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpcar_arrow_hover_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_arrow_hover_bg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_arrow_hover_border_color',
            [
                'label' => __('Border Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgpcar_arrow_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_section_style_dots',
            [
                'label' => __('Navigation - Dots', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpcar_dots_position_y',
            [
                'label' => __('Vertical Position', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-bullets, {{WRAPPER}} .swiper-pagination-custom, {{WRAPPER}} .swiper-pagination-fraction' => 'bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-container-vertical>.swiper-pagination-bullets' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_dots_spacing',
            [
                'label' => __('Spacing', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .swiper-container-vertical>.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: calc({{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_dots_nav_align',
            [
                'label' => __('Alignment', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-posts-display'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-posts-display'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-posts-display'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],

                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-bullets, .swiper-pagination-custom, {{WRAPPER}} .swiper-pagination-fraction' => 'text-align: {{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'mgpcar_dots_width',
            [
                'label' => __('Dots Width', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_dots_height',
            [
                'label' => __('Dots Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_dots_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->start_controls_tabs('mgpcar_tabs_dots');
        $this->start_controls_tab(
            'mgpcar_tab_dots_normal',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpcar_dots_nav_color',
            [
                'label' => __('Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpcar_tab_dots_hover',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpcar_dots_nav_hover_color',
            [
                'label' => __('Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpcar_tab_dots_active',
            [
                'label' => __('Active', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpcar_dots_nav_active_color',
            [
                'label' => __('Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Register Blank widget Advanced ontrols.
     *
     * Adds different input fields in the style tab to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_advanced_controls()
    {
        $this->start_controls_section(
            'mgpdc_attr_sec',
            [
                'label' => __('Magical Attributes', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $this->add_control(
            'mgpdc_attr_calss',
            [
                'label' => __('Custom Class', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'mgpdc_attr_id',
            [
                'label' => __('Custom ID', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpdc_custom_css_sec',
            [
                'label' => __('Magical Custom CSS', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );
        $this->add_control(
            'mgpdc_custom_css',
            [
                'label' => __('Custom CSS', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::CODE,
                'language' => 'css',
                'rows' => 20,
            ]
        );

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
        $mgpcar_posts_count = absint($this->get_settings('mgpcar_posts_count'));


        $mgpcar_filter = $this->get_settings('mgpcar_posts_filter');
        $mgpcar_custom_order = $this->get_settings('mgpcar_custom_order');
        $mgpcar_grid_categories = $this->get_settings('mgpcar_grid_categories');
        $orderby = $this->get_settings('orderby');
        $order = $this->get_settings('order');


        // Query Argument
        $args = array(
            'post_type'             => $mgpla_post_type,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $mgpcar_posts_count,
        );

        switch ($mgpcar_filter) {

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
        if ($mgpcar_filter === 'show_byid' && !empty($settings['mgpcar_post_id'])) {
            $args['post__in'] = array_map('absint', $settings['mgpcar_post_id']);
        } elseif ($mgpcar_filter === 'show_byid_manually') {
            $post_ids = array_map('absint', explode(',', $settings['mgpcar_post_ids_manually']));
            $args['post__in'] = array_filter($post_ids);
        }


        // Custom Order
        if ($mgpcar_custom_order == 'yes') {
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }

        if (!(($mgpcar_filter == "show_byid") || ($mgpcar_filter == "show_byid_manually"))) {

            $post_cats = str_replace(' ', '', $mgpcar_grid_categories);
            if ("0" != $mgpcar_grid_categories && $mgpla_post_type == 'post') {
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
        $mgpcar_post_style = $this->get_settings('mgpcar_post_style');
        $mgpcar_autoplay = $this->get_settings('mgpcar_autoplay');
        if ($mgpcar_autoplay == 'yes') {
            $mgpcar_autoplay_set = $mgpcar_autoplay;
            $mgpcar_autoplay_delay = $settings['mgpcar_autoplay_delay'];
            $mgpcar_autoplay_speed = $settings['mgpcar_autoplay_speed'];
        } else {
            $mgpcar_autoplay_set = false;
            $mgpcar_autoplay_delay = 2500;
            $mgpcar_autoplay_speed = 500;
        }


        $mgpcar_products = new WP_Query($args);
        $mgp_unque_num = wp_rand('8652397', '5832471');
?>

        <div <?php if ($settings['mgpdc_attr_id']) : ?> id="<?php echo esc_attr($settings['mgpdc_attr_id']); ?>" <?php endif; ?> class="mgp-unique<?php echo esc_attr($mgp_unque_num); ?> mgproductd-grid <?php echo esc_attr($settings['mgpdc_attr_calss']); ?>">
            <?php if ($settings['mgpdc_custom_css']) : ?>
                <style>
                    <?php echo esc_html($settings['mgpdc_custom_css']); ?>
                </style>
            <?php endif; ?>
            <?php
            if ($mgpcar_products->have_posts()) :
            ?>

                <div id="mgpdeg-items" class="mgproductd mgpde-items style<?php echo esc_attr($mgpcar_post_style); ?>">
                    <div class="mgproductd mgpc-pcarousel swiper-container" data-loop="<?php echo esc_attr($settings['mgpcar_loop']); ?>" data-number="<?php echo esc_attr($settings['mgpcar_posts_number']); ?>" data-margin="<?php echo esc_attr($settings['mgpcar_posts_margin']['size']); ?>" data-direction="horizontal" data-autoplay="<?php echo esc_attr($mgpcar_autoplay_set); ?>" data-auto-delay="<?php echo esc_attr($mgpcar_autoplay_delay); ?>" data-speed="<?php echo esc_attr($mgpcar_autoplay_speed); ?>" data-auto-height="<?php echo esc_attr($settings['mgpcar_auto_height']); ?>" data-grab-cursor="<?php echo esc_attr($settings['mgpcar_grab_cursor']); ?>" data-nav="<?php echo esc_attr($settings['mgpcar_navigation']); ?>" data-dots="<?php echo esc_attr($settings['mgpcar_dots']); ?>">
                        <div class="swiper-wrapper">
                            <?php while ($mgpcar_products->have_posts()) : $mgpcar_products->the_post(); ?>
                                <div class="swiper-slide no-load">
                                    <?php $this->mgpcar_grid_item_style($settings); ?>
                                </div>
                            <?php
                            endwhile;
                            wp_reset_query();
                            wp_reset_postdata();
                            ?>
                        </div>
                        <?php if ($settings['mgpcar_dots']) : ?>
                            <div class="swiper-pagination mgpcar-btn"></div>
                        <?php endif; ?>

                        <?php if ($settings['mgpcar_navigation']) : ?>
                            <div class="swiper-button-prev mgpcar-nav">
                                <?php \Elementor\Icons_Manager::render_icon($settings['mgpcar_nav_prev_icon']); ?>
                            </div>
                            <div class="swiper-button-next mgpcar-nav">
                                <?php \Elementor\Icons_Manager::render_icon($settings['mgpcar_nav_next_icon']); ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php else :
                mp_display_posts_not_found($settings['mgpla_post_type']);
            endif; ?>
        </div>
    <?php

    } // 

    public function mgpcar_grid_item_style($settings)
    {

        $mgpcar_post_style = $this->get_settings('mgpcar_post_style');

        $mgpcar_post_img_show = $this->get_settings('mgpcar_post_img_show');
        $mgpcar_img_size = $this->get_settings('mgpcar_img_size');
        $mgpcar_show_title = $this->get_settings('mgpcar_show_title');
        $mgpcar_crop_title = $this->get_settings('mgpcar_crop_title');
        $mgpcar_title_tag = $this->get_settings('mgpcar_title_tag');
        $mgpcar_desc_show = $this->get_settings('mgpcar_desc_show');
        $mgpcar_crop_desc = $this->get_settings('mgpcar_crop_desc');
        $mgpcar_post_btn = $this->get_settings('mgpcar_post_btn');
        $mgpcar_category_show = $this->get_settings('mgpcar_category_show');
        $mgpcar_usebtn_icon = $this->get_settings('mgpcar_usebtn_icon');
        $mgpcar_btn_title = $this->get_settings('mgpcar_btn_title');
        $mgpcar_btn_target = $this->get_settings('mgpcar_btn_target');
        $mgpcar_btn_icon = $this->get_settings('mgpcar_btn_icon');
        $mgpcar_btn_icon_position = $this->get_settings('mgpcar_btn_icon_position');


    ?>
        <div class="card mg-card mg-shadow mgp-card mb-4">
            <?php mp_post_thumbnail($mgpcar_post_img_show, $mgpcar_img_size); ?>
            <div class="mg-card-text card-body">
                <?php
                if ($settings['mgpla_post_type'] == 'post') {
                    mp_post_cat_display($settings['mgpcar_category_show'], $settings['mgpcar_cat_type'], ', ', 'mp-post-cat', $settings['mgpcar_caticon_show']);
                }

                ?>

                <?php
                mp_post_title($mgpcar_show_title, $mgpcar_title_tag, $mgpcar_crop_title);
                ?>
                <?php
                if ($mgpcar_post_style == '1') {
                    mpd_posts_meta($settings['mgpcar_author_show'], $settings['mgpcar_date_show'], $settings['mgpcar_comment_icon_show']);
                }
                ?>
                <?php if ($mgpcar_desc_show) : ?>
                    <p><?php
                        if (has_excerpt()) {
                            echo esc_html(wp_trim_words(get_the_excerpt(), $mgpcar_crop_desc, '...'));
                        } else {
                            echo esc_html(wp_trim_words(get_the_content(), $mgpcar_crop_desc, '...'));
                        }
                        ?></p>
                <?php endif; ?>


                <?php
                if ($mgpcar_post_btn) {
                    mp_post_btn(
                        $text = $mgpcar_btn_title,
                        $icon_show = $mgpcar_usebtn_icon,
                        $icon = $settings['mgpcar_btn_icon'],
                        $icon_position = $mgpcar_btn_icon_position,
                        $target = $mgpcar_btn_target,
                        $class = $settings['mgpcar_link_type']
                    );
                }

                if ($mgpcar_post_style == '2') {
                    mpd_posts_meta_author_date($settings['mgpcar_author_show'], $settings['mgpcar_date_show']);
                }

                mpd_post_tags($settings['mgpcar_tag_show']);

                ?>
            </div>

        </div>
<?php
    }
}
