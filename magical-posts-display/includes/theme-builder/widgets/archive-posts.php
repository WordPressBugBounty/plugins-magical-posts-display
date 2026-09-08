<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Posts theme widget.
 * Enhanced version with Grid (static/masonry) and List styles
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Archive_Posts' ) ) {

	class Mgpd_Theme_Archive_Posts extends \Elementor\Widget_Base {

		use Advanced_Media_Trait;
		use Premium_Features_Trait;

		public function get_name() {
			return 'mgpd-theme-archive-posts';
		}

		public function get_title() {
			return __( 'Blog / Archive Posts', 'magical-posts-display' );
		}

		public function get_icon() {
			return 'eicon-posts-archive';
		}

		public function get_categories() {
			return [ 'mgpd-theme-archive' ];
		}

		public function get_keywords() {
			return [ 'archive', 'posts', 'loop', 'grid', 'list', 'masonry', 'blog', 'theme' ];
		}

		protected function register_controls() {
			$this->register_layout_controls();
			$this->register_query_controls();
			$this->register_content_controls();
			$this->register_pagination_controls();
			$this->register_style_controls();
		}

		protected function register_layout_controls() {
			$this->start_controls_section(
				'layout_section',
				[ 'label' => __( 'Layout Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'display_style',
				[
					'label'   => __( 'Display Style', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'grid',
					'options' => [
						'grid' => __( 'Grid', 'magical-posts-display' ),
						'list' => __( 'List', 'magical-posts-display' ),
					],
				]
			);

			// Grid Layout Type
			$this->add_control(
				'grid_layout_type',
				[
					'label'   => __( 'Grid Layout Type', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'static',
					'options' => [
						'static'  => __( 'Fixed Height Grid', 'magical-posts-display' ),
						'masonry' => __( 'Masonry Grid (Pro Only)', 'magical-posts-display' ),
					],
					'condition' => [
						'display_style' => 'grid',
					],
					'description' => __( 'Fixed height creates uniform cards. Masonry creates Pinterest-style layout.', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'masonry_style',
				[
					'label'   => __( 'Masonry Style', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'style1',
					'options' => [
						'style1' => __( 'Style 1 - Default Heights', 'magical-posts-display' ),
						'style2' => __( 'Style 2 - Alternating Heights', 'magical-posts-display' ),
						'style3' => __( 'Style 3 - Pattern Heights', 'magical-posts-display' ),
					],
					'condition' => [
						'display_style' => 'grid',
						'grid_layout_type' => 'masonry',
					],
					'classes' => 'mpd-pro-control',
				]
			);

			$this->add_control(
				'grid_style',
				[
					'label'   => __( 'Grid Style', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => '1',
					'options' => [
						'1' => __( 'Style One', 'magical-posts-display' ),
						'2' => __( 'Style Two', 'magical-posts-display' ),
						'3' => __( 'Style Three', 'magical-posts-display' ),
					],
					'condition' => [
						'display_style' => 'grid',
					],
				]
			);

			$this->add_control(
				'list_style',
				[
					'label'   => __( 'List Style', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => '1',
					'options' => [
						'1' => __( 'Style One', 'magical-posts-display' ),
						'2' => __( 'Style Two', 'magical-posts-display' ),
						'3' => __( 'Style Three', 'magical-posts-display' ),
					],
					'condition' => [
						'display_style' => 'list',
					],
				]
			);

			$this->add_control(
				'columns',
				[
					'label'   => __( 'Columns (Desktop)', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => '4',
					'options' => [
						'12' => '1',
						'6'  => '2',
						'4'  => '3',
						'3'  => '4',
						'2'  => '6',
					],
					'condition' => [
						'display_style' => 'grid',
					],
				]
			);

			$this->add_control(
				'columns_tablet',
				[
					'label'   => __( 'Columns (Tablet)', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => '6',
					'options' => [
						'12' => '1',
						'6'  => '2',
						'4'  => '3',
						'3'  => '4',
					],
					'condition' => [
						'display_style' => 'grid',
					],
				]
			);

			$this->add_control(
				'columns_mobile',
				[
					'label'   => __( 'Columns (Mobile)', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => '12',
					'options' => [
						'12' => '1',
						'6'  => '2',
					],
					'condition' => [
						'display_style' => 'grid',
					],
				]
			);

			$this->add_control(
				'list_img_position',
				[
					'label' => __( 'Image Position', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'magical-posts-display' ),
							'icon' => 'eicon-arrow-left',
						],
						'right' => [
							'title' => __( 'Right', 'magical-posts-display' ),
							'icon' => 'eicon-arrow-right',
						],
					],
					'default' => 'left',
					'toggle' => false,
					'condition' => [
						'display_style' => 'list',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function register_query_controls() {
			$this->start_controls_section(
				'query_section',
				[ 'label' => __( 'Query Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'posts_per_page',
				[
					'label'   => __( 'Posts Per Page', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 10,
					'min'     => 1,
					'max'     => 50,
				]
			);

			$this->end_controls_section();
		}

		protected function register_content_controls() {
			$this->start_controls_section(
				'content_section',
				[ 'label' => __( 'Content Settings', 'magical-posts-display' ) ]
			);

			// Image
			$this->add_control(
				'show_thumbnail',
				[
					'label'     => __( 'Show Thumbnail', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'media_source',
				[
					'label' => __( 'Advanced Media Source (Pro Only)', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'featured' => __( 'Featured Image Only', 'magical-posts-display' ),
						'content' => __( 'First Content Image (Pro Only)', 'magical-posts-display' ),
						'video' => __( 'Video Embed (YouTube/Vimeo) (Pro Only)', 'magical-posts-display' ),
						'priority' => __( 'Priority Fallback (Pro Only)', 'magical-posts-display' ),
					],
					'default' => 'featured',
					'description' => __( 'Choose media source with priority fallback system', 'magical-posts-display' ),
					'classes' => 'mpd-pro-control',
					'condition' => [
						'show_thumbnail' => 'yes',
					],
				]
			);

			$this->add_control(
				'media_priority',
				[
					'label' => __( 'Priority Order (Pro Only)', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => [
						'video' => __( 'Video Embed', 'magical-posts-display' ),
						'featured' => __( 'Featured Image', 'magical-posts-display' ),
						'content' => __( 'First Content Image', 'magical-posts-display' ),
						'placeholder' => __( 'Placeholder Image', 'magical-posts-display' ),
					],
					'default' => ['video', 'featured', 'content', 'placeholder'],
					'description' => __( 'Set priority order for media fallback', 'magical-posts-display' ),
					'classes' => 'mpd-pro-control',
					'condition' => [
						'show_thumbnail' => 'yes',
						'media_source' => 'priority',
					],
				]
			);

			$this->add_control(
				'video_play_icon',
				[
					'label' => __( 'Show Video Play Icon', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'default' => 'yes',
					'classes' => 'mpd-pro-control',
					'condition' => [
						'show_thumbnail' => 'yes',
						'media_source' => ['video', 'priority'],
					],
				]
			);

			// Title
			$this->add_control(
				'show_title',
				[
					'label'     => __( 'Show Title', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'title_tag',
				[
					'label' => __( 'Title HTML Tag', 'magical-posts-display' ),
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
					'condition' => [
						'show_title' => 'yes',
					],
				]
			);

			$this->add_control(
				'crop_title',
				[
					'label'   => __( 'Crop Title By Word', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 10,
					'min'     => 1,
					'max'     => 50,
					'condition' => [
						'show_title' => 'yes',
					],
				]
			);

			// Category
			$this->add_control(
				'show_category',
				[
					'label'     => __( 'Show Category', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'cat_type',
				[
					'label' => __( 'Show Categories', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'one',
					'options' => [
						'one' => __( 'One', 'magical-posts-display' ),
						'all' => __( 'All', 'magical-posts-display' ),
					],
					'condition' => [
						'show_category' => 'yes',
					],
				]
			);

			// Meta
			$this->add_control(
				'show_author',
				[
					'label'     => __( 'Show Author', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'show_date',
				[
					'label'     => __( 'Show Date', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
				]
			);

			$this->add_control(
				'show_comments',
				[
					'label'     => __( 'Show Comment Count', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => '',
				]
			);

			// Excerpt
			$this->add_control(
				'show_excerpt',
				[
					'label'     => __( 'Show Excerpt', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'excerpt_length',
				[
					'label'   => __( 'Excerpt Length (words)', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 20,
					'min'     => 5,
					'max'     => 100,
					'condition' => [
						'show_excerpt' => 'yes',
					],
				]
			);

			// Button
			$this->add_control(
				'show_button',
				[
					'label'     => __( 'Show Read More Button', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => '',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'button_text',
				[
					'label'   => __( 'Button Text', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Read More', 'magical-posts-display' ),
					'condition' => [
						'show_button' => 'yes',
					],
				]
			);

			$this->add_control(
				'button_icon',
				[
					'label' => __( 'Button Icon', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'condition' => [
						'show_button' => 'yes',
					],
				]
			);

			$this->add_control(
				'button_icon_position',
				[
					'label' => __( 'Icon Position', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'right',
					'options' => [
						'left' => __( 'Left', 'magical-posts-display' ),
						'right' => __( 'Right', 'magical-posts-display' ),
					],
					'condition' => [
						'show_button' => 'yes',
						'button_icon[value]!' => '',
					],
				]
			);

			// Tags
			$this->add_control(
				'show_tags',
				[
					'label'     => __( 'Show Tags', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => '',
					'separator' => 'before',
				]
			);

			// Premium Features
			$this->add_control(
				'reading_time',
				[
					'label' => __( 'Show Reading Time (Pro Only)', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'default' => '',
					'classes' => 'mpd-pro-control',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'view_count',
				[
					'label' => __( 'Show View Count (Pro Only)', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'default' => '',
					'classes' => 'mpd-pro-control',
				]
			);

			$this->add_control(
				'social_share',
				[
					'label' => __( 'Show Social Share (Pro Only)', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'default' => '',
					'classes' => 'mpd-pro-control',
				]
			);

			$this->add_control(
				'premium_features_style',
				[
					'label' => __( 'Premium Features Position', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' => __( 'Below Content', 'magical-posts-display' ),
						'image-top' => __( 'Image Top', 'magical-posts-display' ),
						'image-overlay' => __( 'Image Overlay', 'magical-posts-display' ),
					],
					'classes' => 'mpd-pro-control',
				]
			);

			// Alignment
			$this->add_responsive_control(
				'content_align',
				[
					'label' => __( 'Content Alignment', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'magical-posts-display' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'magical-posts-display' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'magical-posts-display' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'default' => 'left',
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-post-content' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function register_pagination_controls() {
			$this->start_controls_section(
				'pagination_section',
				[ 'label' => __( 'Pagination Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'pagination_type',
				[
					'label' => __( 'Pagination Type', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'numbers',
					'options' => [
						'numbers'   => __( 'Numbers (Standard)', 'magical-posts-display' ),
						'load_more' => __( 'AJAX Load More (Pro Only)', 'magical-posts-display' ),
						'infinite'  => __( 'Infinite Scroll (Pro Only)', 'magical-posts-display' ),
					],
				]
			);

			$this->add_control(
				'pagination_prev_text',
				[
					'label' => __( 'Previous Text', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '&laquo; Previous', 'magical-posts-display' ),
					'condition' => [
						'pagination_type' => 'numbers',
					],
				]
			);

			$this->add_control(
				'pagination_next_text',
				[
					'label' => __( 'Next Text', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Next &raquo;', 'magical-posts-display' ),
					'condition' => [
						'pagination_type' => 'numbers',
					],
				]
			);

			$this->add_control(
				'load_more_text',
				[
					'label' => __( 'Load More Button Text', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Load More', 'magical-posts-display' ),
					'condition' => [
						'pagination_type' => 'load_more',
					],
				]
			);

			$this->add_control(
				'infinite_loader_text',
				[
					'label' => __( 'Loading Text', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Loading...', 'magical-posts-display' ),
					'condition' => [
						'pagination_type' => 'infinite',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function register_style_controls() {
			// Card Style
			$this->start_controls_section(
				'card_style_section',
				[
					'label' => __( 'Card Style', 'magical-posts-display' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_responsive_control(
				'card_padding',
				[
					'label' => __( 'Padding', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .mgp-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'card_bg_color',
				[
					'label' => __( 'Background Color', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgp-card' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'card_border',
					'selector' => '{{WRAPPER}} .mgp-card',
				]
			);

			$this->add_responsive_control(
				'card_border_radius',
				[
					'label' => __( 'Border Radius', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .mgp-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'card_box_shadow',
					'selector' => '{{WRAPPER}} .mgp-card',
				]
			);

			$this->end_controls_section();

			// Image Style
			$this->start_controls_section(
				'image_style_section',
				[
					'label' => __( 'Image Style', 'magical-posts-display' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_thumbnail' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'image_height',
				[
					'label' => __( 'Image Height', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 600,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mp-post-img img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
					],
					'condition' => [
						'display_style' => 'grid',
						'grid_layout_type' => 'static',
					],
				]
			);

			$this->add_responsive_control(
				'list_image_width',
				[
					'label' => __( 'Image Width', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 500,
						],
						'%' => [
							'min' => 10,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mp-post-img' => 'flex: 0 0 {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'display_style' => 'list',
					],
				]
			);

			$this->add_responsive_control(
				'image_border_radius',
				[
					'label' => __( 'Border Radius', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .mp-post-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			// Title Style
			$this->start_controls_section(
				'title_style_section',
				[
					'label' => __( 'Title Style', 'magical-posts-display' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_title' => 'yes',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label'     => __( 'Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-post-title a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_hover_color',
				[
					'label'     => __( 'Hover Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-post-title a:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'selector' => '{{WRAPPER}} .mgpd-archive-post-title',
				]
			);

			$this->add_responsive_control(
				'title_spacing',
				[
					'label' => __( 'Bottom Spacing', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-post-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			// Meta Style
			$this->start_controls_section(
				'meta_style_section',
				[
					'label' => __( 'Meta Style', 'magical-posts-display' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'meta_color',
				[
					'label'     => __( 'Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mp-meta-items' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'meta_typography',
					'selector' => '{{WRAPPER}} .mp-meta-items',
				]
			);

			$this->add_responsive_control(
				'meta_spacing',
				[
					'label' => __( 'Bottom Spacing', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mp-meta-items' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			// Excerpt Style
			$this->start_controls_section(
				'excerpt_style_section',
				[
					'label' => __( 'Excerpt Style', 'magical-posts-display' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_excerpt' => 'yes',
					],
				]
			);

			$this->add_control(
				'excerpt_color',
				[
					'label'     => __( 'Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-post-excerpt' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'excerpt_typography',
					'selector' => '{{WRAPPER}} .mgpd-archive-post-excerpt',
				]
			);

			$this->add_responsive_control(
				'excerpt_spacing',
				[
					'label' => __( 'Bottom Spacing', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-post-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			// Button Style
			$this->start_controls_section(
				'button_style_section',
				[
					'label' => __( 'Button Style', 'magical-posts-display' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_button' => 'yes',
					],
				]
			);

			$this->start_controls_tabs( 'button_tabs' );

			$this->start_controls_tab(
				'button_normal_tab',
				[
					'label' => __( 'Normal', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'button_color',
				[
					'label' => __( 'Text Color', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mp-btn' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'button_bg_color',
				[
					'label' => __( 'Background Color', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mp-btn' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'button_hover_tab',
				[
					'label' => __( 'Hover', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'button_hover_color',
				[
					'label' => __( 'Text Color', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mp-btn:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'button_hover_bg_color',
				[
					'label' => __( 'Background Color', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mp-btn:hover' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'selector' => '{{WRAPPER}} .mp-btn',
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'button_padding',
				[
					'label' => __( 'Padding', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .mp-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'button_border',
					'selector' => '{{WRAPPER}} .mp-btn',
				]
			);

			$this->add_responsive_control(
				'button_border_radius',
				[
					'label' => __( 'Border Radius', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .mp-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			// Pagination Style
			$this->start_controls_section(
				'pagination_style_section',
				[
					'label' => __( 'Pagination Style', 'magical-posts-display' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_responsive_control(
				'pagination_spacing',
				[
					'label' => __( 'Top Spacing', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'pagination_align',
				[
					'label' => __( 'Alignment', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'magical-posts-display' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'magical-posts-display' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'magical-posts-display' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'default' => 'center',
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-pagination' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->start_controls_tabs( 'pagination_tabs' );

			$this->start_controls_tab(
				'pagination_normal_tab',
				[
					'label' => __( 'Normal', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'pagination_color',
				[
					'label' => __( 'Color', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-pagination a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'pagination_bg_color',
				[
					'label' => __( 'Background Color', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-pagination a' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'pagination_hover_tab',
				[
					'label' => __( 'Hover', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'pagination_hover_color',
				[
					'label' => __( 'Color', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-pagination a:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'pagination_hover_bg_color',
				[
					'label' => __( 'Background Color', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-pagination a:hover' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'pagination_active_tab',
				[
					'label' => __( 'Active', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'pagination_active_color',
				[
					'label' => __( 'Color', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-pagination .current' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'pagination_active_bg_color',
				[
					'label' => __( 'Background Color', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-pagination .current' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'pagination_typography',
					'selector' => '{{WRAPPER}} .mgpd-archive-pagination',
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'pagination_padding',
				[
					'label' => __( 'Padding', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-pagination a, {{WRAPPER}} .mgpd-archive-pagination .current' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'pagination_border_radius',
				[
					'label' => __( 'Border Radius', 'magical-posts-display' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-pagination a, {{WRAPPER}} .mgpd-archive-pagination .current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			$paged = max( 1, absint( get_query_var( 'paged' ) ), absint( get_query_var( 'page' ) ) );

			// Inherit the current archive context (category, tag, author,
			// search, date, post type, blog home) so the widget lists the
			// archive's own posts instead of every post on the site.
			$args = $this->build_archive_query_args( $settings, $paged );

			$query = new WP_Query( $args );

			if ( ! $query->have_posts() ) {
				echo '<p class="mgpd-no-posts">' . esc_html__( 'No posts found.', 'magical-posts-display' ) . '</p>';
				return;
			}

			$display_style = $settings['display_style'];
			$grid_layout_type = $settings['grid_layout_type'] ?? 'static';
			$pagination_type = $settings['pagination_type'] ?? 'numbers';
			if ( ( 'load_more' === $pagination_type || 'infinite' === $pagination_type ) && ! mp_display_check_main_ok() ) {
				$pagination_type = 'numbers';
			}

			// Build wrapper classes
			$wrapper_classes = [ 'mgpd-theme-archive-posts' ];

			if ( $display_style === 'grid' ) {
				$wrapper_classes[] = 'mgpd-grid-layout';
				$wrapper_classes[] = 'mgpd-grid-style-' . $settings['grid_style'];
				$wrapper_classes[] = 'mgpd-layout-' . $grid_layout_type;

				if ( $grid_layout_type === 'masonry' && mp_display_check_main_ok() ) {
					$wrapper_classes[] = 'mgpd-masonry-' . $settings['masonry_style'];
				}

				// Responsive columns
				$wrapper_classes[] = 'mgpd-col-' . $settings['columns'];
				$wrapper_classes[] = 'mgpd-col-tablet-' . $settings['columns_tablet'];
				$wrapper_classes[] = 'mgpd-col-mobile-' . $settings['columns_mobile'];
			} else {
				$wrapper_classes[] = 'mgpd-list-layout';
				$wrapper_classes[] = 'mgpd-list-style-' . $settings['list_style'];
				$wrapper_classes[] = 'mgpd-img-' . $settings['list_img_position'];
			}

			$wrapper_attributes = [
				'class'              => esc_attr( implode( ' ', $wrapper_classes ) ),
				'data-mgpd-archive'  => '1',
				'data-page'          => (string) $paged,
				'data-max'           => (string) $query->max_num_pages,
				'data-pagination'    => esc_attr( $pagination_type ),
				'data-query-args'    => esc_attr( wp_json_encode( $this->get_public_query_args( $args ) ) ),
				'data-widget-settings' => esc_attr( wp_json_encode( $this->get_public_widget_settings( $settings ) ) ),
			];

			printf(
				'<div %s>',
				$this->build_attribute_string( $wrapper_attributes )
			);

			while ( $query->have_posts() ) {
				$query->the_post();

				if ( $display_style === 'grid' ) {
					$this->render_grid_item( $settings );
				} else {
					$this->render_list_item( $settings );
				}
			}

			echo '</div>';

			// Pagination
			$this->render_pagination( $query, $settings );

			wp_reset_postdata();
		}

		/**
		 * Build the widget query args, inheriting the current archive query.
		 *
		 * @param array $settings Widget settings.
		 * @param int   $paged    Current page number.
		 * @return array WP_Query args.
		 */
		protected function build_archive_query_args( $settings, $paged = 1 ) {
			global $wp_query;

			$args = [];

			if ( $wp_query instanceof WP_Query && ( is_archive() || is_home() || is_search() ) ) {
				$allowed = [
					'post_type',
					'cat',
					'category_name',
					'tag',
					'tag_id',
					'tax_query',
					's',
					'year',
					'monthnum',
					'day',
					'author',
					'author_name',
					'orderby',
					'order',
				];

				foreach ( $allowed as $key ) {
					if ( isset( $wp_query->query_vars[ $key ] ) && '' !== $wp_query->query_vars[ $key ] && [] !== $wp_query->query_vars[ $key ] ) {
						$args[ $key ] = $wp_query->query_vars[ $key ];
					}
				}
			}

			$args['posts_per_page']     = absint( $settings['posts_per_page'] );
			$args['paged']              = max( 1, absint( $paged ) );
			$args['post_status']        = 'publish';
			$args['ignore_sticky_posts'] = 1;

			return $args;
		}

		/**
		 * Query arg keys safe to inherit from the main query / accept via AJAX.
		 *
		 * @return array
		 */
		protected function get_allowed_query_keys() {
			return [
				'post_type',
				'cat',
				'category_name',
				'tag',
				'tag_id',
				'tax_query',
				's',
				'year',
				'monthnum',
				'day',
				'author',
				'author_name',
				'orderby',
				'order',
			];
		}

		/**
		 * Widget setting keys the item renderers depend on.
		 *
		 * @return array
		 */
		protected function get_allowed_settings_keys() {
			return [
				'posts_per_page',
				'display_style',
				'grid_layout_type',
				'grid_style',
				'list_style',
				'list_img_position',
				'show_thumbnail',
				'media_source',
				'media_priority',
				'video_play_icon',
				'show_title',
				'title_tag',
				'crop_title',
				'show_category',
				'cat_type',
				'show_author',
				'show_date',
				'show_comments',
				'show_excerpt',
				'excerpt_length',
				'show_button',
				'button_text',
				'button_icon',
				'button_icon_position',
				'show_tags',
				'reading_time',
				'view_count',
				'social_share',
				'premium_features_style',
			];
		}

		/**
		 * Reduce query args to a safe whitelist for transport to AJAX.
		 *
		 * @param array $args Full query args.
		 * @return array Safe query args.
		 */
		protected function get_public_query_args( $args ) {
			$public = [];
			foreach ( $this->get_allowed_query_keys() as $key ) {
				if ( isset( $args[ $key ] ) ) {
					$public[ $key ] = $args[ $key ];
				}
			}

			return $public;
		}

		/**
		 * Reduce widget settings to the display options the item renderers use.
		 *
		 * @param array $settings Full widget settings.
		 * @return array Safe settings.
		 */
		protected function get_public_widget_settings( $settings ) {
			$public = [];
			foreach ( $this->get_allowed_settings_keys() as $key ) {
				$public[ $key ] = isset( $settings[ $key ] ) ? $settings[ $key ] : '';
			}

			return $public;
		}

		/**
		 * Escape an attribute array into an HTML attribute string.
		 *
		 * @param array $attributes Attribute => value pairs.
		 * @return string
		 */
		protected function build_attribute_string( $attributes ) {
			$output = [];

			foreach ( $attributes as $name => $value ) {
				$output[] = sprintf( '%s="%s"', $name, $value );
			}

			return implode( ' ', $output );
		}

		/**
		 * AJAX handler: render the next page of archive items.
		 */
		public static function ajax_load_more() {
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'mgpd_theme_nonce' ) ) {
				wp_send_json_error( __( 'Security check failed', 'magical-posts-display' ) );
			}

			$page          = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 0;
			$query_args    = isset( $_POST['query_args'] ) ? json_decode( wp_unslash( $_POST['query_args'] ), true ) : [];
			$raw_settings  = isset( $_POST['widget_settings'] ) ? json_decode( wp_unslash( $_POST['widget_settings'] ), true ) : [];

			if ( $page < 2 ) {
				wp_send_json_error( __( 'Invalid page number.', 'magical-posts-display' ) );
			}

			$query_args   = is_array( $query_args ) ? $query_args : [];
			$raw_settings = is_array( $raw_settings ) ? $raw_settings : [];

			$widget = new self();

			// Rebuild both payloads through the same whitelists used on render.
			$settings = $widget->get_public_widget_settings( $raw_settings );

			$args = $widget->build_archive_query_args( $settings, $page );

			$inherited = $widget->get_public_query_args( $query_args );
			foreach ( $inherited as $key => $value ) {
				$args[ $key ] = $value;
			}

			$args['paged']               = $page;
			$args['posts_per_page']      = max( 1, absint( $settings['posts_per_page'] ) );
			$args['post_status']         = 'publish';
			$args['ignore_sticky_posts'] = 1;

			$query = new WP_Query( $args );

			if ( ! $query->have_posts() ) {
				wp_send_json_success( [
					'html'     => '',
					'has_more' => false,
				] );
			}

			$display_style = ! empty( $settings['display_style'] ) ? $settings['display_style'] : 'grid';

			ob_start();
			while ( $query->have_posts() ) {
				$query->the_post();
				if ( $display_style === 'list' ) {
					$widget->render_list_item( $settings );
				} else {
					$widget->render_grid_item( $settings );
				}
			}
			wp_reset_postdata();
			$html = ob_get_clean();

			wp_send_json_success( [
				'html'     => $html,
				'has_more' => $page < (int) $query->max_num_pages,
			] );
		}

		protected function render_grid_item( $settings ) {
			$grid_style = $settings['grid_style'];
			$show_thumbnail = $settings['show_thumbnail'] === 'yes';
			$show_title = $settings['show_title'] === 'yes';
			$show_excerpt = $settings['show_excerpt'] === 'yes';
			$show_category = $settings['show_category'] === 'yes';
			$show_author = $settings['show_author'] === 'yes';
			$show_date = $settings['show_date'] === 'yes';
			$show_comments = $settings['show_comments'] === 'yes';
			$show_button = $settings['show_button'] === 'yes';
			$show_tags = $settings['show_tags'] === 'yes';

			// Premium features
			$reading_time = $settings['reading_time'] ?? false;
			$view_count = $settings['view_count'] ?? false;
			$social_share = $settings['social_share'] ?? false;
			$premium_features_style = $settings['premium_features_style'] ?? 'default';

			?>
			<div class="mgpd-archive-post-item">
				<div class="mgp-card mg-card mg-shadow mgp-mb-4">
					<?php if ( $show_thumbnail ) : ?>
						<div class="mp-post-img">
							<?php
							// Advanced Media Source (Pro)
							if ( mp_display_check_main_ok() && $settings['media_source'] !== 'featured' ) {
								$media_settings = [
									'mgpg_media_source' => $settings['media_source'],
									'mgpg_media_priority' => $settings['media_priority'] ?? ['video', 'featured', 'content', 'placeholder'],
									'mgpg_video_play_icon' => $settings['video_play_icon'] ?? 'yes'
								];
								echo $this->get_advanced_media( get_the_ID(), $media_settings );
							} else {
								mp_post_thumbnail( 'yes' );
							}

							// Premium features - Image Top
							if ( mp_display_check_main_ok() && $premium_features_style === 'image-top' ) {
								echo '<div class="mgpd-premium-features">';
								$this->render_premium_features_content( $reading_time, $view_count, $social_share );
								echo '</div>';
							}

							// Premium features - Image Overlay
							if ( mp_display_check_main_ok() && $premium_features_style === 'image-overlay' ) {
								echo '<div class="mgpd-premium-features">';
								$this->render_premium_features_content( $reading_time, $view_count, $social_share );
								echo '</div>';
							}
							?>
						</div>
					<?php endif; ?>

					<div class="mg-card-text mgp-card-body mgpd-archive-post-content">
						<?php
						// Style 3 - Author & Category at top
						if ( $grid_style == '3' ) :
							?>
							<div class="magical-post-authon-category">
								<?php
								if ( $show_author ) {
									mpd_posts_meta( 'yes', '', '' );
								}
								if ( $show_category ) {
									mp_post_cat_display( 'yes', $settings['cat_type'] ?? 'one' );
								}
								?>
							</div>
							<?php
						endif;

						// Style 1 & 2 - Category before title
						if ( $show_category && ( $grid_style == '1' || $grid_style == '2' ) ) {
							mp_post_cat_display( 'yes', $settings['cat_type'] ?? 'one', ', ' );
						}

						// Title
						if ( $show_title ) {
							mp_post_title( 'yes', $settings['title_tag'], $settings['crop_title'] );
						}

						// Style 1 - Meta after title
						if ( $grid_style == '1' ) {
							mpd_posts_meta( $show_author ? 'yes' : '', $show_date ? 'yes' : '', $show_comments ? 'yes' : '' );
						}

						// Excerpt
						if ( $show_excerpt ) :
							$excerpt = get_the_excerpt();
							$length  = absint( $settings['excerpt_length'] );
							$words   = explode( ' ', wp_strip_all_tags( $excerpt ) );

							if ( count( $words ) > $length ) {
								$words  = array_slice( $words, 0, $length );
								$excerpt = implode( ' ', $words ) . '&hellip;';
							}
							?>
							<div class="mgpd-archive-post-excerpt">
								<p><?php echo wp_kses_post( $excerpt ); ?></p>
							</div>
							<?php
						endif;

						// Premium Features Content
						if ( mp_display_check_main_ok() && ( !$premium_features_style || $premium_features_style === 'default' ) ) {
							$this->render_premium_features_content( $reading_time, $view_count, $social_share );
						}

						// Style 3 - Date & Button
						if ( $grid_style == '3' ) :
							?>
							<div class="mgp_there_style-time">
								<?php if ( $show_date ) : ?>
									<span>
										<i class="fa-regular fa-calendar-days"></i>
										<?php echo esc_html( get_the_date( 'd M Y' ) ); ?>
									</span>
								<?php endif; ?>
								<?php
								if ( $show_button ) {
									$this->render_button( $settings );
								}
								?>
							</div>
							<?php
						endif;

						// Style 1 & 2 - Button
						if ( $show_button && ( $grid_style == '1' || $grid_style == '2' ) ) {
							$this->render_button( $settings );
						}

						// Style 2 - Meta at bottom
						if ( $grid_style == '2' ) {
							mpd_posts_meta_author_date( $show_author ? 'yes' : '', $show_date ? 'yes' : '' );
						}

						// Tags
						if ( $show_tags ) {
							mpd_post_tags( 'yes' );
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}

		protected function render_list_item( $settings ) {
			$list_style = $settings['list_style'];
			$show_thumbnail = $settings['show_thumbnail'] === 'yes';
			$show_title = $settings['show_title'] === 'yes';
			$show_excerpt = $settings['show_excerpt'] === 'yes';
			$show_category = $settings['show_category'] === 'yes';
			$show_author = $settings['show_author'] === 'yes';
			$show_date = $settings['show_date'] === 'yes';
			$show_comments = $settings['show_comments'] === 'yes';
			$show_button = $settings['show_button'] === 'yes';
			$show_tags = $settings['show_tags'] === 'yes';

			// Premium features
			$reading_time = $settings['reading_time'] ?? false;
			$view_count = $settings['view_count'] ?? false;
			$social_share = $settings['social_share'] ?? false;
			$premium_features_style = $settings['premium_features_style'] ?? 'default';

			?>
			<div class="mgpd-archive-post-item mgpd-list-item">
				<div class="mgp-card mg-card mg-shadow mgp-mb-4">
					<?php if ( $show_thumbnail ) : ?>
						<div class="mp-post-img">
							<?php
							// Advanced Media Source (Pro)
							if ( mp_display_check_main_ok() && $settings['media_source'] !== 'featured' ) {
								$media_settings = [
									'mgpg_media_source' => $settings['media_source'],
									'mgpg_media_priority' => $settings['media_priority'] ?? ['video', 'featured', 'content', 'placeholder'],
									'mgpg_video_play_icon' => $settings['video_play_icon'] ?? 'yes'
								];
								echo $this->get_advanced_media( get_the_ID(), $media_settings );
							} else {
								mp_post_thumbnail( 'yes' );
							}

							// Premium features on image
							if ( mp_display_check_main_ok() && in_array( $premium_features_style, ['image-top', 'image-overlay'] ) ) {
								echo '<div class="mgpd-premium-features">';
								$this->render_premium_features_content( $reading_time, $view_count, $social_share );
								echo '</div>';
							}
							?>
						</div>
					<?php endif; ?>

					<div class="mg-card-text mgp-card-body mgpd-archive-post-content">
						<?php
						// Category
						if ( $show_category ) {
							mp_post_cat_display( 'yes', $settings['cat_type'] ?? 'one', ', ' );
						}

						// Title
						if ( $show_title ) {
							mp_post_title( 'yes', $settings['title_tag'], $settings['crop_title'] );
						}

						// Meta
						if ( $list_style == '1' ) {
							mpd_posts_meta( $show_author ? 'yes' : '', $show_date ? 'yes' : '', $show_comments ? 'yes' : '' );
						}

						// Excerpt
						if ( $show_excerpt ) :
							$excerpt = get_the_excerpt();
							$length  = absint( $settings['excerpt_length'] );
				$words   = explode( ' ', wp_strip_all_tags( $excerpt ) );

							if ( count( $words ) > $length ) {
								$words  = array_slice( $words, 0, $length );
								$excerpt = implode( ' ', $words ) . '&hellip;';
							}
							?>
							<div class="mgpd-archive-post-excerpt">
								<p><?php echo wp_kses_post( $excerpt ); ?></p>
							</div>
							<?php
						endif;

						// Premium Features Content
						if ( mp_display_check_main_ok() && ( !$premium_features_style || $premium_features_style === 'default' ) ) {
							$this->render_premium_features_content( $reading_time, $view_count, $social_share );
						}

						// Button
						if ( $show_button ) {
							$this->render_button( $settings );
						}

						// Style 2 - Meta at bottom
						if ( $list_style == '2' ) {
							mpd_posts_meta_author_date( $show_author ? 'yes' : '', $show_date ? 'yes' : '' );
						}

						// Tags
						if ( $show_tags ) {
							mpd_post_tags( 'yes' );
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}

		protected function render_button( $settings ) {
			$button_text = $settings['button_text'];
			$button_icon = $settings['button_icon'];
			$button_icon_position = $settings['button_icon_position'] ?? 'right';

			?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="mp-btn">
				<?php if ( ! empty( $button_icon['value'] ) && $button_icon_position === 'left' ) : ?>
					<span class="mp-btn-icon mp-btn-icon-left">
						<?php \Elementor\Icons_Manager::render_icon( $button_icon, [ 'aria-hidden' => 'true' ] ); ?>
					</span>
				<?php endif; ?>
				<span class="mp-btn-text"><?php echo esc_html( $button_text ); ?></span>
				<?php if ( ! empty( $button_icon['value'] ) && $button_icon_position === 'right' ) : ?>
					<span class="mp-btn-icon mp-btn-icon-right">
						<?php \Elementor\Icons_Manager::render_icon( $button_icon, [ 'aria-hidden' => 'true' ] ); ?>
					</span>
				<?php endif; ?>
			</a>
			<?php
		}

		protected function render_pagination( $query, $settings ) {
			if ( $query->max_num_pages <= 1 ) {
				return;
			}

			$pagination_type = $settings['pagination_type'] ?? 'numbers';
			$current_page    = max( 1, absint( get_query_var( 'paged' ) ), absint( get_query_var( 'page' ) ) );

			echo '<nav class="mgpd-archive-pagination" aria-label="' . esc_attr__( 'Posts navigation', 'magical-posts-display' ) . '">';

			if ( $pagination_type === 'load_more' ) {
				?>
				<button type="button" class="mgpd-load-more-btn mp-btn"
					data-mgpd-loadmore="1"
					data-target="[data-mgpd-archive]"
					data-page="<?php echo esc_attr( $current_page ); ?>"
					data-max="<?php echo esc_attr( $query->max_num_pages ); ?>">
					<span class="mgpd-load-more-text"><?php echo esc_html( $settings['load_more_text'] ?? __( 'Load More', 'magical-posts-display' ) ); ?></span>
				</button>
				<p class="mgpd-end-message" hidden><?php echo esc_html__( 'You have reached the end.', 'magical-posts-display' ); ?></p>
				<?php
			} elseif ( $pagination_type === 'infinite' ) {
				?>
				<div class="mgpd-infinite-sentinel"
					data-mgpd-infinite="1"
					data-target="[data-mgpd-archive]"
					data-page="<?php echo esc_attr( $current_page ); ?>"
					data-max="<?php echo esc_attr( $query->max_num_pages ); ?>"></div>
				<div class="mgpd-infinite-loader">
					<span class="mgpd-loader-text"><?php echo esc_html( $settings['infinite_loader_text'] ?? __( 'Loading...', 'magical-posts-display' ) ); ?></span>
				</div>
				<p class="mgpd-end-message" hidden><?php echo esc_html__( 'You have reached the end.', 'magical-posts-display' ); ?></p>
				<?php
			} else {
				$pagination = paginate_links( [
					'total'     => $query->max_num_pages,
					'current'   => $current_page,
					'prev_text' => $settings['pagination_prev_text'] ?? '',
					'next_text' => $settings['pagination_next_text'] ?? '',
					'type'      => 'array',
				] );

				if ( $pagination ) {
					echo '<ul>';
					foreach ( $pagination as $link ) {
						echo '<li>' . wp_kses_post( $link ) . '</li>';
					}
					echo '</ul>';
				}
			}

			echo '</nav>';
		}
	}
}
