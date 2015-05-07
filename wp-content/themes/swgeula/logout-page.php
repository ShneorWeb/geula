<?php
/*
Template Name: Logout Page
*/
?>
<?php 
	wp_logout();
	$redirect = "custom-login-page";
	wp_redirect( site_url($redirect) );
?>