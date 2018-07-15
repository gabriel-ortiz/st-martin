<?php

namespace STM_WP\WPUF;

/**
 * This file runs all the functions associated with the WPUF plugin
 *
 * @return void
 */
 
 function setup(){
    $n = function( $function ){
    return __NAMESPACE__ . "\\$function"; 
    };
    
    //add the hooks and filters here
    //add_action( "wpuf_add_post_after_insert", $n( "handle_wpuf_upload") );
 }
 
 function handle_wpuf_upload($post_id, $form_id, $form_settings, $form_vars){
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' ) ;     
    //check if the plugin is enabled - if so then upload the form data through the post array
    if( ! is_plugin_active('wp-user-frontend/wpuf.php') ){
        return false;
    }
    
    //set the post meta values from the form
    //update_post_meta( $post_id, 'stm_year', $_POST['post_title'] );    
    
    
 }
 