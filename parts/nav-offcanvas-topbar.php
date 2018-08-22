<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://jointswp.com/docs/off-canvas-menu/
 */
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
				<div class="show-for-large stm-c-nav__cta_container">
					<a href="<?php echo esc_url( site_url('/share-your-story/') ); ?>" target="_self" class="stm-c-nav__cta"><span class="fa fa-comments" style="margin-right: 1rem;" aria-hidden="true"></span><?php echo __( 'share your story', 'stm' ); ?></a>
				</div>				
				
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
