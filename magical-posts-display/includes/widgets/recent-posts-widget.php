<?php

/**
 * Widget API: mgpd_Recent_Posts class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Core class used to implement a Recent Posts widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
if (!class_exists('mgpd_Recent_Posts')) :
	class mgpd_Recent_Posts extends WP_Widget
	{

		/**
		 * Sets up a new Recent Posts widget instance.
		 *
		 * @since 2.8.0
		 */
		public function __construct()
		{
			$widget_ops = array(
				'classname' => 'mgpd_Recent_Posts',
				'description' => __('You can show your site popular posts and recent posts by this Magical Posts display widget.', 'magical-posts-display'),
				'customize_selective_refresh' => true,
			);
			parent::__construct('mpdw-recent-posts', __('Advance Posts Widget', 'magical-posts-display'), $widget_ops);
			$this->alt_option_name = 'mgpd_Recent_Posts';
		}

		/**
		 * Outputs the content for the current Recent Posts widget instance.
		 *
		 * @since 2.8.0
		 *
		 * @param array $args Display arguments including 'before_title', 'after_title',
		 *                    'before_widget', and 'after_widget'.
		 * @param array $instance Settings for the current Recent Posts widget instance.
		 */
		public function widget($args, $instance)
		{
			if (!isset($args['widget_id'])) {
				$args['widget_id'] = $this->id;
			}

			$title = (!empty($instance['title'])) ? $instance['title'] : __('Recent Posts');
			$title = apply_filters('widget_title', $title, $instance, $this->id_base);

			$number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
			if (!$number) {
				$number = 5;
			}
			$show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : true;
			$psourch = isset($instance['psourch']) ? sanitize_text_field($instance['psourch']) : 'one-psourch';
			$mpcats = isset($instance['mpcats']) ? sanitize_text_field($instance['mpcats']) : 'select-cat';
			$mpwpstyle = isset($instance['mpwpstyle']) ? sanitize_text_field($instance['mpwpstyle']) : 'onestyle';

			$pdatas = array(
				'posts_per_page' => $number,
				'no_found_rows' => true,
				'post_status' => 'publish',
				'ignore_sticky_posts' => true,
			);
			if ($psourch == 'two-psourch') {
				$pdatas['meta_key'] = 'mpd_my_post_viewed';
				$pdatas['orderby'] = 'meta_value_num';
			}

			if ('select-cat' != $mpcats && (mp_display_check_main_ok() || mp_display_author_namet() == 'wptheme space pro')) {
				$pdatas['tax_query'][] = array(
					array(
						'taxonomy' => 'category',
						'terms' => $mpcats,
						'field' => 'term_id',
						'include_children' => false
					)
				);
			}

			$r = new WP_Query(apply_filters('widget_posts_args', $pdatas, $instance));

			if (!$r->have_posts()) {
				return;
			}

			echo $args['before_widget'];
			if ($title) {
				echo $args['before_title'] . esc_html($title) . $args['after_title'];
			}
?>
			<ul class="mpdw-recent-posts <?php echo esc_attr($mpwpstyle); ?>">
				<?php foreach ($r->posts as $recent_post) : ?>
					<?php
					$post_title = get_the_title($recent_post->ID);
					$title = (!empty($post_title)) ? $post_title : __('no title', 'magical-posts-display');
					?>
					<li class="mpdw-recent-item mb-3">
						<div class="row">
							<?php if (has_post_thumbnail($recent_post->ID)) : ?>
								<div class="col-sm-4">
									<div class="mpdw-recent-img mb-1">
										<?php echo get_the_post_thumbnail($recent_post->ID, 'medium'); ?>
									</div>
								</div>
								<div class="col-sm-8">
								<?php else : ?>
									<div class="col-sm-12">
									<?php endif; ?>
									<div class="mpdw-recent-text">
										<h4><a href="<?php echo esc_url(get_permalink($recent_post->ID)); ?>"><?php echo esc_html(wp_trim_words($title, 6, '..')); ?></a></h4>
										<?php if ($show_date) : ?>
											<span class="post-date"><?php echo esc_html(get_the_date('M j, Y', $recent_post->ID)); ?></span>
										<?php endif; ?>
									</div>
									</div>
								</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php
			echo $args['after_widget'];
		}

		/**
		 * Handles updating the settings for the current Recent Posts widget instance.
		 *
		 * @since 2.8.0
		 *
		 * @param array $new_instance New settings for this instance as input by the user via
		 *                            WP_Widget::form().
		 * @param array $old_instance Old settings for this instance.
		 * @return array Updated settings to save.
		 */
		public function update($new_instance, $old_instance)
		{
			$instance = $old_instance;
			$instance['title'] = sanitize_text_field($new_instance['title']);
			$instance['number'] = (int) $new_instance['number'];
			$instance['show_date'] = isset($new_instance['show_date']) ? (bool) $new_instance['show_date'] : true;
			$instance['psourch'] = isset($new_instance['psourch']) ? sanitize_text_field($new_instance['psourch']) : 'one-psourch';
			$instance['mpcats'] = isset($new_instance['mpcats']) ? sanitize_text_field($new_instance['mpcats']) : 'select-cat';
			$instance['mpwpstyle'] = isset($new_instance['mpwpstyle']) ? sanitize_text_field($new_instance['mpwpstyle']) : 'onestyle';

			return $instance;
		}

		/**
		 * Outputs the settings form for the Recent Posts widget.
		 *
		 * @since 2.8.0
		 *
		 * @param array $instance Current settings.
		 */
		public function form($instance)
		{
			$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
			$number = isset($instance['number']) ? absint($instance['number']) : 5;
			$show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : true;
			$psourch = isset($instance['psourch']) ? esc_attr($instance['psourch']) : 'one-psourch';
			$mpcats = isset($instance['mpcats']) ? esc_attr($instance['mpcats']) : 'select-cat';
			$mpwpstyle = isset($instance['mpwpstyle']) ? esc_attr($instance['mpwpstyle']) : 'onestyle';
			$terms = get_terms(array(
				'taxonomy' => 'category',
				'hide_empty' => true,
			));
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'magical-posts-display'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of posts to show:', 'magical-posts-display'); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('psourch')); ?>"><?php esc_html_e('Posts show by:', 'magical-posts-display'); ?></label>
				<select id="<?php echo esc_attr($this->get_field_id('psourch')); ?>" name="<?php echo esc_attr($this->get_field_name('psourch')); ?>">
					<option value="one-psourch" <?php selected($psourch, 'one-psourch'); ?>>
						<?php esc_html_e('Recent post', 'magical-posts-display'); ?>
					</option>
					<option value="two-psourch" <?php selected($psourch, 'two-psourch'); ?>>
						<?php esc_html_e('Popular post', 'magical-posts-display'); ?>
					</option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('mpcats')); ?>"><?php esc_html_e('Posts Categories:', 'magical-posts-display'); ?></label>
				<select id="<?php echo esc_attr($this->get_field_id('mpcats')); ?>" name="<?php echo esc_attr($this->get_field_name('mpcats')); ?>">
					<option value="select-cat" <?php selected($mpcats, 'select-cat'); ?>>
						<?php esc_html_e('All Categories', 'magical-posts-display', 'magical-posts-display'); ?>
					</option>
					<?php
					if (!empty($terms) && !is_wp_error($terms)) {
						foreach ($terms as $term) {
					?>
							<option value="<?php echo esc_attr($term->term_id); ?>" <?php selected($mpcats, $term->term_id); ?>>
								<?php echo esc_html($term->name); ?>
							</option>
					<?php
						}
					}
					?>
				</select>
				<span style="color: red;font-size:12px"><?php esc_html_e('Only Work with pro version', 'magical-posts-display'); ?></span>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('mpwpstyle')); ?>"><?php esc_html_e('Style:', 'magical-posts-display'); ?></label>
				<select id="<?php echo esc_attr($this->get_field_id('mpwpstyle')); ?>" name="<?php echo esc_attr($this->get_field_name('mpwpstyle')); ?>">
					<option value="onestyle" <?php selected($mpwpstyle, 'onestyle'); ?>>
						<?php esc_html_e('Style One', 'magical-posts-display'); ?>
					</option>
					<option value="twostyle" <?php selected($mpwpstyle, 'twostyle'); ?>>
						<?php esc_html_e('Style Two', 'magical-posts-display'); ?>
					</option>
				</select>
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php checked($show_date); ?> id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" />
				<label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>"><?php esc_html_e('Display post date?', 'magical-posts-display'); ?></label>
			</p>
<?php
		}
	}

	function reg_mpd_recent_widget()
	{
		register_widget('mgpd_Recent_Posts');
	}
	add_action('widgets_init', 'reg_mpd_recent_widget');

endif;
?>