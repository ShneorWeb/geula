<?php get_header(); ?>	

    <div class="col-lg-12 col-md-12 archive_cont">	
        <?php
          $author =  get_the_author_meta( 'ID'); 
        ?>
             <div class="page-header">	
				

				<div class="header_category">	

					    <div class="back_to_libary">
                          
                             <?php if($gsLocaleShort == "he"): ?>
                               <a href="<?php echo get_permalink('68'); ?>">
                                <i class="fa fa-arrow-right"></i>
                                 <?php echo get_the_title( '68' ); ?>
                             <?php else: ?>
                               <a href="<?php echo get_permalink('109'); ?>">
                                <i class="fa fa-arrow-left"></i>
                                 <?php echo get_the_title( '109' ); ?>
                             <?php endif; ?>
                             
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
                                                   
                                        echo $user_post_count . ' ' . __('lessons in the library', 'swgeulatr');  
                                    ?>
                                </div>
                            </div>

                        </div>
				</div>
                
			</div>
        
			<div class="search_by">
                    
                <div class="search_text">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>  
                    <input type="search" placeholder="<?php echo __('Search', 'swgeulatr'); ?>">
                </div>
                
        <div class="selects">                                     
                    
                    <!-- filter by subject -->
                     <form>      
                         
                         <select id="select_subject" name="select_subject" onchange="filterBoxesTeach(jQuery('#select_subject').val(),jQuery('#select_order').val(),<?php echo $author; ?>)" class="selectpicker show-tick"> 
                             
                             <option value="<?php echo $this_category->cat_ID; ?>">
                                <?php _e("subject","swgeula");?>
                             </option> 
                             
                             <?php   
                              
                             $teachCats = getMyCatsTeach(0,$author);
                             $arrTeachSubjects = array();

                             foreach ($teachCats as $teachCat) {                                 
                                    $cats_str = get_category_parents($teachCat, false, '%#%');
                                    $cats_array = explode('%#%', $cats_str);
                                    $cat_depth = sizeof($cats_array)-2;

                                    if ($cat_depth==3) :                                
                                      $temp1 = get_category($teachCat);  
                                      $temp2 = get_category($temp1->parent);
                                      if ( !in_array(array($temp2->cat_ID,$temp2->cat_name),$arrTeachSubjects) ) $arrTeachSubjects[] = array($temp2->cat_ID,$temp2->cat_name);
                                    endif;
                                 
                             }                             
      
                              foreach ($arrTeachSubjects as $catTeach) {
                                $option = '<option value="'.$catTeach[0].'"';
                                //if ( $tempParent->parent == getCatIDOfLibrary() &&  $cat==$category->cat_ID) $option .= ' selected';
                                $option .= '>';
                                $option .= $catTeach[1];                                
                                $option .= '</option>';
                                echo $option;
                              }                                                          
                             ?>
                             
                        </select>                                               
                         
                    </form>
                    
                   
                    
     <form>          
           <!-- filter by order -->                          
           <select id="select_order" name="select_order" onchange="filterBoxesTeach(jQuery('#select_subject').val(),jQuery('#select_order').val(),<?php echo $author; ?>)" class="selectpicker show-tick">
               <option value="new_to_old"><?php _e("old to new","swgeula");?></option>
               <option value="old_to_new"><?php _e("new to old","swgeula");?></option>
               <option value="alphabet"><?php _e("alphabetical","swgeula");?></option>                                                                          
           </select>    
     </form>
                          
        </div>

      </div>

          <div id="spinner"></div>                  
    
       <div class="categories row" id="div-cat-boxes">                                    
                <?php                  
                  $arrMyCats = array();
                  $arrMyCats = $teachCats;                     
                  $bMyLessons = true;
                  $orderby="ID"; 
                  include_once("inc/category_boxes.php");
                ?>            
        
       </div>
        
      </div>

<?php get_footer(); ?>