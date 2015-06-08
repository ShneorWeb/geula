<?php
/*
Template Name: Lessons Teach
*/
get_header(); ?>	

    <div class="col-lg-12 col-md-12 archive_cont">	
       
        <?php
          $current_user = wp_get_current_user();
//print_r($current_user);
          $author =   $current_user->ID;
        ?>
           
             <div class="page-header">	
				

				<div class="header_category">	

					    <div class="back_to_libary">

                            <h1><?php the_title(); ?></h1>

                         </div>
                         
                          <div class="box menu">
                            <a href="
                               <?php 
                                    if(ICL_LANGUAGE_CODE=='he'){
                                        echo get_permalink(90);
                                    }else{
                                       echo get_permalink(126); 
                                    }
                                 ?>
                               ">
                                <?php echo __('השיעורים שלי', 'swgeula'); ?>
                            </a >
                            <a class="current">
                                <?php echo __('שיעורים שאני מוסר', 'swgeula'); ?>
                            </a>
                        </div>

                        <div class="image_category">
                            <!--TODO : image from ofer function -->
				            <div class="category_square_avatar in_header">
                                <?php echo get_avatar( $author, 160 ); ?>
                            </div>
                            <div class="dtls">
                                <div class="current_category_name">
                                         <h1><?php echo $current_user->display_name; ?></h1>
                                </div>

                                <div class="current_category_description">
                                    <?php echo $current_user->subject; ?>
                                </div>

                                <div class="current_category_description">
                                    <?php echo $current_user->description; ?>
                                </div>

                                <div class="number_of_posts_in_header">
                                    <?php
                                        $user_id = $current_user->id;                                     
                                        $user_post_count = count_user_posts( $user_id );
                                                   
                                        echo $user_post_count . ' ' . __(' שיעורים בספריה', 'swgeula');  
                                    ?>
                                </div>
                            </div>

                        </div>
				</div>
                
			</div>
        
			<div class="search_by">
                    
                <div class="search_text">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>  
                    <input type="search" placeholder="<?php echo __('חיפוש', 'swgeula'); ?>">
                </div>
                
				<div class="selects">
                   
                    
                    <!-- filter by subject -->
                     <form method="get" id="select_parent">      
                         
                         <select name="select_parent" onchange='this.form.submit()' class="selectpicker show-tick"> 
                             
                             <option value="<?php echo $this_category->cat_ID; ?>">
                                <?php echo esc_attr(__('נושא')); ?>
                             </option> 
                             
                             <?php 
                              $categories = get_categories(array(
                                        'hide_empty' => 0,
                              )); 
      
                              foreach ($categories as $category) {
                                $is_subject_category = get_field('subject_category', "category_".$category->cat_ID);
                                $cat_authors = get_field('swauthors', "category_".$category->cat_ID);
                                
                                
                                if($is_subject_category && ($author==$cat_authors["ID"]) ) : 
                                    $option = '<option value="'.$category->cat_ID.'" '.selected($_GET['select_parent'],$category->cat_ID, 1).'>';
                                    $option .= $category->cat_name;
                                    $option .= '</option>';
                                    echo $option;
                                    echo $cat_authors[0];
                                  endif;
                              }
                                
                                
                                if($_GET['select_parent'] == ""){
                                    $parent_cat = $_GET['select_parent_oval'];
                                }else{
                                     $parent_cat = $_GET['select_parent'];
                                }
      
      
                               
                             ?>
                             
                        </select>
                         
                         <?php $select_order = $_GET['select_order']; ?>
                         <input name="select_order" type="hidden" value="<?php echo $select_order ?>"/>
                         
                         <?php $moser_id  = $_GET['select_author']; ?>
                         <input name="select_author" type="hidden" value="<?php echo $moser_id ?>"/>
                         
                    </form>
                    
                   
                    
     <form method="get" id="select_order">
          
           <!-- filter by order -->
                   
         
           <select name="select_order" onchange='this.form.submit()' class="selectpicker show-tick">
               <option value="new_to_old" <?php selected( $_GET['select_order'],'new_to_old'); ?> ><?php echo __('חדש לישן', 'swgeula'); ?></option>
               <option value="old_to_new" <?php selected( $_GET['select_order'],'old_to_new' ); ?>><?php echo __('ישן לחדש', 'swgeula'); ?></option>
               <option value="name" <?php selected( $_GET['select_order'],'name' ); ?>><?php echo __('אלף בתי', 'swgeula'); ?></option>
                
               
                
                <?php
                      
                      $orderby = "ID";
                      if ($_GET['select_order'] == 'new_to_old') { $order = "desc";  }
                      if ($_GET['select_order'] == 'old_to_new') { $order = "asc";  }  
                      if ($_GET['select_order'] == 'name') { $orderby = "name";$order = "asc";  }  
                    ?>
               
           </select>
         
                <input name="select_parent" type="hidden" value="<?php echo $parent_cat ?>"/>
                <?php $moser_id  = $_GET['select_author']; ?>
                <input name="select_author" type="hidden" value="<?php echo $moser_id ?>"/>
     </form>
													
				</div>

			</div>

            <div id="spinner"></div>				    	   	
		
			<div class="categories row">
                
                

				<ul class="product_list" style="padding:0px;">

					<?php
                    
                    //if parent cat is empty
                     if($parent_cat == ""){
                        $parent_cat = $this_category->cat_ID;
                      }
      
					
                        
                        $args = array(	 
                            'child_of' => $parent_cat,
                            'hide_empty' => 0,
                            'orderby' => $orderby,
                            'order' => $order,
                        );
					
				        foreach (get_categories($args) as $cat) : 
                        
                        //get depth of category from - http://www.devdevote.com/cms/wordpress-hacks/get_depth
                        $cats_str = get_category_parents($cat, false, '%#%');
                        $cats_array = explode('%#%', $cats_str);
                        $cat_depth = sizeof($cats_array)-2;
                        
                      
                        //
				        $values = get_field('swauthors', "category_".$cat->cat_ID);
                        if (is_array($values) && count($values)>0 ) $moser_id = $values["ID"];                                                              
                        else $moser_id = 0;                         
                        
                        //remove level 2(subject) categories
                        if($cat_depth == 3  ) :
                        
                        //filter by authors                          
                        if($author == $moser_id):
                        
                        ?>

                           
							<div class="category_single col-lg-4 col-md-6 col-sm-6 col-xs-12 ">


							<?php $color = get_field('swcolor', "category_".$cat->cat_ID); ?>

									<li class="category_square"> 
                                        
										<div class="category_top_square" style="background:<?php echo $color; ?>">
                                            <span class="category_top_time">                                                
                                               <?php echo formatHoursMinutes(getTotalVideoDurationCat($cat->cat_ID));?>
                                            </span>
                                             <span class="category_top_time" style="margin-left:6px;">
                                                  <?php 
                                                    $numLessons = getNumLessons($cat->cat_ID);
                                                    if ($numLessons==1) echo __('lesson','swgeula') . __(' 1','swgeula');
                                                    else echo __($numLessons) . __(' ','swgeula') . __('lessons','swgeula');
                                                  ?>
                                            </span>
											<i class="icon-type-of-lesson-icon-1"></i>
										</div>
                                        
										<div class="category_square_content">
                                            
											<h3 class="category_square-format">
												<?php $values =  get_field('swtype', "category_".$cat->cat_ID);												
												    echo '' . $values .'' ;												
												$values = get_field('swformat', "category_".$cat->cat_ID);												
												    echo  '&nbsp;' . $values . '';
												?>
											</h3>
                                            
										

											<h2>
                                                <a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->cat_name; ?></a>
                                            </h2>
                                            
											<div class="category_square_description">
													<?php
                                                    /*echo category_description($cat->term_id); */
                                                    ?>
												<p>
                                                <?php $short_description = get_field('short_description', "category_".$cat->cat_ID);
                                                    echo substr( $short_description, 0,177); 
                                                    /*echo "...";*/
                                                    ?>
                                                </p>
											</div>

                                        <div class="bottom_cont">
											<div class="category_square_author">
											
												<?php
												 
												 $values = get_field('swauthors', "category_".$cat->cat_ID);
												
                        if ( is_array($values) && (count($values)>0) ) {
                                                    
												    $the_user = (object)$values;
                            
                            echo '<a href="'. get_author_posts_url( $user_id) . '">';
                                                   
												    echo '<div class="category_square_avatar">'. get_avatar( $the_user, 60 ) . '</div>'; 

												    echo '<div class="author_des"><div class="category_square_author_name"><h4>' . $the_user->display_name . '</h4></div>';
												    
												    echo '<div class="category_square_author_subject">' .get_the_author_meta('subject', $user_id ). '</div>';?>
                                                
											    	<div class="category_square_number">
														 <?php
                                                            $user_id = get_the_author_meta('ID');                                     
                                                            $user_post_count = count_user_posts( $user_id );

                                                            echo $user_post_count . ' ' . __('lessons in the library', 'swgeula');  
                                                        ?>
                                                        
													</div><?php } ?>
                                                
											</div>
													</a>

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
                    
       <a href="<?php echo site_url() . '/category/' . $cat_grandparent_slug.'?select_parent='.$cat_parent_id; ?>" style="color:<?php echo $color; ?>" onMouseOver="this.style.border='2px solid <?php echo $color; ?>'" onMouseOut="this.style.border='2px solid #b2bac2'" class="category_square_oval_submit"><?php echo $cat_parent_name; ?></a>
                     
          <?php $values = get_field('swlevel', "category_".$cat->cat_ID);                
                    echo '<span class="oval">' . $values . '</span>';
                

                                                    ?>
                                                    
            <?php include "inc/add_lesson_btn.php" ?>
            
        </div>
		
                    
                    
                    </div>
                    </div>
									</li>
							</div>

							

							

					

						<?php 
                        endif;
                        endif;
                        endforeach; 
        ?>
				</ul>
				</div>
				
			</div>

    </div>

</div>

<?php get_footer(); ?>