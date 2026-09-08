<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post Navigation theme widget.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Post_Navigation' ) ) {

	class Mgpd_Theme_Post_Navigation extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgpd-theme-post-navigation';
		}

		public function get_title() {
			return __( 'Post Navigation', 'magical-posts-display' );
		}

		public function get_icon() {
			return 'eicon-post-navigation';
		}

		public function get_categories() {
			return [ 'mgpd-theme-single' ];
		}

		public function get_keywords() {
			return [ 'post', 'navigation', 'previous', 'next', 'prev', 'theme' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'content_section',
				[ 'label' => __( 'Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'prev_text',
				[
					'label'   => __( 'Previous Link Text', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '&larr; Previous Post',
				]
			);

			$this->add_control(
				'next_text',
				[
					'label'   => __( 'Next Link Text', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => 'Next Post &rarr;',
				]
			);

			$this->add_control(
				'in_same_cat',
				[
					'label'     => __( 'Same Category Only', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'no',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'show_nav_titles',
				[
					'label'     => __( 'Show Post Titles', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'show_nav_thumbs',
				[
					'label'     => __( 'Show Post Thumbnails (Pro Only)', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'no',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
					'classes'   => 'mpd-pro-control',
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
				'link_color',
				[
					'label'     => __( 'Link Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-navigation a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			$in_same_cat = 'yes' === $settings['in_same_cat'];

			// Build navigation HTML.
			$prev = get_previous_post( $in_same_cat );
			$next = get_next_post( $in_same_cat );

			if ( ! $prev && ! $next ) {
				mgpd_theme_demo( 'navigation', $settings );
				return;
			}

			echo '<nav class="mgpd-theme-post-navigation">';

			$show_title = 'yes' === ( $settings['show_nav_titles'] ?? 'yes' );
			$show_thumb = mp_display_check_main_ok() && 'yes' === ( $settings['show_nav_thumbs'] ?? 'no' );

			if ( $prev ) {
				$thumb_html = '';
				if ( $show_thumb && has_post_thumbnail( $prev ) ) {
					$thumb_html = '<span class="mgpd-nav-thumb">' . get_the_post_thumbnail( $prev, 'thumbnail' ) . '</span>';
				}
				echo '<div class="mgpd-nav-prev">';
				echo '<a href="' . esc_url( get_permalink( $prev ) ) . '" class="mgpd-nav-link-wrap">';
				echo $thumb_html;
				echo '<span class="mgpd-nav-info">';
				echo '<span class="mgpd-nav-label">' . wp_kses_post( $settings['prev_text'] ) . '</span>';
				if ( $show_title ) {
					echo '<span class="mgpd-nav-title">' . esc_html( get_the_title( $prev ) ) . '</span>';
				}
				echo '</span>';
				echo '</a>';
				echo '</div>';
			}

			if ( $next ) {
				$thumb_html = '';
				if ( $show_thumb && has_post_thumbnail( $next ) ) {
					$thumb_html = '<span class="mgpd-nav-thumb">' . get_the_post_thumbnail( $next, 'thumbnail' ) . '</span>';
				}
				echo '<div class="mgpd-nav-next">';
				echo '<a href="' . esc_url( get_permalink( $next ) ) . '" class="mgpd-nav-link-wrap">';
				echo '<span class="mgpd-nav-info">';
				echo '<span class="mgpd-nav-label">' . wp_kses_post( $settings['next_text'] ) . '</span>';
				if ( $show_title ) {
					echo '<span class="mgpd-nav-title">' . esc_html( get_the_title( $next ) ) . '</span>';
				}
				echo '</span>';
				echo $thumb_html;
				echo '</a>';
				echo '</div>';
			}

			echo '</nav>';
		}
	}
}
