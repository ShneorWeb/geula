<?php
/**
 * The template for displaying all single posts.
 *
 * @package swgeula
 */

get_header(); ?>

<?php 
$parent_cat = get_the_category()[0];

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
                                  <?php echo $parent_cat->name ?>
                              </a>
                            </div>

                            <?php 
                                        $cat_image =  get_category_meta('image');
                                        $page_bg_image = wp_get_attachment_image($cat_image, 'category_image');
                                        $page_bg_image_url = $page_bg_image[0];
                                        $cat_name = get_category(get_query_var('cat'))->name;

                            ?>

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
                                        <div role="tabpanel" class="tab-pane fade" id="references">...</div>
                                        <div role="tabpanel" class="tab-pane fade" id="downloads">...</div>
                                      </div>

                                </div>
                             </div>
                        </div>
                       
                    </div>

                

               
              </div>
                
              <div class="col-md-3">
               <?php the_post_navigation(); ?>
              </div>

        </div>
            

		<?php endwhile; // end of the loop. ?>
            </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
