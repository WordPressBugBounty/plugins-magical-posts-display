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


