<?php
/*
 * Register haslider slider post type. 
 * This is administrator only post type. 
 *
 * @link              http://digitalkroy.com/mp-display
 * @since             1.0.0
 * @package           haslider slider
 *
 * @wordpress-plugin
 */
 
/**
 *add haslider slider administrator role
 *
 *
 */
if ( ! function_exists( 'mp_display_admin_role' ) ) :
function mp_display_admin_role() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'edit_mp_display' ); 
    $admins->add_cap( 'read_mp_displays' ); 
    $admins->add_cap( 'delete_mp_display' ); 
    $admins->add_cap( 'delete_mp_displays' ); 
    $admins->add_cap( 'edit_mp_displays' ); 
    $admins->add_cap( 'edit_mp_display_others' ); 
    $admins->add_cap( 'publish_mp_displays' ); 
    $admins->add_cap( 'read_private_mp_display_posts' ); 
    $admins->add_cap( 'create_mp_displays' ); 
}
add_action( 'admin_init', 'mp_display_admin_role');
endif;
/**
 *Remove haslider slider administrator role
 *
 *
 */
if ( ! function_exists( 'mp_display_admin_role_remove' ) ) :
function mp_display_admin_role_remove() {
    // remove administrator role
    $admins = get_role( 'administrator' );
	$admins->remove_cap( 'edit_mp_display' ); 
    $admins->remove_cap( 'read_mp_displays' ); 
    $admins->remove_cap( 'delete_mp_display' ); 
    $admins->remove_cap( 'delete_mp_displays' ); 
    $admins->remove_cap( 'edit_mp_displays' ); 
    $admins->remove_cap( 'edit_mp_display_others' ); 
    $admins->remove_cap( 'publish_mp_displays' ); 
    $admins->remove_cap( 'read_private_mp_display_posts' ); 
    $admins->remove_cap( 'create_mp_displays' ); 
}
endif;
