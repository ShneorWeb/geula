<?php get_header(); ?>	
    <div class="col-md-12"style="margin-top:34px;">	
    <?php
						$child = get_category($cat); 
						$parent = $child->parent;
						$parent_name = get_category($parent);
						$parent_name = $parent_name->name;
						$category_id = get_cat_ID( $parent_name );
						$category_link = get_category_link( $category_id );
						$this_category = get_category($cat);
     if (($category_id) != 0){	?>	
			<div class="page-header">	
				

				<div class="col-md-12 header_category">	

					
					  
						<?php 
					
						
						
						echo '<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> <a href="'.  esc_url( $category_link ) .'" style="font-size:18px; color:#7f8a94;">'.$parent_name .'</a>';
						?>
							

								<?php 
				    				$cat_image =  get_category_meta('image');
				    				$page_bg_image = wp_get_attachment_image($cat_image, 'category_image');
				    				$page_bg_image_url = $page_bg_image[0];
				    				$cat_name = get_category(get_query_var('cat'))->name;?>
				    				<div class="image_category" style="background-image:url(<?php echo $cat_image ?>); background-repeat:no-repeat;
background-size:contain;
background-position:right;">
				    			<?php
				    				echo '<div class="current_category_name">'. $cat_name.'</div>';
				    				 ?>
				    				 <div class="current_category_description"><?php echo category_description($cat->term_id);  ?>
				    		</div>
				    		</div>
				</div>
			</div>

			<div >
					<div class="col-md-12">
							<div class="search_by">
											<div style="float:right;">
													<span class="glyphicon glyphicon-search" aria-hidden="true"></span>  חיפוש
											</div>
											<div style="float:left;">
													<span style="padding-left:30px;">חדש לישן</span>   <span class="glyphicon glyphicon-menu-down" aria-hidden="true" style="font-size: 1.2em; color:black;"></span>
													<span style="padding-left:30px;">נושא  <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></span>
													<span style="padding-left:30px;">מוסר שיעור   <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></span>
											</div>


							</div>

					</div>

			</div>
				    	
			   	

		<?php $this_category = get_category($cat);
  if (get_category_children($this_category->cat_ID) != "") {?>
			<div class="categories">

				<ul class="product_list" style="padding:0px;">


					<?php
					if (is_category()|| is_single()) {
						$this_category = get_category($cat);
						
					$id = get_query_var('cat');
					$args = array(	 'parent' => $this_category->cat_ID, 'hide_empty' => 0 );


 
					$count = 0;
					
						foreach (get_categories($args) as $cat) : 

							?>


							<div class="col-sm-4 ">


							<?php $color = get_category_meta('color', get_term_by('slug', $cat->cat_name, 'category'));
													
													?>

									<li class="category_square"> 
										<div class="category_top_square" style="background:<?php echo $color; ?>">
											<span class="category_top_time"><a>12 שעות</a></span>
											<span class="glyphicon glyphicon-folder-open"></span>
										</div>
										<div class="category_square_content">
											<div class="category_square-format">
												<?php $values =  get_category_meta('type', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $value => $label) {
												    echo '<p><span>' . $value .'</span>' ;
												}
												$values = get_category_meta('format', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $value => $label) {
												    echo  '&nbsp; <span>' . $value . '</span></p>';
												}?>
											</div>
										

											<h3><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->cat_name; ?></a></h3>
											<div class="category_square_description">
													<!--<?php echo category_description($cat->term_id); ?>-->
													<?php $short_description = get_category_meta('short_description', get_term_by('slug', $cat->cat_name, 'category'));
														echo $short_description;
														?>
											</div>

											<div class="category_square_author">
												<?php
													
												 $values = get_category_meta('authors', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $user_id) {
												    $the_user = get_user_by('id', $user_id);
												    echo '<div class="category_square_avatar">'. get_avatar( $the_user, 60 ) . '</div>'; 

												    echo '<div class="author_des"><div class="category_square_author_name">' . $the_user->user_login . '</div></br>';
												    
												    echo '<div class="category_square_author_subject">' .get_the_author_meta('subject', $user_id ). '</div>';?>
											    	<div class="category_square_number">
														38 שיעורים בספריה
													</div></div>
													<?php } ?>

												
											
											
											</div><div style="clear:both;"></div>
											<div class="category_square_oval">
											<?php
												
											   			 echo '<span class="oval" style="background:'. $color .'; color:#ffffff;">חדש</span>';
													
													$values = get_category_meta('subject', get_term_by('slug', $cat->cat_name, 'category'));
													foreach ($values as $value => $label) {
											   			 echo '<span class="oval" style="border:1px solid #b2bac2; color:'. $color .';">' . $value . '</span>';
													}
													$values = get_category_meta('level', get_term_by('slug', $cat->cat_name, 'category'));
													foreach ($values as $value => $label) {
											   			 echo '<span class="oval" style="border:1px solid #b2bac2; color:#b2bac2;">' . $value . '</span>';
													}

											?>
											</div>
										</div>
									</li>
							</div>

							<?php $count = $count + 1;
						 ?>
							<?php if( $count % 3 == 0): ?>

							<div class="rows"></div>
							
							<?php endif; ?>

							

					

						<?php endforeach; } ?>
				</ul>
				</div>
				<?php } 

					else{
						if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article>

				    <div class="page-header">	
				    	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				    	<p>By <?php the_author(); ?> on <?php echo the_time('l, F jS, Y'); ?> in <?php the_category( ', ' );?>.  <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></p>
				    </div>				

					<?php the_excerpt(); ?>

				</article>
				<?php endwhile; endif; 
					}
				?>
			</div>
			
				
			<div class="col-md-3">	
				
				
				<?php get_sidebar(); ?>
			<!-- .sidebar -->			
			</div>
		<?php } else{ ?>
		<div class="page-header">
			<div class="col-md-12 header_category">	

					
					  
												

									<?php 
				    				$cat_image =  get_category_meta('image');
				    				$page_bg_image = wp_get_attachment_image($cat_image, 'category_image');
				    				$page_bg_image_url = $page_bg_image[0];
				    				$cat_name = get_category(get_query_var('cat'))->name;?>
				    				<div class="image_category" style="background-image:url(<?php echo $cat_image ?>); background-repeat:no-repeat; background-size:contain; background-position:right;">
				    				<?php
				    				echo '<div class="current_category_name">'. $cat_name.'</div>';
				    				 ?>
				    				 <div class="current_category_description"><?php echo category_description($cat->term_id);  ?>
				    		</div>	
				    				</div>
			</div>
		</div>
		<?php $this_category = get_category($cat);
  if (get_category_children($this_category->cat_ID) != "") {?>
			<div class="categories">

				<ul class="product_list" style="padding:0px;">


					<?php
					if (is_category()|| is_single()) {
						$this_category = get_category($cat);
						
					$id = get_query_var('cat');
					$args = array(	 'parent' => $this_category->cat_ID, 'hide_empty' => 0 );


 
					$count = 0;
					
						foreach (get_categories($args) as $cat) : 

							?>


							<div class="col-sm-12 ">
								<h3><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->cat_name; ?></a></h3>
								<?php $short_description = get_category_meta('short_description', get_term_by('slug', $cat->cat_name, 'category'));
														echo $short_description;
														?>

							

									
							</div>

							<?php $count = $count + 1;
						 ?>
							<?php if( $count % 3 == 0): ?>

							<div class="rows"></div>
							
							<?php endif; ?>

							

					

						<?php endforeach; } ?>
				</ul>
				</div>
				<?php } 

					else{
						if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article>

				    <div class="page-header">	
				    	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				    	<p>By <?php the_author(); ?> on <?php echo the_time('l, F jS, Y'); ?> in <?php the_category( ', ' );?>.  <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></p>
				    </div>				

					<?php the_excerpt(); ?>

				</article>
				<?php endwhile; endif; 
					}
				?>
			</div>

			
		<?php } ?>
		</div>

		

			
<?php get_footer(); ?>
				