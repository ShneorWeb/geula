<?php
  $cat_id = get_query_var('cat');
  $args = array(
      'category'         => $cat_id
  );
  $posts = get_posts($args); 
  $count = count($posts); 
?>

<div class="page-header single_category_list">	
				
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
                                $color =  get_category_meta('color'); 
                            ?>

				    		<div class="image_category" style=" background-color:<?php echo $color; ?>; ">
								
								<div class="right-content">
                                    
								    <div class="category_square-format">
                                                <!--TODO: GET the icon dunamly -->
                                                <i class="icon-type-of-lesson-icon-1"></i>
                                        
                                                <?php $values =  get_category_meta('type');
												foreach ($values as $value => $label) {
												    echo '<span>' . $value .'</span>' ;
												}
												$values = get_category_meta('format');
												foreach ($values as $value => $label) {
												    echo  '<span>' . $value . '</span>';
												}?>
                                    </div>
				    			     <div class="current_category_name">
                                        <h1><?php echo $cat_name; ?></h1>
                                    </div>
				    				 
				    				 <div class="current_category_description">
                                         <h2>
                                             <?php
                                                $short_description = get_category_meta('short_description');
												echo $short_description;
								             ?>
                                         </h2>
				    			</div>
				    			<div class="category_square_oval">
								    <?php
								        //TODO: get the 'new' tag dynamclay from site
								       	echo '<span class="oval">חדש</span>';
								    	
								    	$values = get_category_meta('level');
								    	foreach ($values as $value => $label) {
								       		 echo '<span class="oval">' . $value . '</span>';
								    	}
                                               
                                               $cat = get_queried_object();
                                               $cat_slug =  $cat->slug;
                                               $cat_parent_id = $cat->parent;

                                               $cat_parent_object = get_category($cat_parent_id);
                                               $cat_parent_slug = $cat_parent_object->slug;
                                               $cat_parent_name = get_cat_name( $cat_parent_id );

                                               $cat_grandparent_id = $cat_parent_object->parent;
                                               $cat_grandparent_object = get_category($cat_grandparent_id);
                                               $cat_grandparent_slug = $cat_grandparent_object->slug;

                                    ?>
                    
                                    <a href="<?php echo site_url() . '/category/' . $cat_grandparent_slug.'?select_parent='.$cat_parent_id; ?>" class="category_square_oval_submit">
                                        <?php echo $cat_parent_name; ?>
                                    </a>

											
											</div>
                                    
                                    
				    			</div>
                                
				    			<div class="left-content">
									
											<div class="category_square-format">
												<ul class="single_cat_dtls">
                                                    <!-- TODO: get the length of corses need to come dynamclay -->
													<li>12 שעות</li>
													<li><?php $values =  get_category_meta('level');
																	foreach ($values as $value => $label) {
																	    echo '<span>' . $value .'</span>' ;
																	}?>
													</li>
													<li><?php echo $count . ' ' . __('שיעורים', 'swgeula'); ?></li>
                                                    <!-- TODO: get the number of users need to come dynamclay -->	
                                                    <li>32 לומדים</li>
												</ul>
											</div>
											

				    			</div>
				    			
				    		</div>

				    		<div class="rail">
                                
                                <div class="rail--btns">
                                    <!--TODO: what link is need to go to? -->
                                    <a href="#" id="playBtnCont">
                                        <button type="button" class="btn btn-default playBtn">
                                            <i class="fa fa-play fa-flip-horizontal"></i> 
                                                <?php echo __('התחל', 'swgeula'); ?>
                                        </button>
                                    </a>	
                                    <!--TODO: what link is need to go to? -->
                                    <a href="#">
                                        <button type="button" class="btn btn-default getAfter" >
                                            <i class="fa fa-clock-o"></i>  
                                                <?php echo __('תזמן למעגל', 'swgeula'); ?>
                                        </button>
                                    </a>	
				    			</div>
                                
				    			<div class="rail--timeline">
                                    
                                        <span class="start_number" >367</span>
                                        <span class="end_number" >24</span>
                                    
                                        <div class="progress"> 
                                            <!--TODO: get the status of progress dynamclay -->
                                             <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                 <span class="sr-only">40% Complete (success)</span>
                                             </div>
                                        </div>

								</div>
				    			
				    			
				    		</div>
				    
	</div><!-- header_category -->
    
    <div class="row">
        
        <div class="col-lg-8 col-md-8">
            <h3>
                <?php echo __('אודות הסדרה', 'swgeula'); ?>
            </h3>
			<div class="box">
			    <?php echo category_description($cat->term_id);  ?>
			</div>
            
            <h3>
                <?php echo $count . ' ' . __('שיעורים בסדרה זו', 'swgeula'); ?>
            </h3>
			<div class="box contOfSingPosts">
			 <?php
                $counter = 0;
                if ( have_posts() ) : while ( have_posts() ) : the_post();
                $counter +=1;
                ?>
						
							<div class="single_lesson_cont">
								    
								    <a href="<?php the_permalink(); ?>">
                                        <div class="name">
                                            <!-- TODO:
                                    put the v icon if this post was seen and not just for the first post like now...
                                            -->
                                            <?php if($counter == 1) { ?>
                                            <i class="fa fa-check-circle"></i>
                                            <?php }else{ ?>
                                            <i class="fa fa-chevron-left"></i>
                                            <?php } ?>
                                            <?php the_title(); ?>
                                        </div>
                                        <div class="time">
                                            <!--TODO: get the time of posts from cf ? -->
                                            18:23
                                        </div>
                                    </a>
								</div>
                
				    <?php endwhile; endif; ?>
                                
				    		
		  </div>
        
        </div>
        
	   <div class="col-lg-4 col-md-4">
			<h3>
                <?php echo __('מוסר שיעור', 'swgeula'); ?>
            </h3>
			<div class="box userdtls">
                   <?php
				    $values = get_category_meta('authors');
						foreach ($values as $user_id) {
							$the_user = get_user_by('id', $user_id);
                            //TODO : image from ofer function
							echo '<div class="category_square_avatar">'. get_avatar( $the_user, 100 ) . '</div>'; 
                             ?>
                            <div class="dtls">
                                <?php
                                echo '<div class="author_des"><div class="category_square_author_name">' . $the_user->display_name . '</div>';
                                echo '<div class="category_square_author_subject">' .get_the_author_meta('subject', $user_id ). '</div>';

                    echo '<div class="category_square_author_subject desc">' .get_the_author_meta('description', $user_id ). '</div>';
                    ?>


                                <div class="category_square_number">
                                    <!-- 
                                     TODO: get the number of posts dynamcly
                                      -->
                                    38 שיעורים בספריה
                                </div>
                            </div>
                        <?php }?>
							
											



				    		</div>
				    		</div>
				    		
                    </div><!-- row -->
				</div>
			</div>