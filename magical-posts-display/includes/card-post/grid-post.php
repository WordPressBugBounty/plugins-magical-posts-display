<?php
/*
*
* Template for show grid posts
*
*
*/

if (!function_exists('mp_display_posts_grid_display')) :
	function mp_display_posts_grid_display($id)
	{
		$posts_card = get_post_meta($id, 'posts_card', true);
		$mp_posts_show_by =  !empty($posts_card[0]['posts_show_by'])  ? $posts_card[0]['posts_show_by'] : 'latest';
		$mp_posts_cat =  !empty($posts_card[0]['posts_cat'])  ? $posts_card[0]['posts_cat'] : 'latest';
		$mp_posts_tag =  !empty($posts_card[0]['posts_tag'])  ? $posts_card[0]['posts_tag'] : 'latest';
		$mp_set_posts_num =  !empty($posts_card[0]['set_posts_num'])  ? $posts_card[0]['set_posts_num'] : 'all';
		$mp_posts_number =  !empty($posts_card[0]['posts_number'])  ? $posts_card[0]['posts_number'] : '10';
		$grid_column =  !empty($posts_card[0]['grid_column'])  ? $posts_card[0]['grid_column'] : '4';
		$mp_button_style =  !empty($posts_card[0]['button_style'])  ? $posts_card[0]['button_style'] : 'primary';
		$mgposts_btn =  !empty($posts_card[0]['mgposts_btn'])  ? $posts_card[0]['mgposts_btn'] : 'show';
		$mp_btn_text =  !empty($posts_card[0]['btn_text'])  ? $posts_card[0]['btn_text'] : __('Read More', 'magical-posts-display');
		$mp_post_pagination =  !empty($posts_card[0]['post_pagination'])  ? $posts_card[0]['post_pagination'] : '';
		//posts number set 
		if ($mp_set_posts_num == 'all') {
			$mp_posts_number = -1;
		}

		$posts_meta = get_post_meta($id, 'posts_meta', true);
		$mgposts_img =  !empty($posts_meta[0]['mgposts_img'])  ? $posts_meta[0]['mgposts_img'] : 'show';
		$mgposts_title =  !empty($posts_meta[0]['mgposts_title'])  ? $posts_meta[0]['mgposts_title'] : 'show';
		$mgposts_title_words =  !empty($posts_meta[0]['mgposts_title_words'])  ? $posts_meta[0]['mgposts_title_words'] : '5';
		$mgpost_desc =  !empty($posts_meta[0]['mgpost_desc'])  ? $posts_meta[0]['mgpost_desc'] : 'show';
		$mgposts_desc_words =  !empty($posts_meta[0]['mgposts_desc_words'])  ? $posts_meta[0]['mgposts_desc_words'] : '25';
		$mp_post_cat =  !empty($posts_meta[0]['post_cat'])  ? $posts_meta[0]['post_cat'] : '';
		$mp_post_author =  !empty($posts_meta[0]['post_author'])  ? $posts_meta[0]['post_author'] : '';
		$mp_post_date =  !empty($posts_meta[0]['post_date'])  ? $posts_meta[0]['post_date'] : '';
		$mp_post_comment =  !empty($posts_meta[0]['post_comment'])  ? $posts_meta[0]['post_comment'] : '';
		$mp_post_tag =  !empty($posts_meta[0]['post_tag'])  ? $posts_meta[0]['post_tag'] : '';



?>
		<div class="mp-display-gird grid1">
			<div class="row">
				<?php
				//post order
				if ($mp_posts_show_by == 'ASC') {
					$post_order = $mp_posts_show_by;
				} else {
					$post_order = 'DESC';
				}

				if ($mp_posts_cat != 'latest' && $mp_posts_show_by == 'category') {
					$terms = array(
						array(
							'taxonomy'  => 'category',
							'field'  => 'slug',
							'terms'  => $mp_posts_cat
						)
					);
				} elseif ($mp_posts_tag != 'latest' && $mp_posts_show_by == 'tag') {
					$terms = array(
						array(
							'taxonomy'  => 'post_tag',
							'field'  => 'slug',
							'terms'  => $mp_posts_tag
						)
					);
				} else {
					$terms = '';
				}

				if (is_front_page()) {
					$paged = (get_query_var('page')) ? get_query_var('page') : 1;
				} else {
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				}
				$mgpg_args = array(
					'post_type'  		=>	'post',
					'post_status'  		=>	'publish',
					'posts_per_page' 	=> $mp_posts_number,
					'tax_query' 	    =>	$terms,
					'order'   => $post_order,
					'paged'   => $paged,
					'ignore_sticky_posts' => 1
				);
				$mgpg_loop = new WP_Query($mgpg_args);
				if ($mgpg_loop->have_posts()) :
					while ($mgpg_loop->have_posts()) :  $mgpg_loop->the_post();
						$post_thumb_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
						//tag list
						$tags_list = get_the_tag_list();
				?>
						<div class="col-lg-<?php echo esc_attr($grid_column); ?>">
							<div class="card mgps-card mb-4">
								<?php if ($mgposts_img == 'show') : ?>
									<?php if (has_post_thumbnail()) : ?>
										<?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
									<?php else : ?>
										<div class="no-post-thumbnail"></div>
									<?php endif; ?>
								<?php endif; ?>
								<div class="card-body">
									<?php if ($mp_post_cat) : ?>
										<div class="mp-meta cat-list">
											<?php mp_display_category_link(); ?>
										</div>
									<?php endif; ?>
									<?php if ($mgposts_title == 'show') : ?>
										<h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php echo esc_html(wp_trim_words(get_the_title(), $mgposts_title_words)); ?></a></h5>
									<?php endif; ?>
									<?php if (!empty($mp_post_author) || !empty($mp_post_date) || !empty($mp_post_comment)) : ?>
										<div class="mp-meta bottom-meta mb-2">
											<?php
											if ($mp_post_author) {
												mp_display_posted_by();
											}
											if ($mp_post_date) {
												mp_display_posted_on();
											}
											if ($mp_post_comment) {
												mp_display_single_comment_icon();
											}
											?>
										</div>
									<?php endif; ?>
									<?php if ($mgpost_desc == 'show') : ?>
										<p class="card-text"><?php echo esc_html(wp_trim_words(get_the_content(), $mgposts_desc_words)); ?></p>
									<?php endif; ?>
									<?php if ($mgposts_btn == 'show') : ?>
										<a href="<?php the_permalink(); ?>" class="btn btn-outline-<?php echo esc_attr($mp_button_style); ?>"><?php echo esc_html($mp_btn_text); ?></a>
									<?php endif; ?>
								</div>
								<?php if ($tags_list && $mp_post_tag) : ?>
									<div class="card-footer">

										<div class="mp-meta tag-list">
											<?php mp_display_tag_link(); ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>

					<?php
					endwhile;
					if (is_page() && $mp_post_pagination) {
						mp_display_pagination($paged, $mgpg_loop);
					}

					wp_reset_postdata();
				else :
					?>
					<div class="mp-error">
						<?php esc_html_e('No post found!', 'magical-posts-display'); ?>
					</div>
				<?php

				endif; ?>
			</div>
		</div>
<?php

	}
	add_action('card_grid_post_display', 'mp_display_posts_grid_display');

endif;
