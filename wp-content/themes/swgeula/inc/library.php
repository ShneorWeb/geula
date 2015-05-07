<div class="page-header library-page">
    		
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
        $cats1 = get_categories($args);
					
		foreach ($cats1 as $cat) : ?>
							
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
					$cats = get_categories($args);

          //sort categories by last updated post:
          $arrCatsArray = array();
          foreach ($cats as $cat2) : 

            $post_args = array(
              'post_type' => 'post',
              'post_status' => 'publish',
              'orderby' => 'post_date',
              'order' => 'DESC',
              'posts_per_page' => 1,
              'cat' => (int)$cat2->cat_ID,            
            );    
            
            $the_query = new WP_Query( $post_args);

            if ( $the_query->have_posts() ) :

              while ( $the_query->have_posts() ) { $the_query->the_post();

                $arrCatsArray[] = array(
                  'date' => get_the_time('U'),
                  'term_id' => $cat2->term_id,              
                  'cat_ID' => $cat2->cat_ID,          
                  'cat_name' => $cat2->cat_name,
                  'slug' => $cat2->slug,
                  'parent' => $cat2->parent 
                );
              }

            else :
                $arrCatsArray[] = array(
                  'date' => strtotime("-1 year", time()),
                  'term_id' => $cat2->term_id,  
                  'cat_ID' => $cat2->cat_ID,                      
                  'cat_name' => $cat2->cat_name,
                  'slug' => $cat2->slug,
                  'parent' => $cat2->parent 
                );  
            endif;

          endforeach;

          usort($arrCatsArray, "compareDates");


					foreach ($arrCatsArray as $cat2) :

                $cat2 = (object)$cat2; 

                $color = get_category_meta('color', get_term_by('slug', $cat2->cat_name, 'category'));
        			  $is_subject_category = get_category_meta('subject_category', get_term_by('slug', $cat2->slug, 'category'));
                if(!$is_subject_category) : 		
					?>
                 
					   <div class="category_single col-lg-4 col-md-6 col-sm-6 col-xs-6 ">

                                <li class="category_square"> 
                                        
										<div class="category_top_square" style="background:<?php echo $color; ?>">
                                            <span class="category_top_time">
                                                
                                                <?php echo formatHoursMinutes(getTotalVideoDurationCat($cat2->cat_ID));?>

                                            </span>
                                            <!-- 
                                                    TODO: get the icon of category dynamcly
                                                -->
											<i class="icon-type-of-lesson-icon-1"></i>
										</div>
                                        
										<div class="category_square_content">
                                            
											<h3 class="category_square-format">
												<?php $values =  get_category_meta('type', get_term_by('slug', $cat2->cat_name, 'category'));
												foreach ($values as $value => $label) {
												    echo '' . $value .'' ;
												}
												$values = get_category_meta('format', get_term_by('slug', $cat2->cat_name, 'category'));
												foreach ($values as $value => $label) {
												    echo  '&nbsp;' . $value . '';
												}?>
											</h3>
                                            
										

											<h2>
                                                <a href="<?php echo get_category_link($cat2->term_id); ?>"><?php echo $cat2->cat_name; ?></a>
                                            </h2>
                                            
											<div class="category_square_description">
													<?php
                                                    /*echo category_description($cat2->term_id); */
                                                    ?>
												<p>
                                                <?php $short_description = get_category_meta('short_description', get_term_by('slug', $cat2->cat_name, 'category'));
                                                    echo substr( $short_description, 0,180); 
                                                    echo "...";
                                                    ?>
                                                </p>
											</div>

											<div class="category_square_author">
												<?php
													
												 $values = get_category_meta('authors', get_term_by('slug', $cat2->slug, 'category'));
												foreach ($values as $user_id) {
												    $the_user = get_user_by('id', $user_id);
                                                    //TODO : image from ofer function
												    echo '<div class="category_square_avatar">'. get_avatar( $the_user->ID, 96 ) . '</div>'; 

												    echo '<div class="author_des"><div class="category_square_author_name"><h4>' . $the_user->display_name . '</h4></div>';
												    
												    echo '<div class="category_square_author_subject">' .get_the_author_meta('subject', $user_id ). '</div>';?>
                                                
											    	<div class="category_square_number">
														<?php 
                                                            $user_post_count = count_user_posts( $user_id );
                                                            echo $user_post_count . ' ' . __('lessons in the library', 'swgeula');                                                            
                                                        ?>                                                        
													</div><?php } ?>
											</div>
													

											</div>
                                        
		<div class="category_square_oval">
                                               
             <?php
                $cat2_slug =  $cat2->slug;
                $cat_parent_id = $cat2->parent;
                
                $cat_parent_object = get_category($cat_parent_id);
                $cat_parent_slug = $cat_parent_object->slug;
                $cat_parent_name = $cat_parent_object->name;
                
                $cat_grandparent_id = $cat_parent_object->parent;
                $cat_grandparent_object = get_category($cat_grandparent_id);
                $cat_grandparent_slug = $cat_grandparent_object->slug;
                        
                /*echo '<span class="oval" style="background:'. $color .'; color:#ffffff; border:1px solid #' . $color .';">חדש</span>';*/
?>
                    
       <a href="<?php echo $cat_grandparent_slug; ?>/<?php echo $cat_parent_slug;?>" style="color:<?php echo $color; ?>" class="category_square_oval_submit"><?php echo $cat_parent_name; ?></a>
                     

          <?php $values = get_category_meta('level', get_term_by('slug', $cat->cat_name, 'category'));
                foreach ($values as $value => $label) {
                    echo '<span class="oval">' . $value . '</span>';
                                                        }

                                                    ?>
        
        
        <?php include "add_lesson_btn.php" ?>
        
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