<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post Theme Widgets module for Magical Posts Display.
 *
 * Registers the single post & archive Elementor widgets (post title, content,
 * featured image, meta, comments, author box, archive posts, ...) that power
 * the Magical Addons Theme Builder templates.
 *
 * Widgets are registered on `elementor/widgets/register` (fired by Elementor
 * on init), which is always later than this file's plugins_loaded include.
 *
 * @package    Magical_Posts_Display
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'Mgpd_Theme_Builder_Module' ) ) {

	/**
	 * Class Mgpd_Theme_Builder_Module
	 */
	class Mgpd_Theme_Builder_Module {

		/**
		 * Singleton instance.
		 *
		 * @var Mgpd_Theme_Builder_Module|null
		 */
		private static $_instance;

		/**
		 * Get singleton instance.
		 *
		 * @return Mgpd_Theme_Builder_Module
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Constructor.
		 */
		private function __construct() {
			if ( ! did_action( 'elementor/loaded' ) ) {
				return;
			}

			require_once __DIR__ . '/demo-content.php';

			// Elementor fires both hooks after plugins_loaded, so registering
			// here is safe no matter the plugin load order.
			add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
			add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
			add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_styles' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_scripts' ] );
		}

		/**
		 * Load the widget class files.
		 */
		public function load_widgets() {
			$widgets_dir = MAGICAL_POSTS_DISPLAY_DIR . 'includes/theme-builder/widgets/';

			$widgets = [
				'post-title',
				'post-excerpt',
				'post-content',
				'featured-image',
				'post-meta',
				'post-navigation',
				'post-comments',
				'author-box',
				'archive-title',
				'archive-posts',
				'post-pagination',
			];

			foreach ( $widgets as $widget ) {
				$file = $widgets_dir . $widget . '.php';
				if ( file_exists( $file ) ) {
					require_once $file;
				}
			}
		}

		/**
		 * Register post theme widgets.
		 *
		 * @param object $widgets_manager Elementor widgets manager.
		 */
		public function register_widgets( $widgets_manager ) {
			$this->load_widgets();

			$widgets = [
				'Mgpd_Theme_Post_Title',
				'Mgpd_Theme_Post_Excerpt',
				'Mgpd_Theme_Post_Content',
				'Mgpd_Theme_Featured_Image',
				'Mgpd_Theme_Post_Meta',
				'Mgpd_Theme_Post_Navigation',
				'Mgpd_Theme_Post_Comments',
				'Mgpd_Theme_Author_Box',
				'Mgpd_Theme_Archive_Title',
				'Mgpd_Theme_Archive_Posts',
				'Mgpd_Theme_Post_Pagination',
			];

			/**
			 * Filters the post theme widgets.
			 *
			 * @param array $widgets Widget class names.
			 */
			$widgets = apply_filters( 'mgpd_theme_builder/widgets', $widgets );

			foreach ( $widgets as $class_name ) {
				if ( class_exists( $class_name ) ) {
					$widgets_manager->register( new $class_name() );
				}
			}
		}

		/**
		 * Register widget categories.
		 *
		 * @param object $elements_manager Elementor elements manager.
		 */
		public function register_categories( $elements_manager ) {
			$elements_manager->add_category( 'mgpd-theme-single', [
				'title' => __( 'Post Single', 'magical-posts-display' ),
				'icon'  => 'eicon-post-content',
			] );

			$elements_manager->add_category( 'mgpd-theme-archive', [
				'title' => __( 'Post Archive', 'magical-posts-display' ),
				'icon'  => 'eicon-posts-archive',
			] );
		}

		/**
		 * Enqueue editor styles.
		 */
		public function enqueue_editor_styles() {
			if ( class_exists( '\Elementor\Icons_Manager' ) ) {
				\Elementor\Icons_Manager::enqueue_shim();
			}
			wp_enqueue_style(
				'mgpd-theme-builder-widgets',
				MAGICAL_POSTS_DISPLAY_URL . '/assets/css/theme-builder-widgets.css',
				[],
				MAGICAL_POSTS_DISPLAY_VERSION
			);
		}

		/**
		 * Enqueue frontend styles.
		 */
		public function enqueue_frontend_styles() {
			if ( class_exists( '\Elementor\Icons_Manager' ) ) {
				\Elementor\Icons_Manager::enqueue_shim();
			}
			wp_enqueue_style(
				'mgpd-theme-builder-widgets',
				MAGICAL_POSTS_DISPLAY_URL . '/assets/css/theme-builder-widgets.css',
				[],
				MAGICAL_POSTS_DISPLAY_VERSION
			);
		}

		/**
		 * Enqueue frontend scripts (AJAX load more / infinite scroll).
		 */
		public function enqueue_frontend_scripts() {
			wp_enqueue_script(
				'mgpd-theme-builder',
				MAGICAL_POSTS_DISPLAY_URL . '/assets/js/theme-builder.js',
				[ 'jquery' ],
				MAGICAL_POSTS_DISPLAY_VERSION,
				true
			);

			wp_localize_script(
				'mgpd-theme-builder',
				'mgpdThemeBuilder',
				[
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'mgpd_theme_nonce' ),
					'i18n'    => [
						'error'    => __( 'Something went wrong. Please try again.', 'magical-posts-display' ),
						'loading'  => __( 'Loading...', 'magical-posts-display' ),
						'loadMore' => __( 'Load More', 'magical-posts-display' ),
					],
				]
			);
		}
	}
}

/**
 * Bootstrap the post theme widgets module.
 *
 * @return Mgpd_Theme_Builder_Module
 */
function mgpd_theme_builder() {
	return Mgpd_Theme_Builder_Module::instance();
}

mgpd_theme_builder();
