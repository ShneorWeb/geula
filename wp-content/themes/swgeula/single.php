<?php
/**
 * The template for displaying all single posts.
 *
 * @package swgeula
 */

get_header(); ?>

<?php 
$parent_cat = get_the_category()[0];
$parent_cat_id = $parent_cat->cat_ID;
$parent_cat_name = $parent_cat->name;
$parent_cat_count = $parent_cat->count;
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            
        <div class="archive_cont col-md-12">	    

		<?php while ( have_posts() ) : the_post(); ?>

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
            <div class="row">
            
                <div class="col-md-9">
                    <div class="player">
                        <!-- 16:9 aspect ratio -->
                        <div class="embed-responsive embed-responsive-16by9">
                          <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/eNKzDlhbxmg?rel=0&amp;showinfo=0" frameborder="1"></iframe>
                        </div>

                    </div>
                    
                    <div class="dtls box">
                        <div class="top">
                            <h1><?php the_title(); ?></h1>
                            <div class="length"><?php the_field('length'); ?></div>
                        </div>
                         <div class="bottom">
                             
                            <div class="text">
                                <?php the_content(); ?>
                             </div>
                             
                             <div class="tabs">
                                 <div role="tabpanel">

                                      <!-- Nav tabs -->
                                      <ul class="nav nav-tabs" role="tablist">
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
                  <div class="box sidebox">
                    <div class="lessonNumber">
                          <?php 

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
                                    $parent_cat = get_the_category()[0];
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

                            my_post_number(); 

                        ?>
                    </div>  
                    <h2 class="name_of_single"><?php the_title(); ?></h2>  
                   <?php the_post_navigation(); ?>
                  </div>
              
              </div>

        </div>
            

		<?php endwhile; // end of the loop. ?>
            </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
