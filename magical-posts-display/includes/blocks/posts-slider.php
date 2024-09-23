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
class mgdPostsSlider
{

    function __construct()
    {
        add_action('carbon_fields_register_fields', [$this, 'mgpd_slider']);
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


    function mgpd_slider()
    {

        Block::make(__('Magical Posts Slider', 'magical-posts-display'))
            ->set_category('magical-posts-display', __('Magical Posts', 'magical-posts-display'), 'welcome-widgets-menus')
            ->set_icon('slides')
            ->set_keywords([__('Slider', 'magical-posts-display'), __('slide', 'magical-posts-display'), __('post', 'magical-posts-display')])
            ->set_mode('edit')
            ->add_tab(__('Slider Items'), array(
                Field::make('separator', 'mpdsl_post_query', __('Post Query', 'magical-posts-display')),
                Field::make('select', 'mpdsl_posts_show', __('Show Posts by', 'magical-posts-display'))
                    ->set_options(array(
                        'DSC' => __('Latest Posts', 'magical-posts-display'),
                        'ASC' => __('Oldest Posts', 'magical-posts-display'),
                        'rand' => __('Random Posts', 'magical-posts-display'),
                    ))
                    ->set_default_value('DSC'),
                Field::make('select', 'mpdsl_posts_cat', __('Select Category', 'magical-posts-display'))
                    ->set_options(array($this, 'mgpd_cat_list'))
                    ->set_default_value('all'),
                Field::make('text', 'mpdsl_posts_number', __('Posts number', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(5),

                Field::make('separator', 'mpdsl_post_img', __('Posts image', 'magical-posts-display')),
                Field::make('select', 'mpdsl_img_size', __('Image size', 'magical-posts-display'))
                    ->set_options(array(
                        'slider-bg' => __('Slider size (1600*600)', 'magical-posts-display'),
                        'medium_large' => __('Medium large (768*0)', 'magical-posts-display'),
                        'large' => __('Large ( 1024*1024)', 'magical-posts-display'),
                        'full' => __('Orginal size', 'magical-posts-display'),
                    ))
                    ->set_default_value('slider-bg'),

                Field::make('separator', 'mpdsl_post_content', __('Post Content', 'magical-posts-display')),
                Field::make('select', 'mpdsl_text_align', __('Text align', 'magical-posts-display'))
                    ->set_options(array(
                        'left' => __('Text Align Left', 'magical-posts-display'),
                        'center' => __('Text Align Center', 'magical-posts-display'),
                        'right' => __('Text Align Right', 'magical-posts-display'),
                    ))
                    ->set_default_value('center'),
                Field::make('checkbox', 'mpdsl_cat', __('Show Category', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdsl_title', __('Show Title', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdsl_desc', __('Show Description', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdsl_show_btn', 'Show Button')
                    ->set_default_value('yes'),
                Field::make('text', 'mpdsl_btn_text', __('Button Text', 'magical-posts-display'))
                    ->set_default_value(__('Read More', 'magical-posts-display')),
            ))

            ->add_tab(__('Slider Options'), array(
                Field::make('separator', 'mpdsl_sep_options', __('Slider options', 'magical-posts-display')),
                Field::make('text', 'mpdsl_height', __('Slider Height', 'magical-posts-display'))->set_help_text(__('Enter Slider Height'))
                    ->set_attribute('type', 'number')->set_default_value('500'),
                Field::make('checkbox', 'mpdsl_autoplay', __('autoplay', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('text', 'mpdsl_delay', __('Autoplay delay time', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(3000),
                Field::make('checkbox', 'mpdsl_loop', __('Loop', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdsl_autoheight', __('Auto Height', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdsl_grabcursor', __('Grab Cursor', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdsl_nav', __('Show Nav', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdsl_dots', __('Show Dots', 'magical-posts-display')),

            ))

            ->add_tab(__('Slider Style'), array(
                Field::make('separator', 'mpdsl_sep_content', __('Content Style', 'magical-posts-display')),

                Field::make('text', 'mpdsl_conttop_padding', __('Content Top Padding', 'magical-posts-display'))->set_help_text(__('Enter content top padding. padding set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('checkbox', 'mpdsl_overlay', __('Show Slider Overlay', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('color', 'mpdsl_overlay_color', __('Overlay color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('text', 'mpdsl_overlay_opacity', __('Overlay Opacity', 'magical-posts-display'))->set_help_text(__('Enter 0.01 to 0.99 for set opacity. '))
                    ->set_attribute('type', 'number')->set_default_value('0.5'),

                Field::make('separator', 'mpdsl_sep_meta', __('Category Style', 'magical-posts-display')),

                Field::make('text', 'mpdsl_meta_size', __('Category size', 'magical-posts-display'))->set_help_text(__('Set Category size. Category size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdsl_cat_margin', __('Category bottom space', 'magical-posts-display'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdsl_meta_color', __('Category color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdsl_sep_title', __('Title Style', 'magical-posts-display')),
                Field::make('text', 'mpdsl_title_size', __('Title font size', 'magical-posts-display'))->set_help_text(__('Tyepe number for icon size. Icon size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdsl_title_margin', __('Title bottom space', 'magical-posts-display'))->set_help_text(__('Tyepe number icon margin. Icon margin set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdsl_title_color', __('Title color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdsl_sep_desc', __('Description Style', 'magical-posts-display')),

                Field::make('text', 'mpdsl_desc_size', __('Description size', 'magical-posts-display'))->set_help_text(__('Tyepe number for icon size. Icon size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdsl_desc_margin', __('Description bottom space', 'magical-posts-display'))->set_help_text(__('Description bottom margin. Margin set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdsl_desc_color', __('Description color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),


                Field::make('separator', 'mpdsl_sep_btn', __('Button style', 'magical-posts-display')),
                Field::make('select', 'mpdsl_btn', __('Select button', 'magical-posts-display'))
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
                    ->set_default_value('success'),
                Field::make('separator', 'mpdsl_sep_navdot', __('Navs & Dots style', 'magical-posts-display')),
                Field::make('checkbox', 'mpdsl_navhover', __('Nav Only Show Hover', 'magical-posts-display')),
                Field::make('color', 'mpdsl_nav_color', __('Navs color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdsl_nav_bgcolor', __('Navs Background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdsl_dots_color', __('Dots color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdsl_dots_bgcolor', __('Active Dots color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

            ))



            ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                $rand_num = wp_rand(798548, 325894);
                $mpdsl_posts_show = isset($fields['mpdsl_posts_show']) ? $fields['mpdsl_posts_show'] : 'DSC';
                $mpdsl_posts_cat = isset($fields['mpdsl_posts_cat']) ? $fields['mpdsl_posts_cat'] : 'all';
                $mpdsl_posts_number = isset($fields['mpdsl_posts_number']) ? $fields['mpdsl_posts_number'] : '5';
                $mpdsl_img_size = isset($fields['mpdsl_img_size']) ? $fields['mpdsl_img_size'] : 'medium';

                $mpdsl_text_align = isset($fields['mpdsl_text_align']) ? $fields['mpdsl_text_align'] : 'center';
                $mpdsl_cat = isset($fields['mpdsl_cat']) ? $fields['mpdsl_cat'] : 'yes';
                $mpdsl_title = isset($fields['mpdsl_title']) ? $fields['mpdsl_title'] : 'yes';
                $mpdsl_desc = isset($fields['mpdsl_desc']) ? $fields['mpdsl_desc'] : 'yes';
                $mpdsl_show_btn = isset($fields['mpdsl_show_btn']) ? $fields['mpdsl_show_btn'] : 'yes';
                $mpdsl_btn_text = isset($fields['mpdsl_btn_text']) ? $fields['mpdsl_btn_text'] : __('Read More', 'magical-posts-display');

                // all carousel options
                $mpdsl_height = isset($fields['mpdsl_height']) ? $fields['mpdsl_height'] : '500';
                $mpdsl_autoplay = isset($fields['mpdsl_autoplay']) ? $fields['mpdsl_autoplay'] : 'yes';
                $mpdsl_delay = isset($fields['mpdsl_delay']) ? $fields['mpdsl_delay'] : '3000';
                $mpdsl_loop = isset($fields['mpdsl_loop']) ? $fields['mpdsl_loop'] : 'yes';
                $mpdsl_autoheight = isset($fields['mpdsl_autoheight']) ? $fields['mpdsl_autoheight'] : 'yes';
                $mpdsl_grabcursor = isset($fields['mpdsl_grabcursor']) ? $fields['mpdsl_grabcursor'] : 'yes';
                $mpdsl_nav = isset($fields['mpdsl_nav']) ? $fields['mpdsl_nav'] : '';
                $mpdsl_dots = isset($fields['mpdsl_dots']) ? $fields['mpdsl_dots'] : 'yes';


                // all style options
                $mpdsl_conttop_padding = isset($fields['mpdsl_conttop_padding']) ? $fields['mpdsl_conttop_padding'] : 'mgpdc2';
                $mpdsl_overlay = isset($fields['mpdsl_overlay']) ? $fields['mpdsl_overlay'] : 'yes';
                $mpdsl_overlay_color = isset($fields['mpdsl_overlay_color']) ? $fields['mpdsl_overlay_color'] : '';
                $mpdsl_overlay_opacity = isset($fields['mpdsl_overlay_opacity']) ? $fields['mpdsl_overlay_opacity'] : '';
                $mpdsl_title_size = isset($fields['mpdsl_title_size']) ? $fields['mpdsl_title_size'] : '';
                $mpdsl_title_margin = isset($fields['mpdsl_title_margin']) ? $fields['mpdsl_title_margin'] : '';
                $mpdsl_title_color = isset($fields['mpdsl_title_color']) ? $fields['mpdsl_title_color'] : '';

                $mpdsl_desc_size = isset($fields['mpdsl_desc_size']) ? $fields['mpdsl_desc_size'] : '';
                $mpdsl_desc_margin = isset($fields['mpdsl_desc_margin']) ? $fields['mpdsl_desc_margin'] : '';
                $mpdsl_desc_color = isset($fields['mpdsl_desc_color']) ? $fields['mpdsl_desc_color'] : '';
                $mpdsl_meta_size = isset($fields['mpdsl_meta_size']) ? $fields['mpdsl_meta_size'] : '';
                $mpdsl_cat_margin = isset($fields['mpdsl_cat_margin']) ? $fields['mpdsl_cat_margin'] : '';
                $mpdsl_meta_color = isset($fields['mpdsl_meta_color']) ? $fields['mpdsl_meta_color'] : '';
                $mpdsl_btn = isset($fields['mpdsl_btn']) ? $fields['mpdsl_btn'] : 'success';
                $mpdsl_navhover = isset($fields['mpdsl_navhover']) ? $fields['mpdsl_navhover'] : '';
                $mpdsl_nav_color = isset($fields['mpdsl_nav_color']) ? $fields['mpdsl_nav_color'] : '';
                $mpdsl_nav_bgcolor = isset($fields['mpdsl_nav_bgcolor']) ? $fields['mpdsl_nav_bgcolor'] : '';
                $mpdsl_dots_color = isset($fields['mpdsl_dots_color']) ? $fields['mpdsl_dots_color'] : '';
                $mpdsl_dots_bgcolor = isset($fields['mpdsl_dots_bgcolor']) ? $fields['mpdsl_dots_bgcolor'] : '';


?>
            <div class="mgps mgp-slider mgps<?php echo esc_attr($rand_num); ?> <?php if ($mpdsl_navhover) : ?>mgpdc2<?php endif; ?>">
                <style type="text/css">
                    <?php
                    mpd_get_style_item(
                        '.mgps.mgp-slider.mgps' . esc_attr($rand_num) . '  .mgps-item',
                        array(
                            'height' => $mpdsl_height,
                        )
                    );
                    mpd_get_style_item(
                        '.mgp-slider.mgps' . esc_attr($rand_num) . ' .mgps-item img',
                        array(
                            'min-height' => $mpdsl_height,
                        )
                    );
                    mpd_get_style_item(
                        '.mgp-slider.mgps' . esc_attr($rand_num) . ' .mgps-text',
                        array(
                            'padding-top' => $mpdsl_conttop_padding,
                        )
                    );
                    if ($mpdsl_overlay) {
                        mpd_get_style_item(
                            '.mgp-slider.mgps' . esc_attr($rand_num) . ' .mgps-item:before',
                            array(
                                'opacity' => $mpdsl_overlay_opacity,
                                'background' => $mpdsl_overlay_color,
                            )
                        );
                    } else {
                        mpd_get_style_item(
                            '.mgp-slider.mgps' . esc_attr($rand_num) . ' .mgps-item:before',
                            array(
                                'content' => 'inherit',
                            )
                        );
                    }
                    mpd_get_style_item(
                        '.mgp-slider.mgps' . esc_attr($rand_num) . ' .mgps-text h1.mgps-title',
                        array(
                            'font-size' => $mpdsl_title_size,
                            'margin-bottom' => $mpdsl_title_margin,
                            'color' => $mpdsl_title_color,
                        )
                    );
                    mpd_get_style_item(
                        '.mgp-slider.mgps' . esc_attr($rand_num) . ' .mgps-text p.mgps-desc',
                        array(
                            'font-size' => $mpdsl_desc_size,
                            'margin-bottom' => $mpdsl_desc_margin,
                            'color' => $mpdsl_desc_color,
                        )
                    );
                    mpd_get_style_item(
                        '.mgp-slider.mgps' . esc_attr($rand_num) . ' .mp-meta a,.mgp-slider.mgps' . esc_attr($rand_num) . ' .mp-meta i',
                        array(
                            'font-size' => $mpdsl_meta_size,
                            'margin-bottom' => $mpdsl_cat_margin,
                            'color' => $mpdsl_meta_color,
                        )
                    );
                    mpd_get_style_item(
                        '.mgp-slider.mgps' . esc_attr($rand_num) . ' .swiper-button-next,.mgp-slider.mgps' . esc_attr($rand_num) . ' .swiper-button-prev',
                        array(
                            'background-color' => $mpdsl_nav_bgcolor,
                        )
                    );
                    mpd_get_style_item(
                        '.mgp-slider.mgps' . esc_attr($rand_num) . ' .swiper-button-next:after,.mgp-slider.mgps' . esc_attr($rand_num) . ' .swiper-button-prev:after',
                        array(
                            'color' => $mpdsl_nav_color,
                        ),
                        1
                    );
                    mpd_get_style_item(
                        '.mgp-slider.mgps' . esc_attr($rand_num) . ' .swiper-pagination-bullet',
                        array(
                            'background-color' => $mpdsl_dots_color,
                            'opacity' => 1,
                        ),
                        1
                    );
                    mpd_get_style_item(
                        '.mgp-slider.mgps' . esc_attr($rand_num) . ' .swiper-pagination-bullet-active',
                        array(
                            'background-color' => $mpdsl_dots_bgcolor,
                        ),
                        1
                    );


                    ?>
                </style>




                <div class="swiper-container mgpc<?php echo esc_attr($rand_num); ?>">
                    <div class="mgpsac<?php echo esc_attr($rand_num); ?>">
                        <div class="swiper-wrapper">
                            <?php


                            if ($mpdsl_posts_cat != 'all') {
                                $terms = array(
                                    array(
                                        'taxonomy'  => 'category',
                                        'field'  => 'slug',
                                        'terms'  => $mpdsl_posts_cat
                                    )
                                );
                            } else {
                                $terms = '';
                            }



                            $mp_args = array(
                                'post_type'         =>  'post',
                                'post_status'       =>  'publish',
                                'posts_per_page'    => $mpdsl_posts_number,
                                'tax_query'         =>  $terms,
                                'ignore_sticky_posts' => 1
                            );
                            if ($mpdsl_posts_show == 'rand') {
                                $mp_args['orderby'] = 'rand';
                            } else {
                                $mp_args['order'] = $mpdsl_posts_show;
                            }



                            $mp_loop = new WP_Query($mp_args);
                            if ($mp_loop->have_posts()) :
                                while ($mp_loop->have_posts()) :  $mp_loop->the_post();
                                    $post_thumb_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
                                    //tag list
                                    $tags_list = get_the_tag_list();
                            ?>
                                    <div class="swiper-slide">
                                        <div class="mgps-item">
                                            <div class="mgps-img">
                                                <?php
                                                if (has_post_thumbnail()) {
                                                    the_post_thumbnail($mpdsl_img_size, array('class' => 'mgps-image'));
                                                } else {
                                                    echo '<img class="mgps-image" src="' . esc_url(MAGICAL_POSTS_DISPLAY_ASSETS . 'img/blue.svg') . '" alt="' . esc_attr('default slider image', 'magical-posts-display') . '">';
                                                }

                                                ?>
                                            </div>
                                            <?php if ($mpdsl_cat || $mpdsl_title || $mpdsl_desc || $mpdsl_show_btn) : ?>
                                                <div class="mgps-text text-<?php echo esc_attr($mpdsl_text_align); ?>">
                                                    <div class="mgps-container">
                                                        <?php if ($mpdsl_cat) : ?>
                                                            <div class="mp-meta cat-list">
                                                                <?php mpd_one_cat(get_the_ID()); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if ($mpdsl_title) : ?>
                                                            <h1 class="mgps-title" data-swiper-parallax="-100"><?php echo esc_html(wp_trim_words(get_the_title(), 10, ' ')); ?></h1>
                                                        <?php endif; ?>
                                                        <?php if ($mpdsl_desc) : ?>
                                                            <p class="mgps-desc" data-swiper-parallax="-200">
                                                                <?php
                                                                if (has_excerpt()) {
                                                                    echo esc_html(wp_trim_words(get_the_excerpt(), 50, '...'));
                                                                } else {
                                                                    echo esc_html(wp_trim_words(get_the_content(), 50, '...'));
                                                                }
                                                                ?>
                                                            </p>
                                                        <?php endif; ?>
                                                        <?php if ($mpdsl_show_btn) : ?>
                                                            <a data-swiper-parallax="-600" href="<?php the_permalink(); ?>" class="btn btn-<?php echo esc_attr($mpdsl_btn); ?> mgps-btn"><?php echo esc_html($mpdsl_btn_text); ?></a>
                                                        <?php endif; ?>
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
                        <?php if ($mpdsl_dots) : ?>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination pagination-mgpc<?php echo esc_attr($rand_num); ?>"></div>
                        <?php endif; ?>
                        <?php if ($mpdsl_nav) : ?>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev sbp<?php echo esc_attr($rand_num); ?>"></div>
                            <div class="swiper-button-next sbn<?php echo esc_attr($rand_num); ?>"></div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            <script>
                var swiper = new Swiper('.mgpsac<?php echo esc_attr($rand_num); ?>', {
                    <?php if ($mpdsl_autoheight) : ?>
                        autoHeight: true,
                    <?php endif; ?>
                    effect: 'fade',
                    grabCursor: <?php echo $mpdsl_grabcursor ? 'true' : 'false'; ?>,
                    <?php if ($mpdsl_autoplay) : ?>
                        autoplay: {
                            delay: <?php echo esc_attr($mpdsl_delay); ?>,
                        },
                    <?php endif; ?>
                    slidesPerView: 1,
                    parallax: true,
                    spaceBetween: 30,
                    <?php if ($mpdsl_loop) : ?>
                        loop: true,
                    <?php endif; ?>
                    <?php if ($mpdsl_dots) : ?>
                        pagination: {
                            el: '.pagination-mgpc<?php echo esc_attr($rand_num); ?>',
                            clickable: true,
                            // type: 'progressbar',
                        },
                    <?php endif; ?>
                    <?php if ($mpdsl_nav) : ?>
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

new mgdPostsSlider();
