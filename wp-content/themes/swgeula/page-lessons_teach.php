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
                                if($gsLocaleShort=='he'){
                                    $temp1 = get_page_by_path('השיעורים-שלי');  
                                    echo get_permalink( $temp1->ID );
                                }
                                else{
                                   $temp1 = get_page_by_path('my-lessons');  
                                   echo get_permalink( $temp1->ID ); 
                                }
                                 ?>
                               ">
                                <?php _e('my lessons', 'swgeula'); ?>
                            </a >
                            <a class="current">
                                <?php _e('lessons I teach', 'swgeula'); ?>
                            </a>
                        </div>

                        <div class="image_category">
                            
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
                     <form>      
                         
                         <select id="select_subject" name="select_subject" onchange="filterBoxesTeach(jQuery('#select_subject').val(),jQuery('#select_order').val())" class="selectpicker show-tick"> 
                             
                             <option value="<?php echo $this_category->cat_ID; ?>">
                                <?php _e("subject","swgeula");?>
                             </option> 
                             
                             <?php   
                              
                             $teachCats = getMyCatsTeach(0);
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
           <select id="select_order" name="select_order" onchange="filterBoxesTeach(jQuery('#select_subject').val(),jQuery('#select_order').val())" class="selectpicker show-tick">
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