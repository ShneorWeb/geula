<!DOCTYPE html>
<html ng-app="appgeula">
	<head> 
		<base href="/geula/">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
		<title><?php wp_title( '|', true, 'right' ); ?></title>		
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
		<![endif]-->
		<?php wp_head(); ?>
	</head> 
	<body>   
		<div id="wrap">
			<header class="header">
				<?php get_header(); ?>
			</header><!-- .header -->
			<div class="container">
				<div>
					<input type="text" ng-model="name">
			 
					<p>Hello, {{name}}!</p>
				</div>

				<div ng-view></div>

				<div class="sidebar">
				<?php get_sidebar(); ?>
			</div><!-- .sidebar -->
			


			<footer class="footer">
				<?php get_footer(); ?>
			</footer><!-- .footer -->
			</div><!--.container-->			
		</div><!-- #wrap -->
	</body>
</html>