<?php get_header(); ?>	
<div class="row">
        <div class="col-md-9">					
				<div>
					<input type="text" ng-model="name">
			 
					<p>Hello, {{name}}!</p>
				</div>

				<div ng-view></div>
				</div>
				<div class="col-md-3">	
				
				
				<?php get_sidebar(); ?>
			<!-- .sidebar -->			
			</div>
			</div>
			<footer class="footer">
				<?php get_footer(); ?>
				