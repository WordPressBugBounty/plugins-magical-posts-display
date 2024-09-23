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
class mgPdList
{

    function __construct()
    {
        add_action('carbon_fields_register_fields', [$this, 'mgd_post_display_lists']);
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


    function mgd_post_display_lists()
    {

        Block::make(__('Magical Awesome Posts Lists', 'magical-posts-display'))
            ->set_category('magical-posts-display', __('Magical Posts', 'magical-posts-display'), 'welcome-widgets-menus')
            ->set_icon('excerpt-view')
            ->set_keywords([__('post', 'magical-posts-display'), __('List', 'magical-posts-display'), __('card', 'magical-posts-display')])
            ->set_mode('both')
            ->add_tab(__('Posts List'), array(
                Field::make('separator', 'mpdlist_post_content', __('Post content', 'magical-posts-display')),
                Field::make('select', 'mpdlist_posts_show', __('Show Posts by', 'magical-posts-display'))
                    ->set_options(array(
                        'DSC' => __('Latest Posts', 'magical-posts-display'),
                        'ASC' => __('Oldest Posts', 'magical-posts-display'),
                        'rand' => __('Random Posts', 'magical-posts-display'),
                    ))
                    ->set_default_value('DSC'),
                Field::make('select', 'mpdlist_posts_cat', __('Select Category', 'magical-posts-display'))
                    ->set_options(array($this, 'mgpd_cat_list'))
                    ->set_default_value('all'),
                Field::make('text', 'mpdlist_posts_number', __('Posts number', 'magical-posts-display'))
                    ->set_attribute('type', 'number')->set_default_value(6),
                Field::make('select', 'mpdlist_text_align', __('Text position', 'magical-posts-display'))
                    ->set_options(array(
                        'left' => __('Left', 'magical-posts-display'),
                        'center' => __('Center', 'magical-posts-display'),
                        'right' => __('Right', 'magical-posts-display'),
                    ))
                    ->set_default_value('left'),

                Field::make('separator', 'mpdlist_post_img', __('Posts image or Highlighted date', 'magical-posts-display')),
                Field::make('select', 'mpdlist_posts_imgmeta', __('Show Highlighted date or image', 'magical-posts-display'))
                    ->set_options(array(
                        'show-hdate' => __('Show Highlighted date', 'magical-posts-display'),
                        'show-img' => __('Show image', 'magical-posts-display'),
                        'hide' => __('Hide Highlighted date or image', 'magical-posts-display'),
                    ))
                    ->set_default_value('show-hdate'),
                Field::make('select', 'mpdlist_img_position', __('Image or Highlighted date Position', 'magical-posts-display'))
                    ->set_options(array(
                        'left' => __('Left', 'magical-posts-display'),
                        'right' => __('Right', 'magical-posts-display'),
                    ))
                    ->set_default_value('left'),
                /* Field::make( 'select', 'mpdlist_posts_column', __( 'Text and Highlighted date or image column','magical-posts-display' ) )
            ->set_options( array(
                '2/10' => __( '2/10','magical-posts-display' ),
                '3/9' => __( '3/9','magical-posts-display' ),
                '4/8' => __( '4/8','magical-posts-display' ),
            ) )
            ->set_default_value('3/9'),*/
                Field::make('text', 'mpdlist_img_width', __('Image & Date Width', 'magical-posts-display'))->set_help_text(__('Enter Image div width. Default width 150px'))
                    ->set_attribute('type', 'number')
                    ->set_default_value('150'),
                Field::make('select', 'mpdlist_img_size', __('Image size', 'magical-posts-display'))
                    ->set_options(array(
                        'thumbnail' => __('Thumbnail (150*150)', 'magical-posts-display'),
                        'medium' => __('Medium (300*300)', 'magical-posts-display'),
                        'card-List' => __('List Card (600*900)', 'magical-posts-display'),
                        'card-list' => __('List card (600*700)', 'magical-posts-display'),
                        'medium_large' => __('Medium large (768*0)', 'magical-posts-display'),
                        'large' => __('Large ( 1024*1024)', 'magical-posts-display'),
                        'full' => __('Orginal size', 'magical-posts-display'),
                    ))
                    ->set_default_value('thumbnail'),

                Field::make('separator', 'mpdlist_post_meta', __('Post Meta', 'magical-posts-display')),
                Field::make('checkbox', 'mpdlist_style', __('Show list style', 'magical-posts-display')),
                Field::make('checkbox', 'mpdlist_cat', __('Show Category', 'magical-posts-display'))
                    ->set_option_value('yes'),
                Field::make('checkbox', 'mpdlist_author', __('Show Author', 'magical-posts-display'))
                    ->set_option_value('yes'),
                Field::make('checkbox', 'mpdlist_date', __('Show Date', 'magical-posts-display'))
                    ->set_option_value('yes'),
            ))
            ->add_tab(__('List Style'), array(
                Field::make('separator', 'mpdlist_sep_content', __('List Style', 'magical-posts-display')),

                Field::make('text', 'mpdlist_padding', __('List Padding', 'magical-posts-display'))->set_help_text(__('Enter list padding. padding set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdlist_bgcolor', __('List background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('text', 'mpdlist_item_bmargin', __('List items Bottom margin', 'magical-posts-display'))->set_help_text(__('Enter list padding. padding set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdlist_item_bgcolor', __('List items background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdlist_sep_img', __('Image Style', 'magical-posts-display')),
                Field::make('text', 'mpdlist_img_height', __('Image height', 'magical-posts-display'))->set_help_text(__('Set image height. Leave empty for auto height.'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdlist_img_margin', __('Image bottom space', 'magical-posts-display'))->set_help_text(__('Tyepe image bottom margin. Icon margin set by px'))
                    ->set_attribute('type', 'number'),

                Field::make('separator', 'mpdlist_sep_title', __('Title Style', 'magical-posts-display')),
                Field::make('text', 'mpdlist_title_size', __('Title font size', 'magical-posts-display'))->set_help_text(__('Tyepe number for icon size. Icon size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdlist_title_margin', __('Title bottom space', 'magical-posts-display'))->set_help_text(__('Tyepe number icon margin. Icon margin set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdlist_title_color', __('Title color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdlist_sep_hmeta', __('Highlighted meta Style', 'magical-posts-display')),
                Field::make('text', 'mpdlist_hmeta_size', __('Font size', 'magical-posts-display'))->set_help_text(__('Tyepe number for text size. Text size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'mpdlist_hmeta_tbpadding', __('Top bottom padding', 'magical-posts-display'))->set_help_text(__('Tyepe number for text size. Text size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdlist_hmeta_bg1', __('Day Background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdlist_hmeta_txt1', __('Day text color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdlist_hmeta_bg2', __('Month Background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdlist_hmeta_txt2', __('Month text color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdlist_hmeta_bg3', __('Year Background color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),
                Field::make('color', 'mpdlist_hmeta_txt3', __('Year text color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),

                Field::make('separator', 'mpdlist_sep_meta', __('Meta Style', 'magical-posts-display')),
                Field::make('text', 'mpdlist_meta_size', __('Meta size', 'magical-posts-display'))->set_help_text(__('Set Meta size. Meta size set by px'))
                    ->set_attribute('type', 'number'),
                Field::make('color', 'mpdlist_meta_color', __('Meta color', 'magical-posts-display'))
                    ->set_palette(array('#FF0000', '#000000', '#C0B283', '#4484CE', '#3FB0AC', '#C2DDE6', '#88D317', '#8076a3')),


            ))



            ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                $rand_num = wp_rand(6252948, 8952146);
                /*$mpdlist_posts_show =isset( $fields['mpdlist_posts_show'])? $fields['mpdlist_posts_show']: 'DSC';*/
                $mpdlist_posts_show = mpd_get_option($fields['mpdlist_posts_show'], 'DSC');
                $mpdlist_posts_cat = mpd_get_option($fields['mpdlist_posts_cat'], 'all');
                $mpdlist_posts_number = mpd_get_option($fields['mpdlist_posts_number'], '9');
                $mpdlist_text_align = mpd_get_option($fields['mpdlist_text_align'], 'left');
                $mpdlist_posts_imgmeta = mpd_get_option($fields['mpdlist_posts_imgmeta'], 'show-hdate');
                $mpdlist_img_position = mpd_get_option($fields['mpdlist_img_position'], 'left');
                $mpdlist_img_size = mpd_get_option($fields['mpdlist_img_size'], 'thumbnail');
                $mpdlist_style = mpd_get_option($fields['mpdlist_style']);
                $mpdlist_cat = mpd_get_option($fields['mpdlist_cat'], 'yes');
                $mpdlist_author = mpd_get_option($fields['mpdlist_author'], 'yes');
                $mpdlist_date = mpd_get_option($fields['mpdlist_date'], 'yes');
                $mpdlist_padding = mpd_get_option($fields['mpdlist_padding']);
                $mpdlist_bgcolor = mpd_get_option($fields['mpdlist_bgcolor']);
                $mpdlist_item_bmargin = mpd_get_option($fields['mpdlist_item_bmargin']);
                $mpdlist_item_bgcolor = mpd_get_option($fields['mpdlist_item_bgcolor']);
                $mpdlist_img_height = mpd_get_option($fields['mpdlist_img_height']);
                $mpdlist_img_margin = mpd_get_option($fields['mpdlist_img_margin']);
                $mpdlist_title_size = mpd_get_option($fields['mpdlist_title_size']);
                $mpdlist_title_margin = mpd_get_option($fields['mpdlist_title_margin']);
                $mpdlist_title_color = mpd_get_option($fields['mpdlist_title_color']);
                $mpdlist_hmeta_size = mpd_get_option($fields['mpdlist_hmeta_size']);
                $mpdlist_hmeta_tbpadding = mpd_get_option($fields['mpdlist_hmeta_tbpadding']);
                $mpdlist_hmeta_bg1 = mpd_get_option($fields['mpdlist_hmeta_bg1']);
                $mpdlist_hmeta_txt1 = mpd_get_option($fields['mpdlist_hmeta_txt1']);
                $mpdlist_hmeta_bg2 = mpd_get_option($fields['mpdlist_hmeta_bg2']);
                $mpdlist_hmeta_txt2 = mpd_get_option($fields['mpdlist_hmeta_txt2']);
                $mpdlist_hmeta_bg3 = mpd_get_option($fields['mpdlist_hmeta_bg3']);
                $mpdlist_hmeta_txt3 = mpd_get_option($fields['mpdlist_hmeta_txt3']);
                $mpdlist_meta_size = mpd_get_option($fields['mpdlist_meta_size']);
                $mpdlist_meta_color = mpd_get_option($fields['mpdlist_meta_color']);

                $mpdlist_img_width = isset($fields['mpdlist_img_width']) ? $fields['mpdlist_img_width'] : '150';


?>
            <div class="mgpd mp-display-list mgpdl mgpdl<?php echo esc_attr($rand_num); ?> ">
                <style type="text/css">
                    <?php
                    mpd_get_style_item(
                        '.mgpdl.mgpdl' . esc_attr($rand_num),
                        array(
                            'padding' => $mpdlist_padding,
                            'background-color' => $mpdlist_bgcolor
                        )
                    );
                    mpd_get_style_item(
                        '.mgpdl' . esc_attr($rand_num) . ' ul li.mgpdl-list-item',
                        array(
                            'margin-bottom' => $mpdlist_item_bmargin,
                            'background-color' => $mpdlist_item_bgcolor
                        ),
                        true
                    );
                    mpd_get_style_item(
                        '.mgpdl' . esc_attr($rand_num) . ' .mpdl-img img',
                        array(
                            'margin-bottom' => $mpdlist_img_margin,
                            'height' => $mpdlist_img_height
                        ),
                        true
                    );

                    mpd_get_style_item(
                        '.mgpdl' . esc_attr($rand_num) . ' .mgpdl-list-item .mpdl-title a,.mgpdl' . esc_attr($rand_num) . ' .mgpdl-list-item .mpdl-title',
                        array(
                            'font-size' => $mpdlist_title_size,
                            'color' => $mpdlist_title_color,
                            'margin-bottom' => $mpdlist_title_margin
                        ),
                        true
                    );
                    mpd_get_style_item(
                        '.mgpdl' . esc_attr($rand_num) . ' .mpdl-date span',
                        array(
                            'font-size' => $mpdlist_hmeta_size,
                            'padding-top' => $mpdlist_hmeta_tbpadding,
                            'padding-bottom' => $mpdlist_hmeta_tbpadding
                        ),
                        true
                    );
                    mpd_get_style_item(
                        '.mgpdl' . esc_attr($rand_num) . ' .mpdl-date span.mp-day',
                        array(
                            'background-color' => $mpdlist_hmeta_bg1,
                            'color' => $mpdlist_hmeta_txt1,
                        )
                    );
                    mpd_get_style_item(
                        '.mgpdl' . esc_attr($rand_num) . ' .mpdl-date span.mp-month',
                        array(
                            'background-color' => $mpdlist_hmeta_bg2,
                            'color' => $mpdlist_hmeta_txt2,
                        )
                    );
                    mpd_get_style_item(
                        '.mgpdl' . esc_attr($rand_num) . ' .mpdl-date span.mp-year',
                        array(
                            'background-color' => $mpdlist_hmeta_bg3,
                            'color' => $mpdlist_hmeta_txt3,
                        )
                    );
                    mpd_get_style_item(
                        '.mgpdl' . esc_attr($rand_num) . ' .mp-meta,.mgpdl' . esc_attr($rand_num) . ' .mp-meta a,.mgpdl' . esc_attr($rand_num) . ' .mp-meta i',
                        array(
                            'font-size' => $mpdlist_meta_size,
                            'color' => $mpdlist_meta_color,
                        )
                    );
                    mpd_get_style_item(
                        '.mgpdl' . esc_attr($rand_num) . ' .mpdl-img, .mgpdl' . esc_attr($rand_num) . ' .mpdl-date',
                        array(
                            'width' => $mpdlist_img_width,
                        )
                    );
                    ?>
                </style>




                <ul class="mgpdl-list <?php if (empty($mpdlist_style)) : ?>mgpdl-hstyle<?php endif; ?>">
                    <?php


                    if ($mpdlist_posts_cat != 'all') {
                        $terms = array(
                            array(
                                'taxonomy'  => 'category',
                                'field'  => 'slug',
                                'terms'  => $mpdlist_posts_cat
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
                        'posts_per_page'    => $mpdlist_posts_number,
                        'tax_query'         =>  $terms,
                        'ignore_sticky_posts' => 1
                    );
                    if ($mpdlist_posts_show == 'rand') {
                        $mp_args['orderby'] = 'rand';
                    } else {
                        $mp_args['order'] = $mpdlist_posts_show;
                    }
                    /*if(is_page() && $mpdg_show_pagination){
$mp_args['paged'] = $paged;
}*/
                    $mp_loop = new WP_Query($mp_args);
                    if ($mp_loop->have_posts()) :
                        while ($mp_loop->have_posts()) :  $mp_loop->the_post();

                            /*if( $mpdlist_posts_imgmeta == 'hide' ){
    $mpdl_column = 12;
    $mpdl_column_meta = '';
    }elseif( $mpdlist_posts_imgmeta == 'show-img' && !has_post_thumbnail() ){
    $mpdl_column = 12;
    $mpdl_column_meta = '';
    }else{*/
                            $mpdl_column = 'auto';
                            $mpdl_column_meta = 'auto';

                            /*}*/


                    ?>
                            <li class="mgpdl-list-item mgbb mb-1 pb-1 text-<?php if ($mpdlist_img_position == 'right') : ?>right<?php else : ?>left<?php endif; ?>">
                                <div class="row <?php if ($mpdlist_img_position == 'right') : ?>justify-content-end<?php endif; ?>">
                                    <?php if ($mpdlist_img_position == 'left' && $mpdlist_posts_imgmeta != 'hide') : ?>
                                        <?php if ($mpdlist_posts_imgmeta == 'show-hdate') : ?>
                                            <div class="col-sm-<?php echo esc_attr($mpdl_column_meta); ?>">
                                                <div class="mpdl-date bg-info text-center">
                                                    <span class="mp-day"><?php echo esc_html(get_the_date('l')); ?></span>
                                                    <span class="mp-month"><?php echo esc_html(get_the_date('M j')); ?></span>
                                                    <span class="mp-year"><?php echo esc_html(get_the_date('Y')); ?></span>
                                                </div>
                                            </div>
                                            <?php
                                        else :
                                            if (has_post_thumbnail()) :
                                            ?>
                                                <div class="col-sm-<?php echo esc_attr($mpdl_column_meta); ?>">
                                                    <div class="mpdl-img">
                                                        <?php the_post_thumbnail($mpdlist_img_size); ?>
                                                    </div>
                                                </div>
                                        <?php
                                            endif; // check post thumbnail
                                        endif; // check post meta or image 
                                        ?>

                                    <?php endif; ?>
                                    <div class="col-sm-<?php echo esc_attr($mpdl_column); ?>">
                                        <div class="mpdl-text text-<?php echo esc_attr($mpdlist_text_align); ?>">
                                            <?php if ($mpdlist_cat) : ?>
                                                <div class="mp-meta cat-list">
                                                    <?php mpd_one_cat(get_the_ID()); ?>
                                                </div>
                                            <?php endif; ?>
                                            <h3 class="mpdl-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <?php if ($mpdlist_author || $mpdlist_date) : ?>
                                                <div class="mp-meta bottom-meta mb-2">
                                                    <?php
                                                    if ($mpdlist_author) {
                                                        mp_display_posted_by();
                                                    }
                                                    if ($mpdlist_date) {
                                                        echo '<i class="icon-mp-clock"></i> ';
                                                        echo esc_html(get_the_date());
                                                    }

                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>


                                    </div>
                                    <?php if ($mpdlist_img_position == 'right' && $mpdlist_posts_imgmeta != 'hide') : ?>
                                        <?php if ($mpdlist_posts_imgmeta == 'show-hdate') : ?>
                                            <div class="col-sm-<?php echo esc_attr($mpdl_column_meta); ?>">
                                                <div class="mpdl-date bg-info text-center">
                                                    <span class="mp-day"><?php echo get_the_date('l'); ?></span>
                                                    <span class="mp-month"><?php echo get_the_date('M j'); ?></span>
                                                    <span class="mp-year"><?php echo get_the_date('Y'); ?></span>
                                                </div>
                                            </div>
                                            <?php
                                        else :
                                            if (has_post_thumbnail()) :
                                            ?>
                                                <div class="col-sm-<?php echo esc_attr($mpdl_column_meta); ?>">
                                                    <div class="mpdl-img ">
                                                        <?php the_post_thumbnail($mpdlist_img_size); ?>
                                                    </div>
                                                </div>
                                        <?php
                                            endif; // check post thumbnail
                                        endif; // check post meta or image 
                                        ?>
                                    <?php endif; ?>
                                </div>


                            </li>

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




<?php
            });
    }
}

new mgPdList();
