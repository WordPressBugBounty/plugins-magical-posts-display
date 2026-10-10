<?php
/*
*
* Elementor main class
*
*/

class mgPostsElementorMain
{

	function __construct()
	{

		add_action('elementor/widgets/register', [$this, 'init_widgets']);
		add_action('elementor/elements/categories_registered', [$this, 'register_new_category']);
		add_action('elementor/frontend/after_enqueue_styles', [$this, 'frontend_widget_styles']);
		add_action("elementor/frontend/after_enqueue_scripts", [$this, 'frontend_assets_scripts']);
		add_action('elementor/editor/after_enqueue_styles', [$this, 'editor_widget_style']);
	}


	public function init_widgets($widgets_manager)
	{
		// Image grid 
		if (mpd_is_widget_enabled('adv_posts_img_grid')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/advanced-posts-img-grid.php');
			$widgets_manager->register(new \mgpdAdPostsImgGrid());
		}
		// Posts Grid
		if (mpd_is_widget_enabled('posts_grid')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-grid.php');
			$widgets_manager->register(new \mgpdEPostsGrid());
		}
		// Posts list
		if (mpd_is_widget_enabled('posts_list')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-list.php');
			$widgets_manager->register(new \mgpdEPostsList());
		}
		// Awesome Posts list
		if (mpd_is_widget_enabled('awesome_posts_list')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/awesome-posts-list.php');
			$widgets_manager->register(new \mgpdEAwesomePostsList());
		}
		// Posts Carousel
		if (mpd_is_widget_enabled('posts_carousel')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-carousel.php');
			$widgets_manager->register(new \mgPosts_carousel());
		}

		// Posts Slider
		if (mpd_is_widget_enabled('posts_slider')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-slider.php');
			$widgets_manager->register(new \mgpdEPostsSlider());
		}

		// Posts Accordion
		if (mpd_is_widget_enabled('posts_accordion')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-accordion.php');
			$widgets_manager->register(new \mgpdEPostsAccordion());
		}

		// Posts Tabs
		if (mpd_is_widget_enabled('posts_tab')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-tab.php');
			$widgets_manager->register(new \mgpdEPostsTab());
		}

		// Posts Ticker
		if (mpd_is_widget_enabled('posts_ticker')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-ticker.php');
			$widgets_manager->register(new \mgpdEPostsTicker());
		}
		// Posts Categories
		if (mpd_is_widget_enabled('posts_cat')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-cat.php');
			$widgets_manager->register(new \mgpdEPosts_cats());
		}

		// Advanced Posts ad grid one
		if (mpd_is_widget_enabled('adv_posts_grid1')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/advanced-posts-grid1.php');
			$widgets_manager->register(new \mgpdAdPostsGrid1());
		}
		// Advanced Posts ad grid two
		if (mpd_is_widget_enabled('adv_posts_grid2')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/advanced-posts-grid2.php');
			$widgets_manager->register(new \mgpdAdPostsGrid2());
		}
		// News Magazine Grid
		if (mpd_is_widget_enabled('news_magazine_grid')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/news-magazine-grid.php');
			$widgets_manager->register(new \mgpdNewsMagazineGrid());
		}

		// News Magazine Image Grid
		if (mpd_is_widget_enabled('news_magazine_img_grid')) {
			require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/news-magazine-img-grid.php');
			$widgets_manager->register(new \mgpdNewsMagazineImgGrid());
		}
	}

