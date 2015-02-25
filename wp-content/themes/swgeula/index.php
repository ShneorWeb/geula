<?php get_header(); ?>						
				<!--<div>
					<input type="text" ng-model="name">
			 
					<p>Hello, {{name}}!</p>
				</div>-->

				<?php //echo do_shortcode('[login_widget]'); ?>

				<div ng-view></div>
				<?php				;
				//echo("lang=".WPLANG);
				?>
				<?php _e("hello world","swgeulatr");?>

				<?php _e("Web site","swgeulatr");?>

				<div class="sidebar">
				<?php get_sidebar(); ?>
			</div><!-- .sidebar -->			