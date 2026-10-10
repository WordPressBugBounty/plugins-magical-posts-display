<?php
/**
 * Presets & Layouts Showcase Guide Template
 *
 * @package Magical Posts Display
 */

defined('ABSPATH') || exit;

if (!function_exists('is_plugin_active')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$mg_plugin_file    = 'magical-addons-for-elementor/magical-addons-for-elementor.php';
$is_mg_installed   = file_exists(WP_PLUGIN_DIR . '/' . $mg_plugin_file);
$has_theme_builder = function_exists('mg_tb') || class_exists('MgTB') || is_plugin_active($mg_plugin_file);
$tb_templates_url  = admin_url('admin.php?page=magical-addons#/theme-builder');
$new_page_url      = admin_url('post-new.php?post_type=page');
?>

<div class="mgpd-presets-wrapper">
    <!-- Hero Banner -->
    <div class="mgpd-presets-hero">
        <div class="mgpd-presets-hero-content">
            <span class="mgpd-badge mgpd-badge-version"><?php esc_html_e('Design Blueprint & Guide', 'magical-posts-display'); ?></span>
            <h3 class="mgpd-presets-hero-title">
                <span class="dashicons dashicons-art"></span>
                <?php esc_html_e('Post Showcase Presets & Guide', 'magical-posts-display'); ?>
            </h3>
            <p class="mgpd-presets-hero-desc">
                <?php esc_html_e('Need inspiration? Browse our popular layout styles below. Each guide blueprint tells you the exact Elementor widget to use and the optimal settings for stunning results.', 'magical-posts-display'); ?>
            </p>
            <div class="mgpd-presets-hero-actions">
                <a href="<?php echo esc_url($new_page_url); ?>" class="button button-primary mgpd-btn-hero">
                    <span class="dashicons dashicons-plus-alt2"></span>
                    <?php esc_html_e('Create New Page in Elementor', 'magical-posts-display'); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Layout Presets Grid -->
    <div class="mgpd-presets-section">
        <h3 class="mgpd-section-heading">
            <span class="dashicons dashicons-layout"></span>
            <?php esc_html_e('8 Ready-to-Build Post Layouts', 'magical-posts-display'); ?>
        </h3>

        <div class="mgpd-presets-grid">
            <!-- Preset 1 -->
            <div class="mgpd-preset-card">
                <div class="mgpd-preset-preview mgpd-gradient-1">
                    <span class="dashicons dashicons-grid-view mgpd-preset-icon"></span>
                    <span class="mgpd-preset-tag"><?php esc_html_e('Most Popular', 'magical-posts-display'); ?></span>
                </div>
                <div class="mgpd-preset-body">
                    <h4 class="mgpd-preset-title"><?php esc_html_e('1. Classic 3-Column Card Grid', 'magical-posts-display'); ?></h4>
                    <p class="mgpd-preset-text"><?php esc_html_e('The gold standard for blogs and magazine homepages. Features crisp thumbnails, category badges, author/date meta, and read more buttons.', 'magical-posts-display'); ?></p>
                    <div class="mgpd-preset-meta">
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Widget:', 'magical-posts-display'); ?></strong> <code>Posts Grid</code></div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Style:', 'magical-posts-display'); ?></strong> Style One</div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Columns:', 'magical-posts-display'); ?></strong> 3 (Desktop), 2 (Tablet), 1 (Mobile)</div>
                    </div>
                </div>
            </div>

            <!-- Preset 2 -->
            <div class="mgpd-preset-card">
                <div class="mgpd-preset-preview mgpd-gradient-2">
                    <span class="dashicons dashicons-format-gallery mgpd-preset-icon"></span>
                    <span class="mgpd-preset-tag"><?php esc_html_e('Modern Magazine', 'magical-posts-display'); ?></span>
                </div>
                <div class="mgpd-preset-body">
                    <h4 class="mgpd-preset-title"><?php esc_html_e('2. Magazine Image Overlay Grid', 'magical-posts-display'); ?></h4>
                    <p class="mgpd-preset-text"><?php esc_html_e('Stunning magazine style with high-impact image overlays, floating badges, and high-contrast typography.', 'magical-posts-display'); ?></p>
                    <div class="mgpd-preset-meta">
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Widget:', 'magical-posts-display'); ?></strong> <code>News/Magazine Image Grid</code></div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Style:', 'magical-posts-display'); ?></strong> Classic Magazine or Featured Focus</div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Image Ratio:', 'magical-posts-display'); ?></strong> 16:9 Landscape</div>
                    </div>
                </div>
            </div>

            <!-- Preset 3 -->
            <div class="mgpd-preset-card">
                <div class="mgpd-preset-preview mgpd-gradient-3">
                    <span class="dashicons dashicons-images-alt2 mgpd-preset-icon"></span>
                    <span class="mgpd-preset-tag"><?php esc_html_e('Interactive', 'magical-posts-display'); ?></span>
                </div>
                <div class="mgpd-preset-body">
                    <h4 class="mgpd-preset-title"><?php esc_html_e('3. Touch Swiper Posts Carousel', 'magical-posts-display'); ?></h4>
                    <p class="mgpd-preset-text"><?php esc_html_e('Silky smooth Swiper carousel with mobile touch gestures, navigation arrows, pagination dots, and autoplay support.', 'magical-posts-display'); ?></p>
                    <div class="mgpd-preset-meta">
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Widget:', 'magical-posts-display'); ?></strong> <code>Posts Carousel</code></div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Slides Per View:', 'magical-posts-display'); ?></strong> 3 (Desktop), 1 (Mobile)</div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Autoplay Delay:', 'magical-posts-display'); ?></strong> 4000ms</div>
                    </div>
                </div>
            </div>

            <!-- Preset 4 -->
            <div class="mgpd-preset-card">
                <div class="mgpd-preset-preview mgpd-gradient-4">
                    <span class="dashicons dashicons-megaphone mgpd-preset-icon"></span>
                    <span class="mgpd-preset-tag"><?php esc_html_e('Breaking News', 'magical-posts-display'); ?></span>
                </div>
                <div class="mgpd-preset-body">
                    <h4 class="mgpd-preset-title"><?php esc_html_e('4. Animated News Ticker', 'magical-posts-display'); ?></h4>
                    <p class="mgpd-preset-text"><?php esc_html_e('Keep readers informed with real-time scrolling breaking news headlines. Perfect for header top bars or news section banners.', 'magical-posts-display'); ?></p>
                    <div class="mgpd-preset-meta">
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Widget:', 'magical-posts-display'); ?></strong> <code>Posts Ticker</code></div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Animation:', 'magical-posts-display'); ?></strong> Slide Up</div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Speed:', 'magical-posts-display'); ?></strong> 3000ms with pause on hover</div>
                    </div>
                </div>
            </div>

            <!-- Preset 5 -->
            <div class="mgpd-preset-card">
                <div class="mgpd-preset-preview mgpd-gradient-5">
                    <span class="dashicons dashicons-category mgpd-preset-icon"></span>
                    <span class="mgpd-preset-tag"><?php esc_html_e('Multi-Category', 'magical-posts-display'); ?></span>
                </div>
                <div class="mgpd-preset-body">
                    <h4 class="mgpd-preset-title"><?php esc_html_e('5. Dynamic Category Tabbed Grid', 'magical-posts-display'); ?></h4>
                    <p class="mgpd-preset-text"><?php esc_html_e('Allows visitors to switch between categories effortlessly without leaving the page. Boosts engagement and page exploration.', 'magical-posts-display'); ?></p>
                    <div class="mgpd-preset-meta">
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Widget:', 'magical-posts-display'); ?></strong> <code>Posts Tabs</code></div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Filter:', 'magical-posts-display'); ?></strong> Select 3-5 categories</div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Posts Per Tab:', 'magical-posts-display'); ?></strong> 6 items</div>
                    </div>
                </div>
            </div>

            <!-- Preset 6 -->
            <div class="mgpd-preset-card">
                <div class="mgpd-preset-preview mgpd-gradient-6">
                    <span class="dashicons dashicons-list-view mgpd-preset-icon"></span>
                    <span class="mgpd-preset-tag"><?php esc_html_e('Sidebar / Compact', 'magical-posts-display'); ?></span>
                </div>
                <div class="mgpd-preset-body">
                    <h4 class="mgpd-preset-title"><?php esc_html_e('6. Compact Thumbnail Post List', 'magical-posts-display'); ?></h4>
                    <p class="mgpd-preset-text"><?php esc_html_e('Side-by-side thumbnail and title layout. Ideal for blog sidebars, footer sections, and popular post listings.', 'magical-posts-display'); ?></p>
                    <div class="mgpd-preset-meta">
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Widget:', 'magical-posts-display'); ?></strong> <code>Posts List</code> or <code>Awesome Posts List</code></div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Image Position:', 'magical-posts-display'); ?></strong> Left</div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Crop Title:', 'magical-posts-display'); ?></strong> 6-8 words</div>
                    </div>
                </div>
            </div>

            <!-- Preset 7 -->
            <div class="mgpd-preset-card">
                <div class="mgpd-preset-preview mgpd-gradient-7">
                    <span class="dashicons dashicons-slides mgpd-preset-icon"></span>
                    <span class="mgpd-preset-tag"><?php esc_html_e('Hero Banner', 'magical-posts-display'); ?></span>
                </div>
                <div class="mgpd-preset-body">
                    <h4 class="mgpd-preset-title"><?php esc_html_e('7. Full-Width Hero Post Slider', 'magical-posts-display'); ?></h4>
                    <p class="mgpd-preset-text"><?php esc_html_e('Dramatic full-bleed post slider for top stories, breaking features, and high-impact editorial stories.', 'magical-posts-display'); ?></p>
                    <div class="mgpd-preset-meta">
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Widget:', 'magical-posts-display'); ?></strong> <code>Posts Slider</code></div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Effect:', 'magical-posts-display'); ?></strong> Fade or Slide</div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Overlay:', 'magical-posts-display'); ?></strong> Dark Gradient</div>
                    </div>
                </div>
            </div>

            <!-- Preset 8 -->
            <div class="mgpd-preset-card">
                <div class="mgpd-preset-preview mgpd-gradient-8">
                    <span class="dashicons dashicons-menu-alt3 mgpd-preset-icon"></span>
                    <span class="mgpd-preset-tag"><?php esc_html_e('Content Heavy', 'magical-posts-display'); ?></span>
                </div>
                <div class="mgpd-preset-body">
                    <h4 class="mgpd-preset-title"><?php esc_html_e('8. Collapsible Post Accordion', 'magical-posts-display'); ?></h4>
                    <p class="mgpd-preset-text"><?php esc_html_e('Saves vertical space while allowing users to expand and read summaries on click. Great for changelogs and series.', 'magical-posts-display'); ?></p>
                    <div class="mgpd-preset-meta">
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Widget:', 'magical-posts-display'); ?></strong> <code>Posts Accordion</code></div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('First Open:', 'magical-posts-display'); ?></strong> Yes</div>
                        <div class="mgpd-meta-item"><strong><?php esc_html_e('Posts Count:', 'magical-posts-display'); ?></strong> 5-8 posts</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Builder Synergy Section -->
    <div class="mgpd-presets-section mgpd-tb-synergy-section">
        <h3 class="mgpd-section-heading">
            <span class="dashicons dashicons-layout"></span>
            <?php esc_html_e('How to Build Custom Single Post & Archive Templates', 'magical-posts-display'); ?>
        </h3>

        <div class="mgpd-synergy-box">
            <div class="mgpd-synergy-intro">
                <h4><?php esc_html_e('🎨 Connect Magical Posts Display + Magical Addons Theme Builder', 'magical-posts-display'); ?></h4>
                <p>
                    <?php esc_html_e('With Magical Posts Display, you get 11 dynamic Theme Builder widgets (Post Title, Content, Excerpt, Featured Image, Meta, Comments, Author Box, Archive Posts). When paired with our free companion plugin (Magical Addons for Elementor), you can replace your theme blog templates completely without paying for Elementor Pro!', 'magical-posts-display'); ?>
                </p>
            </div>

            <div class="mgpd-synergy-steps">
                <div class="mgpd-synergy-step">
                    <div class="mgpd-step-circle">1</div>
                    <h5><?php esc_html_e('Enable Theme Builder', 'magical-posts-display'); ?></h5>
                    <p><?php esc_html_e('Activate Magical Addons for Elementor to unlock the Theme Builder template conditions manager.', 'magical-posts-display'); ?></p>
                </div>
                <div class="mgpd-synergy-step">
                    <div class="mgpd-step-circle">2</div>
                    <h5><?php esc_html_e('Create Single / Archive Template', 'magical-posts-display'); ?></h5>
                    <p><?php esc_html_e('Go to Theme Builder -> Single Post or Archive -> Add New. Set condition to "All Posts".', 'magical-posts-display'); ?></p>
                </div>
                <div class="mgpd-synergy-step">
                    <div class="mgpd-step-circle">3</div>
                    <h5><?php esc_html_e('Drag Dynamic Widgets', 'magical-posts-display'); ?></h5>
                    <p><?php esc_html_e('Drag Post Title, Featured Image, Meta, Content & Author Box into your section and style freely!', 'magical-posts-display'); ?></p>
                </div>
            </div>

            <div class="mgpd-synergy-footer">
                <?php if ($has_theme_builder) : ?>
                    <div class="mgpd-tb-connected-banner">
                        <span class="mgpd-tb-status-pill">
                            <span class="dashicons dashicons-yes-alt"></span>
                            <?php esc_html_e('Theme Builder Active & Connected', 'magical-posts-display'); ?>
                        </span>
                        <a href="<?php echo esc_url($tb_templates_url); ?>" class="button button-primary button-hero mgpd-btn-tb-open">
                            <span class="dashicons dashicons-layout"></span>
                            <?php esc_html_e('Open Theme Builder Templates', 'magical-posts-display'); ?>
                        </a>
                    </div>
                <?php else : ?>
                    <div class="mgpd-ajax-plugin-installer-wrap">
                        <button type="button" class="button button-primary button-hero mgpd-btn-ajax-addons" data-action="<?php echo $is_mg_installed ? 'activate' : 'install'; ?>">
                            <span class="dashicons <?php echo $is_mg_installed ? 'dashicons-update' : 'dashicons-download'; ?> mgpd-btn-icon"></span>
                            <span class="mgpd-btn-text">
                                <?php echo $is_mg_installed 
                                    ? esc_html__('Activate Magical Addons (1-Click)', 'magical-posts-display') 
                                    : esc_html__('Get Magical Addons Theme Builder (Free 1-Click)', 'magical-posts-display'); ?>
                            </span>
                        </button>
                        <div class="mgpd-ajax-status-msg" style="display:none; margin-top:12px; font-weight:600;"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
