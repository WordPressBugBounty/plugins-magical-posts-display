<?php


class mgpdEPostsTicker extends \Elementor\Widget_Base
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
        return 'mgposts_ticker';
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
        return __('Magical Posts Ticker', 'magical-posts-display');
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
        return 'eicon-posts-ticker';
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
        return ['magic', 'post', 'ticker', 'posts', 'category'];
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
            'mgptik_query',
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
            'mgptik_posts_filter',
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
            'mgptik_post_id',
            [
                'label' => __('Select posts', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_posts_name(),
                'condition' => [
                    'mgptik_posts_filter' => 'show_byid',
                    'mgpla_post_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'mgptik_post_ids_manually',
            [
                'label' => __('posts IDs', 'magical-posts-display'),
                'description' => __('Separate IDs with commas', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'mgptik_posts_filter' => 'show_byid_manually',
                ]
            ]
        );

        $this->add_control(
            'mgptik_posts_count',
            [
                'label'   => __('posts Limit', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 10,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'mgptik_grid_categories',
            [
                'label' => esc_html__('posts Categories', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mp_display_taxonomy_list(),
                'condition' => [
                    'mgptik_posts_filter!' => 'show_byid',
                    'mgpla_post_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'mgptik_custom_order',
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
                    'mgptik_custom_order' => 'yes',
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
                    'mgptik_custom_order' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgptik_text',
            [
                'label' => esc_html__('Ticker Text', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgptik_head_text',
            [
                'label'       => __('Ticker Header Text', 'magical-posts-display'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Latest News', 'magical-posts-display'),
                'default'     => __('Latest News', 'magical-posts-display'),
            ]
        );
        $this->add_responsive_control(
            'mgptik_head_width',
            [
                'label' => __('Header Width', 'magical-posts-display'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpticker .mgpticker-text' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgpd-left .mgpd-sticker ul' => 'padding-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgpd-right .mgpd-sticker ul' => 'padding-right: {{SIZE}}{{UNIT}};',

                ],
            ]
        );

        $this->add_control(
            'mgptik_linking_text',
            [
                'label' => __('Add Post Link', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgptik_link_terget',
            [
                'label'   => __('Link Open', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '_self',
                'options' => [
                    '_self'   => __('Same Tab', 'magical-posts-display'),
                    '_blank'  => __('New Tab', 'magical-posts-display'),

                ],
                'condition' => [
                    'mgptik_linking_text' => 'yes',
                ]
            ]
        );
        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgptik_content',
            [
                'label' => esc_html__('Ticker Options', 'magical-posts-display'),
            ]
        );


        $this->add_control(
            'mgptik_pause_mouse',
            [
                'label'     => __('Pause On Mouse Hover', 'magical-posts-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgptik_direction',
            [
                'label'   => __('Ticker Direction', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'up',
                'options' => [
                    'up'   => __('Up', 'magical-posts-display'),
                    'down'  => __('Down', 'magical-posts-display'),

                ]
            ]
        );
        $this->add_control(
            'mgptik_text_position',
            [
                'label'   => __('Text Position', 'magical-posts-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'   => __('Left', 'magical-posts-display'),
                    'right'  => __('Right', 'magical-posts-display'),

                ]
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
            'mgptik_style',
            [
                'label' => __('Ticker style', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgptik_padding',
            [
                'label' => __('Padding', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd.mgpticker' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgptik_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd.mgpticker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgptik_bg_color',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .mgpd.mgpticker',
            ]
        );

        $this->add_control(
            'mgptik_border_radius',
            [
                'label' => __('Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpd.mgpticker' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgptik_content_border',
                'selector' => '{{WRAPPER}} .mgpd.mgpticker',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgptik_content_shadow',
                'selector' => '{{WRAPPER}} .mgpd.mgpticker',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgptik_hed_style',
            [
                'label' => __('Ticker Header', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgptik_hed_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpticker .mgpticker-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgptik_hed_bgcolor',
                'label' => esc_html__('Background', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpticker .mgpticker-text',
            ]
        );
        $this->add_control(
            'mgptik_descb_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpticker .mgpticker-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgptik_hed_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpticker .mgpticker-text',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgptik_text_style',
            [
                'label' => __('Ticker Text', 'magical-posts-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgptik_text_margin',
            [
                'label' => __('Margin', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpticker ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgptik_text_color',
            [
                'label' => __('Text Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpticker ul li a,{{WRAPPER}} .mgpticker ul li' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgptik_text_bgcolor',
            [
                'label' => __('Background Color', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpticker ul li' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgptik_text_radius',
            [
                'label' => __('Border Radius', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpticker ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgptik_text_typography',
                'label' => __('Typography', 'magical-posts-display'),
                'selector' => '{{WRAPPER}} .mgpticker ul li a',
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
        $mgptik_posts_count = absint($this->get_settings('mgptik_posts_count'));

        $mgptik_filter = $this->get_settings('mgptik_posts_filter');
        $mgptik_custom_order = $this->get_settings('mgptik_custom_order');
        $mgptik_grid_categories = $this->get_settings('mgptik_grid_categories');
        $orderby = $this->get_settings('orderby');
        $order = $this->get_settings('order');


        // Query Argument
        $args = array(
            'post_type'             => $mgpla_post_type,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $mgptik_posts_count,
        );

        switch ($mgptik_filter) {


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

        if ($mgptik_filter === 'show_byid' && !empty($settings['mgptik_post_id'])) {
            $args['post__in'] = array_map('absint', $settings['mgptik_post_id']);
        } elseif ($mgptik_filter === 'show_byid_manually') {
            $post_ids = array_map('absint', explode(',', $settings['mgptik_post_ids_manually']));
            $args['post__in'] = array_filter($post_ids);
        }

        // Custom Order
        if ($mgptik_custom_order == 'yes') {
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }

        if (!(($mgptik_filter == "show_byid") || ($mgptik_filter == "show_byid_manually"))) {

            $post_cats = str_replace(' ', '', $mgptik_grid_categories);
            if ("0" != $mgptik_grid_categories && $mgpla_post_type == 'post') {
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
        $mgptik_head_text = $this->get_settings('mgptik_head_text');
        $mgptik_direction = $this->get_settings('mgptik_direction');
        $mgptik_pause_mouse = $this->get_settings('mgptik_pause_mouse');
        $mgptik_text_position = $this->get_settings('mgptik_text_position');
        // grid content
        $mgptik_linking_text = $this->get_settings('mgptik_linking_text');
        $mgptik_link_terget = $this->get_settings('mgptik_link_terget');

        $mgptik_mouse_pause = $mgptik_pause_mouse ? true : false;



        $rand_num = wp_rand(987564, 365298);

        $mgptik_posts = new WP_Query($args);
        if ($mgptik_posts->have_posts()) :
?>

            <div class="mgpd mgpticker mgticker<?php echo esc_attr($rand_num); ?> mgpd-<?php echo esc_attr($mgptik_text_position); ?>">

                <span class="mgpticker-text"><?php echo esc_html($mgptik_head_text); ?></span>
                <div class="mgpd-ticker mgpd-sticker mptickers" data-direction="<?php echo esc_attr($mgptik_direction); ?>" data-pause="<?php echo esc_attr($mgptik_mouse_pause); ?>">
                    <ul>
                        <?php while ($mgptik_posts->have_posts()) : $mgptik_posts->the_post(); ?>

                            <?php if ($mgptik_linking_text) : ?>
                                <li><a href="<?php the_permalink(); ?>" target="<?php echo esc_attr($mgptik_link_terget); ?>"><?php the_title(); ?></a></li>
                            <?php else : ?>
                                <li><?php the_title(); ?></li>
                            <?php endif; ?>


                        <?php
                        endwhile;
                        wp_reset_query();
                        wp_reset_postdata();
                        ?>
                    </ul>

                </div>
            </div>

<?php else :
            mp_display_posts_not_found($settings['mgpla_post_type']);
        endif;
    }
}
