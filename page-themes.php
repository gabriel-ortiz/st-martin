<?php 
/**
 * Template Name: Themes Template page
 */

get_header(); ?>

<?php

	//get all the data for the page and art post type
	$thumb_url  	= get_the_post_thumbnail_url( $post, 'large' );
	$title      	= get_the_title();   // Could use 'the_title()' but this allows for override
	$description	= ( $post->post_excerpt ) ? get_the_excerpt(): ''; // Could use 'the_excerpt()' but this allows for override
	$content		= get_the_content();
	$get_theme_tax	= get_post_meta( $post->ID, 'stm_tax_theme', true );
	$get_term_id	= wp_get_post_terms($post->ID, 'stm-theme');
	
	$args = array(
		'post_type' => 'fieldwork',
		'posts_per_page'	=> -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'stm-theme',
				'field'    => 'term_id',
				'terms'    => $get_term_id[0]->term_id,
				'include_children'	=> true
			),
		),
	);
	
	$theme_images = new WP_Query( $args );
	
	//debug_to_console( $theme_images->posts );
	
	//check to make sure we have posts
	if( $theme_images->have_posts() ){
		//turn object into array
		$theme_images = json_decode(json_encode($theme_images->posts), true);
		
		$filter_themes = array();
		
		$theme_images = array_map( function($array){
			//get the image ID
			$img_id 			= get_post_meta( $array['ID'], 'stm_media_id', true );
			//get the post subjects array
			$img_subjects		= get_the_terms( $array['ID'], 'stm-subject' );
			//get the post themes array
			$img_themes			= get_the_terms( $array['ID'], 'stm-theme' );
			
			$img_themes = json_decode(json_encode($img_themes),true);

			
			//create array of readable names and add them to array that create filters
			$readable_names = array_filter($img_themes,  function($array){
				if( $array['parent'] ){
					return $array;					
				}
			} );
		
			
			//single out the approriate keys
			$readable_names = array_column( $readable_names, 'name' );
			$serialize_themes = array_map( function($array){
				return sanitize_title( $array );
			}, $readable_names );

			return $array = array(
				'img_title'	=> $array['post_title'],
				'img_content'	=> $array['post_content'],
				'img_id'		=> $array['ID'],
				'img_owner'	=> get_post_meta( $array['ID'], 'stm_owner', true),
				'img_year'		=> get_post_meta($array['ID'], 'stm_year', true),
				'img_id'		=> $img_id,
				'img_url'		=> wp_get_attachment_image_src( $img_id, 'large' ),
				'img_subject'	=> $img_subjects, //data hasn't been set for this yet
				'img_classes'	=> implode( ' ', $serialize_themes ),
				'img_themes'	=> $img_themes,
				'readable_names'=> $readable_names	

				);
			
		}, $theme_images );
		
		//debug_to_console( $theme_images );
		
		//merge all the keywords together into a single array to be filtered
		foreach( $theme_images as $key => $img ){
			$filter_themes  = array_merge( $filter_themes, $img['readable_names'] );
		}
		//now we reduce all elements to only unique values
		$filter_themes = array_unique( $filter_themes );
	}

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
		</div>

	</div>
	<div class="off-canvas-content" data-off-canvas-content>
		
		<!--Header and menu-->
		 <?php get_template_part( 'parts/nav', 'offcanvas-topbar' ); ?>
		  
		<div class="stm-c-hero" style="background-image:url(<?php echo esc_url( $thumb_url ); ?>)" role="banner">
			
			<div class="grid-container">
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
		  
		<div class="site-content grid-container">
			<div class="inner-content grid-x align-center">
	
				<main class="main cell">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope itemtype="http://schema.org/WebPage">
		
						    <section id="the-content" class="entry-content grid-x grid-margin-x grid-padding-y grid-padding-x" itemprop="articleBody" role="main">
							    
							    <div class="cell medium-6">
							    	<?php the_content(); ?>						    	
							    </div>
							    <div class="cell medium-6">
			    	
									<div class="reveal small"  data-close-on-click="true" data-animation-in="fade-in" data-animation-out="fade-out" id="stm-c-reveal" data-reveal>
										<h1>Image Slideshow</h1>

										<div class="stm-c-img__slider">image sliders will go here</div>
										
									  <button class="close-button" data-close aria-label="Close modal" type="button">
									    <span aria-hidden="true">&times;</span>
									  </button>
									</div>	
								
							    	<div class="stm-c-img">
							    		<div class="stm-c-img__control-panel">
										     <!-- checkbox dropdown -->
										     <div 
										        class="jplist-checkbox-dropdown stm-c-img__dropdown"
										        tabIndex = "0"
										        data-control-type="checkbox-dropdown" 
										        data-control-name="category-checkbox-dropdown" 
										        data-control-action="filter"
										        data-no-selected-text="Filter by category:"
										        data-one-item-text="Filtered by {selected}"
										        data-many-items-text="{num} selected">
										        
										        <ul style="display:none;" class="stm-c-img__filter-list" >
										        	<?php if( $filter_themes ) foreach( $filter_themes as $key => $theme ):  
										        		$sanitized_class_name = sanitize_title( $theme );
										        	
										        	?>	
											           <li>
											              <input data-path=".<?php echo $sanitized_class_name; ?>" id="<?php echo $sanitized_class_name; ?>" type="checkbox"/>
											              <label for="<?php echo $sanitized_class_name; ?>"><?php echo $theme; ?></label>
											           </li>
										           <?php endforeach; ?>
										        </ul>
										     </div>	
							    		</div>
							    		
								    	<div class="grid-x small-up-2 medium-up-3 stm-c-img__grid">
								    		<?php 
								    		//loop through images and create display
								    		foreach( $theme_images as $key => $image ):
								    			//$json_img_meta = json_encode( $image, true );
								    		?>
								    			<div class="cell stm-c-img__block <?php echo $image['img_classes']; ?>" data-img='<?php echo htmlspecialchars(json_encode($image), ENT_QUOTES, 'UTF-8' ); ?>'>
								    					<?php echo wp_get_attachment_image( $image['img_id'], 'thumbnail', '', array( "class" => 'stm-c-img__preview', 'tabIndex' => 0 ) ) ?> 
								    			</div>
								    			
								    		<?php endforeach; ?>
								    	</div>							    		
							    	</div>
							    	

							    							    	
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


