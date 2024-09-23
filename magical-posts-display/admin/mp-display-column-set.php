<?php
/*
 * haslider slider update messages.
 *
 * @link              http://digitalkroy.com/mp-display
 * @since             1.0.0
 * @package           mp-display
 *
 * @wordpress-plugin
 */

// haslider slider all item column set
if (!function_exists('mp_display_image_count_admin_column')) :
    function mp_display_image_count_admin_column($post_ID)
    {
        // $mp_display_count = get_post_meta($post_ID, 'slider_img', true);
        $posts_card = get_post_meta($post_ID, 'posts_card', true);

        $mp_posts_number =  !empty($posts_card[0]['posts_number'])  ? $posts_card[0]['posts_number'] : '10';


        if ($mp_posts_number == '-1') {
            $total_post = __('All Posts', 'magical-posts-display');
        } else {
            $total_post = $mp_posts_number;
        }
        return $total_post;
    }
endif;

if (!function_exists('mp_display_shortcode_column_head')) :
    add_filter('manage_mp-display_posts_columns', 'mp_display_shortcode_column_head', 10);
    function mp_display_shortcode_column_head($defaults)
    {
        $defaults['shortcode_generate'] = __('Shortcode', 'magical-posts-display');
        $defaults['post_number'] = __('Total posts', 'magical-posts-display');
        $defaults['post_type'] = __('Posts source', 'magical-posts-display');
        return $defaults;
    }
endif;
if (!function_exists('mp_display_column_content')) :
    add_action('manage_mp-display_posts_custom_column', 'mp_display_column_content', 10, 2);
    function mp_display_column_content($column_name, $post_ID)
    {
        $posts_card = get_post_meta($post_ID, 'posts_card', true);

        $mp_posts_number =  !empty($posts_card[0]['posts_number'])  ? $posts_card[0]['posts_number'] : '10';
        $mp_set_posts_num =  !empty($posts_card[0]['set_posts_num'])  ? $posts_card[0]['set_posts_num'] : 'all';

        $mp_posts_show_by =  !empty($posts_card[0]['posts_show_by'])  ? $posts_card[0]['posts_show_by'] : 'latest';
        $mp_posts_cat =  !empty($posts_card[0]['posts_cat'])  ? $posts_card[0]['posts_cat'] : 'latest';
        $mp_posts_tag =  !empty($posts_card[0]['posts_tag'])  ? $posts_card[0]['posts_tag'] : 'latest';
        if ($mp_set_posts_num == 'all') {
            $mp_posts_number = -1;
        }

        if ($column_name == 'shortcode_generate') {
            $shortcode_render = '[magical-post id="' . $post_ID . '"]';
            printf(
                '<input style="min-width:210px" type="text" onClick="this.setSelectionRange(0, this.value.length)" value="%s" />',
                esc_attr($shortcode_render)
            );
        }
        if ($column_name == 'post_number') {

            if ($mp_posts_number == 1) {
                printf(
                    // translators: %d: number of posts added
                    esc_html__('%d post added', 'magical-posts-display'),
                    intval($mp_posts_number)
                );
            } elseif ($mp_posts_number == '-1') {
                esc_html_e('All posts added', 'magical-posts-display');
            } else {
                printf(
                    // translators: %d: number of posts added
                    esc_html(_n('%d post added', '%d posts added', absint($mp_posts_number), 'magical-posts-display')),
                    absint($mp_posts_number)
                );
            }
        }
        if ($column_name == 'post_type') {

            if ($mp_posts_show_by == 'DESC') {
                esc_html_e('Latest posts', 'magical-posts-display');
            } elseif ($mp_posts_show_by == 'ASC') {
                esc_html_e('Oldest posts', 'magical-posts-display');
            } elseif ($mp_posts_show_by == 'category') {
                printf(
                    // translators: %s: category name
                    esc_html__('Category: %s', 'magical-posts-display'),
                    esc_html($mp_posts_cat)
                );
            } elseif ($mp_posts_show_by == 'tag') {
                printf(
                    // translators: %s: tag name
                    esc_html__('Tag: %s', 'magical-posts-display'),
                    esc_html($mp_posts_tag)
                );
            } else {
                esc_html_e('No post type selected', 'magical-posts-display');
            }
        }
    }
endif;
