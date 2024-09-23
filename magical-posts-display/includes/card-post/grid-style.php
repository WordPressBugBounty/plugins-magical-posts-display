<?php 
/*
*
* Action for add style
*
*
*/

if ( ! function_exists( 'mp_display_posts_style' ) ) : 
function mp_display_posts_style($id){
$mg_posts_style = get_post_meta( $id, 'mg_posts_style', true );
$mgposts_cardbg =  !empty( $mg_posts_style[0]['mgposts_cardbg'])  ? $mg_posts_style[0]['mgposts_cardbg'] : '';
$mgposts_card_padding =  !empty( $mg_posts_style[0]['mgposts_card_padding'])  ? $mg_posts_style[0]['mgposts_card_padding'] : '';
$mgposts_img_width =  !empty( $mg_posts_style[0]['mgposts_img_width'])  ? $mg_posts_style[0]['mgposts_img_width'] : '';
$mgposts_img_height =  !empty( $mg_posts_style[0]['mgposts_img_height'])  ? $mg_posts_style[0]['mgposts_img_height'] : '';
$mgposts_img_bspace =  !empty( $mg_posts_style[0]['mgposts_img_bspace'])  ? $mg_posts_style[0]['mgposts_img_bspace'] : '';
$mgposts_title_font =  !empty( $mg_posts_style[0]['mgposts_title_font'])  ? $mg_posts_style[0]['mgposts_title_font'] : '';
$mgposts_title_color =  !empty( $mg_posts_style[0]['mgposts_title_color'])  ? $mg_posts_style[0]['mgposts_title_color'] : '';
$mgposts_desc_font =  !empty( $mg_posts_style[0]['mgposts_desc_font'])  ? $mg_posts_style[0]['mgposts_desc_font'] : '';
$mgposts_desc_color =  !empty( $mg_posts_style[0]['mgposts_desc_color'])  ? $mg_posts_style[0]['mgposts_desc_color'] : '';
$mgposts_meta_font =  !empty( $mg_posts_style[0]['mgposts_meta_font'])  ? $mg_posts_style[0]['mgposts_meta_font'] : '';
$mgposts_meta_color =  !empty( $mg_posts_style[0]['mgposts_meta_color'])  ? $mg_posts_style[0]['mgposts_meta_color'] : '';



?>
<style type="text/css">

<?php
	mpd_get_style_item(
        '.mgps.mgps-'.esc_attr($id).' .mgps-card',
        array(
            'background-color'=> $mgposts_cardbg,
            'padding'=> $mgposts_card_padding,
        )
    );
	mpd_get_style_item(
        '.mgps.mgps-'.esc_attr($id).' .mgps-card img, .mgps.mgps-'.esc_attr($id).' .no-post-thumbnail',
        array(
            'width'=> $mgposts_img_width,
            'height'=> $mgposts_img_height,
            'min-height'=> $mgposts_img_height,
            'margin-bottom'=> $mgposts_img_bspace,
        )
    );
	mpd_get_style_item(
        '.mgps.mgps-'.esc_attr($id).' .card-title a, .mgps.mgps-'.esc_attr($id).' .card-title',
        array(
            'font-size'=> $mgposts_title_font,
            'color'=> $mgposts_title_color,
        )
    );
	mpd_get_style_item(
        '.mgps.mgps-'.esc_attr($id).' .card-text',
        array(
            'font-size'=> $mgposts_desc_font,
            'color'=> $mgposts_desc_color,
        )
    );
	mpd_get_style_item(
        '.mgps.mgps-'.esc_attr($id).' .mp-meta,.mgps.mgps-'.esc_attr($id).' .mp-meta i,.mgps.mgps-'.esc_attr($id).' .mp-meta a',
        array(
            'font-size'=> $mgposts_meta_font,
            'color'=> $mgposts_meta_color,
        )
    );
 ?>	

</style>
<?php

}
add_action( 'mgp_card_style_display', 'mp_display_posts_style' );
endif;