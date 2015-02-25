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
	<title><?php wp_title( '|', true, 'right' ); ?></title>
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
<body>   
		<div id="wrap">			
			<div class="container">

				<?php include_once("inc/user_log.php"); ?>