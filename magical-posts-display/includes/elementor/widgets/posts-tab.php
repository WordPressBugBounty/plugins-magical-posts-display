<?php


class mgpdEPostsTab extends \Elementor\Widget_Base
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
        return 'mgposts_tab';
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
        return __('Magical Posts Tabs', 'magical-posts-display');
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
        return 'eicon-tabs';
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
        return ['magic', 'post', 'category', 'grid', 'tab'];
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
            'mapt_cats_section',
            [
                'label' => esc_html__('Select Posts Categories', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mapt_cats',
            [
                'label' => __('Select Posts Categories', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_taxonomy_list(),

            ]
        );
        $this->add_control(
            'mapt_posts_count',
            [
                'label'   => __('Posts Limit', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'step'    => 1,
            ]
        );
        $this->add_control(
            'mapt_column',
            [
                'label'   => __('Grid Column', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '12'   => __('1 Column', 'magical-posts-display'),
                    '6'  => __('2 Column', 'magical-posts-display'),
                    '4'  => __('3 Column', 'magical-posts-display'),
                    '3'  => __('4 Column', 'magical-posts-display'),
                    '2'  => __('6 Column', 'magical-posts-display'),

                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mapt_options_section',
            [
                'label' => esc_html__('Tab Options', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mapt_type',
            [
                'label' => esc_html__('Type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'magical-posts-display'),
                    'vertical' => esc_html__('Vertical', 'magical-posts-display'),
                ],
            ]
        );

        $this->add_control(
            'mapt_style',
            [
                'label' => esc_html__('Tabs Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '2',
                'options' => [
                    '1' => esc_html__('Style One', 'magical-posts-display'),
                    '2' => esc_html__('Style Two', 'magical-posts-display'),
                    '3' => esc_html__('Style Three', 'magical-posts-display'),
                    '4' => esc_html__('Style Four', 'magical-posts-display'),
                ],
            ]
        );
        $this->add_control(
            'mapt_animation',
            [
                'label' => esc_html__('Tabs Animation', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'slideUp',
                'options' => [
                    'none' => esc_html__('None', 'magical-posts-display'),
                    'fade' => esc_html__('Fade', 'magical-posts-display'),
                    'slideDown' => esc_html__('Slide Down', 'magical-posts-display'),
                    'slideUp' => esc_html__('Slide Up', 'magical-posts-display'),
                    'slideRight' => esc_html__('Slide Right', 'magical-posts-display'),
                    'slideLeft' => esc_html__('Slide Left', 'magical-posts-display'),
                ],
            ]
        );
        $this->add_control(
            'mapt_full_width',
            [
                'label' => esc_html__('Full Width Nav', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => esc_html__('Show', 'magical-posts-display'),
                'label_off' => esc_html__('Hide', 'magical-posts-display'),
                'condition' => [
                    'mapt_type' => 'horizontal',
                ],
            ]
        );

        $this->add_responsive_control(
            'mapt_nav_align',
            [
                'label' => esc_html__('Nav Alignment', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-right',
                    ],

                ],
                'default' => 'left',
                'condition' => [
                    'mapt_full_width!' => 1,
                ],


            ]
        );
        /*
		$this->add_control(
			'mapt_icon_show',
			[
				'label' => esc_html__( 'Show Icon?', 'magical-posts-display' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'magical-posts-display' ),
				'label_off' => esc_html__( 'No', 'magical-posts-display' ),
				'default' => '',
			]
		);
        $this->add_control(
			'mapt_selected_icon',
			[
				'label' => esc_html__( 'Select Icon', 'magical-posts-display' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'separator' => 'before',
				'default' => [
					'value' => 'icon-mp-plus',
					'library' => 'fa-solid',
				],
				'condition' => [
					'mapt_icon_show' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'mapt_icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'magical-posts-display' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'magical-posts-display' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'magical-posts-display' ),
						'icon' => 'eicon-h-align-right',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'magical-posts-display' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'magical-posts-display' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'left',
				'toggle' => false,
				'label_block' => false,
				'condition' => [
					'mapt_icon_show' => 'yes',
				],
				
			]
		);
	*/
        $this->end_controls_section();

        // posts Content
        $this->start_controls_section(
            'mapt_layout',
            [
                'label' => esc_html__('Grid Layout', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mapt_post_style',
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

        $this->end_controls_section();

        $this->start_controls_section(
            'mapt_content',
            [
                'label' => esc_html__('Content Settings', 'magical-posts-display'),
            ]
        );


        $this->add_control(
            'mapt_post_img_show',
            [
                'label'     => __('Show Posts image', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mapt_img_size',
            [
                'label' => esc_html__('Image Size', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'medium_large',
                'options' => [
                    'thumbnail'  => esc_html__('Thumbnail (150px x 150px max)', 'magical-posts-display'),
                    'medium'   => esc_html__('Medium (300px x 300px max)', 'magical-posts-display'),
                    'medium_large'   => esc_html__('Medium Large (768px x 0px max)', 'magical-posts-display'),
                    'large'   => esc_html__('Large (1024px x 1024px max)', 'magical-posts-display'),
                    'full'   => esc_html__('Full Size (Original image size)', 'magical-posts-display'),
                ],
                'condition' => [
                    'mapt_post_img_show' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mapt_show_title',
            [
                'label'     => __('Show posts Title', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mapt_crop_title',
            [
                'label'   => __('Crop Title By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 5,
                'condition' => [
                    'mapt_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mapt_title_tag',
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
                    'mapt_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mapt_desc_show',
            [
                'label'     => __('Show posts Description', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'

            ]
        );
        $this->add_control(
            'mapt_crop_desc',
            [
                'label'   => __('Crop Description By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 20,
                'condition' => [
                    'mapt_desc_show' => 'yes',
                ]

            ]
        );

        $this->add_responsive_control(
            'mapt_content_align',
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
            'mapt_meta_section',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'default' => '',
            ]
        );
        $this->add_control(
            'mapt_category_show',
            [
                'label'     => __('Show Category', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mapt_cat_type',
            [
                'label' => __('Category type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'all' => __('Show all categories', 'magical-posts-display'),
                    'one' => __('Show first category', 'magical-posts-display'),
                ],
                'default' => 'one',
                'condition' => [
                    'mapt_category_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mapt_date_show',
            [
                'label'     => __('Show Date', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mapt_author_show',
            [
                'label'     => __('Show Author', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mapt_comment_icon_show',
            [
                'label'     => __('Show Comment Icon', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mapt_tag_show',
            [
                'label'     => __('Show Tags', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',

            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'mapt_button',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mapt_post_btn',
            [
                'label' => __('Use post link?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mapt_link_type',
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
            'mapt_btn_title',
            [
                'label'       => __('Link Title', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Read More', 'magical-posts-display'),
                'default'     => __('Read More', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mapt_btn_target',
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
            'mapt_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => '',
            ]
        );

        $this->add_control(
            'mapt_btn_icon',
            [
                'label' => __('Choose Icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mapt_usebtn_icon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mapt_btn_icon_position',
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
                    'mapt_usebtn_icon' => 'yes',
                ],

            ]
        );
        $this->add_responsive_control(
            'mapt_cardbtn_iconspace',
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
                    'mapt_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-card .mp-post-btn i.left,{{WRAPPER}} .mg-card .mp-post-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-card .mp-post-btn i.right, {{WRAPPER}} .mg-card .mp-post-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
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
            'mapt_navwrapper_section',
            [
                'label' => esc_html__('Nav Wrapper', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mapt_nav_wrapper_bg',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mpt-tabs ul.nav.nav-tabs,{{WRAPPER}} .mpt-tab-vertical .vertical-tab',
            ]
        );
        $this->add_responsive_control(
            'mapt_nav_wrapper_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpt-tabs .mpdtab-nav-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mapt_nav_wrapper_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpt-tabs ul.nav.nav-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mapt_nav_wrapper_border',
                'selector' => '{{WRAPPER}} .mpt-tabs.mpt-tab-horizontal ul.nav.nav-tabs,{{WRAPPER}} .mpt-tab-vertical .vertical-tab',
            ]
        );

        $this->add_responsive_control(
            'mapt_navwrapper_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpt-tabs.mpt-tab-horizontal ul.nav.nav-tabs,{{WRAPPER}} .mpt-tab-vertical .vertical-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mapt_navwrapper_box_shadow',
                'label' => esc_html__('Box Shadow', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mpt-tabs.mpt-tab-horizontal ul.nav.nav-tabs,{{WRAPPER}} .mpt-tab-vertical .vertical-tab',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mapt_navitems_style',
            [
                'label'     => esc_html__('Nav Items', 'magical-posts-display'),
                'tab'     => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'         => 'mapt_tabitems_typography',
                'selector'     => '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a',
            ]
        );
        $this->add_responsive_control(
            'mapt_tabitems_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mapt_tabitems_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'mapt_navitems_style_tabs'
        );
        $this->start_controls_tab(
            'mapt_nav_items_normal_tab',
            [
                'label' => esc_html__('Normal', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mapt_nav_items_normal_textcolor',
            [
                'label'         => esc_html__('Text Color', 'magical-posts-display'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a' => 'color: {{VALUE}};',

                ],
            ]
        );
        /*
        $this->add_control(
            'mapt_nav_items_normal_iconcolor', [
                'label'		 =>esc_html__( 'Icon Color', 'magical-posts-display' ),
                'type'		 => \Elementor\Controls_Manager::COLOR,
                'selectors'	 => [
                    '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a span i' => 'color: {{VALUE}};',
                ],
                'condition' => [
					'mapt_icon_show' => 'yes',
				],
            ]
        );
*/
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mapt_nav_items_normal_bg',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a,{{WRAPPER}} .mpdtabs-style4 .nav-tabs li a.active:after',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mapt_nav_items_normal_border',
                'label' => esc_html__('Border', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a',
            ]
        );

        $this->add_control(
            'mapt_nav_items_normal_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mapt_nav_items_normal_bshadow',
                'label' => esc_html__('Box Shadow', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mapt_navitems_style_active_tab',
            [
                'label' => esc_html__('Active', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mapt_nav_items_active_textcolor',
            [
                'label'         => esc_html__('Text Color', 'magical-posts-display'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a.active' => 'color: {{VALUE}};',

                ],
            ]
        );
        /*
        $this->add_control(
            'mapt_nav_items_active_iconcolor', [
                'label'		 =>esc_html__( 'Icon Color', 'magical-posts-display' ),
                'type'		 => \Elementor\Controls_Manager::COLOR,
                'selectors'	 => [
                    '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a.active span i' => 'color: {{VALUE}};',
                ],
                'condition' => [
					'mapt_icon_show' => 'yes',
				],
            ]
        );
*/
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mapt_nav_items_active_bg',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a.active, {{WRAPPER}} .mpdtabs-style1 .nav-tabs li a.active:after',
            ]
        );
        $this->add_control(
            'mapt_nav_items_active_arrowcolor',
            [
                'label'         => esc_html__('Extra Arrow Color', 'magical-posts-display'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mpdtabs-style2 .nav-tabs li a.active, {{WRAPPER}} .mpdtabs-style2 .nav-tabs li a.active:hover' => 'border-top-color: {{VALUE}};',
                    '{{WRAPPER}}  .mpdtabs-style1 .nav-tabs li a:after' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}}  .mpdtabs-style3 .nav-tabs li a.active:after' => 'border-top-color: {{VALUE}};',
                ],


            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mapt_nav_items_active_border',
                'label' => esc_html__('Border', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a.active',
            ]
        );

        $this->add_control(
            'mapt_nav_items_active_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mapt_nav_items_active_bshadow',
                'label' => esc_html__('Box Shadow', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mpt-tabs ul.nav-tabs li a.active',
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        //Tab body style
        $this->start_controls_section(
            'mapt_tabbody_section',
            [
                'label' => esc_html__('Tab Body Style', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mapt_tabbody_bg',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mpt-tab-horizontal .tab-content.mpdtab-content,{{WRAPPER}} .vertical-content',
            ]
        );
        $this->add_responsive_control(
            'mapt_tabbody_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tab-content.mpdtab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mapt_tabbody_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tab-content.mpdtab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mapt_tabbody_border',
                'selector' => '{{WRAPPER}} .mpt-tab-horizontal .tab-content.mpdtab-content,{{WRAPPER}} .vertical-content',
            ]
        );

        $this->add_responsive_control(
            'mapt_tabbody_bradius',
            [
                'label' => esc_html__('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpt-tab-horizontal .tab-content.mpdtab-content,{{WRAPPER}} .vertical-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mapt_tabbody_box_shadow',
                'label' => esc_html__('Box Shadow', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mpt-tab-horizontal .tab-content.mpdtab-content,{{WRAPPER}} .vertical-content',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mapt_grid_style',
            [
                'label' => __('Grid style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mapt_grid_height',
            [
                'label' => __('Grid Height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                        'step' => 1,
                    ]
                ],

                'selectors' => [
                    '{{WRAPPER}} .mpdtab-content .mgp-card' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mapt_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdtab-content .mgp-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mapt_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdtab-content .mgp-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mapt_bg_color',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .mpdtab-content .mgp-card',
            ]
        );

        $this->add_control(
            'mapt_border_radius',
            [
                'label' => __('Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpdtab-content .mgp-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mapt_content_border',
                'selector' => '{{WRAPPER}} .mpdtab-content .mgp-card',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mapt_content_shadow',
                'selector' => '{{WRAPPER}} .mpdtab-content .mgp-card',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mapt_img_style',
            [
                'label' => __('Image style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mapt_post_img_show' => 'yes',
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
                    '{{WRAPPER}} .mgp-card .mp-post-img figure img' => 'flex: 0 0 {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );

        $this->add_responsive_control(
            'mapt_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-posts-display'),
                'label_off' => __('Off', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'mapt_img_height',
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
                    'mapt_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mp-post-img figure img' => 'height: {{SIZE}}{{UNIT}};min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mapt_imgbg_height',
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
                    'size' => 250,
                ],
                'condition' => [
                    'mapt_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mp-post-img figure' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mapt_img_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mp-post-img figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mapt_img_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mp-post-img figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mapt_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mp-post-img figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mapt_img_bgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mgp-card .mp-post-img figure img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mapt_img_border',
                'selector' => '{{WRAPPER}} .mgp-card .mp-post-img figure img',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mapt_title_style',
            [
                'label' => __('posts Title', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mapt_title_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mapt_title_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mapt_title_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mgp-title-link,{{WRAPPER}} .mgp-card .mgp-ptitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mapt_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mapt_descb_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mapt_title_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgp-card .mgp-ptitle',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mapt_description_style',
            [
                'label' => __('Description', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mapt_description_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.card-body p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mapt_description_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.card-body p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mapt_description_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.card-body p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mapt_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.card-body p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mapt_description_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.card-body p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mapt_description_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgp-card .mg-card-text.card-body p',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mapt_meta_style',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mapt_meta_cat',
            [
                'label' => __('Category style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mapt_category_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mapt_meta_cat_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-cats' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mapt_category_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mapt_meta_cat_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-cats, {{WRAPPER}} .mgp-post-cats a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mapt_category_show' => 'yes',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mapt_meta_cat_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgp-post-cats, {{WRAPPER}} .mgp-post-cats a',
                'condition' => [
                    'mapt_category_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mapt_meta_author',
            [
                'label' => __('Posts Author', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mapt_author_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mapt_meta_author_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mapt_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mapt_meta_author_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline i, {{WRAPPER}} .mp-meta .byline a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mapt_author_show' => 'yes',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mapt_meta_author_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-meta .byline a',
                'condition' => [
                    'mapt_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mapt_meta_date',
            [
                'label' => __('Date Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mapt_date_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mapt_meta_date_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-time,{{WRAPPER}} .mp-posts-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mapt_date_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mapt_meta_date_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-time, {{WRAPPER}} .mgp-time i,{{WRAPPER}} .mp-posts-date,{{WRAPPER}} .mp-posts-date i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mapt_date_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mapt_meta_date_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-posts-date,{{WRAPPER}} .mgp-time',
                'condition' => [
                    'mapt_date_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mapt_meta_tag',
            [
                'label' => __('Tags style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mapt_tag_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mapt_meta_tag_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mapt_tag_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mapt_meta_tag_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links a, {{WRAPPER}} .mpg-tags-links i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mapt_tag_show' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mapt_meta_tag_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mpg-tags-links a',
                'condition' => [
                    'mapt_date_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mapt_meta_comment',
            [
                'label' => __('Comment Icon style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mapt_comment_icon_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mapt_meta_comment_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .single-comments-link a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mapt_comment_icon_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mapt_meta_comment_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .single-comments-link a,{{WRAPPER}} .mp-meta .single-comments-link a i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mapt_comment_icon_show' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mapt_meta_comment_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-meta .single-comments-link a',
                'condition' => [
                    'mapt_comment_icon_show' => 'yes',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mapt_btn_style',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mapt_btn_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'mapt_btn_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mapt_btn_typography',
                'selector' => '{{WRAPPER}} .mgp-card a.mp-post-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mapt_btn_border',
                'selector' => '{{WRAPPER}} .mgp-card a.mp-post-btn',
            ]
        );

        $this->add_control(
            'mapt_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mapt_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mgp-card a.mp-post-btn',
            ]
        );
        $this->add_control(
            'mapt_button_color',
            [
                'label' => __('Button color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('mapt_btn_tabs');

        $this->start_controls_tab(
            'mapt_btn_normal_style',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mapt_btn_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mapt_btn_bg_color',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgp-card a.mp-post-btn',
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mapt_btn_hover_style',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mapt_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} .mgp-card a.mp-post-btn:hover',
            ]
        );

        $this->add_control(
            'mapt_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn:hover, {{WRAPPER}} .mgp-card a.mp-post-btn:focus' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mapt_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn:hover, {{WRAPPER}} .mgp-card a.mp-post-btn:focus' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mapt_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mapt_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn:hover, {{WRAPPER}} .mgp-card a.mp-post-btn:focus' => 'border-color: {{VALUE}} !important;',
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
            'mapt_attr_sec',
            [
                'label' => __('Magical Attributes', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $this->add_control(
            'mapt_attr_calss',
            [
                'label' => __('Custom Class', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'mapt_attr_id',
            [
                'label' => __('Custom ID', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mapt_custom_css_sec',
            [
                'label' => __('Magical Custom CSS', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );
        $this->add_control(
            'mapt_custom_css',
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
        $mapt_cats = $this->get_settings('mapt_cats');
        $mapt_post_img_show = $this->get_settings('mapt_post_img_show');
        $mapt_column    = $settings['mapt_column'];
        $mapt_posts_count    = absint($settings['mapt_posts_count']);
        $mapt_post_style   = $settings['mapt_post_style'];
        $mapt_show_title   = $settings['mapt_show_title'];
        $mapt_title_tag   = $settings['mapt_title_tag'];
        $mapt_crop_title   = $settings['mapt_crop_title'];
        $mapt_crop_desc   = $settings['mapt_crop_desc'];
        $mapt_desc_show   = $settings['mapt_desc_show'];

?>


        <?php
        $mapt_rand = wp_rand(253195, 56914658);

        if ($mapt_cats) :
        ?>

            <div class="mpt-tabs mpt-shadow mpdtabs-style<?php echo esc_attr($settings['mapt_style']); ?> mpt-tab-<?php echo esc_attr($settings['mapt_type']); ?>">

                <?php
                // if( $settings['mapt_type'] == 'horizontal'):
                ?>

                <!-- Horijontal tab start -->
                <?php if ($settings['mapt_type'] == 'vertical') : ?>
                    <div class="row">
                        <div class="col-md-3 vertical-tab">
                            <!-- Horijontal tab end -->
                        <?php endif; ?>


                        <div class="mpdtab-nav-wrap bsknav-<?php if ($settings['mapt_full_width'] == 'yes') : ?>full<?php else : ?>fit navalign-<?php echo esc_attr($settings['mapt_nav_align']); ?><?php endif; ?>">
                            <ul class="nav nav-tabs <?php if ($settings['mapt_full_width'] == 'yes' && $settings['mapt_type'] == 'horizontal') : ?>nav-justified<?php endif; ?>" id="myTab" role="tablist">

                                <?php
                                foreach ($mapt_cats as $index => $cats_id) :
                                    //	$cat_info = get_term_by('id', $cats_id, 'post');
                                    $cat_info = get_the_category_by_ID($cats_id);
                                    if ($index == 0) {
                                        $bsklink_class = 'nav-link active';
                                    } else {
                                        $bsklink_class = 'nav-link';
                                    }
                                    $term_name = empty($cat_info) ? __('Select Category', 'magical-posts-display') : $cat_info;

                                ?>

                                    <li class="nav-item" role="presentation">
                                        <a class="<?php echo esc_attr($bsklink_class); ?>" id="tab-<?php echo esc_attr($mapt_rand . $index); ?>" data-bs-toggle="tab" data-bs-target="#mapt_<?php echo esc_attr($mapt_rand . $index); ?>" href="#" role="tab" aria-controls="mapt_<?php echo esc_attr($mapt_rand . $index); ?>" aria-selected="<?php if ($index == 0) : ?>true<?php else : ?>false<?php endif; ?>">
                                            <?php /* if($settings['mapt_icon_show'] == 'yes' && ($settings['mapt_icon_position'] == 'left' || $settings['mapt_icon_position'] == 'top')  ): ?>
    	 <span class="mpdtabs-icon-<?php echo esc_attr( $settings['mapt_icon_position']); ?>">
    			    <?php \Elementor\Icons_Manager::render_icon( $settings['mapt_selected_icon'] ); ?>
    			</span> 
	<?php endif; */ ?>
                                            <span><?php echo esc_html($term_name); ?></span>
                                            <?php /* if($settings['mapt_icon_show'] == 'yes' && ($settings['mapt_icon_position'] == 'right' || $settings['mapt_icon_position'] == 'bottom') ): ?>
    	 <span class="mpdtabs-icon-<?php echo esc_attr( $settings['mapt_icon_position']); ?>">
    		<?php \Elementor\Icons_Manager::render_icon( $settings['mapt_selected_icon'] ); ?>
    	</span>
		<?php endif; */ ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>


                        <!-- Horijontal tab start -->
                        <?php if ($settings['mapt_type'] == 'vertical') : ?>
                        </div>
                        <div class="col-md-9 vertical-content">
                            <!-- Horijontal tab end -->
                        <?php endif; ?>
                        <?php $mgp_unque_num = wp_rand('8652397', '5832471'); ?>
                        <div class="tab-content mpdtab-content">
                            <?php if ($settings['mapt_custom_css']) : ?>
                                <style>
                                    <?php echo esc_html($settings['mapt_custom_css']); ?>
                                </style>
                            <?php endif; ?>
                            <?php
                            foreach ($mapt_cats as $index => $cats_id) :
                                $pcat_obj = get_term_by('id', $cats_id, 'category');
                                $pcat_slug = empty($pcat_obj->slug) ? null : $pcat_obj->slug;
                            ?>
                                <div id="mapt_<?php echo esc_attr($mapt_rand . $index); ?>" class="tab-pane fade in <?php if ($index == 0) : ?>show active<?php endif; ?>" role="tabpanel" aria-labelledby="home-tab">
                                    <div <?php if ($settings['mapt_attr_id']) : ?> id="<?php echo esc_attr($settings['mapt_attr_id']); ?>" <?php endif; ?> class="mgp-unique<?php echo esc_attr($mgp_unque_num); ?> mgpostd mgpde-items style<?php echo esc_attr($mapt_post_style); ?> mgpostd-grid <?php echo esc_attr($settings['mapt_attr_calss']); ?>">

                                        <div class="row">


                                            <?php
                                            $args = array(
                                                'post_type'             => 'post',
                                                'post_status'           => 'publish',
                                                'ignore_sticky_posts'   => 1,
                                                'posts_per_page'        => $mapt_posts_count,
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => 'category',
                                                        'field'    => 'slug',
                                                        'terms'    => $pcat_slug,
                                                    ),
                                                ),
                                            );

                                            $mgpteb_item_posts = new WP_Query($args);
                                            if ($mgpteb_item_posts->have_posts()) :
                                                while ($mgpteb_item_posts->have_posts()) : $mgpteb_item_posts->the_post();
                                            ?>
                                                    <div class="col-lg-<?php echo esc_attr($mapt_column); ?>">
                                                        <div class="card mg-card mg-shadow mgp-card mb-4">
                                                            <?php mp_post_thumbnail($mapt_post_img_show, $settings['mapt_img_size']); ?>
                                                            <div class="mg-card-text card-body">
                                                                <?php
                                                                mp_post_cat_display($settings['mapt_category_show'], $settings['mapt_cat_type'], ', ');
                                                                ?>

                                                                <?php
                                                                mp_post_title($mapt_show_title, $mapt_title_tag, $mapt_crop_title);
                                                                ?>
                                                                <?php
                                                                if ($mapt_post_style == '1') {
                                                                    mpd_posts_meta($settings['mapt_author_show'], $settings['mapt_date_show'], $settings['mapt_comment_icon_show']);
                                                                }
                                                                ?>
                                                                <?php if ($mapt_desc_show) : ?>
                                                                    <p><?php
                                                                        if (has_excerpt()) {
                                                                            echo esc_html(wp_trim_words(get_the_excerpt(), $settings['mapt_crop_desc'], ''));
                                                                        } else {
                                                                            echo esc_html(wp_trim_words(get_the_content(), $settings['mapt_crop_desc'], ''));
                                                                        }
                                                                        ?>
                                                                    </p>
                                                                <?php endif; ?>


                                                                <?php
                                                                $mapt_post_btn =  $settings['mapt_post_btn'];
                                                                $mapt_btn_title =  $settings['mapt_btn_title'];
                                                                $mapt_usebtn_icon =  $settings['mapt_usebtn_icon'];
                                                                $mapt_btn_icon_position =  $settings['mapt_btn_icon_position'];
                                                                $mapt_btn_target =  $settings['mapt_btn_target'];
                                                                if ($mapt_post_btn) {
                                                                    mp_post_btn(
                                                                        $text = $mapt_btn_title,
                                                                        $icon_show = $mapt_usebtn_icon,
                                                                        $icon = $settings['mapt_btn_icon'],
                                                                        $icon_position = $mapt_btn_icon_position,
                                                                        $target = $mapt_btn_target,
                                                                        $class = $settings['mapt_link_type']
                                                                    );
                                                                }

                                                                if ($mapt_post_style == '2') {
                                                                    mpd_posts_meta_author_date($settings['mapt_author_show'], $settings['mapt_date_show']);
                                                                }

                                                                mpd_post_tags($settings['mapt_tag_show']);

                                                                ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php
                                                endwhile;
                                                wp_reset_query();
                                                wp_reset_postdata();
                                                ?>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>


                            <?php endforeach; ?>

                        </div>

                        <!-- Horijontal tab start -->
                        <?php if ($settings['mapt_type'] == 'vertical') : ?>
                        </div>
                    </div>
                    <!-- Horijontal tab end -->
                <?php endif; ?>



            </div>
        <?php else : ?>
            <div class="alert alert-danger text-center">
                <?php echo esc_html('Please select posts categories for display the Tab.'); ?>
            </div>
        <?php endif; //Check tab item 
        ?>

<?php
    }
}
