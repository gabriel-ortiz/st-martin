<?php
function site_scripts() {
  
  global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
  
  wp_register_script( 
        'slick',   
        get_template_directory_uri() . '/assets/scripts/vendors/slick.min.js', 
        array(), 
        '', 
        true
    );
  
  //enqueue jplists
	//register scripts for filtering
	wp_register_script(
		'jplist',
		get_template_directory_uri() . '/assets/scripts/vendors/jplist.js',
		array('jquery'),
		'',
		true
	);  
      
  // Adding scripts file in the footer
  wp_enqueue_script( 
        'site-js',
        get_template_directory_uri() . '/assets/scripts/scripts.js', 
        array( 'jquery', 'slick', 'jplist' ), 
        filemtime(get_template_directory() . '/assets/scripts/js'), 
        true 
    );
    
  //localize some JS Assets
	wp_localize_script( 'site-js', 'STM', array(
		'site_url' 	=> site_url('/'),
		'assets' 	=> STM_ASSETS,
		'ajax_url' 	=> admin_url( 'admin-ajax.php' ),
		'nonce'    	=> wp_create_nonce( 'stm_nonce' ),
	) );  
  
  // Register main stylesheet
  wp_enqueue_style( 
        'site-css', 
        get_template_directory_uri() . '/assets/styles/style.css', 
        array(), 
        filemtime(get_template_directory() . '/assets/styles/scss'),
        'all' 
    );
    
    // Register main stylesheet
  wp_enqueue_style( 
        'site-css', 
        get_template_directory_uri() . '/assets/styles/style.css', 
        array(), 
        filemtime(get_template_directory() . '/assets/styles/scss'),
        'all' 
    );
    
    
  wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.0.10/css/all.css');   
  
  // Comment reply script for threaded comments
  if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
    wp_enqueue_script( 'comment-reply' );
    }
}
add_action('wp_enqueue_scripts', 'site_scripts', 999);

function admin_scripts(){
    wp_enqueue_script(
        'cmb2-conditionals', 
        get_template_directory_uri() . '/includes/libraries/js-cmb2-conditionals.js', 
        array( 'jquery' ),
        '',
        true 
    );

}

add_action( 'admin_enqueue_scripts', 'admin_scripts' );