<?php 

get_header(); ?>

<?php

	//get all the data for the page and art post type
	$thumb_url  	= get_the_post_thumbnail_url( $post, 'full' );
	$title      	= get_the_title();   // Could use 'the_title()' but this allows for override
	$description	= ( $post->post_excerpt ) ? get_the_excerpt(): ''; // Could use 'the_excerpt()' but this allows for override
	$content		= get_the_content();

?>

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
		
		<!--Header and menu-->
		 <?php get_template_part( 'parts/nav', 'offcanvas-topbar' ); ?>
		  
		<div class="stm-c-hero" style="background-image:url(<?php echo esc_url( $thumb_url ); ?>)" role="banner">
			
			<div class="stm-l-container">
				<div class="grid-x align-middle">
					<div class="cell medium-6" >
						<div role="heading" aria-level="1" class="stm-c-hero__title stm-e-slide-up"><?php echo $title; ?></div>
					</div> <!-- end article header -->
					<?php if( $description ): ?>
						<div class="cell medium-4">
							<div class="stm-c-hero__description"> <?php echo $description; ?></div>									
						</div>	
					<?php endif; ?>
				</div>
			
			</div>

		</div><!--end of hero container-->		  
		  
		<div class="site-content stm-l-container">
			<div class="inner-content grid-x align-center">
	
				<main class="main cell">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope itemtype="http://schema.org/WebPage">
		
						    <section id="the-content" class="entry-content grid-x grid-margin-x grid-padding-y grid-padding-x" itemprop="articleBody" role="main">
							    
							    <div class="cell">
							    	<?php the_content(); ?>						    	
							    </div>
							    
							</section> <!-- end article section -->
												
							<footer class="article-footer">
								 <?php wp_link_pages(); ?>
							</footer> <!-- end article footer -->						
		
											
						</article> <!-- end article -->
			    
			    	<?php endwhile; endif; ?>	
				</main>
	
			</div> <!-- end #inner-content -->
	
		</div> <!-- end #content -->	
	  
	 	 <?php get_footer(); ?>

	  
	</div>
</div>


