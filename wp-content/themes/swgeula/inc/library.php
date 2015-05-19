<div class="page-header library-page">
        <div class="header_category">            
                        

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
 //if (get_category_children($this_category->cat_ID) != "") {
     //if (is_category() || is_single()) {
		    //$this_category = get_category($cat);						        
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
                  <button type="button"><?php _e("show all","swgeula") ?></button>
                </a>
            </div>
                              
            <div class="bottom_part">
              <?php
				        $cat_image =  get_category_meta('image', get_term_by('slug', $cat->cat_name, 'category'));               
              ?>
				<div class="library_image_category" style="background-image:url(<?php echo $cat_image ?>);">
                   
                    <ul class="product_list row">
							
									
					<?php 						

          //get direct child of current category which is a nosse. 
          //Then get all direct children of this child
          $args = array(   
                        'parent' => $cat->cat_ID,
                        'hide_empty' => 0                        
                    );
          $catsTemp = get_categories($args);          
          $arrTempCats = array();

          foreach ($catsTemp as $cattemp) : 

              $args2 = array(   
                        'parent' => $cattemp->cat_ID,
                        'hide_empty' => 0                        
              );     
          
              $catsTemp2 = get_categories($args2);       
              
              foreach ($catsTemp2 as $cattemp2) : 
                if ( !in_array($cattemp2->cat_ID,$arrTempCats) ) $arrTempCats[] = $cattemp2->cat_ID;
              endforeach;

          endforeach;

					
					$args = array(	 
                        'include' => implode(",",$arrTempCats),
                        'hide_empty' => 0,
                        'number' => 3
                    );

					$count = 0;
					$cats2 = get_categories($args);          

          //sort categories by last updated post:
          $arrCatsArray = array();
          foreach ($cats2 as $cat2) : 

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

          $iCounter = 0;
					foreach ($arrCatsArray as $cat2) :

                if ($iCounter>2) break;

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
                                            <span class="category_top_time" style="margin-left:6px;">
                                              <?php 
                                                $numLessons = getNumLessons($cat2->cat_ID);
                                                if ($numLessons==1) echo __('lesson','swgeula') . __(' 1','swgeula');
                                                else echo __($numLessons) . __(' ','swgeula') . __('lessons','swgeula');
                                              ?>
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
                                                    echo substr( $short_description, 0,177); 
                                                    /*echo "...";*/
                                                    ?>
                                                </p>
											</div>

                                        <div class="bottom_cont">
                                            
                                        
											<div class="category_square_author">
                                                


                                                        <?php

                                                         $values = get_category_meta('authors', get_term_by('slug', $cat2->slug, 'category'));
                                                        foreach ($values as $user_id) {
                                                            $the_user = get_user_by('id', $user_id);
                                                            //TODO : image from ofer function
                                                            echo '<a href="'. get_author_posts_url( $user_id) . '">';
                                                            echo '<div class="category_square_avatar">'. get_avatar( $the_user->ID, 60 ) . '</div>'; 

                                                            echo '<div class="author_des"><div class="category_square_author_name"><h4>' . $the_user->display_name . '</h4></div>';

                                                            echo '<div class="category_square_author_subject">' .get_the_author_meta('subject', $user_id ). '</div>';?>

                                                            <div class="category_square_number">
                                                                <?php 
                                                                    $user_post_count = count_user_posts( $user_id );
                                                                    echo $user_post_count . ' ' . __('lessons in the library', 'swgeula');                                                            
                                                                ?>                                                        
                                                            </div>
                                                            </a>
                                                        <?php } ?>
                                                
											</div>
													

											</div>
                                        
		<div class="category_square_oval">
                                               
             <?php                
                $cat_parent_id = $cat2->parent;                
                $cat_parent_object = get_category($cat_parent_id);                
                $cat_parent_name = $cat_parent_object->name;                                                      
                /*echo '<span class="oval" style="background:'. $color .'; color:#ffffff; border:1px solid #' . $color .';">חדש</span>';*/
?>
                    
       <a href="<?php echo get_category_link($cat_parent_id);?>" style="color:<?php echo $color; ?>;" onMouseOver="this.style.border='2px solid <?php echo $color; ?>'" onMouseOut="this.style.border='2px solid #b2bac2'" class="category_square_oval_submit"><?php echo $cat_parent_name; ?></a>
                     

        <?php $values = get_category_meta('level', get_term_by('slug', $cat->cat_name, 'category'));
                foreach ($values as $value => $label) {
                    echo '<span class="oval">' . $value . '</span>';
                }
        ?>      

        <div id="lessob_buttons">
        <?php 
              $catAddID=$cat2->cat_ID; 
              include "add_lesson_btn.php";
        ?>
        </div>
        
        </div>
                        </div>
		
                    
                                </li>
                    </div><!-- category_single -->
                
            <?php endif;?>
            <?php 
              $iCounter++;
            endforeach  
            ?>
										

					</ul>		
	    		</div>
    		</div><!-- bootm part -->
        </div><!-- cat_sing -->
							
    <?php
      endforeach; //} 
//        }
    ?>
</div>