<?php
/**
 * Dashboard Overview & Welcome Page Template
 *
 * @package Magical Posts Display
 */

defined('ABSPATH') || exit;

$is_pro = function_exists('mp_display_check_main_ok') ? mp_display_check_main_ok() : (class_exists('magicalPostDisplayPro') && !empty(get_option('has_magical_posts_pro')));
$version = defined('MAGICAL_POSTS_DISPLAY_VERSION') ? MAGICAL_POSTS_DISPLAY_VERSION : '1.3.0';
?>

<div id="mgpdp1" class="mgpd-dashboard-wrapper">
	<!-- Hero Section -->
	<header class="mgpd-hero-banner">
		<div class="mgpd-hero-content">
			<div class="mgpd-hero-badges">
				<span class="mgpd-badge mgpd-badge-version"><?php echo esc_html('v' . $version); ?></span>
				<?php if ($is_pro) : ?>
					<span class="mgpd-badge mgpd-badge-pro"><span class="dashicons dashicons-yes-alt"></span> <?php esc_html_e('PRO Active', 'magical-posts-display'); ?></span>
				<?php else : ?>
					<span class="mgpd-badge mgpd-badge-free"><?php esc_html_e('Free Version', 'magical-posts-display'); ?></span>
				<?php endif; ?>
			</div>

			<h1 class="mgpd-hero-title">
				<span class="dashicons dashicons-tickets-alt mgpd-hero-icon"></span>
				<?php esc_html_e('Magical Posts Display', 'magical-posts-display'); ?>
			</h1>

			<p class="mgpd-hero-subtitle">
				<?php esc_html_e('The most flexible posts showcase & theme builder solution for Elementor. Create stunning grids, carousels, lists, sliders, and dynamic templates in minutes.', 'magical-posts-display'); ?>
			</p>

			<div class="mgpd-hero-actions">
				<a href="<?php echo esc_url(admin_url('post-new.php?post_type=page')); ?>" class="mgpd-btn mgpd-btn-primary">
					<span class="dashicons dashicons-plus-alt2"></span>
					<?php esc_html_e('Create Page in Elementor', 'magical-posts-display'); ?>
				</a>

				<?php if (post_type_exists('mg_tb_template')) : ?>
					<a href="<?php echo esc_url(admin_url('admin.php?page=magical-theme-builder')); ?>" class="mgpd-btn mgpd-btn-secondary">
						<span class="dashicons dashicons-layout"></span>
						<?php esc_html_e('Theme Builder Templates', 'magical-posts-display'); ?>
					</a>
				<?php endif; ?>

				<?php if (!$is_pro) : ?>
					<a href="https://wpthemespace.com/product/magical-posts-display-pro/" target="_blank" class="mgpd-btn mgpd-btn-accent">
						<span class="dashicons dashicons-star-filled"></span>
						<?php esc_html_e('Upgrade to Pro', 'magical-posts-display'); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</header>

	<!-- Quick Start Steps -->
	<section class="mgpd-section">
		<h2 class="mgpd-section-title"><?php esc_html_e('Get Started in 3 Simple Steps', 'magical-posts-display'); ?></h2>
		<div class="mgpd-steps-grid">
			<div class="mgpd-step-card">
				<div class="mgpd-step-number">1</div>
				<h3 class="mgpd-step-heading"><?php esc_html_e('Edit with Elementor', 'magical-posts-display'); ?></h3>
				<p class="mgpd-step-desc"><?php esc_html_e('Create a new page or edit an existing one using the Elementor page builder.', 'magical-posts-display'); ?></p>
			</div>
			<div class="mgpd-step-card">
				<div class="mgpd-step-number">2</div>
				<h3 class="mgpd-step-heading"><?php esc_html_e('Drag a Posts Widget', 'magical-posts-display'); ?></h3>
				<p class="mgpd-step-desc"><?php esc_html_e('Search for "Magical" or pick Posts Grid, Carousel, Slider, or List from the panel.', 'magical-posts-display'); ?></p>
			</div>
			<div class="mgpd-step-card">
				<div class="mgpd-step-number">3</div>
				<h3 class="mgpd-step-heading"><?php esc_html_e('Customize & Publish', 'magical-posts-display'); ?></h3>
				<p class="mgpd-step-desc"><?php esc_html_e('Select layout styles, query by category/tag, configure pagination, and publish!', 'magical-posts-display'); ?></p>
			</div>
		</div>
	</section>

	<!-- Features & Widgets Showcase -->
	<section class="mgpd-section">
		<div class="mgpd-section-header">
			<h2 class="mgpd-section-title"><?php esc_html_e('Included Showcase Widgets', 'magical-posts-display'); ?></h2>
			<p class="mgpd-section-subtitle"><?php esc_html_e('Every widget is crafted with responsive controls, advanced query options, and beautiful typography.', 'magical-posts-display'); ?></p>
		</div>

		<div class="mgpd-features-grid">
			<!-- Posts Grid -->
			<div class="mgpd-feature-card">
				<div class="mgpd-feature-icon mgpd-icon-indigo">
					<span class="dashicons dashicons-grid-view"></span>
				</div>
				<h3 class="mgpd-feature-title"><?php esc_html_e('Posts Grid', 'magical-posts-display'); ?></h3>
				<p class="mgpd-feature-desc"><?php esc_html_e('Multi-column posts layout supporting fitRows, masonry layout, dynamic Ajax category filter tabs, and image overlay cards.', 'magical-posts-display'); ?></p>
				<span class="mgpd-feature-tag"><?php esc_html_e('Elementor Widget', 'magical-posts-display'); ?></span>
			</div>

			<!-- Posts Carousel -->
			<div class="mgpd-feature-card">
				<div class="mgpd-feature-icon mgpd-icon-purple">
					<span class="dashicons dashicons-images-alt2"></span>
				</div>
				<h3 class="mgpd-feature-title"><?php esc_html_e('Posts Carousel', 'magical-posts-display'); ?></h3>
				<p class="mgpd-feature-desc"><?php esc_html_e('Touch-friendly swiper carousel with autoplay, dots navigation, arrows, and multiple slides per view on mobile & desktop.', 'magical-posts-display'); ?></p>
				<span class="mgpd-feature-tag"><?php esc_html_e('Elementor Widget', 'magical-posts-display'); ?></span>
			</div>

			<!-- Posts Slider -->
			<div class="mgpd-feature-card">
				<div class="mgpd-feature-icon mgpd-icon-pink">
					<span class="dashicons dashicons-slides"></span>
				</div>
				<h3 class="mgpd-feature-title"><?php esc_html_e('Posts Slider', 'magical-posts-display'); ?></h3>
				<p class="mgpd-feature-desc"><?php esc_html_e('Hero sliders for magazine banners, featured breaking news, and homepage highlights with smooth transition effects.', 'magical-posts-display'); ?></p>
				<span class="mgpd-feature-tag"><?php esc_html_e('Elementor Widget', 'magical-posts-display'); ?></span>
			</div>

			<!-- Posts List & Accordion -->
			<div class="mgpd-feature-card">
				<div class="mgpd-feature-icon mgpd-icon-blue">
					<span class="dashicons dashicons-list-view"></span>
				</div>
				<h3 class="mgpd-feature-title"><?php esc_html_e('Posts List & Accordion', 'magical-posts-display'); ?></h3>
				<p class="mgpd-feature-desc"><?php esc_html_e('Clean list view with thumbnail side-by-side positioning, plus interactive collapsible accordions for content-heavy sites.', 'magical-posts-display'); ?></p>
				<span class="mgpd-feature-tag"><?php esc_html_e('Elementor Widget', 'magical-posts-display'); ?></span>
			</div>

			<!-- Category Tabs & Ticker -->
			<div class="mgpd-feature-card">
				<div class="mgpd-feature-icon mgpd-icon-amber">
					<span class="dashicons dashicons-category"></span>
				</div>
				<h3 class="mgpd-feature-title"><?php esc_html_e('Tabs & News Ticker', 'magical-posts-display'); ?></h3>
				<p class="mgpd-feature-desc"><?php esc_html_e('Display posts partitioned by category in tabbed sections, and keep visitors engaged with animated breaking news tickers.', 'magical-posts-display'); ?></p>
				<span class="mgpd-feature-tag"><?php esc_html_e('Elementor Widget', 'magical-posts-display'); ?></span>
			</div>

			<!-- Theme Builder Suite -->
			<div class="mgpd-feature-card">
				<div class="mgpd-feature-icon mgpd-icon-emerald">
					<span class="dashicons dashicons-layout"></span>
				</div>
				<h3 class="mgpd-feature-title"><?php esc_html_e('Theme Builder Suite', 'magical-posts-display'); ?></h3>
				<p class="mgpd-feature-desc"><?php esc_html_e('11 dedicated widgets for building custom Single Post, Blog, Archive, Search, Author Box, Post Meta, and Comments templates.', 'magical-posts-display'); ?></p>
				<span class="mgpd-feature-tag mgpd-tag-highlight"><?php esc_html_e('Theme Builder', 'magical-posts-display'); ?></span>
			</div>
		</div>
	</section>

	<!-- Resources & Community -->
	<section class="mgpd-section mgpd-community-section">
		<div class="mgpd-resources-grid">
			<div class="mgpd-resource-card">
				<div class="mgpd-res-icon"><span class="dashicons dashicons-book"></span></div>
				<h3><?php esc_html_e('Documentation', 'magical-posts-display'); ?></h3>
				<p><?php esc_html_e('Detailed documentation and tutorials to help you build magazine, news, and blog layouts.', 'magical-posts-display'); ?></p>
				<a href="https://wpthemespace.com" target="_blank" class="mgpd-card-link"><?php esc_html_e('Read Documentation &rarr;', 'magical-posts-display'); ?></a>
			</div>

			<div class="mgpd-resource-card">
				<div class="mgpd-res-icon"><span class="dashicons dashicons-sos"></span></div>
				<h3><?php esc_html_e('Need Support?', 'magical-posts-display'); ?></h3>
				<p><?php esc_html_e('Have a question, feedback, or need help configuring a widget? We are here to assist you.', 'magical-posts-display'); ?></p>
				<a href="https://wordpress.org/support/plugin/magical-posts-display/" target="_blank" class="mgpd-card-link"><?php esc_html_e('Get Support &rarr;', 'magical-posts-display'); ?></a>
			</div>

			<div class="mgpd-resource-card mgpd-resource-review">
				<div class="mgpd-res-icon mgpd-star-icon"><span class="dashicons dashicons-star-filled"></span></div>
				<h3><?php esc_html_e('Enjoying the Plugin?', 'magical-posts-display'); ?></h3>
				<p><?php esc_html_e('If Magical Posts Display helps you build better sites, please support us with a 5-star review on WordPress.org!', 'magical-posts-display'); ?></p>
				<a href="https://wordpress.org/support/plugin/magical-posts-display/reviews/?filter=5" target="_blank" class="mgpd-btn mgpd-btn-gold">
					<span class="dashicons dashicons-star-filled"></span>
					<?php esc_html_e('Leave a 5-Star Review', 'magical-posts-display'); ?>
				</a>
			</div>
		</div>
	</section>
</div>

