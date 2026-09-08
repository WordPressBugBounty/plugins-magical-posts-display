<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post Comments theme widget.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Post_Comments' ) ) {

	class Mgpd_Theme_Post_Comments extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgpd-theme-post-comments';
		}

		public function get_title() {
			return __( 'Post Comments', 'magical-posts-display' );
		}

		public function get_icon() {
			return 'eicon-comments';
		}

		public function get_categories() {
			return [ 'mgpd-theme-single' ];
		}

		public function get_keywords() {
			return [ 'post', 'comments', 'discussion', 'replies', 'theme' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'content_section',
				[ 'label' => __( 'Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'show_comments_form',
				[
					'label'     => __( 'Show Comments Form', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'no_comments_text',
				[
					'label'   => __( 'No Comments Text', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Comments are closed.', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'custom_form_style',
				[
					'label'       => __( 'Modern Form Styling', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'default'     => '',
					'label_on'    => __( 'Yes', 'magical-posts-display' ),
					'label_off'   => __( 'No', 'magical-posts-display' ),
					'classes'     => 'mpd-pro-control',
					'description' => __( 'Apply modern sleek design to the comment form inputs and submit button (Pro Feature).', 'magical-posts-display' ),
				]
			);

			$this->end_controls_section();

			// Style
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
						'{{WRAPPER}} .mgpd-theme-post-comments' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'link_color',
				[
					'label'     => __( 'Link Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-comments a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'link_hover_color',
				[
					'label'     => __( 'Link Hover Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-comments a:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'text_typography',
					'selector' => '{{WRAPPER}} .mgpd-theme-post-comments',
				]
			);

			$this->add_responsive_control(
				'spacing',
				[
					'label'      => __( 'Spacing', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-post-comments' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'padding',
				[
					'label'      => __( 'Padding', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-post-comments' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .mgpd-theme-post-comments' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'background_color',
				[
					'label'     => __( 'Background Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-comments' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->end_controls_section();

			// No Comments Style
			$this->start_controls_section(
				'no_comments_style',
				[
					'label' => __( 'No Comments Message', 'magical-posts-display' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'no_comments_color',
				[
					'label'     => __( 'Text Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-no-comments' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'no_comments_bg',
				[
					'label'     => __( 'Background Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-no-comments' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'no_comments_typography',
					'selector' => '{{WRAPPER}} .mgpd-no-comments',
				]
			);

			$this->add_responsive_control(
				'no_comments_padding',
				[
					'label'      => __( 'Padding', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-no-comments' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'no_comments_border_radius',
				[
					'label'      => __( 'Border Radius', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-no-comments' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$post_id  = get_the_ID();
			$settings = $this->get_settings_for_display();

			if ( ! $post_id ) {
				mgpd_theme_demo( 'comments' );
				return;
			}

			$classes = [ 'mgpd-theme-post-comments' ];
			if ( function_exists( 'mp_display_check_main_ok' ) && mp_display_check_main_ok() && 'yes' === ( $settings['custom_form_style'] ?? '' ) ) {
				$classes[] = 'mgpd-modern-comments';
			}

			echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';

			if ( comments_open( $post_id ) || get_comments_number( $post_id ) ) {
				if ( 'yes' === $settings['show_comments_form'] ) {
					comments_template();
				} else {
					// Show comments list only, no form
					echo '<div class="mgpd-comments-list-only">';
					wp_list_comments();
					echo '</div>';
				}
			} else {
				$no_comments_text = ! empty( $settings['no_comments_text'] ) ? $settings['no_comments_text'] : __( 'Comments are closed.', 'magical-posts-display' );
				echo '<p class="mgpd-no-comments">' . esc_html( $no_comments_text ) . '</p>';
			}

			echo '</div>';
		}
	}
}
