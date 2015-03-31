<div class="page-header library-page">
    		<div class="header_category">	

					   

                        <?php 
                                    $cat_image =  get_category_meta('image');
                                    $page_bg_image = wp_get_attachment_image($cat_image, 'category_image');
                                    $page_bg_image_url = $page_bg_image[0];
                                    $cat_name = get_category(get_query_var('cat'))->name;

                        ?>

                        <div class="image_category" style="background-image:url(<?php echo $cat_image ?>);">
                            
                            <div class="texts">
                                <i class="icon-library-icon"></i>
                                <div class="current_category_name">
                                         <h1><?php the_field('library_title', 'option'); ?></h1>
                                        
                                </div>

                                <div class="current_category_description">
                                    <p><?php the_field('library_sub_title', 'option'); ?></p>
                                </div>
                            </div>
                             <div class="stages">
                                <?php the_field('stages', 'option'); ?>
                            </div>

                        </div>
				</div><!-- header_category -->
		      </div><!-- page-header -->
	       </div><!-- archive_cont -->
        </div><!-- row -->
    </div><!-- container -->
</div><!-- content -->


		<?php $this_category = get_category($cat);
  if (get_category_children($this_category->cat_ID) != "") {?>
			


					<?php
					if (is_category()|| is_single()) {
						$this_category = get_category($cat);
						
                        $id = get_query_var('cat');
                        $args = array(	 'parent' => $this_category->cat_ID, 'hide_empty' => 0 );

					    $count = 0;
					
						foreach (get_categories($args) as $cat) : ?>
							
                            <div class="cat_sing">
                                
                                <div class="header_part">
                                    <a href="<?php echo get_category_link($cat->term_id); ?>" class="texts_cont">
                                        <div>
                                             <h2>
                                               <?php echo $cat->cat_name; ?>
                                              </h2>
                                              <p>        
                                                <?php
                                                    $short_description = get_category_meta('short_description', get_term_by('slug', $cat->cat_name, 'category'));
                                                    echo $short_description;
                                                  ?>
                                               </p>
                                        </div>
                                    </a>
                                
                                    <a href="<?php echo get_category_link($cat->term_id); ?>" class="btn_cont">
                                       <button type="button">הצג הכל</button>
                                    </a>
                                  
                                    
                                
                                </div>
                              
                              
	
                    <div class="bottom_part"><?php
							$cat_image =  get_category_meta('image', get_term_by('slug', $cat->cat_name, 'category'));
				    				$page_bg_image = wp_get_attachment_image($cat_image, 'category_image');
				    				$page_bg_image_url = $page_bg_image[0];
				    				$cat_name = get_category(get_query_var('cat'))->name;?>
				    				<div class="image_category" style="background-image:url(<?php echo $cat_image ?>); background-repeat:no-repeat; background-size:contain; background-position:right;">


										
							
							<div>
									
									<?php 
						
					$id = get_query_var('cat');
					$args = array(	 'parent' => $cat->cat_ID, 'hide_empty' => 0, 'number' => 3, );


 
					$count = 0;
					
						foreach (get_categories($args) as $cat) : 


							
							$color = get_category_meta('color', get_term_by('slug', $cat->cat_name, 'category'));
													
													?>
									<div class="col-md-4 col-sm-12 col-xs-12 ">
									<li class="category_square"> 
										<div class="category_top_square" style="background:<?php echo $color; ?>">
											<p><span class="category_top_time">12 שעות</span>
											<span class="glyphicon glyphicon-folder-open" style="padding-right:20px;"></span></p>
										</div>
										<div class="category_square_content"><h5>
											<div class="category_square-format">
												<?php $values =  get_category_meta('type', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $value => $label) {
												    echo '<p><span>' . $value .'</span>' ;
												}
												$values = get_category_meta('format', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $value => $label) {
												    echo  '&nbsp; <span>' . $value . '</span></p>';
												}?>
											</div></h5>
										

											<h3><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->cat_name; ?></a></h3>
											<div class="category_square_description">
													<!--<?php echo category_description($cat->term_id); ?>-->
													<p><?php $short_description = get_category_meta('short_description', get_term_by('slug', $cat->cat_name, 'category'));
														echo $short_description;
														?></p>
											</div>

											<div class="category_square_author">
												<?php
													
												 $values = get_category_meta('authors', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $user_id) {
												    $the_user = get_user_by('id', $user_id);
												    echo '<div class="category_square_avatar">'. get_avatar( $the_user, 60 ) . '</div>'; 

												    echo '<div class="author_des"><div class="category_square_author_name"><h4>' . $the_user->user_login . '</h4></div></br>';
												    
												    echo '<div class="category_square_author_subject"><h4><small>' .get_the_author_meta('subject', $user_id ). '</small></h4></div>';?>
											    	<div class="category_square_number">
														<h5><small>38 שיעורים בספריה</small></h5>
													</div></div>
													<?php } ?>

												
											
											
											</div><div style="clear:both;"></div>
											<div class="category_square_oval"><h4>
											<?php
												
											   			 echo '<span class="oval" style="background:'. $color .'; color:#ffffff; border:1px solid #' . $color .';">חדש</span>';
													
													$values = get_category_meta('subject', get_term_by('slug', $cat->cat_name, 'category'));
													foreach ($values as $value => $label) {
											   			 echo '<span class="oval" style="border:1px solid #b2bac2; color:'. $color .';">' . $value . '</span>';
													}
													$values = get_category_meta('level', get_term_by('slug', $cat->cat_name, 'category'));
													foreach ($values as $value => $label) {
											   			 echo '<span class="oval" style="border:1px solid #b2bac2; color:#b2bac2;">' . $value . '</span>';
													}

											?></h4>
											</div></li></div><?php endforeach;  ?>
										</div>

							
				    		</div>
				    		</div>
                            </div><!-- cat_sing -->
							
							

												

					

						<?php endforeach; } ?>
				
				<div class="container-fluid">
							<div class="row">
							<div class="col-sm-12 ">
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