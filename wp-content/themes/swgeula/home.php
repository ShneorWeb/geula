<?php get_header(); ?>	

    <div class="col-md-12">									

				<div ng-view></div>
				<p class="pull-right visible-xs">
            		<button type="button" class="btn btn-primary btn-xs offcanvas-control" data-toggle="offcanvas">Sidebar <span class="glyphicon glyphicon-resize-horizontal"></span></button>
          		</p>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article>

				    <div class="page-header">	
				    	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				    	<p>By <?php the_author(); ?> on <?php echo the_time('l, F jS, Y'); ?> in <?php the_category( ', ' );?>.  <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></p>
				    	
				    </div>				

					<?php the_excerpt(); ?>

				</article>
				<?php endwhile; endif; ?>
				</div>
				<div class="col-md-12" style="margin-top:30px;" >
				 <div class="row">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="col-sm-4 portfolio-piece">
					<?php 
						$thumb_id = get_post_thumbnail_id();
						$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);						
					 ?>
					<p><a href="<?php the_permalink(); ?>"><img src="<?php echo $thumb_url[0]; ?>"></a></p>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p><a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a></p>

			</div>

			<?php $count = $the_query->current_post + 1; ?>
			<?php if( $count % 3 == 0): ?>

			</div><div class="row">
			
			<?php endif; ?>

			<?php endwhile; endif; ?>

	    </div></div>



				<div class="">	
			
				<!--/.navbar-collapse -->
				<?php get_sidebar(); ?>
			<!-- .sidebar -->			
			</div>
			
			</div>
				<?php get_footer(); ?>
				