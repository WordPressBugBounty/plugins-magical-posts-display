<?php
/*
* All posts function goes here
*
*
*/

// posts title elementor style

if (!function_exists('mp_post_title')) {
    function mp_post_title($show = 1, $tag = "h2", $crop_title = "5", $class = 'mp-post-title')
    {
        if ($show) :
?>
            <a class="mpp-title-link <?php echo esc_attr($class); ?>" href="<?php the_permalink(); ?>">
                <?php
                printf(
                    '<%1$s class="mgp-ptitle">%2$s</%1$s>',
                    mpd_validate_html_tag($tag),
                    esc_html(wp_trim_words(get_the_title(), $crop_title))
                );
                ?>
            </a>
        <?php
        endif;
    }
}

// posts tuhumbnail 

if (!function_exists('mp_post_thumbnail')) {
    function mp_post_thumbnail($show = 1, $size = "large", $class = "mp-card-img")
    {
        if (has_post_thumbnail() && $show) :
        ?>
            <div class="mp-post-img <?php echo esc_attr($class); ?>">
                <figure>
                    <?php the_post_thumbnail($size); ?>
                </figure>
            </div>
        <?php
        endif;
    }
}



// post catgery display
if (!function_exists('mp_post_cat_display')) {
    function mp_post_cat_display($show = 1, $num = 'one', $all_sep = '/ ', $class = "mp-post-cat", $icon = 1)
    {
        if (!$show) {
            return;
        }
        $all_sep = esc_html__($all_sep, 'magical-posts-display');
        $mpg_cat_list = get_the_category_list($all_sep);

        $mpdr_category = get_the_category();
        if ($mpdr_category && $num == 'one') {
            $mpd_category = $mpdr_category[wp_rand(0, count($mpdr_category) - 1)];
        ?>
            <div class="mppost-cats mpcat-one <?php echo esc_attr($class); ?>">

                <?php
                if ($icon) {
                    echo '<i class="icon-mp-folder-oe"></i> <a href="' . esc_url(get_category_link($mpd_category)) . '">' . esc_html($mpd_category->name) . '</a>';
                } else {
                    echo '<a href="' . esc_url(get_category_link($mpd_category)) . '">' . esc_html($mpd_category->name) . '</a>';
                }


                ?>
            </div>
        <?php
        } elseif ($mpg_cat_list && $num != 'one') {
        ?>
            <div class="mppost-cats mpcat-all <?php echo esc_attr($class); ?>">
                <?php
                // translators: %s: list of categories
                $categories_text = sprintf(esc_html__('%s', 'magical-posts-display'), $mpg_cat_list);
                printf('<span class="mgp-post-cats">%s</span>', wp_kses_post($categories_text));
                ?>
            </div>
<?php
        } else {
            echo '<div class="mppost-cats no-cat ' . esc_attr($class) . '"></div>';
        }
    }
}

if (!function_exists('mp_post_count_post_visits')) :
    // popular post show 
    function mp_post_count_post_visits()
    {
        $today_date = gmdate('Y-m-d');
        if (is_single()) {
            $views = get_post_meta(get_the_ID(), 'mp_post_post_viewed', true);
            if ($views == '') {
                update_post_meta(get_the_ID(), 'mp_post_post_viewed', '1');
            } else {
                $views_no = intval($views);
                update_post_meta(get_the_ID(), 'mp_post_post_viewed', ++$views_no);
            }
        }
    }
endif;
add_action('wp_head', 'mp_post_count_post_visits');
add_action('wp_head', 'mp_post_is_week_viewed');

