<?php

/**
 * Slider widget class
 *
 * @package Magical addons
 */

defined('ABSPATH') || die();

use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

class mgpdEPostsSlider extends \Elementor\Widget_Base
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
        return 'mgposts_dslider';
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
        return __('Magical Posts Slider', 'magical-posts-display');
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
        return 'eicon-post-slider';
    }

    public function get_keywords()
    {
        return ['slider', 'post', 'gallery', 'carousel', 'magic'];
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
            'mpd-slider-script-active',
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
            'mps_slider_section',
            [
                'label' => __('Slider posts', 'magical-posts-display'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgps_product_id',
            [
                'label' => __('Select posts for slide', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_posts_name(),

            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'home-slider',
                'separator' => 'before',
                'default' => 'slider-bg',
                'exclude' => [
                    'custom'
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mps_slider_content_section',
            [
                'label' => __('Slider Content', 'magical-posts-display'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgps_content_show',
            [
                'label' => __('Show Slider content?', 'magical-posts-display'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgps_category_show',
            [
                'label'     => __('Show Category', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'mgps_content_show' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mgps_title_show',
            [
                'label' => __('Show title?', 'magical-posts-display'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'mgps_content_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgps_crop_title',
            [
                'label'   => __('Crop Title By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 5,
                'condition' => [
                    'mgps_content_show' => 'yes',
                    'mgps_title_show' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgps_desc_show',
            [
                'label' => __('Show Description?', 'magical-posts-display'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'mgps_content_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgps_crop_desc',
            [
                'label'   => __('Crop Description By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 20,
                'condition' => [
                    'mgps_desc_show' => 'yes',
                    'mgps_content_show' => 'yes',
                ]

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mgps_settings_section',
            [
                'label' => __('Slider Settings', 'magical-posts-display'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgps_slide_effect',
            [
                'label' => __('Slide Effect', 'magical-posts-display'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'fade' => __('fade', 'magical-posts-display'),
                    'slide' => __('Slide', 'magical-posts-display'),
                ],
                'default' => 'fade',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'mgps_slide_direction',
            [
                'label' => __('Slider Direction', 'magical-posts-display'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'horizontal' => __('Horizontal', 'magical-posts-display'),
                    'vertical' => __('Vertical', 'magical-posts-display'),
                ],
                'default' => 'horizontal',
                'description' => __('Slider direction only show in the slide effect', 'magical-posts-display'),
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'mgps_animation_speed',
            [
                'label' => __('Animation Speed', 'magical-posts-display'),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 1,
                'max' => 10000,
                'default' => 1000,
                'description' => __('Slide speed in milliseconds', 'magical-posts-display'),
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'mgps_autoplay',
            [
                'label' => __('Autoplay?', 'magical-posts-display'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'mgps_autoplay_speed',
            [
                'label' => __('Autoplay Speed', 'magical-posts-display'),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 100,
                'max' => 10000,
                'default' => 3000,
                'description' => __('Autoplay speed in milliseconds', 'magical-posts-display'),
                'frontend_available' => true,
                'condition' => [
                    'mgps_autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgps_loop',
            [
                'label' => __('Infinite Loop?', 'magical-posts-display'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'mgps_grab_cursor',
            [
                'label' => __('Grab Cursor?', 'magical-posts-display'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgps_navdots_section',
            [
                'label' => __('Nav & Dots', 'magical-posts-display'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgps_dots',
            [
                'label' => __('Slider Dots?', 'magical-posts-display'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->add_control(
            'mgps_navigation',
            [
                'label' => __('Slider Navigation?', 'magical-posts-display'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgps_nav_prev_icon',
            [
                'label' => __('Choose Prev Icon', 'magical-posts-display'),
                'type' => Controls_Manager::ICONS,
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
                    'mgps_navigation' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mgps_nav_next_icon',
            [
                'label' => __('Choose Next Icon', 'magical-posts-display'),
                'type' => Controls_Manager::ICONS,
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
                    'mgps_navigation' => 'yes',
                ],

            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'mgps_button',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgps_post_btn',
            [
                'label' => __('Use post link?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgps_link_type',
            [
                'label' => __('Link type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'link1' => 'Link style one',
                    'btn btn-outline-light' => 'Link style two',
                    'btn btn-info' => 'Button',
                ],
                'default' => 'btn btn-outline-light',
            ]
        );

        $this->add_control(
            'mgps_btn_title',
            [
                'label'       => __('Link Title', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Read More', 'magical-posts-display'),
                'default'     => __('Read More', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgps_btn_target',
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
            'mgps_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => '',
            ]
        );

        $this->add_control(
            'mgps_btn_icon',
            [
                'label' => __('Choose Icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mgps_usebtn_icon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgps_btn_icon_position',
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
                    'mgps_usebtn_icon' => 'yes',
                ],

            ]
        );
        $this->add_responsive_control(
            'mgps_cardbtn_iconspace',
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
                    'mgps_usebtn_icon' => 'yes',
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
            'mgps_style_section',
            [
                'label' => __('Slider Item', 'magical-posts-display'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mgps_slide_height_auto',
            [
                'label' => __('Slider Auto Height?', 'magical-posts-display'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'mgps_slide_height',
            [
                'label' => __('Slider Height', 'magical-posts-display'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1200,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'condition' => [
                    'mgps_slide_height_auto' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgps-main .mgs-item img, {{WRAPPER}} .mgps-main .mgse-img-before, {{WRAPPER}} .swiper-vertical' => 'height: {{SIZE}}{{UNIT}};min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'mgps_item_border',
                'selector' => '{{WRAPPER}} .mgps-main .mgs-item',
            ]
        );

        $this->add_responsive_control(
            'mgps_item_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgps-main .mgs-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mgps_style_content',
            [
                'label' => __('Slide Content', 'magical-posts-display'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgps_content_padding',
            [
                'label' => __('Content Padding', 'magical-posts-display'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgps-main .mgs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'mgps_content_background',
                'selector' => '{{WRAPPER}} .mgps-main .mgs-content',
                'exclude' => [
                    'image'
                ]
            ]
        );
        $this->add_responsive_control(
            'mgps_content_radius',
            [
                'label' => __('Content Border Radius', 'magical-posts-display'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgps-main .mgs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_control(
            'mgps_cat_style',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __('Category', 'magical-posts-display'),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'mgps_cat_spacing',
            [
                'label' => __('Bottom Spacing', 'magical-posts-display'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} span.slide-cat a' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_cat_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.slide-cat a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mgps_cat_typo',
                'selector' => '{{WRAPPER}} span.slide-cat a',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'mgps_cat_shadow',
                'label' => __('Title Text Shadow', 'plugin-domain'),
                'selector' => '{{WRAPPER}} span.slide-cat a',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'mgps_cat_border',
                'selector' => '{{WRAPPER}} span.slide-cat a',
            ]
        );
        $this->add_responsive_control(
            'mgps_cat_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} span.slide-cat a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgps_heading_title',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __('Title', 'magical-posts-display'),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'mgps_title_spacing',
            [
                'label' => __('Bottom Spacing', 'magical-posts-display'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mgs-content .mgs-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_title_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgs-content .mgs-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mgps_title_typo',
                'selector' => '{{WRAPPER}} .mgs-content .mgs-title',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'mgps_title_shadow',
                'label' => __('Title Text Shadow', 'plugin-domain'),
                'selector' => '{{WRAPPER}} .mgs-content .mgs-title',
            ]
        );

        $this->add_control(
            'mgps_heading_subtitle',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __('Subtitle', 'magical-posts-display'),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'mgps_subtitle_spacing',
            [
                'label' => __('Bottom Spacing', 'magical-posts-display'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mgs-content .mgs-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_subtitle_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgs-content .mgs-subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mgps_subtitle',
                'selector' => '{{WRAPPER}} .mgs-content .mgs-subtitle',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'mgps_subtitle_shadow',
                'label' => __('Title Text Shadow', 'plugin-domain'),
                'selector' => '{{WRAPPER}} .mgs-content .mgs-subtitle',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgps_btn_style',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgps_btn_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgps-main a.mp-post-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgps_btn_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgps-main a.mp-post-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgps_btn_typography',
                'selector' => '{{WRAPPER}} .mgps-main a.mp-post-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgps_btn_border',
                'selector' => '{{WRAPPER}} .mgps-main a.mp-post-btn',
            ]
        );

        $this->add_control(
            'mgps_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgps-main a.mp-post-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgps_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mgps-main a.mp-post-btn',
            ]
        );
        $this->add_control(
            'mgps_button_color',
            [
                'label' => __('Button color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('mgps_btn_tabs');

        $this->start_controls_tab(
            'mgps_btn_normal_style',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgps_btn_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mgps-main a.mp-post-btn' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgps_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgps-main a.mp-post-btn' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgps_btn_hover_style',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgps_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} .mgps-main a.mp-post-btn:hover',
            ]
        );

        $this->add_control(
            'mgps_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgps-main a.mp-post-btn:hover, {{WRAPPER}} .mgps-main a.mp-post-btn:focus' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgps_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgps-main a.mp-post-btn:hover, {{WRAPPER}} .mgps-main a.mp-post-btn:focus' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgps_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgps_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgps-main a.mp-post-btn:hover, {{WRAPPER}} .mgps-main a.mp-post-btn:focus' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'mgps_section_style_arrow',
            [
                'label' => __('Navigation - Arrow', 'magical-posts-display'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgps_arrow_position_toggle',
            [
                'label' => __('Position', 'magical-posts-display'),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __('None', 'magical-posts-display'),
                'label_on' => __('Custom', 'magical-posts-display'),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'mgps_arrow_positiony',
            [
                'label' => __('Vertical', 'magical-posts-display'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                // 'condition' => [
                //     'arrow_position_toggle' => 'yes'
                // ],
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
            'mgps_arrow_position_x',
            [
                'label' => __('Horizontal', 'magical-posts-display'),
                'type' => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-rtl .swiper-button-next' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-button-next,{{WRAPPER}} .swiper-rtl .swiper-button-prev' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();
        $this->add_responsive_control(
            'mgps_arrow_border',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};width:inherit;height:inherit',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'mgps_arrow_border',
                'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
            ]
        );

        $this->add_responsive_control(
            'mgps_arrow_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->start_controls_tabs('mgps_tabs_arrow');

        $this->start_controls_tab(
            'mgps_tab_arrow_normal',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgps_arrow_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next i, {{WRAPPER}} .swiper-button-prev i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-button-next svg, {{WRAPPER}} .swiper-button-prev svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_arrow_bg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgps_tab_arrow_hover',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgps_arrow_hover_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_arrow_hover_bg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgps_arrow_hover_border_color',
            [
                'label' => __('Border Color', 'magical-posts-display'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'arrow_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'mgps_section_style_dots',
            [
                'label' => __('Navigation - Dots', 'magical-posts-display'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgps_dots_position_y',
            [
                'label' => __('Vertical Position', 'magical-posts-display'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-horizontal>.swiper-pagination-bullets, {{WRAPPER}} .swiper-pagination-custom, {{WRAPPER}} .swiper-pagination-fraction' => 'bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-vertical>.swiper-pagination-bullets' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgps_dots_spacing',
            [
                'label' => __('Spacing', 'magical-posts-display'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .swiper-vertical>.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: calc({{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgps_dots_nav_align',
            [
                'label' => __('Alignment', 'magical-posts-display'),
                'type' => Controls_Manager::CHOOSE,
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
                'condition' => [
                    'mgps_slide_direction' => 'horizontal',
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .swiper-horizontal>.swiper-pagination-bullets, .swiper-pagination-custom, {{WRAPPER}} .swiper-pagination-fraction' => 'text-align: {{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'mgps_dots_width',
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
            'mgps_dots_height',
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
            'mgps_dots_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->start_controls_tabs('mgps_tabs_dots');
        $this->start_controls_tab(
            'mgps_tab_dots_normal',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgps_dots_nav_color',
            [
                'label' => __('Color', 'magical-posts-display'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgps_tab_dots_hover',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgps_dots_nav_hover_color',
            [
                'label' => __('Color', 'magical-posts-display'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgps_tab_dots_active',
            [
                'label' => __('Active', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgps_dots_nav_active_color',
            [
                'label' => __('Color', 'magical-posts-display'),
                'type' => Controls_Manager::COLOR,
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
        $mgps_autoplay = $settings['mgps_autoplay'] ? 'true' : 'false';
        $mgps_loop = $settings['mgps_loop'] ? 'true' : 'false';
        $mgps_grab_cursor = $settings['mgps_grab_cursor'] ? 'true' : 'false';
        $mgps_dots = $settings['mgps_dots'] ? 'true' : 'false';
        $mgps_navigation = $settings['mgps_navigation'] ? 'true' : 'false';
        $mgps_animation_speed = $settings['mgps_animation_speed'] ? $settings['mgps_animation_speed'] : 1000;
        $mgps_autoplay_speed = $settings['mgps_autoplay_speed'] ? $settings['mgps_autoplay_speed'] : 3000;

        $product_ids = !empty($settings['mgps_product_id']) ? $settings['mgps_product_id'] : array();
        $sanitized_product_ids = array_filter(array_map('absint', $product_ids));
        // Query Argument
        $args = array(
            'post_type'             => 'post',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => -1,
            'post__in'        => $sanitized_product_ids
        );

        $mgpslide_posts = new WP_Query($args);

        if ($mgpslide_posts->have_posts()) :

?>

            <div class="mgps-main swiper swiper-container" data-loop="<?php echo esc_attr($mgps_loop); ?>" data-effect="<?php echo esc_attr($settings['mgps_slide_effect']); ?>" data-direction="<?php echo esc_attr($settings['mgps_slide_direction']); ?>" data-speed="<?php echo esc_attr($mgps_animation_speed); ?>" data-autoplay="<?php echo esc_attr($mgps_autoplay); ?>" data-auto-delay="<?php echo esc_attr($settings['mgps_autoplay_speed']); ?>" data-grab-cursor="<?php echo esc_attr($mgps_grab_cursor); ?>" data-nav="<?php echo esc_attr($mgps_navigation); ?>" data-dots="<?php echo esc_attr($mgps_dots); ?>">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper mgps-<?php echo esc_attr($settings['mgps_slide_effect']); ?>">
                    <?php
                    while ($mgpslide_posts->have_posts()) : $mgpslide_posts->the_post();

                        $this->posts_slider_item_output($settings);

                    endwhile;
                    wp_reset_query();
                    wp_reset_postdata();
                    ?>
                </div>
                <?php if ($settings['mgps_dots']) : ?>
                    <div class="swiper-pagination"></div>
                <?php endif; ?>

                <?php if ($settings['mgps_navigation']) : ?>
                    <div class="swiper-button-prev">
                        <?php \Elementor\Icons_Manager::render_icon($settings['mgps_nav_prev_icon']); ?>
                    </div>
                    <div class="swiper-button-next">
                        <?php \Elementor\Icons_Manager::render_icon($settings['mgps_nav_next_icon']); ?>
                    </div>
                <?php endif; ?>

                <!-- If we need scrollbar 
    <div class="swiper-scrollbar"></div>
    -->
            </div>


        <?php
        endif;
    }

    public function posts_slider_item_output($settings)
    {
        $mgpslide_cat = get_the_category();
        if ($mgpslide_cat) {
            $mgpslide_category = $mgpslide_cat[wp_rand(0, count($mgpslide_cat) - 1)];
        } else {
            $mgpslide_category = '';
        }

        $mgps_post_btn = $settings['mgps_post_btn'];
        $mgps_btn_title = $settings['mgps_btn_title'];
        $mgps_usebtn_icon = $settings['mgps_usebtn_icon'];
        $mgps_btn_icon_position = $settings['mgps_btn_icon_position'];
        $mgps_btn_target = $settings['mgps_btn_target'];
        ?>
        <!-- Slides -->
        <div class="swiper-slide mgs-item">
            <div class="mgse-img-before">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail($settings['thumbnail_size'], array('class' => 'mgps-img')); ?>
                <?php else : ?>
                    <div class="mgps-no-img noimg-set"></div>
                <?php endif; ?>
            </div>
            <?php if ($settings['mgps_content_show']) : ?>
                <div class="mgs-content mgst-center mgs-overlay">
                    <?php if ($mgpslide_category && $settings['mgps_category_show']) : ?>
                        <span class="slide-cat"><a href="<?php echo esc_url(get_category_link($mgpslide_category)); ?>"><?php echo esc_html($mgpslide_category->name); ?></a>
                        </span>
                    <?php endif; ?>
                    <?php if ($settings['mgps_title_show']) : ?>
                        <h2 class="mgs-title" data-swiper-parallax-scale="0.15"><?php echo esc_html(wp_trim_words(get_the_title(), $settings['mgps_crop_title'], '')); ?></h2>
                    <?php endif; //title end 
                    ?>
                    <?php if ($settings['mgps_desc_show']) : ?>
                        <p class="mgs-subtitle" data-swiper-parallax-opacity="0.5">
                            <?php
                            if (has_excerpt()) {
                                echo esc_html(wp_trim_words(get_the_excerpt(), $settings['mgps_crop_desc'], ''));
                            } else {
                                echo esc_html(wp_trim_words(get_the_content(), $settings['mgps_crop_desc'], ''));
                            }
                            ?>
                        </p>
                    <?php endif; //subtitle end 
                    ?>
                    <?php
                    if ($mgps_post_btn) {
                        mp_post_btn(
                            $text = $mgps_btn_title,
                            $icon_show = $mgps_usebtn_icon,
                            $icon = $settings['mgps_btn_icon'],
                            $icon_position = $mgps_btn_icon_position,
                            $target = $mgps_btn_target,
                            $class = $settings['mgps_link_type']
                        );
                    }
                    ?>
                </div>
            <?php endif; //content end 
            ?>
        </div>
<?php
    }
}
