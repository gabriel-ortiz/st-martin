<?php
namespace STM_WP\Shortcodes;
/**
 * Set up shortcodes
 *
 * @return void
 */
function setup() {
	$n = function ( $function ) {
		return __NAMESPACE__ . "\\$function";
	};
	// NOTE: Uncomment to activate shortcode
	add_shortcode( 'example_shortcode', $n( 'example_shortcode' ) );
	add_shortcode( 'button', $n( 'button_fn' ) );
}
 /**
  * Create an example shortcode
  *
  * @param $attributes array List of attributes from the given shortcode
  *
  * @return mixed HTML output for the shortcode
  */
 function example_shortcode( $attributes, $content = null ) {
 	$data = shortcode_atts( array(
 		'class' => 'h2',
 		'text'	=> 'Hello World',
 	), $attributes );
 	$html = '<div class="' . $data['class'] . '">' . $data['text'] . '</div>';
 	return $html;
 }
 
 /**
 * Create a button CTA shortcode
 *
 * @param $attributes array List of attributes from the given shortcode
 *
 * @return mixed HTML output for the shortcode
 */
function button_fn( $attributes = false, $content = null ) {
	$data = shortcode_atts( array(
		'url'   => '',
		'size'  => '', // small, default ""
		'style' => '', // solid, default ""
	), $attributes );
	if ( ! $data['url'] ) {
		return null; // will return nothing if no url is specified
	}
	$classes = '';
	// @todo error trapping could be built-in here to check for valid class names
	if ( array_key_exists( 'size', $data ) && $data['size'] ) {
		$classes  = 'ccl-is-' . esc_attr( $data['size'] ) . ' ';
	}
	if ( array_key_exists( 'style', $data ) && $data['style'] ) {
		$classes .= 'ccl-is-' . esc_attr( $data['style'] );
	}
	$html = '<a href="' . esc_url( $data['url'] ) . '" class="ccl-b-btn ' . $classes . '">' . $content . '</a>';
	return $html;
}