<?php get_header(); ?>						
				<div>
					<input type="text" ng-model="name">
			 
					<p>Hello, {{name}}!</p>
				</div>

				<div ng-view></div>

				<div class="sidebar">
				<?php get_sidebar(); ?>
			</div><!-- .sidebar -->			