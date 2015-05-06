					<?php                   

                    //if parent cat is empty
                     if($parent_cat == ""){
                        $parent_cat = $this_category->cat_ID;
                      }
      
					//if (is_category() || is_single() || $bIsAjax) {
                        
                        $args = array(	 
                            'child_of' => $parent_cat,
                            'hide_empty' => 0,
                            'orderby' => $orderby,
                            'order' => $order,
                        );
					    $cats = get_categories($args);
                        
                        
				        foreach ($cats as $cat) : 
                        
                            //get depth of category from - http://www.devdevote.com/cms/wordpress-hacks/get_depth
                            $cats_str = get_category_parents($cat, false, '%#%');
                            $cats_array = explode('%#%', $cats_str);
                            $cat_depth = sizeof($cats_array)-2;
                            
                          
                            //
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

                               
    							<div class="category_single col-lg-4 col-md-6 col-sm-6 col-xs-12 ">


    							<?php $color = get_category_meta('color', get_term_by('slug', $cat->cat_name, 'category')); ?>

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
                    $cat_parent = $cat->parent;                                                                               
                    $tempParent = get_category($cat_parent);                                        
                    
                    //if ($parentcat->parent == getCatIDOfLibrary()) $cat_parent_link = "";
                    //else $cat_parent_link = 
                            
                         /*echo '<span class="oval" style="background:'. $color .'; color:#ffffff; border:1px solid #' . $color .';">חדש</span>';*/    ?>                   
                     <?php //echo "cat="   . $tempParent2->parent; ?>

              <?php echo '<a href="'.((isset($bInNosse) && $bInNosse)?'../'.$tempParent->slug:$tempParent->slug).'" style="color:'.$color.'" class="category_square_oval_submit">'.$tempParent->name.'</a>';  ?>

              <?php $values = get_category_meta('level', get_term_by('slug', $cat->cat_name, 'category'));
                    foreach ($values as $value => $label) {                        
                        echo '<span class="oval">' . $value . '</span>';
                                                            }

                                                        ?>
                
            </div>
    		
                        
                        
                        </div>
    									</li>
    							</div>

    							

    							

    					

    						<?php 
                            endif;
                            endif;
                        endforeach; 
                        //} 
        ?>