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
class mgdPostList
{

    function __construct()
    {
        add_action('carbon_fields_register_fields', [$this, 'mgd_post_list']);
    }

    /**
     *  Taxonomy List
     * @return array
     */
    function mgpd_cat_list()
    {
        $options['all'] = __('All category', 'magical-posts-display');
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


    function mgd_post_list()
    {

        Block::make(__('Magical Posts List card', 'magical-posts-display'))
            ->set_category('magical-posts-display', __('Magical Posts', 'magical-posts-display'), 'welcome-widgets-menus')
            ->set_icon('excerpt-view')
            ->set_keywords([__('post', 'magical-posts-display'), __('List', 'magical-posts-display'), __('card', 'magical-posts-display')])
            ->set_mode('both')
            ->add_tab(__('Posts List'), array(
                Field::make('separator', 'mpdg_post_content', __('Post content', 'magical-posts-display')),
                Field::make('select', 'mpdg_posts_show', __('Show Posts by', 'magical-posts-display'))
                    ->set_options(array(
                        'DSC' => __('Latest Posts', 'magical-posts-display'),
                        'ASC' => __('Oldest Posts', 'magical-posts-display'),
                        'rand' => __('Random Posts', 'magical-posts-display'),
                    ))
                    ->set_default_value('DSC'),
                Field::make('select', 'mpdg_posts_cat', __('Select Category', 'magical-posts-display'))
                    ->set_options(array($this, 'mgpd_cat_list'))
                    ->set_default_value('all'),
                Field::make('text', 'mpdg_posts_number', __('Posts number', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(9),
                Field::make('select', 'mpdg_text_align', __('Text position', 'magical-posts-display'))
                    ->set_options(array(
                        'left' => __('Left', 'magical-posts-display'),
                        'center' => __('Center', 'magical-posts-display'),
                        'right' => __('Right', 'magical-posts-display'),
                    ))
                    ->set_default_value('left'),
                Field::make('checkbox', 'mpdg_show_btn', 'Show Button')
                    ->set_default_value('yes'),
                Field::make('text', 'mpdg_btn_text', __('Button text', 'magical-posts-display'))
                    ->set_default_value(__('Read More', 'magical-posts-display')),
                Field::make('checkbox', 'mpdg_show_pagination', 'Show Posts Pagination'),
                Field::make('separator', 'mpdg_post_img', __('Posts image', 'magical-posts-display')),
                Field::make('select', 'mpdg_posts_img', __('Show Posts image', 'magical-posts-display'))
                    ->set_options(array(
                        'show-img' => __('Show image', 'magical-posts-display'),
                        'hide-img' => __('Hide image', 'magical-posts-display'),
                    ))
                    ->set_default_value('show-img'),
                Field::make('select', 'mpdg_img_position', __('Image Position', 'magical-posts-display'))
                    ->set_options(array(
                        'left' => __('Left', 'magical-posts-display'),
                        'right' => __('Right', 'magical-posts-display'),
                    ))
                    ->set_default_value('left'),
                Field::make('select', 'mpdg_img_size', __('Image size', 'magical-posts-display'))
                    ->set_options(array(
                        'thumbnail' => __('Thumbnail (150*150)', 'magical-posts-display'),
                        'medium' => __('Medium (300*300)', 'magical-posts-display'),
                        'card-List' => __('List Card (600*900)', 'magical-posts-display'),
                        'card-list' => __('List card (600*700)', 'magical-posts-display'),
                        'medium_large' => __('Medium large (768*0)', 'magical-posts-display'),
                        'large' => __('Large ( 1024*1024)', 'magical-posts-display'),
                        'full' => __('Orginal size', 'magical-posts-display'),
                    ))
                    ->set_default_value('card-List'),

                Field::make('separator', 'mpdg_post_meta', __('Post Meta', 'magical-posts-display')),
                Field::make('checkbox', 'mpdg_cat', __('Show Category', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdg_author', __('Show Author', 'magical-posts-display')),
                Field::make('checkbox', 'mpdg_date', __('Show Date', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdg_tag', __('Show Tags', 'magical-posts-display')),
                Field::make('checkbox', 'mpdg_comment', __('Show Comment', 'magical-posts-display')),
            ))
            ->add_tab(__('List Style'), array(
                Field::make('separator', 'mpdg_sep_content', __('Content Style', 'magical-posts-display')),

                Field::make('text', 'mpdg_cont_padding', __('Content Padding', 'magical-posts-display'))->set_help_text(__('Enter content padding. padding set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdg_cont_bgcolor', __('Content background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdg_sep_img', __('Image Style', 'magical-posts-display')),
                Field::make('checkbox', 'mpdg_img_width', __('Set 100% image width', 'magical-posts-display'))
                    ->set_option_value('yes'),
                Field::make('text', 'mpdg_img_height', __('Image height', 'magical-posts-display'))->set_help_text(__('Set image height. Leave empty for auto height.'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdg_img_margin', __('Image bottom space', 'magical-posts-display'))->set_help_text(__('Tyepe image bottom margin. Icon margin set by px'))
                    ->set_attribute('type', 'number'),

                Field::make('separator', 'mpdg_sep_title', __('Title Style', 'magical-posts-display')),
                Field::make('text', 'mpdg_title_size', __('Title font size', 'magical-posts-display'))->set_help_text(__('Tyepe number for icon size. Icon size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdg_title_margin', __('Title bottom space', 'magical-posts-display'))->set_help_text(__('Tyepe number icon margin. Icon margin set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdg_title_color', __('Title color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdg_sep_desc', __('Description Style', 'magical-posts-display')),

                Field::make('text', 'mpdg_desc_size', __('Description size', 'magical-posts-display'))->set_help_text(__('Tyepe number for icon size. Icon size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdg_desc_margin', __('Description bottom space', 'magical-posts-display'))->set_help_text(__('Description bottom margin. Margin set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdg_desc_color', __('Description color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdg_sep_meta', __('Meta Style', 'magical-posts-display')),

                Field::make('text', 'mpdg_meta_size', __('Meta size', 'magical-posts-display'))->set_help_text(__('Set Meta size. Meta size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdg_meta_color', __('Meta color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),


                Field::make('separator', 'mpdg_sep_btn', __('Button style', 'magical-posts-display')),
                Field::make('select', 'mpdg_btn', __('Select button', 'magical-posts-display'))
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
                $rand_num = wp_rand(6252948, 8952146);
                $mpdg_posts_show = isset($fields['mpdg_posts_show']) ? $fields['mpdg_posts_show'] : 'DSC';
                $mpdg_posts_cat = isset($fields['mpdg_posts_cat']) ? $fields['mpdg_posts_cat'] : 'all';
                $mpdg_posts_number = isset($fields['mpdg_posts_number']) ? $fields['mpdg_posts_number'] : '9';
                $mpdg_text_align = isset($fields['mpdg_text_align']) ? $fields['mpdg_text_align'] : 'left';
                $mpdg_posts_img = isset($fields['mpdg_posts_img']) ? $fields['mpdg_posts_img'] : 'show-img';
                $mpdg_img_position = isset($fields['mpdg_img_position']) ? $fields['mpdg_img_position'] : 'left';
                $mpdg_img_size = isset($fields['mpdg_img_size']) ? $fields['mpdg_img_size'] : 'card-List';
                $mpdg_show_btn = isset($fields['mpdg_show_btn']) ? $fields['mpdg_show_btn'] : 'yes';
                $mpdg_btn_text = isset($fields['mpdg_btn_text']) ? $fields['mpdg_btn_text'] : __('Read More', 'magical-posts-display');
                $mpdg_show_pagination = isset($fields['mpdg_show_pagination']) ? $fields['mpdg_show_pagination'] : '';
                $mpdg_cat = isset($fields['mpdg_cat']) ? $fields['mpdg_cat'] : 'yes';
                $mpdg_author = isset($fields['mpdg_author']) ? $fields['mpdg_author'] : '';
                $mpdg_date = isset($fields['mpdg_date']) ? $fields['mpdg_date'] : 'yes';
                $mpdg_tag = isset($fields['mpdg_tag']) ? $fields['mpdg_tag'] : '';
                $mpdg_comment = isset($fields['mpdg_comment']) ? $fields['mpdg_comment'] : '';
                $mpdg_cont_padding = isset($fields['mpdg_cont_padding']) ? $fields['mpdg_cont_padding'] : '';
                $mpdg_cont_bgcolor = isset($fields['mpdg_cont_bgcolor']) ? $fields['mpdg_cont_bgcolor'] : '';
                $mpdg_img_width = isset($fields['mpdg_img_width']) ? $fields['mpdg_img_width'] : 'yes';
                $mpdg_img_height = isset($fields['mpdg_img_height']) ? $fields['mpdg_img_height'] : '';
                $mpdg_img_margin = isset($fields['mpdg_img_margin']) ? $fields['mpdg_img_margin'] : '';
                $mpdg_title_size = isset($fields['mpdg_title_size']) ? $fields['mpdg_title_size'] : '';
                $mpdg_title_margin = isset($fields['mpdg_title_margin']) ? $fields['mpdg_title_margin'] : '';
                $mpdg_title_color = isset($fields['mpdg_title_color']) ? $fields['mpdg_title_color'] : '';
                $mpdg_desc_size = isset($fields['mpdg_desc_size']) ? $fields['mpdg_desc_size'] : '';
                $mpdg_desc_margin = isset($fields['mpdg_desc_margin']) ? $fields['mpdg_desc_margin'] : '';
                $mpdg_desc_color = isset($fields['mpdg_desc_color']) ? $fields['mpdg_desc_color'] : '';
                $mpdg_meta_size = isset($fields['mpdg_meta_size']) ? $fields['mpdg_meta_size'] : '';
                $mpdg_meta_color = isset($fields['mpdg_meta_color']) ? $fields['mpdg_meta_color'] : '';
                $mpdg_btn = isset($fields['mpdg_btn']) ? $fields['mpdg_btn'] : 'info';


?>
            <div class="mgpd mp-display-list mgpdl mgpdl<?php echo esc_attr($rand_num); ?> ">
                <style type="text/css">
                    <?php if ($mpdg_cont_padding || $mpdg_cont_bgcolor) : ?>.mgpdl<?php echo esc_attr($rand_num); ?>.mgpdl-card {
                        <?php if ($mpdg_cont_padding) : ?>padding: <?php echo esc_attr($mpdg_cont_padding); ?>px !important;
                        <?php endif; ?><?php if ($mpdg_cont_bgcolor) : ?>background: <?php echo esc_attr($mpdg_cont_bgcolor); ?>;
                        <?php endif; ?>
                    }

                    <?php endif; ?><?php if ($mpdg_img_width || $mpdg_img_height || $mpdg_img_margin) : ?>.mgpdl<?php echo esc_attr($rand_num); ?>.mgpdl-card img,
                    .mgpdl<?php echo esc_attr($rand_num); ?>.mgpdl-card .no-post-thumbnail {
                        <?php if ($mpdg_img_width == 'yes') : ?>width: 100%;
                        <?php endif; ?><?php if ($mpdg_img_height) : ?>height: <?php echo esc_attr($mpdg_img_height); ?>px;
                        <?php endif; ?><?php if ($mpdg_img_margin) : ?>margin-bottom: <?php echo esc_attr($mpdg_img_margin); ?>px;
                        <?php endif; ?>
                    }

                    <?php endif; ?><?php if ($mpdg_title_size || $mpdg_title_margin || $mpdg_title_color) : ?>.mgpdl<?php echo esc_attr($rand_num); ?>.mgpdl-card .card-title a,
                    .mgpdl<?php echo esc_attr($rand_num); ?>.mgpdl-card .card-title {
                        <?php if ($mpdg_title_size) : ?>font-size: <?php echo esc_attr($mpdg_title_size); ?>px;
                        <?php endif; ?><?php if ($mpdg_title_color) : ?>color: <?php echo esc_attr($mpdg_title_color); ?>;
                        <?php endif; ?><?php if ($mpdg_title_margin) : ?>margin-bottom: <?php echo esc_attr($mpdg_title_margin); ?>px;
                        <?php endif; ?>
                    }

                    <?php endif; ?><?php if ($mpdg_desc_size || $mpdg_desc_margin || $mpdg_desc_color) : ?>.mgpdl<?php echo esc_attr($rand_num); ?>.mgpdl-card .card-text {
                        <?php if ($mpdg_desc_size) : ?>font-size: <?php echo esc_attr($mpdg_desc_size); ?>px;
                        <?php endif; ?><?php if ($mpdg_desc_color) : ?>color: <?php echo esc_attr($mpdg_desc_color); ?>;
                        <?php endif; ?><?php if ($mpdg_desc_margin) : ?>margin-bottom: <?php echo esc_attr($mpdg_desc_margin); ?>px;
                        <?php endif; ?>
                    }

                    <?php endif; ?><?php if ($mpdg_meta_size || $mpdg_meta_color) : ?>.mgpdl<?php echo esc_attr($rand_num); ?>.mp-meta,
                    .mgpdl<?php echo esc_attr($rand_num); ?>.mp-meta a,
                    .mgpdl<?php echo esc_attr($rand_num); ?>.mp-meta i {
                        <?php if ($mpdg_meta_size) : ?>font-size: <?php echo esc_attr($mpdg_meta_size); ?>px;
                        <?php endif; ?><?php if ($mpdg_meta_color) : ?>color: <?php echo esc_attr($mpdg_meta_color); ?>;
                        <?php endif; ?>
                    }

                    <?php endif; ?>
                </style>




                <div class="mgpdl-items">
                    <?php


                    if ($mpdg_posts_cat != 'all') {
                        $terms = array(
                            array(
                                'taxonomy'  => 'category',
                                'field'  => 'slug',
                                'terms'  => $mpdg_posts_cat
                            )
                        );
                    } else {
                        $terms = '';
                    }
                    if (is_front_page()) {
                        $paged = (get_query_var('page')) ? get_query_var('page') : 1;
                    } else {
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    }
                    $mp_args = array(
                        'post_type'         =>  'post',
                        'post_status'       =>  'publish',
                        'posts_per_page'    => $mpdg_posts_number,
                        'tax_query'         =>  $terms,
                        'ignore_sticky_posts' => 1
                    );
                    if ($mpdg_posts_show == 'rand') {
                        $mp_args['orderby'] = 'rand';
                    } else {
                        $mp_args['order'] = $mpdg_posts_show;
                    }
                    if (is_page() && $mpdg_show_pagination) {
                        $mp_args['paged'] = $paged;
                    }

                    $mp_loop = new WP_Query($mp_args);
                    if ($mp_loop->have_posts()) :
                        while ($mp_loop->have_posts()) :  $mp_loop->the_post();
                            $post_thumb_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
                            //tag list
                            $tags_list = get_the_tag_list();
                    ?>
                            <div class="mgpdl-item mgpd-list <?php if (has_post_thumbnail() && $mpdg_posts_img == 'show-img') : ?>mgpdl-hasimg<?php endif; ?>">
                                <div class="card mgpdl-card mb-4">
                                    <div class="row">

                                        <?php if ($mpdg_posts_img == 'show-img' && has_post_thumbnail() && $mpdg_img_position == 'left') : ?>
                                            <div class="col-md-5">
                                                <?php the_post_thumbnail($mpdg_img_size, array('class' => 'card-img-top')); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-md-<?php if ($mpdg_posts_img == 'show-img' && has_post_thumbnail()) : ?>7<?php else : ?>12<?php endif; ?>">
                                            <div class="card-body text-<?php echo esc_attr($mpdg_text_align); ?>">
                                                <?php if ($mpdg_cat) : ?>
                                                    <div class="mp-meta cat-list">
                                                        <?php mpd_one_cat(get_the_ID()); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                                <?php if (!empty($mpdg_author) || !empty($mpdg_date) || !empty($mpdg_comment)) : ?>
                                                    <div class="mp-meta bottom-meta mb-2">
                                                        <?php
                                                        if ($mpdg_author) {
                                                            mp_display_posted_by();
                                                        }
                                                        if ($mpdg_date) {
                                                            echo '<i class="icon-mp-clock"></i> ';
                                                            echo esc_html(get_the_date());
                                                        }
                                                        if ($mpdg_comment) {
                                                            mp_display_single_comment_icon();
                                                        }
                                                        ?>
                                                    </div>
                                                <?php endif; ?>
                                                <p class="card-text">
                                                    <?php /* echo wp_trim_words(get_the_content(), 40, ' Show by button'); */ ?>
                                                    <?php
                                                    if (has_excerpt()) {
                                                        echo esc_html(wp_trim_words(get_the_excerpt(), 40, '...'));
                                                    } else {
                                                        echo esc_html(wp_trim_words(get_the_content(), 40, '...'));
                                                    }
                                                    ?>
                                                </p>
                                                <?php if ($mpdg_show_btn) : ?>
                                                    <a href="<?php the_permalink(); ?>" class="btn btn-<?php echo esc_attr($mpdg_btn); ?>"><?php echo esc_html($mpdg_btn_text); ?></a>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ($tags_list && $mpdg_tag) : ?>
                                                <div class="card-footer text-<?php echo esc_attr($mpdg_text_align); ?>">
                                                    <div class="mp-meta tag-list">
                                                        <?php mp_display_tag_link(); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($mpdg_posts_img == 'show-img' && has_post_thumbnail() && $mpdg_img_position == 'right') : ?>
                                            <div class="col-md-5">
                                                <?php the_post_thumbnail($mpdg_img_size, array('class' => 'card-img-top')); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        <?php
                        endwhile;

                        wp_reset_postdata();
                    else :
                        ?>
                        <div class="mp-error text-center pb-5 pt-5">
                            <?php esc_html_e('No post found!', 'magical-posts-display'); ?>
                        </div>
                    <?php

                    endif; ?>
                </div>
                <?php
                if (is_page() && $mpdg_show_pagination) {
                    mp_display_pagination($paged, $mp_loop);
                }
                ?>
            </div>



<?php
            });
    }
}

new mgdPostList();
