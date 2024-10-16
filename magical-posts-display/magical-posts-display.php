<?php
/*
 * @link              http://wpthemespace.com
 * @since             1.0.0
 * @package           Magical Posts Display
 *
 * @wordpress-plugin
 * Plugin Name:       Magical Posts Display
 * Plugin URI:        http://wpthemespace.com
 * Description:       Show your site posts, Pages and Custom Post Types with many different styles by Elementor Widgets.
 * Version:           1.2.41
 * Author:            Noor alam
 * Author URI:        https://profiles.wordpress.org/nalam-1
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       magical-posts-display
 * Domain Path:       /languages
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
		const version = '1.2.41';

		/**
		 * Minimum PHP Version
		 *
		 * @since 1.0.0
		 *
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const MINIMUM_PHP_VERSION = '5.6';


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
			require_once('lib/custom-template/pagetemplater.php');
			require_once('includes/elementor/extra.php');

			//add_action('activated_plugin', [$this, 'mgpd_plugin_homego']);
			$this->define_constants();
			add_action('init', [$this, 'i18n']);
			add_action('plugins_loaded', [$this, 'init']);
			add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'admin_adminpro_link']);
			add_action('init', [$this, 'elementor_notice_hide_options']);
		}

		// After active go homepage
		/*
	public function mgpd_plugin_homego($plugin)
	{
		if (plugin_basename(__FILE__) == $plugin) {
			wp_redirect(admin_url('admin.php?page=mgpd-page'));
			die();
		}
	}
	*/

		public  function admin_adminpro_link($links)
		{
			$newlink = sprintf("<a target='_blank' href='%s'><span style='color:red;font-weight:bold'>%s</span></a>", esc_url('https://wpthemespace.com/product/magical-posts-display-pro/?add-to-cart=8239'), __('Get Pro', 'optionsdemo'));
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
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 *
		 * Fired by `init` action hook.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function i18n()
		{

			load_plugin_textdomain('magical-posts-display');
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

			require_once('file-include.php');

			//	require_once( 'lib/carbon-fields/vendor/autoload.php' );
			$this->mgposts_new_user();

			$install_date = gmdate("Y-m-d", strtotime(get_option('mgposte_install_date', current_time('mysql', true))));
			$compare_date = '2023-03-07';
			if ($compare_date > $install_date) {
				if (!did_action('elementor/loaded')) {
					require_once('vendor/autoload.php');
					\Carbon_Fields\Carbon_Fields::boot();
				}
			}



			// Check for required PHP version
			if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
				add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
				return;
			}
			//
			add_action('admin_enqueue_scripts', [$this, 'mgpost_display_editor_scripts']);
			add_action('enqueue_block_assets', [$this, 'mgpblock_style']);
			add_action('enqueue_block_assets', [$this, 'mgpblock_scripts']);
			add_action('enqueue_block_editor_assets', [$this, 'mgpblock_editor_scripts']);

			// Add image size
			add_image_size('slider-bg', 1600, 600, true);
			add_image_size('card-grid', 600, 900, true);
			add_image_size('card-list', 600, 700, true);

			// Check if Elementor installed and activated
			if (did_action('elementor/loaded')) {
				require_once('includes/elementor/elementor-main.php');
			} else {
				global $pagenow;
				if (in_array($pagenow, array('plugins.php', 'admin.php')) && !(get_option('mgelhide9'))) {
					add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
				}
			}
			$is_plugin_activated = get_option('mgposte_plugin_activated');
			if ('yes' !== $is_plugin_activated) {
				update_option('mgposte_plugin_activated', 'yes');
			}
			$mgposte_install_date = get_option('mgposte_install_date');
			if (empty($mgposte_install_date)) {
				update_option('mgposte_install_date', current_time('mysql'));
			}
			if (!empty($mgposte_install_date)) {
				$install_day = round((time() - strtotime($mgposte_install_date)) / 24 / 60 / 60);
				if ($install_day > 2) {
					$this->appsero_init_tracker_magical_posts_display();
				}
			}
		}

		public function elementor_notice_hide_options()
		{
			if (isset($_GET['mgelhide']) && $_GET['mgelhide'] == 1) {
				//  delete_option( 'mgelhide');
				update_option('mgelhide9', 1);
			}
		}


		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have Elementor installed or activated.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_notice_missing_main_plugin()
		{
			if (get_option('mgelhide9')) {
				return;
			}
			if (isset($_GET['activate'])) unset($_GET['activate']);


			if (file_exists(WP_PLUGIN_DIR . '/elementor/elementor.php')) {
				$magial_eactive_url = wp_nonce_url('plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php');
				$message = sprintf(
					/* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
					esc_html__('%1$s Recommended %2$s plugin, which is currently NOT RUNNING  %3$s', 'magical-posts-display'),
					'<strong>' . esc_html__('Magical Posts Display', 'magical-posts-display') . '</strong>',
					'<strong>' . esc_html__('Elementor', 'magical-posts-display') . '</strong>',
					'<a class="button button-primary" style="margin-left:20px" href="' . $magial_eactive_url . '">' . __('Activate Elementor', 'magical-posts-display') . '</a>'

				);
			} else {
				$magial_einstall_url =  wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
				$message = sprintf(
					/* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
					esc_html__('%1$s Recommended %2$s plugin for use all Elementor addons, which is currently NOT RUNNING  %3$s', 'magical-posts-display'),
					'<strong>' . esc_html__('Magical Posts Display', 'magical-posts-display') . '</strong>',
					'<strong>' . esc_html__('Elementor', 'magical-posts-display') . '</strong>',
					'<a class="button button-primary" style="margin-left:20px" href="' . $magial_einstall_url . '">' . __('Install Elementor', 'magical-posts-display') . '</a>'
					/* '<a class="button skipelementor" style="margin-left:20px" href="#">' . __('Skip it for only use Gutenberg addons', 'magical-posts-display') . '</a>' */

				);
			}

			printf('<div class="notice notice-warning is-dismissible mgpd-notice"><p style="padding: 13px 0">%1$s</p></div>', wp_kses_post($message));
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
		public function mgpblock_style()
		{
			wp_register_style(
				'swiper',
				plugins_url('/assets/css/swiper.min.css', __FILE__),
				[],
				'8.4.5',
				'all'
			);

			wp_enqueue_style('venobox.min', plugins_url('/assets/css/venobox.min.css', __FILE__), array(), '1.0.0', 'all');
			wp_enqueue_style('bootstrap', plugins_url('/assets/css/bootstrap.min.css', __FILE__), array(), '5.1.1', 'all');
			wp_enqueue_style('mpd-fonts', plugins_url('/assets/css/fontello.css', __FILE__), array(), MAGICAL_POSTS_DISPLAY_VERSION, 'all');
			//	wp_enqueue_style('swiper.min', plugins_url('/assets/css/swiper.min.css', __FILE__), array(), '5.3.8', 'all');
			wp_enqueue_style('mpd-style', plugins_url('/assets/css/mp-style.css', __FILE__), array(), MAGICAL_POSTS_DISPLAY_VERSION, 'all');
		}

		public function mgpblock_scripts()
		{


			wp_register_script(
				'mg-swiper',
				plugins_url('/assets/js/swiper.min.js', __FILE__),
				['jquery'],
				'8.4.5',
				true
			);

			wp_enqueue_script('masonry');
			wp_enqueue_script('venobox-js', plugins_url('/assets/js/venobox.min.js', __FILE__), array('jquery'), '1.0.0', true);
			wp_enqueue_script('bootstrap.bundle.min', plugins_url('/assets/js/bootstrap.bundle.min.js', __FILE__), array('jquery'), '5.1.1', false);
			//	wp_enqueue_script('swiper.min', plugins_url('/assets/js/swiper.min.js', __FILE__), array('jquery'), '5.3.8', false);
			wp_enqueue_script('jquery.easy-ticker', plugins_url('/assets/js/jquery.easy-ticker.min.js', __FILE__), array('jquery'), '3.1.0', false);
			wp_enqueue_script('mpd-main', plugins_url('/assets/js/main.js', __FILE__), array('jquery'), MAGICAL_POSTS_DISPLAY_VERSION, true);
		}

		/**
		 * Add style and scripts for gutenburg editor
		 *
		 * Add the plugin style and scripts for gutenburg editor
		 *
		 * @since 1.0.4
		 *
		 * @access public
		 */
		public function mgpblock_editor_scripts()
		{
			wp_enqueue_style('mp-admin-block', plugins_url('/assets/css/mgblock-admin.css', __FILE__), array(), '1.0.0', 'all');
		}


		/**
		 * Add style and scripts for editor
		 *
		 * Add the plugin style and scripts for editor only
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function mgpost_display_editor_scripts()
		{
			global $pagenow;

			if (in_array($pagenow, array('post-new.php', 'post.php'))) {
				wp_enqueue_style('mp-admin-style', plugins_url('/assets/css/admin-style.css', __FILE__), array(), '1.1.0', 'all');

				wp_enqueue_script('cmb2-conditional-logic', plugins_url('/assets/js/cmb2-conditional-logic.js', __FILE__), array('jquery'), '2.5.1', true);
			}
			if (isset($_GET['page']) && $_GET['page'] == 'mgpd-page') {
				wp_enqueue_style('mp-admin-page', plugins_url('/assets/css/mgadmin-page.css', __FILE__), array(), '1.1.0', 'all');
				wp_enqueue_style('venobox.min', plugins_url('/assets/css/venobox.min.css', __FILE__), array(), '1.0.0', 'all');
				wp_enqueue_script('venobox-js', plugins_url('/assets/js/venobox.min.js', __FILE__), array('jquery'), '1.0.0', true);
			}
			wp_enqueue_script('mgntc-js', plugins_url('/assets/js/mgntc.js', __FILE__), array('jquery'), '1.0.0', true);
		}

		public function mgposts_new_user()
		{

			$install_date = gmdate("Y-m-d", strtotime(get_option('mgposte_install_date', current_time('mysql', true))));

			$compare_date = '2023-03-02';

			if ($compare_date > $install_date) {
				update_option('mgposte_latest_activated', 1);
			}
		}




		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required PHP version.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_notice_minimum_php_version()
		{

			if (isset($_GET['activate'])) unset($_GET['activate']);

			$message = sprintf(
				/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
				esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'magical-posts-display'),
				'<strong>' . esc_html__('Magical Posts Display', 'magical-posts-display') . '</strong>',
				'<strong>' . esc_html__('PHP', 'magical-posts-display') . '</strong>',
				self::MINIMUM_PHP_VERSION
			);

			printf(
				'<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
				wp_kses_post($message)
			);
		}


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
				require_once __DIR__ . '/vendor/appsero/client/src/Client.php';
			}

			$client = new Appsero\Client('b22159f0-7a14-46d4-b250-ce15883ee621', 'Magical Posts Display', __FILE__);

			// Active insights
			$client->insights()->init();
		}
	}
	magicalPostDisplay::instance();
endif;
