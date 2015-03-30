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
				    		<h4>
                                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						
							

								

								  		<div style="border-bottom:1px solid #ccc; padding:10px;">
								  		<div style="display:inline-block; width:100%;">
								    	 <span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="padding-left:10px;"></span>
								    	 <span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
								    	 <span style="float:left;">18:23</span>
								    	<!--<p>By <?php the_author(); ?> on <?php echo the_time('l, F jS, Y'); ?> in <?php the_category( ', ' );?>.  <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></p>-->
								    			
								    		</div></div>
									<!--<?php the_excerpt(); ?>-->

								
							

						
				<?php endwhile; endif; ?>
                                </h4></div>
				    		
				    		</div>
				</div>
			</div>