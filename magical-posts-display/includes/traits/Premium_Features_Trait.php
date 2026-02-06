<?php

/**
 * Premium Features Trait
 * 
 * Reusable trait for adding premium features to widgets
 * Includes: AJAX filter, Infinite scroll, Reading time, View count, Social sharing, Hover effects
 * 
 * @package Magical Posts Display
 * @since 1.2.54
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

trait Premium_Features_Trait
{
    use SVG_Icons_Trait;

    /**
     * Add premium features control sections to Elementor widget
     * Call this method in _register_controls()
     */
    protected function register_premium_features_controls()
    {

        // Premium Features Section
        $this->start_controls_section(
            'mgpg_premium_features',
            [
                'label' => __('✨ Premium Features', 'magical-posts-display') . mp_display_pro_only_text(),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // AJAX Category Filter
        $this->add_control(
            'mgpg_ajax_filter',
            [
                'label' => __('AJAX Category Filter', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => '',
                'description' => __('Enable dynamic category filtering without page reload', 'magical-posts-display'),
            ]
        );

        // Infinite Scroll
        $this->add_control(
            'mgpg_infinite_scroll',
            [
                'label' => __('Infinite Scroll', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => '',
                'description' => __('Auto-load more posts when scrolling', 'magical-posts-display'),
            ]
        );

        // Reading Time
        $this->add_control(
            'mgpg_reading_time',
            [
                'label' => __('Show Reading Time', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => '',
                'description' => __('Display estimated reading time', 'magical-posts-display'),
            ]
        );

        // View Count
        $this->add_control(
            'mgpg_view_count',
            [
                'label' => __('Show View Count', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => '',
                'description' => __('Display post view count', 'magical-posts-display'),
            ]
        );

        // Social Share
        $this->add_control(
            'mgpg_social_share',
            [
                'label' => __('Social Share Buttons', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-posts-display'),
                'label_off' => __('No', 'magical-posts-display'),
                'return_value' => 'yes',
                'default' => '',
                'description' => __('Show social sharing buttons (Facebook, X, LinkedIn, Pinterest, Instagram)', 'magical-posts-display'),
            ]
        );

        // Hover Effects
        $this->add_control(
            'mgpg_hover_effects',
            [
                'label' => __('Hover Effects', 'magical-posts-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'none' => __('None', 'magical-posts-display'),
                    'zoom' => __('Zoom', 'magical-posts-display'),
                    'slide-up' => __('Slide Up', 'magical-posts-display'),
                    'fade' => __('Fade', 'magical-posts-display'),
                ],
                'default' => 'none',
                'description' => __('Select hover animation effect', 'magical-posts-display'),
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render reading time HTML
     */
    protected function render_reading_time()
    {
        $content = get_the_content();
        $word_count = str_word_count(wp_strip_all_tags($content));
        $reading_time = ceil($word_count / 200); // 200 words per minute
?>
        <div class="mgpd-reading-time">
            <?php echo $this->get_reading_time_icon(16); ?>
            <?php echo esc_html($reading_time); ?> min read
        </div>
    <?php
    }

    /**
     * Render view count HTML
     */
    protected function render_view_count()
    {
        $post_views = get_post_meta(get_the_ID(), 'mp_post_post_viewed', true);
        $post_views = $post_views ? absint($post_views) : 0;
    ?>
        <div class="mgpd-view-count">
            <?php echo $this->get_view_count_icon(16); ?>
            <?php echo esc_html(number_format($post_views)); ?> views
        </div>
    <?php
    }

    /**
     * Render social share buttons HTML with SVG icons
     */
    protected function render_social_share()
    {
        $post_url = get_permalink();
        $post_title = get_the_title();
        echo '<div class="mgpd-social-share">';
        echo $this->get_all_social_share_buttons($post_url, $post_title, null, 20);
        echo '</div>';
    }

    /**
     * Render all premium features based on settings
     * 
     * @param array $settings Widget settings
     */
    protected function render_premium_features($settings)
    {
        if (!mp_display_check_main_ok()) {
            return; // Pro version not active
        }

        $has_features = false;

        // Check if any feature is enabled
        if (
            (!empty($settings['mgpg_reading_time']) && $settings['mgpg_reading_time'] === 'yes') ||
            (!empty($settings['mgpg_view_count']) && $settings['mgpg_view_count'] === 'yes') ||
            (!empty($settings['mgpg_social_share']) && $settings['mgpg_social_share'] === 'yes')
        ) {
            $has_features = true;
        }

        if (!$has_features) {
            return;
        }

    ?>
        <div class="mgpd-premium-features">
            <?php


            if (
                (!empty($settings['mgpg_reading_time']) && $settings['mgpg_reading_time'] === 'yes') ||
                (!empty($settings['mgpg_view_count']) && $settings['mgpg_view_count'] === 'yes')
            ) {
                echo '<div class="mgpd-time-count-wrap">';

                if (!empty($settings['mgpg_reading_time']) && $settings['mgpg_reading_time'] === 'yes') {
                    $this->render_reading_time();
                }

                if (!empty($settings['mgpg_view_count']) && $settings['mgpg_view_count'] === 'yes') {
                    $this->render_view_count();
                }

                echo '</div>';
            }


            if (!empty($settings['mgpg_social_share']) && $settings['mgpg_social_share'] === 'yes') {
                $this->render_social_share();
            }
            ?>
        </div>
    <?php
    }

    /**
     * Render infinite scroll trigger and loading spinner
     * 
     * @param bool $enabled Whether infinite scroll is enabled
     */
    protected function render_infinite_scroll_trigger($enabled = false)
    {
        if (!$enabled || !mp_display_check_main_ok()) {
            return;
        }
    ?>
        <div class="mgpd-infinite-scroll-trigger" style="height: 1px; margin-top: 50px;"></div>
        <div class="mgpd-loading-spinner" style="display: none; text-align: center; padding: 20px;">
            <svg class="mgpd-spinner" width="40" height="40" viewBox="0 0 50 50">
                <circle cx="25" cy="25" r="20" fill="none" stroke="currentColor" stroke-width="4" stroke-dasharray="31.4 31.4" stroke-linecap="round"></circle>
            </svg>
            <span><?php echo esc_html__('Loading more posts...', 'magical-posts-display'); ?></span>
        </div>
    <?php
    }

    /**
     * Render AJAX category filter
     * 
     * @param bool $enabled Whether AJAX filter is enabled
     * @param string $post_type Post type for filtering
     */
    protected function render_ajax_category_filter($enabled = false, $post_type = 'post')
    {
        if (!$enabled || !mp_display_check_main_ok() || $post_type !== 'post') {
            return;
        }

        $categories = get_categories(array('hide_empty' => true));
        if (empty($categories)) {
            return;
        }
    ?>
        <div class="mgpd-ajax-filter-container">
            <div class="mgpd-filter-buttons">
                <button class="mgpd-filter-btn active" data-category="all">
                    <?php echo esc_html__('All', 'magical-posts-display'); ?>
                </button>
                <?php foreach ($categories as $category) : ?>
                    <button class="mgpd-filter-btn" data-category="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
<?php
    }
}
