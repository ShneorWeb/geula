<?php
/**
 * The header for our theme.
 *
 * @package swgeula
 */
?><!DOCTYPE html>
<html>
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
    
  <script src="https://apis.google.com/js/client:platform.js" async defer></script>

	<?php wp_head(); ?>


	<?php //if (!is_user_logged_in()) : ?>
    <script> 

    (function($) {

		$(document).ready(function() {                   
        $(".sidebar .menu a:not([href$='edit-profile/'])").attr("target","_self");
        $(".nav .menu-item a:not([href$='edit-profile/'])").attr("target","_self");


        if (document.location.href.indexOf("#eprf")!=-1) {
            angular.element(document).ready(function() {
              angular.bootstrap(document,['appgeula']);                 
            });
        }
		});		

  

	})(jQuery);
	</script>  

    <?php //endif;?>  
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
           
          <a class="navbar-brand" href="<?php bloginfo( 'url' ); ?>" target="_self"><?php bloginfo( 'name' ); ?></a>
         
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
			<div class="container-fluid">
<div class="row" style="margin-top:32px;">
    

        
