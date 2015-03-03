<?php
/*
Template Name: Custom_Profile
*/
?>

<?php include_once("header.php");?>


	<div class="col-sm-9" style="margin-top:100px;">		
				
				<div ng-controller="Profile">					
					<div ng-include="template.url"></div>
				</div>
	</div>


<?php get_footer(); ?>				