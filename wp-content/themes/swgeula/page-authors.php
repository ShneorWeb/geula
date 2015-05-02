<?php
/*
Template Name: Authors Page
*/
get_header(); ?>	

<div class="col-lg-12 col-md-12 archive_cont">	

<div class="page-header">	
				

				<div class="header_category">	

					    <div class="back_to_libary">
                        
                            <h1><?php the_title(); ?></h1>
                          
                        </div>
				</div>
                
			</div>
        
			<div class="search_by">
                    
                <div class="search_text">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>  
                    <input type="search" placeholder="חיפוש">
                </div>

			</div>
    
            <div id="spinner"></div>				    	   	
		
			<div class="categories row">
                
                

				<ul class="product_list" style="padding:0px;">

					<?php
                    
      
					
                        
                        $args = array(
                                /* https://codex.wordpress.org/Function_Reference/get_users */
                                    'blog_id'      => 1,
                                    'role'         => 'Administrator',
                                 );
                                $blogusers = get_users( $args );
                                // Array of stdClass objects.
                                foreach ( $blogusers as $user ) :
                    
                    ?>

                           
							<div class="category_single col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                                <a href="<?php echo get_author_posts_url( $user->id ); ?>">
									<li class="category_square"> 
										
										<div class="category_square_content">                                         

											<div class="category_square_author">
												<?php
                        												    
                                                    //TODO : image from ofer function
												    echo '<div class="category_square_avatar">'. get_avatar( $user, 100 ) . '</div>'; 

												    echo '<div class="author_des"><div class="category_square_author_name"><h2>' . $user->display_name . '</h2></div>';
												    
												    echo '<div class="category_square_author_subject">' .$user->subject. '</div>';?>
                                                
                                                  <?php echo '<div class="category_square_author_subject desc">' .$user->description. '</div>';?>
                                                
											    	<div class="category_square_number">
														<?php 
                                                              
                                                            $user_post_count = count_user_posts( $user->id );
                                                            echo $user_post_count . ' ' . __('lessons in the library', 'swgeula');  
                                                        ?>
													</div>
											</div>
													

											</div>

                                        </div>
									</li>
                                </a>
							</div>

						<?php 
                       
                        endforeach; 
        ?>
				</ul>
				</div>
				
			</div>
        </div>
    </div>

</div>

<?php get_footer(); ?>
				