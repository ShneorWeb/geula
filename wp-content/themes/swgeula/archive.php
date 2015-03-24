<?php get_header(); ?>	
    <div class="col-lg-12 col-md-12 archive_cont">	
    <?php

      $child = get_category($cat); 
      $parent = $child->parent;
      $parent_name = get_category($parent);
      $parent_name = $parent_name->name;
      $category_id = get_cat_ID( $parent_name );
      $category_link = get_category_link( $category_id );
      $this_category = get_category($cat);

     if (($category_id) != 0){	?>	
     	<?php $this_category = get_category($cat);
  if (get_category_children($this_category->cat_ID) != "") {


/*page category*/
  	?>

  
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
                    
                    <!-- TODO: http://pastebin.com/LCFS945E -->
                    
                     <form method="post" id="select_author">
                        <select name="select" onchange='this.form.submit()' class="selectpicker">
                            <option>מוסר שיעור</option>
                            <?php 
                               /*TODO: query categories by author */
                                  $args = array(
                                /* https://codex.wordpress.org/Function_Reference/get_users */
                                    'blog_id'      => 1,
                                    'role'         => 'Administrator',
                                 );
                                $blogusers = get_users( $args );
                                // Array of stdClass objects.
                                foreach ( $blogusers as $user ) {
                                    echo '<option>' . esc_html( $user->display_name ) . '</option>';
                                }
                            ?>
                            
                        </select>
                    </form>
                    
                     <form method="post" id="select_parent">                            
                         <select name="select_parent" onchange='this.form.submit()' class="selectpicker show-tick"> 
                             <option value="<?php echo $this_category->cat_ID; ?>"<?php selected($_POST['select_parent'],$category->cat_ID, 1) ?>><?php echo esc_attr(__('נושא')); ?></option> 
                             <?php 
                              $this_cat = get_query_var('cat');
                              $categories = get_categories(array(
                                        'hide_empty' => 0,
                                        'child_of' => $this_cat,
                                        'parent' => $this_cat,
                              )); 
      
                              foreach ($categories as $category) {
                                $option = '<option value="'.$category->cat_ID.'" '.selected($_POST['select_parent'],$category->cat_ID, 1).'>';
                                $option .= $category->cat_name;
                                /*$option .= ' ('.$category->category_count.')';*/
                                  /*$option .= $category->parent;*/
                                $option .= '</option>';
                                echo $option;
                              }
                                
                                if($_POST['select_parent'] == ""){
                                    $parent_cat = $_POST['select_parent_oval'];
                                }else{
                                     $parent_cat = $_POST['select_parent'];
                                }
                                
     
                                
                             ?>
                             
                        </select>
                    </form>
                    
                    
                    <?php
                      $orderby = "ID";
                      if ($_POST['select_order'] == 'new_to_old') { $order = "desc";  }
                      if ($_POST['select_order'] == 'old_to_new') { $order = "asc";  } 
                    ?>
                    
                     <form method="post" id="select_order">
                          <select name="select_order" onchange='this.form.submit()'>
                            <option value="new_to_old"<?php selected( $_POST['select_order'],'new_to_old', 1 ); ?>>חדש לישן</option>
                            <option value="old_to_new"<?php selected( $_POST['select_order'],'old_to_new', 1 ); ?>>ישן לחדש</option>
                          </select>
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
      
                   /*echo "parent_cat is:".$parent_cat;*/
      
					if (is_category()|| is_single()) {
                        
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
                        
                        //remove level 2(subject) categories
                        if($cat_depth == 3) :
                        
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
												    echo '<div class="category_square_avatar">'. get_avatar( $the_user, 60 ) . '</div>'; 

												    echo '<div class="author_des"><div class="category_square_author_name"><h4>' . $the_user->user_login . '</h4></div>';
												    
												    echo '<div class="category_square_author_subject">' .get_the_author_meta('subject', $user_id ). '</div>';?>
											    	<div class="category_square_number">
														 <!-- 
                                                        TODO: get the number of posts dynamcly
                                                        -->
                                                        38 שיעורים בספריה
													</div><?php } ?>
											</div>
													

											</div>
                                        
		<div class="category_square_oval">
                                               
             <?php
                $cat_parent = $cat->parent;
                $cat_parent;
                $cat_parent_name = get_cat_name( $cat_parent );
                        
                     /*echo '<span class="oval" style="background:'. $color .'; color:#ffffff; border:1px solid #' . $color .';">חדש</span>';*/
?>
               
                <form method="post" >

                    <input type="hidden" name="select_parent_oval"  value="<?php echo $cat_parent; $_POST['select_parent_oval']; ?>" />
                    <input type="submit" style="color:<?php echo $color; ?>" value="<?php echo $cat_parent_name; ?>" class="category_square_oval_submit"/>
                     
                    <?php 
                       $parent_cat = $_POST['select_parent_oval'];
                    ?>
            </form>
              
  

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
                        endforeach; } 
        ?>
				</ul>
				</div>
				
			</div>
			
				
			<?php 
/*end page category*/


/*page single category with list of posts*/
		} 

			else{?>
					
				<div class="page-header single_category_list">	
				
 
				<div class="col-md-12 header_category">	
					
					
					  
						<?php 
					 
						
						
						echo '<span class="glyphicon glyphicon-arrow-right" aria-hidden="true" style="color:#7f8a94;"></span> <a href="'.  esc_url( $category_link ) .'" style="font-size:18px; color:#7f8a94;">'.$parent_name .'</a>';
						?>
							

								<?php 
				    				$cat_image =  get_category_meta('image');
				    				$page_bg_image = wp_get_attachment_image($cat_image, 'category_image');
				    				$page_bg_image_url = $page_bg_image[0];
				    				$cat_name = get_category(get_query_var('cat'))->name;?>
				    				<?php $color =  get_category_meta('color'); ?>
				    	<div class="top_container">

				    		<div class="image_category" style=" background-color:<?php echo $color; ?>; ">
								
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 right-content" style="float:none;">
								
										
										<h5>
											<div class="category_square-format">
												<p><span class="glyphicon glyphicon-folder-open" style="padding-left:20px;"></span>
												<?php $values =  get_category_meta('type');
												foreach ($values as $value => $label) {
												    echo '<span>' . $value .'</span>' ;
												}
												$values = get_category_meta('format');
												foreach ($values as $value => $label) {
												    echo  '&nbsp; <span>' . $value . '</span>';
												}?>
											</p></div></h5>
				    			<?php
				    				echo '<div class="current_category_name":inline-block; style="padding-right:0px;"><h1 style="padding-top:20px; color:#ffffff;">'. $cat_name.'</h1></div>';
				    				 ?>
				    				 <div class="current_category_description" style="padding-right:0px; "><h4 style="color:#ffffff;"><?php $short_description = get_category_meta('short_description');
														echo $short_description;
														?></h4>
				    			</div>
				    			<div class="category_square_oval"><h4>
											<?php
												
											   			 echo '<span class="oval" style="color:#ffffff; border:1px solid #ffffff">חדש</span>';
													
													
													$values = get_category_meta('level');
													foreach ($values as $value => $label) {
											   			 echo '<span class="oval" style="border:1px solid #ffffff; color:#ffffff;">' . $value . '</span>';
													}

											?></h4>
											</div>
				    			</div>
				    			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 left-content" style="float:none;">
									<h5>
											<div class="category_square-format">
												<ul style="display:inline-block; padding-right:20px; border-right:1px solid #ffffff;">
													<li>12 שעות</br></br></li>
													<li><?php $values =  get_category_meta('level');
																	foreach ($values as $value => $label) {
																	    echo '<span>' . $value .'</span>' ;
																	}?></br></br>
													</li>
													<li>32 שיעורים</br></br></li>
													<li>32 לומדים</li>
												</ul>
											</div>
									</h5>		

				    			</div>
				    			
				    		</div>

				    		<div class="rail">
				    			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 " style="margin-top:0px;">
				    			<div><span style="float:left; padding-right:20px;">367</span>
				    				<span style="float:right; padding-left:20px;">24</span>
				    			<div class="progress"> 
									 <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
									     <span class="sr-only">40% Complete (success)</span>
								</div>
								</div>
									
								</div>
								</div>
				    			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 ">
				    			<a href="<?php echo get_category_link($cat->term_id); ?>"><button type="button" class="btn btn-default " style="background-color:#5fcf80; color:#ffffff;" aria-label="Left Align"><span class="glyphicon glyphicon-chevron-left" style="color:#ffffff;"></span> התחל </button></a>	
				    			<a href="<?php echo get_category_link($cat->term_id); ?>"><button type="button" class="btn btn-default " style="background-color:#e15258; color:#ffffff;" aria-label="Left Align"><span class="glyphicon glyphicon-dashboard" style="color:#ffffff;"></span> תזמן למעל </button></a>	
				    			</div>
				    			
				    		</div>
				    	</div>
				    		</div>
				    		
				    		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 " style="margin-top:20px;">
				    		<h4>מוסר שיעור</h4>
				    		<div class="box">

				    				
												<?php
													
												 $values = get_category_meta('authors');
												foreach ($values as $user_id) {
												    $the_user = get_user_by('id', $user_id);
												   

												    echo '<div class="author_des"><div class="category_square_author_name"><h4  style="margin-bottom:0px;">' . $the_user->user_login . '</h4></div></br>';
												    
												    echo '<div class="category_square_author_subject"><h4  style="margin-top:0px; padding-top:0px;"><small>' .get_the_author_meta('subject', $user_id ). '</small></h4></div>';

												    echo '<div class="category_square_author_subject"><h4><small>' .get_the_author_meta('description', $user_id ). '</small></h4></div>';	
												    ?>
											    	

											    	<div class="category_square_number">
														<h5><small>38 שיעורים בספריה</small></h5>
													</div>
													</div><?php 

													echo '<div class="category_square_avatar" style="vertical-align:top;">'. get_avatar( $the_user, 60 ) . '</div>'; 
													} ?>
							
											



				    		</div>
				    		</div>
				    		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 " style="margin-top:20px; ">
				    		<h4>אודות הסדרה</h4>
				    		<div class="box">
				    		<h4><?php echo category_description($cat->term_id);  ?></h4>
				    		</div>
				    		<h4 style="margin-top:40px;">32 שיעורים בסדרה זו</h4>
				    		<div class="box" style="padding:0px;">
				    		<h4><?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						
							

								

								  		<div style="border-bottom:1px solid #ccc; padding:10px;">
								  		<div style="display:inline-block; width:100%;">
								    	 <span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="padding-left:10px;"></span>
								    	 <span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
								    	 <span style="float:left;">18:23</span>
								    	<!--<p>By <?php the_author(); ?> on <?php echo the_time('l, F jS, Y'); ?> in <?php the_category( ', ' );?>.  <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></p>-->
								    			
								    		</div></div>
									<!--<?php the_excerpt(); ?>-->

								
							

						
				<?php endwhile; endif; 
			}
			?></h4></div>
				    		
				    		</div>
				</div>
			</div>
						
		<?php 

