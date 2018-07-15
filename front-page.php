<?php 
/**
 * The front page template
 */

get_header('home'); ?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php
			if ( 'page' == get_option( 'show_on_front' ) ) {
	
					$thumb_url   	 = get_the_post_thumbnail_url( $post, 'large' );
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
    </div>
    
    <div class="off-canvas-content" data-off-canvas-content>
      <!-- Your page content lives here -->
	 	<div class="content stm-c-front-page" data-sticky-container style="background-image:url(<?php echo $thumb_url; ?>)">
				
		 <!-- This navs will be applied to the topbar, above all content 
			  To see additional nav styles, visit the /parts directory -->
		 <?php get_template_part( 'parts/nav', 'offcanvas-topbar' ); ?>
			
			<div class="inner-content grid-x">
				
			    	<main class="cell small-4 large-offset-1 stm-c-front-page__content stm-e-slide-right ">
			    		
			    		<?php echo $content; ?>
			    		
			    	</main>
			    
			</div> <!-- end #inner-content -->
			
			</div> <!-- end #content -->
	
	<?php get_footer('home'); ?>
     
    </div> <!-- end .off-canvas-content -->  
  
  </div> <!--end of off-canvas-wrapper-->

		


