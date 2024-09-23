<?php


/**
 * 
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;
use Carbon_Fields\Field\Complex_Field;

/**
 * 
 */
class postsTab
{

    function __construct()
    {
        add_action('carbon_fields_register_fields', [$this, 'posts_tab']);
    }
    public function mgpd_query_arg($number = 10, $cat = '', $orderby = '', $order = 'DSC')
    {
        $mpd_args = array(
            'post_type'         =>  'post',
            'post_status'       =>  'publish',
            'posts_per_page'    => $number,
            'tax_query'         => array(
                array(
                    'taxonomy'  => 'category',
                    'field'  => 'slug',
                    'terms'  => $cat
                )
            ),
            'orderby'        => $orderby,
            'order'   => $order,
            'ignore_sticky_posts' => 1
        );
        return $mpd_args;
    }

    /**
     *  Taxonomy List
     * @return array
     */
    function mgpd_cat_list()
    {
        $options[''] = __('Select category', 'magical-posts-display');
        $terms = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => true,
        ));
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->slug] = $term->name;
            }
        }
        return $options;
    }


    function posts_tab()
    {

        Block::make(__('Magical posts Tab', 'magical-posts-display'))
            ->set_category('magical-posts-display', __('Magical Block', 'magical-posts-display'), 'welcome-view-site')
            ->set_icon('archive')
            ->set_keywords([__('tab', 'magical-posts-display'), __('accordion', 'magical-posts-display'), __('post', 'magical-posts-display')])
            ->set_mode('both')

            ->add_tab(__('Magical tab'), array(
                Field::make('separator', 'mpdtab_tab_item', __('Add tab category items', 'magical-posts-display')),
                Field::make('select', 'mpdtab_posts_cat_one', __('Select Category For first tab', 'magical-posts-display'))
                    ->set_options(array($this, 'mgpd_cat_list'))
                    ->set_default_value('all'),
                Field::make('select', 'mpdtab_posts_cat_two', __('Select Category For Second tab', 'magical-posts-display'))
                    ->set_options(array($this, 'mgpd_cat_list'))
                    ->set_default_value('all'),
                Field::make('select', 'mpdtab_posts_cat_three', __('Select Category For Third tab', 'magical-posts-display'))
                    ->set_options(array($this, 'mgpd_cat_list'))
                    ->set_default_value('all'),
                Field::make('select', 'mpdtab_posts_cat_four', __('Select Category For Fourth tab', 'magical-posts-display'))
                    ->set_options(array($this, 'mgpd_cat_list'))
                    ->set_default_value('all'),
                Field::make('separator', 'mpdtab_sep_cotent', __('Tab content setup', 'magical-posts-display')),
                Field::make('select', 'mpdtab_posts_show', __('Show Posts by', 'magical-posts-display'))
                    ->set_options(array(
                        'DSC' => __('Latest Posts', 'magical-posts-display'),
                        'ASC' => __('Oldest Posts', 'magical-posts-display'),
                        'rand' => __('Random Posts', 'magical-posts-display'),
                    ))
                    ->set_default_value('DSC'),
                Field::make('text', 'mpdtab_posts_number', __('Posts number', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(6),
                Field::make('select', 'mpdtab_posts_column', __('Grid Column', 'magical-posts-display'))
                    ->set_options(array(
                        '12' => __('One Column', 'magical-posts-display'),
                        '6' => __('Two Column', 'magical-posts-display'),
                        '4' => __('Three Column', 'magical-posts-display'),
                        '3' => __('Four Column', 'magical-posts-display'),
                    ))
                    ->set_default_value('4'),
                Field::make('checkbox', 'mpdtab_show_btn', 'Show Button')
                    ->set_default_value('yes'),
                Field::make('text', 'mpdtab_btn_text', __('Button Text', 'magical-posts-display'))
                    ->set_default_value(__('Read More', 'magical-posts-display')),

                Field::make('separator', 'mpdtab_post_img', __('Tab Posts image', 'magical-posts-display')),
                Field::make('select', 'mpdtab_posts_img', __('Show Posts image', 'magical-posts-display'))
                    ->set_options(array(
                        'show-img' => __('Show image', 'magical-posts-display'),
                        'hide-img' => __('Hide image', 'magical-posts-display'),
                    ))
                    ->set_default_value('show-img'),
                Field::make('select', 'mpdtab_img_size', __('Image size', 'magical-posts-display'))
                    ->set_options(array(
                        'thumbnail' => __('Thumbnail (150*150)', 'magical-posts-display'),
                        'medium' => __('Medium (300*300)', 'magical-posts-display'),
                        'card-grid' => __('Grid Card (600*900)', 'magical-posts-display'),
                        'card-list' => __('List card (600*700)', 'magical-posts-display'),
                        'medium_large' => __('Medium large (768*0)', 'magical-posts-display'),
                        'large' => __('Large ( 1024*1024)', 'magical-posts-display'),
                        'full' => __('Orginal size', 'magical-posts-display'),
                    ))
                    ->set_default_value('medium'),
                Field::make('separator', 'mpdtab_post_meta', __('Post Meta', 'magical-posts-display')),
                Field::make('checkbox', 'mpdtab_cat', __('Show Category', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdtab_author', __('Show Author', 'magical-posts-display')),
                Field::make('checkbox', 'mpdtab_date', __('Show Date', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdtab_tag', __('Show Tags', 'magical-posts-display')),
                Field::make('checkbox', 'mpdtab_comment', __('Show Comment', 'magical-posts-display')),
            ))
            ->add_tab(__('Tab Style'), array(
                Field::make('separator', 'mpdtab_sep_navtab', __('Tab Nav Style', 'magical-posts-display')),
                Field::make('color', 'mpdtab_navtab_bgcolor', __('Tab Nav Background Color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdtab_navtab_color', __('Nav Text Color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdtab_navtab_hvcolor', __('Nav Text hover Color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdtab_navitem_bgcolor', __('Nav Item Background Color', 'magical-posts-display')),
                Field::make('color', 'mpdtab_navitem_hvbgcolor', __('Nav Item  Background Hover Color', 'magical-posts-display')),

                Field::make('select', 'mpdtab_navtab_align', __('Nav Position'))
                    ->set_options(array(
                        'left' => __('Left', 'magical-posts-display'),
                        'center' => __('Center', 'magical-posts-display'),
                        'right' => __('Right', 'magical-posts-display'),

                    ))
                    ->set_default_value('left'),
                Field::make('separator', 'mpdtab_sep_content', __('Content Style', 'magical-posts-display')),

                Field::make('text', 'mpdtab_cont_padding', __('Content Padding', 'magical-posts-display'))->set_help_text(__('Enter content padding. padding set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdtab_cont_bgcolor', __('Content background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdtab_card_bgcolor', __('Card background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdtab_sep_img', __('Image Style', 'magical-posts-display')),
                Field::make('checkbox', 'mpdtab_img_width', __('Set 100% image width', 'magical-posts-display'))
                    ->set_option_value('yes'),
                Field::make('text', 'mpdtab_img_height', __('Image height', 'magical-posts-display'))->set_help_text(__('Set image height. Leave empty for auto height.'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdtab_img_margin', __('Image bottom space', 'magical-posts-display'))->set_help_text(__('Tyepe image bottom margin. Icon margin set by px'))
                    ->set_attribute('type', 'number'),

                Field::make('separator', 'mpdtab_sep_title', __('Title Style', 'magical-posts-display')),
                Field::make('text', 'mpdtab_title_size', __('Title font size', 'magical-posts-display'))->set_help_text(__('Tyepe number for icon size. Icon size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdtab_title_margin', __('Title bottom space', 'magical-posts-display'))->set_help_text(__('Tyepe number icon margin. Icon margin set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdtab_title_color', __('Title color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdtab_sep_desc', __('Description Style', 'magical-posts-display')),

                Field::make('text', 'mpdtab_desc_size', __('Description size', 'magical-posts-display'))->set_help_text(__('Tyepe number for icon size. Icon size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdtab_desc_margin', __('Description bottom space', 'magical-posts-display'))->set_help_text(__('Description bottom margin. Margin set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdtab_desc_color', __('Description color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdtab_sep_meta', __('Meta Style', 'magical-posts-display')),

                Field::make('text', 'mpdtab_meta_size', __('Meta size', 'magical-posts-display'))->set_help_text(__('Set Meta size. Meta size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdtab_meta_color', __('Meta color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),


                Field::make('separator', 'mpdtab_sep_btn', __('Button style', 'magical-posts-display')),
                Field::make('select', 'mpdtab_btn', __('Select button', 'magical-posts-display'))
                    ->set_options(array(
                        'primary' => __('Primary', 'magical-posts-display'),
                        'secondary' => __('Secondary', 'magical-posts-display'),
                        'success' => __('Success', 'magical-posts-display'),
                        'info' => __('Info', 'magical-posts-display'),
                        'light' => __('Light', 'magical-posts-display'),
                        'dark' => __('Dark', 'magical-posts-display'),
                        'warning' => __('Warning', 'magical-posts-display'),
                        'danger' => __('Danger', 'magical-posts-display'),
                        'link' => __('Link', 'magical-posts-display'),
                    ))
                    ->set_default_value('info'),


            ))



            ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                $rand_num = wp_rand(558732, 665284);

                $mpdtab_posts_cat_one = mpd_get_option($fields['mpdtab_posts_cat_one']);
                $mpdtab_posts_cat_two = mpd_get_option($fields['mpdtab_posts_cat_two']);
                $mpdtab_posts_cat_three = mpd_get_option($fields['mpdtab_posts_cat_three']);
                $mpdtab_posts_cat_four = mpd_get_option($fields['mpdtab_posts_cat_four']);
                $mpdtab_posts_show = mpd_get_option($fields['mpdtab_posts_show'], 'DSC');
                $mpdtab_posts_number = mpd_get_option($fields['mpdtab_posts_number'], '6');
                $mpdtab_posts_column = mpd_get_option($fields['mpdtab_posts_column'], '4');
                $mpdtab_show_btn = mpd_get_option($fields['mpdtab_show_btn'], 'yes');
                $mpdtab_btn_text = mpd_get_option($fields['mpdtab_btn_text'], __('Read More', 'magical-posts-display'));
                $mpdtab_posts_img = mpd_get_option($fields['mpdtab_posts_img'], 'show-img');
                $mpdtab_img_size = mpd_get_option($fields['mpdtab_img_size'], 'medium');
                $mpdtab_cat = mpd_get_option($fields['mpdtab_cat'], 'yes');
                $mpdtab_date = mpd_get_option($fields['mpdtab_date'], 'yes');
                $mpdtab_author = mpd_get_option($fields['mpdtab_author']);
                $mpdtab_tag = mpd_get_option($fields['mpdtab_tag']);
                $mpdtab_comment = mpd_get_option($fields['mpdtab_comment']);

                //style items
                $mpdtab_navtab_bgcolor = mpd_get_option($fields['mpdtab_navtab_bgcolor']);
                $mpdtab_navtab_color = mpd_get_option($fields['mpdtab_navtab_color']);
                $mpdtab_navtab_hvcolor = mpd_get_option($fields['mpdtab_navtab_hvcolor']);
                $mpdtab_navitem_bgcolor = mpd_get_option($fields['mpdtab_navitem_bgcolor']);
                $mpdtab_navitem_hvbgcolor = mpd_get_option($fields['mpdtab_navitem_hvbgcolor']);
                $mpdtab_navtab_align = mpd_get_option($fields['mpdtab_navtab_align']);
                $mpdtab_cont_padding = mpd_get_option($fields['mpdtab_cont_padding']);
                $mpdtab_cont_bgcolor = mpd_get_option($fields['mpdtab_cont_bgcolor']);
                $mpdtab_card_bgcolor = mpd_get_option($fields['mpdtab_card_bgcolor']);
                $mpdtab_img_width = mpd_get_option($fields['mpdtab_img_width']);
                $mpdtab_img_height = mpd_get_option($fields['mpdtab_img_height']);
                $mpdtab_img_margin = mpd_get_option($fields['mpdtab_img_margin']);
                $mpdtab_title_size = mpd_get_option($fields['mpdtab_title_size']);
                $mpdtab_title_margin = mpd_get_option($fields['mpdtab_title_margin']);
                $mpdtab_title_color = mpd_get_option($fields['mpdtab_title_color']);
                $mpdtab_desc_size = mpd_get_option($fields['mpdtab_desc_size']);
                $mpdtab_desc_margin = mpd_get_option($fields['mpdtab_desc_margin']);
                $mpdtab_desc_color = mpd_get_option($fields['mpdtab_desc_color']);
                $mpdtab_meta_size = mpd_get_option($fields['mpdtab_meta_size']);
                $mpdtab_meta_color = mpd_get_option($fields['mpdtab_meta_color']);
                $mpdtab_btn = mpd_get_option($fields['mpdtab_btn']);

                if ($mpdtab_posts_show == 'rand') {
                    $mg_orderby = 'rand';
                    $mg_order   = 'DSC';
                } else {
                    $mg_orderby = 'date';
                    $mg_order   = $mpdtab_posts_show;
                }



?>


            <style type="text/css">
                <?php

                mpd_get_style_item(
                    '.tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .mgtnav',
                    array(
                        'background-color' => $mpdtab_navtab_bgcolor
                    )
                );
                mpd_get_style_item(
                    '.tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .mgtnav li a',
                    array(
                        'color' => $mpdtab_navtab_color,
                        'background-color' => $mpdtab_navitem_bgcolor
                    )
                );

                mpd_get_style_item(
                    '.tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .nav-tabs li a:hover,.tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .nav-tabs li a.active',
                    array(
                        'color' => $mpdtab_navtab_hvcolor,
                        'background-color' => $mpdtab_navitem_hvbgcolor,
                    )
                );
                mpd_get_style_item(
                    '.tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .tab-content',
                    array(
                        'padding' => $mpdtab_cont_padding,
                        'background-color' => $mpdtab_cont_bgcolor,
                    )
                );
                // image width height
                if ($mpdtab_img_width) {
                    $mgimg_width =  array(
                        'width' => '100%',
                        'height' => $mpdtab_img_height,
                        'margin-bottom' => $mpdtab_img_margin,
                    );
                } else {
                    $mgimg_width = array(
                        'height' => $mpdtab_img_height,
                        'margin-bottom' => $mpdtab_img_margin,
                    );
                }
                mpd_get_style_item(
                    '.tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .tab-content img',
                    $mgimg_width

                );
                mpd_get_style_item(
                    '.tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .tab-content .card-title,.tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .tab-content .card-title a',
                    array(
                        'font-size' => $mpdtab_title_size,
                        'margin-bottom' => $mpdtab_title_margin,
                        'color' => $mpdtab_title_color,
                    )

                );
                mpd_get_style_item(
                    '.tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .tab-content .card-text',
                    array(
                        'font-size' => $mpdtab_desc_size,
                        'margin-bottom' => $mpdtab_desc_margin,
                        'color' => $mpdtab_desc_color,
                    )

                );
                mpd_get_style_item(
                    '.tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .tab-content .mgpdg1-card',
                    array(
                        'background-color' => $mpdtab_card_bgcolor,
                    )

                );
                mpd_get_style_item(
                    '.tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .mp-meta, .tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .mp-meta a,
        .tab.mgpd-tab.mgpdtab' . esc_attr($rand_num) . ' .mp-meta i',
                    array(
                        'font-size' => $mpdtab_meta_size,
                        'color' => $mpdtab_meta_color,
                    )

                );

                ?>
            </style>
            <?php
                $mpdtab_tabs = array();
                if ($mpdtab_posts_cat_one) {
                    $mpdtab_tabs[] = $mpdtab_posts_cat_one;
                }
                if ($mpdtab_posts_cat_two) {
                    $mpdtab_tabs[] = $mpdtab_posts_cat_two;
                }
                if ($mpdtab_posts_cat_three) {
                    $mpdtab_tabs[] = $mpdtab_posts_cat_three;
                }
                if ($mpdtab_posts_cat_four) {
                    $mpdtab_tabs[] = $mpdtab_posts_cat_four;
                }

            ?>

            <div class="tab mgpd-tab mgpdtab<?php echo esc_attr($rand_num); ?> mgpd-style1 mb-3" role="mgptab">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs mgtnav text-<?php echo esc_attr($mpdtab_navtab_align); ?>" role="tablist">
                    <?php if ($mpdtab_tabs) : ?>
                        <?php
                        $num = 0;
                        foreach ($mpdtab_tabs as $mgtab) :
                            $num++;
                            if ($mgtab) {
                                $cat_obj = get_category_by_slug($mgtab);
                                $cat_name = isset($cat_obj->name) ? $cat_obj->name : '';
                            }

                        ?>
                            <li class="mgtnav-item" role="presentation">
                                <a href="#" class="<?php if ($num == 1) : ?>active<?php else : ?>inactive<?php endif; ?>" id="profile-tab" data-bs-toggle="tab" data-bs-target="#mgcat<?php echo esc_attr($num . $rand_num); ?>" type="button" role="tab" aria-controls="cat<?php echo esc_attr($num . $rand_num); ?>" aria-selected="<?php if ($num == 1) : ?>true<?php else : ?>false<?php endif; ?>"><?php echo esc_html($cat_name); ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabs pt-3 pb-3">
                    <?php if ($mpdtab_tabs) : ?>
                        <?php
                        $num = 0;
                        foreach ($mpdtab_tabs as $mgtab) :
                            $num++
                        ?>
                            <div role="mgptab" class="tab-pane mgpdtab1 fade <?php if ($num == 1) : ?>show active<?php endif; ?>" id="mgcat<?php echo esc_attr($num . $rand_num); ?>">
                                <div class="mgpd mp-display-gird mgptab mgpdtab1 mgpdtab1<?php echo esc_attr($rand_num); ?> ">
                                    <div class="mgpd-masonry">
                                        <div class="row">
                                            <?php


                                            //  $mpd1_loop= new WP_Query($mpd_args1);
                                            $mpd1_loop = new WP_Query($this->mgpd_query_arg($mpdtab_posts_number, $mgtab, $mg_orderby, $mg_order));

                                            if ($mpd1_loop->have_posts()) :
                                                while ($mpd1_loop->have_posts()) :  $mpd1_loop->the_post();
                                                    $post_thumb_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
                                                    //tag list
                                                    $tags_list = get_the_tag_list();
                                            ?>
                                                    <div class="mgpd-masonry-item col-lg-<?php echo esc_attr($mpdtab_posts_column); ?>">
                                                        <div class="card mgpdg1-card mb-4">


                                                            <?php if (has_post_thumbnail()) : ?>
                                                                <?php the_post_thumbnail($mpdtab_img_size, array('class' => 'card-img-top')); ?>
                                                            <?php endif; ?>
                                                            ?>
                                                            <div class="card-body">
                                                                <?php if ($mpdtab_cat) : ?>
                                                                    <div class="mp-meta cat-list">
                                                                        <?php mpd_one_cat(get_the_ID()); ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                                                <?php if (!empty($mpdtab_author) || !empty($mpdtab_date) || !empty($mpdtab_comment)) : ?>
                                                                    <div class="mp-meta bottom-meta mb-2">
                                                                        <?php
                                                                        if ($mpdtab_author) {
                                                                            mp_display_posted_by();
                                                                        }
                                                                        if ($mpdtab_date) {
                                                                            echo '<i class="icon-mp-clock"></i> ';
                                                                            echo esc_html(get_the_date());
                                                                        }
                                                                        if ($mpdtab_comment) {
                                                                            mp_display_single_comment_icon();
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <p class="card-text">

                                                                    <?php
                                                                    if (has_excerpt()) {
                                                                        echo esc_html(wp_trim_words(get_the_excerpt(), 25, '...'));
                                                                    } else {
                                                                        echo esc_html(wp_trim_words(get_the_content(), 25, '...'));
                                                                    }
                                                                    ?>
                                                                </p>
                                                                <?php if ($mpdtab_show_btn) : ?>
                                                                    <a href="<?php the_permalink(); ?>" class="btn btn-<?php echo esc_attr($mpdtab_btn); ?>"><?php echo esc_html($mpdtab_btn_text); ?></a>
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php if ($tags_list && $mpdtab_tag) : ?>
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

                                                wp_reset_query();
                                                wp_reset_postdata();
                                            else :
                                                ?>
                                                <div class="mp-error text-center pb-5 pt-5">
                                                    <?php esc_html_e('No post found!', 'magical-posts-display'); ?>
                                                </div>
                                            <?php

                                            endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- Tab end -->
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="mp-error text-center pb-5 pt-5">
                            <?php esc_html_e('Please select minimum One category', 'magical-posts-display'); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>


<?php
            });
    }
}

new postsTab();
