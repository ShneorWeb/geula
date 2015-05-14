<?php
/**
 * The template for displaying all single posts.
 *
 * @package swgeula
 */

get_header(); 

$parent_cat = get_the_category();
$parent_cat = $parent_cat[0];
$parent_cat_id = $parent_cat->cat_ID;
$parent_cat_name = $parent_cat->name;
$parent_cat_count = $parent_cat->count;

$user_id = get_the_author_meta('ID');                                     
$the_user = get_user_by('id', $user_id);
$user_post_count = count_user_posts( $user_id );

class MY_Post_Numbers {

                                private $count = 0;
                                private $posts = array();

                                public function display_count() {
                                    $this->init(); // prevent unnecessary queries
                                    $id = get_the_ID();
                                    echo __('שיעור', 'swgeula') . ' ' . $this->posts[$id] . ' ' . __('מתוך', 'swgeula') . ' ' . $this->count;
                                }

                                private function init() {
                                    if ( $this->count )
                                    return;
                                    $parent_cat = get_the_category();
                                    $parent_cat = $parent_cat[0];
                                    $parent_cat_id = $parent_cat->cat_ID;
                                    global $wpdb;
                                    $posts = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND ID IN ( SELECT object_id FROM {$wpdb->term_relationships} WHERE term_taxonomy_id = '"  . $parent_cat_id . "' ) ORDER BY post_date " );

                                    // can add or change order if you want
                                    $this->count = count($posts);


                                    foreach ( $posts as $key => $value ) {
                                        $this->posts[$value] = $key + 1;
                                    }
                                    unset($posts);
                                }

                            }

                            $GLOBALS['my_post_numbers'] = new MY_Post_Numbers;

                            function my_post_number() {
                                $GLOBALS['my_post_numbers']->display_count();
                            }

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

        <div class="archive_cont col-md-12">

		<?php while ( have_posts() ) : the_post(); ?>

        <?php
        $vidURL = sanitize_text_field( get_field('video_url') );
        $vidArray = explode("/", $vidURL);
        $vidID = $vidArray[count($vidArray)-1];      
        ?>

				<div class="page-header">
                    <div class="header_category">

                            <div class="back_to_libary">
                              <a href="<?php echo get_category_link($parent_cat->term_id ) ?>">
                                  <i class="fa fa-arrow-right"></i>
                                  <?php echo $parent_cat_name ?>
                              </a>
                            </div>

                    </div>
			     </div>
                 
            <div class="box sidebox mob">
                    <div class="lessonNumber">
                          <?php my_post_number(); ?>
                    </div>
                    <h2 class="name_of_single"><?php the_title(); ?></h2>

								<div class="previous_post_link">
                                    <?php previous_post_link_plus(array(
                                    'order_by' => 'post_date',

                                    'format' => '%link',

                                    'link' => '<i class="fa fa-long-arrow-right"></i>',

                                    'in_same_cat' => true,

                                    ) ); ?>

								</div>

								<div class="next_post_link">

                                    <?php next_post_link_plus(array(
                                    'order_by' => 'post_date',

                                    'format' => '%link',

                                    'link' => '<i class="fa fa-long-arrow-left"></i>',

                                    'in_same_cat' => true,

                                    ) ); ?>

								</div>

                  </div>
            
            
            <div class="row">

                <div class="col-md-9">



                    <script>                    
                    // 2. This code loads the IFrame Player API code asynchronously.
                    var tag = document.createElement('script');
                    var userID = <?php echo get_current_user_id(); ?>;
                    var lessonID = <?php echo get_the_ID();?>;
                    var ajaxurl = gbLocal?'/geula/wp-admin/admin-ajax.php':'/wp-admin/admin-ajax.php'; 

                    tag.src = "https://www.youtube.com/iframe_api";
                    var firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);


                    function setVideoPos(pos) {
                      var data = {        
                        action: 'video_played',
                        lesson_id: lessonID,
                        video_loc: pos,
                        user_id: userID
                      };                                                                                            
                      console.log( data );
                      jQuery.post(ajaxurl, data, function(data) {                    
                        //bDoNotPost[playerID]=true;                                                                                                                                                        
                        //jQuery("#jwplayer-"+playerID+"-views").text(data);                                    
                        console.log(data);
                      });
                    }
                    function getVideoPos(event) {
                      var data = {        
                        action: 'get_video_loc',
                        lesson_id: lessonID,                        
                        user_id: userID
                      };                                                      
                      console.log( data );
                      jQuery.post(ajaxurl, data, function(data) {                    
                        //bDoNotPost[playerID]=true;                                                                                                                                                        
                        //jQuery("#jwplayer-"+playerID+"-views").text(data);                                    
                        console.log(data);
                        if (jQuery.isNumeric( data )) {
                          curVidPos = data;                        
                          event.target.seekTo(curVidPos,true);
                          event.target.playVideo();
                          //update db that lesson has begun:
                          //var strid = jQuery(this).attr("id");
                          //var playerID = strid.substr(strid.indexOf("jwplayer-")+9);                                            
                          //if (curVidPos>0) setVideoPos(0);
                        }
                      });
                    }

                    function setDone() {
                      var data = {        
                        action: 'set_video_done',
                        lesson_id: lessonID,                        
                        user_id: userID
                      };                                                                                            
                      console.log( data );
                      jQuery.post(ajaxurl, data, function(data) {                    
                        //bDoNotPost[playerID]=true;                                                                                                                                                        
                        //jQuery("#jwplayer-"+playerID+"-views").text(data);                                    
                        console.log(data);
                      });
                    }

                    // 3. This function creates an <iframe> (and YouTube player)
                    //    after the API code downloads.
                    var player;
                    function onYouTubeIframeAPIReady() {
                      player = new YT.Player('vid_player', {                        
                        width: '1020',
                        height: '573',
                        videoId: '<?php echo $vidID;?>',
                        events: {
                          'onReady': onPlayerReady,
                          'onStateChange': onPlayerStateChange
                        }
                      });
                    }

                    // 4. The API will call this function when the video player is ready.
                    function onPlayerReady(event) {                      
                      getVideoPos(event);                      
                    }

                    
                    //var done = false;
                    function onPlayerStateChange(event) {
                      //if (event.data == YT.PlayerState.PLAYING && !done) {
                        //setTimeout(stopVideo, 6000);
                        //done = true;
                      //}
                      if (event.data == YT.PlayerState.ENDED) setDone();
                      else if (event.data == YT.PlayerState.PAUSED) setVideoPos(event.target.getCurrentTime());
                    }
                    function stopVideo() {
                      player.stopVideo();
                    }


                    jQuery( window ).unload(function() {
                      setVideoPos(player.getCurrentTime());
                      console.log("time="+player.getCurrentTime());
                      return false;
                    });
                  </script>

                    <div id="vid_player">
                        <!-- 16:9 aspect ratio -->
                        <!--<div class="embed-responsive embed-responsive-16by9">
                          <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/eNKzDlhbxmg?rel=0&amp;showinfo=0" frameborder="1"></iframe>
                        </div>-->
                    </div>

                    <div class="dtls box">
                        <div class="top">
                            <h1><?php the_title(); ?></h1>
                            <div class="length"><?php echo gmdate("H:i:s", getVideoDuration($vidID));?></div>
                        </div>
                         <div class="bottom">

                            <div class="text">
                                <?php the_content(); ?>
                             </div>

                             <div class="tabs">
                                 <div role="tabpanel">

                                      <!-- Nav tabs -->
                                      <ul class="nav nav-tabs" role="tablist" id="singleTabs">
                                        <li role="presentation" class="active"><a href="#discussion" aria-controls="discussion" role="tab" data-toggle="tab"><?php echo __('דיון', 'swgeula'); ?></a></li>
                                        <li role="presentation"><a href="#references" aria-controls="references" role="tab" data-toggle="tab"><?php echo __('מראה מקומות', 'swgeula'); ?></a></li>
                                        <li role="presentation"><a href="#downloads" aria-controls="downloads" role="tab" data-toggle="tab"><?php echo __('קבצים להורדה', 'swgeula'); ?></a></li>

                                      </ul>

                                      <!-- Tab panes -->
                                      <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="discussion">
                                           <?php
                                                // If comments are open or we have at least one comment, load up the comment template
                                                if ( comments_open() || get_comments_number() ) :
                                                    comments_template();
                                                endif;
                                            ?>
                                          </div>
                                        <div role="tabpanel" class="tab-pane fade" id="references">
                                          <?php the_field('CROSS_REFERENCES'); ?>
                                          </div>
                                        <div role="tabpanel" class="tab-pane fade" id="downloads">
                                          <?php

                                            // check if the repeater field has rows of data
                                            if( have_rows('downloads') ):

                                                // loop through the rows of data
                                                while ( have_rows('downloads') ) : the_row();

                                                    if( get_sub_field('dwnld_file') ):
                                                        ?>

                                                        <div class="single_dwnld_file">
                                                             <a href="<?php echo get_sub_field('dwnld_file'); ?>" download>                                                          <i class="fa fa-download"></i><?php echo get_sub_field('dwnld_file_name_and_desc'); ?>
                                                             </a>
                                                        </div>


                                                        <?php
                                                                endif;

                                                            endwhile;

                                                        else :

                                                            // no rows found

                                                        endif;

                                                        ?>
                                          </div>
                                      </div>

                                </div>
                             </div>
                        </div>

                    </div>




              </div>

              <div class="col-md-3">
                  <div class="box sidebox reg">
                    <div class="lessonNumber">
                          <?php my_post_number(); ?>
                    </div>
                    <h2 class="name_of_single"><?php the_title(); ?></h2>

											<div class="previous_post_link">

												<?php previous_post_link_plus(array(
													'order_by' => 'post_date',

			                    'format' => '%link',

			                    'link' => '<i class="fa fa-long-arrow-right"></i>',

			                    'in_same_cat' => true,

			                    ) ); ?>

											</div>

											<div class="next_post_link">

											<?php next_post_link_plus(array(
												'order_by' => 'post_date',

												'format' => '%link',

												'link' => '<i class="fa fa-long-arrow-left"></i>',

												'in_same_cat' => true,

												) ); ?>

										</div>

                  </div>
                  
                    <h3>
                        <?php echo __('מוסר שיעור', 'swgeula'); ?>
                    </h3>

                    <div class="box userdtls">
                           <?php                                
                                echo '<div class="category_square_avatar">'. get_avatar( $the_user->ID, 100 ) . '</div>'; 
                            ?>
                                   
                                    <div class="dtls">
                                        <?php
                                        echo '<div class="author_des"><div class="category_square_author_name">' . $the_user->display_name . '</div>';
                                        echo '<div class="category_square_author_subject">' .get_the_author_meta('subject', $user_id ). '</div>';

                            echo '<div class="category_square_author_subject desc">' .get_the_author_meta('description', $user_id ). '</div>';
                            ?>


                                        <div class="category_square_number">
                                            <?php echo $user_post_count . ' ' . __('lessons in the library', 'swgeula');  ?>
                                        </div>
                                    </div>
                                





                    </div>

            </div>

        </div>


		<?php endwhile; // end of the loop. ?>
            </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
