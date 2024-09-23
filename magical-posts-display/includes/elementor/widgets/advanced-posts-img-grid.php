<?php


class mgpdAdPostsImgGrid extends \Elementor\Widget_Base
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
        return 'mgposts_adimg_grid';
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
        return __('Posts Image Grid', 'magical-posts-display');
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
        return 'eicon-gallery-justified';
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
        if (in_array('magical-posts-display-pro/magical-posts-display-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            return ['mgp-mgposts-pro'];
        } else {
            return ['mgp-mgposts'];
        }
    }

    public function get_keywords()
    {
        return ['magic', 'post', 'advanced', 'grid', 'image'];
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
                    'mgpg_post_type' => 'post',
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
                'label' => esc_html__('Grid Settings', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpla_gpost_style',
            [
                'label'   => __('Grid Style', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => mp_display_imgover_style_list()
            ]
        );
        $this->add_control(
            'mgpla_rownumber',
            [
                'label'   => __('Show Posts Per Row', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '12'   => __('1', 'magical-posts-display'),
                    '6'  => __('2', 'magical-posts-display'),
                    '4'  => __('3', 'magical-posts-display'),
                    '3'  => __('4', 'magical-posts-display'),
                ],
                'condition' => [
                    'mgpla_gpost_style' => '1',
                ]
            ]
        );
        /*
        $this->add_control(
            'mgpla_post_grid_position',
            [
                'label' => __('Grid position', 'magical-posts-display'),
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
                'prefix_class' => 'mgov-img-',
                'style_transfer' => true,
                'condition' => [
                    'mgpla_gpost_style!' => '1',
                ]
            ]

        );*/
        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpla_pset_content',
            [
                'label' => esc_html__('Posts Settings', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpla_pse_title',
            [
                'label'     => __('Show Title', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpla_gcrop_title',
            [
                'label'   => __('Crop Title By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 5,
                'condition' => [
                    'mgpla_pse_title' => 'yes',
                ]


            ]
        );
        $this->add_control(
            'mgpla_gtitle_tag',
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
                    'mgpla_pse_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpla_bdesc_show',
            [
                'label'     => __('Show posts Description', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => ''

            ]
        );
        $this->add_control(
            'mgpla_bcrop_desc',
            [
                'label'   => __('Crop Description By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 10,
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
                    '{{WRAPPER}} .mgomg-plus-gtext' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpla_settings_other',
            [
                'label' => esc_html__('Big Post Settings', 'magical-posts-display'),
                'condition' => [
                    'mgpla_gpost_style!' => '1',
                ]
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
        $this->add_control(
            'mgpla_bshow_title',
            [
                'label'     => __('Show Posts Title', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpla_crop_btitle',
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
                    '{{WRAPPER}} .mgomg-items .mgomg-items1 .mgomg-post-text .mgomg-plus-gtext' => 'text-align: {{VALUE}};',
                ]
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
                'default' => 'flex-end',
                'selectors' => [
                    '{{WRAPPER}} .mgomg-items .mgomg-items1 .mgomg-post-text .mgomg-plus-gtext' => 'align-content: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpla_bmeta_section',
            [
                'label' => __('Big Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'mgpla_gpost_style!' => '1',
                ]
            ]
        );
        $this->add_control(
            'mgpla_bdate_show',
            [
                'label'     => __('Show Date', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpla_bcategory_show',
            [
                'label'     => __('Show Category', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpla_bcat_type',
            [
                'label' => __('Category type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'all' => __('Show all categories', 'magical-posts-display'),
                    'one' => __('Show first category', 'magical-posts-display'),
                ],
                'default' => 'one',
                'condition' => [
                    'mgpla_bcategory_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpla_bauthor_show',
            [
                'label'     => __('Show Author', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );

        $this->add_responsive_control(
            'mgpla_bmeta_align',
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
                    '{{WRAPPER}} .mgomg-pimg.mgomg-items1 .mgomg-post-text .mp-meta .row' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpla_meta_section',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
                    '{{WRAPPER}} .mgomg-pimg .mgomg-post-text .mp-meta .row' => 'justify-content: {{VALUE}};',
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
            'mgpla_cimg_style',
            [
                'label' => __('Post Image style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'image_cwidth_set',
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
                    '{{WRAPPER}} .mgomg-items .mgomg-pimg img' => 'width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_cimg_auto_height',
            [
                'label' => __('Image auto height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-posts-display'),
                'label_off' => __('Off', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'mgpla_cimg_height',
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
                    'mgpla_cimg_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgomg-items .mgomg-pimg img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_cimg_divheight',
            [
                'label' => __('Image Div Height', 'magical-posts-display'),
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
                    'mgpla_cimg_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgomg-items .mgomg-pimg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_cpost_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgomg-pimg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_cpost_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgomg-pimg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpla_cimg_bg',
                'label' => esc_html__('Image Background', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgomg-items .mgomg-pimg',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpla_cimg_border',
                'selector' => '{{WRAPPER}} .mgomg-items .mgomg-pimg img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpla_cimg_shadow',
                'selector' => '{{WRAPPER}} .mgomg-items .mgomg-pimg img',
            ]
        );
        $this->end_controls_section();
        //big image style
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
                    '{{WRAPPER}} .mgomg-items .mgomg-pimg.mgomg-items1 img' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};',

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
                    '{{WRAPPER}} .mgomg-items .mgomg-pimg.mgomg-items1 img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_bimg_divheight',
            [
                'label' => __('Image Div Height', 'magical-posts-display'),
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
                    '{{WRAPPER}} .mgomg-items .mgomg-pimg.mgomg-items1' => 'height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgomg-pimg.mgomg-items1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgomg-pimg.mgomg-items1' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpla_bimg_bg',
                'label' => esc_html__('Image Background', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgomg-items .mgomg-pimg.mgomg-items1',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpla_bimg_border',
                'selector' => '{{WRAPPER}} .mgomg-items .mgomg-pimg.mgomg-items1 img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpla_bimg_shadow',
                'selector' => '{{WRAPPER}} .mgomg-items .mgomg-pimg.mgomg-items1 img',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpla_mtext_bstyle',
            [
                'label' => __('Post Main Text', 'magical-posts-display'),
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
                    '{{WRAPPER}} .mgomg-plus-gtext' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgomg-plus-gtext' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpla_mtext_bbgcolor',
                'label' => esc_html__('Text Background', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgomg-plus-gtext',
            ]
        );

        $this->add_control(
            'mgpla_mtext_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgomg-plus-gtext' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpla_mtext_border',
                'selector' => '{{WRAPPER}} .mgomg-plus-gtext',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpla_mtext_shadow',
                'selector' => '{{WRAPPER}} .mgomg-plus-gtext',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgpla_title_bstyle',
            [
                'label' => __('Post Title', 'magical-posts-display'),
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
                    '{{WRAPPER}} .mgomg-items .mgp-ptitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgomg-items .mgp-ptitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_title_bcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgomg-items a.mpp-title-link,{{WRAPPER}} .mgomg-items .mgp-ptitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_title_bbgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgomg-items .mgp-ptitle' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .mgomg-items .mgp-ptitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpla_title_btypography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgomg-items .mgp-ptitle',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpla_description_bstyle',
            [
                'label' => __('Post Description', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mgpla_bdesc_show' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'mgpla_description_bpadding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgomg-items .mgomg-plus-gtext p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgomg-items .mgomg-plus-gtext p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_description_bcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgomg-items .mgomg-plus-gtext p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpla_description_bbgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgomg-items .mgomg-plus-gtext p' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .mgomg-items .mgomg-plus-gtext p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpla_description_btypography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgomg-items .mgomg-plus-gtext p',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgpla_meta_bstyle',
            [
                'label' => __('Post Meta', 'magical-posts-display'),
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
                    'mgpg_post_type' => 'post',
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
                    '{{WRAPPER}} .mgomg-items .mp-post-cat a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpg_post_type' => 'post',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpla_meta_cat_bpadding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgomg-items .mp-post-cat a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpg_post_type' => 'post',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpla_metacat_bgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgomg-post-text .mp-post-cat a',
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpg_post_type' => 'post',
                ],
            ]
        );
        $this->add_control(
            'mgpla_meta_cat_bcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgomg-items .mp-post-cat a i,{{WRAPPER}} .mgomg-items .mp-post-cat a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpg_post_type' => 'post',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpla_meta_cat_btypography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgomg-items .mp-post-cat a, {{WRAPPER}} .mgomg-items .mgladp1 .mp-post-cat',
                'condition' => [
                    'mgpla_category_show' => 'yes',
                    'mgpg_post_type' => 'post',
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
                    '{{WRAPPER}} .mgomg-items .mp-meta .byline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgomg-items .mp-meta .byline i, {{WRAPPER}} .mp-meta .byline a' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .mgomg-items .mp-meta .byline a',
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
                    '{{WRAPPER}} .mgomg-items .mgp-time,{{WRAPPER}} .mgomg-items .mp-posts-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .mgomg-items .mgp-time, {{WRAPPER}} .mgomg-items .mgp-time i,{{WRAPPER}} .mgomg-items .mp-posts-date,{{WRAPPER}} .mgomg-items .mp-posts-date i' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .mgomg-items .mp-posts-date,{{WRAPPER}} .mgomg-items .mgp-time',
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

        $mgpg_post_type = isset($settings['mgpg_post_type']) ? $settings['mgpg_post_type'] : 'post';
        $mgpg_post_type = sanitize_text_field($mgpg_post_type);

        $mgpla_filter = $this->get_settings('mgpla_posts_filter');
        $mgpla_posts_count = absint($this->get_settings('mgpla_posts_count'));

        $mgpla_custom_order = $this->get_settings('mgpla_custom_order');
        $mgpla_grid_categories = $this->get_settings('mgpla_grid_categories');
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
            'post_type'             => $mgpg_post_type,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $mgpla_posts_count,
        );
        if ($mgpg_pagination_show) {
            $args['paged'] = $paged;
        }

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
            if ("0" != $mgpla_grid_categories && $mgpg_post_type == 'post') {
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
        $mgpla_gpost_style = $this->get_settings('mgpla_gpost_style');

        $mgpla_posts = new WP_Query($args);
        $mgpla_count = 0;

        if ($mgpla_posts->have_posts()) :
?>
            <div id="mgomg-items" class="mgomg">

                <div class="mgomg-items mgomg-style<?php echo esc_attr($mgpla_gpost_style); ?> ">
                    <?php if ($mgpla_gpost_style == 1) : ?>
                        <div class="row" data-masonry='{"percentPosition": true }'>
                        <?php endif; ?>
                        <?php
                        while ($mgpla_posts->have_posts()) : $mgpla_posts->the_post();
                            $mgpla_count++;
                            $settings['mgpla_count'] = $mgpla_count;
                            if ($mgpla_gpost_style == 1) {
                                $this->free_image_posts($settings);
                            } elseif ($mgpla_gpost_style == 2 || $mgpla_gpost_style == 3) {
                                if (mp_display_author_namet() == 'wptheme space pro') {
                                    $this->mgover_pro_image_posts($settings);
                                } else {
                                    do_action('mgpdad_Posts_img', $settings);
                                }
                            }
                        endwhile;
                        wp_reset_query();
                        wp_reset_postdata();
                        ?>
                        <?php if ($mgpla_gpost_style == 1) : ?> </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php
            if ($mgpg_pagination_show) {
                mp_display_pagination($paged, $mgpla_posts, $settings['mgpg_pagination_style']);
            }
            ?>
        <?php else :
            mp_display_posts_not_found($settings['mgpg_post_type']);
        endif;
    }


    public function free_image_posts($settings)
    {
        if ($settings['mgpla_rownumber'] == '12') {
            $column_set = 'col-lg-12';
        } else {
            $column_set = 'col-lg-' . $settings['mgpla_rownumber'] . ' col-md-6';
        }
        $mgpg_post_type = !empty($settings['mgpg_post_type']) ? $settings['mgpg_post_type'] : 'post';

        ?>
        <div class="<?php echo esc_attr($column_set); ?> bsgrid-item mb-4">
            <div class="mgomg-pimg">
                <?php
                if (has_post_thumbnail()) :
                    the_post_thumbnail();
                else :
                ?>
                    <div class="mgomg-in-noimg">
                        <div class="mgomg-in-square"></div>
                        <div class="mgomg-in-circle"></div>
                    </div>
                <?php endif; ?>
                <div class="mgomg-post-text">
                    <div class="mgomg-plus-gtext">
                        <?php
                        if ($mgpg_post_type == 'post') {
                            mp_post_cat_display($settings['mgpla_category_show'], $settings['mgpla_cat_type'], ', ', 'mp-post-cat', '');
                        }
                        // Display Title 
                        mp_post_title($settings['mgpla_pse_title'], $settings['mgpla_gtitle_tag'], $settings['mgpla_gcrop_title']);

                        if ($settings['mgpla_bdesc_show']) :
                        ?>
                            <p>
                                <?php
                                if (has_excerpt()) {
                                    echo esc_html(wp_trim_words(get_the_excerpt(), $settings['mgpla_bcrop_desc'], '...'));
                                } else {
                                    echo esc_html(wp_trim_words(get_the_content(), $settings['mgpla_bcrop_desc'], '...'));
                                }
                                ?></p>
                        <?php endif; ?>

                        <div class="entry-meta-over">
                            <?php
                            mpd_posts_meta_author_date($settings['mgpla_author_show'], $settings['mgpla_date_show'], 'text-left');
                            ?>
                        </div><!-- .entry-meta -->
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    function mgover_pro_image_posts($settings)
    {
        if ($settings['mgpla_count'] == 1) {
            $mgpla_wrap = $settings['mgpla_wrap'];
            $mgpla_category_show = $settings['mgpla_bcategory_show'];
            $mgpla_cat_type = $settings['mgpla_bcat_type'];
            $mgpla_pse_title = $settings['mgpla_bshow_title'];
            $mgpla_gtitle_tag = $settings['mgpla_btitle_tag'];
            $mgpla_gcrop_title = $settings['mgpla_crop_btitle'];
            $mgpla_bdesc_show = $settings['mgpla_desc_show'];
            $mgpla_bcrop_desc = $settings['mgpla_crop_desc'];
            $mgpla_author_show = $settings['mgpla_bauthor_show'];
            $mgpla_date_show = $settings['mgpla_bdate_show'];
        } else {
            $mgpla_wrap = 'no';
            $mgpla_category_show = $settings['mgpla_category_show'];
            $mgpla_cat_type = $settings['mgpla_cat_type'];
            $mgpla_pse_title = $settings['mgpla_pse_title'];
            $mgpla_gtitle_tag = $settings['mgpla_gtitle_tag'];
            $mgpla_gcrop_title = $settings['mgpla_gcrop_title'];
            $mgpla_bdesc_show = $settings['mgpla_bdesc_show'];
            $mgpla_bcrop_desc = $settings['mgpla_bcrop_desc'];
            $mgpla_author_show = $settings['mgpla_author_show'];
            $mgpla_date_show = $settings['mgpla_date_show'];
        }
        $mgpg_post_type = !empty($settings['mgpg_post_type']) ? $settings['mgpg_post_type'] : 'post';


    ?>
        <div class="mgomg-pimg mgomg-items<?php echo esc_attr($settings['mgpla_count']); ?> mgpl-nowrap-<?php echo esc_attr(esc_attr($mgpla_wrap)); ?>">
            <?php
            if (has_post_thumbnail()) :
                the_post_thumbnail();
            else :
            ?>
                <div class="mgomg-in-noimg">
                    <div class="mgomg-in-square"></div>
                    <div class="mgomg-in-circle"></div>
                </div>
            <?php endif; ?>
            <div class="mgomg-post-text">
                <div class="mgomg-plus-gtext">
                    <?php
                    if ($mgpg_post_type == 'post') {
                        mp_post_cat_display($mgpla_category_show, $mgpla_cat_type, '  ', 'mp-post-cat', '');
                    }
                    // Display Title 
                    mp_post_title($mgpla_pse_title, $mgpla_gtitle_tag, $mgpla_gcrop_title);

                    if ($mgpla_bdesc_show) :
                    ?>
                        <p>
                            <?php
                            if (has_excerpt()) {
                                echo esc_attr(wp_trim_words(get_the_excerpt(), $mgpla_bcrop_desc, '...'));
                            } else {
                                echo esc_attr(wp_trim_words(get_the_content(), $mgpla_bcrop_desc, '...'));
                            }
                            ?></p>
                    <?php endif; ?>
                    <div class="entry-meta-over">
                        <?php
                        mpd_posts_meta_author_date($mgpla_author_show, $mgpla_date_show, 'text-left');
                        ?>
                    </div><!-- .entry-meta -->
                </div>
            </div>
        </div>

<?php
    }
}
