<?php
/**
 * The header for our theme.
 *
 * @package swgeula
 */
?><!DOCTYPE html>
<html ng-app="appgeula">
<head>
	<script>
		var newBase = document.createElement("base");
		newBase.setAttribute("href", document.location);
		document.getElementsByTagName("head")[0].appendChild(newBase);		
	</script>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/images/favicon.ico">

    <title>
      <?php wp_title( '|', true, 'right' ); ?>
      <?php bloginfo( 'name' ); ?>
    </title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<!-- Latest compiled and minified CSS -->
<!-- Latest compiled and minified CSS -->







</head>

<body <?php body_class(); ?> data-spy="scroll" data-target="#myScrollspy">

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a>
        </div>

        <div class="navbar-collapse collapse">

          <?php 
            $args = array(
              'menu'        => 'header-menu',
              'menu_class'  => 'nav navbar-nav',
              'container'   => 'false'
            );
            wp_nav_menu( $args );
          ?></div><!--/.navbar-collapse -->

      </div>
    </div>
   
    <div class="col-md-3 col-sm-4" id="myScrollspy">
 <ul class="nav nav-tabs nav-stacked" data-spy="affix" data-offset-top="195">
          
          <?php get_sidebar(); ?></ul></div>
      

   
		<div id="wrap">			
			<div class="container">


        