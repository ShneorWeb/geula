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
            'hide_empty' => 0,
            'orderby' => 'name',
            'order' => 'ASC'
    );
         
    $count = 0;
    $cats1 = get_categories($args);        
       
    $order_cats = array("דבר מלכות","מגולה לגאולה","בית המקדש","גאולה","משיח"); //this list is revresed so last is first when done
    foreach($order_cats as $oc) { 
          for ($i=0;$i<count($cats1);$i++) :
            if ($cats1[$i]->name == $oc) {     
              $temp = $cats1[$i];
              unset($cats1[$i]);
              array_unshift($cats1, $temp);      
            }
          endfor;
    }

		  			
		foreach ($cats1 as $cat) : ?>
							
          <div class="cat_sing" style="opacity:0">
            <div id="spinner"></div>
            <div class="header_part">
               <a href="<?php echo get_category_link($cat->term_id); ?>" class="texts_cont">
                 <div>
                   <h2><?php echo $cat->cat_name; ?></h2>
                     <p>        
                       <?php
                          $short_description = get_field('short_description', "category_".$cat->cat_ID);
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
				        $cat_image =  get_field('swimage', "category_".$cat->cat_ID);               
              ?>
				<div class="library_image_category" style="background-image:url(<?php echo $cat_image ?>);">                                  							
									
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

					
          if ( count($arrTempCats)>0 ) :
          ?>
          <ul class="product_list row">

          <?php

  					$args = array(	 
                          'include' => implode(",",$arrTempCats),
                          'hide_empty' => 0                      
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

            $arrCatsArray2 = array_slice($arrCatsArray, 0, 3); 
            
  					foreach ($arrCatsArray2 as $cat2) :
                  
                  $cat2 = (object)$cat2; 

                  $color = get_field('swcolor', "category_".$cat2->cat_ID);                                
          			  $is_subject_category = get_field('subject_category', "category_".$cat2->cat_ID);
                  if(!$is_subject_category) : 		
  					?>
                   
  					   <div class="category_single col-lg-4 col-md-6 col-sm-6 col-xs-12 ">

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
  												<?php $values =  get_field('swtype', "category_".$cat2->cat_ID);                                                
                          if ( is_string($values) ) {  												
    												    echo '' . $values .'' ;
                            }  												
    												$values = get_field('swformat', "category_".$cat2->cat_ID);  												
                            if ( is_string($values) ) {    
    												    echo  '&nbsp;' . $values . '';  												
                            }
                        ?>
  											</h3>
                                              
  										

  											<h2>
                                                  <a href="<?php echo get_category_link($cat2->term_id); ?>"><?php echo $cat2->cat_name; ?></a>
                                              </h2>
                                              
  											<div class="category_square_description">
  													<?php
                                                      /*echo category_description($cat2->term_id); */
                                                      ?>
  												<p>
                                                  <?php $short_description = get_field('short_description', "category_".$cat2->cat_ID);
                                                      echo mb_substr( $short_description, 0,160,'UTF-8'); 
                                                      /*echo "...";*/
                                                      ?>
                                                  </p>
  											</div>

                                          <div class="bottom_cont">
                                              
                                          
  											<div class="category_square_author">
                                                  


                                                          <?php

                                                          $values = get_field('swauthors', "category_".$cat2->cat_ID);                                                                                                                
                                                          if ( is_array($values) && count($values)>0 ) {                                                          
                                                                
                                                                $the_user = (object)$values;

                                                                echo '<a href="'. get_author_posts_url( $the_user->ID) . '">';
                                                                echo '<div class="category_square_avatar">'. get_avatar( $the_user->ID, 60 ) . '</div>'; 

                                                                echo '<div class="author_des"><div class="category_square_author_name"><h4>' . $the_user->display_name . '</h4></div>';

                                                                echo '<div class="category_square_author_subject">' .get_the_author_meta('subject', $user_id ). '</div>';?>

                                                                <div class="category_square_number">
                                                                    <?php                                                                         
                                                                        if (is_numeric($numLessons)) echo $numLessons . ' ' . __('lessons in the library', 'swgeula');                                                            
                                                                    ?>                                                        
                                                                </div>
                                                                </a>
                                                            <?php                                                        
                                                          }
                                                          ?>
                                                  
  											</div>
  													

  											</div>
                                          
  		<div class="category_square_oval">
                                                 
               <?php                
                  $cat_parent_id = $cat2->parent;                
                  $cat_parent_object = get_category($cat_parent_id);                
                  $cat_parent_name = $cat_parent_object->name;                                                      
                  /*echo '<span class="oval" style="background:'. $color .'; color:#ffffff; border:1px solid #' . $color .';">חדש</span>';*/
  ?>
             <div class="tags_and_level">         
         <a href="<?php echo get_category_link($cat_parent_id);?>" style="color:<?php echo $color; ?>;" onMouseOver="this.style.border='2px solid <?php echo $color; ?>'" onMouseOut="this.style.border='2px solid #EAEDEF'" class="category_square_oval_submit"><?php echo $cat_parent_name; ?></a>
                       

          <?php $values = get_field('swlevel', "category_".$cat2->cat_ID);        
                if ( is_string($values) ) {                
                      echo '<span class="oval">' . $values . '</span>';                
                }
          ?>      
            </div>

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
              endforeach;             
              ?>										
  					</ul>		
            <?php
            endif;
            ?>
  	    		</div>
      		</div><!-- bootm part -->
          </div><!-- cat_sing -->
  							
      <?php
        endforeach;       
    ?>
</div>