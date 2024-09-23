<?php
/*
 * Include and setup custom metaboxes and fields. 
 *
 * @link              http://digitalkroy.com/mp-display
 * @since             1.0.0
 * @package          haslider slider
 *
 * @wordpress-plugin
 */
if ( ! function_exists( 'mp_display_cheackbox_default' ) ) :
function mp_display_cheackbox_default( $default ) {
    return isset( $_GET['post'] ) ? '' : ( $default ? (string) $default : '' );
}
endif;

//All meta show in tab
if ( ! function_exists( 'mp_display_group_tab' ) ) :
add_action( 'cmb2_init', 'mp_display_group_tab' );
function mp_display_group_tab() {

	$mp_display_meta = new_cmb2_box( array(
		'id'           => 'metabox-tabs',
		'title'        => __('All setup for magical posts display','magical-posts-display'),
		'object_types' => array('mp-display'), // post type
		'context'      => 'normal',
		'priority'     => 'high',
		'tabs'      => array(
            'one' => array(
                'label' => __('Setup Magical Posts', 'magical-posts-display'),
                'icon'  => 'dashicons-format-image', // Dashicon
            ),
            'two' => array(
                'label' => __('Posts settings', 'magical-posts-display'),
                'icon'  => 'dashicons-format-gallery', // Dashicon
            ),
            'three' => array(
                'label' => __('Posts style', 'magical-posts-display'),
                'icon'  => 'dashicons-format-gallery', // Dashicon
            ),
           /* 'three' => array(
                'label' => __('Advance Settings', 'magical-posts-display'),
                'icon'  => 'dashicons-format-gallery', // Dashicon
            ),*/
           
        ),
	) );
	/*
	$mp_display_meta->add_field(array(
        'name' => esc_html__('','magical-posts-display'),
        'id'   => 'post_type',
        'type' => 'radio_image',
        'options' => array(
			'card' => __( 'Card view','magical-posts-display' ),
			'section'   => __( 'section view','magical-posts-display' ),
		),
		'default' => 'card',
		'tab'  => 'one',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		
    ));*/
	
	// slider style one
	$slider_one = $mp_display_meta->add_field( array(
		'id'           => 'posts_card',
		'type'         => 'group',
		'repeatable'   => false,
		'tab'  => 'one',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		'options'      => array(
			'group_title'   => __('Setup Magical Posts', 'magical-posts-display' ),
			
		),
		'fields' => array(
				array(
					'name' => __( 'Posts Show By', 'magical-posts-display' ),
					'desc'    => __( 'Add slider title. Must fill the field. Sliders can not be seen if it is empty.', 'magical-posts-display' ),
	    			'id'   => 'posts_show_by',
	    			'type' => 'pw_select',
	    			'default' => 'DESC',
	    			'options'          => array(
						'DESC'   => __( 'Latest Posts','magical-posts-display' ),
						'ASC'   => __( 'Oldest Posts','magical-posts-display' ),
						'category'   => __( 'Category','magical-posts-display' ),
						'tag'   => __( 'Tag','magical-posts-display' ),
					),
	    			
				),
				array(
					'name' => __( 'Select Category', 'magical-posts-display' ),
					'desc'    => __( 'Select category for display category posts', 'magical-posts-display' ),
	    			'id'   => 'posts_cat',
	    			'type' => 'pw_select',
	    			'default' => 'latest',
	    			'options'          => mp_display_get_term_options( 'category' ), 
	    			'attributes' => array(
						'data-conditional-id' => 'posts_show_by',
						'data-conditional-value' =>'category' ,

					),
	    			
				),
				array(
					'name' => __( 'Select tag', 'magical-posts-display' ),
					'desc'    => __( 'Select tag for display tag posts', 'magical-posts-display' ),
	    			'id'   => 'posts_tag',
	    			'type' => 'pw_select',
	    			'default' => 'latest',
	    			'options'          => mp_display_get_term_options( 'post_tag' ), 
	    			'attributes' => array(
						'data-conditional-id' => 'posts_show_by',
						'data-conditional-value' =>'tag' ,

					),
	    			
				),
				array(
					'name' => __( 'Posts number', 'magical-posts-display' ),
					'desc'    => __( 'Select posts number', 'magical-posts-display' ),
	    			'id'   => 'set_posts_num',
	    			'type' => 'radio_image',
	    			'default' => 'all',
	    			'options'          => array(
						'all'   => __( 'Show all posts','magical-posts-display' ),
						'set'   => __( 'Select posts number','magical-posts-display' ),
					),
	    			
				),
				array(
				'name'             => __( 'Number of posts', 'magical-posts-display' ),
				'desc'             => __( 'Set posts for display.', 'magical-posts-display' ),
				'id'               => 'posts_number',
				'type'        => 'own_slider',
				'min'         => '1',
				'max'         => '100',
				'default'     => '9', // start value
				'value_label' => __('posts:','magical-posts-display'),
				'attributes' => array(
						'data-conditional-id' => 'set_posts_num',
						'data-conditional-value' =>'set' ,

					),
				),
				array(
				'name'             => __( 'Show post pagination', 'magical-posts-display' ),
				'desc'             => __( 'You can show or hide post pagination. Pagination only work page.', 'magical-posts-display' ),
				'id'               => 'post_pagination',
				'type'	           => 'switch',
		        'default'          => mp_display_cheackbox_default('on'),
		        'attributes' => array(
						'data-conditional-id' => 'set_posts_num',
						'data-conditional-value' =>'set' ,

					),
			    			
			),
				array(
					'name' => __( 'Post card type', 'magical-posts-display' ),
					'desc'    => __( 'Select card type', 'magical-posts-display' ),
	    			'id'   => 'posts_card_type',
	    			'type' => 'pw_select',
	    			'default' => 'grid',
	    			'options'          => array(
						'grid'   => __( 'Grid style','magical-posts-display' ),
						'list'   => __( 'List style','magical-posts-display' ),
					),
	    			
				),/*
				array(
					'name' => __( 'Select grid Style', 'magical-posts-display' ),
					'desc'    => __( 'Select one style from here', 'magical-posts-display' ),
	    			'id'   => 'grid_style',
	    			'type' => 'pw_select',
	    			'default' => 'grid1',
	    			'options'          => array(
						'grid1'   => __( 'Grid style one','magical-posts-display' ),
						'grid2'   => __( 'Grid style two','magical-posts-display' ),
						'grid3'   => __( 'Grid style three','magical-posts-display' ),
					),
					'attributes' => array(
						'data-conditional-id' => 'magical-posts-display',
						'data-conditional-value' =>'grid' ,

					),
	    			
				),*/
				array(
					'name' => __( 'Grid column', 'magical-posts-display' ),
					'desc'    => __( 'Select grid column', 'magical-posts-display' ),
	    			'id'   => 'grid_column',
	    			'type' => 'pw_select',
	    			'default' => '4',
	    			'options'          => array(
						'12'   => __( 'One column','magical-posts-display' ),
						'6'   => __( 'Two column','magical-posts-display' ),
						'4'   => __( 'Three column','magical-posts-display' ),
						'3'   => __( 'Four column','magical-posts-display' ),
					),
					'attributes' => array(
						'data-conditional-id' => 'magical-posts-display',
						'data-conditional-value' =>'grid' ,

					),
	    			
				),
/*
				array(
					'name' => __( 'Select list Style', 'magical-posts-display' ),
					'desc'    => __( 'Select one style from here', 'magical-posts-display' ),
	    			'id'   => 'list_style',
	    			'type' => 'pw_select',
	    			'default' => 'list1',
	    			'options'          => array(
						'list1'   => __( 'list style one','magical-posts-display' ),
						'list2'   => __( 'List style two','magical-posts-display' ),
					),
					'attributes' => array(
						'data-conditional-id' => 'magical-posts-display',
						'data-conditional-value' =>'list' ,

					),
					
	    			
				),

*/
				array(
					'name' => __( 'Show posts button', 'magical-posts-display' ),
		    		'id'   => 'mgposts_btn',
		    		'type' => 'select',
		    		'default' => 'show',
		    		'options'          => array(
						'show'   => __( 'Show button','magical-posts-display' ),
						'hide'   => __( 'Hide button','magical-posts-display' ),
						),

		    			
				),
				array(
					'name' => __( 'Button text', 'magical-posts-display' ),
					'desc'    => __( 'Add read more button text.', 'magical-posts-display' ),
	    			'id'   => 'btn_text',
	    			'type' => 'text',
	    			'default' => __('Read More','magical-posts-display' ),
	    			'attributes' => array(
						'data-conditional-id' => 'mgposts_btn',
						'data-conditional-value' =>'show' ,

					),
				),
				array(
					'name' => __( 'Select button', 'magical-posts-display' ),
					'desc'    => __( 'Select read more button style.', 'magical-posts-display' ),
	    			'id'   => 'button_style',
	    			'type' => 'pw_select',
	    			'default' => 'dark',
	    			'options'          => array(
	    				'dark'   => __( 'Button dark','magical-posts-display' ),
						'primary'   => __( 'Button primary','magical-posts-display' ),
						'secondary'   => __( 'Button secondary','magical-posts-display' ),
						'success'   => __( 'Button success','magical-posts-display' ),
						'danger'   => __( 'Button danger','magical-posts-display' ),
						'warning'   => __( 'Button warning','magical-posts-display' ),
						'info'   => __( 'Button info','magical-posts-display' ),
						'light'   => __( 'Button light','magical-posts-display' ),
						'link'   => __( 'Button link','magical-posts-display' ),
					),
					'attributes' => array(
						'data-conditional-id' => 'mgposts_btn',
						'data-conditional-value' =>'show' ,

					),
				),
	
			),
	) );	
	// tab one
		// slider meta settings
	$slider_one = $mp_display_meta->add_field( array(
		'id'           => 'posts_meta',
		'type'         => 'group',
		'repeatable'   => false,
		'tab'  => 'two',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		'options'      => array(
			'group_title'   => __('Setup Magical Posts', 'magical-posts-display' ),
			
		),
		'fields' => array(
			array(
				'name' => __( 'Show posts image', 'magical-posts-display' ),
	    		'id'   => 'mgposts_img',
	    		'type' => 'select',
	    		'default' => 'show',
	    		'options'          => array(
					'show'   => __( 'Show image','magical-posts-display' ),
					'hide'   => __( 'Hide image','magical-posts-display' ),
					),
	    			
			),
			array(
				'name' => __( 'Show posts title', 'magical-posts-display' ),
	    		'id'   => 'mgposts_title',
	    		'type' => 'select',
	    		'default' => 'show',
	    		'options'          => array(
					'show'   => __( 'Show Title','magical-posts-display' ),
					'hide'   => __( 'Hide Title','magical-posts-display' ),
					),
	    			
			),
			array(
				'name' => __( 'maximum Title Words', 'magical-posts-display' ),
				'desc'  => __( 'Set maximum title words', 'magical-posts-display' ),
	    		'id'   => 'mgposts_title_words',
	    		'type' => 'text',
	    		'default' => '5',
				'attributes' => array(
					'type' => 'number',
					'pattern' => '\d*',
					'data-conditional-id' => 'mgposts_title',
					'data-conditional-value' =>'show' ,
				),
	    			
	    			
			),
			array(
				'name' => __( 'Show posts description', 'magical-posts-display' ),
	    		'id'   => 'mgpost_desc',
	    		'type' => 'select',
	    		'default' => 'show',
	    		'options'          => array(
					'show'   => __( 'Show description','magical-posts-display' ),
					'hide'   => __( 'Hide description','magical-posts-display' ),
					),
	    			
			),
			array(
				'name' => __( 'maximum description Words', 'magical-posts-display' ),
				'desc'  => __( 'Set maximum description words', 'magical-posts-display' ),
	    		'id'   => 'mgposts_desc_words',
	    		'type' => 'text',
	    		'default' => '25',
				'attributes' => array(
					'type' => 'number',
					'pattern' => '\d*',
					'data-conditional-id' => 'mgpost_desc',
					'data-conditional-value' =>'show' ,
				),
	    			
	    			
			),
			
			array(
				'name'             => __( 'Show post category', 'magical-posts-display' ),
				'desc'             => __( 'You can show or hide post category.', 'magical-posts-display' ),
				'id'               => 'post_cat',
				'type'	           => 'switch',
		        'default'          => mp_display_cheackbox_default('on'),
			    			
			),
			array(
				'name'             => __( 'Show post author', 'magical-posts-display' ),
				'desc'             => __( 'You can show or hide post author.', 'magical-posts-display' ),
				'id'               => 'post_author',
				'type'	           => 'switch',
		        'default'          => mp_display_cheackbox_default('on'),
			    			
			),
			array(
				'name'             => __( 'Show post date', 'magical-posts-display' ),
				'desc'             => __( 'You can show or hide post date.', 'magical-posts-display' ),
				'id'               => 'post_date',
				'type'	           => 'switch',
		        'default'          => mp_display_cheackbox_default('on'),
			    			
			),
			array(
				'name'             => __( 'Show post comment', 'magical-posts-display' ),
				'desc'             => __( 'You can show or hide post comment. Post comment only show when comment open.', 'magical-posts-display' ),
				'id'               => 'post_comment',
				'type'	           => 'switch',
		        'default'          => '',
			    			
			),
			array(
				'name'             => __( 'Show post tag', 'magical-posts-display' ),
				'desc'             => __( 'You can show or hide post tag.', 'magical-posts-display' ),
				'id'               => 'post_tag',
				'type'	           => 'switch',
		        'default'          => '',
			    			
			),
		),
	) );
		// Posts tyle
	$slider_one = $mp_display_meta->add_field( array(
		'id'           => 'mg_posts_style',
		'type'         => 'group',
		'repeatable'   => false,
		'tab'  => 'three',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		'options'      => array(
			'group_title'   => __('Magical Posts Style', 'magical-posts-display' ),
			
		),
		'fields' => array(
			array(
				'name' => __( 'Basic Style', 'magical-posts-display' ),
				'type' => 'title',
				'id'   => 'mgp_basic_style',
				
			),
			
			array(
				'name' => __( 'Card background Color', 'magical-posts-display' ),
				'desc'  => __( 'Set card background color.', 'magical-posts-display' ),
	    		'id'   => 'mgposts_cardbg',
	    		'type'  => 'colorpicker',
	    			
			),
			array(
				'name' => __( 'Card padding', 'magical-posts-display' ),
				'desc'  => __( 'Set card padding by number px.', 'magical-posts-display' ),
	    		'id'   => 'mgposts_card_padding',
	    		'type' => 'text',
				'attributes' => array(
					'type' => 'number',
					'pattern' => '\d*',
				),
	    			
	    			
			),
			array(
				'name' => __( 'Image Style', 'magical-posts-display' ),
				'type' => 'title',
				'id'   => 'mgp_img_style',
				'attributes' => array(
					'data-conditional-id' => 'mgposts_img',
					'data-conditional-value' =>'show' ,
				),
			),
			array(
				'name' => __( 'Image width', 'magical-posts-display' ),
				'desc'  => __( 'Set image width  by number. leave empty for 100% width', 'magical-posts-display' ),
	    		'id'   => 'mgposts_img_width',
	    		'type' => 'text',
				'attributes' => array(
					'type' => 'number',
					'pattern' => '\d*',
					'data-conditional-id' => 'mgposts_img',
					'data-conditional-value' =>'show' ,
				),
	    			
	    			
			),
			array(
				'name' => __( 'Image height', 'magical-posts-display' ),
				'desc'  => __( 'Set image height by number. leave empty for auto height', 'magical-posts-display' ),
	    		'id'   => 'mgposts_img_height',
	    		'type' => 'text',
				'attributes' => array(
					'type' => 'number',
					'pattern' => '\d*',
					'data-conditional-id' => 'mgposts_img',
					'data-conditional-value' =>'show' ,
				),
	    			
	    			
			),
			array(
				'name' => __( 'Image bottom space', 'magical-posts-display' ),
				'desc'  => __( 'Set image bottom space  by number. Bottom space set by margin.', 'magical-posts-display' ),
	    		'id'   => 'mgposts_img_bspace',
	    		'type' => 'text',
				'attributes' => array(
					'type' => 'number',
					'pattern' => '\d*',
					'data-conditional-id' => 'mgposts_img',
					'data-conditional-value' =>'show' ,
				),
	    			
	    			
			),
			array(
				'name' => __( 'Title Style', 'magical-posts-display' ),
				'type' => 'title',
				'id'   => 'mgp_title_style',
				'attributes' => array(
					'data-conditional-id' => 'mgposts_title',
					'data-conditional-value' =>'show' ,
				),
			),
			array(
				'name' => __( 'Title Font Size', 'magical-posts-display' ),
				'desc'  => __( 'Set title font size by number.', 'magical-posts-display' ),
	    		'id'   => 'mgposts_title_font',
	    		'type' => 'text',
				'attributes' => array(
					'type' => 'number',
					'pattern' => '\d*',
					'data-conditional-id' => 'mgposts_title',
					'data-conditional-value' =>'show' ,
				),
	    			
	    			
			),
			array(
				'name' => __( 'Title Color', 'magical-posts-display' ),
				'desc'  => __( 'Set title color.', 'magical-posts-display' ),
	    		'id'   => 'mgposts_title_color',
	    		'type'  => 'colorpicker',
				'attributes' => array(
					'data-conditional-id' => 'mgposts_title',
					'data-conditional-value' =>'show' ,
				),
	    			
	    			
			),
			array(
				'name' => __( 'Description Style', 'magical-posts-display' ),
				'type' => 'title',
				'id'   => 'mgp_desc_style',
				'attributes' => array(
					'data-conditional-id' => 'mgpost_desc',
					'data-conditional-value' =>'show' ,
				),
			),
			array(
				'name' => __( 'Description Font Size', 'magical-posts-display' ),
				'desc'  => __( 'Set title font size by number.', 'magical-posts-display' ),
	    		'id'   => 'mgposts_desc_font',
	    		'type' => 'text',
				'attributes' => array(
					'type' => 'number',
					'pattern' => '\d*',
					'data-conditional-id' => 'mgpost_desc',
					'data-conditional-value' =>'show' ,
				),
	    			
	    			
			),
			array(
				'name' => __( 'Description Color', 'magical-posts-display' ),
				'desc'  => __( 'Set title color.', 'magical-posts-display' ),
	    		'id'   => 'mgposts_desc_color',
	    		'type'  => 'colorpicker',
				'attributes' => array(
					'data-conditional-id' => 'mgpost_desc',
					'data-conditional-value' =>'show' ,
				),
	    			
	    			
			),
			array(
				'name' => __( 'Meta Style', 'magical-posts-display' ),
				'type' => 'title',
				'id'   => 'mgp_meta_style',
			),
			array(
				'name' => __( 'Meta Font Size', 'magical-posts-display' ),
				'desc'  => __( 'Set title font size by number.', 'magical-posts-display' ),
	    		'id'   => 'mgposts_meta_font',
	    		'type' => 'text',
					
			),
			array(
				'name' => __( 'Meta Color', 'magical-posts-display' ),
				'desc'  => __( 'Set title color.', 'magical-posts-display' ),
	    		'id'   => 'mgposts_meta_color',
	    		'type'  => 'colorpicker',
					
			),
			
		),
	) );


}
endif;

