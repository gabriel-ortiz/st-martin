<?php

namespace STM_WP\Translations;

/**
 * 
 * Set up defaults and run hooks and filters on setup
 * 
 */
 
 function setup(){
    
    $n = function( $function ){
        return __NAMESPACE__ . '\\$function';
    };
    
    //add_filter( 'pll_get_taxonomies', __NAMESPACE__ .'\\add_tax_to_pll', 10, 2 );
 }
 

 
function add_tax_to_pll( $taxonomies, $is_settings ) {
    
    //check to make sure the plugin is activiated and constant is defined
    if( defined( POLYLANG_BASENAME ) ){
        
        if ( $is_settings ) {
            unset( $taxonomies['stm-theme'] );
        } else {
            $taxonomies['stm-theme'] = 'stm-theme';
        }
        return $taxonomies;        
        
    }
    
}