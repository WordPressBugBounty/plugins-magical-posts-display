<?php

/**
 * Plugin Name: Magical Posts Display
 * Plugin URI: http://wpthemespace.com/magical-posts-display
 * Description: Show your site posts, Pages and Custom Post Types with many different styles by Elementor Widgets.
 * Version: 1.2.57
 * Author: Noor Alam
 * Author URI: http://wpthemespace.com
 * Text Domain: magical-posts-display
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package magical-posts-display
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
if (!class_exists('magicalPostDisplay')) :
	final class magicalPostDisplay
	{

		/**
		 * Plugin Version
		 *
		 * @since 1.0.0
		 *
		 * @var string The plugin version.
		 */
		const version = '1.2.57';

		/**
		 * Minimum PHP Version
		 *
		 * @since 1.0.0
		 *
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const MINIMUM_PHP_VERSION = '7.4';
		/**
		 * Instance
		 *
		 * @since 1.0.0
		 *
		 * @access private
		 * @static
		 *
		 * @var magicalPostDisplay The single instance of the class.
		 */
		private static $_instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @static
		 *
		 * @return magicalPostDisplay An instance of the class.
		 */
		public static function instance()
		{

			if (is_null(self::$_instance)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function __construct()
		{

			//add_action('activated_plugin', [$this, 'mgpd_plugin_homego']);
			$this->define_constants();
			add_action('plugins_loaded', [$this, 'init']);
			add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'admin_adminpro_link']);
			require_once('lib/custom-template/pagetemplater.php');
			require_once('includes/elementor/extra.php');
		}

		// After active go homepage - functionality removed
		// Was: mgpd_plugin_homego method for redirect after activation

		public  function admin_adminpro_link($links)
		{
			$newlink = sprintf("<a target='_blank' href='%s'><span style='color:red;font-weight:bold'>%s</span></a>", esc_url('https://wpthemespace.com/product/magical-posts-display-pro/?add-to-cart=8239'), __('Get Pro', 'magical-posts-display'));
			if (empty(mp_display_check_main_ok())) {
				$links[] = $newlink;
				return $links;
			}
			return $links;
		}

		public function define_constants()
		{
			define('MAGICAL_POSTS_DISPLAY_VERSION', self::version);
			define('MAGICAL_POSTS_DISPLAY_FILE', __FILE__);
			define('MAGICAL_POSTS_DISPLAY_DIR', plugin_dir_path(__FILE__));
			define('MAGICAL_POSTS_DISPLAY_URL', plugins_url('', MAGICAL_POSTS_DISPLAY_FILE));
			define('MAGICAL_POSTS_DISPLAY_ASSETS', MAGICAL_POSTS_DISPLAY_URL . '/assets/');
		}


		/**
		 * Initialize the plugin
		 *
		 * Load the plugin only after Elementor (and other plugins) are loaded.
		 * Checks for basic plugin requirements, if one check fail don't continue,
		 * if all check have passed load the files required to run the plugin.
		 *
		 * Fired by `plugins_loaded` action hook.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function init()
		{
			// Include all plugin files
			require_once('file-include.php');

			// Initialize new user settings
			$this->mgposts_new_user();

			// Check for required PHP version
			if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
				return; // Admin notice is now handled by admin-info.php
			}

			// Load Elementor integration if available
			if (did_action('elementor/loaded')) {
				require_once('includes/elementor/elementor-main.php');
			}

			// Track plugin activation and installation
			$this->track_plugin_usage();

			// Appsero tracking removed with vendor dependencies
		}

		/**
		 * Track plugin usage
		 */
		public function track_plugin_usage()
		{
			$is_plugin_activated = get_option('mgposte_plugin_activated');
			if ('yes' !== $is_plugin_activated) {
				update_option('mgposte_plugin_activated', 'yes');
			}

			$mgposte_install_date = get_option('mgposte_install_date');
			if (empty($mgposte_install_date)) {
				update_option('mgposte_install_date', current_time('mysql'));
			}

			// Initialize Appsero tracking
			$this->appsero_init_tracker_magical_posts_display();
		}

		public function mgposts_new_user()
		{

			$install_date = gmdate("Y-m-d", strtotime(get_option('mgposte_install_date', current_time('mysql', true))));

			$compare_date = '2023-03-02';

			if ($compare_date > $install_date) {
				update_option('mgposte_latest_activated', 1);
			}
		}

		// Appsero tracker function removed with vendor dependencies
		/**
		 * Initialize the plugin tracker
		 *
		 * @return void
		 */
		function appsero_init_tracker_magical_posts_display()
		{
			global $pagenow;
			if ($pagenow == 'plugins.php') {
				return;
			}

			if (!class_exists('Appsero\Client')) {
				return; // Autoloader should have loaded this, if not available, skip
			}

			$client = new Appsero\Client('b22159f0-7a14-46d4-b250-ce15883ee621', 'Magical Posts Display', __FILE__);

			// Active insights
			$client->insights()->init();
		}

	}
	magicalPostDisplay::instance();
endif;
