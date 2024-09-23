<?php
/*
 * Template Name: Magical Posts Display
 * Description: A Page Template for magical posts display plugin
 */

get_header();
?>
	<main id="mgpdisplay-page" class="site-main magical-posts-template">

		<?php
			while ( have_posts() ) :
				the_post();
		?>
		<?php if(has_post_thumbnail()): ?>
		<div class="page-featured-image">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?> 
		<div class="container">
			<div class="entry-content">
				<?php
				the_content();

				?>
			</div><!-- .entry-content -->
		</div><!-- .container -->
	<?php
			endwhile; // End of the loop.
		?>

	</main><!-- #main -->


<?php
get_footer();
