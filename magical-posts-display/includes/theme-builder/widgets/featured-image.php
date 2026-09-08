<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Featured Image theme widget.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Featured_Image' ) ) {

	class Mgpd_Theme_Featured_Image extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgpd-theme-featured-image';
		}

		public function get_title() {
			return __( 'Featured Image', 'magical-posts-display' );
		}

		public function get_icon() {
			return 'eicon-single-image';
		}

		public function get_categories() {
			return [ 'mgpd-theme-single' ];
		}

		public function get_keywords() {
			return [ 'featured', 'image', 'thumbnail', 'post', 'photo', 'theme' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'content_section',
				[ 'label' => __( 'Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'link_to_post',
				[
					'label'     => __( 'Link to Post', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'image_size',
				[
					'label'   => __( 'Image Size', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'full',
					'options' => [
						'thumbnail' => __( 'Thumbnail', 'magical-posts-display' ),
						'medium'    => __( 'Medium', 'magical-posts-display' ),
						'large'     => __( 'Large', 'magical-posts-display' ),
						'full'      => __( 'Full', 'magical-posts-display' ),
					],
				]
			);

			$this->add_control(
				'open_lightbox',
				[
					'label'     => __( 'Lightbox', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'no',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
					'condition' => [
						'link_to_post!' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'image_align',
				[
					'label'     => __( 'Alignment', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::CHOOSE,
					'options'   => [
						'left'   => [
							'title' => __( 'Left', 'magical-posts-display' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'magical-posts-display' ),
							'icon'  => 'eicon-text-align-center',
						],
						'right'  => [
							'title' => __( 'Right', 'magical-posts-display' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'aspect_ratio',
				[
					'label'   => __( 'Aspect Ratio (Pro Only)', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' => __( 'Original / Default', 'magical-posts-display' ),
						'16-9'    => '16:9 (Landscape)',
						'4-3'     => '4:3 (Standard)',
						'1-1'     => '1:1 (Square)',
						'21-9'    => '21:9 (Ultrawide)',
					],
					'classes' => 'mpd-pro-control',
				]
			);

			$this->add_control(
				'fallback_image',
				[
					'label'       => __( 'Fallback Image (Pro Only)', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::MEDIA,
					'description' => __( 'Shown if the post does not have a featured image.', 'magical-posts-display' ),
					'classes'     => 'mpd-pro-control',
				]
			);

			$this->end_controls_section();

			// Style.
			$this->start_controls_section(
				'style_section',
				[
					'label' => __( 'Style', 'magical-posts-display' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_responsive_control(
				'image_width',
				[
					'label'      => __( 'Width', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ '%', 'px', 'vw' ],
					'range'      => [
						'%'  => [
							'min' => 10,
							'max' => 100,
						],
						'px' => [
							'min' => 50,
							'max' => 1200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-featured-image' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'image_height',
				[
					'label'      => __( 'Height', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vh' ],
					'range'      => [
						'px' => [
							'min' => 50,
							'max' => 1000,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-featured-image img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
					],
				]
			);

			$this->add_control(
				'image_fit',
				[
					'label'     => __( 'Object Fit', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''        => __( 'Default', 'magical-posts-display' ),
						'cover'   => __( 'Cover', 'magical-posts-display' ),
						'contain' => __( 'Contain', 'magical-posts-display' ),
						'fill'    => __( 'Fill', 'magical-posts-display' ),
					],
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-featured-image img' => 'object-fit: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'border_radius',
				[
					'label'      => __( 'Border Radius', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-featured-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
						'{{WRAPPER}} .mgpd-theme-featured-image a'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'image_shadow',
					'selector' => '{{WRAPPER}} .mgpd-theme-featured-image img',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'image_hover_shadow',
					'label'    => __( 'Hover Shadow', 'magical-posts-display' ),
					'selector' => '{{WRAPPER}} .mgpd-theme-featured-image:hover img',
				]
			);

			$this->add_responsive_control(
				'image_spacing',
				[
					'label'      => __( 'Spacing', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-featured-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$post_id = get_the_ID();

			if ( ! $post_id ) {
				mgpd_theme_demo( 'image' );
				return;
			}

			$settings    = $this->get_settings_for_display();
			$image_size  = ! empty( $settings['image_size'] ) ? $settings['image_size'] : 'full';
			$thumb_id    = get_post_thumbnail_id( $post_id );

			// Check Pro fallback image if no post thumbnail
			if ( ! $thumb_id && mp_display_check_main_ok() && ! empty( $settings['fallback_image']['id'] ) ) {
				$thumb_id = absint( $settings['fallback_image']['id'] );
			}

			if ( ! $thumb_id ) {
				mgpd_theme_demo( 'image' );
				return;
			}

			$image_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
			$image_alt = $image_alt ? $image_alt : get_the_title( $post_id );

			// Responsive markup with srcset/sizes + lazy loading.
			$image_html = wp_get_attachment_image( $thumb_id, $image_size, false, [
				'alt'      => esc_attr( $image_alt ),
				'loading'  => 'lazy',
			] );

			if ( ! $image_html ) {
				mgpd_theme_demo( 'image' );
				return;
			}

			if ( 'yes' === $settings['link_to_post'] ) {
				$image_html = '<a href="' . esc_url( get_permalink( $post_id ) ) . '">' . $image_html . '</a>';
			} elseif ( 'yes' === $settings['open_lightbox'] ) {
				$lightbox_url = wp_get_attachment_image_url( $thumb_id, 'full' );
				$this->add_render_attribute( 'lightbox', [
					'href'            => esc_url( $lightbox_url ),
					'data-elementor-open-lightbox' => 'yes',
					'data-elementor-lightbox-slideshow' => $this->get_id(),
				] );
				$image_html = '<a ' . $this->get_render_attribute_string( 'lightbox' ) . '>' . $image_html . '</a>';
			}

			$wrapper_classes = [ 'mgpd-theme-featured-image' ];
			if ( mp_display_check_main_ok() && ! empty( $settings['aspect_ratio'] ) && 'default' !== $settings['aspect_ratio'] ) {
				$wrapper_classes[] = 'has-aspect-ratio ratio-' . sanitize_html_class( $settings['aspect_ratio'] );
			}

			printf( '<div class="%s">%s</div>', esc_attr( implode( ' ', $wrapper_classes ) ), $image_html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}
