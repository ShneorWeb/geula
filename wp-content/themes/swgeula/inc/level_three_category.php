<?php
  $cat_id = get_query_var('cat');
  $args = array(
      'category'         => $cat_id
  );
  $posts = get_posts($args); 
  $count = count($posts); 
  $arrPostIDs = array();
  foreach ( $posts as $post ) :    
      $arrPostIDs[] = $post->ID;
  endforeach;  
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

                                               $tempParent2 = get_category($cat_parent_id);

                                    ?>
                    
                                    <a href="<?php echo ($tempParent2->parent == getCatIDOfLibrary()?'':$tempParent2->slug);?>" class="category_square_oval_submit">
                                        <?php echo $cat_parent_name; ?>
                                    </a>

											
											</div>
                                    
                                    
				    			</div>
                                
				    			<div class="left-content">
									
											<div class="category_square-format">
												<ul class="single_cat_dtls">
                                                    <!-- TODO: get the length of corses need to come dynamclay -->
													<li><?php echo formatHoursMinutes(getTotalVideoDuration($arrPostIDs));?></li>
													<li><?php $values =  get_category_meta('level');
																	foreach ($values as $value => $label) {
																	    echo '<span>' . $value .'</span>' ;
																	}?>
													</li>
													<li><?php echo $count . ' ' . __('שיעורים', 'swgeula'); ?></li>
                                                    <!-- TODO: get the number of users need to come dynamclay -->	
                                                    <li><?php echo(getNumStudents($arrPostIDs));?> לומדים</li>
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
            <script> 
            /*
                var userID = <?php echo get_current_user_id(); ?>;
                var arrLessonIDs = new Array();

                (function($) {

                $(document).ready(function() {                   
                    
                     function getLessonStarted() {
                      var data = {        
                        action: 'get_lesson_started',
                        lesson_ids: arrLessonIDs.join(),                        
                        user_id: userID
                      };                                                                            
                      console.log( data );
                      jQuery.post(ajaxurl, data, function(data) {                                            
                        console.log(data);
                        var arrLessonStarted = eval(data);
                        for (var i=0;i<arrLessonStarted.length;i++) {
                          if (arrLessonStarted[i][1]=="1") {
                            $("i#"+arrLessonStarted[i][0]).removeClass('fa-chevron-left');
                            $("i#"+arrLessonStarted[i][0]).addClass('fa-check-circle');
                          }
                        }
                      });
                    }

                    getLessonStarted();

                });                        

              })(jQuery);

              */
              /*function secondsToTimeString(seconds) {
                return (new Date(seconds * 1000)).toUTCString().match(/(\d\d:\d\d:\d\d)/)[0];
              }*/
              </script>  

			         <?php
                $userID = get_current_user_id();
                $counter = 0;
                if ( have_posts() ) : while ( have_posts() ) : the_post();
                $counter +=1;

                $vidURL = sanitize_text_field( get_field('video_url') );
                $vidArray = explode("/", $vidURL);
                $vidID = $vidArray[count($vidArray)-1];
               ?>

                <script>
                                      
                  arrLessonIDs.push(<?php the_ID(); ?>);

                  /*(function($) {

                  $(document).ready(function() { 

                      var youTubeURL = 'http://gdata.youtube.com/feeds/api/videos/eNKzDlhbxmg?v=2&alt=json';
                      var json = (function () {
                          $.ajax({
                              'async': false,
                              'global': false,
                              'url': youTubeURL,
                              'dataType': "jsonp", // necessary for IE9
                              crossDomain: true,
                              'success': function (data) {
                                  var duration = data.entry.media$group.yt$duration.seconds;
                                  console.log(duration);
                                  $("#time-<?php the_ID();?>").text(secondsToTimeString(duration));
                              }
                          });
                      })();

                    });    

                  })(jQuery);*/    
              
                </script>  
						
							<div class="single_lesson_cont">
								    
								    <a href="<?php the_permalink(); ?>">
                                        <div class="name">                                            
                                            <i id="<?php the_ID();?>" class="fa <?php if (getLessonStarted(get_the_ID(),$userID)) echo('fa-check-circle'); else echo('fa-chevron-left');?>"></i>                                            
                                            <?php the_title(); ?>
                                        </div>
                                        <div class="time">                                            
                                            <?php echo gmdate("H:i:s", getVideoDuration($vidID));?>
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
							echo '<div class="category_square_avatar">'. get_avatar( $the_user->ID, 60 ) . '</div>'; 
                             ?>
                            <div class="dtls">
                                <?php
                                echo '<div class="author_des"><div class="category_square_author_name">' . $the_user->display_name . '</div>';
                                echo '<div class="category_square_author_subject">' .get_the_author_meta('subject', $user_id ). '</div>';

                    echo '<div class="category_square_author_subject desc">' .get_the_author_meta('description', $user_id ). '</div>';
                    ?>


                                <div class="category_square_number">
                                   <?php 
                                        $user_post_count = count_user_posts( $user_id );
                                        echo $user_post_count . ' ' . __('lessons in the library', 'swgeula');  
                                    ?>
                                </div>
                            </div>
                        <?php }?>
							
											



				    		</div>
				    		</div>
				    		
                    </div><!-- row -->
				</div>
			</div>