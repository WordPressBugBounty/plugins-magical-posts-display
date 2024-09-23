<?php 
/*
 *   Register haslider slider post type. 
 *   This is administrator only post type. 
 *
 * @Author            Noor alam
 * @link              http://digitalkroy.com/mp-display
 * @since             1.0.0
 * @package           haslider slider
 *
 * @wordpress-plugin
 */
 
 if ( ! function_exists( 'mp_display_post_type' ) ) :
function mp_display_post_type() {
	$labels = array(
		'name'               => __( 'masical posts','magical-posts-display' ),
		'singular_name'      => __( 'masical posts','magical-posts-display' ),
		'menu_name'          => __( 'Masical posts','magical-posts-display' ),
		'name_admin_bar'     => __( 'Masical posts','magical-posts-display' ),
		'add_new'            => __( 'Add New Masical posts','magical-posts-display' ),
		'add_new_item'       => __( 'Add New Masical posts','magical-posts-display' ),
		'new_item'           => __( 'New Masical posts', 'magical-posts-display' ),
		'edit_item'          => __( 'Edit Masical posts', 'magical-posts-display' ),
		'view_item'          => __( 'View Masical posts', 'magical-posts-display' ),
		'all_items'          => __( 'All Masical posts', 'magical-posts-display' ),
		'parent_item_colon'  => __( 'Parent Masical posts:', 'magical-posts-display' ),
		'not_found'          => __( 'No Masical posts found.', 'magical-posts-display' ),
		'not_found_in_trash' => __( 'No Masical posts found in Trash.', 'magical-posts-display' ),
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'You can create awesome image sliders with by haslider slider.', 'magical-posts-display' ),
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => array( 'slug' => 'mp-display' ),
		'capabilities' => array(
          'edit_post'          => 'edit_mp_display', 
		  'read_post'          => 'read_mp_displays', 
		  'delete_post'        => 'delete_mp_display', 
		  'delete_posts'       => 'delete_mp_displays', 
		  'edit_posts'         => 'edit_mp_displays', 
		  'edit_others_posts'  => 'edit_mp_display_others', 
		  'publish_posts'      => 'publish_mp_displays',       
		  'read_private_posts' => 'read_private_mp_display_posts', 
		  'create_posts'       => 'create_mp_displays',
		),
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 60,
		'menu_icon' => 'dashicons-tickets-alt',
		'supports'           => array( 'title')
	);

	register_post_type( 'mp-display', $args );

}
 add_action( 'init', 'mp_display_post_type' );
 endif;
 
 
/*
 * Change haslider slider title placeholder
 *
 *
 */
if ( ! function_exists( 'mp_display_title_text' ) ) :
function mp_display_title_text( $title ){
     $screen = get_current_screen();
 
     if  ( 'mp-display' == $screen->post_type ) {
          $title = __('Masical posts name','magical-posts-display');
     }
 
     return $title;
}
 
add_filter( 'enter_title_here', 'mp_display_title_text' );
endif;