<?php
/**
 * Functions and definitions
 */
// Useful global constants
define( 'STM_VERSION',      '0.1.0' );
define( 'STM_URL',          get_stylesheet_directory_uri() );
define( 'STM_TEMPLATE_URL', get_template_directory_uri() );
//define( 'STM_PATH',         get_template_directory() . '/' );
define( 'STM_PATH',         dirname( __FILE__ ) . '/' );
define( 'STM_INC',          STM_PATH . 'includes/' );
define( 'STM_ASSETS',       STM_TEMPLATE_URL . '/assets/' );
if ( ! defined( 'DAY_IN_SECONDS' ) ) {
    define( 'DAY_IN_SECONDS', 24 * 60 * 60 );
}		
	
//search and replace for changing plugin prefix
/**
find ./ -type f -exec sed -i -e 's/STM_WP/FWF/g' {} \;
find ./ -type f -exec sed -i -e 's/go_wp/fwf/g' {} \; 
find ./ -type f -exec sed -i 's/go_wp/fw/gI' {} \; 
find ./ -type f -exec sed -i -e 's/STM_WP/fw/g' {} \; 	
*/

// Theme support options
require_once(get_template_directory().'/functions/theme-support.php'); 

// WP Head and other cleanup functions
require_once(get_template_directory().'/functions/cleanup.php'); 

// Register scripts and stylesheets
require_once(get_template_directory().'/functions/enqueue-scripts.php'); 

// Register custom menus and menu walkers
require_once(get_template_directory().'/functions/menu.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/functions/sidebar.php'); 

// Makes WordPress comments suck less
require_once(get_template_directory().'/functions/comments.php'); 

// Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory().'/functions/page-navi.php'); 

// Adds support for multiple languages
require_once(get_template_directory().'/functions/translation/translation.php'); 

// Customize the WordPress login menu
require_once(get_template_directory().'/functions/login.php'); 

// Customize the WordPress admin
require_once(get_template_directory().'/functions/admin.php'); 

// Adds site styles to the WordPress editor
//require_once(get_template_directory().'/functions/editor-styles.php');


// Include lib classes
include( STM_INC . 'libraries/extended-cpts.php' );
include( STM_INC . 'libraries/extended-taxos.php' );
include( STM_INC . 'libraries/cmb2.addons.php' );
include( STM_INC . 'libraries/cmb2/init.php' );
include( STM_INC . 'libraries/cmb2-attached-posts/cmb2-attached-posts-field.php' );
include( STM_INC . 'libraries/cmb2-post-search-field/cmb2_post_search_field.php' );
include( STM_INC . 'libraries/cmb2-conditionals.php' );

// Include compartmentalized functions
//require_once STM_INC . 'core.php';
require_once STM_INC . 'post-types.php';
require_once STM_INC . 'shortcodes.php';
require_once STM_INC . 'taxonomies.php';

require_once STM_INC . 'metaboxes.php';
require_once STM_INC . 'wpuf.php';



// Run the setup functions
//STM_WP\Core\setup();
STM_WP\PostTypes\setup();
STM_WP\Shortcodes\setup();
STM_WP\Taxonomies\setup();
STM_WP\WPUF\setup();


// Adds site styles to the WordPress editor
// require_once(get_template_directory().'/functions/editor-styles.php'); 

// Remove 4.2 Emoji Support
// require_once(get_template_directory().'/functions/disable-emoji.php'); 

// Related post function - no need to rely on plugins
// require_once(get_template_directory().'/functions/related-posts.php'); 

// Use this as a template for custom post types
// require_once(get_template_directory().'/functions/custom-post-type.php');

/**
 * Converts and console logs data from PHP on the front end
 * 
 * @param $data to log, $title
 * 
 * @todo - set up hook for displaying on admin side
 *
 * @return array|mixed|string|\WP_Error
 */
function debug_to_console( $data, $title = null) {
	
	//check for title and localize arguments
	$fn_title = !empty( $title ) ? $title : 'From WP';
	$fn_data = $data;
	
	add_action( (is_admin() ? 'admin_footer' : 'wp_footer'), function() use ($fn_title, $fn_data){
		
	    if( is_array($fn_data) || is_object($fn_data) ) {
			echo "<script>
					if(console.debug!='undefined'){
						console.log('{$fn_title}:' , ". json_encode($fn_data) .");
					}</script>" ;
		} else {
			echo "<script>
					if(console.debug!='undefined'){	
						console.log('{$fn_title}: ".$fn_data."');
					}</script>" ;
		}		
		
	} );
}