if (!function_exists('mp_post_is_week_viewed')) :
    function mp_post_is_week_viewed()
    {

        $today_date = gmdate("Y-m-d");
        $now = time();

        if (is_single()) {
            $views = get_post_meta(get_the_ID(), 'mp_post_week_viewed', true);
            $time_views = get_post_meta(get_the_ID(), 'mp_post_view_time', true);

            $viewdate = strtotime($time_views);
            $datediff = $now - $viewdate;
            $days = floor($datediff / (60 * 60 * 24));

            if ($days == 7) {
                delete_post_meta_by_key('mp_post_view_time');
                if ($views > '5') {
                    update_post_meta(get_the_ID(), 'mp_post_week_viewed', '5');
                }
            }
            if (empty($time_views)) {
                update_post_meta(get_the_ID(), 'mp_post_view_time', $today_date);
            }


            if ($views == '') {
                update_post_meta(get_the_ID(), 'mp_post_week_viewed', '1');
            } elseif ($views > '50') {
                update_post_meta(get_the_ID(), 'mp_post_week_viewed', '10');
            } else {
                $views_no = intval($views);
                update_post_meta(get_the_ID(), 'mp_post_week_viewed', ++$views_no);
            }
        }
    }
endif;


function mpd_check_plugin_active($plugin_path)
{
    $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
    return in_array($plugin_path, $active_plugins);
}


function mpd_validate_html_tag($tag, $default_tag = 'h2', $allowed_tags = array())
{
    // Use the provided whitelist or fall back to a predefined set of safe tags
    $safe_tags = !empty($allowed_tags) ? $allowed_tags : array(
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'div',
        'span',
        'p'
    );

    // Make sure we're working with a string
    $tag = is_string($tag) ? strtolower(trim($tag)) : '';

    // Return the validated tag or default
    return in_array($tag, $safe_tags, true) ? $tag : $default_tag;
}

/**
 * Default elements enabled state
 */
function mpd_get_default_elements()
{
    return array(
        // Post Showcase Widgets
        'posts_grid'             => 1,
        'posts_list'             => 1,
        'awesome_posts_list'     => 1,
        'posts_carousel'         => 1,
        'posts_slider'           => 1,
        'posts_accordion'        => 1,
        'posts_tab'              => 1,
        'posts_ticker'           => 1,
        'posts_cat'              => 1,
        'adv_posts_grid1'        => 1,
        'adv_posts_grid2'        => 1,
        'adv_posts_img_grid'     => 1,
        'news_magazine_grid'     => 1,
        'news_magazine_img_grid' => 1,
        // Theme Builder Widgets
        'theme_post_title'       => 1,
        'theme_post_excerpt'     => 1,
        'theme_post_content'     => 1,
        'theme_featured_image'   => 1,
        'theme_post_meta'        => 1,
        'theme_post_navigation'  => 1,
        'theme_post_comments'    => 1,
        'theme_author_box'       => 1,
        'theme_archive_title'    => 1,
        'theme_archive_posts'    => 1,
        'theme_post_pagination'  => 1,
    );
}

/**
 * Elements metadata for Widget Manager dashboard
 */
