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
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/advanced-posts-img-grid.php');
		$widgets_manager->register(new \mgpdAdPostsImgGrid());
		//Posts Grid
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-grid.php');
		$widgets_manager->register(new \mgpdEPostsGrid());
		//Posts list
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-list.php');
		$widgets_manager->register(new \mgpdEPostsList());
		//Awesome Posts list
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/awesome-posts-list.php');
		$widgets_manager->register(new \mgpdEAwesomePostsList());
		// Posts Carousel
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-carousel.php');
		$widgets_manager->register(new \mgPosts_carousel());

		// Posts Slider
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-slider.php');
		$widgets_manager->register(new \mgpdEPostsSlider());

		// Posts Accordion
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-accordion.php');
		$widgets_manager->register(new \mgpdEPostsAccordion());

		// Posts Tabs
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-tab.php');
		$widgets_manager->register(new \mgpdEPostsTab());

		// Posts Tabs
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-ticker.php');
		$widgets_manager->register(new \mgpdEPostsTicker());
		// Posts Categories
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/posts-cat.php');
		$widgets_manager->register(new \mgpdEPosts_cats());

		// Advanced Posts ad grid one
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/advanced-posts-grid1.php');
		$widgets_manager->register(new \mgpdAdPostsGrid1());
		// Advanced Posts ad grid one
		require_once(MAGICAL_POSTS_DISPLAY_DIR . '/includes/elementor/widgets/advanced-posts-grid2.php');
		$widgets_manager->register(new \mgpdAdPostsGrid2());
	}

	public function register_new_category(\Elementor\Elements_Manager $elements_manager)
	{

		//add our categories
		$category_prefix = 'mgp-';

		if (class_exists('magicalPostDisplayPro')) {
			$elements_manager->add_category($category_prefix . 'mgposts', [
				'title' => esc_html__('Magical Posts Display', 'magical-posts-display'),
				'icon' => 'fa fa-magic',
			]);
		} else {
			$elements_manager->add_category(
				$category_prefix . 'mgposts',
				[
					'title' => esc_html__('Magical Posts Display', 'magical-posts-display'),
					'icon' => 'fa fa-magic',
				]
			);
			$reorder_cats = function () use ($category_prefix) {
				uksort($this->categories, function ($keyOne, $keyTwo) use ($category_prefix) {
					if (substr($keyOne, 0, 4) == $category_prefix) {
						return -1;
					}
					if (substr($keyTwo, 0, 4) == $category_prefix) {
						return 1;
					}
					return 0;
				});
			};
			$reorder_cats->call($elements_manager);
		} // check pro version

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
		wp_enqueue_style("mp-accordion-style", MAGICAL_POSTS_DISPLAY_ASSETS . 'css/widget-style/mp-accordion.css', array(), MAGICAL_POSTS_DISPLAY_VERSION, 'all');

		wp_enqueue_style("mp-tab-style", MAGICAL_POSTS_DISPLAY_ASSETS . 'css/widget-style/mp-tabs.css', array(), MAGICAL_POSTS_DISPLAY_VERSION, 'all');
	}


	/*
	plugin elementor js
	*/
	function frontend_assets_scripts()
	{

		// posts slider active
		wp_register_script(
			'mpd-slider-script-active',
			MAGICAL_POSTS_DISPLAY_ASSETS . 'js/widgets-active/post-slider-active.js',
			['jquery'],
			MAGICAL_POSTS_DISPLAY_VERSION,
			true
		);
		//posts carousel active
		wp_register_script(
			'mpd-pcarousel-active',
			MAGICAL_POSTS_DISPLAY_ASSETS . 'js/widgets-active/posts-carousel-active.js',
			['jquery'],
			MAGICAL_POSTS_DISPLAY_VERSION,
			true
		);

		// posts ticker active
		wp_enqueue_script("mpd-ticker-script-js", MAGICAL_POSTS_DISPLAY_ASSETS . 'js/widgets-active/posts-ticker-active.js', array('jquery'), MAGICAL_POSTS_DISPLAY_VERSION, true);
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
