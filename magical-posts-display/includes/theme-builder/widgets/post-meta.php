<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post Meta theme widget.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Post_Meta' ) ) {

	class Mgpd_Theme_Post_Meta extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgpd-theme-post-meta';
		}

		public function get_title() {
			return __( 'Post Meta', 'magical-posts-display' );
		}

		public function get_icon() {
			return 'eicon-post-info';
		}

		public function get_categories() {
			return [ 'mgpd-theme-single' ];
		}

		public function get_keywords() {
			return [ 'post', 'meta', 'date', 'author', 'category', 'info', 'theme' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'content_section',
				[ 'label' => __( 'Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'show_date',
				[
					'label'     => __( 'Show Date', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'show_author',
				[
					'label'     => __( 'Show Author', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'show_category',
				[
					'label'     => __( 'Show Category', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'show_tags',
				[
					'label'     => __( 'Show Tags', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'no',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'show_comments',
				[
					'label'     => __( 'Show Comments Count', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'no',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'separator',
				[
					'label'   => __( 'Separator', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '|',
				]
			);

			$this->add_control(
				'icon_position',
				[
					'label'   => __( 'Icon Position', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'before',
					'options' => [
						'none'   => __( 'None', 'magical-posts-display' ),
						'before' => __( 'Before', 'magical-posts-display' ),
					],
				]
			);

			$this->add_control(
				'show_author_avatar',
				[
					'label'     => __( 'Show Author Avatar (Pro Only)', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'no',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
					'classes'   => 'mpd-pro-control',
				]
			);

			$this->add_control(
				'show_modified_date',
				[
					'label'     => __( 'Show Last Modified Date (Pro Only)', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'no',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
					'classes'   => 'mpd-pro-control',
				]
			);

			$this->add_control(
				'show_reading_time',
				[
					'label'     => __( 'Show Reading Time (Pro Only)', 'magical-posts-display' ),
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
				'text_color',
				[
					'label'     => __( 'Text Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-meta' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'link_color',
				[
					'label'     => __( 'Link Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-meta a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'link_hover_color',
				[
					'label'     => __( 'Link Hover Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-meta a:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'meta_typography',
					'selector' => '{{WRAPPER}} .mgpd-theme-post-meta',
				]
			);

			$this->add_responsive_control(
				'meta_spacing',
				[
					'label'      => __( 'Spacing', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'meta_alignment',
				[
					'label'     => __( 'Alignment', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::CHOOSE,
					'options'   => [
						'flex-start' => [
							'title' => __( 'Left', 'magical-posts-display' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center'     => [
							'title' => __( 'Center', 'magical-posts-display' ),
							'icon'  => 'eicon-text-align-center',
						],
						'flex-end'   => [
							'title' => __( 'Right', 'magical-posts-display' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-meta' => 'justify-content: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$post_id  = get_the_ID();

			if ( ! $post_id ) {
				mgpd_theme_demo( 'meta' );
				return;
			}

			$settings      = $this->get_settings_for_display();
			$parts         = [];
			$sep           = ! empty( $settings['separator'] ) ? ' ' . wp_kses_post( $settings['separator'] ) . ' ' : ' | ';
			$icon_position = ! empty( $settings['icon_position'] ) ? $settings['icon_position'] : 'before';

			if ( 'yes' === $settings['show_date'] ) {
				$icon = ( 'before' === $icon_position ) ? '<i class="far fa-calendar"></i> ' : '';
				$parts[] = '<span class="mgpd-meta-date">' . $icon . esc_html( get_the_date( '', $post_id ) ) . '</span>';
			}

			if ( 'yes' === $settings['show_author'] ) {
				$author_id = get_post_field( 'post_author', $post_id );
				$avatar_html = '';
				if ( mp_display_check_main_ok() && 'yes' === ( $settings['show_author_avatar'] ?? 'no' ) ) {
					$avatar_html = '<span class="mgpd-meta-author-avatar">' . get_avatar( $author_id, 24 ) . '</span>';
				}
				$icon = ( 'before' === $icon_position && empty( $avatar_html ) ) ? '<i class="far fa-user"></i> ' : '';
				$parts[] = '<span class="mgpd-meta-author">' . $avatar_html . $icon . '<a href="' . esc_url( get_author_posts_url( $author_id ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $author_id ) ) . '</a></span>';
			}

			if ( mp_display_check_main_ok() && 'yes' === ( $settings['show_modified_date'] ?? 'no' ) ) {
				$icon = ( 'before' === $icon_position ) ? '<i class="far fa-clock"></i> ' : '';
				$parts[] = '<span class="mgpd-meta-modified-date">' . $icon . sprintf( __( 'Updated: %s', 'magical-posts-display' ), esc_html( get_the_modified_date( '', $post_id ) ) ) . '</span>';
			}

			if ( mp_display_check_main_ok() && 'yes' === ( $settings['show_reading_time'] ?? 'no' ) ) {
				$content = get_post_field( 'post_content', $post_id );
				$word_count = str_word_count( wp_strip_all_tags( $content ) );
				$reading_time = max( 1, ceil( $word_count / 200 ) );
				$icon = ( 'before' === $icon_position ) ? '<i class="far fa-hourglass"></i> ' : '';
				$parts[] = '<span class="mgpd-meta-reading-time">' . $icon . sprintf( /* translators: %d: minutes */ _n( '%d min read', '%d mins read', $reading_time, 'magical-posts-display' ), $reading_time ) . '</span>';
			}

			if ( 'yes' === $settings['show_category'] ) {
				$categories = get_the_category( $post_id );
				if ( ! empty( $categories ) ) {
					$icon = ( 'before' === $icon_position ) ? '<i class="far fa-folder"></i> ' : '';
					$cat_links = [];
					foreach ( $categories as $category ) {
						$cat_links[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
					}
					$parts[] = '<span class="mgpd-meta-category">' . $icon . implode( ', ', $cat_links ) . '</span>';
				}
			}

			if ( 'yes' === $settings['show_tags'] ) {
				$tags = get_the_tags( $post_id );
				if ( ! empty( $tags ) ) {
					$icon = ( 'before' === $icon_position ) ? '<i class="fas fa-tags"></i> ' : '';
					$tag_links = [];
					foreach ( $tags as $tag ) {
						$tag_links[] = '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a>';
					}
					$parts[] = '<span class="mgpd-meta-tags">' . $icon . implode( ', ', $tag_links ) . '</span>';
				}
			}

			if ( 'yes' === $settings['show_comments'] ) {
				$comments_count = get_comments_number( $post_id );
				$icon = ( 'before' === $icon_position ) ? '<i class="far fa-comment"></i> ' : '';
				$parts[] = '<span class="mgpd-meta-comments">' . $icon . '<a href="' . esc_url( get_comments_link( $post_id ) ) . '">' . sprintf( _n( '%s Comment', '%s Comments', $comments_count, 'magical-posts-display' ), number_format_i18n( $comments_count ) ) . '</a></span>';
			}

			if ( empty( $parts ) ) {
				return;
			}

			echo '<div class="mgpd-theme-post-meta">' . implode( $sep, $parts ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}
