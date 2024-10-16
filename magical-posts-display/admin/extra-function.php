<?php
/*
 * Extra function for this plugin.
 *
 * @link              http://awesomebootstrap.net
 * @since             1.0.0
 * @package           magical post display
 */

//add group fields 

if (!function_exists('mp_display_get_term_options')) :
	function mp_display_get_term_options($taxonomy)
	{
		global $wp_version;
		if ($wp_version >= 4.5) {
			$args = array(
				'taxonomy' => $taxonomy,
				'orderby'    => 'count',
				'hide_empty' => 0,
			);
			$terms = get_terms($args);
		} else {
			$args = array(
				'orderby'    => 'count',
				'hide_empty' => 0,
			);
			$terms = get_terms($taxonomy, $args);
		}
		if ('post_tag' == $taxonomy) {
			$cat_name = __('Tag', 'magical-posts-display');
		} else {
			$cat_name = !empty($taxonomy) ? $taxonomy : __('items', 'magical-posts-display');
		}
		$cat = array();

		$cat['latest'] =  sprintf(__('Select', 'magical-posts-display') . ' %s', $cat_name);

		if (!empty($terms) && !is_wp_error($terms)) :
			foreach ($terms as $term) :
				$cat[$term->slug] = esc_html($term->name);
			endforeach;
		endif;

		return $cat;
	}
endif;



//Admin notice 
if (!function_exists('spacehide_go_me')) :
	function spacehide_go_me()
	{
		global $pagenow;
		if ($pagenow != 'themes.php') {
			return;
		}

		$class = 'notice notice-success is-dismissible';
		$url1 = esc_url('https://wpthemespace.com/product-category/pro-theme/');

		$message = __('<strong><span style="color:red;">Latest WordPress Theme:</span>  <span style="color:green"> If you find a Secure, SEO friendly, full functional premium WordPress theme for your site then </span>  </strong>', 'niso');

		printf(
			'<div class="%1$s" style="padding:10px 15px 20px;"><p>%2$s <a href="%3$s" target="_blank">%4$s</a>.</p><a target="_blank" class="button button-danger" href="%3$s" style="margin-right:10px">%5$s</a></div>',
			esc_attr($class),
			wp_kses_post($message),
			esc_url($url1),
			esc_html__('see here', 'magical-posts-display'),
			esc_html__('View WordPress Theme', 'magical-posts-display')
		);
	}
	add_action('admin_notices', 'spacehide_go_me');
endif;
