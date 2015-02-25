<?php get_header(); ?>						

				<div ng-view></div>
				<?php				;
				//echo("lang=".WPLANG);
				?>
				<?php _e("hello world","swgeulatr");?>

				<?php _e("Web site","swgeulatr");?>

				<div class="sidebar">

				</div>
				<div class="col-md-3">	
				
				
				<!-- .sidebar -->				
				<?php get_sidebar(); ?>
			
			</div>
			</div>
		
<?php get_footer(); ?>
				
