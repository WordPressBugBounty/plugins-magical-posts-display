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
class mgdPostTicker
{

    function __construct()
    {
        add_action('carbon_fields_register_fields', [$this, 'mgpd_ticker']);
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


    function mgpd_ticker()
    {

        Block::make(__('Magical Posts Ticker', 'magical-posts-display'))
            ->set_category('magical-posts-display', __('Magical Posts', 'magical-posts-display'), 'welcome-widgets-menus')
            ->set_icon('controls-repeat')
            ->set_keywords([__('ticker', 'magical-posts-display'), __('slider', 'magical-posts-display'), __('news', 'magical-posts-display')])
            ->set_mode('edit')
            ->add_tab(__('Ticker Items'), array(
                Field::make('separator', 'mpdc_post_content', __('Post ticker content', 'magical-posts-display')),
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
                    ->set_attribute('type', 'number')->set_default_value(10),
                Field::make('text', 'mpdc_ticker_text', __('Ticker Header Text', 'magical-posts-display'))
                    ->set_default_value(__('Latest News', 'magical-posts-display')),

                Field::make('checkbox', 'mpdc_show_link', 'Add link')
                    ->set_default_value('yes'),
                Field::make('select', 'mpdc_link_terget', __('Link Terget', 'magical-posts-display'))
                    ->set_options(array(
                        '_self' => __('Self Window', 'magical-posts-display'),
                        '_blank' => __('Blank Window', 'magical-posts-display'),
                    ))
                    ->set_default_value('_self'),

            ))

            ->add_tab(__('Ticker Options'), array(
                Field::make('separator', 'mpdc_sep_options', __('Ticker options', 'magical-posts-display')),
                Field::make('checkbox', 'mpdc_mousepause', __('Mouse Pause', 'magical-posts-display'))
                    ->set_default_value('yes'),
                Field::make('select', 'mpdc_direction', __('Ticker direction', 'magical-posts-display'))
                    ->set_options(array(
                        'up' => __('Up', 'magical-posts-display'),
                        'down' => __('Down', 'magical-posts-display'),
                    ))
                    ->set_default_value('up'),
                Field::make('select', 'mpdc_ticker_position', __('Text Position', 'magical-posts-display'))
                    ->set_options(array(
                        'left' => __('Left', 'magical-posts-display'),
                        'right' => __('Right', 'magical-posts-display'),
                    ))
                    ->set_default_value('left'),
                /*Field::make( 'text', 'mpdc_delay',__( 'Autoplay delay time','magical-posts-display' ) )
        ->set_attribute( 'type', 'number' )->set_default_value(3000),*/


            ))

            ->add_tab(__('Ticker Style'), array(
                Field::make('separator', 'mpdc_sep_header', __('Ticker Header Style', 'magical-posts-display')),
                Field::make('text', 'mpdc_header_size', __('Header font size', 'magical-posts-display'))->set_help_text(__('Type number for font size. Font size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdc_header_width', __('Header Width', 'magical-posts-display'))->set_help_text(__('Type number for header width.'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdc_header_padding', __('Header padding top', 'magical-posts-display'))->set_help_text(__('Type number for header top padding.'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdc_header_bgcolor', __('Header background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdc_header_color', __('Header text color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdc_sep_text', __('Ticker text style', 'magical-posts-display')),
                Field::make('text', 'mpdc_text_size', __('Text Font size', 'magical-posts-display'))->set_help_text(__('Type number for font size. Font size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdc_text_color', __('Text color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdc_text_bgcolor', __('Text background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdc_border_color', __('Ticker Border color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdc_sep_extra', __('Extra style', 'magical-posts-display')),
                Field::make('checkbox', 'mpdc_border_show', 'Show Border')
                    ->set_default_value('yes'),
                Field::make('checkbox', 'mpdc_border_shadow', 'Show Shadow')
                    ->set_default_value('yes'),



            ))



            ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                $rand_num = wp_rand(798548, 325894);
                $mpdc_posts_show = isset($fields['mpdc_posts_show']) ? $fields['mpdc_posts_show'] : 'DSC';
                $mpdc_posts_cat = isset($fields['mpdc_posts_cat']) ? $fields['mpdc_posts_cat'] : 'all';
                $mpdc_posts_number = isset($fields['mpdc_posts_number']) ? $fields['mpdc_posts_number'] : '10';
                $mpdc_img_size = isset($fields['mpdc_img_size']) ? $fields['mpdc_img_size'] : 'medium';
                $mpdc_ticker_text = isset($fields['mpdc_ticker_text']) ? $fields['mpdc_ticker_text'] : __('Latest News', 'magical-posts-display');
                $mpdc_show_link = isset($fields['mpdc_show_link']) ? $fields['mpdc_show_link'] : 'yes';
                $mpdc_link_terget = isset($fields['mpdc_link_terget']) ? $fields['mpdc_link_terget'] : '_self';

                // all carousel options
                $mpdc_mousepause = isset($fields['mpdc_mousepause']) ? $fields['mpdc_mousepause'] : 'yes';
                $mpdc_direction = isset($fields['mpdc_direction']) ? $fields['mpdc_direction'] : 'up';
                $mpdc_ticker_position = isset($fields['mpdc_ticker_position']) ? $fields['mpdc_ticker_position'] : 'left';

                $mpdc_sdesc = isset($fields['mpdc_sdesc']) ? $fields['mpdc_sdesc'] : '';

                // all style options
                $mpdc_header_size = isset($fields['mpdc_header_size']) ? $fields['mpdc_header_size'] : '';
                $mpdc_header_width = isset($fields['mpdc_header_width']) ? $fields['mpdc_header_width'] : '';
                $mpdc_header_padding = isset($fields['mpdc_header_padding']) ? $fields['mpdc_header_padding'] : '';
                $mpdc_header_bgcolor = isset($fields['mpdc_header_bgcolor']) ? $fields['mpdc_header_bgcolor'] : '';
                $mpdc_header_color = isset($fields['mpdc_header_color']) ? $fields['mpdc_header_color'] : '';
                $mpdc_text_size = isset($fields['mpdc_text_size']) ? $fields['mpdc_text_size'] : '';
                $mpdc_text_color = isset($fields['mpdc_text_color']) ? $fields['mpdc_text_color'] : '';
                $mpdc_text_bgcolor = isset($fields['mpdc_text_bgcolor']) ? $fields['mpdc_text_bgcolor'] : '';
                $mpdc_border_color = isset($fields['mpdc_border_color']) ? $fields['mpdc_border_color'] : '';
                $mpdc_border_show = isset($fields['mpdc_border_show']) ? $fields['mpdc_border_show'] : 'yes';
                $mpdc_border_shadow = isset($fields['mpdc_border_shadow']) ? $fields['mpdc_border_shadow'] : 'yes';



?>
            <div class="mgpd mgpticker mgticker<?php echo esc_attr($rand_num); ?> mgpd-<?php echo esc_attr($mpdc_ticker_position); ?>">
                <style type="text/css">
                    <?php
                    mpd_get_style_item(
                        '.mgpticker.mgticker' . esc_attr($rand_num) . ' .mgpticker-text',
                        array(
                            'font-size' => $mpdc_header_size,
                            'width' => $mpdc_header_width,
                            'background-color' => $mpdc_header_bgcolor,
                            'padding-top' => $mpdc_header_padding,
                            'color' => $mpdc_header_color,
                        )
                    );
                    if ($mpdc_ticker_position == 'left') {
                        mpd_get_style_item(
                            '.mgpd-sticker.mgpticker' . esc_attr($rand_num) . ' ul',
                            array(
                                'padding-left' => $mpdc_header_width,
                            )
                        );
                    } else {
                        mpd_get_style_item(
                            '.mgpd.mgticker' . esc_attr($rand_num) . '.mgpd-right ul',
                            array(
                                'padding-right' => $mpdc_header_width,
                            )
                        );
                    }


                    mpd_get_style_item(
                        '.mgpticker.mgticker' . esc_attr($rand_num),
                        array(
                            'border-color' => $mpdc_border_color,
                            'background-color' => $mpdc_text_bgcolor,
                        )
                    );
                    mpd_get_style_item(
                        '.mgpticker.mgticker' . esc_attr($rand_num) . ' ul li',
                        array(
                            'font-size' => $mpdc_text_size,
                            'background-color' => $mpdc_text_bgcolor,
                            'color' => $mpdc_text_color,
                        )
                    );
                    if ($mpdc_show_link) {
                        mpd_get_style_item(
                            '.mgpticker.mgticker' . esc_attr($rand_num) . ' ul li a',
                            array(
                                'color' => $mpdc_text_color,
                            )
                        );
                    }
                    if (empty($mpdc_border_show)) {
                        mpd_get_style_item(
                            '.mgpticker.mgticker' . esc_attr($rand_num),
                            array(
                                'border' => 'none',
                            )
                        );
                    }
                    if (empty($mpdc_border_shadow)) {
                        mpd_get_style_item(
                            '.mgpticker.mgticker' . esc_attr($rand_num),
                            array(
                                'box-shadow' => 'inherit',
                            )
                        );
                    }


                    ?>
                </style>
                <span class="mgpticker-text"><?php echo esc_html($mpdc_ticker_text); ?></span>
                <div class="mgpd-ticker mgpd-sticker mgpticker<?php echo esc_attr($rand_num); ?>">
                    <ul>
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



                        $mpdt_args = array(
                            'post_type'         =>  'post',
                            'post_status'       =>  'publish',
                            'posts_per_page'    => $mpdc_posts_number,
                            'tax_query'         =>  $terms,
                            'ignore_sticky_posts' => 1
                        );
                        if ($mpdc_posts_show == 'rand') {
                            $mpdt_args['orderby'] = 'rand';
                        } else {
                            $mpdt_args['order'] = $mpdc_posts_show;
                        }



                        $mpdt_loop = new WP_Query($mpdt_args);
                        if ($mpdt_loop->have_posts()) :
                            while ($mpdt_loop->have_posts()) :  $mpdt_loop->the_post();
                        ?>
                                <?php if ($mpdc_show_link) : ?>
                                    <li><a href="<?php the_permalink(); ?>" target="<?php echo esc_attr($mpdc_link_terget); ?>"><?php the_title(); ?></a></li>
                                <?php else : ?>
                                    <li><?php the_title(); ?></li>
                                <?php endif; ?>

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
                    </ul>
                </div>
            </div>
            <script>
                ;
                (function($) {
                    "use strict";
                    jQuery(document).ready(function($) {
                        $('.mgpticker<?php echo esc_attr($rand_num); ?>').easyTicker({
                            direction: '<?php echo esc_attr($mpdc_direction); ?>',
                            easing: 'swing',
                            speed: 'slow',
                            interval: 2000,
                            visible: 1,
                            mousePause: <?php if ($mpdc_mousepause) : ?>true<?php else : ?>false<?php endif; ?>,
                            height: 'auto',
                        });

                    });

                }(jQuery));
            </script>


<?php
            });
    }
}

new mgdPostTicker();
