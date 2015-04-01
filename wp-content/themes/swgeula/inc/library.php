<div class="page-header library-page">
    		<div class="header_category">	

					   

                        <?php 
                                    $cat_image =  get_category_meta('image');
                                    $page_bg_image = wp_get_attachment_image($cat_image, 'category_image');
                                    $page_bg_image_url = $page_bg_image[0];
                                    $cat_name = get_category(get_query_var('cat'))->name;

                        ?>

                        <div class="image_category">
                            
                            <div class="texts">
                                <i class="icon-library-icon"></i>
                                <div class="name_and_sedc">
                                    <div class="current_category_name">
                                             <h1><?php the_field('library_title', 'option'); ?></h1>

                                    </div>
                                    <div class="current_category_description">
                                        <p><?php the_field('library_sub_title', 'option'); ?></p>
                                    </div>
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


<?php
 $this_category = get_category($cat);
 if (get_category_children($this_category->cat_ID) != "") {
     if (is_category()|| is_single()) {
		$this_category = get_category($cat);
						
        $id = get_query_var('cat');
        $args = array(	 
            'parent' => $this_category->cat_ID,
            'hide_empty' => 0
        );
         
        $count = 0;
					
		foreach (get_categories($args) as $cat) : ?>
							
          <div class="cat_sing" style="opacity:0">
            <div id="spinner"></div>
            <div class="header_part">
               <a href="<?php echo get_category_link($cat->term_id); ?>" class="texts_cont">
                 <div>
                   <h2><?php echo $cat->cat_name; ?></h2>
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
                              
            <div class="bottom_part">
              <?php
				$cat_image =  get_category_meta('image', get_term_by('slug', $cat->cat_name, 'category'));
                $page_bg_image = wp_get_attachment_image($cat_image, 'category_image');
                $page_bg_image_url = $page_bg_image[0];
                $cat_name = get_category(get_query_var('cat'))->name;?>
				<div class="library_image_category" style="background-image:url(<?php echo $cat_image ?>);">
                    <ul class="product_list row">
							
									
					<?php 
						
					$id = get_query_var('cat');
					$args = array(	 
                        'child_of' => $cat->cat_ID,
                        'hide_empty' => 0,
                        'number' => 4,
                    );

					$count = 0;
					
					foreach (get_categories($args) as $cat) : 

                      $color = get_category_meta('color', get_term_by('slug', $cat->cat_name, 'category'));
        			  $is_subject_category = get_category_meta('subject_category', get_term_by('slug', $cat->cat_name, 'category'));
                        if(!$is_subject_category) : 		
					?>
                 
					   <div class="category_single col-lg-4 col-md-6 col-sm-6 col-xs-6 ">

                                <li class="category_square"> 
                                        
										<div class="category_top_square" style="background:<?php echo $color; ?>">
                                            <span class="category_top_time">
                                                
                                                <!-- 
                                                    TODO: get the time of category dynamcly
                                                -->
                                                
                                                12 שעות
                                            </span>
											<i class="icon-type-of-lesson-icon-1"></i>
										</div>
                                        
										<div class="category_square_content">
                                            
											<h3 class="category_square-format">
												<?php $values =  get_category_meta('type', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $value => $label) {
												    echo '' . $value .'' ;
												}
												$values = get_category_meta('format', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $value => $label) {
												    echo  '&nbsp;' . $value . '';
												}?>
											</h3>
                                            
										

											<h2>
                                                <a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->cat_name; ?></a>
                                            </h2>
                                            
											<div class="category_square_description">
													<?php
                                                    /*echo category_description($cat->term_id); */
                                                    ?>
												<p>
                                                <?php $short_description = get_category_meta('short_description', get_term_by('slug', $cat->cat_name, 'category'));
                                                    echo substr( $short_description, 0,180); 
                                                    echo "...";
                                                    ?>
                                                </p>
											</div>

											<div class="category_square_author">
												<?php
													
												 $values = get_category_meta('authors', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $user_id) {
												    $the_user = get_user_by('id', $user_id);
                                                    //TODO : image from ofer function
												    echo '<div class="category_square_avatar">'. get_avatar( $the_user, 60 ) . '</div>'; 

												    echo '<div class="author_des"><div class="category_square_author_name"><h4>' . $the_user->display_name . '</h4></div>';
												    
												    echo '<div class="category_square_author_subject">' .get_the_author_meta('subject', $user_id ). '</div>';?>
                                                
											    	<div class="category_square_number">
														 <!-- 
                                                        TODO: get the number of posts dynamcly
                                                        -->
                                                        38 שיעורים בספריה
													</div><?php } ?>
											</div>
													

											</div>
                                        
		<div class="category_square_oval">
                                               
             <?php
                $cat_slug =  $cat->slug;
                $cat_parent_id = $cat->parent;
                
                $cat_parent_object = get_category($cat_parent_id);
                $cat_parent_slug = $cat_parent_object->slug;
                $cat_parent_name = get_cat_name( $cat_parent_id );
                
                $cat_grandparent_id = $cat_parent_object->parent;
                $cat_grandparent_object = get_category($cat_grandparent_id);
                $cat_grandparent_slug = $cat_grandparent_object->slug;
                        
                /*echo '<span class="oval" style="background:'. $color .'; color:#ffffff; border:1px solid #' . $color .';">חדש</span>';*/
?>
                    
       <a href="<?php echo $cat_grandparent_slug.'?select_parent='.$cat_parent_id; ?>" style="color:<?php echo $color; ?>" class="category_square_oval_submit"><?php echo $cat_parent_name; ?></a>
                     

          <?php $values = get_category_meta('level', get_term_by('slug', $cat->cat_name, 'category'));
                foreach ($values as $value => $label) {
                    echo '<span class="oval">' . $value . '</span>';
                                                        }

                                                    ?>
            
        </div>
		
                    
                                </li>
                    </div><!-- category_single -->
                
            <?php endif;endforeach  ?>
										

					</ul>		
	    		</div>
    		</div><!-- bootm part -->
        </div><!-- cat_sing -->
							
    <?php
      endforeach; } 
        }else{
      if ( have_posts() ) : while ( have_posts() ) : the_post(); 
     endwhile; endif; }
    ?>
</div>