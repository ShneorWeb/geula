<?php
/*
Template Name: Logout Page
*/
?>
<?php 
	wp_logout();
	$redirect = "my-account/sign-in/";
	wp_redirect( site_url($redirect) );
?>