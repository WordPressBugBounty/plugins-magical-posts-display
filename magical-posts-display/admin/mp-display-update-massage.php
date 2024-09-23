<?php
/*
 * Register haslider slider post type. 
 * This is administrator only post type. 
 *
 * @link              http://digitalkroy.com/mp-display
 * @since             1.0.0
 * @package           haslider slider
 *
 * @wordpress-plugin
 */

/**
 * haslider slider update messages.
 *
 *
 */
if (!function_exists('mp_display_updated_messages')) :
	function mp_display_updated_messages($messages)
	{
		global $post;
		$post_ID = $post->ID;
		$post             = get_post();
		$post_type        = get_post_type($post);
		$post_type_object = get_post_type_object($post_type);
		$pslider_shortcode = '[magical-post id="' . $post_ID . '"]';
		$messages['mp-display'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __('slider updated. Shortcode is:', 'magical-posts-display') . '<input style="min-width:165px" type=\'text\' onClick=\'this.setSelectionRange(0, this.value.length)\' value=\'' . $pslider_shortcode . '\' />',
			2  => __('slider field updated. Shortcode is:', 'magical-posts-display') . '<input style="min-width:165px" type=\'text\' onClick=\'this.setSelectionRange(0, this.value.length)\' value=\'' . $pslider_shortcode . '\' />',
			3  => __('slider field deleted.', 'magical-posts-display'),
			4  => __('slider item updated.', 'magical-posts-display'),
			/* translators: %s: date and time of the revision */
			5  => isset($_GET['revision']) ? sprintf(__('slider restored to revision from %s', 'magical-posts-display'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
			6  =>  __('slider published. Shortcode is:', 'magical-posts-display') . '<input style="min-width:165px" type=\'text\' onClick=\'this.setSelectionRange(0, this.value.length)\' value=\'' . $pslider_shortcode . '\' />',
			7  => __('slider saved.', 'magical-posts-display') . '<input style="min-width:165px" type=\'text\' onClick=\'this.setSelectionRange(0, this.value.length)\' value=\'' . $pslider_shortcode . '\' />',
			8  => __('slider submitted.', 'magical-posts-display') . '<input style="min-width:165px" type=\'text\' onClick=\'this.setSelectionRange(0, this.value.length)\' value=\'' . $pslider_shortcode . '\' />',
			9 => sprintf(
				// translators: %s: Scheduled date and time of the slider item
				__('Slider item scheduled for: <strong>%s</strong>.', 'magical-posts-display'),
				date_i18n(
					// translators: Publish box date format, see http://php.net/date
					__('M j, Y @ G:i', 'magical-posts-display'),
					strtotime($post->post_date)
				)
			),
			10 => __('slider draft updated.', 'magical-posts-display')
		);


		return $messages;
	}
	add_filter('post_updated_messages', 'mp_display_updated_messages');
endif;
