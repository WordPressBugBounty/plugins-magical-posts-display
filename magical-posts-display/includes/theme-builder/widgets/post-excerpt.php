<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post Excerpt theme widget.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Post_Excerpt' ) ) {

	class Mgpd_Theme_Post_Excerpt extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgpd-theme-post-excerpt';
		}

		public function get_title() {
			return __( 'Post Excerpt', 'magical-posts-display' );
		}

		public function get_icon() {
			return 'eicon-text';
		}

		public function get_categories() {
			return [ 'mgpd-theme-single' ];
		}

		public function get_keywords() {
			return [ 'post', 'excerpt', 'summary', 'description', 'theme' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'content_section',
				[ 'label' => __( 'Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'excerpt_length',
				[
					'label'       => __( 'Excerpt Length', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'default'     => 25,
					'min'         => 5,
					'max'         => 100,
					'description' => __( 'Number of words to show.', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'more_text',
				[
					'label'   => __( 'More Text', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '&hellip;',
				]
			);

			$this->add_control(
				'show_read_more',
				[
					'label'     => __( 'Show Read More Link', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'no',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'read_more_text',
				[
					'label'     => __( 'Read More Text', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::TEXT,
					'default'   => __( 'Read More', 'magical-posts-display' ),
					'condition' => [
						'show_read_more' => 'yes',
					],
				]
			);

			$this->add_control(
				'fade_out',
				[
					'label'       => __( 'Fade Out Effect', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'default'     => '',
					'label_on'    => __( 'Yes', 'magical-posts-display' ),
					'label_off'   => __( 'No', 'magical-posts-display' ),
					'classes'     => 'mpd-pro-control',
					'description' => __( 'Fade out the excerpt smoothly towards the bottom (Pro Feature).', 'magical-posts-display' ),
				]
			);

			$this->end_controls_section();

			// Style tab.
			$this->start_controls_section(
				'style_section',
				[
					'label' => __( 'Style', 'magical-posts-display' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'text_color',
				[
					'label'     => __( 'Text Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-excerpt' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'text_typography',
					'selector' => '{{WRAPPER}} .mgpd-theme-post-excerpt',
				]
			);

			$this->add_responsive_control(
				'text_spacing',
				[
					'label'      => __( 'Spacing', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'text_alignment',
				[
					'label'     => __( 'Alignment', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::CHOOSE,
					'options'   => [
						'left'    => [
							'title' => __( 'Left', 'magical-posts-display' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center'  => [
							'title' => __( 'Center', 'magical-posts-display' ),
							'icon'  => 'eicon-text-align-center',
						],
						'right'   => [
							'title' => __( 'Right', 'magical-posts-display' ),
							'icon'  => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => __( 'Justify', 'magical-posts-display' ),
							'icon'  => 'eicon-text-align-justify',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-excerpt' => 'text-align: {{VALUE}};',
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();

			// Read More Style.
			$this->start_controls_section(
				'read_more_style',
				[
					'label'     => __( 'Read More', 'magical-posts-display' ),
					'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_read_more' => 'yes',
					],
				]
			);

			$this->add_control(
				'read_more_color',
				[
					'label'     => __( 'Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-read-more-link' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'read_more_hover_color',
				[
					'label'     => __( 'Hover Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-read-more-link:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'read_more_typography',
					'selector' => '{{WRAPPER}} .mgpd-read-more-link',
				]
			);

			$this->add_responsive_control(
				'read_more_spacing',
				[
					'label'      => __( 'Spacing', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-read-more-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$post_id = get_the_ID();

			if ( ! $post_id ) {
				mgpd_theme_demo( 'excerpt' );
				return;
			}

			$settings = $this->get_settings_for_display();
			$excerpt  = get_the_excerpt( $post_id );

			if ( empty( $excerpt ) ) {
				mgpd_theme_demo( 'excerpt' );
				return;
			}

			$length = ! empty( $settings['excerpt_length'] ) ? absint( $settings['excerpt_length'] ) : 25;
			$words  = explode( ' ', wp_strip_all_tags( $excerpt ) );

			if ( count( $words ) > $length ) {
				$words  = array_slice( $words, 0, $length );
				$excerpt = implode( ' ', $words );
				$more    = ! empty( $settings['more_text'] ) ? ' ' . wp_kses_post( $settings['more_text'] ) : '';
				$excerpt .= $more;
			}

			$classes = [ 'mgpd-theme-post-excerpt' ];
			if ( function_exists( 'mp_display_check_main_ok' ) && mp_display_check_main_ok() && 'yes' === ( $settings['fade_out'] ?? '' ) ) {
				$classes[] = 'has-fade-out';
			}

			echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . wp_kses_post( $excerpt );

			if ( 'yes' === $settings['show_read_more'] ) {
				$read_more_text = ! empty( $settings['read_more_text'] ) ? esc_html( $settings['read_more_text'] ) : __( 'Read More', 'magical-posts-display' );
				echo ' <a href="' . esc_url( get_permalink( $post_id ) ) . '" class="mgpd-read-more-link">' . $read_more_text . '</a>';
			}

			echo '</div>';
		}
	}
}
