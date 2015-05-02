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
                     <form method="get" id="select_author">
                        <select name="select_author" onchange='this.form.submit()' class="selectpicker show-tick">
                            <option value="0" >מוסר שיעור</option>
                            <?php 
                               
                                  $args = array(
                                /* https://codex.wordpress.org/Function_Reference/get_users */
                                    'blog_id'      => 1,
                                    'role'         => 'Administrator',
                                 );
                                $blogusers = get_users( $args );
                                // Array of stdClass objects.
                                foreach ( $blogusers as $user ) {?>
                                    <option value="<?php echo $user->id ?>" <?php selected( $_GET['select_author'],$user->id); ?> ><?php echo esc_html( $user->display_name ); ?></option>
                              <?php  } ?>
                            
                        </select>
                         
                         <?php $select_order = $_GET['select_order']; ?>
                         <input name="select_order" type="hidden" value="<?php echo $select_order ?>"/>
                         
                         <?php $parent_cat  = $_GET['select_parent']; ?>
                         <input name="select_parent" type="hidden" value="<?php echo $parent_cat ?>"/>
                         
                    </form>
                    
                    <!-- filter by subject -->
                     <form method="get" id="select_parent">      
                         
                         <select name="select_parent" onchange='this.form.submit()' class="selectpicker show-tick"> 
                             
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
                
                <?php include_once("category_boxes.php");?>
				
			 </div>
				
		  </div>