/*end page single category with list of posts*/

/*page library*/

		} else{ ?>
		<div class="page-header">
			<div class="col-md-12 header_category">	

					
					  
												

									<?php 
				    				$cat_image =  get_category_meta('image');
				    				$page_bg_image = wp_get_attachment_image($cat_image, 'category_image');
				    				$page_bg_image_url = $page_bg_image[0];
				    				$cat_name = get_category(get_query_var('cat'))->name;?>
				    				<div class="image_category" style="padding:20px; display: table; width:100%;">
				    				
				    					<div class="col-md-4" style="vertical-align:middle; display: table-cell;">
				    					<h4><small><ul style="color:#686969; line-height:30px; ">
				    					<li><span  class="circle">1</span> בחר קטגוריה</li>
				    					<li><span class="circle">2</span> בחר והוסף נושא לימוד</li>
				    					<li><span class="circle">3</span> הנושא התווסף לשיעורים שלך</li>
				    					</ul></small></h4>
					    				</div>
					    				
					    				 <div class="col-md-8" style="margin-top:0px; background-image:url(<?php echo $cat_image ?>); display:inline-block; background-repeat:no-repeat; background-size:contain; background-position:right;"><div class="current_category_name" style="color:#39add1; font-size:40px; line-height:40px;">
					    				 <?php $short_description = get_category_meta('short_description');
														echo $short_description;
														?>
										</div>
										<div class="current_category_description" style="padding-bottom:0px;">
					    				 <?php echo category_description($cat->term_id);  ?>
					    				</div>	</div>
					    				
					    				
					    				
					    				

				    				</div>
			</div>
		</div>
	</div>
	<div style="clear:both;"></div>
	</div></div>


		<?php $this_category = get_category($cat);
  if (get_category_children($this_category->cat_ID) != "") {?>
			<div class="categories sub_categories">

				<ul class="product_list" style="padding:0px;">


					<?php
					if (is_category()|| is_single()) {
						$this_category = get_category($cat);
						
					$id = get_query_var('cat');
					$args = array(	 'parent' => $this_category->cat_ID, 'hide_empty' => 0 );


 
					$count = 0;
					
						foreach (get_categories($args) as $cat) : 

							?>
							<div class="container-fluid">
							<div class="row">
							<div class="col-sm-12 ">
							<div class="col-sm-12 ">
								<h3><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->cat_name; ?></a></h3>
								<div ><h6><div style="display:inline-block;"><a href="<?php echo get_category_link($cat->term_id); ?>"><?php $short_description = get_category_meta('short_description', get_term_by('slug', $cat->cat_name, 'category'));
														echo $short_description;
														?></a></div>
														<div class="show_more" style="display:inline-block; float:left"><a href="<?php echo get_category_link($cat->term_id); ?>"><button type="button" class="btn btn-default btn-xs" aria-label="Left Align">הצג הכל</button></a></div></h6></div>

							

									
							</div></div></div></div>
							<div><?php
							$cat_image =  get_category_meta('image', get_term_by('slug', $cat->cat_name, 'category'));
				    				$page_bg_image = wp_get_attachment_image($cat_image, 'category_image');
				    				$page_bg_image_url = $page_bg_image[0];
				    				$cat_name = get_category(get_query_var('cat'))->name;?>
				    				<div class="image_category" style="background-image:url(<?php echo $cat_image ?>); background-repeat:no-repeat; background-size:contain; background-position:right;">


										<div class="container-fluid">
							<div class="row">
							<div class="col-sm-12 ">
									
									<?php 
						
					$id = get_query_var('cat');
					$args = array(	 'parent' => $cat->cat_ID, 'hide_empty' => 0, 'number' => 3, );


 
					$count = 0;
					
						foreach (get_categories($args) as $cat) : 


							
							$color = get_category_meta('color', get_term_by('slug', $cat->cat_name, 'category'));
													
													?>
									<div class="col-md-4 col-sm-12 col-xs-12 ">
									<li class="category_square"> 
										<div class="category_top_square" style="background:<?php echo $color; ?>">
											<p><span class="category_top_time">12 שעות</span>
											<span class="glyphicon glyphicon-folder-open" style="padding-right:20px;"></span></p>
										</div>
										<div class="category_square_content"><h5>
											<div class="category_square-format">
												<?php $values =  get_category_meta('type', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $value => $label) {
												    echo '<p><span>' . $value .'</span>' ;
												}
												$values = get_category_meta('format', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $value => $label) {
												    echo  '&nbsp; <span>' . $value . '</span></p>';
												}?>
											</div></h5>
										

											<h3><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->cat_name; ?></a></h3>
											<div class="category_square_description">
													<!--<?php echo category_description($cat->term_id); ?>-->
													<p><?php $short_description = get_category_meta('short_description', get_term_by('slug', $cat->cat_name, 'category'));
														echo $short_description;
														?></p>
											</div>

											<div class="category_square_author">
												<?php
													
												 $values = get_category_meta('authors', get_term_by('slug', $cat->cat_name, 'category'));
												foreach ($values as $user_id) {
												    $the_user = get_user_by('id', $user_id);
												    echo '<div class="category_square_avatar">'. get_avatar( $the_user, 60 ) . '</div>'; 

												    echo '<div class="author_des"><div class="category_square_author_name"><h4>' . $the_user->user_login . '</h4></div></br>';
												    
												    echo '<div class="category_square_author_subject"><h4><small>' .get_the_author_meta('subject', $user_id ). '</small></h4></div>';?>
											    	<div class="category_square_number">
														<h5><small>38 שיעורים בספריה</small></h5>
													</div></div>
													<?php } ?>

												
											
											
											</div><div style="clear:both;"></div>
											<div class="category_square_oval"><h4>
											<?php
												
											   			 echo '<span class="oval" style="background:'. $color .'; color:#ffffff; border:1px solid #' . $color .';">חדש</span>';
													
													$values = get_category_meta('subject', get_term_by('slug', $cat->cat_name, 'category'));
													foreach ($values as $value => $label) {
											   			 echo '<span class="oval" style="border:1px solid #b2bac2; color:'. $color .';">' . $value . '</span>';
													}
													$values = get_category_meta('level', get_term_by('slug', $cat->cat_name, 'category'));
													foreach ($values as $value => $label) {
											   			 echo '<span class="oval" style="border:1px solid #b2bac2; color:#b2bac2;">' . $value . '</span>';
													}

											?></h4>
											</div></li></div><?php endforeach;  ?>
										</div>

							</div></div>
				    		</div>
				    		</div>
							
							

												

					

						<?php endforeach; } ?>
				</ul>
				</div>
				<div class="container-fluid">
							<div class="row">
							<div class="col-sm-12 ">
				<?php } 

					else{
						if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article>

				    <div class="page-header">	
				    	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				    	<p>By <?php the_author(); ?> on <?php echo the_time('l, F jS, Y'); ?> in <?php the_category( ', ' );?>.  <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></p>
				    </div>				

					<?php the_excerpt(); ?>

				</article>
				<?php endwhile; endif; 
					}
				?>
			</div>

			
		<?php } ?>
		</div>

		

			
<?php get_footer(); ?>
				