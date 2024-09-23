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
class mgdPostCarousel
{

    function __construct()
    {
        add_action('carbon_fields_register_fields', [$this, 'mgpd_carousel']);
    }

    /**
     *  Taxonomy List
     * @return array
     */
    function mgpd_cat_list()
    {
        $options[] = '';
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


    function mgpd_carousel()
    {

        Block::make(__('Magical Posts Carouesl', 'magical-posts-display'))
            ->set_category('magical-posts-display', __('Magical Posts', 'magical-posts-display'), 'welcome-widgets-menus')
            ->set_icon('editor-insertmore')
            ->set_keywords([__('carousel', 'magical-posts-display'), __('slider', 'magical-posts-display'), __('post', 'magical-posts-display')])
            ->set_mode('edit')
            ->add_tab(__('Carouesl Items'), array(
                Field::make('separator', 'mpdc_post_content', __('Post content', 'magical-posts-display')),
                Field::make('select', 'mpdc_posts_show', __('Show Posts by', 'magical-posts-display'))
                    ->set_options(array(
                        'DSC' => __('Latest Posts', 'magical-posts-display'),
                        'ASC' => __('Oldest Posts', 'magical-posts-display'),
                        'rand' => __('Random Posts', 'magical-posts-display'),
                    ))
                    ->set_default_value('DSC'),
                Field::make('select', 'mpdc_posts_cat', __('Select Category', 'magical-posts-display'))
                    ->set_options(array($this, 'mgpd_cat_list'))
                    ->set_default_value('all'),
                Field::make('text', 'mpdc_posts_number', __('Posts number', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(9),

                Field::make('checkbox', 'mpdc_show_btn', 'Show Button')
                    ->set_default_value('yes'),
                Field::make('text', 'mpdc_btn_text', __('Button Text', 'magical-posts-display'))
                    ->set_default_value(__('Read More', 'magical-posts-display')),

                Field::make('separator', 'mpdc_post_img', __('Posts image', 'magical-posts-display')),
                Field::make('select', 'mpdc_posts_img', __('Show Posts image', 'magical-posts-display'))
                    ->set_options(array(
                        'show-img' => __('Show image', 'magical-posts-display'),
                        'hide-img' => __('Hide image', 'magical-posts-display'),
                    ))
                    ->set_default_value('show-img'),
                Field::make('select', 'mpdc_img_size', __('Image size', 'magical-posts-display'))
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

                Field::make('separator', 'mpdc_post_meta', __('Post Meta', 'magical-posts-display')),
                Field::make('checkbox', 'mpdc_cat', __('Show Category', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdc_author', __('Show Author', 'magical-posts-display')),
                Field::make('checkbox', 'mpdc_date', __('Show Date', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdc_tag', __('Show Tags', 'magical-posts-display')),
                Field::make('checkbox', 'mpdc_comment', __('Show Comment', 'magical-posts-display')),
            ))

            ->add_tab(__('Carouesl Options'), array(
                Field::make('separator', 'mpdc_sep_options', __('Carouesl options', 'magical-posts-display')),
                Field::make('checkbox', 'mpdc_autoplay', __('autoplay', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('text', 'mpdc_delay', __('Autoplay delay time', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(3000),
                Field::make('checkbox', 'mpdc_loop', __('Loop', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdc_autoheight', __('Auto Height', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdc_grabcursor', __('Grab Cursor', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdc_nav', __('Show Nav', 'magical-posts-display')),
                Field::make('checkbox', 'mpdc_dots', __('Show Dots', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('text', 'mpdc_items_big', __('Item Per View For Big Screen', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(3),
                Field::make('text', 'mpdc_space_big', __('Space Between For Big Screen', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(30),
                Field::make('text', 'mpdc_items_medium', __('Item Per View For Medium Screen', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(2),
                Field::make('text', 'mpdc_space_medium', __('Space Between For Medium Screen', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(20),
                Field::make('text', 'mpdc_items_small', __('Item Per View For Small Screen', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(1),
                Field::make('text', 'mpdc_space_small', __('Space Between For Small Screen', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(10),
                Field::make('separator', 'mpdc_sep_showhide', __('Carouesl Item Show Hide', 'magical-posts-display')),
                Field::make('checkbox', 'mpdc_simg', __('Show Image', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdc_stitle', __('Show Title', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdc_sdesc', __('Show Description', 'magical-posts-display')),

            ))

            ->add_tab(__('Carouesl Style'), array(
                Field::make('separator', 'mpdc_sep_content', __('Content Style', 'magical-posts-display')),
                Field::make('select', 'mpdc_style', __('Card Style', 'magical-posts-display'))
                    ->set_options(array(
                        'mgpdc1' => __('Style one', 'magical-posts-display'),
                        'mgpdc2' => __('Style two', 'magical-posts-display'),
                    ))
                    ->set_default_value('mgpdc2'),

                Field::make('text', 'mpdc_cont_padding', __('Content Padding', 'magical-posts-display'))->set_help_text(__('Enter content padding. padding set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdc_cont_bgcolor', __('Content background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdc_sep_img', __('Image Style', 'magical-posts-display')),
                Field::make('checkbox', 'mpdc_img_width', __('Set 100% image width', 'magical-posts-display'))
                    ->set_option_value('yes'),
                Field::make('text', 'mpdc_img_height', __('Image height', 'magical-posts-display'))->set_help_text(__('Set image height. Leave empty for auto height.'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdc_img_margin', __('Image bottom space', 'magical-posts-display'))->set_help_text(__('Tyepe image bottom margin. Icon margin set by px'))
                    ->set_attribute('type', 'number'),

                Field::make('separator', 'mpdc_sep_title', __('Title Style', 'magical-posts-display')),
                Field::make('text', 'mpdc_title_size', __('Title font size', 'magical-posts-display'))->set_help_text(__('Tyepe number for icon size. Icon size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdc_title_margin', __('Title bottom space', 'magical-posts-display'))->set_help_text(__('Tyepe number icon margin. Icon margin set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdc_title_color', __('Title color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdc_sep_desc', __('Description Style', 'magical-posts-display')),

                Field::make('text', 'mpdc_desc_size', __('Description size', 'magical-posts-display'))->set_help_text(__('Tyepe number for icon size. Icon size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdc_desc_margin', __('Description bottom space', 'magical-posts-display'))->set_help_text(__('Description bottom margin. Margin set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdc_desc_color', __('Description color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdc_sep_meta', __('Meta Style', 'magical-posts-display')),

                Field::make('text', 'mpdc_meta_size', __('Meta size', 'magical-posts-display'))->set_help_text(__('Set Meta size. Meta size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdc_meta_color', __('Meta color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),


                Field::make('separator', 'mpdc_sep_btn', __('Button style', 'magical-posts-display')),
                Field::make('select', 'mpdc_btn', __('Select button', 'magical-posts-display'))
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
                    ->set_default_value('link'),

            ))



            ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                $rand_num = wp_rand(798548, 325894);
                $mpdc_posts_show = isset($fields['mpdc_posts_show']) ? $fields['mpdc_posts_show'] : 'DSC';
                $mpdc_posts_cat = isset($fields['mpdc_posts_cat']) ? $fields['mpdc_posts_cat'] : 'all';
                $mpdc_posts_number = isset($fields['mpdc_posts_number']) ? $fields['mpdc_posts_number'] : '9';
                $mpdc_img_size = isset($fields['mpdc_img_size']) ? $fields['mpdc_img_size'] : 'medium';
                $mpdc_posts_img = isset($fields['mpdc_posts_img']) ? $fields['mpdc_posts_img'] : 'show-img';
                $mpdc_show_btn = isset($fields['mpdc_show_btn']) ? $fields['mpdc_show_btn'] : 'yes';
                $mpdc_btn_text = isset($fields['mpdc_btn_text']) ? $fields['mpdc_btn_text'] : __('Read More', 'magical-posts-display');
                $mpdc_cat = isset($fields['mpdc_cat']) ? $fields['mpdc_cat'] : 'yes';
                $mpdc_author = isset($fields['mpdc_author']) ? $fields['mpdc_author'] : '';
                $mpdc_date = isset($fields['mpdc_date']) ? $fields['mpdc_date'] : 'yes';
                $mpdc_tag = isset($fields['mpdc_tag']) ? $fields['mpdc_tag'] : '';
                $mpdc_comment = isset($fields['mpdc_comment']) ? $fields['mpdc_comment'] : '';
                // all carousel options
                $mpdc_autoplay = isset($fields['mpdc_autoplay']) ? $fields['mpdc_autoplay'] : 'yes';
                $mpdc_delay = isset($fields['mpdc_delay']) ? $fields['mpdc_delay'] : '3000';
                $mpdc_loop = isset($fields['mpdc_loop']) ? $fields['mpdc_loop'] : 'yes';
                $mpdc_autoheight = isset($fields['mpdc_autoheight']) ? $fields['mpdc_autoheight'] : 'yes';
                $mpdc_grabcursor = isset($fields['mpdc_grabcursor']) ? $fields['mpdc_grabcursor'] : 'yes';
                $mpdc_nav = isset($fields['mpdc_nav']) ? $fields['mpdc_nav'] : '';
                $mpdc_dots = isset($fields['mpdc_dots']) ? $fields['mpdc_dots'] : 'yes';
                $mpdc_items_big = isset($fields['mpdc_items_big']) ? $fields['mpdc_items_big'] : '3';
                $mpdc_space_big = isset($fields['mpdc_space_big']) ? $fields['mpdc_space_big'] : '30';
                $mpdc_items_medium = isset($fields['mpdc_items_medium']) ? $fields['mpdc_items_medium'] : '2';
                $mpdc_space_medium = isset($fields['mpdc_space_medium']) ? $fields['mpdc_space_medium'] : '20';
                $mpdc_items_small = isset($fields['mpdc_items_small']) ? $fields['mpdc_items_small'] : '1';
                $mpdc_space_small = isset($fields['mpdc_space_small']) ? $fields['mpdc_space_small'] : '10';
                $mpdc_simg = isset($fields['mpdc_simg']) ? $fields['mpdc_simg'] : 'yes';
                $mpdc_stitle = isset($fields['mpdc_stitle']) ? $fields['mpdc_stitle'] : 'yes';
                $mpdc_sdesc = isset($fields['mpdc_sdesc']) ? $fields['mpdc_sdesc'] : '';

                // all style options
                $mpdc_style = isset($fields['mpdc_style']) ? $fields['mpdc_style'] : 'mgpdc2';
                $mpdc_cont_padding = isset($fields['mpdc_cont_padding']) ? $fields['mpdc_cont_padding'] : '';
                $mpdc_cont_bgcolor = isset($fields['mpdc_cont_bgcolor']) ? $fields['mpdc_cont_bgcolor'] : '';
                $mpdc_img_width = isset($fields['mpdc_img_width']) ? $fields['mpdc_img_width'] : 'yes';
                $mpdc_img_height = isset($fields['mpdc_img_height']) ? $fields['mpdc_img_height'] : '';
                $mpdc_img_margin = isset($fields['mpdc_img_margin']) ? $fields['mpdc_img_margin'] : '';
                $mpdc_title_size = isset($fields['mpdc_title_size']) ? $fields['mpdc_title_size'] : '';
                $mpdc_title_margin = isset($fields['mpdc_title_margin']) ? $fields['mpdc_title_margin'] : '';
                $mpdc_title_color = isset($fields['mpdc_title_color']) ? $fields['mpdc_title_color'] : '';
                $mpdc_desc_size = isset($fields['mpdc_desc_size']) ? $fields['mpdc_desc_size'] : '';
                $mpdc_desc_margin = isset($fields['mpdc_desc_margin']) ? $fields['mpdc_desc_margin'] : '';
                $mpdc_desc_color = isset($fields['mpdc_desc_color']) ? $fields['mpdc_desc_color'] : '';
                $mpdc_meta_size = isset($fields['mpdc_meta_size']) ? $fields['mpdc_meta_size'] : '';
                $mpdc_meta_color = isset($fields['mpdc_meta_color']) ? $fields['mpdc_meta_color'] : '';
                $mpdc_btn = isset($fields['mpdc_btn']) ? $fields['mpdc_btn'] : 'link';


?>
            <div class="mgpd mp-display-gird mgpc<?php echo esc_attr($rand_num); ?> <?php echo esc_attr($mpdc_style); ?> ">
                <style type="text/css">
                    <?php if ($mpdc_cont_padding || $mpdc_cont_bgcolor) : ?>.mgpc<?php echo esc_attr($rand_num); ?>.mgpdg1-card {
                        <?php if ($mpdc_cont_padding) : ?>padding: <?php echo esc_attr($mpdc_cont_padding); ?>px !important;
                        <?php endif; ?><?php if ($mpdc_cont_bgcolor) : ?>background: <?php echo esc_attr($mpdc_cont_bgcolor); ?>;
                        <?php endif; ?>
                    }

                    <?php endif; ?><?php if ($mpdc_cont_bgcolor) : ?>.mgpc<?php echo esc_attr($rand_num); ?>.mgpdc2 .card .mp-meta.cat-list {
                        <?php if ($mpdc_cont_bgcolor) : ?>background: <?php echo esc_attr($mpdc_cont_bgcolor); ?>;
                        <?php endif; ?>
                    }

                    <?php endif; ?><?php if ($mpdc_img_width || $mpdc_img_height || $mpdc_img_margin) : ?>.mgpc<?php echo esc_attr($rand_num); ?>.mgpdg1-card img,
                    .mgpc<?php echo esc_attr($rand_num); ?>.mgpdg1-card .no-post-thumbnail {
                        <?php if ($mpdc_img_width == 'yes') : ?>width: 100%;
                        <?php endif; ?><?php if ($mpdc_img_height) : ?>height: <?php echo esc_attr($mpdc_img_height); ?>px;
                        <?php endif; ?><?php if ($mpdc_img_margin) : ?>margin-bottom: <?php echo esc_attr($mpdc_img_margin); ?>px;
                        <?php endif; ?>
                    }

                    <?php endif; ?><?php if ($mpdc_title_size || $mpdc_title_margin || $mpdc_title_color) : ?>.mgpc<?php echo esc_attr($rand_num); ?>.mgpdg1-card .card-title a,
                    .mgpc<?php echo esc_attr($rand_num); ?>.mgpdg1-card .card-title {
                        <?php if ($mpdc_title_size) : ?>font-size: <?php echo esc_attr($mpdc_title_size); ?>px;
                        <?php endif; ?><?php if ($mpdc_title_color) : ?>color: <?php echo esc_attr($mpdc_title_color); ?>;
                        <?php endif; ?><?php if ($mpdc_title_margin) : ?>margin-bottom: <?php echo esc_attr($mpdc_title_margin); ?>px;
                        <?php endif; ?>
                    }

                    <?php endif; ?><?php if ($mpdc_desc_size || $mpdc_desc_margin || $mpdc_desc_color) : ?>.mgpc<?php echo esc_attr($rand_num); ?>.mgpdg1-card .card-text {
                        <?php if ($mpdc_desc_size) : ?>font-size: <?php echo esc_attr($mpdc_desc_size); ?>px;
                        <?php endif; ?><?php if ($mpdc_desc_color) : ?>color: <?php echo esc_attr($mpdc_desc_color); ?>;
                        <?php endif; ?><?php if ($mpdc_desc_margin) : ?>margin-bottom: <?php echo esc_attr($mpdc_desc_margin); ?>px;
                        <?php endif; ?>
                    }

                    <?php endif; ?><?php if ($mpdc_meta_size || $mpdc_meta_color) : ?>.mgpc<?php echo esc_attr($rand_num); ?>.mp-meta,
                    .mgpc<?php echo esc_attr($rand_num); ?>.mp-meta a,
                    .mgpc<?php echo esc_attr($rand_num); ?>.mp-meta i {
                        <?php if ($mpdc_meta_size) : ?>font-size: <?php echo esc_attr($mpdc_meta_size); ?>px;
                        <?php endif; ?><?php if ($mpdc_meta_color) : ?>color: <?php echo esc_attr($mpdc_meta_color); ?>;
                        <?php endif; ?>
                    }

                    <?php endif; ?>
                </style>




                <div class="swiper-container mgpc<?php echo esc_attr($rand_num); ?>">
                    <div class="mgpsac<?php echo esc_attr($rand_num); ?>">
                        <div class="swiper-wrapper">
                            <?php


                            if ($mpdc_posts_cat != 'all') {
                                $terms = array(
                                    array(
                                        'taxonomy'  => 'category',
                                        'field'  => 'slug',
                                        'terms'  => $mpdc_posts_cat
                                    )
                                );
                            } else {
                                $terms = '';
                            }



                            $mp_args = array(
                                'post_type'         =>  'post',
                                'post_status'       =>  'publish',
                                'posts_per_page'    => $mpdc_posts_number,
                                'tax_query'         =>  $terms,
                                'ignore_sticky_posts' => 1
                            );
                            if ($mpdc_posts_show == 'rand') {
                                $mp_args['orderby'] = 'rand';
                            } else {
                                $mp_args['order'] = $mpdc_posts_show;
                            }



                            $mp_loop = new WP_Query($mp_args);
                            if ($mp_loop->have_posts()) :
                                while ($mp_loop->have_posts()) :  $mp_loop->the_post();
                                    $post_thumb_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
                                    //tag list
                                    $tags_list = get_the_tag_list();
                            ?>
                                    <div class="swiper-slide">
                                        <div class="card mgpdg1-card mb-4">

                                            <?php if ($mpdc_simg && $mpdc_posts_img == 'show-img') : ?>
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <div class="mgpd-card-img">
                                                        <?php the_post_thumbnail($mpdc_img_size, array('class' => 'card-img-top')); ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <?php if ($mpdc_cat) : ?>
                                                    <div class="mp-meta cat-list">
                                                        <?php mpd_one_cat(get_the_ID()); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if ($mpdc_stitle) : ?>
                                                    <h5 class="card-title mgpd-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                                <?php endif; ?>
                                                <?php if (!empty($mpdc_author) || !empty($mpdc_date) || !empty($mpdc_comment)) : ?>
                                                    <div class="mp-meta bottom-meta mb-2">
                                                        <?php
                                                        if ($mpdc_author) {
                                                            mp_display_posted_by();
                                                        }
                                                        if ($mpdc_date) {
                                                            echo '<i class="icon-mp-clock"></i> ';
                                                            echo esc_attr(get_the_date());
                                                        }
                                                        if ($mpdc_comment) {
                                                            mp_display_single_comment_icon();
                                                        }
                                                        ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if ($mpdc_sdesc) : ?>
                                                    <p class="card-text">
                                                        <?php
                                                        if (has_excerpt()) {
                                                            echo esc_html(wp_trim_words(get_the_excerpt(), 25, '...'));
                                                        } else {
                                                            echo esc_html(wp_trim_words(get_the_content(), 25, '...'));
                                                        }
                                                        ?>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if ($mpdc_show_btn) : ?>
                                                    <a href="<?php the_permalink(); ?>" class="btn btn-<?php echo esc_attr($mpdc_btn); ?> mgpd-btn"><?php echo esc_html($mpdc_btn_text); ?></a>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ($tags_list && $mpdc_tag) : ?>
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

                                wp_reset_postdata();
                            else :
                                ?>
                                <div class="mp-error text-center pb-5 pt-5">
                                    <?php esc_html_e('No post found!', 'magical-posts-display'); ?>
                                </div>
                            <?php

                            endif; ?>
                        </div>
                        <?php if ($mpdc_dots) : ?>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination pagination-mgpc<?php echo esc_attr($rand_num); ?>"></div>
                        <?php endif; ?>
                        <?php if ($mpdc_nav) : ?>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev sbp<?php echo esc_attr($rand_num); ?>"></div>
                            <div class="swiper-button-next sbn<?php echo esc_attr($rand_num); ?>"></div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            <script>
                var swiper = new Swiper('.mgpsac<?php echo esc_attr($rand_num); ?>', {
                    <?php if ($mpdc_autoheight) : ?>
                        autoHeight: true,
                    <?php endif; ?>
                    effect: 'slide',
                    grabCursor: <?php if ($mpdc_grabcursor) : ?>true<?php else : ?>false<?php endif; ?>,
                    <?php if ($mpdc_autoplay) : ?>
                        autoplay: {
                            delay: <?php echo esc_attr($mpdc_delay); ?>,
                        },
                    <?php endif; ?>
                    slidesPerView: <?php echo esc_attr($mpdc_items_big); ?>,
                    <?php if ($mpdc_space_big) : ?>
                        spaceBetween: <?php echo esc_attr($mpdc_space_big); ?>,
                    <?php endif; ?>
                    <?php if ($mpdc_loop) : ?>
                        loop: true,
                    <?php endif; ?>
                    breakpoints: {
                        320: {
                            slidesPerView: <?php echo esc_attr($mpdc_items_small); ?>,
                            <?php if ($mpdc_space_small) : ?>
                                spaceBetween: <?php echo esc_attr($mpdc_space_small); ?>
                            <?php endif; ?>
                        },
                        480: {
                            slidesPerView: <?php echo esc_attr($mpdc_items_medium); ?>,
                            <?php if ($mpdc_space_medium) : ?>
                                spaceBetween: <?php echo esc_attr($mpdc_space_medium); ?>
                            <?php endif; ?>
                        },
                        640: {
                            slidesPerView: <?php echo esc_attr($mpdc_items_big); ?>,
                            <?php if ($mpdc_space_big) : ?>
                                spaceBetween: <?php echo esc_attr($mpdc_space_big); ?>
                            <?php endif; ?>
                        }
                    },
                    <?php if ($mpdc_dots) : ?>
                        pagination: {
                            el: '.pagination-mgpc<?php echo esc_attr($rand_num); ?>',
                            clickable: true,
                            // type: 'progressbar',
                        },
                    <?php endif; ?>
                    <?php if ($mpdc_nav) : ?>
                        navigation: {
                            nextEl: '.sbn<?php echo esc_attr($rand_num); ?>',
                            prevEl: '.sbp<?php echo esc_attr($rand_num); ?>',
                        },
                    <?php endif; ?>
                });
            </script>


<?php
            });
    }
}

new mgdPostCarousel();
