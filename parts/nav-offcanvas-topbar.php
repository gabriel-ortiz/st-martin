<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://jointswp.com/docs/off-canvas-menu/
 */

//get the language CTA
$lang_cta = '';
if( class_exists('Polylang') ){
	if( strpos( pll_current_language(), 'fr' ) !== false ){
		$lang_cta =  STM_WP\MetaBoxes\ThemeOptions\stm_get_option('stm_fr_menu_cta');
	}else{
		$lang_cta =  STM_WP\MetaBoxes\ThemeOptions\stm_get_option('stm_en_menu_cta');		
	}
}

?>


<header class="header" role="banner" >
	<div  class="stm-c-nav sticky" data-sticky data-options="marginTop:0;stickTo:top;" style="width:100%">
		<div class="top-bar" id="top-bar-menu" >
			<div class="top-bar-left float-left show-for-large">
				<div class="menu">
					<div class="stm-c-nav__title">
						<a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
					</div>
					<div class="stm-c-nav__menu flex-child-grow">
						<?php joints_top_nav(); ?>	
					</div>
				<?php if( $lang_cta ): ?>	
					
					<div class="show-for-large stm-c-nav__cta_container">
						<a href="<?php echo esc_url( get_permalink( $lang_cta ) ); ?>" target="_self" class="stm-c-nav__cta"><span class="fa fa-comments" style="margin-right: 1rem;" aria-hidden="true"></span><?php echo get_the_title( $lang_cta ); ?></a>
					</div>	
					
				<?php endif; ?>
				
				</div>
			
			</div>
			

			
			
			<div class="hide-for-large stm-c-nav--mobile">
				<ul class="menu">
					<!-- <li><button class="menu-icon" type="button" data-toggle="off-canvas"></button></li> -->
					<li><a data-toggle="offCanvas"><span class="fa fa-bars" aria-hidden="true"></span> <?php _e( 'Menu', 'stm' ); ?></a></li>
				</ul>
			</div>
		</div>	
	</div>
</header> <!-- end .header -->	
