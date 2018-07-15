<?php
namespace STM_WP\Taxonomies;
/**
 * Set up taxonomies.
 *
 * @return void
 */
function setup() {
	$n = function ( $function ) {
		return __NAMESPACE__ . "\\$function";
	};
	// NOTE: Uncomment to activate taxonomy
	add_action( 'init', $n( 'register_stm_themes' ) );
	
	add_action( 'init', $n( 'register_stm_subjects' ) );	
}
/**
 * Register the my_taxo taxonomy and assign it to posts.
 *
 * See https://github.com/johnbillion/extended-taxos for more info on using the extended-taxos library
 */
function register_stm_themes() {
	register_extended_taxonomy( 'stm-theme', 'fieldwork', 
	array(
			'meta_box'	=> 'simple',
			'checked_ontop' => true,
			'allow_hierarchy'	=> true			
		),
	array(
        'singular' => 'Theme',
        'plural'   => 'Themes',
        'slug'     => 'themes'		
		)
	);
}

function register_stm_subjects() {
	register_extended_taxonomy( 'stm-subject', 'fieldwork', 
	array(
			'meta_box'			=> 'simple',
			'checked_ontop' 	=> true,
			'allow_hierarchy'	=> true
		),
	array(
        'singular' => 'Subject',
        'plural'   => 'Subjects',
        'slug'     => 'subjects'		
		)
	);
}

