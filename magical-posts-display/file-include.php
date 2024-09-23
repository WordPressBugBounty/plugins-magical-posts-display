<?php
/*
*
* Magical posts display 
* All files includes
*
*
*
*/

$mg_args = array(
	'posts_per_page' => -1,
	'ignore_sticky_posts' => 1,
	'post_type' => 'mp-display',

);

$mgposts = get_posts($mg_args);
$install_date = gmdate("Y-m-d", strtotime(get_option('mgposte_install_date')));
$compare_date = '2023-03-07';

if (is_admin()) {
	// We are in admin mode

	if ($mgposts || class_exists('magicalPostDisplayPro')) {
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/src/cmb2/init.php');
	}
	if ($mgposts) {
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/mp-display-post.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/mp-display-admin-role.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/mp-display-column-set.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/mp-display-update-massage.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/src/cmb2-tabs/cmb2-tabs.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/src/cmb-field-select2/cmb-field-select2.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/src/cmb2-slider/slider-field.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/src/cmb2-radio-image.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/src/cmb2-switch-button.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/mp-display-meta-tab.php');
	}


	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/extra-function.php');
	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/admin-page/class.settings-api.php');
	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'admin/admin-page/admin-page.php');
} // check is admin

if ($mgposts) {
	require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/mp-display-shortcode.php');
}


// all posts function
require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/mp-posts-function.php');


require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/mp-posts-meta.php');
require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/widgets/recent-posts-widget.php');




if ($compare_date > $install_date) {
	if (!did_action('elementor/loaded')) {
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/blocks/posts-slider.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/blocks/posts-carousel.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/blocks/posts-grid.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/blocks/posts-list-card.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/blocks/awesome-posts-lists.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/blocks/posts-accordion.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/blocks/posts-tab.php');
		require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/blocks/posts-ticker.php');
	}
}







/*
	*
	* Plugin activation hook
	*
	*/
function mp_display_activation_setup()
{
	// Trigger our function that registers the custom post type
	mp_display_post_type();

	// Clear the permalinks after the post type has been registered
	flush_rewrite_rules();
	// Add new administrator role
	mp_display_admin_role();
}

/*
	*
	* Plugin deactivation hook
	*
	*/

function mp_display_deactivation_setup()
{

	// Clear the permalinks to remove our post type's rules
	flush_rewrite_rules();

	// gets the administrator role remove
	mp_display_admin_role_remove();
}

register_activation_hook(__FILE__, 'mp_display_activation_setup');
register_deactivation_hook(__FILE__, 'mp_display_deactivation_setup');




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

if (!function_exists('mpd_count_post_visits')) {
	function mpd_count_post_visits()
	{
		if (is_single()) {
			global $post;
			$views = get_post_meta($post->ID, 'mpd_my_post_viewed', true);
			if ($views == '') {
				update_post_meta($post->ID, 'mpd_my_post_viewed', '1');
			} else {
				$views_no = intval($views);
				update_post_meta($post->ID, 'mpd_my_post_viewed', ++$views_no);
			}
		}
	}
	add_action('wp_head', 'mpd_count_post_visits');
}
