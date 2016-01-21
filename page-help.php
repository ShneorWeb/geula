<?php
/*
Template Name: Help
*/
get_header(); 

if (!is_user_logged_in()) {
  include_once("inc/not_logged_in_msg.php");
}
else {

$current_user = wp_get_current_user();
?>	


<div class="col-lg-12 col-md-12 archive_cont">	

    <div class="page-header">	
				
        <div class="header_category">	
                <div class="back_to_libary">

                        <h1><?php the_title(); ?></h1>

                     </div>
                </div>
                

                <div class="image_category">              
                      <?php the_content(); ?>
                   </div>
                   

    </div>	
                     
			
</div>

<?php 
    } //of else not logged
?>
<?php get_footer(); ?>
				