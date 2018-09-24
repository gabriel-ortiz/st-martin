<?php

namespace STM_WP\MetaBoxes\ThemeOptions;

/**
 * 
 * Theme page for the St. Martin's Project
 * 
 */
 
 function setup(){
    
    $n = function( $function ){
        return __NAMESPACE__ . '\\$function';
    };
 
		add_action( 'cmb2_admin_init', __NAMESPACE__ . '\\stm_register_theme_options_metabox'  );   

 }
 
 function stm_register_theme_options_metabox() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'           => 'stm_theme_options',
		'title'        => esc_html__( 'Theme Options', 'stm' ),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'stm_options', // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'myprefix' ), // Falls back to 'title' (above).
		// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'myprefix' ), // The text for the options-page save button. Defaults to 'Save'.
	) );

	/*
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */

	$cmb_options->add_field( array(
		'name' => __( 'English Menu Call to Action(CTA)', 'stm' ),
		'desc' => __( 'Selects the post for the Enlgish CTA in the menu', 'stm' ),
		'id'   => 'stm_en_menu_cta',
		'type' => 'post_search_text',
		'post_type' => 'page',
    	'select_type' => 'radio',
    	// Will replace any selection with selection from modal. Default is 'add'
    	'select_behavior' => 'replace',		
	) );

	$cmb_options->add_field( array(
		'name' => __( 'French Menu Call to Action(CTA)', 'stm' ),
		'desc' => __( 'Selects the post for the French CTA in the menu', 'stm' ),
		'id'   => 'stm_fr_menu_cta',
		'type' => 'post_search_text',
		'post_type' => 'page',
    	'select_type' => 'radio',
    	// Will replace any selection with selection from modal. Default is 'add'
    	'select_behavior' => 'replace',		
	) );

}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
function stm_get_option( $key = '', $default = false ) {
	if ( function_exists( 'cmb2_get_option' ) ) {
		// Use cmb2_get_option as it passes through some key filters.
		return cmb2_get_option( 'stm_options', $key, $default );
	}
	// Fallback to get_option if CMB2 is not loaded yet.
	$opts = get_option( 'stm_options', $default );
	$val = $default;
	if ( 'all' == $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}
	return $val;
}