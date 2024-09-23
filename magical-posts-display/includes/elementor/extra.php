<?php
/*
*
*  Magical Posts Display plugin elementor helper function
*
*
*/




if (!class_exists('mpd_posts_meta_author_date')) {
    function mpd_posts_meta_author_date($author = '', $date = '', $class = 'mt-3 text-right')
    {
?>
        <div class="mp-meta mgp-ms2 <?php echo esc_attr($class); ?>">
            <div class="row">
                <?php if ($author) : ?>
                    <div class="col-auto">
                        <?php mp_display_posted_by(); ?>
                    </div>
                <?php endif; ?>
                <?php if ($date) : ?>
                    <div class="col-auto ml-auto text-right">
                        <span class="mgp-time">
                            <i class="icon-mp-clock"></i>
                            <?php echo esc_html(get_the_date('d M Y')); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php
    }
}

// Check main 
function mp_display_check_main_ok()
{
    $has_magical_posts_pro = get_option("has_magical_posts_pro");
    $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));

    if (in_array('magical-posts-display-pro/magical-posts-display-pro.php', $active_plugins) && !empty($has_magical_posts_pro)) {
        return true;
    }
    return false;
}

if (!class_exists('mpd_posts_meta')) {
    function mpd_posts_meta($author = '', $date = '', $comment = '', $class = 'mb-2')
    {
    ?>
        <div class="mp-meta bottom-meta <?php echo esc_attr($class); ?>">
            <?php
            if ($author) {
                mp_display_posted_by();
            }
            if ($date) {
                echo '<span class="mp-posts-date">';
                echo '<i class="icon-mp-clock"></i> ';
                echo get_the_date();
                echo '</span>';
            }
            if ($comment) {
                mp_display_single_comment_icon();
            }
            ?>
        </div>
    <?php
    }
}


if (!class_exists('mpd_post_tags')) {
    function mpd_post_tags($show = '')
    {
        $mgp_tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'magical-posts-display'));
        if ($mgp_tags_list && $show == 'yes') {
            printf('<span class="mpg-tags-links"><i class="icon-mp-tag"></i> %s</span>', $mgp_tags_list);
        }
    }
}


if (!class_exists('mpd_get_allowed_html_tags')) {
    function mpd_get_allowed_html_tags()
    {
        $allowed_html = [
            'b' => [],
            'i' => [],
            'u' => [],
            'em' => [],
            'br' => [],
            'abbr' => [
                'title' => [],
            ],
            'span' => [
                'class' => [],
            ],
            'strong' => [],
        ];

        $allowed_html['a'] = [
            'href' => [],
            'title' => [],
            'class' => [],
            'id' => [],
        ];

        return $allowed_html;
    }
}

if (!function_exists('mpd_kses_tags')) {
    function mpd_kses_tags($string = '')
    {
        return wp_kses($string, mpd_get_allowed_html_tags());
    }
}




/* 
* Category list
* return first one
*/
if (!function_exists('mp_display_product_catlist')) {
    function mp_display_product_catlist($id = null, $taxonomy = 'category', $limit = 1)
    {
        $terms = get_the_terms($id, $taxonomy);
        $i = 0;
        if (is_wp_error($terms))
            return $terms;

        if (empty($terms))
            return false;

        foreach ($terms as $term) {
            $i++;
            $link = get_term_link($term, $taxonomy);
            if (is_wp_error($link)) {
                return $link;
            }
            echo '<a href="' . esc_url($link) . '">' . $term->name . '</a>';
            if ($i == $limit) {
                break;
            } else {
                continue;
            }
        }
    }
}

/**
 * Get Post List
 * return array
 */
if (!function_exists('mp_display_posts_name')) {
    function mp_display_posts_name($post_type = 'post')
    {
        $options = array();
        $options['0'] = __('Select', 'bstoolkit-for-elementor');
        // $perpage = mp_display_get_option( 'loadproductlimit', 'mp_display_others_tabs', '20' );
        $all_post = array('posts_per_page' => -1, 'post_type' => $post_type);
        $post_terms = get_posts($all_post);
        if (!empty($post_terms) && !is_wp_error($post_terms)) {
            foreach ($post_terms as $term) {
                $options[$term->ID] = $term->post_title;
            }
            return $options;
        }
    }
}
/**
 *  Taxonomy List
 * @return array
 */
if (!function_exists('mp_display_taxonomy_list')) {
    function mp_display_taxonomy_list($taxonomy = 'category')
    {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ));
        $options = array();
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                //  $options[ $term->slug ] = $term->name;
                $options[$term->term_id] = $term->name;
            }
            return $options;
        }
    }
}
/**
 *  Taxonomy List by slug
 * @return array
 */
if (!function_exists('mp_display_catslug_list')) {
    function mp_display_catslug_list($taxonomy = 'category')
    {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ));
        $options = array();
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->slug] = $term->name;
            }
            return $options;
        }
    }
}


// posts button 
if (!function_exists('mp_post_btn')) {
    function mp_post_btn($text = 'Read More', $icon_show = '', $icon = '', $icon_position = 'right', $target = '_self', $class = 'mp-btn-link')
    {


    ?>

        <?php if ($icon_show) : ?>
            <a href="<?php the_permalink(); ?>" target="<?php echo esc_attr($target); ?>" class="mp-post-btn <?php echo esc_attr($class); ?>">
                <?php if ($icon_position == 'left') : ?>

                    <span class="left"><?php \Elementor\Icons_Manager::render_icon($icon); ?></span>

                <?php endif; ?>
                <span><?php echo mpd_kses_tags($text); ?></span>
                <?php if ($icon_position == 'right') : ?>
                    <span class="right"><?php \Elementor\Icons_Manager::render_icon($icon); ?></span>
                <?php endif; ?>
            </a>
        <?php else : ?>
            <a href="<?php the_permalink(); ?>" target="<?php echo esc_attr($target); ?>" class="mp-post-btn <?php echo esc_attr($class); ?>"><?php echo  mpd_kses_tags($text); ?></a>
        <?php endif; ?>


    <?php
    }
}

