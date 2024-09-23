<?php


class mgpdEPosts_cats extends \Elementor\Widget_Base
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
        return 'mgp_post_cat';
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
        return __('Magical Posts Categories', 'magical-posts-display');
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
        return 'eicon-column';
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
        return ['magic', 'post', 'grid', 'card', 'category'];
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
            'mgpds_cats',
            [
                'label' => esc_html__('Posts Categories', 'magical-posts-display'),
            ]
        );
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'mgpd_cats',
            [
                'label' => __('Select Post Category', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => false,
                'options' => mp_display_catslug_list(),
            ]
        );

        $repeater->add_control(
            'mgpc_cat_img',
            [
                'label' => __('Choose Default Image', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                /* 'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ], */
            ]
        );

        $repeater->add_control(
            'mgpc_badge_use',
            [
                'label' => __('Use Card Badge?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => '',
            ]
        );
        $repeater->add_control(
            'badge_text',
            [
                'label'       => __('Badge Text', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Badge Text', 'magical-posts-display'),
                'default'     => __('Badge', 'magical-posts-display'),
                'condition' => [
                    'mgpc_badge_use' => 'yes',
                ],
            ]
        );
        $repeater->add_control(
            'badge_position',
            [
                'label' => __('Badge Position', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left-top' => [
                        'title' => __('Left Top', 'magical-posts-display'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'left-bottom' => [
                        'title' => __('Left Bottom', 'magical-posts-display'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right-top' => [
                        'title' => __('Right Top', 'magical-posts-display'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'right-bottom' => [
                        'title' => __('Right Bottom', 'magical-posts-display'),
                        'icon' => 'eicon-h-align-right',
                    ],

                ],
                'default' => 'right-bottom',

            ]
        );

        $this->add_control(
            'cat_list',
            [
                'label' => esc_html__('Category List', 'textdomain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                /* 'default' => [
                    [
                        'list_title' => esc_html__('Title #1', 'textdomain'),
                        'list_content' => esc_html__('Item content. Click the edit button to change this text.', 'textdomain'),
                    ],
                    [
                        'list_title' => esc_html__('Title #2', 'textdomain'),
                        'list_content' => esc_html__('Item content. Click the edit button to change this text.', 'textdomain'),
                    ],
                ],
                'title_field' => '{{{ list_title }}}', */
            ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
            'mgpds_cats_grid',
            [
                'label' => esc_html__('Posts Categories Grid', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpd_cats_column',
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
        $this->add_control(
            'mgpd_cats_style',
            [
                'label'   => __('Style', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1'   => __('Style One', 'magical-posts-display'),
                    'style2'  => __('Style Two', 'magical-posts-display'),
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgpc_catdimg',
            [
                'label' => __('Default Categories Image', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'mgpc_catimg_show',
            [
                'label' => __('Show Categories Images?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'yes' => __('Yes', 'magical-posts-display'),
                'no' => __('No', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgpc_default_img',
            [
                'label' => __('Choose Default Image', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'medium_large',
                'separator' => 'none',
                'exclude' => [
                    'full',
                    'custom',
                    'large',
                    'shop_catalog',
                    'shop_single',
                    'shop_thumbnail'
                ],

            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgpc_cat_content',
            [
                'label' => __('Content', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgpc_desc_info',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('You need to add category description by posts category edit.', 'magical-posts-display'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]
        );
        $this->add_control(
            'mgpc_catdes_show',
            [
                'label'     => __('Show Categories Description', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'

            ]
        );
        $this->add_control(
            'mgpc_catdes_crop',
            [
                'label'   => __('Crop Description By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 10,
                'condition' => [
                    'mgpc_catdes_show' => 'yes',
                ]

            ]
        );

        $this->add_responsive_control(
            'text_align',
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-item' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
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
            'mgpc_cat_basic_style',
            [
                'label' => __('Basic Style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpc_cat_grid_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpc_cat_grid_margin',
            [
                'label' => __('Content Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpc_cat_grid_bg_color',
            [
                'label' => __('Card Background color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpc_cat_grid_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpc_cat_grid_border',
                'selector' => '{{WRAPPER}} .mgpckit-cat-item',
            ]
        );
        $this->add_control(
            'content_grid_boxshadow',
            [
                'label' => __('Use Box shadow?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'yes' => __('Yes', 'magical-addons-for-elementor'),
                'no' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpc_grid_boxshadow',
                'selector' => '{{WRAPPER}} .mgpckit-shadow',
                'condition' => [
                    'content_grid_boxshadow' => 'yes',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpc_cat_content_style',
            [
                'label' => __('Content style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpc_cat_content_padding',
            [
                'label' => __('Content Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-info.p-3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpc_cat_content_margin',
            [
                'label' => __('Content Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgpc_cat_img_style',
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
                'size_units' => ['px', '%'],
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
                    '{{WRAPPER}} .mgpckit-cat-img figure img' => 'width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );

        $this->add_control(
            'mgpc_cat_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-posts-display'),
                'label_off' => __('Off', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpc_cat_img_height',
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
                    'mgpc_cat_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-img figure img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpc_cat_img_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-img figure' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpc_cat_img_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-img figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpc_cat_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-img figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            'mgpc_cat_imgbg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpc_cat_img_border',
                'selector' => '{{WRAPPER}} .mgpckit-cat-img figure img',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpc_cat_title_style',
            [
                'label' => __('Category Title', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpc_cat_title_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-info h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpc_cat_title_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-info h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpc_cat_title_bg',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpckit-cat-info h2 a,{{WRAPPER}} .mgpckit-cat-info h2',
            ]
        );
        $this->add_control(
            'mgpc_cat_title_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-info h2 a,{{WRAPPER}} .mgpckit-cat-info h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpc_cat_title_typography',
                'selector' => '{{WRAPPER}} .mgpckit-cat-info h2',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgtm_cat_description_style',
            [
                'label' => __('Description style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpc_cat_description_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-info p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpc_cat_description_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-info p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpc_cat_description_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpckit-cat-info p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpc_cat_description_typography',
                'selector' => '{{WRAPPER}} .mgpckit-cat-info p',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgpc_badge_style',
            [
                'label' => __('Badge', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,

            ]
        );
        $this->add_responsive_control(
            'mgpc_badge_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} span.mgpckit-cat-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpc_badge_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} span.mgpckit-cat-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpc_badge_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.mgpckit-cat-badge' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpc_badge_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.mgpckit-cat-badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpc_badge_typography',
                'selector' => '{{WRAPPER}} span.mgpckit-cat-badge',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpc_badge_border',
                'selector' => '{{WRAPPER}} span.mgpckit-cat-badge',
            ]
        );

        $this->add_control(
            'mgpc_badge_bradius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} span.mgpckit-cat-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpc_badge_bshadow',
                'selector' => '{{WRAPPER}} span.mgpckit-cat-badge',
            ]
        );
        $this->add_control(
            'mgpc_badge_rotate',
            [
                'label' => __('Badge Rotate', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 360,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} span.mgpckit-cat-badge' => 'transform:rotate({{SIZE}}deg);',
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
        $cat_list = $this->get_settings('cat_list');
        $mgpd_cats_column = $this->get_settings('mgpd_cats_column');


        if ($cat_list) :

?>
            <div class="mgpckit-cat-grid mpdc-catg-<?php echo esc_attr($settings['mgpd_cats_style']); ?>">
                <div class="row">
                    <?php
                    foreach ($cat_list as $item) :
                        $catslug = $item['mgpd_cats'];
                        $mgpc_cat_img = $item['mgpc_cat_img'];
                        $category = get_category_by_slug($catslug);

                        $catid = $category->term_id;

                        //term name
                        $term_name = $category->name;
                        //term desc
                        $term_desc = $category->description;

                        $cat_link =  get_category_link($catid);;
                    ?>
                        <div class="col-lg-<?php echo esc_attr($mgpd_cats_column); ?>">
                            <div class="mgpckit-cat-item <?php if ($settings['content_grid_boxshadow'] == 'yes') : ?>mgpdi-shadow<?php endif; ?>">

                                <?php if ($settings['mgpc_catimg_show']) : ?>
                                    <div class="mgpckit-cat-img">
                                        <figure>
                                            <a href="<?php echo esc_url($cat_link); ?> ">
                                                <?php if (!empty($mgpc_cat_img['url'] || $mgpc_cat_img['id'])) : ?>
                                                    <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'mgpc_cat_img'); ?>
                                                <?php else : ?>
                                                    <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'mgpc_default_img'); ?>

                                                <?php endif; ?>
                                            </a>

                                        </figure>
                                        <?php if ($item['mgpc_badge_use']) : ?>
                                            <span class="mgpckit-cat-badge mgpckit-cat-<?php echo esc_attr($item['badge_position']); ?>"><?php echo esc_html($item['badge_text']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($term_name || $term_desc) : ?>
                                    <div class="mgpckit-cat-info p-3">
                                        <h2><a href="<?php echo esc_url($cat_link); ?> "><?php echo esc_html($term_name); ?></a></h2>
                                        <?php if ($settings['mgpc_catdes_show'] && $term_desc) : ?>
                                            <p><?php echo esc_html(wp_trim_words($term_desc, $settings['mgpc_catdes_crop'], '..')); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-danger">
                <?php echo esc_html('Please select posts categories for display this section.'); ?>
            </div>
        <?php endif; ?>

<?php
    }
}
