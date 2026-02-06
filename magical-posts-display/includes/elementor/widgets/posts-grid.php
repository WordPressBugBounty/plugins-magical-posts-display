<?php

class mgpdEPostsGrid extends \Elementor\Widget_Base
{
    use SVG_Icons_Trait;
    use Advanced_Media_Trait;
    use Query_Controls_Trait;

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
        return 'mgposts_dgrid';
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
        return __('Magical Posts Grid', 'magical-posts-display');
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
        return 'eicon-posts-grid';
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
            'mgpg_query',
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
            'mgpg_posts_filter',
            [
                'label' => esc_html__('Filter By', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'recent',
                'options' => [
                    'recent' => esc_html__('Recent Posts', 'magical-posts-display'),
                    'popular' => esc_html__('Popular Posts(Pro Only)', 'magical-posts-display'),
                    'trending' => esc_html__('Trending posts(Pro Only)', 'magical-posts-display'),
                    'random_order' => esc_html__('Random Posts', 'magical-posts-display'),
                    'show_byid' => esc_html__('Show By Id (Post Only)', 'magical-posts-display'),
                    'show_byid_manually' => esc_html__('Add ID Manually', 'magical-posts-display'),
                    'advanced_query' => esc_html__('Advanced Query Builder (Pro Only)', 'magical-posts-display'),
                    'custom_fields' => esc_html__('Custom Fields Filter (Pro Only)', 'magical-posts-display'),
                    'exclude_current' => esc_html__('Exclude Current Post (Pro Only)', 'magical-posts-display'),
                ],
            ]
        );
        $this->add_control(
            'mgpg_post_id',
            [
                'label' => __('Select posts', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_posts_name(),
                'condition' => [
                    'mgpg_posts_filter' => 'show_byid',
                    'mgpg_post_type' => 'post',
                ],

            ]
        );

        $this->add_control(
            'mgpg_post_ids_manually',
            [
                'label' => __('posts IDs', 'magical-posts-display'),
                'description' => __('Separate IDs with commas', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'mgpg_posts_filter' => 'show_byid_manually',
                ]
            ]
        );

        $this->add_control(
            'mgpg_posts_count',
            [
                'label'   => __('posts Limit', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'step'    => 1,
            ]
        );

        // Post Position Control
        $this->register_post_position_control('mgpg_posts_filter');

        $this->add_control(
            'mgpg_grid_categories',
            [
                'label' => esc_html__('posts Categories', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_taxonomy_list(),
                'condition' => [
                    'mgpg_posts_filter!' => 'show_byid',
                    'mgpg_post_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'mgpg_custom_order',
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
                    'mgpg_custom_order' => 'yes',
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
                    'mgpg_custom_order' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpg_layout',
            [
                'label' => esc_html__('Grid Layout', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpg_layout_type',
            [
                'label'   => __('Layout Type', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'static',
                'options' => [
                    'static'   => __('Static', 'magical-posts-display'),
                    'masonry'  => __('Masonry', 'magical-posts-display'),
                ],
                'description' => __('Choose between static grid layout or masonry layout. Masonry creates a dynamic, Pinterest-style layout. <strong>Note: Masonry only works on frontend, not in editor preview.</strong>', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpg_masonry_style',
            [
                'label'   => __('Masonry Style', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1'   => __('Style 1 - Default Heights', 'magical-posts-display'),
                    'style2'   => __('Style 2 - Alternating Heights', 'magical-posts-display'),
                    'style3'   => __('Style 3 - Pattern Heights', 'magical-posts-display'),
                ],
                'condition' => [
                    'mgpg_layout_type' => 'masonry',
                ],
                'description' => __('Choose different image height patterns for masonry layout. <strong>Note: Masonry preview only works on frontend.</strong>', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpg_post_style',
            [
                'label'   => __('Grid Style', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'   => __('Style One', 'magical-posts-display'),
                    '2'  => __('Style Two', 'magical-posts-display'),
                    '3'  => __('Style Three', 'magical-posts-display'),
                ]
            ]
        );
        $this->add_control(
            'mgpg_rownumber',
            [
                'label'   => __('Show Posts Per Row', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '12'   => __('1', 'magical-posts-display'),
                    '6'  => __('2', 'magical-posts-display'),
                    '4'  => __('3', 'magical-posts-display'),
                    '3'  => __('4', 'magical-posts-display'),
                    '2'  => __('6', 'magical-posts-display'),
                ]
            ]
        );
        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpg_content',
            [
                'label' => esc_html__('Content Settings', 'magical-posts-display'),
            ]
        );


        $this->add_control(
            'mgpg_post_img_show',
            [
                'label'     => __('Show Posts image', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mgpg_media_source',
            [
                'label' => __('Advanced Media Source (Pro Only)', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'featured' => __('Featured Image Only', 'magical-posts-display'),
                    'content' => __('First Content Image (Pro Only)', 'magical-posts-display'),
                    'video' => __('Video Embed (YouTube/Vimeo) (Pro Only)', 'magical-posts-display'),
                    'priority' => __('Priority Fallback (Pro Only)', 'magical-posts-display'),
                ],
                'default' => 'featured',
                'description' => __('Choose media source with priority fallback system (Pro Only)', 'magical-posts-display'),
                'classes' => 'mpd-pro-control',
                'condition' => [
                    'mgpg_post_img_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpg_media_priority',
            [
                'label' => __('Priority Order (Pro Only)', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    'video' => __('Video Embed', 'magical-posts-display'),
                    'featured' => __('Featured Image', 'magical-posts-display'),
                    'content' => __('First Content Image', 'magical-posts-display'),
                    'placeholder' => __('Placeholder Image', 'magical-posts-display'),
                ],
                'default' => ['video', 'featured', 'content', 'placeholder'],
                'description' => __('Set priority order for media fallback. First available source will be used (Pro Only)', 'magical-posts-display'),
                'classes' => 'mpd-pro-control',
                'condition' => [
                    'mgpg_post_img_show' => 'yes',
                    'mgpg_media_source' => 'priority',
                ],
            ]
        );

        $this->add_control(
            'mgpg_video_play_icon',
            [
                'label' => __('Show Video Play Icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => __('Display play icon overlay on video thumbnails (Pro Only)', 'magical-posts-display'),
                'classes' => 'mpd-pro-control',
                'condition' => [
                    'mgpg_post_img_show' => 'yes',
                    'mgpg_media_source' => ['video', 'priority'],
                ],
                'condition_type' => 'or',
            ]
        );

        $this->add_control(
            'mgpg_show_title',
            [
                'label'     => __('Show posts Title', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpg_crop_title',
            [
                'label'   => __('Crop Title By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 5,
                'condition' => [
                    'mgpg_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpg_title_tag',
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
                    'mgpg_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpg_desc_show',
            [
                'label'     => __('Show posts Description', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'

            ]
        );
        $this->add_control(
            'mgpg_crop_desc',
            [
                'label'   => __('Crop Description By Word', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 20,
                'condition' => [
                    'mgpg_desc_show' => 'yes',
                ]

            ]
        );

        $this->add_responsive_control(
            'mgpg_content_align',
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
                    '{{WRAPPER}} .mgp-card .mg-card-text.mgp-card-body' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpg_meta_section',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'default' => '',
            ]
        );
        $this->add_control(
            'mgpg_category_show',
            [
                'label'     => __('Show Category', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'mgpg_post_type' => 'post',
                ]

            ]
        );
        $this->add_control(
            'mgpg_cat_type',
            [
                'label' => __('Category type', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'all' => __('Show all categories', 'magical-posts-display'),
                    'one' => __('Show first category', 'magical-posts-display'),
                ],
                'default' => 'one',
                'condition' => [
                    'mgpg_category_show' => 'yes',
                    'mgpg_post_type' => 'post',
                ],
            ]
        );
        $this->add_control(
            'mgpg_date_show',
            [
                'label'     => __('Show Date', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpg_author_show',
            [
                'label'     => __('Show Author', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpg_comment_icon_show',
            [
                'label'     => __('Show Comment Icon', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpg_tag_show',
            [
                'label'     => __('Show Tags', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',

            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'mgpg_button',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgpg_post_btn',
            [
                'label' => __('Use post link?', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpg_link_type',
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
            'mgpg_btn_title',
            [
                'label'       => __('Link Title', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Read More', 'magical-posts-display'),
                'default'     => __('Read More', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpg_btn_target',
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
            'mgpg_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => '',
            ]
        );

        $this->add_control(
            'mgpg_btn_icon',
            [
                'label' => __('Choose Icon', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mgpg_usebtn_icon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_btn_icon_position',
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
                    'mgpg_usebtn_icon' => 'yes',
                ],

            ]
        );
        $this->add_responsive_control(
            'mgpg_cardbtn_iconspace',
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
                    'mgpg_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-card .mp-post-btn i.left,{{WRAPPER}} .mg-card .mp-post-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-card .mp-post-btn i.right, {{WRAPPER}} .mg-card .mp-post-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        // Premium Features Section
        $this->start_controls_section(
            'mgpg_premium_features',
            [
                'label' => sprintf('%s %s', __('Premium Features', 'magical-posts-display'), mp_display__pro_only_text()),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        if (empty(mp_display_check_main_ok())) {
            $this->add_control(
                'mgpg_premium_info',
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => sprintf('<span style="color:red">%s</span>', __('These advanced features are only available in the Pro version.', 'magical-posts-display')),
                ]
            );
        }
        $this->add_control(
            'mgpg_ajax_filter',
            [
                'label' => __('AJAX Category Filter', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => __('Enable dynamic category filtering without page reload (Pro Only)', 'magical-posts-display'),
                'classes' => 'mpd-pro-control',
            ]
        );

        $this->add_control(
            'mgpg_infinite_scroll',
            [
                'label' => __('Infinite Scroll', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => __('Load more posts automatically when scrolling (Pro Only)', 'magical-posts-display'),
                'classes' => 'mpd-pro-control',
            ]
        );

        $this->add_control(
            'mgpg_reading_time',
            [
                'label' => __('Reading Time Display', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => __('Show estimated reading time for each post (Pro Only)', 'magical-posts-display'),
                'classes' => 'mpd-pro-control',
            ]
        );

        $this->add_control(
            'mgpg_view_count',
            [
                'label' => __('Post Views Counter', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => __('Display post view counts with analytics (Pro Only)', 'magical-posts-display'),
                'classes' => 'mpd-pro-control',
            ]
        );

        $this->add_control(
            'mgpg_social_share',
            [
                'label' => __('Social Share Buttons', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => __('Add social sharing buttons to each post card (Pro Only)', 'magical-posts-display'),
                'classes' => 'mpd-pro-control',
            ]
        );

        $this->add_control(
            'mgpg_premium_features_style',
            [
                'label' => __('Premium Features Display Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'default' => __('Default (Below Content)', 'magical-posts-display'),
                    'image-top' => __('Top of Image (Pro Only)', 'magical-posts-display'),
                    'image-overlay' => __('Image Overlay on Hover (Pro Only)', 'magical-posts-display'),
                ],
                'default' => 'default',
                'description' => __('Choose where to display reading time, views, and social buttons (Pro Only)', 'magical-posts-display'),
                'classes' => 'mpd-pro-control',
                'condition' => [
                    'mgpg_reading_time' => 'yes',
                    'mgpg_view_count' => 'yes',
                    'mgpg_social_share' => 'yes',
                ],
                'condition_type' => 'or',
            ]
        );

        $this->add_control(
            'mgpg_hover_effects',
            [
                'label' => __('Advanced Hover Effects', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'none' => __('None', 'magical-posts-display'),
                    'zoom' => __('Zoom Effect (Pro Only)', 'magical-posts-display'),
                    'slide' => __('Slide Effect (Pro Only)', 'magical-posts-display'),
                    'fade' => __('Fade Effect (Pro Only)', 'magical-posts-display'),
                    'rotate' => __('Rotate Effect (Pro Only)', 'magical-posts-display'),
                ],
                'default' => 'none',
                'description' => __('Choose advanced hover animations for post cards (Pro Only)', 'magical-posts-display'),
                'classes' => 'mpd-pro-control',
            ]
        );
        if (mp_display_check_main_ok()) {
            $this->add_control(
                'mgpg_ajax_info',
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => sprintf('<span style="color:red">%s</span>', __('All Ajax features only work in the frontend', 'magical-posts-display')),
                ]
            );
        }
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
            'mgpg_style',
            [
                'label' => __('Layout style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'mgpg_min_height',
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
                    '{{WRAPPER}} .mg-card.mgp-card' => 'min-height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card.mgp-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card.mgp-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpg_bg_color',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .mg-card.mgp-card',
            ]
        );

        $this->add_control(
            'mgpg_border_radius',
            [
                'label' => __('Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card.mgp-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_content_border',
                'selector' => '{{WRAPPER}} .mg-card.mgp-card',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_content_shadow',
                'selector' => '{{WRAPPER}} .mg-card.mgp-card',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgpg_img_style',
            [
                'label' => __('Image style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mgpg_post_img_show' => 'yes',
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
            'mgpg_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-posts-display'),
                'label_off' => __('Off', 'magical-posts-display'),
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'mgpg_img_height',
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
                    'mgpg_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mp-post-img figure img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpg_imgbg_height',
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
                    'mgpg_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mp-post-img figure' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_img_padding',
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
            'mgpg_img_margin',
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
            'mgpg_img_border_radius',
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
                'name' => 'mgpg_img_bgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mgp-card .mp-post-img figure img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_img_border',
                'selector' => '{{WRAPPER}} .mgp-card .mp-post-img figure img',
            ]
        );
        $this->end_controls_section();

        // Filter Buttons Style Section
        $this->start_controls_section(
            'mgpd_filter_buttons_style',
            [
                'label' => __('Filter Buttons', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mgpg_ajax_filter' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'mgpd_filter_align',
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
                    '{{WRAPPER}} .mgpd-filter-buttons' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpd_filter_spacing',
            [
                'label' => __('Buttons Spacing', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpd_filter_margin',
            [
                'label' => __('Container Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-filter-buttons' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpd_filter_padding',
            [
                'label' => __('Container Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-filter-buttons' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Button Tabs for Normal and Active states
        $this->start_controls_tabs('mgpd_filter_btn_tabs');

        // Normal State Tab
        $this->start_controls_tab(
            'mgpd_filter_btn_normal',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpd_filter_btn_typography',
                'selector' => '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn',
            ]
        );

        $this->add_control(
            'mgpd_filter_btn_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpd_filter_btn_bg',
                'label' => __('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn',
            ]
        );

        $this->add_responsive_control(
            'mgpd_filter_btn_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 10,
                    'right' => 20,
                    'bottom' => 10,
                    'left' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpd_filter_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpd_filter_btn_border',
                'selector' => '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpd_filter_btn_shadow',
                'selector' => '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn',
            ]
        );

        $this->end_controls_tab();

        // Active/Hover State Tab
        $this->start_controls_tab(
            'mgpd_filter_btn_active',
            [
                'label' => __('Active/Hover', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpd_filter_btn_active_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn.active' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpd_filter_btn_active_bg',
                'label' => __('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn.active, {{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn:hover',
            ]
        );

        $this->add_control(
            'mgpd_filter_btn_active_border_color',
            [
                'label' => __('Border Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn.active' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpd_filter_btn_active_shadow',
                'selector' => '{{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn.active, {{WRAPPER}} .mgpd-filter-buttons .mgpd-filter-btn:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'mgpg_title_style',
            [
                'label' => __('Posts Title', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Adding Tabs for Normal and Hover
        $this->start_controls_tabs('mgpg_title_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'mgpg_title_normal',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_responsive_control(
            'mgpg_title_padding',
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
            'mgpg_title_margin',
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
            'mgpg_title_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mgp-title-link, {{WRAPPER}} .mgp-card .mgp-ptitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_descb_radius',
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
                'name' => 'mgpg_title_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgp-card .mgp-ptitle',
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'mgpg_title_hover',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpg_hover_transition',
            [
                'label' => __('Hover Transition', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle' => 'transition: all {{SIZE}}s ease;',
                ],
            ]
        );

        $this->add_control(
            'mgpg_title_hover_color',
            [
                'label' => __('Text Hover Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mgp-title-link:hover, {{WRAPPER}} .mgp-card .mgp-ptitle:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_title_hover_bgcolor',
            [
                'label' => __('Background Hover Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_descb_hover_radius',
            [
                'label' => __('Hover Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        $this->start_controls_section(
            'mgpg_description_style',
            [
                'label' => __('Description', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('mgpg_description_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'mgpg_description_normal',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_responsive_control(
            'mgpg_description_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.mgp-card-body p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_description_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.mgp-card-body p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_description_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.mgp-card-body p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.mgp-card-body p' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_description_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.mgp-card-body p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab(); // End of Normal Tab

        // Hover Tab
        $this->start_controls_tab(
            'mgpg_description_hover',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpg_description_hover_color',
            [
                'label' => __('Hover Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.mgp-card-body p:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_description_hover_bgcolor',
            [
                'label' => __('Hover Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.mgp-card-body p:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_des_hover_transition',
            [
                'label' => __('Hover Transition', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text.mgp-card-body p' => 'transition: all {{SIZE}}s ease;',
                ],
            ]
        );

        $this->end_controls_tab(); // End of Hover Tab

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_description_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgp-card .mg-card-text.mgp-card-body p',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mgpg_meta_style',
            [
                'label' => __('Posts Meta', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mgpg_meta_cat',
            [
                'label' => __('Category Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpg_category_show' => 'yes',
                    'mgpg_post_type' => 'post',
                ],
            ]
        );

        $this->start_controls_tabs('mgpg_meta_cat_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'mgpg_meta_cat_normal',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpg_meta_cat_text_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-post-cat, {{WRAPPER}} .mp-post-cat a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_meta_cat_bg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-post-cat' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_meta_cat_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .mp-post-cat' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_meta_cat_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .mp-post-cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_meta_cat_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mp-post-cat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_meta_cat_border',
                'label' => __('Border', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-post-cat',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_meta_cat_box_shadow',
                'label' => __('Box Shadow', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-post-cat',
            ]
        );

        $this->end_controls_tab(); // End Normal Tab

        // Hover Tab
        $this->start_controls_tab(
            'mgpg_meta_cat_hover',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpg_meta_cat_text_color_hover',
            [
                'label' => __('Hover Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-post-cat:hover, {{WRAPPER}} .mp-post-cat a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_meta_cat_bg_color_hover',
            [
                'label' => __('Hover Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-post-cat:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_meta_cat_border_hover',
                'label' => __('Hover Border', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-post-cat:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_meta_cat_box_shadow_hover',
                'label' => __('Hover Box Shadow', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-post-cat:hover',
            ]
        );

        $this->end_controls_tab(); // End Hover Tab

        $this->end_controls_tabs(); // End Tabs

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_meta_cat_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-post-cat, {{WRAPPER}} .mp-post-cat a',
                'condition' => [
                    'mgpg_category_show' => 'yes',
                    'mgpg_post_type' => 'post',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_meta_category_icon_size',
            [
                'label' => __('Icon Size', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mppost-cats i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mppost-cats svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Transition Duration Control
        $this->add_control(
            'mgpg_meta_cat_transition',
            [
                'label' => __('Transition Duration', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mp-post-cat' => 'transition: all {{SIZE}}s ease;',
                ],
            ]
        );

        $this->add_control(
            'mgpg_author_style_section',
            [
                'label' => __('Author Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpg_author_show' => 'yes',
                ],
            ]
        );


        $this->start_controls_tabs('mgpg_author_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'mgpg_author_normal_tab',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_author_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-meta .byline a',
            ]
        );

        $this->add_responsive_control(
            'mgpg_meta_author_icon_size',
            [
                'label' => __('Icon Size', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mp-meta .byline svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_author_text_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline i, {{WRAPPER}} .mp-meta .byline a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_author_background_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_author_border',
                'label' => __('Border', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-meta .byline',
            ]
        );

        $this->add_responsive_control(
            'mgpg_author_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_author_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'mgpg_author_hover_tab',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpg_author_hover_text_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_author_hover_background_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_author_hover_box_shadow',
                'label' => __('Box Shadow', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-meta .byline:hover',
            ]
        );

        $this->add_control(
            'mgpg_author_transition_duration',
            [
                'label' => __('Transition Duration', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mp-meta .byline' => 'transition: all {{SIZE}}s;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();



        $this->add_control(
            'mgpg_meta_date',
            [
                'label' => __('Date Style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpg_date_show' => 'yes',
                ],
            ]
        );
        $this->start_controls_tabs('mgpg_meta_date_tabs');

        // Normal Tab
        $this->start_controls_tab('mgpg_meta_date_normal', [
            'label' => __('Normal', 'magical-posts-display'),
        ]);

        $this->add_control(
            'mgpg_meta_date_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-posts-date, {{WRAPPER}} .mgp-time' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_meta_date_background_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-posts-date, {{WRAPPER}} .mgp-time' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_meta_date_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .mp-posts-date, {{WRAPPER}} .mgp-time' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_meta_date_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .mp-posts-date, {{WRAPPER}} .mgp-time' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_meta_date_border',
                'selector' => '{{WRAPPER}} .mp-posts-date, {{WRAPPER}} .mgp-time',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_meta_date_box_shadow',
                'selector' => '{{WRAPPER}} .mp-posts-date, {{WRAPPER}} .mgp-time',
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab('mgpg_meta_date_hover', [
            'label' => __('Hover', 'magical-posts-display'),
        ]);

        $this->add_control(
            'mgpg_meta_date_hover_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-posts-date:hover, {{WRAPPER}} .mgp-time:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_meta_date_hover_background_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mp-posts-date:hover, {{WRAPPER}} .mgp-time:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_meta_date_hover_border',
                'selector' => '{{WRAPPER}} .mp-posts-date:hover, {{WRAPPER}} .mgp-time:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_meta_date_hover_box_shadow',
                'selector' => '{{WRAPPER}} .mp-posts-date:hover, {{WRAPPER}} .mgp-time:hover',
            ]
        );

        $this->add_control(
            'mgpg_meta_date_transition',
            [
                'label' => __('Transition Duration', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mp-posts-date, {{WRAPPER}} .mgp-time' => 'transition: all {{SIZE}}s;',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_meta_date_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mp-posts-date, {{WRAPPER}} .mgp-time',
            ]
        );


        $this->add_responsive_control(
            'mgpg_meta_date_icon_size',
            [
                'label' => __('Icon Size', 'bk-helper'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .mgp-time i, {{WRAPPER}} .mp-posts-date i, {{WRAPPER}} .mgp_there_style-time > span:first-of-type i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgp-time svg, {{WRAPPER}} .mp-posts-date svg, .mgp_there_style-time > span:first-of-type svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_meta_tag',
            [
                'label' => __('Tags style', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpg_tag_show' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('mgpg_meta_tag_tabs');

        // Normal Tab
        $this->start_controls_tab('mgpg_meta_tag_normal', [
            'label' => __('Normal', 'magical-posts-display'),
        ]);

        $this->add_control(
            'mgpg_meta_tag_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links a, {{WRAPPER}} .mpg-tags-links i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mpg-tags-links svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_meta_tag_background_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_meta_tag_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_meta_tag_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_meta_tag_border',
                'selector' => '{{WRAPPER}} .mpg-tags-links',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_meta_tag_box_shadow',
                'selector' => '{{WRAPPER}} .mpg-tags-links',
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab('mgpg_meta_tag_hover', [
            'label' => __('Hover', 'magical-posts-display'),
        ]);

        $this->add_control(
            'mgpg_meta_tag_hover_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links a:hover, {{WRAPPER}} .mpg-tags-links i:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mpg-tags-links svg:hover' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_meta_tag_hover_background_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_meta_tag_hover_border',
                'selector' => '{{WRAPPER}} .mpg-tags-links:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_meta_tag_hover_box_shadow',
                'selector' => '{{WRAPPER}} .mpg-tags-links:hover',
            ]
        );

        $this->add_control(
            'mgpg_meta_tag_transition',
            [
                'label' => __('Transition Duration', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links' => 'transition: all {{SIZE}}s;',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_meta_tag_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mpg-tags-links a',
                'condition' => [
                    'mgpg_date_show' => 'yes',
                ],
                'condition' => [
                    'mgpg_tag_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_meta_tag_icon_size',
            [
                'label' => __('Icon Size', 'bk-helper'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mpg-tags-links svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpg_tag_show' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mgpg_btn_style',
            [
                'label' => __('Button', 'magical-posts-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpg_btn_padding',
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
            'mgpg_btn_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_btn_icon_size',
            [
                'label' => __('Icon Size', 'bk-helper'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn i,{{WRAPPER}} .mgp_there_style-time a span i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgp_there_style-time a span svg, {{WRAPPER}} .mgp-card a.mp-post-btn svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_btn_typography',
                'selector' => '{{WRAPPER}} .mgp-card a.mp-post-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_btn_border',
                'selector' => '{{WRAPPER}} .mgp-card a.mp-post-btn',
            ]
        );

        $this->add_control(
            'mgpg_btn_border_radius',
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
                'name' => 'mgpg_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mgp-card a.mp-post-btn',
            ]
        );
        $this->add_control(
            'mgpg_button_color',
            [
                'label' => __('Button color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('mgpg_btn_tabs');

        $this->start_controls_tab(
            'mgpg_btn_normal_style',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpg_btn_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn, {{WRAPPER}} .mgp_there_style-time a, .mgp_there_style-time a span, .mgp_there_style-time a span i' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .mgp_there_style-time a span svg, {{WRAPPER}} .mgp-card a.mp-post-btn span svg' => 'fill: {{VALUE}} !important;',

                ],
            ]
        );

        $this->add_control(
            'mgpg_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpg_btn_hover_style',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} .mgp-card a.mp-post-btn:hover',
            ]
        );

        $this->add_control(
            'mgpg_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn:hover, {{WRAPPER}} .mgp-card a.mp-post-btn:focus, .mgp-card a.mp-post-btn:hover span, .mgp-card a.mp-post-btn:hover span i' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .mgp-card a.mp-post-btn:hover span svg' => 'fill: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgpg_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn:hover, {{WRAPPER}} .mgp-card a.mp-post-btn:focus' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'mgpg_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgpg_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mp-post-btn:hover, {{WRAPPER}} .mgp-card a.mp-post-btn:focus' => 'border-color: {{VALUE}} !important;',
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

        // Premium Features Style Section
        $this->start_controls_section(
            'mgpg_premium_style',
            [
                'label' => sprintf('%s %s', __('✨ Premium Features Style', 'magical-posts-display'), mp_display__pro_only_text()),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        if (empty(mp_display_check_main_ok())) {
            $this->add_control(
                'mgpg_premium_style_info',
                [
                    'label' => sprintf('<span style="color:red">%s</span>', __('Premium features styling only works with pro version.', 'magical-posts-display')),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
        }

        // Reading Time Style
        $this->add_control(
            'mgpg_reading_time_heading',
            [
                'label' => __('Reading Time', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mgpg_reading_time_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-reading-time' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_reading_time_bg',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-reading-time' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_reading_time_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpd-reading-time',
            ]
        );

        $this->add_responsive_control(
            'mgpg_reading_time_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-reading-time' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_reading_time_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-reading-time' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_reading_time_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-reading-time' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // View Count Style
        $this->add_control(
            'mgpg_view_count_heading',
            [
                'label' => __('View Count', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mgpg_view_count_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-view-count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_view_count_bg',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-view-count' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_view_count_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpd-view-count',
            ]
        );

        $this->add_responsive_control(
            'mgpg_view_count_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-view-count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_view_count_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-view-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_view_count_border_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-view-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Social Share Buttons Style
        $this->add_control(
            'mgpg_social_share_heading',
            [
                'label' => __('Social Share Buttons', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'mgpg_social_share_size',
            [
                'label' => __('Button Size', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 32,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-social-share a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_social_share_gap',
            [
                'label' => __('Gap Between Buttons', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-social-share' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_social_share_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-social-share' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Social Button Colors with Tabs
        $this->add_control(
            'mgpg_social_colors_heading',
            [
                'label' => __('Individual Button Colors', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('mgpg_social_colors_tabs');

        // Normal State Tab
        $this->start_controls_tab(
            'mgpg_social_normal_tab',
            [
                'label' => __('Normal', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpg_social_facebook_color',
            [
                'label' => __('Facebook', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-share-facebook' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_social_twitter_color',
            [
                'label' => __('X (Twitter)', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-share-twitter' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_social_linkedin_color',
            [
                'label' => __('LinkedIn', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-share-linkedin' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_social_pinterest_color',
            [
                'label' => __('Pinterest', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-share-pinterest' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_social_instagram_color',
            [
                'label' => __('Instagram', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-share-instagram' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'mgpg_social_hover_tab',
            [
                'label' => __('Hover', 'magical-posts-display'),
            ]
        );

        $this->add_control(
            'mgpg_social_facebook_hover_color',
            [
                'label' => __('Facebook', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-share-facebook:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_social_twitter_hover_color',
            [
                'label' => __('X (Twitter)', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-share-twitter:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_social_linkedin_hover_color',
            [
                'label' => __('LinkedIn', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-share-linkedin:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_social_pinterest_hover_color',
            [
                'label' => __('Pinterest', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-share-pinterest:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_social_instagram_hover_color',
            [
                'label' => __('Instagram', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpd-share-instagram:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Hover Effects
        $this->add_control(
            'mgpg_social_hover_heading',
            [
                'label' => __('Hover Effects', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mgpg_social_hover_scale',
            [
                'label' => __('Scale on Hover', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .mgpd-social-share a:hover' => 'transform: scale(1.1);',
                ],
            ]
        );

        $this->add_control(
            'mgpg_social_transition_speed',
            [
                'label' => __('Transition Speed (ms)', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 50,
                    ],
                ],
                'default' => [
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpd-social-share a' => 'transition: all {{SIZE}}ms ease;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render premium features content
     * 
     * @param string $reading_time Show reading time
     * @param string $view_count Show view count
     * @param string $social_share Show social share
     */
    private function render_premium_features_content($reading_time, $view_count, $social_share)
    {

        if ($reading_time || $view_count) {
            echo '<div class="mgpd-time-count-wrap">';
            // Reading Time Display
            if ($reading_time) {
                $content = get_the_content();
                $word_count = str_word_count(wp_strip_all_tags($content));
                $reading_time_value = ceil($word_count / 200); // Average reading speed: 200 words per minute
                echo '<div class="mgpd-reading-time">' . $this->get_reading_time_icon(16) . ' ' . $reading_time_value . ' min read</div>';
            }

            // Post Views Counter
            if ($view_count) {
                $post_views = get_post_meta(get_the_ID(), 'mp_post_post_viewed', true);
                $post_views = $post_views ? $post_views : 0;
                echo '<div class="mgpd-view-count">' . $this->get_view_count_icon(16) . ' ' . number_format($post_views) . ' views</div>';
            }
            echo '</div>';
        }
        // Social Share Buttons
        if ($social_share) {
            $post_url = get_permalink();
            $post_title = get_the_title();
            echo '<div class="mgpd-social-share">';
            echo $this->get_all_social_share_buttons($post_url, $post_title, null, 20);
            echo '</div>';
        }
    }

    /**
     * Render single post item
     * Reusable method for both normal render and AJAX responses
     * 
     * @param array $settings Widget settings
     * @param string $item_class CSS classes for the item wrapper
     */
    public function render_single_post_item($settings, $item_class = '')
    {
        $mgpg_post_style = $settings['mgpg_post_style'];
        $mgpg_post_type = $settings['mgpg_post_type'];
        $mgpg_post_img_show = $settings['mgpg_post_img_show'];
        $mgpg_media_source = $settings['mgpg_media_source'] ?? 'featured';
        $mgpg_premium_features_style = $settings['mgpg_premium_features_style'] ?? 'default';
        $mgpg_show_title = $settings['mgpg_show_title'];
        $mgpg_title_tag = $settings['mgpg_title_tag'];
        $mgpg_crop_title = $settings['mgpg_crop_title'];
        $mgpg_desc_show = $settings['mgpg_desc_show'];
        $mgpg_crop_desc = $settings['mgpg_crop_desc'];
        $mgpg_post_btn = $settings['mgpg_post_btn'];
        $mgpg_btn_title = $settings['mgpg_btn_title'];
        $mgpg_usebtn_icon = $settings['mgpg_usebtn_icon'];
        $mgpg_btn_icon_position = $settings['mgpg_btn_icon_position'] ?? 'right';
        $mgpg_btn_target = $settings['mgpg_btn_target'];
        $mgpg_reading_time = $settings['mgpg_reading_time'] ?? false;
        $mgpg_view_count = $settings['mgpg_view_count'] ?? false;
        $mgpg_social_share = $settings['mgpg_social_share'] ?? false;
?>
        <div class="<?php echo esc_attr($item_class); ?>">
            <div class="mgp-card mg-card mg-shadow mgp-mb-4">
                <?php
                if ($mgpg_post_img_show) {
                    echo '<div class="mp-post-img">';

                    // Check if using advanced media source (Pro Only)
                    if (mp_display_check_main_ok() && $mgpg_media_source && $mgpg_media_source !== 'featured') {
                        $media_settings = array(
                            'mgpg_media_source' => $mgpg_media_source,
                            'mgpg_media_priority' => $settings['mgpg_media_priority'] ?? array('video', 'featured', 'content', 'placeholder'),
                            'mgpg_video_play_icon' => $settings['mgpg_video_play_icon'] ?? 'yes'
                        );
                        echo $this->get_advanced_media(get_the_ID(), $media_settings);
                    } else {
                        // Use default featured image
                        mp_post_thumbnail($mgpg_post_img_show);
                    }

                    // Premium features - Image Top style
                    if (mp_display_check_main_ok() && $mgpg_premium_features_style === 'image-top') {
                        echo '<div class="mgpd-premium-features">';
                        $this->render_premium_features_content($mgpg_reading_time, $mgpg_view_count, $mgpg_social_share);
                        echo '</div>';
                    }

                    // Premium features - Image Overlay style
                    if (mp_display_check_main_ok() && $mgpg_premium_features_style === 'image-overlay') {
                        echo '<div class="mgpd-premium-features">';
                        $this->render_premium_features_content($mgpg_reading_time, $mgpg_view_count, $mgpg_social_share);
                        echo '</div>';
                    }

                    echo '</div>';
                }
                ?>
                <div class="mg-card-text mgp-card-body">
                    <?php
                    if ($mgpg_post_style == '3') {
                    ?>
                        <div class="magical-post-authon-category">
                            <?php
                            mpd_posts_meta($settings['mgpg_author_show']);
                            mp_post_cat_display($settings['mgpg_category_show']);
                            ?>
                        </div>
                    <?php
                    }
                    if ($mgpg_post_type == 'post' && ($mgpg_post_style == '1' || $mgpg_post_style == '2')) {
                        mp_post_cat_display($settings['mgpg_category_show'], $settings['mgpg_cat_type'] ?? 'one', ', ');
                    }
                    ?>
                    <?php
                    mp_post_title($mgpg_show_title, $mgpg_title_tag, $mgpg_crop_title);
                    ?>
                    <?php
                    if ($mgpg_post_style == '1') {
                        mpd_posts_meta($settings['mgpg_author_show'], $settings['mgpg_date_show'], $settings['mgpg_comment_icon_show']);
                    }
                    ?>
                    <?php if ($mgpg_desc_show) : ?>
                        <p><?php
                            if (has_excerpt()) {
                                echo esc_html(wp_trim_words(get_the_excerpt(), $mgpg_crop_desc, '...'));
                            } else {
                                echo esc_html(wp_trim_words(get_the_content(), $mgpg_crop_desc, '...'));
                            }
                            ?>
                        </p>
                    <?php endif; ?>

                    <?php
                    // Premium Features Content (Pro Only) - Only show in default position
                    if (mp_display_check_main_ok() && (!$mgpg_premium_features_style || $mgpg_premium_features_style === 'default')) {
                        $this->render_premium_features_content($mgpg_reading_time, $mgpg_view_count, $mgpg_social_share);
                    }
                    ?>

                    <?php
                    if ($mgpg_post_style == '3') {
                    ?>
                        <div class="mgp_there_style-time">
                            <span>
                                <i class="fa-regular fa-calendar-days"></i>
                                <?php echo esc_html(get_the_date('d M Y')); ?>
                            </span>
                            <?php
                            if ($mgpg_post_btn && ($mgpg_post_style == '3')) {
                                mp_post_btn(
                                    $text = $mgpg_btn_title,
                                    $icon_show = $mgpg_usebtn_icon,
                                    $icon = $settings['mgpg_btn_icon'],
                                    $icon_position = $mgpg_btn_icon_position,
                                    $target = $mgpg_btn_target,
                                    $class = $settings['mgpg_link_type'] ?? ''
                                );
                            }
                            ?>
                        </div>
                    <?php
                    }
                    if ($mgpg_post_btn && ($mgpg_post_style == '1' || $mgpg_post_style == '2')) {
                        mp_post_btn(
                            $text = $mgpg_btn_title,
                            $icon_show = $mgpg_usebtn_icon,
                            $icon = $settings['mgpg_btn_icon'],
                            $icon_position = $mgpg_btn_icon_position,
                            $target = $mgpg_btn_target,
                            $class = $settings['mgpg_link_type'] ?? ''
                        );
                    }

                    if ($mgpg_post_style == '2') {
                        mpd_posts_meta_author_date($settings['mgpg_author_show'], $settings['mgpg_date_show']);
                    }

                    mpd_post_tags($settings['mgpg_tag_show']);

                    ?>
                </div>

            </div>
        </div>
        <?php
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
        $mgpg_posts_count = absint($this->get_settings('mgpg_posts_count'));

        $mgpg_filter = $this->get_settings('mgpg_posts_filter');

        $mgpg_custom_order = $this->get_settings('mgpg_custom_order');
        $mgpg_grid_categories = $this->get_settings('mgpg_grid_categories');
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
            'posts_per_page'        => $mgpg_posts_count,
        );
        if ($mgpg_pagination_show) {
            $args['paged'] = $paged;
        }

        switch ($mgpg_filter) {

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
        if ($mgpg_filter === 'show_byid' && !empty($settings['mgpg_post_id'])) {
            $args['post__in'] = mp_display_resolve_post_ids($settings['mgpg_post_id'], $mgpg_post_type);
        } elseif ($mgpg_filter === 'show_byid_manually') {
            $post_ids = array_map('trim', explode(',', $settings['mgpg_post_ids_manually']));
            $args['post__in'] = mp_display_resolve_post_ids($post_ids, $mgpg_post_type);
        }


        // Custom Order
        if ($mgpg_custom_order == 'yes') {
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }

        if (!(($mgpg_filter == "show_byid") || ($mgpg_filter == "show_byid_manually"))) {

            $post_cats = str_replace(' ', '', $mgpg_grid_categories);
            if ("0" != $mgpg_grid_categories && $mgpg_post_type == 'post') {
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
        $mgpg_layout_type = $this->get_settings('mgpg_layout_type');
        $mgpg_masonry_style = $this->get_settings('mgpg_masonry_style');
        $mgpg_post_style = $this->get_settings('mgpg_post_style');
        $mgpg_rownumber = $this->get_settings('mgpg_rownumber');
        // grid content
        $mgpg_post_img_show = $this->get_settings('mgpg_post_img_show');
        $mgpg_show_title = $this->get_settings('mgpg_show_title');
        $mgpg_crop_title = $this->get_settings('mgpg_crop_title');
        $mgpg_title_tag = $this->get_settings('mgpg_title_tag');
        $mgpg_desc_show = $this->get_settings('mgpg_desc_show');
        $mgpg_crop_desc = $this->get_settings('mgpg_crop_desc');
        $mgpg_post_btn = $this->get_settings('mgpg_post_btn');
        $mgpg_category_show = $this->get_settings('mgpg_category_show');
        $mgpg_usebtn_icon = $this->get_settings('mgpg_usebtn_icon');
        $mgpg_btn_title = $this->get_settings('mgpg_btn_title');
        $mgpg_btn_target = $this->get_settings('mgpg_btn_target');
        $mgpg_btn_icon = $this->get_settings('mgpg_btn_icon');

        // Premium Features Settings (Pro Only)
        $mgpg_ajax_filter = $this->get_settings('mgpg_ajax_filter');
        $mgpg_infinite_scroll = $this->get_settings('mgpg_infinite_scroll');
        $mgpg_reading_time = $this->get_settings('mgpg_reading_time');
        $mgpg_view_count = $this->get_settings('mgpg_view_count');
        $mgpg_social_share = $this->get_settings('mgpg_social_share');
        $mgpg_hover_effects = $this->get_settings('mgpg_hover_effects');
        $mgpg_premium_features_style = $this->get_settings('mgpg_premium_features_style');
        $mgpg_media_source = $this->get_settings('mgpg_media_source');
        $mgpg_btn_icon_position = $this->get_settings('mgpg_btn_icon_position');

        // Apply post position settings
        $args = $this->apply_post_position_to_query($args, $settings, 'mgpg_posts_filter');

        $mgpg_posts = new WP_Query($args);

        if ($mgpg_posts->have_posts()) :

            if ($mgpg_rownumber == '12') {
                $column_set = 'mgp-col-lg-12';
            } else {
                $column_set = 'mgp-col-lg-' . $mgpg_rownumber . ' mgp-col-md-6';
            }

            // Add masonry specific classes
            $container_class = 'mgpd mgp-items style' . esc_attr($mgpg_post_style);
            $row_class = 'mgp-row';
            $item_class = $column_set;

            // Add premium feature classes
            if ($mgpg_ajax_filter === 'yes' && mp_display_check_main_ok()) {
                $container_class .= ' mgpd-ajax-filter-enabled';
            }
            if ($mgpg_infinite_scroll === 'yes' && mp_display_check_main_ok()) {
                $container_class .= ' mgpd-infinite-scroll';
            }
            if ($mgpg_hover_effects && $mgpg_hover_effects !== 'none' && mp_display_check_main_ok()) {
                $container_class .= ' mgpd-hover-' . esc_attr($mgpg_hover_effects);
            }
            // Add premium features style class
            if ($mgpg_premium_features_style && $mgpg_premium_features_style !== 'default' && mp_display_check_main_ok()) {
                $container_class .= ' mgpd-premium-' . esc_attr($mgpg_premium_features_style);
            }

            if ($mgpg_layout_type === 'masonry') {
                $masonry_style = $mgpg_masonry_style ? $mgpg_masonry_style : 'style1';
                $container_class .= ' mgpd-masonry-container mgpd-masonry-' . esc_attr($masonry_style);
                $row_class .= ' mgpd-masonry';
                $item_class .= ' mgpd-masonry-item';
            }
        ?>

            <?php
            // Premium Features - Category Filter (Pro Only) - Move to top
            if (mp_display_check_main_ok() && $mgpg_ajax_filter === 'yes' && $mgpg_post_type == 'post') {
                $categories = get_categories(array('hide_empty' => true));
                if (!empty($categories)) {
                    echo '<div class="mgpd-ajax-filter-container">';
                    echo '<div class="mgpd-filter-buttons">';
                    echo '<button class="mgpd-filter-btn active" data-category="all">' . __('All', 'magical-posts-display') . '</button>';
                    foreach ($categories as $category) {
                        echo '<button class="mgpd-filter-btn" data-category="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</button>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>

            <div id="mgp-items" class="<?php echo esc_attr($container_class); ?>">
                <div class="<?php echo esc_attr($row_class); ?>">
                    <?php while ($mgpg_posts->have_posts()) : $mgpg_posts->the_post(); ?>
                        <?php $this->render_single_post_item($settings, $item_class); ?>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                    wp_reset_postdata();
                    ?>
                </div>
            </div>

            <?php
            // Inline Masonry Initialization Script for better compatibility
            if ($mgpg_layout_type === 'masonry') {
                $widget_id = uniqid('mgpd_masonry_');
            ?>
                <script type="text/javascript">
                    (function() {
                        // Initialize masonry for this specific widget
                        function initMasonry<?php echo $widget_id; ?>() {
                            var container = document.querySelector('.mgpd-masonry-container');
                            if (container && typeof Masonry !== 'undefined' && typeof imagesLoaded !== 'undefined') {
                                var masonryGrid = container.querySelector('.mgpd-masonry');
                                if (masonryGrid) {
                                    // Force all images to load first
                                    imagesLoaded(masonryGrid, function() {
                                        // Clear any existing height to let masonry calculate properly
                                        masonryGrid.style.height = '';

                                        // Initialize masonry
                                        var masonry = new Masonry(masonryGrid, {
                                            itemSelector: '.mgpd-masonry-item',
                                            columnWidth: '.mgpd-masonry-item',
                                            percentPosition: true,
                                            transitionDuration: 0
                                        });

                                        // Store instance for global access
                                        window.mgpdMasonryInstance = masonry;

                                        // Force layout calculation after a brief delay
                                        setTimeout(function() {
                                            masonry.layout();
                                        }, 100);
                                    });
                                }
                            }
                        }

                        // Initialize when DOM is ready
                        if (document.readyState === 'loading') {
                            document.addEventListener('DOMContentLoaded', initMasonry<?php echo $widget_id; ?>);
                        } else {
                            initMasonry<?php echo $widget_id; ?>();
                        }

                        // Also initialize on window load as fallback
                        window.addEventListener('load', initMasonry<?php echo $widget_id; ?>);
                    })();
                </script>
            <?php
            }
            ?>

            <?php
            if ($mgpg_pagination_show) {
                mp_display_pagination($paged, $mgpg_posts, $settings['mgpg_pagination_style']);
            }
            ?>

            <?php
            // Premium Features JavaScript & HTML (Pro Only)
            if (mp_display_check_main_ok()) {

                // Infinite Scroll Trigger
                if ($mgpg_infinite_scroll === 'yes') {
                    echo '<div class="mgpd-infinite-scroll-trigger" style="height: 1px; margin-top: 50px;"></div>';
                    echo '<div class="mgpd-loading-spinner" style="display: none; text-align: center; padding: 20px;">';
                    echo $this->get_loading_spinner_icon(40);
                    echo '<span>' . __('Loading more posts...', 'magical-posts-display') . '</span>';
                    echo '</div>';
                }

                // Only localize script if any premium features are enabled
                if ($mgpg_ajax_filter === 'yes' || $mgpg_infinite_scroll === 'yes' || ($mgpg_hover_effects && $mgpg_hover_effects !== 'none')) {
                    // Convert switcher values to proper booleans for JS
                    $ajax_filter_bool = ($mgpg_ajax_filter === 'yes' && $mgpg_post_type == 'post');
                    $infinite_scroll_bool = ($mgpg_infinite_scroll === 'yes');
                    $hover_effects_bool = ($mgpg_hover_effects && $mgpg_hover_effects !== 'none');
                    
                    // Localize script data for JavaScript
                    wp_localize_script('mgpd-premium-features', 'mgpd_ajax', array(
                        'ajaxurl' => admin_url('admin-ajax.php'),
                        'nonce' => wp_create_nonce('mgpd_ajax_nonce'),
                        'settings' => $settings,
                        'layout_type' => $mgpg_layout_type,
                        'ajax_filter_enabled' => $ajax_filter_bool,
                        'infinite_scroll_enabled' => $infinite_scroll_bool,
                        'hover_effects_enabled' => $hover_effects_bool,
                        'current_page' => $paged,
                        'max_pages' => $mgpg_posts->max_num_pages,
                        'post_type' => $mgpg_post_type,
                        'texts' => array(
                            'error_loading' => __('Error loading posts. Please try again.', 'magical-posts-display'),
                            'loading_more' => __('Loading more posts...', 'magical-posts-display')
                        )
                    ));
                }
            }
            ?>

<?php else :
            mp_display_posts_not_found($settings['mgpg_post_type']);
        endif;
    }

    /**
     * AJAX handler for category filtering
     * Static method to be called from WordPress AJAX hooks
     */
    public static function ajax_filter_posts()
    {
        // Check nonce for security
        if (!isset($_POST['nonce']) || !wp_verify_nonce(wp_unslash($_POST['nonce']), 'mgpd_ajax_nonce')) {
            wp_die(__('Security check failed', 'magical-posts-display'));
        }

        // Check if pro version is active
        if (!mp_display_check_main_ok()) {
            wp_send_json_error(__('Premium feature requires pro version', 'magical-posts-display'));
        }

        $category = isset($_POST['category']) ? sanitize_text_field(wp_unslash($_POST['category'])) : '';
        $settings = isset($_POST['settings']) ? wp_unslash($_POST['settings']) : array();
        $post_type = isset($_POST['post_type']) ? sanitize_text_field(wp_unslash($_POST['post_type'])) : 'post';

        // Sanitize settings array - ensure it's an array
        if (!is_array($settings)) {
            $settings = array();
        }

        // Set default settings if not provided
        $default_settings = array(
            'mgpg_posts_count' => 6,
            'mgpg_rownumber' => '4',
            'mgpg_layout_type' => 'grid',
            'mgpg_post_style' => '1',
            'mgpg_post_type' => 'post',
            'mgpg_post_img_show' => 'yes',
            'mgpg_show_title' => 'yes',
            'mgpg_title_tag' => 'h3',
            'mgpg_crop_title' => '',
            'mgpg_desc_show' => 'yes',
            'mgpg_crop_desc' => '',
            'mgpg_post_btn' => 'yes',
            'mgpg_btn_title' => __('Read More', 'magical-posts-display'),
            'mgpg_usebtn_icon' => '',
            'mgpg_btn_icon_position' => 'right',
            'mgpg_btn_target' => '_self',
            'mgpg_category_show' => 'yes',
            'mgpg_date_show' => 'yes',
            'mgpg_author_show' => 'yes',
            'mgpg_media_source' => 'featured',
            'mgpg_premium_features_style' => 'default',
            'mgpg_reading_time' => '',
            'mgpg_view_count' => '',
            'mgpg_social_share' => '',
        );
        $settings = wp_parse_args($settings, $default_settings);

        // Build query args
        $args = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => isset($settings['mgpg_posts_count']) ? absint($settings['mgpg_posts_count']) : 6,
            'ignore_sticky_posts' => 1
        );

        // Add category filter if not "all"
        if ($category !== 'all' && $post_type === 'post') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category
                )
            );
        }

        $query = new WP_Query($args);
        $output = '';

        if ($query->have_posts()) {
            // Instantiate widget to reuse render method
            $widget = new self();

            // Calculate item class - consistent with render() method
            $mgpg_rownumber = isset($settings['mgpg_rownumber']) ? $settings['mgpg_rownumber'] : '4';
            $mgpg_layout_type = isset($settings['mgpg_layout_type']) ? $settings['mgpg_layout_type'] : 'grid';

            if ($mgpg_rownumber == '12') {
                $item_class = 'mgp-col-lg-12';
            } else {
                $item_class = 'mgp-col-lg-' . $mgpg_rownumber . ' mgp-col-md-6';
            }

            if ($mgpg_layout_type === 'masonry') {
                $item_class .= ' mgpd-masonry-item';
            }

            while ($query->have_posts()) {
                $query->the_post();
                ob_start();
                $widget->render_single_post_item($settings, $item_class);
                $output .= ob_get_clean();
            }
            wp_reset_postdata();
        }

        wp_send_json_success($output);
    }

    /**
     * AJAX handler for infinite scroll
     * Static method to be called from WordPress AJAX hooks
     */
    public static function ajax_infinite_scroll()
    {
        // Check nonce for security
        if (!isset($_POST['nonce']) || !wp_verify_nonce(wp_unslash($_POST['nonce']), 'mgpd_ajax_nonce')) {
            wp_die(__('Security check failed', 'magical-posts-display'));
        }

        // Check if pro version is active
        if (!mp_display_check_main_ok()) {
            wp_send_json_error(__('Premium feature requires pro version', 'magical-posts-display'));
        }

        $page = isset($_POST['page']) ? absint($_POST['page']) : 1;
        $settings = isset($_POST['settings']) ? wp_unslash($_POST['settings']) : array();
        $post_type = isset($_POST['post_type']) ? sanitize_text_field(wp_unslash($_POST['post_type'])) : 'post';

        // Sanitize settings array - ensure it's an array
        if (!is_array($settings)) {
            $settings = array();
        }

        // Set default settings if not provided
        $default_settings = array(
            'mgpg_posts_count' => 6,
            'mgpg_rownumber' => '4',
            'mgpg_layout_type' => 'grid',
            'mgpg_post_style' => '1',
            'mgpg_post_type' => 'post',
            'mgpg_post_img_show' => 'yes',
            'mgpg_show_title' => 'yes',
            'mgpg_title_tag' => 'h3',
            'mgpg_crop_title' => '',
            'mgpg_desc_show' => 'yes',
            'mgpg_crop_desc' => '',
            'mgpg_post_btn' => 'yes',
            'mgpg_btn_title' => __('Read More', 'magical-posts-display'),
            'mgpg_usebtn_icon' => '',
            'mgpg_btn_icon_position' => 'right',
            'mgpg_btn_target' => '_self',
            'mgpg_category_show' => 'yes',
            'mgpg_date_show' => 'yes',
            'mgpg_author_show' => 'yes',
            'mgpg_media_source' => 'featured',
            'mgpg_premium_features_style' => 'default',
            'mgpg_reading_time' => '',
            'mgpg_view_count' => '',
            'mgpg_social_share' => '',
        );
        $settings = wp_parse_args($settings, $default_settings);

        // Build query args
        $args = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => isset($settings['mgpg_posts_count']) ? absint($settings['mgpg_posts_count']) : 6,
            'paged' => $page,
            'ignore_sticky_posts' => 1
        );

        $query = new WP_Query($args);
        $output = '';

        if ($query->have_posts()) {
            // Instantiate widget
            $widget = new self();

            // Calculate item class - consistent with render() method
            $mgpg_rownumber = isset($settings['mgpg_rownumber']) ? $settings['mgpg_rownumber'] : '4';
            $mgpg_layout_type = isset($settings['mgpg_layout_type']) ? $settings['mgpg_layout_type'] : 'grid';

            if ($mgpg_rownumber == '12') {
                $item_class = 'mgp-col-lg-12';
            } else {
                $item_class = 'mgp-col-lg-' . $mgpg_rownumber . ' mgp-col-md-6';
            }

            if ($mgpg_layout_type === 'masonry') {
                $item_class .= ' mgpd-masonry-item';
            }

            while ($query->have_posts()) {
                $query->the_post();
                ob_start();
                $widget->render_single_post_item($settings, $item_class);
                $output .= ob_get_clean();
            }
            wp_reset_postdata();
        }
        wp_send_json_success($output);
    }
}
