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
class postsAccordion
{

    function __construct()
    {
        add_action('carbon_fields_register_fields', [$this, 'mgpd_accordion']);
    }

    function mgpd_posts_list()
    {
        // $mgposts[] = '';
        $mgposts[] = __('Select post', 'magical-posts-display');

        $post_list = get_posts(array(
            'numberposts'    => -1,
        ));
        if (!empty($post_list) && !is_wp_error($post_list)) {
            foreach ($post_list as $list) {
                $mgposts[$list->ID] = $list->post_title;
            }
        }
        return $mgposts;
    }


    function mgpd_accordion()
    {
        $accordion_labels = array(
            'plural_name' => __('Accordion Items', 'magical-posts-display'),
            'singular_name' => __('Accordion Item', 'magical-posts-display'),
        );
        Block::make(__('Magical posts Accordion', 'magical-posts-display'))
            ->set_category('magical-posts-display', __('Magical Block', 'magical-posts-display'), 'welcome-view-site')
            ->set_icon('analytics')
            ->set_keywords([__('accordion', 'magical-posts-display'), __('tab', 'magical-posts-display'), __('content', 'magical-posts-display')])
            ->set_mode('both')

            ->add_tab(__('Add Accordion'), array(
                Field::make('complex', 'mpdac_accordions', __('Accordion', 'magical-posts-display'))
                    ->setup_labels($accordion_labels)
                    ->add_fields(array(
                        Field::make('select', 'mpdac_posts_id', __('Select post', 'magical-posts-display'))
                            ->set_options(array($this, 'mgpd_posts_list')),
                    ))
            ))
            ->add_tab(__('Accordion Settings'), array(
                Field::make('separator', 'mpdac_sep_title', __('Title settings', 'magical-posts-display')),
                Field::make('color', 'mpdac_title_color', __('Title color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
                Field::make('color', 'mpdac_title_bgcolor', __('Title background color', 'magical-posts-display')),
                Field::make('select', 'mpdac_title_tag', __('Select title tag', 'magical-posts-display'))
                    ->set_options(array(
                        'h1' => 'h1',
                        'h2' => 'h2',
                        'h3' => 'h3',
                        'h4' => 'h4',
                        'h5' => 'h5',
                        'h6' => 'h6',
                        'p' => 'p',
                    ))
                    ->set_default_value('h3'),
                Field::make('select', 'mpdac_title_align', __('Title Position'))
                    ->set_options(array(
                        'left' => __('Left', 'magical-posts-display'),
                        'center' => __('Center', 'magical-posts-display'),
                        'right' => __('Right', 'magical-posts-display'),

                    ))
                    ->set_default_value('left'),
                Field::make('separator', 'mpdac_sep_content', __('Content settings', 'magical-posts-display')),
                Field::make('color', 'mpdac_content_color', __('Content color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
                Field::make('color', 'mpdac_content_bgcolor', __('Content background color', 'magical-posts-display')),

                Field::make('color', 'mpdac_link_color', __('Link color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),


            ))



            ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                $rand_num = wp_rand(558732, 665284);

                $mpdac_accordions = mpd_get_option($fields['mpdac_accordions']);
                $mpdac_title_color = mpd_get_option($fields['mpdac_title_color']);
                $mpdac_title_bgcolor = mpd_get_option($fields['mpdac_title_bgcolor']);
                $mpdac_title_tag = mpd_get_option($fields['mpdac_title_tag']);
                $mpdac_title_align = mpd_get_option($fields['mpdac_title_align']);
                $mpdac_content_color = mpd_get_option($fields['mpdac_content_color']);
                $mpdac_content_bgcolor = mpd_get_option($fields['mpdac_content_bgcolor']);
                $mpdac_link_color = mpd_get_option($fields['mpdac_link_color']);


?>


            <div class="accordion mgba-accordion mgpac<?php echo esc_attr($rand_num); ?> mgba-style1 mb-4 mt-4" id="mgpac<?php echo esc_attr($rand_num); ?>" role="tablist" aria-multiselectable="true">
                <style type="text/css">
                    <?php
                    mpd_get_style_item(
                        '.mgpac' . esc_attr($rand_num) . ' .mgbaccordion-head',
                        array(
                            'background-color' => $mpdac_title_bgcolor
                        )
                    );
                    mpd_get_style_item(
                        '.mgpac' . esc_attr($rand_num) . ' .mgbaccordion-head .mgbaccordion-title,.mgpac' . esc_attr($rand_num) . ' .mgbaccordion-head .mgbaccordion-icon',
                        array(
                            'color' => $mpdac_title_color,
                        )
                    );
                    mpd_get_style_item(
                        '.mgpac' . esc_attr($rand_num) . ' .card-body.mgba-content',
                        array(
                            'color' => $mpdac_content_color,
                            'background-color' => $mpdac_content_bgcolor,
                        )
                    );
                    mpd_get_style_item(
                        '.mgpac' . esc_attr($rand_num) . ' .card-body.mgba-content a',
                        array(
                            'color' => $mpdac_link_color,
                        ),
                        true
                    );

                    ?>
                </style>

                <!-- Accordion card -->
                <?php

                $mpda_id = [];

                if (!empty($mpdac_accordions)) {
                    foreach ($mpdac_accordions as $mpdac_pid) {
                        $mpda_id[] = $mpdac_pid['mpdac_posts_id'];
                    }
                }

                $args = array(
                    'post_type' => 'post',
                    'post_status'       =>  'publish',
                    'post__in'      => $mpda_id,
                    'ignore_sticky_posts' => 1,
                    'orderby'        => 'post__in',
                    'order'          => 'ASC'

                );
                ?>
                <div class="accordion mgba-accordion mgacm<?php echo esc_attr($rand_num); ?> mgba-style1 mb-4 mt-4" id="mgacm<?php echo esc_attr($rand_num); ?>" role="tablist" aria-multiselectable="true">
                    <?php
                    if ($mpda_id) :
                        $count = 0;
                        $mpac_loop = new WP_Query($args);
                        while ($mpac_loop->have_posts()) :  $mpac_loop->the_post();
                            $count++;
                            if ($count == 1) {
                                $aria_ex = 'true';
                                $aria_show = 'show';
                            } else {
                                $aria_ex = 'false';
                                $aria_show = '';
                            }

                            if (has_excerpt()) {
                                $mgpdb_content = get_the_excerpt();
                            } else {
                                $mgpdb_content = get_the_content();
                            }

                    ?>
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header mgbaccordion-head z-depth-1 mb-1 p-0" role="tab" id="heading<?php echo esc_attr($rand_num . $count); ?>">
                                    <a class="mgbaccordion-title-link" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo esc_attr($rand_num . $count); ?>" href="#" aria-expanded="<?php echo esc_attr($aria_ex); ?>" aria-controls="collapse<?php echo esc_attr($rand_num . $count); ?>">
                                        <div class="row">
                                            <div class="col-lg-11 col-sm-10">
                                                <<?php echo esc_attr($fields['mpdac_title_tag']); ?> class="m-0 white-text text-uppercase mgbaccordion-title text-<?php echo esc_attr($fields['mpdac_title_align']); ?>">
                                                    <?php echo esc_html(wp_trim_words(get_the_title(), 20)); ?>
                                                </<?php echo esc_attr($fields['mpdac_title_tag']); ?>>
                                            </div>
                                            <div class="col-lg-1 col-sm-2 text-right mgbaccordion-icon">
                                                <i class="mba-up fas fa-chevron-up"></i>
                                                <i class="mba-down fas fa-chevron-down"></i>
                                            </div>
                                        </div>


                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapse<?php echo esc_attr($rand_num . $count); ?>" class="collapse <?php echo esc_attr($aria_show); ?>" role="tabpanel" aria-labelledby="heading<?php echo esc_attr($rand_num . $count); ?>" data-bs-parent="#mgpac<?php echo esc_attr($rand_num); ?>" style="">
                                    <div class="card-body mb-1 rgba-grey-light white-text mgba-content">
                                        <?php
                                        if (has_excerpt()) {
                                            echo esc_html(wp_trim_words(get_the_excerpt(), 80, '...'));
                                        } else {
                                            echo esc_html(wp_trim_words(get_the_content(), 80, '...'));
                                        }
                                        ?>
                                        <a href="<?php the_permalink() ?>" class="d-block mt-1"><?php esc_html_e(' Read More', 'magical-posts-display') ?></a>
                                    </div>
                                </div>
                            </div>

                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>


            </div>

<?php
            });
    }
}

new postsAccordion();
