<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post Pagination theme widget.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Post_Pagination' ) ) {

	class Mgpd_Theme_Post_Pagination extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgpd-theme-post-pagination';
		}

		public function get_title() {
			return __( 'Post Pagination', 'magical-posts-display' );
		}

		public function get_icon() {
			return 'eicon-pagination';
		}

		public function get_categories() {
			return [ 'mgpd-theme-archive' ];
		}

		public function get_keywords() {
			return [ 'pagination', 'pager', 'next', 'previous', 'page', 'theme' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'content_section',
				[ 'label' => __( 'Settings', 'magical-posts-display' ) ]
			);

			$this->add_control(
				'pagination_type',
				[
					'label'   => __( 'Pagination Type', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'numbers',
					'options' => [
						'numbers'   => __( 'Numbers (Standard)', 'magical-posts-display' ),
						'load_more' => __( 'AJAX Load More (Pro Only)', 'magical-posts-display' ),
						'infinite'  => __( 'Infinite Scroll (Pro Only)', 'magical-posts-display' ),
					],
					'description' => __( 'Load More & Infinite Scroll append posts into the Blog / Archive Posts widget on this template.', 'magical-posts-display' ),
				]
			);

			$this->add_control(
				'prev_text',
				[
					'label'   => __( 'Previous Text', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '&laquo;',
					'condition' => [
						'pagination_type' => 'numbers',
					],
				]
			);

			$this->add_control(
				'next_text',
				[
					'label'   => __( 'Next Text', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '&raquo;',
					'condition' => [
						'pagination_type' => 'numbers',
					],
				]
			);

			$this->add_control(
				'load_more_text',
				[
					'label'   => __( 'Load More Button Text', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Load More', 'magical-posts-display' ),
					'condition' => [
						'pagination_type' => 'load_more',
					],
				]
			);

			$this->add_control(
				'loading_text',
				[
					'label'   => __( 'Loading Text', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Loading...', 'magical-posts-display' ),
					'condition' => [
						'pagination_type' => 'infinite',
					],
				]
			);

			$this->add_control(
				'mid_size',
				[
					'label'       => __( 'Mid Size', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'default'     => 2,
					'description' => __( 'Number of pages to show before/after current page.', 'magical-posts-display' ),
					'condition'   => [
						'pagination_type' => 'numbers',
					],
				]
			);

			$this->add_control(
				'show_all',
				[
					'label'     => __( 'Show All Pages', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'default'   => 'no',
					'label_on'  => __( 'Yes', 'magical-posts-display' ),
					'label_off' => __( 'No', 'magical-posts-display' ),
					'condition' => [
						'pagination_type' => 'numbers',
					],
				]
			);

			$this->add_control(
				'end_size',
				[
					'label'       => __( 'End Size', 'magical-posts-display' ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'default'     => 1,
					'description' => __( 'Number of pages to show at the beginning and end.', 'magical-posts-display' ),
					'condition'   => [
						'pagination_type' => 'numbers',
						'show_all!' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'alignment',
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
					'default'   => 'center',
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-pagination' => 'text-align: {{VALUE}};',
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
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
				'link_color',
				[
					'label'     => __( 'Link Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-pagination a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'active_color',
				[
					'label'     => __( 'Active Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-pagination .current' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'link_hover_color',
				[
					'label'     => __( 'Link Hover Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-pagination a:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'link_bg_color',
				[
					'label'     => __( 'Link Background', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-pagination a' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'link_hover_bg_color',
				[
					'label'     => __( 'Link Hover Background', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-pagination a:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'active_bg_color',
				[
					'label'     => __( 'Active Background', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-pagination .current' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'pagination_typography',
					'selector' => '{{WRAPPER}} .mgpd-theme-pagination',
				]
			);

			$this->add_responsive_control(
				'item_spacing',
				[
					'label'      => __( 'Item Spacing', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em' ],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-pagination ul' => 'gap: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'item_padding',
				[
					'label'      => __( 'Item Padding', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-pagination a, {{WRAPPER}} .mgpd-theme-pagination .current' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'item_border_radius',
				[
					'label'      => __( 'Border Radius', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-pagination a, {{WRAPPER}} .mgpd-theme-pagination .current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'item_box_shadow',
					'selector' => '{{WRAPPER}} .mgpd-theme-pagination a, {{WRAPPER}} .mgpd-theme-pagination .current',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'item_hover_box_shadow',
					'label'    => __( 'Hover Shadow', 'magical-posts-display' ),
					'selector' => '{{WRAPPER}} .mgpd-theme-pagination a:hover',
				]
			);

			$this->add_responsive_control(
				'pagination_spacing',
				[
					'label'      => __( 'Spacing', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			$pagination_type = ! empty( $settings['pagination_type'] ) ? $settings['pagination_type'] : 'numbers';
			if ( ( 'load_more' === $pagination_type || 'infinite' === $pagination_type ) && ! mp_display_check_main_ok() ) {
				$pagination_type = 'numbers';
			}

			$alignment_class = ! empty( $settings['alignment'] ) ? ' mgpd-align-' . esc_attr( $settings['alignment'] ) : ' mgpd-align-center';

			if ( 'load_more' === $pagination_type || 'infinite' === $pagination_type ) {
				global $wp_query;

				$max_pages = 1;
				if ( $wp_query instanceof WP_Query && $wp_query->max_num_pages ) {
					$max_pages = (int) $wp_query->max_num_pages;
				}

				$current_page = max( 1, absint( get_query_var( 'paged' ) ), absint( get_query_var( 'page' ) ) );

				if ( $max_pages <= 1 ) {
					if ( mgpd_theme_is_editor_preview() ) {
						mgpd_theme_demo( 'pagination' );
					}
					return;
				}

				echo '<nav class="mgpd-theme-pagination mgpd-theme-pagination-ajax' . $alignment_class . '">';

				if ( 'load_more' === $pagination_type ) {
					?>
					<button type="button" class="mgpd-load-more-btn mgpd-theme-load-more"
						data-mgpd-loadmore="1"
						data-target="[data-mgpd-archive]"
						data-page="<?php echo esc_attr( $current_page ); ?>"
						data-max="<?php echo esc_attr( $max_pages ); ?>">
						<span class="mgpd-load-more-text"><?php echo esc_html( $settings['load_more_text'] ?? __( 'Load More', 'magical-posts-display' ) ); ?></span>
					</button>
					<p class="mgpd-end-message" hidden><?php echo esc_html__( 'You have reached the end.', 'magical-posts-display' ); ?></p>
					<?php
				} else {
					?>
					<div class="mgpd-infinite-sentinel"
						data-mgpd-infinite="1"
						data-target="[data-mgpd-archive]"
						data-page="<?php echo esc_attr( $current_page ); ?>"
						data-max="<?php echo esc_attr( $max_pages ); ?>"></div>
					<div class="mgpd-infinite-loader">
						<span class="mgpd-loader-text"><?php echo esc_html( $settings['loading_text'] ?? __( 'Loading...', 'magical-posts-display' ) ); ?></span>
					</div>
					<p class="mgpd-end-message" hidden><?php echo esc_html__( 'You have reached the end.', 'magical-posts-display' ); ?></p>
					<?php
				}

				echo '</nav>';
				return;
			}

			$args = [
				'mid_size'  => absint( $settings['mid_size'] ),
				'prev_text' => wp_kses_post( $settings['prev_text'] ),
				'next_text' => wp_kses_post( $settings['next_text'] ),
				'type'      => 'array',
			];

			if ( 'yes' === $settings['show_all'] ) {
				$args['show_all'] = true;
			} else {
				$args['end_size'] = absint( $settings['end_size'] );
			}

			$pagination = paginate_links( $args );

			if ( ! $pagination ) {
				mgpd_theme_demo( 'pagination' );
				return;
			}

			echo '<nav class="mgpd-theme-pagination' . $alignment_class . '">';
			echo '<ul>';

			foreach ( $pagination as $link ) {
				echo '<li>' . wp_kses_post( $link ) . '</li>';
			}

			echo '</ul>';
			echo '</nav>';
		}
	}
}
