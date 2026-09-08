<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post Title theme widget.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Post_Title' ) ) {

	class Mgpd_Theme_Post_Title extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgpd-theme-post-title';
		}

		public function get_title() {
			return __( 'Post Title', 'magical-posts-display' );
		}

		public function get_icon() {
			return 'eicon-post-title';
		}

		public function get_categories() {
			return [ 'mgpd-theme-single' ];
		}

		public function get_keywords() {
			return [ 'post', 'title', 'heading', 'dynamic', 'theme' ];
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
				'html_tag',
				[
					'label'   => __( 'HTML Tag', 'magical-posts-display' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'h2',
					'options' => [
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
						'p'    => 'p',
					],
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
						'value'   => 'fas fa-star',
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

			// Style tab.
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
						'{{WRAPPER}} .mgpd-theme-post-title a' => 'color: {{VALUE}}',
						'{{WRAPPER}} .mgpd-theme-post-title'    => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_hover_color',
				[
					'label'     => __( 'Hover Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-title a:hover' => 'color: {{VALUE}}',
					],
					'condition' => [
						'link_to_post' => 'yes',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'selector' => '{{WRAPPER}} .mgpd-theme-post-title',
				]
			);

			$this->add_responsive_control(
				'title_spacing',
				[
					'label'      => __( 'Spacing', 'magical-posts-display' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .mgpd-theme-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .mgpd-theme-post-title' => 'text-align: {{VALUE}};',
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'title_text_shadow',
					'selector' => '{{WRAPPER}} .mgpd-theme-post-title',
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
						'{{WRAPPER}} .mgpd-title-icon' => 'color: {{VALUE}}',
						'{{WRAPPER}} .mgpd-title-icon svg' => 'fill: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'icon_hover_color',
				[
					'label'     => __( 'Hover Color', 'magical-posts-display' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgpd-theme-post-title:hover .mgpd-title-icon' => 'color: {{VALUE}}',
						'{{WRAPPER}} .mgpd-theme-post-title:hover .mgpd-title-icon svg' => 'fill: {{VALUE}}',
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
						'{{WRAPPER}} .mgpd-title-icon' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .mgpd-title-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .mgpd-title-icon.mgpd-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .mgpd-title-icon.mgpd-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$post_id = get_the_ID();
			$settings = $this->get_settings_for_display();

			if ( ! $post_id ) {
				mgpd_theme_demo( 'title', $settings );
				return;
			}

			$title = get_the_title( $post_id );

			if ( empty( $title ) ) {
				mgpd_theme_demo( 'title', $settings );
				return;
			}

			$this->add_render_attribute( 'title', 'class', 'mgpd-theme-post-title' );

			$html_tag = ! empty( $settings['html_tag'] ) ? $settings['html_tag'] : 'h2';
			$this->add_render_attribute( 'title', 'class', 'elementor-heading-title' );
			$this->add_render_attribute( 'title', 'class', 'elementor-heading-title-' . $html_tag );

			$title_html = '<' . esc_attr( $html_tag ) . ' ' . $this->get_render_attribute_string( 'title' ) . '>';

			// Icon before
			$has_icon = ! empty( $settings['show_icon'] ) && 'yes' === $settings['show_icon'] && ! empty( $settings['icon']['value'] );
			if ( $has_icon && 'before' === ( $settings['icon_position'] ?? 'before' ) ) {
				$title_html .= '<span class="mgpd-title-icon mgpd-icon-before">';
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
				$title_html .= ob_get_clean();
				$title_html .= '</span>';
			}

			if ( 'yes' === $settings['link_to_post'] ) {
				$title_html .= '<a href="' . esc_url( get_permalink( $post_id ) ) . '">';
				$title_html .= esc_html( $title );
				$title_html .= '</a>';
			} else {
				$title_html .= esc_html( $title );
			}

			// Icon after
			if ( $has_icon && 'after' === ( $settings['icon_position'] ?? 'before' ) ) {
				$title_html .= '<span class="mgpd-title-icon mgpd-icon-after">';
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
				$title_html .= ob_get_clean();
				$title_html .= '</span>';
			}

			$title_html .= '</' . esc_attr( $html_tag ) . '>';

			echo $title_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}
