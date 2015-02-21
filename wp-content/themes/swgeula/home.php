<?php get_header(); ?>	

        <div class="col-sm-9">					
				<div>
					<input type="text" ng-model="name">
			 
					<p>Hello, {{name}}!</p>
				</div>

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



				<div class="col-md-3">	
			
				<!--/.navbar-collapse -->
				<?php get_sidebar(); ?>
			<!-- .sidebar -->			
			</div>
			</div>
			<footer class="footer">
				<?php get_footer(); ?>
				