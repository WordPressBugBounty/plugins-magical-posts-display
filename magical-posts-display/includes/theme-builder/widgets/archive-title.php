<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Archive Title theme widget.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Archive_Title' ) ) {

	class Mgpd_Theme_Archive_Title extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgpd-theme-archive-title';
		}

		public function get_title() {
			return __( 'Archive Title', 'magical-posts-display' );
		}

		public function get_icon() {
			return 'eicon-archive-title';
		}

		public function get_categories() {
			return [ 'mgpd-theme-archive' ];
		}

		public function get_keywords() {
			return [ 'archive', 'title', 'heading', 'category', 'tag', 'theme' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'content_section',
				[ 'label' => __( 'Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'html_tag',
				[
					'label'   => __( 'HTML Tag', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'h1',
					'options' => [
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
					],
				]
			);

			$this->add_control(
				'blog_title',
				[
					'label'       => __( 'Blog Page Title', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'default'     => __( 'Blog', 'magical-posts-display' ),
					'placeholder' => __( 'Blog', 'magical-posts-display' ),
					'description' => __( 'Title displayed on the Blog / Posts page (is_home). On category, tag, author, or date archives, the dynamic archive title is automatically displayed.', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'show_prefix',
				[
					'label'       => __( 'Archive Prefix & Suffix', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'default'     => 'no',
					'label_on'    => __( 'Yes', 'magical-posts-display' ),
					'label_off'   => __( 'No', 'magical-posts-display' ),
					'description' => __( 'Show prefix or suffix on archive pages (e.g. "Category:"). Note: Does not apply to the Blog page.', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'archive_prefix_type',
				[
					'label'     => __( 'Prefix Type', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'default'   => 'dynamic',
					'options'   => [
						'dynamic' => __( 'Dynamic (Category:, Tag:, Author:)', 'magical-posts-display' ),
						'custom'  => __( 'Custom Prefix', 'magical-posts-display' ),
					],
					'condition' => [
						'show_prefix' => 'yes',
					],
				]
			);

			$this->add_control(
				'custom_prefix',
				[
					'label'       => __( 'Custom Prefix (Before)', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'placeholder' => __( 'e.g. Category Archive: or Browsing: ', 'magical-posts-display' ),
					'condition'   => [
						'show_prefix'         => 'yes',
						'archive_prefix_type' => 'custom',
					],
				]
			);

			$this->add_control(
				'archive_suffix',
				[
					'label'       => __( 'Custom Suffix (After)', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'placeholder' => __( 'e.g. Archive or Posts', 'magical-posts-display' ),
					'condition'   => [
						'show_prefix' => 'yes',
					],
				]
			);

			$this->add_control(
				'show_search_count',
				[
					'label'       => __( 'Show Search Count (Pro Only)', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'default'     => 'no',
					'label_on'    => __( 'Yes', 'magical-posts-display' ),
					'label_off'   => __( 'No', 'magical-posts-display' ),
					'description' => __( 'Display total results count on search pages.', 'magical-posts-display' ),
					'classes'     => 'mpd-pro-control',
				]
			);

			$this->add_control(
				'show_icon',
				[
					'label'     => __( 'Show Icon', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'no',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'icon',
				[
					'label'     => __( 'Icon', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::ICONS,
					'default'   => [
						'value'   => 'fas fa-folder',
						'library' => 'fa-solid',
					],
					'condition' => [
						'show_icon' => 'yes',
					],
				]
			);

			$this->add_control(
				'icon_position',
				[
					'label'     => __( 'Icon Position', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'default'   => 'before',
					'options'   => [
						'before' => __( 'Before', 'magical-posts-display' ),
						'after'  => __( 'After', 'magical-posts-display' ),
					],
					'condition' => [
						'show_icon' => 'yes',
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
				'title_color',
				[
					'label'     => __( 'Text Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-archive-title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'selector' => '{{WRAPPER}} .mgpd-theme-archive-title',
				]
			);

			$this->add_responsive_control(
				'title_spacing',
				[
					'label'      => __( 'Spacing', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-archive-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'title_alignment',
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
						'{{WRAPPER}} .mgpd-theme-archive-title' => 'text-align: {{VALUE}};',
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'title_text_shadow',
					'selector' => '{{WRAPPER}} .mgpd-theme-archive-title',
				]
			);

			$this->end_controls_section();

			// Icon Style
			$this->start_controls_section(
				'icon_style_section',
				[
					'label'     => __( 'Icon', 'magical-posts-display' ),
					'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_icon' => 'yes',
					],
				]
			);

			$this->add_control(
				'icon_color',
				[
					'label'     => __( 'Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-archive-icon' => 'color: {{VALUE}}',
						'{{WRAPPER}} .mgpd-archive-icon svg' => 'fill: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'icon_size',
				[
					'label'      => __( 'Size', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-archive-icon' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .mgpd-archive-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'icon_spacing',
				[
					'label'      => __( 'Spacing', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em' ],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-archive-icon.mgpd-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .mgpd-archive-icon.mgpd-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			$html_tag = ! empty( $settings['html_tag'] ) ? $settings['html_tag'] : 'h1';

			$title        = '';
			$prefix       = '';
			$is_blog_page = false;

			if ( is_home() ) {
				$is_blog_page = true;
				$blog_title   = ! empty( $settings['blog_title'] ) ? trim( $settings['blog_title'] ) : '';
				if ( ! empty( $blog_title ) ) {
					$title = $blog_title;
				} else {
					$blog_page_id = (int) get_option( 'page_for_posts' );
					if ( $blog_page_id ) {
						$title = get_the_title( $blog_page_id );
					}
					if ( empty( $title ) ) {
						$title = __( 'Blog', 'magical-posts-display' );
					}
				}
			} elseif ( is_category() ) {
				$title  = single_cat_title( '', false );
				$prefix = __( 'Category', 'magical-posts-display' );
			} elseif ( is_tag() ) {
				$title  = single_tag_title( '', false );
				$prefix = __( 'Tag', 'magical-posts-display' );
			} elseif ( is_author() ) {
				$title  = get_the_author();
				$prefix = __( 'Author', 'magical-posts-display' );
			} elseif ( is_date() ) {
				if ( is_year() ) {
					$title  = get_the_date( _x( 'Y', 'yearly archives date format', 'magical-posts-display' ) );
					$prefix = __( 'Year', 'magical-posts-display' );
				} elseif ( is_month() ) {
					$title  = get_the_date( _x( 'F Y', 'monthly archives date format', 'magical-posts-display' ) );
					$prefix = __( 'Month', 'magical-posts-display' );
				} else {
					$title  = get_the_date( _x( 'F j, Y', 'daily archives date format', 'magical-posts-display' ) );
					$prefix = __( 'Day', 'magical-posts-display' );
				}
			} elseif ( is_post_type_archive() ) {
				$title  = post_type_archive_title( '', false );
				$prefix = __( 'Archives', 'magical-posts-display' );
			} elseif ( is_tax() ) {
				$title  = single_term_title( '', false );
				$prefix = __( 'Archives', 'magical-posts-display' );
			} elseif ( is_search() ) {
				$title  = get_search_query();
				$prefix = __( 'Search Results for', 'magical-posts-display' );
			} elseif ( is_404() ) {
				$title  = __( 'Page Not Found', 'magical-posts-display' );
			} else {
				$title = get_the_archive_title();
			}

			if ( empty( $title ) ) {
				mgpd_theme_demo( 'archive', $settings );
				return;
			}

			echo '<' . esc_attr( $html_tag ) . ' class="mgpd-theme-archive-title">';

			// Icon before
			$has_icon = ! empty( $settings['show_icon'] ) && 'yes' === $settings['show_icon'] && ! empty( $settings['icon']['value'] );
			if ( $has_icon && 'before' === ( $settings['icon_position'] ?? 'before' ) ) {
				echo '<span class="mgpd-archive-icon mgpd-icon-before">';
				\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
				echo '</span>';
			}

			// Prefix (Only for archive pages, never on blog page)
			if ( ! $is_blog_page && 'yes' === ( $settings['show_prefix'] ?? 'no' ) ) {
				$display_prefix = '';
				if ( ( $settings['archive_prefix_type'] ?? 'dynamic' ) === 'custom' && ! empty( $settings['custom_prefix'] ) ) {
					$display_prefix = $settings['custom_prefix'];
				} elseif ( ! empty( $prefix ) ) {
					$display_prefix = $prefix . ': ';
				}

				if ( ! empty( $display_prefix ) ) {
					echo '<span class="mgpd-archive-prefix">' . esc_html( $display_prefix ) . '</span>';
				}
			}

			echo esc_html( $title );

			// Suffix (Only for archive pages, never on blog page)
			if ( ! $is_blog_page && 'yes' === ( $settings['show_prefix'] ?? 'no' ) && ! empty( $settings['archive_suffix'] ) ) {
				echo ' <span class="mgpd-archive-suffix">' . esc_html( $settings['archive_suffix'] ) . '</span>';
			}

			// Search results count (Pro)
			if ( is_search() && mp_display_check_main_ok() && 'yes' === ( $settings['show_search_count'] ?? 'no' ) ) {
				global $wp_query;
				$count = (int) ( $wp_query->found_posts ?? 0 );
				printf( ' <span class="mgpd-search-count">(%s)</span>', sprintf( /* translators: %d: results count */ _n( '%d result', '%d results', $count, 'magical-posts-display' ), $count ) );
			}

			// Icon after
			if ( $has_icon && 'after' === ( $settings['icon_position'] ?? 'before' ) ) {
				echo '<span class="mgpd-archive-icon mgpd-icon-after">';
				\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
				echo '</span>';
			}

			echo '</' . esc_attr( $html_tag ) . '>';
		}
	}
}
