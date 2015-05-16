			<div class="page-header">	
				

				<div class="header_category">	

					    <div class="back_to_libary">                      
                      <?php 
                          $parentOfParent = get_category($this_category->parent);                            
                          ?>
                          <a href="<?php echo esc_url( get_category_link( $parentOfParent->cat_ID ) ); ?>">
                              <i class="fa fa-arrow-right"></i>
                              <?php echo $parentOfParent->name; ?>
                          </a>                      
              </div>

              <?php             
                                                            
                                  $cat_meta = get_category_meta(false, get_term_by('ID', $this_category->cat_ID, 'category'));                                  
                                  $cat_image = $cat_meta["image"];
                                  $cat_name = get_category($this_category->cat_ID)->name;
                            

              ?>

              <div class="image_category" style="background-image:url(<?php echo $cat_image ?>);">

                             <div class="current_category_name">
                                     <h1><?php echo $cat_name; ?></h1>
                            </div>

                            <div class="current_category_description">
                                <?php echo category_description($cat->term_id);  ?>
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
                   
                    <!-- filter by author -->
                     <form>
                        <select id="select_author" name="select_author" onchange="filterBoxes(jQuery('#select_author').val(),jQuery('#select_subject').val(),jQuery('#select_order').val(),<?php echo $this_category->cat_ID;?>,<?php echo $bInNosse?"1":"0";?>)" class="selectpicker show-tick">
                            <option value="0" >מוסר שיעור</option>
                            <?php 
                               
                                  $args = array(                                                                  
                                    'orderby'       => 'name', 
                                    'order'         => 'ASC', 
                                    'exclude_admin' => false,                                   
                                    'echo' => false,
                                    'hide_empty' => false,
                                    'style'  => 'none'
                                 );
                                $authors = wp_list_authors( $args );
                                $arrAuthors = explode(",", $authors);                               
                                $arrCurrentName = array();
                                foreach($arrAuthors as $at) {                                 
                                  $sName = trim(strip_tags($at));                                  
                                     if (!in_array($sName,$arrCurrentName)) {
                                      //$objUser = get_user_by('slug',addslashes($sName));
                                      $user_query = new WP_User_Query( array( 'search_columns' => array( 'display_name', $sName )  ) );
                                      if ( ! empty( $user_query->results ) ) {
                                        foreach ( $user_query->results as $qUser ) {
                                          echo("<option value='".$qUser->ID."'>".addslashes($qUser->display_name)."</option>");
                                          $arrCurrentName[] = $qUser->display_name;
                                        }
                                      }                                  
                                    }
                                }
                                ?>                                                          
                        </select>                     
                         
                         
                    </form>
                    
                    <!-- filter by subject -->
                     <form>      
                         
                         <select id="select_subject" name="select_subject" onchange="filterBoxes(jQuery('#select_author').val(),jQuery('#select_subject').val(),jQuery('#select_order').val(),<?php echo $this_category->cat_ID;?>,<?php echo $bInNosse?"1":"0";?>)" class="selectpicker show-tick"> 
                             
                             <option value="<?php echo $this_category->cat_ID; ?>">
                                <?php echo esc_attr(__('נושא')); ?>
                             </option> 
                             
                             <?php   
                              $tempCat = get_category($cat);
                              $tempParent = get_category($tempCat->parent);
                              if ($tempParent->parent == getCatIDOfLibrary()) {
                                $tempCatID = $tempCat->parent;
                                $parent_cat = $cat;
                              }
                              else $tempCatID = $this_category->cat_ID;

                              $categories = get_categories(array(
                                        'hide_empty' => 0,
                                        'child_of' => $tempCatID,
                                        'parent' => $tempCatID,
                              )); 
      
                              foreach ($categories as $category) {
                                $option = '<option value="'.$category->cat_ID.'"';
                                if ( $tempParent->parent == getCatIDOfLibrary() &&  $cat==$category->cat_ID) $option .= ' selected';
                                $option .= '>';
                                $option .= $category->cat_name;
                                /*$option .= ' ('.$category->category_count.')';*/
                                  /*$option .= $category->parent;*/
                                $option .= '</option>';
                                echo $option;
                              }                                                          
                             ?>
                             
                        </select>                                               
                         
                    </form>
                    
                   
                    
     <form>          
           <!-- filter by order -->                          
           <select id="select_order" name="select_order" onchange="filterBoxes(jQuery('#select_author').val(),jQuery('#select_subject').val(),jQuery('#select_order').val(),<?php echo $this_category->cat_ID;?>,<?php echo $bInNosse?"1":"0";?>)" class="selectpicker show-tick">
               <option value="new_to_old">חדש לישן</option>
               <option value="old_to_new">ישן לחדש</option>
               <option value="alphabet">אלף בתי</option>                                                                          
           </select>    
     </form>
													
				</div>

			</div>

          <div id="spinner"></div>				    	   	
		
			 <div class="categories row" id="div-cat-boxes">                            
                <?php $orderby="ID"; include_once("category_boxes.php");?>            
				
			 </div>
				
		  </div>