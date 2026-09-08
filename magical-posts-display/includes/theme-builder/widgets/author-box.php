<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Author Box theme widget.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Author_Box' ) ) {

	class Mgpd_Theme_Author_Box extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgpd-theme-author-box';
		}

		public function get_title() {
			return __( 'Author Box', 'magical-posts-display' );
		}

		public function get_icon() {
			return 'eicon-author-box';
		}

		public function get_categories() {
			return [ 'mgpd-theme-single' ];
		}

		public function get_keywords() {
			return [ 'author', 'profile', 'bio', 'avatar', 'box', 'theme' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'content_section',
				[ 'label' => __( 'Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'show_avatar',
				[
					'label'     => __( 'Show Avatar', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'avatar_size',
				[
					'label'   => __( 'Avatar Size', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 80,
					'min'     => 30,
					'max'     => 200,
				]
			);

			$this->add_control(
				'show_name',
				[
					'label'     => __( 'Show Name', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'show_bio',
				[
					'label'     => __( 'Show Bio', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'box_layout',
				[
					'label'   => __( 'Layout (Pro Only)', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'inline',
					'options' => [
						'inline' => __( 'Horizontal / Inline', 'magical-posts-display' ),
						'card'   => __( 'Centered Card (Pro Only)', 'magical-posts-display' ),
					],
					'classes' => 'mpd-pro-control',
				]
			);

			$this->add_control(
				'show_social_links',
				[
					'label'       => __( 'Show Social Links (Pro Only)', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'default'     => 'no',
					'label_on'    => __( 'Yes', 'magical-posts-display' ),
					'label_off'   => __( 'No', 'magical-posts-display' ),
					'description' => __( 'Shows the author website plus profile URLs set in the WordPress user profile.', 'magical-posts-display' ),
					'classes'     => 'mpd-pro-control',
				]
			);

			$this->add_control(
				'social_icon_size',
				[
					'label'     => __( 'Social Icon Size', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'     => [
						'px' => [ 'min' => 12, 'max' => 40 ],
					],
					'default'   => [ 'size' => 16 ],
					'condition' => [
						'show_social_links' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}} .mgpd-author-social a' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					],
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
				'name_color',
				[
					'label'     => __( 'Name Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-author-name' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'bio_color',
				[
					'label'     => __( 'Bio Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-author-bio' => 'color: {{VALUE}}',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$post_id  = get_the_ID();
			$settings = $this->get_settings_for_display();

			if ( ! $post_id ) {
				mgpd_theme_demo( 'author' );
				return;
			}

			$author_id = get_post_field( 'post_author', $post_id );
			$author    = get_userdata( $author_id );

			if ( ! $author ) {
				mgpd_theme_demo( 'author' );
				return;
			}

			$wrapper_classes = [ 'mgpd-theme-author-box' ];
			if ( mp_display_check_main_ok() && 'card' === ( $settings['box_layout'] ?? 'inline' ) ) {
				$wrapper_classes[] = 'layout-card';
			}

			echo '<div class="' . esc_attr( implode( ' ', $wrapper_classes ) ) . '">';

			// Avatar.
			if ( 'yes' === $settings['show_avatar'] ) {
				$avatar_size = absint( $settings['avatar_size'] );
				echo '<div class="mgpd-author-avatar">';
				echo get_avatar( $author->ID, $avatar_size );
				echo '</div>';
			}

			echo '<div class="mgpd-author-info">';

			// Name.
			if ( 'yes' === $settings['show_name'] ) {
				echo '<div class="mgpd-author-name">';
				echo '<a href="' . esc_url( get_author_posts_url( $author->ID ) ) . '">';
				echo esc_html( $author->display_name );
				echo '</a>';
				echo '</div>';
			}

			// Bio.
			if ( 'yes' === $settings['show_bio'] && ! empty( $author->description ) ) {
				echo '<div class="mgpd-author-bio">';
				echo wp_kses_post( $author->description );
				echo '</div>';
			}

			// Social links (Pro only).
			if ( mp_display_check_main_ok() && 'yes' === $settings['show_social_links'] ) {
				$social = $this->get_author_social_links( $author );
				if ( ! empty( $social ) ) {
					echo '<div class="mgpd-author-social">' . $social . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}

			echo '</div>';
			echo '</div>';
		}

		/**
		 * Build the author's social profile links.
		 *
		 * Uses the website field plus the standard user contact methods
		 * (facebook, twitter/x, instagram, linkedin, youtube) that themes
		 * and plugins register via `user_contactmethods`.
		 *
		 * @param WP_User $author Author object.
		 * @return string Social links HTML (escaped), empty when none set.
		 */
		protected function get_author_social_links( $author ) {
			$networks = [
				'website'   => [
					'label' => __( 'Website', 'magical-posts-display' ),
					'icon'  => 'fas fa-globe',
				],
				'facebook'  => [
					'label' => __( 'Facebook', 'magical-posts-display' ),
					'icon'  => 'fab fa-facebook-f',
				],
				'twitter'   => [
					'label' => __( 'X / Twitter', 'magical-posts-display' ),
					'icon'  => 'fab fa-twitter',
				],
				'instagram' => [
					'label' => __( 'Instagram', 'magical-posts-display' ),
					'icon'  => 'fab fa-instagram',
				],
				'linkedin'  => [
					'label' => __( 'LinkedIn', 'magical-posts-display' ),
					'icon'  => 'fab fa-linkedin-in',
				],
				'youtube'   => [
					'label' => __( 'YouTube', 'magical-posts-display' ),
					'icon'  => 'fab fa-youtube',
				],
			];

			$html = '';

			foreach ( $networks as $key => $network ) {
				$value = 'website' === $key ? $author->user_url : get_the_author_meta( $key, $author->ID );

				if ( empty( $value ) || ! esc_url( $value ) ) {
					continue;
				}

				$html .= sprintf(
					'<a href="%1$s" aria-label="%2$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="%3$s" aria-hidden="true"></i></a>',
					esc_url( $value ),
					esc_attr( $network['label'] ),
					esc_attr( $network['icon'] )
				);
			}

			return $html;
		}
	}
}
