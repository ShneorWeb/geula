<?php
/*
Template Name: Custom_Profile
*/
get_header(); 

if (!is_user_logged_in()) {
  include_once("inc/not_logged_in_msg.php");
}
else {

?>

	<div ng-controller="Profile">					
        <div ng-include="template.url"></div>
	</div>
	
<?php
} //of else not logged
?>

<?php get_footer(); ?>				