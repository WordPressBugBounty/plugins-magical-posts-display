<?php


class mgpdEPostsAccordion extends \Elementor\Widget_Base
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
        return 'mgposts_accordion';
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
        return esc_html__('Magical Posts Accordion', 'magical-posts-display');
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
        return 'eicon-accordion';
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
        return ['accordion', 'toggle', 'posts', 'magic', 'tab'];
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
            'mpac_item_section',
            [
                'label' => esc_html__('Accordion posts', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'mpac_post_id',
            [
                'label' => __('Select post', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                // 'multiple' => false,
                'options' => mp_display_posts_name(),

            ]
        );
        $repeater->add_control(
            'mpac_is_open',
            [
                'label' => esc_html__('Keep this slide open? ', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => esc_html__('Yes', 'magical-posts-display'),
                'label_off' => esc_html__('No', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mpac_items',
            [
                'label' => esc_html__('Content', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'separator' => 'before',
                'title_field' => get_the_title('{{ mpac_post_id }}'),
                'fields' => $repeater->get_controls(),
                'dynamic' => [
                    'active' => true,
                ],/*
                'default' => [
                    [
                        'mpac_title' => ' Magical Addons For Elementor Accordion Title ',
                        'mpac_content' => 'Lorem ispam dummy text, you can edit or remove it. far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast',
                        'mpac_is_open'    => 'yes'
                    ],
                    [
                        'mpac_title' => ' Magical Addons For Elementor Accordion Title',
                        'mpac_content' => 'Lorem ispam dummy text, you can edit or remove it. far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast',
                    ],
                    [
                        'mpac_title' => 'Magical Addons For Elementor Accordion Title',
                        'mpac_content' => 'Lorem ispam dummy text, you can edit or remove it. far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast',
                    ],
                ],*/
            ]
        );
        /*$this->add_control(
            'mpac_open_first_slide',
            [
                'label' => esc_html__( 'Keep first slide auto open?', 'magical-posts-display' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'magical-posts-display' ),
                'label_off' => esc_html__( 'No', 'magical-posts-display' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );*/
        $this->end_controls_section();
        $this->start_controls_section(
            'mpac_accdion_design',
            [
                'label' => esc_html__('Accordion Design', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mpac_style',
            [
                'label' => esc_html__('Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'accoedion-primary',
                'options' => [
                    'accoedion-primary' => esc_html__('Primary', 'magical-posts-display'),
                    'curve-shape' => esc_html__('Curve Shape', 'magical-posts-display'),
                    'side-curve' => esc_html__('Side Curve', 'magical-posts-display'),
                    'box-icon' => esc_html__('Box Icon', 'magical-posts-display'),
                ],
            ]
        );
        $this->add_control(
            'mpac_effect',
            [
                'label' => esc_html__('Animation Effect', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'effect3',
                'options' => [
                    'none' => esc_html__('No Effect', 'magical-posts-display'),
                    'effect1' => esc_html__('Effect One', 'magical-posts-display'),
                    'effect2' => esc_html__('Effect Two', 'magical-posts-display'),
                    'effect3' => esc_html__('Effect Three', 'magical-posts-display'),
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mpac_accdion_content',
            [
                'label' => esc_html__('Accordion Content', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mpac_show_img',
            [
                'label'     => __('Show post Image', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mpac_img_size',
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
                    'mpac_show_img' => 'yes',
                ]


            ]
        );

        $this->add_control(
            'mpac_crop_title',
            [
                'label'   => __('Crop Title By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 8,

            ]
        );
        $this->add_control(
            'mpac_title_tag',
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
                'default' => 'h2',


            ]
        );
        $this->add_responsive_control(
            'mpac_text_align',
            [
                'label' => esc_html__('Header Alignment', 'magical-posts-display'),
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

            ]
        );
        $this->add_control(
            'mpac_desc_show',
            [
                'label'     => __('Show posts Description', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'

            ]
        );
        $this->add_control(
            'mpac_crop_desc',
            [
                'label'   => __('Crop Description By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 20,
                'condition' => [
                    'mpac_desc_show' => 'yes',
                ]

            ]
        );

        $this->add_responsive_control(
            'mpac_content_align',
            [
                'label' => esc_html__('Content Alignment', 'magical-posts-display'),
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
                'selectors' => [
                    '{{WRAPPER}} .mpdac-post-details' => 'text-align: {{VALUE}};',
                ],

            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mpac_icon_section',
            [
                'label' => esc_html__('Accordion Icon', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mpac_icon_show',
            [
                'label' => esc_html__('Show Icon?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'magical-posts-display'),
                'label_off' => esc_html__('No', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mpac_selected_icon',
            [
                'label' => esc_html__('Icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'separator' => 'before',
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'plus',
                        'plus-square',
                        'angle-double-down',
                        'angle-double-up',
                        'angle-double-right',
                        'angle-double-left',
                        'angle-double-left',
                        'angle-down',
                        'angle-up',
                        'angle-left',
                        'angle-right',
                        'arrow-circle-down',
                        'arrow-circle-up',
                        'arrow-circle-left',
                        'arrow-circle-right',
                        'arrow-down',
                        'arrow-up',
                        'arrow-left',
                        'arrow-right',
                        'caret-down',
                        'caret-up',
                        'caret-left',
                        'caret-right',
                    ],
                    'fa-regular' => [
                        'plus-square',
                        'plus-circle',
                        'arrow-alt-circle-down',
                        'arrow-alt-circle-up',
                        'arrow-alt-circle-left',
                        'arrow-alt-circle-right',
                    ],
                ],
                'condition' => [
                    'mpac_icon_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mpac_selected_active_icon',
            [
                'label' => esc_html__('Active Icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-minus',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'plus',
                        'plus-square',
                        'angle-double-down',
                        'angle-double-up',
                        'angle-double-right',
                        'angle-double-left',
                        'angle-double-left',
                        'angle-down',
                        'angle-up',
                        'angle-left',
                        'angle-right',
                        'arrow-circle-down',
                        'arrow-circle-up',
                        'arrow-circle-left',
                        'arrow-circle-right',
                        'arrow-down',
                        'arrow-up',
                        'arrow-left',
                        'arrow-right',
                        'caret-down',
                        'caret-up',
                        'caret-left',
                        'caret-right',
                    ],
                    'fa-regular' => [
                        'plus-square',
                        'plus-circle',
                        'arrow-alt-circle-down',
                        'arrow-alt-circle-up',
                        'arrow-alt-circle-left',
                        'arrow-alt-circle-right',
                    ],
                ],
                'condition' => [
                    'mpac_icon_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mpac_icon_position',
            [
                'label' => esc_html__('Icon Position', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'magical-posts-display'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'magical-posts-display'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'right',
                'toggle' => false,
                'label_block' => false,
                'condition' => [
                    'mpac_icon_show' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mpac_meta_section',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'default' => '',
            ]
        );
        $this->add_control(
            'mpac_category_show',
            [
                'label'     => __('Show Category', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mpac_cat_type',
            [
                'label' => __('Category type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'all' => __('Show all categories', 'magical-posts-display'),
                    'one' => __('Show first category', 'magical-posts-display'),
                ],
                'default' => 'one',
                'condition' => [
                    'mpac_category_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mpac_date_show',
            [
                'label'     => __('Show Date', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mpac_author_show',
            [
                'label'     => __('Show Author', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );

        $this->add_control(
            'mpac_tag_show',
            [
                'label'     => __('Show Tags', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',

            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mpac_button',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mpac_post_btn',
            [
                'label' => __('Use post link?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mpac_link_type',
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
            'mpac_btn_title',
            [
                'label'       => __('Link Title', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Read More', 'magical-posts-display'),
                'default'     => __('Read More', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mpac_btn_target',
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
            'mpac_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => '',
            ]
        );

        $this->add_control(
            'mpac_btn_icon',
            [
                'label' => __('Choose Icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mpac_usebtn_icon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mpac_btn_icon_position',
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
                    'mpac_usebtn_icon' => 'yes',
                ],

            ]
        );
        $this->add_responsive_control(
            'mpac_cardbtn_iconspace',
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
                    'mpac_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mpacc-btn .mp-post-btn i.left,{{WRAPPER}} .mpacc-btn .mp-post-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mpacc-btn .mp-post-btn i.right, {{WRAPPER}} .mpacc-btn .mp-post-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
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
     * Register Accordion widget style ontrols.
     *
     * Adds different input fields in the style tab to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_style_controls()
    {


        $this->start_controls_section(
            'mpac_style_section',
            [
                'label' => esc_html__('Accordion Style', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mpac_border_main',
                'selector' => '{{WRAPPER}} .accordion.mgaccordion',
            ]
        );
        $this->add_control(
            'mpac_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .accordion.mgaccordion' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mpac_accordion_shadow',
                'selector' => '{{WRAPPER}} .accordion.mgaccordion',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mpac_accordion_bg',
                'label' => esc_html__('Accordion body Background', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .accordion.mgaccordion .mgac-content',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mpac_title_style',
            [
                'label'     => esc_html__('Accordion Title Style', 'magical-posts-display'),
                'tab'     => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'         => 'mpac_title_typography',
                'selector'     => '{{WRAPPER}} .mgrc-title h2',
            ]
        );
        $this->add_control(
            'mpac_usebg_color',
            [
                'label' => esc_html__('Hide default gradient? ', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => esc_html__('Yes', 'magical-posts-display'),
                'label_off' => esc_html__('No', 'magical-posts-display'),
            ]
        );
        $this->start_controls_tabs(
            'mpac_accordion_style_tabs'
        );
        $this->start_controls_tab(
            'mpac_open_tab',
            [
                'label' => esc_html__('Open', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mpac_title_color_open',
            [
                'label'         => esc_html__('Color', 'magical-posts-display'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mgrc-title h2' => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mpac_title_background_open',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mpac_title_border_open',
                'label' => esc_html__('Border', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title',
            ]
        );

        $this->add_control(
            'mpac_title_border_radius_open',
            [
                'label' => esc_html__('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mpac_box_shadow_open',
                'label' => esc_html__('Box Shadow', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mpac_style_close_tab',
            [
                'label' => esc_html__('Closed', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mpac_title_color_close',
            [
                'label'         => esc_html__('Color', 'magical-posts-display'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mgrc-title.collapsed h2' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mpac_background_close',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title.collapsed',

            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mpac_title_border_close',
                'label' => esc_html__('Border', 'magical-posts-display'),
                'condition' => [
                    'mpac_style!' => ['curve-shape']
                ],
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title.collapsed',
            ]
        );
        $this->add_control(
            'mpac_border_radious_close',
            [
                'label' => esc_html__('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title.collapsed' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mpac_box_shadow_close',
                'label' => esc_html__('Box Shadow', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title.collapsed',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'mpac_title_divide',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_responsive_control(
            'mpac_title_padding',
            [
                'label' => esc_html__('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->add_responsive_control(
            'mpac_title_margin_bottom',
            [
                'label'             => esc_html__('Margin Bottom', 'magical-posts-display'),
                'type'             => \Elementor\Controls_Manager::SLIDER,
                'default'         => [
                    'size' => '',
                ],
                'range'             => [
                    'px' => [
                        'min'     => -30,
                        'step'     => 1,
                    ],
                ],
                'size_units'     => ['px'],
                'selectors'         => [
                    '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_cubestyle_bg_color',
            [
                'label' => __('cubestyle Background', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-side-curve .mgrc-title:before' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'mpac_style' => 'side-curve',
                ],

            ]
        );


        $this->end_controls_section();
        //Icon Style Section
        $this->start_controls_section(
            'mpac_section_icon_style',
            [
                'label'     => esc_html__('Title Icon Style', 'magical-posts-display'),
                'tab'     => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mpac_icon_move_heading',
            [
                'type' => \Elementor\Controls_Manager::HEADING,
                'label' => esc_html__('Move icon', 'magical-posts-display'),
                'separator' => 'before'
            ]
        );
        $this->start_controls_tabs(
            'mpac_tabs_icon_move'
        );
        $this->start_controls_tab(
            'mpac_icon_move_left_right',
            [
                'label' => esc_html__('Left & Right', 'magical-posts-display'),
            ]
        );
        $this->add_responsive_control(
            'mpac_icon_move_left_right_value',
            [
                'label' => esc_html__('Left & Right', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -10,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgc-icons.mgc-right-icon' => 'right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgc-icons.mgc-left-icon' => 'left: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'mpac_icon_move_topbottom',
            [
                'label' => esc_html__('Top & Bottom', 'magical-posts-display'),
            ]
        );
        $this->add_responsive_control(
            'mpac_icon_move_topbottom_value',
            [
                'label' => esc_html__('Top & Bottom', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgc-icons.mgc-left-icon, {{WRAPPER}} .mgc-icons.mgc-right-icon' => 'top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->end_controls_tab();


        $this->end_controls_tabs();


        $this->start_controls_tabs(
            'mpac_style_tabs_icon'
        );
        $this->start_controls_tab(
            'mpac_icon_open_tab',
            [
                'label' => esc_html__('Slide Closed Icon', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mpac_icon_color_close',
            [
                'label'         => esc_html__('Color', 'magical-posts-display'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mgrc-title.collapsed .mgc-icon i' => 'color: {{VALUE}};',

                ],
            ]
        );


        $this->add_responsive_control(
            'mpac_icon_typography_close',
            [
                'label' => esc_html__('Size', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgrc-title.collapsed .mgc-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->start_controls_tab(
            'mpac_icon_close_tab',
            [
                'label' => esc_html__(' Slide Open icon', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mpac_icon_color',
            [
                'label'         => esc_html__('Color', 'magical-posts-display'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mgrc-title .mgc-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgrc-title .mgc-icon svg' => 'fill: {{VALUE}};',

                ],
            ]
        );

        $this->add_responsive_control(
            'mpac_icon_typography',
            [
                'label' => esc_html__('Size', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgrc-title .mgc-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgrc-title .mgc-icon svg' => 'width: {{SIZE}}{{UNIT}};',

                ]
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->start_controls_section(
            'mpac_img_style',
            [
                'label' => __('Image style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'mpac_image_width',
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
                    '{{WRAPPER}} .mgac-content .mpdac-post-image img' => 'width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );

        $this->add_control(
            'mpac_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-posts-display'),
                'label_off' => __('Off', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mpac_img_height',
            [
                'label' => __('Image Height', 'magical-posts-display'),
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
                    'mpac_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgac-content .mpdac-post-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mpac_imgbg_height',
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
                    'mpac_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgac-content .mpdac-post-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mpac_img_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgac-content .mpdac-post-image figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mpac_img_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgac-content .mpdac-post-image figure img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mpac_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgac-content .mpdac-post-image figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mpac_img_bgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mgac-content .mpdac-post-image figure img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mpac_img_border',
                'selector' => '{{WRAPPER}} .mgac-content .mpdac-post-image figure img',
            ]
        );
        $this->end_controls_section();
        //accordion content style 
        $this->start_controls_section(
            'mpac_section_content_style',
            [
                'label'     => esc_html__('posts Content', 'magical-posts-display'),
                'tab'     => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mpac_content_color',
            [
                'label'         => esc_html__('Color', 'magical-posts-display'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mgac-content .mpdac-post-details' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'         => 'mpac_content_typography',
                'selector'     => '{{WRAPPER}} .mgac-content .mpdac-post-details',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mpac_content_background',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mgac-content .mpdac-post-details',
            ]
        );

        $this->add_control(
            'mpac_content_border_radious',
            [
                'label' => esc_html__('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mgac-content .mpdac-post-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mpac_content_padding',
            [
                'label' => esc_html__('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mgac-content .mpdac-post-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mpac_content_width',
            [
                'label' => esc_html__('Width', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgac-content .mpdac-post-details' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_section();
        //meta style
        $this->start_controls_section(
            'mpac_meta_style',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mpac_meta_cat',
            [
                'label' => __('Category style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mpac_category_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mpac_meta_cat_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mppost-cats' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mpac_category_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mpac_meta_cat_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mppost-cats, {{WRAPPER}} .mppost-cats a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mpac_category_show' => 'yes',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mpac_meta_cat_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mppost-cats, {{WRAPPER}} .mppost-cats a',
                'condition' => [
                    'mpac_category_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mpac_meta_author',
            [
                'label' => __('Posts Author', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mpac_author_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mpac_meta_author_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mpac_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mpac_meta_author_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline i, {{WRAPPER}} .mp-meta .byline a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mpac_author_show' => 'yes',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mpac_meta_author_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-meta .byline a',
                'condition' => [
                    'mpac_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mpac_meta_date',
            [
                'label' => __('Date Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mpac_date_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mpac_meta_date_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-time,{{WRAPPER}} .mp-posts-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mpac_date_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mpac_meta_date_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-time, {{WRAPPER}} .mgp-time i,{{WRAPPER}} .mp-posts-date,{{WRAPPER}} .mp-posts-date i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mpac_date_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mpac_meta_date_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-posts-date,{{WRAPPER}} .mgp-time',
                'condition' => [
                    'mpac_date_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mpac_meta_tag',
            [
                'label' => __('Tags style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mpac_tag_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mpac_meta_tag_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mpac_tag_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mpac_meta_tag_color',
            [
                'label' => __('tag Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links a, {{WRAPPER}} .mpg-tags-links i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mpac_tag_show' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mpac_meta_tag_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mpg-tags-links a',
                'condition' => [
                    'mpac_date_show' => 'yes',
                ],
            ]
        );


        $this->end_controls_section();
        //Button Style
        $this->start_controls_section(
            'mpac_btn_style',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mpac_btn_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpacc-btn a.mp-post-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mpac_btn_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpacc-btn a.mp-post-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mpac_btn_typography',
                'selector' => '{{WRAPPER}} .mpacc-btn a.added_to_cart',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mpac_btn_border',
                'selector' => '{{WRAPPER}} .mpacc-btn a.added_to_cart,{{WRAPPER}} .mpacc-btn a.mp-post-btn',
            ]
        );

        $this->add_control(
            'mpac_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpacc-btn a.mp-post-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mpac_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mpacc-btn a.mp-post-btn',
            ]
        );
        $this->add_control(
            'mpac_button_color',
            [
                'label' => __('Button color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('infobox_btn_tabs');

        $this->start_controls_tab(
            'mpac_btn_normal_style',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mpac_btn_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mpacc-btn a.mp-post-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mpac_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpacc-btn a.mp-post-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mpac_btn_hover_style',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mpac_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} .mpacc-btn a.mp-post-btn:hover',
            ]
        );

        $this->add_control(
            'mpac_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpacc-btn a.mp-post-btn:hover, {{WRAPPER}} .mpacc-btn a.mp-post-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mpac_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpacc-btn a.mp-post-btn:hover, {{WRAPPER}} .mpacc-btn a.mp-post-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mpac_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mpac_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mpacc-btn a.mp-post-btn:hover, {{WRAPPER}} .mpacc-btn a.mp-post-btn:focus' => 'border-color: {{VALUE}};',
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
        $mpac_items = $this->get_settings('mpac_items');
        $mpac_post_btn = $this->get_settings('mpac_post_btn');
        $mpac_category_show = $this->get_settings('mpac_category_show');
        $mpac_usebtn_icon = $this->get_settings('mpac_usebtn_icon');
        $mpac_btn_title = $this->get_settings('mpac_btn_title');
        $mpac_btn_target = $this->get_settings('mpac_btn_target');
        $mpac_btn_icon = $this->get_settings('mpac_btn_icon');
        $mpac_btn_icon_position = $this->get_settings('mpac_btn_icon_position');
?>


        <?php
        $mpac_rand = wp_rand(253495, 56934658);

        if ($settings['mpac_usebg_color'] == 'yes') {
            $mpac_excolor = 'excolor';
        } else {
            $mpac_excolor = 'eacolor';
        }
        ?>

        <div class="accordion mgaccordion mg-<?php echo esc_attr($settings['mpac_style']); ?> <?php echo esc_attr($mpac_excolor); ?>" id="mpdAccordion<?php echo esc_attr($mpac_rand); ?>">

            <?php if ($mpac_items) : ?>
                <?php
                foreach ($mpac_items as $index => $item) :

                    if ($item['mpac_post_id']) :
                        $mpac_post_id = absint($item['mpac_post_id']);
                        $args = array(
                            'post_type' => 'post',
                            'p'         =>  $mpac_post_id,
                            'post_status'       =>  'publish',
                        );
                        $mpac_loop = new WP_Query($args);
                        while ($mpac_loop->have_posts()) :  $mpac_loop->the_post();
                ?>
                            <div class="card mgrc-item mgrc-item-<?php echo esc_attr($settings['mpac_text_align']); ?>-<?php echo esc_attr($settings['mpac_icon_position']); ?> text-<?php echo esc_attr($settings['mpac_text_align']); ?>">
                                <div class="card-header mg-accordion-title" id="heading<?php echo esc_attr($index); ?><?php echo esc_attr($mpac_rand); ?>">
                                    <div class="mgrc-title <?php if ($item['mpac_is_open'] != 'yes') : ?>collapsed<?php endif; ?> <?php if ($settings['mpac_icon_position'] == 'left') : ?>mgrc-left<?php endif; ?>" data-bs-toggle="collapse" data-bs-target="#mgc-item<?php echo esc_attr($index); ?><?php echo esc_attr($mpac_rand); ?>" aria-expanded="<?php if ($item['mpac_is_open'] == 'yes') : ?>true<?php else : ?>false<?php endif; ?>" aria-controls="mgc-item<?php echo esc_attr($index); ?><?php echo esc_attr($mpac_rand); ?>">
                                        <?php if ($settings['mpac_icon_position'] == 'left' && $settings['mpac_icon_show'] == 'yes') : ?>
                                            <div class="mgc-icons mgc-left-icon">
                                                <div class="mgc-icon mgc-icon-top">
                                                    <span class="mgc-close"><?php \Elementor\Icons_Manager::render_icon($settings['mpac_selected_icon']); ?></span>

                                                </div>
                                                <div class="mgc-icon">
                                                    <span class="mgc-open"><?php \Elementor\Icons_Manager::render_icon($settings['mpac_selected_active_icon']); ?></span>

                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                        // Ensure the title tag is properly escaped to prevent any invalid HTML tags or XSS attacks
                                        echo '<' . tag_escape($settings['mpac_title_tag']) . '>';

                                        // Trim the post title to the specified number of words and escape it for safe output
                                        echo esc_html(wp_trim_words(get_the_title(), $settings['mpac_crop_title'], '...'));

                                        // Close the title tag with the escaped tag name
                                        echo '</' . tag_escape($settings['mpac_title_tag']) . '>';
                                        ?>

                                        <?php if ($settings['mpac_icon_position'] == 'right' && $settings['mpac_icon_show'] == 'yes') : ?>
                                            <div class="mgc-icons mgc-right-icon">
                                                <div class="mgc-icon mgc-icon-top">
                                                    <span class="mgc-close"><?php \Elementor\Icons_Manager::render_icon($settings['mpac_selected_icon']); ?></span>

                                                </div>
                                                <div class="mgc-icon">
                                                    <span class="mgc-open"><?php \Elementor\Icons_Manager::render_icon($settings['mpac_selected_active_icon']); ?></span>

                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                </div>

                                <div id="mgc-item<?php echo esc_attr($index); ?><?php echo esc_attr($mpac_rand); ?>" class="collapse mgac-mcontent mgaccont <?php if ($item['mpac_is_open'] == 'yes') : ?>show<?php endif; ?>" aria-labelledby="heading<?php echo esc_attr($index); ?><?php echo esc_attr($mpac_rand); ?>" data-bs-parent="#mpdAccordion<?php echo esc_attr($mpac_rand); ?>">
                                    <div class="card-body mgac-content mgac-<?php echo esc_attr($settings['mpac_effect']); ?>">

                                        <div class="row">
                                            <?php if ($settings['mpac_show_img']) : ?>
                                                <div class="col-lg-5">
                                                    <div class="mpdac-post-image">
                                                        <figure>
                                                            <a href="<?php the_permalink(); ?>">
                                                                <?php the_post_thumbnail($settings['mpac_img_size']); ?>
                                                            </a>
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                <?php else : ?>
                                                    <div class="col-lg-12">
                                                    <?php endif; ?>
                                                    <div class="mpdac-post-details">
                                                        <?php mp_post_cat_display($mpac_category_show, $settings['mpac_cat_type'], ', '); ?>
                                                        <?php
                                                        if ($settings['mpac_desc_show']) {
                                                            if (has_excerpt()) {
                                                                echo esc_html(wp_trim_words(get_the_excerpt(), $settings['mpac_crop_desc'], '...'));
                                                            } else {
                                                                echo esc_html(wp_trim_words(get_the_content(), $settings['mpac_crop_desc'], '...'));
                                                            }
                                                        }

                                                        ?>
                                                        <div class="mpacc-btn">
                                                            <?php
                                                            if ($mpac_post_btn) {
                                                                mp_post_btn(
                                                                    $text = $mpac_btn_title,
                                                                    $icon_show = $mpac_usebtn_icon,
                                                                    $icon = $mpac_btn_icon,
                                                                    $icon_position = $mpac_btn_icon_position,
                                                                    $target = $mpac_btn_target,
                                                                    $class = $settings['mpac_link_type']
                                                                );
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="mpacc-meta">
                                                            <?php mpd_posts_meta_author_date($settings['mpac_author_show'], $settings['mpac_date_show']);  ?>
                                                        </div>

                                                        <?php mpd_post_tags($settings['mpac_tag_show']); ?>

                                                    </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>
                        <?php else : ?>
                            <div class="alert alert-warning text-center mt-5 mb-5" role="alert">
                                <?php echo esc_html('No posts found. Please add posts for display the accordion.', 'magical-posts-display'); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="alert alert-danger text-center mt-5 mb-5" role="alert">
                        <?php echo esc_html('No posts found. Please add posts for display the accordion.', 'magical-posts-display'); ?>
                    </div>
                <?php endif; ?>
                            </div>

                    <?php
                }
            }
