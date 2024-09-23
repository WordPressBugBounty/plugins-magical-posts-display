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
                    tag_escape($tag),
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
                $categories_text = sprintf(esc_html__('%s', 'magical-addons-for-elementor'), $mpg_cat_list);
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