if (!function_exists('mp_go_pro_template')) :
    function mp_go_pro_template($texts)
    {
        ob_start();

    ?>
        <div class="elementor-nerd-box">
            <img class="elementor-nerd-box-icon" src="<?php echo esc_url(ELEMENTOR_ASSETS_URL . 'images/go-pro.svg'); ?>" />
            <div class="elementor-nerd-box-title"><?php echo esc_html($texts['title']); ?></div>
            <div class="elementor-nerd-box-message"><?php echo esc_html($texts['massage']); ?></div>
            <?php
            // Show a `Get Pro` button only if the user doesn't have Pro.
            if ($texts['link']) { ?>
                <a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-button-go-pro" href="<?php echo esc_url($texts['link']); ?>" target="_blank">
                    <?php echo esc_html__('Get Pro', 'elementor'); ?>
                </a>
            <?php } ?>
        </div>
    <?php
        return ob_get_clean();
    }
endif;

function mp_display_author_namet()
{
    $theme = wp_get_theme();
    $author = $theme->get('Author');
    return $author;
}

/**
 *  Taxonomy slug List
 * @return array
 */
if (!function_exists('mp_display_taxonomy_sluglist')) {
    function mp_display_taxonomy_sluglist($taxonomy = 'category')
    {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ));
        $options = array();
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                //  $options[ $term->slug ] = $term->name;
                $options[$term->slug] = $term->name;
            }
            return $options;
        }
    }
}

// Pro only text 

function mp_display__pro_only_text()
{
    $pro_only_text = esc_html__('Pro Only', 'magical-posts-display');
    $pro_only = '<strong style="color:red;font-size:80%">(' . $pro_only_text . ')</strong>';
    if (mp_display_check_main_ok() || mp_display_author_namet() == 'wptheme space pro') {
        return false;
    } else {
        return $pro_only;
    }
}

/**
 *  Taxonomy List
 * @return array
 */
if (!function_exists('mp_display_imgover_style_list')) {
    function mp_display_imgover_style_list()
    {

        $options = array();
        if (mp_display_check_main_ok() || mp_display_author_namet() == 'wptheme space pro') {
            $options[1] = __('Style One', 'magical-posts-display');
            $options[2] = __('Style Two', 'magical-posts-display');
            $options[3] = __('Style Three', 'magical-posts-display');
        } else {
            $options[1] = __('Style One', 'magical-posts-display');
            $options[11] = __('Style Two (Pro only)', 'magical-posts-display');
            $options[111] = __('Style Three(Pro only)', 'magical-posts-display');
        }

        return $options;
    }
}



// Check main 
function mp_display_post_filter()
{
    if (mp_display_check_main_ok() || mp_display_author_namet() == 'wptheme space pro') {
        $pro_value1 = 'popular';
        $pro_value2 = 'trending';
        $pro_label1 = esc_html__('Popular Posts', 'magical-posts-display');
        $pro_label2 = esc_html__('Trending posts', 'magical-posts-display');
    } else {
        $pro_value1 = 'recent1';
        $pro_value2 = 'recent2';
        $pro_label1 = esc_html__('Popular Posts(Pro Only)', 'magical-posts-display');
        $pro_label2 = esc_html__('Trending posts(Pro Only)', 'magical-posts-display');
    }


    $options = [
        'recent' => esc_html__('Recent Posts', 'magical-posts-display'),
        $pro_value1 => $pro_label1,
        $pro_value2 => $pro_label2,
        'random_order' => esc_html__('Random Posts', 'magical-posts-display'),
        'show_byid' => esc_html__('Show By Id', 'magical-posts-display'),
        'show_byid_manually' => esc_html__('Add ID Manually', 'magical-posts-display'),
    ];

    return $options;
}


function mp_display_all_posts_type()
{
    $post_types = get_post_types(
        array(
            'public' => true,
            '_builtin' => false
        ),
        'objects',
        'and'
    );
    array_unshift($post_types, get_post_type_object('post'), get_post_type_object('page'));

    $filtered_post_types = array_filter($post_types, function ($post_type) {
        return !($post_type->name === 'attachment' || $post_type->name === 'nav_menu_item' || $post_type->name === 'e-landing-page');
    });

    $item = array();
    $count = 0;
    foreach ($filtered_post_types as $post_type) {

        if ($post_type->name === 'post' || $post_type->name === 'page') {
            $item[$post_type->name] = $post_type->label;
        } else {
            if (mp_display_check_main_ok()) {
                $item[$post_type->name] = $post_type->label;
            } else {
                $item['post' . $count++] = $post_type->label . ' ' . mp_display__pro_only_text();
            }
        }
    }
    return $item;
}



function mp_display_posts_not_found($settings)
{
    if ($settings == 'post' || $settings == 'page') :
    ?>
        <div class="alert alert-danger text-center mt-5 mb-5" role="alert">
            <?php echo esc_html('No Posts found this query. Please try another way!!', 'magical-posts-display'); ?>
        </div>
    <?php else : ?>
        <div class="alert alert-danger text-center mt-5 mb-5" role="alert">
            <?php printf(esc_html('Get The Post Type Access and More - %s', 'magical-posts-display'), '<a href="https://wpthemespace.com/product/magical-posts-display-pro/" target="_blank">' . esc_html__('Upgrade Now', 'magical-posts-display') . '</a>');  ?>
        </div>
<?php
    endif;
}
