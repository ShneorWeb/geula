<?php get_header(); ?>						
				
				<?php				;
				//echo("lang=".WPLANG);
				?>
				<?php _e("hello world","swgeulatr");?>

				<?php _e("Web site","swgeulatr");?>

				<div class="sidebar">

				</div>
				<div class="col-md-3">				
				
				<div ng-controller="Profile">
					<div ng-view></div>
				</div>					

				<!-- .sidebar -->				
				<?php get_sidebar(); ?>
			
			</div>
			</div>
		
<?php get_footer(); ?>
				