(function($) {
    'use strict';
    $(document).on('click', '.mgpd-btn-ajax-addons', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var $wrap = $btn.closest('.mgpd-ajax-plugin-installer-wrap');
        var $status = $wrap.find('.mgpd-ajax-status-msg');
        var actionType = $btn.data('action');

        $btn.prop('disabled', true);
        $btn.find('.dashicons').removeClass('dashicons-download dashicons-update dashicons-yes-alt').addClass('dashicons-update mgpd-spin');
        $btn.find('.mgpd-btn-text').text(actionType === 'activate' ? '<?php echo esc_js(__('Activating Magical Addons...', 'magical-posts-display')); ?>' : '<?php echo esc_js(__('Installing & Activating Magical Addons...', 'magical-posts-display')); ?>');
        $status.hide().removeClass('error success').text('');

        $.ajax({
            url: typeof mgpdAdmin !== 'undefined' ? mgpdAdmin.ajax_url : ajaxurl,
            type: 'POST',
            data: {
                action: 'mgpd_install_activate_addons',
                nonce: typeof mgpdAdmin !== 'undefined' ? mgpdAdmin.nonce : ''
            },
            success: function(res) {
                if (res.success) {
                    $btn.find('.dashicons').removeClass('dashicons-update mgpd-spin').addClass('dashicons-yes-alt');
                    $btn.find('.mgpd-btn-text').text('<?php echo esc_js(__('Activated Successfully!', 'magical-posts-display')); ?>');
                    $status.addClass('success').css('color', '#10b981').text(res.data && res.data.message ? res.data.message : '<?php echo esc_js(__('Theme Builder is active!', 'magical-posts-display')); ?>').fadeIn();
                    setTimeout(function() {
                        window.location.reload();
                    }, 1200);
                } else {
                    $btn.prop('disabled', false);
                    $btn.find('.dashicons').removeClass('dashicons-update mgpd-spin').addClass('dashicons-download');
                    $btn.find('.mgpd-btn-text').text('<?php echo esc_js(__('Try Again', 'magical-posts-display')); ?>');
                    $status.addClass('error').css('color', '#ef4444').text(res.data && res.data.message ? res.data.message : '<?php echo esc_js(__('Error activating plugin.', 'magical-posts-display')); ?>').fadeIn();
                }
            },
            error: function() {
                $btn.prop('disabled', false);
                $btn.find('.dashicons').removeClass('dashicons-update mgpd-spin').addClass('dashicons-download');
                $btn.find('.mgpd-btn-text').text('<?php echo esc_js(__('Try Again', 'magical-posts-display')); ?>');
                $status.addClass('error').css('color', '#ef4444').text('<?php echo esc_js(__('An unexpected error occurred. Please try again.', 'magical-posts-display')); ?>').fadeIn();
            }
        });
    });
})(jQuery);
</script>
