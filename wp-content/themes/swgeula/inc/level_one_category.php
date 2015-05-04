			<div class="page-header">	
				

				<div class="header_category">	

					    <div class="back_to_libary">
                          <a href="<?php echo esc_url( $category_link ); ?>">
                              <i class="fa fa-arrow-right"></i>
                              <?php echo $parent_name; ?>
                          </a>
                        </div>

                        <?php 
                                    $cat_image =  get_category_meta('image');
                                    $page_bg_image = wp_get_attachment_image($cat_image, 'category_image');
                                    $page_bg_image_url = $page_bg_image[0];
                                    $cat_name = get_category(get_query_var('cat'))->name;

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
                        <select id="select_author" name="select_author" onchange="filterBoxes(jQuery('#select_author').val(),jQuery('#select_parent').val(),jQuery('#select_order').val())" class="selectpicker show-tick">
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
                         
                         <select id="select_parent" name="select_parent" onchange="filterBoxes(jQuery('#select_author').val(),jQuery('#select_parent').val(),jQuery('#select_order').val())" class="selectpicker show-tick"> 
                             
                             <option value="<?php echo $this_category->cat_ID; ?>">
                                <?php echo esc_attr(__('נושא')); ?>
                             </option> 
                             
                             <?php 
                              $this_cat = get_query_var('cat');
                              $categories = get_categories(array(
                                        'hide_empty' => 0,
                                        'child_of' => $this_cat,
                                        'parent' => $this_cat,
                              )); 
      
                              foreach ($categories as $category) {
                                $option = '<option value="'.$category->cat_ID.'" '.selected($_GET['select_parent'],$category->cat_ID, 1).'>';
                                $option .= $category->cat_name;
                                /*$option .= ' ('.$category->category_count.')';*/
                                  /*$option .= $category->parent;*/
                                $option .= '</option>';
                                echo $option;
                              }
                                
                                
                               /* if($_GET['select_parent'] == ""){
                                    $parent_cat = $_GET['select_parent_oval'];
                                }else{
                                     $parent_cat = $_GET['select_parent'];
                                }*/
      
      
                               
                             ?>
                             
                        </select>                                               
                         
                    </form>
                    
                   
                    
     <form>          
           <!-- filter by order -->                          
           <select id="select_order" name="select_order" onchange="filterBoxes(jQuery('#select_author').val(),jQuery('#select_parent').val(),jQuery('#select_order').val())" class="selectpicker show-tick">
               <option value="new_to_old">חדש לישן</option>
               <option value="old_to_new">ישן לחדש</option>
               <option value="name">אלף בתי</option>                                                                          
           </select>    
     </form>
													
				</div>

			</div>

          <div id="spinner"></div>				    	   	
		
			 <div class="categories row" id="div-cat-boxes">                
            <ul class="product_list" style="padding:0px;">
                <?php $bIsAjax=false; include_once("category_boxes.php");?>
            </ul>
				
			 </div>
				
		  </div>