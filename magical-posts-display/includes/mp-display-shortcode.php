<?php
/*
 * @link              https://wpthemespace.com
 * @since             1.0.0
 * @package           haslider slider wordpress plugin    
 * description        All slider output by this shortcode
 *
 * @ haslider slider
 */
require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/card-post/grid-post.php');
require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/card-post/list-post.php');
require_once(MAGICAL_POSTS_DISPLAY_DIR . 'includes/card-post/grid-style.php');


if (!function_exists('mp_display__shortcode')) :
	function mp_display__shortcode($atts, $content = null)
	{
		global $post;
		ob_start();
		$mp_display_atts = shortcode_atts(array(
			'id' => '',
		), $atts);

		//Query args
		$args = array(
			'post_type'  		=>	'mp-display',
			'post_status'  		=>	'publish',
			'posts_per_page' 	=> 1,
			'p'                => $mp_display_atts['id']

		);
		//start WP_Query
		$loop = new WP_Query($args);

?>

		<?php if ($loop->have_posts()) : ?>
			<?php while ($loop->have_posts()) :  $loop->the_post();

				//slider style one meta 
				$posts_card = get_post_meta(get_the_ID(), 'posts_card', 1);
				$mp_posts_card_type =  !empty($posts_card[0]['posts_card_type'])  ? $posts_card[0]['posts_card_type'] : 'grid';
			?>
				<div class="mgps mgps-<?php echo esc_attr(get_the_ID()); ?>">
					<?php
					do_action('mgp_card_style_display', get_the_ID());
					if ($mp_posts_card_type == 'grid') {
						do_action('card_grid_post_display', get_the_ID());
					} else {
						do_action('card_list_post_display', get_the_ID());
					}

					?>
				</div>


			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<div class="no-mp-display">
				<h2><?php esc_html_e('No post found!', 'magical-posts-display'); ?></h2>
			</div>
		<?php endif; ?>

<?php
		$mp_display_shortcode = ob_get_clean();
		return $mp_display_shortcode;
	}
	add_shortcode('magical-post', 'mp_display__shortcode');
endif;
