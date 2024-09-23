<?php


class mgpdAdPostsGrid1 extends \Elementor\Widget_Base
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
        return 'mgposts_adgrid1';
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
        return __('Posts Group Grid 1', 'magical-posts-display');
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
        return 'eicon-toggle';
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
        return ['magic', 'post', 'advanced', 'grid', 'list'];
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
            'mgpla_query',
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
            'mgpla_posts_filter',
            [
                'label' => esc_html__('Filter By', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'recent',
                'options' => mp_display_post_filter(),
            ]
        );

        $this->add_control(
            'mgpla_post_id',
            [
                'label' => __('Select posts', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_posts_name(),
                'condition' => [
                    'mgpla_posts_filter' => 'show_byid',
                ]
            ]
        );

        $this->add_control(
            'mgpla_post_ids_manually',
            [
                'label' => __('posts IDs', 'magical-posts-display'),
                'description' => __('Separate IDs with commas', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'mgpla_posts_filter' => 'show_byid_manually',
                ]
            ]
        );

        $this->add_control(
            'mgpla_posts_count',
            [
                'label'   => __('posts Limit', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'mgpla_grid_categories',
            [
                'label' => esc_html__('posts Categories', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_taxonomy_list(),
                'condition' => [
                    'mgpla_posts_filter!' => 'show_byid',
                    'mgpla_post_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'mgpla_custom_order',
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
                    'mgpla_custom_order' => 'yes',
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
                    'mgpla_custom_order' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpla_bigp_content',
            [
                'label' => esc_html__('Big Post Settings', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpla_bigpost_show',
            [
                'label'     => __('Show Big Style Post', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpla_bpost_img_show',
            [
                'label'     => __('Show image', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpla_bshow_title',
            [
                'label'     => __('Show Title', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpla_bcrop_title',
            [
                'label'   => __('Crop Title By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 5,
                'condition' => [
                    'mgpla_bshow_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpla_btitle_tag',
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
                    'mgpla_bshow_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpla_bdesc_show',
            [
                'label'     => __('Show posts Description', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'

            ]
        );
        $this->add_control(
            'mgpla_bcrop_desc',
            [
                'label'   => __('Crop Description By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 40,
                'condition' => [
                    'mgpla_bdesc_show' => 'yes',
                ]

            ]
        );

        $this->add_responsive_control(
            'mgpla_bcontent_align',
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
                    '{{WRAPPER}} .mgladp1-hone figcaption' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpla_settings_other',
            [
                'label' => esc_html__('List Layout', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpla_post_style',
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
            'mgpla_post_img_position',
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
            'mgpla_wrap',
            [
                'label' => __('Active No Wrap?', 'magical-posts-display'),
                'description' => __('No Wrap Only work less than 768px layouts', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpla_content',
            [
                'label' => esc_html__('List Posts Settings', 'magical-posts-display'),
            ]
        );


        $this->add_control(
            'mgpla_post_img_show',
            [
                'label'     => __('Show Posts image', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpla_show_title',
            [
                'label'     => __('Show posts Title', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpla_crop_title',
            [
                'label'   => __('Crop Title By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 5,
                'condition' => [
                    'mgpla_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpla_title_tag',
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
                    'mgpla_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpla_desc_show',
            [
                'label'     => __('Show posts Description', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => ''

            ]
        );
        $this->add_control(
            'mgpla_crop_desc',
            [
                'label'   => __('Crop Description By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 10,
                'condition' => [
                    'mgpla_desc_show' => 'yes',
                ]

            ]
        );
        $this->add_responsive_control(
            'mgpla_content_align',
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
        $this->add_responsive_control(
            'mgpla_content_valign',
            [
                'label' => __('vertical Alignment', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Top', 'magical-posts-display'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-posts-display'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => __('Bottom', 'magical-posts-display'),
                        'icon' => 'eicon-v-align-bottom',
                    ],

                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-all .mgpdl-card.no-wrap' => 'align-items: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpla_meta_section',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'default' => '',
            ]
        );
        $this->add_control(
            'mgpla_date_show',
            [
                'label'     => __('Show Date', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpla_category_show',
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
            'mgpla_cat_type',
            [
                'label' => __('Category type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'all' => __('Show all categories', 'magical-posts-display'),
                    'one' => __('Show first category', 'magical-posts-display'),
                ],
                'default' => 'one',
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_control(
            'mgpla_author_show',
            [
                'label'     => __('Show Author', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );

        $this->add_responsive_control(
            'mgpla_meta_align',
            [
                'label' => __('Posts Meta Alignment', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'magical-posts-display'),
                        'icon' => 'eicon-text-align-right',
                    ],

                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-all .mp-meta .row' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        if (empty(mp_display_check_main_ok())) {
            $this->start_controls_section(
                'mgpla_gopro',
                [
                    'label' => esc_html__('Upgrade Pro', 'magical-posts-display'),
                ]
            );
            $this->add_control(
                'mgpla__pro',
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
            'mgpla_style',
            [
                'label' => __('Big Post Image style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'image_bwidth_set',
            [
                'label' => __('Image Width', 'magical-posts-display'),
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
                    '{{WRAPPER}} .mgladp1-hone .mgladp1-img img' => 'width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_bimg_auto_height',
            [
                'label' => __('Image auto height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-posts-display'),
                'label_off' => __('Off', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'mgpla_bimg_height',
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
                    'mgpla_bimg_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mgladp1-img img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_bpost_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mgladp1-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_bpost_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mgladp1-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpla_bimg_border',
                'selector' => '{{WRAPPER}} .mgladp1-hone .mgladp1-img img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpla_bimg_shadow',
                'selector' => '{{WRAPPER}} .mgladp1-hone .mgladp1-img img',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgpla_mtext_bstyle',
            [
                'label' => __('Big Post Main Text', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'mgpla_mtext_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone figcaption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_mtext_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone figcaption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpla_mtext_bbgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone figcaption' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_mtext_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone figcaption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpla_mtext_border',
                'selector' => '{{WRAPPER}} .mgladp1-hone figcaption',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpla_mtext_shadow',
                'selector' => '{{WRAPPER}} .mgladp1-hone figcaption',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgpla_title_bstyle',
            [
                'label' => __('Big Post Title', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpla_title_bpadding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mgp-ptitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_title_bmargin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mgp-ptitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_title_bcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone a.mgp-title-link,{{WRAPPER}} .mgladp1-hone .mgp-ptitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_title_bbgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mgp-ptitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_titleb_bradius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mgp-ptitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpla_title_btypography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgladp1-hone .mgp-ptitle',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpla_description_bstyle',
            [
                'label' => __('Big Post Description', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpla_description_bpadding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd .mgladp1-hone p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_description_bmargin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd .mgladp1-hone p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_description_bcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd .mgladp1-hone p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_description_bbgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd .mgladp1-hone p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_description_bradius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd .mgladp1-hone p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpla_description_btypography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpd .mgladp1-hone p',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgpla_meta_bstyle',
            [
                'label' => __('Big Post Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mgpla_meta_bcat',
            [
                'label' => __('Category style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpla_meta_cat_bmargin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mgladp1 .mp-post-cat a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpla_metacat_bgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgladp1 .mp-post-cat a',
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );
        $this->add_control(
            'mgpla_meta_cat_bcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mgladp1 .mp-post-cat a i,{{WRAPPER}} .mgladp1-hone .mgladp1 .mp-post-cat a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpla_meta_cat_btypography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgladp1-hone .mgladp1 .mp-post-cat a, {{WRAPPER}} .mgladp1-hone .mgladp1 .mp-post-cat',
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_control(
            'mgpla_meta_bauthor',
            [
                'label' => __('Posts Author', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpla_author_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpla_meta_author_bmargin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mp-meta .byline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpla_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpla_meta_author_bcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mp-meta .byline i, {{WRAPPER}} .mp-meta .byline a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpla_author_show' => 'yes',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpla_meta_author_btypography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgladp1-hone .mp-meta .byline a',
                'condition' => [
                    'mgpla_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpla_meta_bdate',
            [
                'label' => __('Date Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpla_date_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_meta_date_bmargin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mgp-time,{{WRAPPER}} .mgladp1-hone .mp-posts-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpla_date_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpla_meta_date_bcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-hone .mgp-time, {{WRAPPER}} .mgladp1-hone .mgp-time i,{{WRAPPER}} .mgladp1-hone .mp-posts-date,{{WRAPPER}} .mgladp1-hone .mp-posts-date i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpla_date_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpla_meta_date_btypography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgladp1-hone .mp-posts-date,{{WRAPPER}} .mgladp1-hone .mgp-time',
                'condition' => [
                    'mgpla_date_show' => 'yes',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpla_mlist_style',
            [
                'label' => __('List Posts Main', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'mgpla_mlist__padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-list.mgladp1-all' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_mlist_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-list.mgladp1-all' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpla_mlist__bbgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-list.mgladp1-all' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_mlist_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-list.mgladp1-all' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpla_mlist_border',
                'selector' => '{{WRAPPER}} .mgpd-list.mgladp1-all',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpla_mlist_shadow',
                'selector' => '{{WRAPPER}} .mgpd-list.mgladp1-all',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpla_img_style',
            [
                'label' => __('List Image style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mgpla_post_img_show' => 'yes',
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
            'mgpla_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-posts-display'),
                'label_off' => __('Off', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'mgpla_img_height',
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
                    'mgpla_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-card figure img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_imgbg_height',
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
                    'mgpla_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-card figure' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpla_img_padding',
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
            'mgpla_img_margin',
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
            'mgpla_img_border_radius',
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
                'name' => 'mgpla_img_bgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mgpdl-card figure img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpla_img_border',
                'selector' => '{{WRAPPER}} .mgpdl-card figure img',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpla_title_style',
            [
                'label' => __('List Posts Title', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpla_title_padding',
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
            'mgpla_title_margin',
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
            'mgpla_title_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item a.mgp-title-link,{{WRAPPER}} .mgpdl-item .mgp-ptitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .mgp-ptitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_descb_radius',
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
                'name' => 'mgpla_title_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpdl-item .mgp-ptitle',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpla_description_style',
            [
                'label' => __('List Description', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpla_description_padding',
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
            'mgpla_description_margin',
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
            'mgpla_description_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .mgpdl-card .mgpdl-text p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdl-item .mgpdl-card .mgpdl-text p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_description_radius',
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
                'name' => 'mgpla_description_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpdl-item .mgpdl-card .mgpdl-text p',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgpla_meta_style',
            [
                'label' => __('List Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mgpla_meta_cat',
            [
                'label' => __('Category style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpla_meta_cat_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-all .mp-post-cat a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],

            ]
        );
        $this->add_responsive_control(
            'mgpla_meta_cat_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-all .mp-post-cat a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_control(
            'mgpla_meta_cat_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-all .mppost-cats.mp-post-cat i,{{WRAPPER}} .mgladp1-all .mppost-cats.mp-post-cat a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpla_meta_cat_bgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgladp1-all .mp-post-cat a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpla_meta_cat_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgladp1-all .mp-post-cat .mgp-post-cats a, {{WRAPPER}} .mgladp1-all .mp-post-cat .mgp-post-cats',
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpla_post_type' => 'post',
                ],
            ]
        );

        $this->add_control(
            'mgpla_meta_author',
            [
                'label' => __('Posts Author', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpla_author_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpla_meta_author_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-all .mp-meta .byline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpla_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpla_meta_author_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-all .mp-meta .byline i, {{WRAPPER}} .mgladp1-all .mp-meta .byline a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpla_author_show' => 'yes',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpla_meta_author_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgladp1-all .mp-meta .byline a',
                'condition' => [
                    'mgpla_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpla_meta_date',
            [
                'label' => __('Date Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpla_date_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_meta_date_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-all .mgp-time,{{WRAPPER}} .mgladp1-all .mp-posts-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpla_date_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpla_meta_date_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgladp1-all .mgp-time, {{WRAPPER}} .mgladp1-all .mgp-time i,{{WRAPPER}} .mgladp1-all .mp-posts-date,{{WRAPPER}} .mgladp1-all .mp-posts-date i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpla_date_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpla_meta_date_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgladp1-all .mp-posts-date,{{WRAPPER}} .mgladp1-all .mgp-time',
                'condition' => [
                    'mgpla_date_show' => 'yes',
                ],
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
        $mgpla_post_type = sanitize_text_field($this->get_settings('mgpla_post_type'));
        $mgpla_posts_count = absint($this->get_settings('mgpla_posts_count'));
        $mgpla_filter = $this->get_settings('mgpla_posts_filter');
        $mgpla_custom_order = $this->get_settings('mgpla_custom_order');
        $mgpla_grid_categories = $this->get_settings('mgpla_grid_categories');
        $orderby = $this->get_settings('orderby');
        $order = $this->get_settings('order');


        // Query Argument
        $args = array(
            'post_type'             => $mgpla_post_type,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $mgpla_posts_count,
        );

        switch ($mgpla_filter) {

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
        if ($mgpla_filter === 'show_byid' && !empty($settings['mgpla_post_id'])) {
            $args['post__in'] = array_map('absint', $settings['mgpla_post_id']);
        } elseif ($mgpla_filter === 'show_byid_manually') {
            $post_ids = array_map('absint', explode(',', $settings['mgpla_post_ids_manually']));
            $args['post__in'] = array_filter($post_ids);
        }

        // Custom Order
        if ($mgpla_custom_order == 'yes') {
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }


        if (!(($mgpla_filter == "show_byid") || ($mgpla_filter == "show_byid_manually"))) {

            $post_cats = str_replace(' ', '', $mgpla_grid_categories);
            if ("0" != $mgpla_grid_categories && $mgpla_post_type == 'post') {
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
        $mgpla_post_style = $this->get_settings('mgpla_post_style');
        // big image
        $mgpla_bigpost_show = $this->get_settings('mgpla_bigpost_show');
        $mgpla_bpost_img_show = $this->get_settings('mgpla_bpost_img_show');
        $mgpla_bshow_title = $this->get_settings('mgpla_bshow_title');
        $mgpla_bcrop_title = $this->get_settings('mgpla_bcrop_title');
        $mgpla_btitle_tag = $this->get_settings('mgpla_btitle_tag');
        $mgpla_bdesc_show = $this->get_settings('mgpla_bdesc_show');
        $mgpla_bcrop_desc = $this->get_settings('mgpla_bcrop_desc');

        // grid content
        $mgpla_post_img_show = $this->get_settings('mgpla_post_img_show');
        $mgpla_show_title = $this->get_settings('mgpla_show_title');
        $mgpla_crop_title = $this->get_settings('mgpla_crop_title');
        $mgpla_title_tag = $this->get_settings('mgpla_title_tag');
        $mgpla_bcrop_title = $this->get_settings('mgpla_bcrop_title');
        $mgpla_btitle_tag = $this->get_settings('mgpla_btitle_tag');
        $mgpla_desc_show = $this->get_settings('mgpla_desc_show');
        $mgpla_crop_desc = $this->get_settings('mgpla_crop_desc');
        $mgpla_category_show = $this->get_settings('mgpla_category_show');
        $mgpla_wrap = $this->get_settings('mgpla_wrap');


        $mgpla_posts = new WP_Query($args);
        $mgpla_count = 0;

        if ($mgpla_posts->have_posts()) :
?>
            <div id="mglp-items" class="mgpd mp-display-list mgpdl style<?php echo esc_attr($mgpla_post_style); ?>">

                <div class="mgpdl-items">
                    <?php
                    while ($mgpla_posts->have_posts()) : $mgpla_posts->the_post();
                        $mgpla_count++;
                        if ($mgpla_count === 1 && $mgpla_bigpost_show == 'yes') :
                    ?>
                            <div class="mgladp1-hone mgladp1-hone-top">
                                <figure class="mgladp1">
                                    <?php if (has_post_thumbnail() && $mgpla_bpost_img_show) : ?>
                                        <div class="mgladp1-img">
                                            <a href="<?php the_permalink(); ?>" target="_self">
                                                <?php the_post_thumbnail();
                                                ?>
                                            </a>

                                            <?php
                                            if ($mgpla_post_type == 'post') {
                                                mp_post_cat_display($mgpla_category_show, $settings['mgpla_cat_type'], ', ', 'mp-post-cat', '');
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    <figcaption>
                                        <?php // Display Title 
                                        mp_post_title($mgpla_bshow_title, $mgpla_btitle_tag, $mgpla_bcrop_title);
                                        ?>
                                        <?php if ($mgpla_bdesc_show) : ?>
                                            <p>
                                                <?php
                                                if (has_excerpt()) {
                                                    echo esc_html(wp_trim_words(get_the_excerpt(), $mgpla_bcrop_desc, '...'));
                                                } else {
                                                    echo esc_html(wp_trim_words(get_the_content(), $mgpla_bcrop_desc, '...'));
                                                }
                                                ?></p>
                                        <?php endif; ?>
                                        <?php
                                        mpd_posts_meta($settings['mgpla_author_show'], $settings['mgpla_date_show']);
                                        ?>
                                    </figcaption>
                                </figure>
                            </div>
                        <?php else : ?>
                            <div class="mgpdl-item mgpd-list mgladp1-all mb-4 <?php if (has_post_thumbnail() && $mgpla_post_img_show) : ?>mgpdl-hasimg<?php endif; ?>">
                                <div class="mgpdl-card <?php if ($mgpla_wrap) : ?>no-wrap<?php endif; ?>">
                                    <?php if (has_post_thumbnail() && $mgpla_post_img_show) : ?>
                                        <div class="mgpdl-img">
                                            <figure>
                                                <a href="<?php the_permalink(); ?>" target="_self">
                                                    <?php the_post_thumbnail(); ?>
                                                </a>
                                            </figure>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body mgpdl-text">
                                        <?php
                                        if ($mgpla_post_type == 'post') {
                                            mp_post_cat_display($mgpla_category_show, $settings['mgpla_cat_type'], ', ', 'mp-post-cat', '');
                                        }
                                        // Display Title 
                                        mp_post_title($mgpla_show_title, $mgpla_title_tag, $mgpla_crop_title);
                                        // display authr and date meta
                                        if ($mgpla_post_style == '1') {
                                            mpd_posts_meta($settings['mgpla_author_show'], $settings['mgpla_date_show']);
                                        }
                                        ?>
                                        <?php if ($mgpla_desc_show) : ?>
                                            <p>
                                                <?php
                                                if (has_excerpt()) {
                                                    echo esc_html(wp_trim_words(get_the_excerpt(), $mgpla_crop_desc, '...'));
                                                } else {
                                                    echo esc_html(wp_trim_words(get_the_content(), $mgpla_crop_desc, '...'));
                                                }
                                                ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php
                                        if ($mgpla_post_style == '2') {
                                            mpd_posts_meta_author_date($settings['mgpla_author_show'], $settings['mgpla_date_show'], 'text-right mpls2');
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                    <?php
                        endif;
                    endwhile;
                    wp_reset_query();
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
<?php else :
            mp_display_posts_not_found($settings['mgpla_post_type']);
        endif;
    }
}
