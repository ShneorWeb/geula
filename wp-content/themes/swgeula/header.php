<<<<<<< HEAD
<head>
=======
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
>>>>>>> 1622975fcd9a395ad14f5f7f0d106eb4604e82b2
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
<<<<<<< HEAD
</head> 
=======
</head> 
<body>   
		<div id="wrap">			
			<div class="container">
>>>>>>> 1622975fcd9a395ad14f5f7f0d106eb4604e82b2
