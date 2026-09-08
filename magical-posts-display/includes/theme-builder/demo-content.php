<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Editor demo content for the Magical Posts Display theme widgets.
 *
 * Theme widgets read the current post. While a template is designed in the
 * Elementor editor there may be no post context (fresh site, or the editor's
 * widget render runs before a preview query exists). In that case these
 * helpers print sample output so the design always shows something — the
 * same idea Elementor Pro uses for its theme widgets. Everything here only
 * outputs inside the editor / preview; the live site is never affected.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! function_exists( 'mgpd_theme_is_editor_preview' ) ) {

	/**
	 * Whether the widget renders inside the Elementor editor or its preview.
	 *
	 * @return bool
	 */
	function mgpd_theme_is_editor_preview() {
		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			return false;
		}

		$plugin = \Elementor\Plugin::instance();

		return $plugin->editor->is_edit_mode()
			|| $plugin->preview->is_preview_mode();
	}
}

if ( ! function_exists( 'mgpd_theme_demo' ) ) {

	/**
	 * Print sample output for a theme widget in the editor.
	 *
	 * @param string $what      Which demo: title, excerpt, content, image,
	 *                          meta, navigation, comments, author, archive,
	 *                          pagination.
	 * @param array  $settings  Widget settings (html tag, labels...).
	 * @return bool True when demo output was printed.
	 */
	function mgpd_theme_demo( $what, $settings = [] ) {
		if ( ! mgpd_theme_is_editor_preview() ) {
			return false;
		}

		$placeholder_text = 'color:#8a94a1;background:#f3f5f8;border-radius:4px;padding:2px 8px;font-size:13px;display:inline-block;margin-bottom:10px;';

		switch ( $what ) {

			case 'title':
				$tag = ! empty( $settings['html_tag'] ) ? $settings['html_tag'] : 'h2';
				$icon_html = '';
				if ( ! empty( $settings['show_icon'] ) && 'yes' === $settings['show_icon'] && ! empty( $settings['icon']['value'] ) ) {
					ob_start();
					\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
					$rendered_icon = ob_get_clean();
					$pos = $settings['icon_position'] ?? 'before';
					$icon_html = '<span class="mgpd-title-icon mgpd-icon-' . esc_attr( $pos ) . '">' . $rendered_icon . '</span>';
				}
				$icon_before = ( empty( $settings['icon_position'] ) || 'before' === $settings['icon_position'] ) ? $icon_html : '';
				$icon_after  = ( ! empty( $settings['icon_position'] ) && 'after' === $settings['icon_position'] ) ? $icon_html : '';
				printf(
					'<%1$s class="mgpd-theme-post-title elementor-heading-title elementor-heading-title-%1$s" style="margin:0;">%2$s%3$s%4$s</%1$s>',
					esc_attr( $tag ),
					$icon_before, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html__( 'Sample Post Title — Your Real Title Renders Here', 'magical-posts-display' ),
					$icon_after // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
				break;

			case 'excerpt':
				printf(
					'<div class="mgpd-theme-post-excerpt">%s</div>',
					esc_html__( 'This is a sample excerpt. It shows how your post summary will look inside this template while you design it.', 'magical-posts-display' )
				);
				break;

			case 'content':
				echo '<div class="mgpd-theme-post-content">';
				echo '<p>' . esc_html__( 'This is sample content generated while you design, because this site has no published posts yet. Publish a post (or open the editor on a site with content) and the real post body will render here.', 'magical-posts-display' ) . '</p>';
				echo '<h2>' . esc_html__( 'A sample heading', 'magical-posts-display' ) . '</h2>';
				echo '<p>' . esc_html__( 'Good templates are invisible: a clear title, scannable meta, generous spacing and readable line lengths carry the reader through the page without effort.', 'magical-posts-display' ) . '</p>';
				echo '</div>';
				break;

			case 'image':
				printf(
					'<div class="mgpd-theme-featured-image" style="display:flex;align-items:center;justify-content:center;min-height:320px;border:2px dashed #c3ccd6;border-radius:8px;background:#f6f8fa;color:#8a94a1;font-size:15px;">%s</div>',
					esc_html__( 'Featured Image', 'magical-posts-display' )
				);
				break;

			case 'meta':
				echo '<div class="mgpd-theme-post-meta">';
				echo '<span class="mgpd-meta-date">' . esc_html__( 'January 15, 2026', 'magical-posts-display' ) . '</span>';
				echo '<span class="mgpd-meta-author">' . esc_html__( 'Sample Author', 'magical-posts-display' ) . '</span>';
				echo '<span class="mgpd-meta-category">' . esc_html__( 'Sample Category', 'magical-posts-display' ) . '</span>';
				echo '</div>';
				break;

			case 'navigation':
				$prev = ! empty( $settings['prev_text'] ) ? $settings['prev_text'] : __( 'Previous Post', 'magical-posts-display' );
				$next = ! empty( $settings['next_text'] ) ? $settings['next_text'] : __( 'Next Post', 'magical-posts-display' );
				echo '<nav class="mgpd-theme-post-navigation">';
				echo '<div class="mgpd-nav-prev"><span class="mgpd-nav-label">' . esc_html( $prev ) . '</span><span class="mgpd-nav-title">' . esc_html__( 'A sample previous post', 'magical-posts-display' ) . '</span></div>';
				echo '<div class="mgpd-nav-next"><span class="mgpd-nav-label">' . esc_html( $next ) . '</span><span class="mgpd-nav-title">' . esc_html__( 'A sample next post', 'magical-posts-display' ) . '</span></div>';
				echo '</nav>';
				break;

			case 'comments':
				printf(
					'<div class="mgpd-theme-post-comments"><p style="%s">%s</p></div>',
					esc_attr( $placeholder_text ),
					esc_html__( 'Comments area — shows the post comment list and form on the live site', 'magical-posts-display' )
				);
				break;

			case 'author':
				echo '<div class="mgpd-theme-author-box">';
				echo '<div class="mgpd-author-avatar"><span style="display:inline-flex;width:80px;height:80px;border-radius:50%;background:#e3e8ee;align-items:center;justify-content:center;color:#8a94a1;font-weight:600;">A</span></div>';
				echo '<div class="mgpd-author-info">';
				echo '<div class="mgpd-author-name">' . esc_html__( 'Sample Author', 'magical-posts-display' ) . '</div>';
				echo '<div class="mgpd-author-bio">' . esc_html__( 'This is a sample author bio so you can style the author box while designing your template.', 'magical-posts-display' ) . '</div>';
				echo '</div>';
				echo '</div>';
				break;

			case 'archive':
				$tag = ! empty( $settings['html_tag'] ) ? $settings['html_tag'] : 'h1';
				$icon_html = '';
				if ( ! empty( $settings['show_icon'] ) && 'yes' === $settings['show_icon'] && ! empty( $settings['icon']['value'] ) ) {
					ob_start();
					\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
					$rendered_icon = ob_get_clean();
					$pos = $settings['icon_position'] ?? 'before';
					$icon_html = '<span class="mgpd-archive-icon mgpd-icon-' . esc_attr( $pos ) . '">' . $rendered_icon . '</span>';
				}
				$icon_before = ( empty( $settings['icon_position'] ) || 'before' === $settings['icon_position'] ) ? $icon_html : '';
				$icon_after  = ( ! empty( $settings['icon_position'] ) && 'after' === $settings['icon_position'] ) ? $icon_html : '';
				$prefix_html = '';
				if ( ! empty( $settings['show_prefix'] ) && 'yes' === $settings['show_prefix'] ) {
					$pref = ( ( $settings['archive_prefix_type'] ?? 'dynamic' ) === 'custom' && ! empty( $settings['custom_prefix'] ) )
						? $settings['custom_prefix']
						: __( 'Category: ', 'magical-posts-display' );
					$prefix_html = '<span class="mgpd-archive-prefix">' . esc_html( $pref ) . '</span>';
				}
				$suffix_html = '';
				if ( ! empty( $settings['show_prefix'] ) && 'yes' === $settings['show_prefix'] && ! empty( $settings['archive_suffix'] ) ) {
					$suffix_html = ' <span class="mgpd-archive-suffix">' . esc_html( $settings['archive_suffix'] ) . '</span>';
				}
				$demo_title = ! empty( $settings['blog_title'] ) ? $settings['blog_title'] : __( 'Archive', 'magical-posts-display' );
				printf(
					'<%1$s class="mgpd-theme-archive-title" style="margin:0;">%2$s%3$s%4$s%5$s%6$s</%1$s>',
					esc_attr( $tag ),
					$icon_before, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					$prefix_html, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html( $demo_title ),
					$suffix_html, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					$icon_after // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
				break;

			case 'pagination':
				echo '<nav class="mgpd-theme-pagination"><ul>';
				foreach ( [ '1', '2', '3' ] as $page ) {
					echo '<li><span class="page-numbers' . ( '1' === $page ? ' current' : '' ) . '">' . esc_html( $page ) . '</span></li>';
				}
				echo '</ul></nav>';
				break;

			default:
				return false;
		}

		return true;
	}
}
