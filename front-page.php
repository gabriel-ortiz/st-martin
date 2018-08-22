<?php 
/**
 * The front page template
 */

get_header('home'); ?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php
			if ( 'page' == get_option( 'show_on_front' ) ) {
	
					$title       	 = get_the_title();   // Could use 'the_title()' but this allows for override
					$description 	 = $post->post_excerpt;
					$content	 	 = get_the_content();
	
				} else {
					// Fall backs if not front-page is set
					$thumb_url   = ''; // maybe set a default here?
					$title       = get_bloginfo( 'name' );
					$description = get_bloginfo( 'description' );
					$content     = 'No front page has been set to pull content from (see <code>Settings &gt; Reading</code>).';	
				}
			?>
			
		<?php endwhile; endif; ?>

  <div class="off-canvas-wrapper">
    <div class="off-canvas position-left" id="offCanvas" data-off-canvas>
      <!-- Your menu or Off-canvas content goes here -->
		<div>
			<div>
				<a href="<?php echo home_url(); ?>"><h3><?php bloginfo('name'); ?></h3></a>
			</div>      	
			<div>
			   <?php joints_off_canvas_nav(); ?>       		
			</div>
			<div style="padding: 1rem">
				<a href="<?php echo esc_url( site_url('/share-your-story/') ); ?>" target="_self" class="stm-c-nav__cta"><span class="fa fa-comments" style="margin-right: 1rem;" aria-hidden="true"></span><?php echo __( 'share your story', 'stm' ); ?></a>
			</div>			
		</div>

    </div>
    
    <div class="off-canvas-content" data-off-canvas-content>
      <!-- Your page content lives here -->
	 	<div class="content" data-sticky-container >
				
		 <!-- This navs will be applied to the topbar, above all content 
			  To see additional nav styles, visit the /parts directory -->
		 <?php get_template_part( 'parts/nav', 'offcanvas-topbar' ); ?>
			
			<div class="inner-content grid-x">
				
			    	<main class="cell small-10 medium-10 large-4 large-offset-1 stm-c-front-page__content stm-e-slide-right ">
			    		
			    		<?php echo $content; ?>
			    		
			    	</main>
			    
			</div> <!-- end #inner-content -->
			
			</div> <!-- end #content -->
	
	<?php get_footer('home'); ?>
     
    </div> <!-- end .off-canvas-content -->  
  
  </div> <!--end of off-canvas-wrapper-->

		


