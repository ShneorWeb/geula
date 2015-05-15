<?php 
if (is_user_logged_in()) {
	wp_safe_redirect(get_category_link(3));
} else {?>


<?php get_header(); ?>	

        <div class="col-sm-9" style="margin-top:100px;">									        						

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

          <?php the_content(); ?>
    
        <?php endwhile; endif; ?>
				</div>
				<div class="col-md-3">	
				
				
				<?php get_sidebar(); ?>
			<!-- .sidebar -->			
			</div>
			</div>

<?php get_footer(); ?>

<?php } //of else ?>						

