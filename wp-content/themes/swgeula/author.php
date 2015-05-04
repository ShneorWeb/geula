<?php get_header(); ?>	

    <div class="col-lg-12 col-md-12 archive_cont">	
        <?php
          $author =  get_the_author_meta( 'ID'); 
        ?>
             <div class="page-header">	
				

				<div class="header_category">	

					    <div class="back_to_libary">
                          <a href="<?php echo get_permalink('68'); ?>">
                              <i class="fa fa-arrow-right"></i>
                              <?php echo get_the_title( '68' ); ?>
                          </a>
                        </div>

                        <div class="image_category">
                            <!--TODO : image from ofer function -->
				            <div class="category_square_avatar in_header">
                                <?php echo get_avatar( $author, 160 ); ?>
                            </div>
                            <div class="dtls">
                                <div class="current_category_name">
                                         <h1><?php echo get_the_author_meta( 'display_name'); ?></h1>
                                </div>

                                <div class="current_category_description">
                                    <?php echo get_the_author_meta( 'subject'); ?>
                                </div>

                                <div class="current_category_description">
                                    <?php echo get_the_author_meta( 'description'); ?>
                                </div>

                                <div class="number_of_posts_in_header">
                                    <?php
                                        $user_id = get_the_author_meta('ID');                                     
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
                    <input type="search" placeholder="חיפוש">
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
                                $is_subject_category = get_category_meta('subject_category', get_term_by('slug', $category->cat_name, 'category'));
                                $cat_authors = get_category_meta('authors', get_term_by('slug', $category->cat_name, 'category'));
                                
                                
                                if($is_subject_category && in_array($author, $cat_authors)) : 
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
               <option value="new_to_old" <?php selected( $_GET['select_order'],'new_to_old'); ?> >חדש לישן</option>
               <option value="old_to_new" <?php selected( $_GET['select_order'],'old_to_new' ); ?>>ישן לחדש</option>
               <option value="name" <?php selected( $_GET['select_order'],'name' ); ?>>אלף בתי</option>
                
               
                
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
				        $values = get_category_meta('authors', get_term_by('slug', $cat->cat_name, 'category'));
                        if (is_array($values))
                            {
                                foreach ($values as $user_id) 
                                    {
                                    $the_user = get_user_by('id', $user_id);
                                    $moser_id = get_the_author_meta('id', $user_id );     
                                  } 
                        }else{
                           $moser_id = 0; 
                        }                                 
                        
                        //remove level 2(subject) categories
                        if($cat_depth == 3  ) :
                        
                        //filter by authors
                        if($author == $moser_id):
                        
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
                    
       <a href="<?php echo site_url() . '/category/' . $cat_grandparent_slug.'?select_parent='.$cat_parent_id; ?>" style="color:<?php echo $color; ?>" class="category_square_oval_submit"><?php echo $cat_parent_name; ?></a>
                     

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
        ?>
				</ul>
				</div>
				
			</div>

    </div>

</div>

<?php get_footer(); ?>