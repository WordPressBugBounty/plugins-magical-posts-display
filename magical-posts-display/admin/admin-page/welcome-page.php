<?php

/**
 * Dashboard home tab template
 */

defined('ABSPATH') || die();
?>

<div id="mgpdp1" class="magical-post-display mgpdp1">
	<div class="mg-cols">
		<section class="sec-wel" <?php if (!class_exists('magicalPostDisplayPro')) : ?> style="background-image: url(<?php echo esc_url(MAGICAL_POSTS_DISPLAY_ASSETS . 'img/blue.svg'); ?>);" <?php else : ?>style="background-image: url(<?php echo esc_url(MAGICAL_POSTS_DISPLAY_ASSETS . 'mg/purple.svg'); ?>);" <?php endif; ?>>
			<div class="wel-center-text">
				<div class="welsec-icon">
					<img src="<?php echo esc_url(MAGICAL_POSTS_DISPLAY_ASSETS . 'img/icons/coffee.svg'); ?>">
				</div>
				<div class="wel-sect-text">
					<h1><?php esc_html_e('Welcome Magical Posts Display', 'magical-posts-display'); ?></h1>
					<h5><?php esc_html_e('Thank you for installing Magical Posts Display WordPress plugin, It\'s awesome !! ', 'magical-posts-display'); ?><br><?php esc_html_e(' Now You can show your site posts awesome way!!', 'magical-posts-display'); ?></h5>
					<a class="button button-mgp1 venoboxvid btn-lg vbox-item mgyouvideo" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/watch?v=7BCThHcUSHk">
						<?php esc_html_e('See Short Video', 'magical-posts-display'); ?>
					</a>

					<?php if (!class_exists('magicalPostDisplayPro')) : ?>
						<a href="https://wpthemespace.com/product/magical-posts-display-pro/" class="button button-mgp1 button-mgp2"><?php esc_html_e('Buy Pro Now', 'magical-posts-display'); ?></a>
					<?php endif; ?>
				</div>

			</div>
		</section>
		<section class="mgfeature mgf1">
			<div class="cols">
				<div class="col-2">
					<div class="mgfimg">
						<img src="<?php echo esc_url(MAGICAL_POSTS_DISPLAY_ASSETS . 'img/blocks-intro.svg'); ?>">
					</div>
				</div>
				<div class="col-2">
					<div class="mgftext">
						<h2><?php esc_html_e('WordPress Elementor Posts Display Addons', 'magical-posts-display'); ?></h2>
						<p><?php esc_html_e('Now you can easily display your site posts many diffrent way. You can show your posts by posts carousel, posts grid, posts list grid, posts list, posts accordion, posts categories tab, So save your time and money.', 'magical-posts-display'); ?></p>
						<a href="<?php echo esc_url(get_admin_url()); ?>post-new.php?post_type=page" class="button button-mgp1 button-mgp2"><?php esc_html_e('Create Your Page With Magical Posts Blocks', 'magical-posts-display'); ?></a>
					</div>
				</div>
			</div>
		</section>
		<section id="mgvideos" class="mgfeature mgf2">
			<div class="wel-center-text">
				<div class="mpd-sect-text">
					<h1><?php esc_html_e('Video Tutorial', 'magical-posts-display'); ?></h1>
					<h5><?php esc_html_e('How to use Magical Posts Display WordPress plugin in your site? ', 'magical-posts-display'); ?></h5>
				</div>
				<div class="cols">
					<div class="col-4">
						<div class="mgvideo">
							<a class="btn btn-danger venoboxvid btn-lg vbox-item mgyouvideo" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/watch?v=Dta4CwqvILI">
								<img src="https://img.youtube.com/vi/Dta4CwqvILI/0.jpg" alt="<?php echo esc_attr__('Video tutorial', 'magical-posts-display'); ?>">
							</a>
							<h3><?php esc_html_e('Magical Posts Carousel Video', 'magical-posts-display'); ?></h3>
						</div>
					</div>
					<div class="col-4">
						<div class="mgvideo">
							<a class="btn btn-danger venoboxvid btn-lg vbox-item mgyouvideo" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/watch?v=cGGZjLLFTao">
								<img src="https://img.youtube.com/vi/cGGZjLLFTao/0.jpg" alt="<?php echo esc_attr__('Video tutorial', 'magical-posts-display'); ?>">
							</a>
							<h3><?php esc_html_e('Magical Posts Grid Video', 'magical-posts-display'); ?></h3>
						</div>
					</div>
					<div class="col-4">
						<div class="mgvideo">
							<a class="btn btn-danger venoboxvid btn-lg vbox-item mgyouvideo" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/watch?v=EurYISxEtec">
								<img src="https://img.youtube.com/vi/EurYISxEtec/0.jpg" alt="<?php echo esc_attr__('Video tutorial', 'magical-posts-display'); ?>">
							</a>
							<h3><?php esc_html_e('Magical Posts Accordion Video', 'magical-posts-display'); ?></h3>
						</div>
					</div>
					<div class="col-4">
						<div class="mgvideo">
							<a class="btn btn-danger venoboxvid btn-lg vbox-item mgyouvideo" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/watch?v=bsXWQ9y79Ew">
								<img src="https://img.youtube.com/vi/bsXWQ9y79Ew/0.jpg" alt="<?php echo esc_attr__('Video tutorial', 'magical-posts-display'); ?>">
							</a>
							<h3><?php esc_html_e('Magical Posts Awesome List Video', 'magical-posts-display'); ?></h3>
						</div>
					</div>
					<div class="col-4">
						<div class="mgvideo">
							<a class="btn btn-danger venoboxvid btn-lg vbox-item mgyouvideo" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/watch?v=R-aOHV5EPpU">
								<img src="https://img.youtube.com/vi/R-aOHV5EPpU/0.jpg" alt="<?php echo esc_attr__('Video tutorial', 'magical-posts-display'); ?>">
							</a>
							<h3><?php esc_html_e('Magical Posts Tab Video', 'magical-posts-display'); ?></h3>
						</div>
					</div>
					<div class="col-4">
						<div class="mgvideo">
							<a class="btn btn-danger venoboxvid btn-lg vbox-item mgyouvideo" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/watch?v=rj3gZ62Wtxo">
								<img src="https://img.youtube.com/vi/rj3gZ62Wtxo/0.jpg" alt="<?php echo esc_attr__('Video tutorial', 'magical-posts-display'); ?>">
							</a>
							<h3><?php esc_html_e('Magical Posts List Card Video', 'magical-posts-display'); ?></h3>
						</div>
					</div>

				</div>

			</div>
		</section>
		<section class="mgrating-sec">
			<div class="mgrating">
				<div class="mgrat-left">
					<img src="<?php echo esc_url(MAGICAL_POSTS_DISPLAY_ASSETS . 'img/icons/coffee.svg'); ?>">
				</div>
				<div class="mgrat-right">
					<h2><?php echo esc_html('Happy with Our Work?', 'magical-posts-display'); ?></h2>
					<p><?php echo esc_html('We are really thankful to you that you have chosen our plugin. If our plugin brings a smile in your face while working, please share your happiness by giving us a 5***** rating in WordPress Org. It will make us happy and won’t take more than 2 mins.', 'magical-posts-display'); ?></p>
					<a class="mgstar-link" href="https://wordpress.org/support/plugin/magical-posts-display/reviews/?filter=5" target="_blank"><?php echo esc_html('I’m Happy to Give You 5*', 'magical-posts-display'); ?></a>
				</div>
			</div>
		</section>

	</div>
</div>