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
		$filter_subjects = array();
		$contains_children = false;
		
		$theme_images = array_map( function($array){
			//get the image ID
			$img_id 			= get_post_meta( $array['ID'], 'stm_media_id', true );
			//get the post subjects array
			$img_subjects		= get_the_terms( $array['ID'], 'stm-subject' );
			//get the post themes array
			$img_themes			= get_the_terms( $array['ID'], 'stm-theme' );
			
			
			$img_subjects	= json_decode(json_encode($img_subjects),true);
			$readable_names 	= json_decode(json_encode($img_themes),true);

			//themes
			//create array of readable names and add them to array that create filters
			/**
			 * Removing the filter by parent category because it causes conflicts if there are no children items
			 */
			// $readable_names = array_filter($readable_names,  function($array){
			// 	if( $array['parent'] ){
					
			// 		return $array;					
			// 	}
			// } );
			
		
			//Subjects
			//create array of readbale names
			if( !empty( $img_subjects ) ){
				//readable
				$readable_subject_names = array_column( $img_subjects, 'name' );
				//serialized
				$serialize_subjects = array_map( function( $array ){
					return sanitize_title( $array );
				}, $readable_subject_names );
				
			
			}
			

			
			//single out the approriate keys
			$readable_names = array_column( $readable_names, 'name' );
			$serialize_themes = array_map( function($array){
				return sanitize_title( $array );
			}, $readable_names );

			//return for $theme_images
			return $array = array(
				'img_title'			=> $array['post_title'],
				'img_content'		=> $array['post_content'],
				'img_id'			=> $array['ID'],
				'img_owner'			=> get_post_meta( $array['ID'], 'stm_owner', true),
				'img_year'			=> get_post_meta($array['ID'], 'stm_year', true),
				'img_id'			=> $img_id,
				'img_url'			=> wp_get_attachment_image_src( $img_id, 'large' ),
				
				'img_classes'		=> implode( ' ', $serialize_themes ),
				'img_themes'		=> $img_themes,
				'readable_names'	=> $readable_names,
				
				'subject_classes'	=> ( !empty( $serialize_subjects ) ) ? implode( ' ', $serialize_subjects ) : '',
				'subject_readable'	=> ( !empty( $readable_subject_names ) ) ? $readable_subject_names : '' 

				);
			
		}, $theme_images );
		
		//debug_to_console( $theme_images );
		
		//merge all the keywords together into a single array to be filtered
		foreach( $theme_images as $key => $img ){
			
			$filter_themes  	= array_merge( $filter_themes, $img['readable_names'] );
			
			if( !empty( $img['subject_readable'] ) ){
				$filter_subjects	= array_merge( $filter_subjects, $img['subject_readable'] );
				
			}
		}
		
		//now we reduce all elements to only unique values
		$filter_themes = array_unique( $filter_themes );
		$filter_subjects = array_unique( $filter_subjects );
		
		$image_count = count( $theme_images );
		
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
							    
							    <div id="stm-c-themes__scroll-to-description" class="cell medium-12 large-6 stm-c-themes__description small-order-2 medium-order-2 large-order-1">
							    	
							    	<?php if( !empty( the_content() ) ): ?>
								    	<div class="grid-x align-right">
											<a href="#stm-c-themes__scroll-to-images" data-smooth-scroll class="button small stm-c-themes__scroll hide-for-large flex-child-shrink">Scroll to Images</a>					    		
								    	</div>
							    	<?php endif; ?>

							    	<?php the_content(); ?>						    	
							    </div>
							    <div id="stm-c-themes__scroll-to-images" class="cell medium-12 large-6 stm-c-themes__container small-order-1 medium-order-1 large-order-2">
					    	
									<div class="reveal"  data-close-on-click="true" data-animation-in="fade-in" data-animation-out="fade-out" id="stm-c-reveal" data-reveal>
										<div class="stm-c-img__slider"></div>
									  <button class="close-button" data-close aria-label="Close modal" type="button">
									    <span aria-hidden="true">&times;</span>
									  </button>
									</div>	
								
							    	<div class="stm-c-img">
							    		<?php if( $filter_themes || $filter_subjects ): ?>
							    		<div class="stm-c-img__stat-options grid-x align-justify">
					                        <div class="stm-u-weight-bold stm-c-database-filter__count flex-child-grow">
					                            <span class="stm-c-img__remaining"><?php echo $image_count; ?></span> /
					                            <span class="stm-c-img__count"><?php echo $image_count; ?></span> <?php _e('Images', 'stm'); ?>
					                        </div>
					                        <a href="#stm-c-themes__scroll-to-description" data-smooth-scroll class="button small stm-c-themes__scroll hide-for-large flex-child-shrink">Scroll to Description</a>							    			
							    		</div>

				                        <?php endif; ?>

							    		<div class="stm-c-img__control-panel grid-x grid-margin-x">
										     <!-- checkbox dropdown -->
										     <?php if( $filter_themes ): ?>
											     <div 
											        class="jplist-checkbox-dropdown stm-c-img__dropdown cell small-12 large-6"
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
											  <?php endif; ?>
											  
											  <?php if( $filter_subjects ): ?>
											     <div 
											        class="jplist-checkbox-dropdown stm-c-img__dropdown cell small-12 large-6"
											        tabIndex = "0"
											        data-control-type="checkbox-dropdown" 
											        data-control-name="subject-checkbox-dropdown" 
											        data-control-action="filter"
											        data-no-selected-text="Filter by Subject:"
											        data-one-item-text="Filtered by {selected}"
											        data-many-items-text="{num} selected">
											        
											        <ul style="display:none;" class="stm-c-img__filter-list" >
											        	<?php if( $filter_subjects ) foreach( $filter_subjects as $key => $subject ):  
											        		$sanitized_class_name = sanitize_title( $subject );
											        	
											        	?>	
												           <li>
												              <input data-path=".<?php echo $sanitized_class_name; ?>" id="<?php echo $sanitized_class_name; ?>" type="checkbox"/>
												              <label for="<?php echo $sanitized_class_name; ?>"><?php echo $subject; ?></label>
												           </li>
											           <?php endforeach; ?>
											        </ul>
											     </div>											  
											  <?php endif; ?>
											  
							    		</div>
							    		
								    	<div class="grid-x grid-margin-x grid-margin-y small-up-1 medium-up-2 large-up-3 stm-c-img__grid">
								    		<?php 
								    		//loop through images and create display
								    		foreach( $theme_images as $key => $image ):
								    			//$json_img_meta = json_encode( $image, true );
								    		?>
								    			<div tabindex="0" style="background-image:url(<?php echo esc_url( $image['img_url'][0] ); ?>)" class="cell stm-c-img__block <?php echo $image['img_classes'] . ' ' . $image['subject_classes']; ?>" data-img='<?php echo htmlspecialchars(json_encode($image), ENT_QUOTES, 'UTF-8' ); ?>'>
								    				<div class="stm-c-img__preview-title">
								    					<div><?php echo $image['img_title']; ?></div>
								    					<span class="fa fa-expand" aria-hidden="true"></span>
								    				</div>
								    			</div>
								    			
								    		<?php endforeach; ?>
								    	
								    	</div>		
								        <!-- no results found -->
								        <div class="jplist-no-results">
								            <p>No results found</p>
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