function mpd_get_elements_metadata()
{
    return array(
        'showcase' => array(
            'title' => __('Post Showcase Widgets', 'magical-posts-display'),
            'widgets' => array(
                'posts_grid' => array(
                    'name'        => __('Posts Grid', 'magical-posts-display'),
                    'class'       => '\mgpdEPostsGrid',
                    'description' => __('Multi-column post grid with static & masonry layout support.', 'magical-posts-display'),
                    'icon'        => 'dashicons-grid-view',
                ),
                'posts_list' => array(
                    'name'        => __('Posts List', 'magical-posts-display'),
                    'class'       => '\mgpdEPostsList',
                    'description' => __('Clean list style with side-by-side featured images.', 'magical-posts-display'),
                    'icon'        => 'dashicons-list-view',
                ),
                'awesome_posts_list' => array(
                    'name'        => __('Awesome Posts List', 'magical-posts-display'),
                    'class'       => '\mgpdEAwesomePostsList',
                    'description' => __('Modern magazine cards and styled compact list layouts.', 'magical-posts-display'),
                    'icon'        => 'dashicons-excerpt-view',
                ),
                'posts_carousel' => array(
                    'name'        => __('Posts Carousel', 'magical-posts-display'),
                    'class'       => '\mgPosts_carousel',
                    'description' => __('Touch-friendly Swiper carousel with dots, arrows and autoplay.', 'magical-posts-display'),
                    'icon'        => 'dashicons-images-alt2',
                ),
                'posts_slider' => array(
                    'name'        => __('Posts Slider', 'magical-posts-display'),
                    'class'       => '\mgpdEPostsSlider',
                    'description' => __('Full-width and hero banner sliders for highlighted posts.', 'magical-posts-display'),
                    'icon'        => 'dashicons-slides',
                ),
                'posts_accordion' => array(
                    'name'        => __('Posts Accordion', 'magical-posts-display'),
                    'class'       => '\mgpdEPostsAccordion',
                    'description' => __('Collapsible accordion cards for FAQs and content-heavy posts.', 'magical-posts-display'),
                    'icon'        => 'dashicons-menu-alt3',
                ),
                'posts_tab' => array(
                    'name'        => __('Posts Tabs', 'magical-posts-display'),
                    'class'       => '\mgpdEPostsTab',
                    'description' => __('Category-partitioned tabs displaying posts dynamically.', 'magical-posts-display'),
                    'icon'        => 'dashicons-category',
                ),
                'posts_ticker' => array(
                    'name'        => __('Posts Ticker', 'magical-posts-display'),
                    'class'       => '\mgpdEPostsTicker',
                    'description' => __('Animated breaking news headline ticker.', 'magical-posts-display'),
                    'icon'        => 'dashicons-megaphone',
                ),
                'posts_cat' => array(
                    'name'        => __('Posts Categories', 'magical-posts-display'),
                    'class'       => '\mgpdEPosts_cats',
                    'description' => __('Visual category badges and grid items.', 'magical-posts-display'),
                    'icon'        => 'dashicons-tag',
                ),
                'adv_posts_grid1' => array(
                    'name'        => __('Advanced Posts Grid 1', 'magical-posts-display'),
                    'class'       => '\mgpdAdPostsGrid1',
                    'description' => __('Special magazine card layout with meta highlight.', 'magical-posts-display'),
                    'icon'        => 'dashicons-screenoptions',
                ),
                'adv_posts_grid2' => array(
                    'name'        => __('Advanced Posts Grid 2', 'magical-posts-display'),
                    'class'       => '\mgpdAdPostsGrid2',
                    'description' => __('Secondary advanced layout with boxed typography.', 'magical-posts-display'),
                    'icon'        => 'dashicons-layout',
                ),
                'adv_posts_img_grid' => array(
                    'name'        => __('Advanced Posts Img Grid', 'magical-posts-display'),
                    'class'       => '\mgpdAdPostsImgGrid',
                    'description' => __('Visual-heavy layout highlighting featured images.', 'magical-posts-display'),
                    'icon'        => 'dashicons-format-image',
                ),
                'news_magazine_grid' => array(
                    'name'        => __('News Magazine Grid', 'magical-posts-display'),
                    'class'       => '\mgpdNewsMagazineGrid',
                    'description' => __('Editorially styled news layout with multiple featured columns.', 'magical-posts-display'),
                    'icon'        => 'dashicons-welcome-widgets-menus',
                ),
                'news_magazine_img_grid' => array(
                    'name'        => __('News/Magazine Image Grid', 'magical-posts-display'),
                    'class'       => '\mgpdNewsMagazineImgGrid',
                    'description' => __('Modern magazine overlay grid with 5 distinct preset styles.', 'magical-posts-display'),
                    'icon'        => 'dashicons-format-gallery',
                ),
            ),
        ),
        'theme_builder' => array(
            'title' => __('Theme Builder Widgets (Single & Archive)', 'magical-posts-display'),
            'widgets' => array(
                'theme_post_title' => array(
                    'name'        => __('Post Title', 'magical-posts-display'),
                    'class'       => 'Mgpd_Theme_Post_Title',
                    'description' => __('Dynamic post or archive title heading.', 'magical-posts-display'),
                    'icon'        => 'dashicons-heading',
                ),
                'theme_post_excerpt' => array(
                    'name'        => __('Post Excerpt', 'magical-posts-display'),
                    'class'       => 'Mgpd_Theme_Post_Excerpt',
                    'description' => __('Dynamic post excerpt or summary text.', 'magical-posts-display'),
                    'icon'        => 'dashicons-editor-paragraph',
                ),
                'theme_post_content' => array(
                    'name'        => __('Post Content', 'magical-posts-display'),
                    'class'       => 'Mgpd_Theme_Post_Content',
                    'description' => __('Full dynamic post or page body content.', 'magical-posts-display'),
                    'icon'        => 'dashicons-text-page',
                ),
                'theme_featured_image' => array(
                    'name'        => __('Featured Image', 'magical-posts-display'),
                    'class'       => 'Mgpd_Theme_Featured_Image',
                    'description' => __('Dynamic current post featured image with lightbox & link options.', 'magical-posts-display'),
                    'icon'        => 'dashicons-format-image',
                ),
                'theme_post_meta' => array(
                    'name'        => __('Post Meta', 'magical-posts-display'),
                    'class'       => 'Mgpd_Theme_Post_Meta',
                    'description' => __('Author, date, comments, categories, and reading time badges.', 'magical-posts-display'),
                    'icon'        => 'dashicons-info',
                ),
                'theme_post_navigation' => array(
                    'name'        => __('Post Navigation', 'magical-posts-display'),
                    'class'       => 'Mgpd_Theme_Post_Navigation',
                    'description' => __('Previous & Next post pagination links.', 'magical-posts-display'),
                    'icon'        => 'dashicons-leftright',
                ),
                'theme_post_comments' => array(
                    'name'        => __('Post Comments', 'magical-posts-display'),
                    'class'       => 'Mgpd_Theme_Post_Comments',
                    'description' => __('Standard WordPress comments thread & reply form.', 'magical-posts-display'),
                    'icon'        => 'dashicons-admin-comments',
                ),
                'theme_author_box' => array(
                    'name'        => __('Author Box', 'magical-posts-display'),
                    'class'       => 'Mgpd_Theme_Author_Box',
                    'description' => __('Author avatar, bio, and archive link box.', 'magical-posts-display'),
                    'icon'        => 'dashicons-admin-users',
                ),
                'theme_archive_title' => array(
                    'name'        => __('Archive Title', 'magical-posts-display'),
                    'class'       => 'Mgpd_Theme_Archive_Title',
                    'description' => __('Dynamic category, tag, author, or search results title.', 'magical-posts-display'),
                    'icon'        => 'dashicons-editor-quote',
                ),
                'theme_archive_posts' => array(
                    'name'        => __('Archive Posts Loop', 'magical-posts-display'),
                    'class'       => 'Mgpd_Theme_Archive_Posts',
                    'description' => __('Main archive loop widget with multiple layouts & AJAX load more.', 'magical-posts-display'),
                    'icon'        => 'dashicons-networking',
                ),
                'theme_post_pagination' => array(
                    'name'        => __('Post Pagination', 'magical-posts-display'),
                    'class'       => 'Mgpd_Theme_Post_Pagination',
                    'description' => __('Numeric, AJAX load more, and Prev/Next archive pagination.', 'magical-posts-display'),
                    'icon'        => 'dashicons-arrow-right-alt2',
                ),
            ),
        ),
    );
}

/**
 * Get active elements mapping
 */
function mpd_get_active_elements()
{
    $defaults = mpd_get_default_elements();
    $saved    = get_option('mgpd_active_elements');

    if (!is_array($saved)) {
        return $defaults;
    }

    return wp_parse_args($saved, $defaults);
}

/**
 * Check if a widget is enabled
 */
function mpd_is_widget_enabled($widget_key)
{
    $active = mpd_get_active_elements();
    return !empty($active[$widget_key]);
}

/**
 * Pro only text helper (prevents fatal error if trait calls it)
 */
if (!function_exists('mp_display_pro_only_text')) {
    function mp_display_pro_only_text()
    {
        if (!function_exists('mp_display_check_main_ok') || !mp_display_check_main_ok()) {
            return ' <span class="mgpd-pro-badge" style="color: #ff5722; font-size: 11px; font-weight: bold;">(' . esc_html__('Pro', 'magical-posts-display') . ')</span>';
        }
        return '';
    }
}