	public function register_new_category(\Elementor\Elements_Manager $elements_manager)
	{

		$category_prefix = 'mgp-';
		$category_slug   = $category_prefix . 'mgposts';

		$elements_manager->add_category($category_slug, [
			'title' => esc_html__('Magical Posts Display', 'magical-posts-display'),
			'icon'  => 'fa fa-magic',
		]);

		// Get all existing categories
		$categories = $elements_manager->get_categories();

		// Remove your custom category from the list to reposition it
		$magical_category = $categories[$category_slug] ?? null;
		unset($categories[$category_slug]);

		if (! $magical_category) {
			return; // Stop if not found
		}

		// Insert at index 3 (4th position)
		$before    = array_slice($categories, 0, 4, true);
		$after     = array_slice($categories, 4, null, true);
		$reordered = $before + [$category_slug => $magical_category] + $after;

		// Use reflection to safely inject reordered categories without breaking if Elementor internals change
		try {
			$reflection = new \ReflectionClass($elements_manager);
			if ($reflection->hasProperty('categories')) {
				$property = $reflection->getProperty('categories');
				$property->setAccessible(true);
				$property->setValue($elements_manager, $reordered);
			}
		} catch (\Throwable $e) {
			// Fallback gracefully without throwing fatal ReflectionException
		}
	}


	/**
	 * Add style and scripts
	 *
	 * Add the plugin style and scripts for this
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	/*
	plugin css
	*/
	function frontend_widget_styles()
	{
		// Styles are registered via MPD_Assets_Manager and enqueued conditionally per widget
		if ( ! wp_style_is( 'mp-accordion-style', 'registered' ) ) {
			wp_register_style("mp-accordion-style", MAGICAL_POSTS_DISPLAY_ASSETS . 'css/widget-style/mp-accordion.css', array(), MAGICAL_POSTS_DISPLAY_VERSION, 'all');
		}

		if ( ! wp_style_is( 'mp-tab-style', 'registered' ) ) {
			wp_register_style("mp-tab-style", MAGICAL_POSTS_DISPLAY_ASSETS . 'css/widget-style/mp-tabs.css', array(), MAGICAL_POSTS_DISPLAY_VERSION, 'all');
		}

		if ( ! wp_style_is( 'magical-news-magazine-grid', 'registered' ) ) {
			wp_register_style('magical-news-magazine-grid', MAGICAL_POSTS_DISPLAY_ASSETS . 'css/news-magazine-grid.css', array(), MAGICAL_POSTS_DISPLAY_VERSION, 'all');
		}

		if ( ! wp_style_is( 'magical-news-magazine-img-grid', 'registered' ) ) {
			wp_register_style('magical-news-magazine-img-grid', MAGICAL_POSTS_DISPLAY_ASSETS . 'css/news-magazine-img-grid.css', array(), MAGICAL_POSTS_DISPLAY_VERSION, 'all');
		}
	}


	/*
	plugin elementor js
	*/
	function frontend_assets_scripts()
	{
		if ( ! wp_script_is( 'mpd-slider-script-active', 'registered' ) ) {
			wp_register_script(
				'mpd-slider-script-active',
				MAGICAL_POSTS_DISPLAY_ASSETS . 'js/widgets-active/post-slider-active.js',
				['jquery', 'swiper'],
				MAGICAL_POSTS_DISPLAY_VERSION,
				true
			);
		}

		if ( ! wp_script_is( 'mpd-pcarousel-active', 'registered' ) ) {
			wp_register_script(
				'mpd-pcarousel-active',
				MAGICAL_POSTS_DISPLAY_ASSETS . 'js/widgets-active/posts-carousel-active.js',
				['jquery', 'swiper'],
				MAGICAL_POSTS_DISPLAY_VERSION,
				true
			);
		}

		if ( ! wp_script_is( 'mpd-ticker-script-js', 'registered' ) ) {
			wp_register_script(
				'mpd-ticker-script-js',
				MAGICAL_POSTS_DISPLAY_ASSETS . 'js/widgets-active/posts-ticker-active.js',
				['jquery', 'jquery.easy-ticker'],
				MAGICAL_POSTS_DISPLAY_VERSION,
				true
			);
		}
	}

	/*
	plugin elementor js
	*/
	function editor_widget_style()
	{

		wp_enqueue_style("mp-elementor-style", MAGICAL_POSTS_DISPLAY_ASSETS . 'css/elementor-admin.css', array(), MAGICAL_POSTS_DISPLAY_VERSION, 'all');
	}
}

new mgPostsElementorMain();
