<?php get_header(); ?>	

        <div class="col-md-9">					
				<div>
					<input type="text" ng-model="name">
			 
					<p>Hello, {{name}}!</p>
				</div>

				<div ng-view></div>
				<p class="pull-right visible-xs">
            		<button type="button" class="btn btn-primary btn-xs offcanvas-control" data-toggle="offcanvas">Sidebar <span class="glyphicon glyphicon-resize-horizontal"></span></button>
          		</p>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
				    <div class="page-header">	
				    	<h1><?php the_title(); ?></h1>
				    </div>


					<?php the_content(); ?>

				<?php endwhile; endif; ?>
				</div>



				<div class="col-md-3">	
			
				<!--/.navbar-collapse -->
				<?php get_sidebar(); ?>
			<!-- .sidebar -->			
			</div>
			</div>
			
				<?php get_footer(); ?>
				