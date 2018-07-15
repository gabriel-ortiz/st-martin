<?php
namespace STM_WP\MetaBoxes\PageThemes;
/**
 * Metaboxes that appear on more than one post type around the site
 *
 * @return void
 */
function setup() {
	$n = function ( $function ) {
		return __NAMESPACE__ . "\\$function";
	};
	// NOTE: Uncomment to activate metabox
	add_action( 'cmb2_init',  $n( 'stm_page_themes' ) );
	

}
/**
 * Example metabox
 * See https://github.com/WebDevStudios/CMB2/wiki/Field-Types for
 * more information on creating metaboxes and field types.
 */
function stm_page_themes() {
	$prefix = 'stm_';
	$cmb = new_cmb2_box( array(
		'id'        	=> $prefix . 'page_themes',
		'title'     	=> __( 'Select Theme for image display', 'stm' ),
		'priority'  	=> 'high',
		'show_names'	=> true,
		'show_on'      => array( 'key' => 'page-template', 'value' => 'page-themes.php' ),		
		'object_types'	=> array( 'page' )
	) );
	
	$cmb->add_field( array(
		'name'           => __('Select a theme Collection', 'stm'),
		'desc'           => __('Choose the corresponding theme of images for this page', 'stm'),
		'id'             => $prefix . 'tax_theme',
		'taxonomy'       => 'stm-theme', // Enter Taxonomy Slug
		'type'           => 'taxonomy_radio_hierarchical',
		// Optional :
		'text'           => array(
			'no_terms_text' => 'Sorry, no terms could be found.' // Change default text. Default: "No terms"
		),
		'remove_default' => 'true' // Removes the default metabox provided by WP core. Pending release as of Aug-10-16
	) );
	
}
