<?php
namespace STM_WP\PostTypes;
/**
 * Set up post types
 *
 * @return void
 */
function setup() {
	$n = function ( $function ) {
		return __NAMESPACE__ . "\\$function";
	};
	// NOTE: Uncomment to activate post type
	add_action( 'init', $n( 'register_fieldwork' ) );
}
/**
 * Register the 'my_post_type' post type
 *
 * See https://github.com/johnbillion/extended-cpts for more information
 * on registering post types with the extended-cpts library.
 */
function register_fieldwork() {
	register_extended_post_type( 'fieldwork', array(
		'menu_icon' 		=> 'dashicons-images-alt2',
		'supports' 			=> array( 'title', 'editor' ),
		'admin_cols' => array(
			'themes' => array(
				'taxonomy' => 'stm-theme'
			)
		),		
		'names'				=> array(
								//Override the base names used for labels:
								'singular' => 'Fieldwork',
								'plural'   => 'Fieldworks',
								'slug'     => 'fieldwork'
								)
	) );
}