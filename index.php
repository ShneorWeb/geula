<!DOCTYPE html>
	<head>
		 <meta charset="<?php bloginfo( 'charset' ); ?>">
		 <meta name="viewport" content="width=device-width">
		 <title><?php wp_title( '|', true, 'right' ); ?></title>
		 <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
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
			<div class="content">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="post-header">
								<div class="date"><?php the_time( 'M j y' ); ?></div>
								<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
								<div class="author"><?php the_author(); ?></div>
							</div><!--.post-header-->
							<div class="entry clear">
								<?php if ( function_exists( 'add_theme_support' ) ) the_post_thumbnail(); ?>
								<?php the_content(); ?>
								<?php edit_post_link(); ?>
								<?php wp_link_pages(); ?>
							</div><!--. entry-->
							<footer class="post-footer">
								<div class="comments"><?php comments_popup_link( 'Leave a Comment', '1 Comment', '% Comments' ); ?></div>
							</footer><!--.post-footer-->
						</div><!-- .post-->
					<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
						<nav class="navigation index">
							<div class="alignleft"><?php next_posts_link( 'Older Entries' ); ?></div>
							<div class="alignright"><?php previous_posts_link( 'Newer Entries' ); ?></div>
						</nav><!--.navigation-->
					<?php else : ?>
				<?php endif; ?>
			</div><!--.content-->
			<div class="sidebar">
				<?php get_sidebar(); ?>
			</div><!-- .sidebar -->
			<footer class="footer">
				<?php get_footer(); ?>
			</footer><!-- .footer -->
		</div><!-- #wrap -->
	</body>
</html>