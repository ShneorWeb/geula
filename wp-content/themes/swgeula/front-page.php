<?php get_header(); ?>	

        <div class="col-sm-9">									

				<div ng-view></div>

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
				