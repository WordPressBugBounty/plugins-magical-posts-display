<?php

/**
 *
 * @package Magical Posts Display
 * @since 1.2.54
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

// Load Composer autoloader
if (file_exists(MAGICAL_POSTS_DISPLAY_DIR . 'vendor/autoload.php')) {
	require_once MAGICAL_POSTS_DISPLAY_DIR . 'vendor/autoload.php';
}

// Include core classes
require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/class-assets-manager.php');
require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/class-ajax-handler.php');
require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/class-hooks-handler.php');

// Initialize core handlers
if (class_exists('MPD_Assets_Manager')) {
	MPD_Assets_Manager::init();
}

if (class_exists('MPD_Ajax_Handler')) {
	MPD_Ajax_Handler::init();
}

if (class_exists('MPD_Hooks_Handler')) {
	MPD_Hooks_Handler::init();
}

if (is_admin()) {
	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/extra-function.php');
	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/admin-page/class.settings-api.php');
	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/admin-page/admin-page.php');
} // check is admin




// all posts function
require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/mp-posts-function.php');

// Load traits
if (file_exists(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/SVG_Icons_Trait.php')) {
	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/SVG_Icons_Trait.php');
}
if (file_exists(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/Advanced_Media_Trait.php')) {
	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/Advanced_Media_Trait.php');
}
if (file_exists(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/Premium_Features_Trait.php')) {
	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/Premium_Features_Trait.php');
}
if (file_exists(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/Query_Controls_Trait.php')) {
	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/traits/Query_Controls_Trait.php');
}

// Admin info (moved to conditional include based on context)
if (is_admin() && !mpd_check_plugin_active('magical-posts-display-pro/magical-posts-display-pro.php')) {
	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/admin-page/admin-info.php');
}


require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/mp-posts-meta.php');
require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/widgets/recent-posts-widget.php');


if (!function_exists('mpd_get_option')) {
	function mpd_get_option($option, $default = '')
	{
		$value = '';
		$value = $option ? $option : $default;
		return $value;
	}
}

if (!function_exists('mpd_array_value_check')) {
	function mpd_array_value_check($array)
	{
		$output = '';
		if ($array) {
			foreach ($array as $key => $value) {
				if ($value) {
					$output = true;
				}
			}
		}
		return $output;
	}
}

if (!function_exists('mpd_get_style_item')) {
	function mpd_get_style_item($class, $items, $importent = '')
	{
		$output = '';
		if ($importent) {
			$importent = ' !important';
		} else {
			$importent = '';
		}


		if (mpd_array_value_check($items)) {
			$output .= $class;
			$output .= '{';
			if ($items) {
				foreach ($items as $key => $value) {
					if ($value) {
						if (ctype_digit($value)) {
							$output .= $key . ':' . $value . 'px' . $importent . ';';
						} else {
							$output .= $key . ':' . $value . $importent . ';';
						}
					}
				}
			}
			$output .= '}';
		}
		echo $output;
	}
}
