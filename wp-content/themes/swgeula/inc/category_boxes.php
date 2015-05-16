<ul class="product_list" style="padding:0px;">
					<?php                   

                    //if parent cat is empty
                     if($parent_cat == ""){
                        $parent_cat = $this_category->cat_ID;
                      }
      
					//if (is_category() || is_single() || $bIsAjax) {
                      

                      //if in my lessons page get my catgories:                                                   
                      if ( $bMyLessons ) {
                        $args = array(   
                              'child_of' => $parent_cat,
                              'hide_empty' => 0,
                              'orderby' => $orderby,
                              'order' => $order,                            
                              'include' => implode(",", $arrMyCats)
                        );
                      }

                      else {  
                        $args = array(	 
                              'child_of' => $parent_cat,
                              'hide_empty' => 0,
                              'orderby' => $orderby,
                              'order' => $order
                        );
                      }

                      //var_dump($args);

					            $cats = get_categories($args);

                      //var_dump($cats);

                      if ($orderby!="name") :                        
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
                                  'date' => strtotime("-1 year"),
                                  'term_id' => $cat2->term_id,   
                                  'cat_ID' => $cat2->cat_ID,                         
                                  'cat_name' => $cat2->cat_name,
                                  'slug' => $cat2->slug,
                                  'parent' => $cat2->parent 
                                );  
                            endif;

                          endforeach;
                          
                          if (strtolower($order)=='desc') usort($arrCatsArray, "compareDates");
                          else usort($arrCatsArray, "compareDates2");

                      else :
                        
                          $arrCatsArray =  (array)$cats;                           
                          usort($arrCatsArray, "compareNames");  

                      endif; //of if ($order!="name")

                       
                        
				        foreach ($arrCatsArray as $cat) : 

                            $cat = (object)$cat; 
                        
                            //get depth of category from - http://www.devdevote.com/cms/wordpress-hacks/get_depth
                            $cats_str = get_category_parents($cat->cat_ID, false, '%#%');
                            $cats_array = explode('%#%', $cats_str);
                            $cat_depth = sizeof($cats_array)-2;
                            
                          
                            
    				                $values = get_category_meta('authors', get_term_by('slug', $cat->cat_name, 'category'));
                            if (is_array($values))
                                {
                                    foreach ($values as $user_id) {
                                        $the_user = get_user_by('id', $user_id);                                        
                                        $moser_id = get_the_author_meta('id', $user_id );     
                                      } 
                            }
                            else{                               
                               $moser_id = 0;                                                               
                            }
                                      
                            
                            //remove level 2(subject) categories                            
                            if($cat_depth == 3  ) :
                            
                            //filter by authors
                            if( empty($iAuthorID) || ($iAuthorID==0) || (isset($the_user) && is_object($the_user) && $iAuthorID == $the_user->ID) ):
                                
                            ?>

                               
    							<div id="catbox_<?php echo $cat->cat_ID; ?>" class="category_single col-lg-4 col-md-6 col-sm-6 col-xs-12 ">


    							<?php $color = get_category_meta('color', get_term_by('slug', $cat->cat_name, 'category')); ?>

    									<li class="category_square"> 
                                            
    										<div class="category_top_square" style="background:<?php echo $color; ?>">
                                                <span class="category_top_time">
                                                    
                                                         <?php echo formatHoursMinutes(getTotalVideoDurationCat($cat->cat_ID));?>                                              
                                                    
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
                                                        echo substr( $short_description, 0,177); 
                                                        /*echo "...";*/
                                                        ?>
                                                    </p>
    											</div>

    											<div class="category_square_author">                                                       
    												<?php    						                                                     					
    												 $values = get_category_meta('authors', get_term_by('slug', $cat->cat_name, 'category'));
    												foreach ($values as $user_id) {
    												    $the_user = get_user_by('id', $user_id);                                                                                                                
                                                        echo '<a href="'. get_author_posts_url( $user_id) . '">';
    												    echo '<div class="category_square_avatar">'. get_avatar( $the_user->ID, 60 ) . '</div>'; 

    												    echo '<div class="author_des"><div class="category_square_author_name"><h4>' . $the_user->display_name . '</h4></div>';
    												    
    												    echo '<div class="category_square_author_subject">' .get_the_author_meta('subject', $user_id ). '</div>';?>
                                                    
    											    	<div class="category_square_number">
    														<?php 
                                                                $user_post_count = count_user_posts( $user_id );
                                                                echo $user_post_count . ' ' . __('lessons in the library', 'swgeula');  
                                                            ?>
    													</div><?php } ?>
                                                    </a>
    											</div>
    													

    											</div>
                                            
    		<div class="category_square_oval">
                                                   
                 <?php                    
                    $cat_parent = $cat->parent;                                                                               
                    $tempParent = get_category($cat_parent);                                        
                    
                    //if ($parentcat->parent == getCatIDOfLibrary()) $cat_parent_link = "";
                    //else $cat_parent_link = 
                            
                         /*echo '<span class="oval" style="background:'. $color .'; color:#ffffff; border:1px solid #' . $color .';">חדש</span>';*/    ?>                   
                     <?php //echo "cat="   . $tempParent2->parent; ?>

              <?php echo '<a href="'.get_category_link($cat->parent).'" style="color:'.$color.'" class="category_square_oval_submit">'.$tempParent->name.'</a>';  ?>

              <?php $values = get_category_meta('level', get_term_by('slug', $cat->cat_name, 'category'));
                    foreach ($values as $value => $label) {                        
                        echo '<span class="oval">' . $value . '</span>';
                                                            }

                                                        ?>
                                                        
            <?php 
                $catAddID=$cat->cat_ID; 
                include "add_lesson_btn.php";
            ?>
                
            </div>
    		
                        
                        
                        
    									</li>
    							</div>

    							

    							

    					

    						<?php 
                            endif;
                            endif;
                        endforeach; 
                        //} 
        ?>
</ul>