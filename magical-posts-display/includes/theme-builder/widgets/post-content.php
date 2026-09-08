<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post Content theme widget.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Post_Content' ) ) {

	class Mgpd_Theme_Post_Content extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgpd-theme-post-content';
		}

		public function get_title() {
			return __( 'Post Content', 'magical-posts-display' );
		}

		public function get_icon() {
			return 'eicon-single-post';
		}

		public function get_categories() {
			return [ 'mgpd-theme-single' ];
		}

		public function get_keywords() {
			return [ 'post', 'content', 'body', 'text', 'theme' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'content_section',
				[ 'label' => __( 'Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'link_pages',
				[
					'label'       => __( 'Multi-page Navigation', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'default'     => 'yes',
					'label_on'    => __( 'Yes', 'magical-posts-display' ),
					'label_off'   => __( 'No', 'magical-posts-display' ),
					'description' => __( 'Show navigation for posts split with <!--nextpage-->', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'drop_cap',
				[
					'label'       => __( 'Drop Cap', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'default'     => '',
					'label_on'    => __( 'Yes', 'magical-posts-display' ),
					'label_off'   => __( 'No', 'magical-posts-display' ),
					'classes'     => 'mpd-pro-control',
					'description' => __( 'Enlarge the first letter of the first paragraph (Pro Feature).', 'magical-posts-display' ),
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

			$this->add_control(
				'text_color',
				[
					'label'     => __( 'Text Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-content' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'link_color',
				[
					'label'     => __( 'Link Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-content a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'link_hover_color',
				[
					'label'     => __( 'Link Hover Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-content a:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'text_typography',
					'selector' => '{{WRAPPER}} .mgpd-theme-post-content',
				]
			);

			$this->add_responsive_control(
				'text_spacing',
				[
					'label'      => __( 'Spacing', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-post-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .mgpd-theme-post-content' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$post_id = get_the_ID();

			if ( ! $post_id ) {
				mgpd_theme_demo( 'content' );
				return;
			}

			$settings = $this->get_settings_for_display();
			$content  = get_post_field( 'post_content', $post_id );

			if ( empty( $content ) ) {
				mgpd_theme_demo( 'content' );
				return;
			}

			// Process content through shortcodes and blocks.
			// Note: the_content output is already sanitized by the filter
			// chain — running wp_kses_post() here would strip iframes,
			// embeds, forms and block markup.
			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );

			$classes = [ 'mgpd-theme-post-content' ];
			if ( function_exists( 'mp_display_check_main_ok' ) && mp_display_check_main_ok() && 'yes' === ( $settings['drop_cap'] ?? '' ) ) {
				$classes[] = 'has-drop-cap';
			}

			echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			if ( 'yes' === $settings['link_pages'] ) {
				wp_link_pages( [
					'before'      => '<div class="mgpd-post-pages-nav"><span class="mgpd-pages-label">' . __( 'Pages:', 'magical-posts-display' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span class="mgpd-page-number">',
					'link_after'  => '</span>',
				] );
			}

			echo '</div>';
		}
	}
}
