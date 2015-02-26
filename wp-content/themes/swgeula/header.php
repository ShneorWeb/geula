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


	<?php //if (!is_user_logged_in()) : ?>
    <script>
    jQuery.noConflict()

    (function($) {

		$(document).ready(function() {	
		/*	$j("a#inline1").fancybox({
				'modal': true,
				'padding':0,
				'margin':0,
			});				
			$j("a#inline1").click();*/
			
		});		

	})(jQuery);
	</script>  
    <?php //endif;?>  
</head> 

<body <?php body_class(); ?>>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">     
      <div class="contaner">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
           
          <a class="navbar-brand" href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a>
         
        </div><div style="float:left;"><?php 
            $args = array(
              'menu'        => 'header-menu',
              'menu_class'  => 'nav navbar-nav',
              'container'   => 'false'
            );
            wp_nav_menu( $args );
          ?></div>

        <div class="navbar-collapse collapse">

           
            <ul class="drop"  style="padding-right:0px; right:0;">
          <?php get_sidebar(); ?></ul>
          </div><!--/.navbar-collapse -->

      </div>
    </div>
    
   
      

   
		<div id="wrap">			
			<div class="container">
<div class="row">
    

        
