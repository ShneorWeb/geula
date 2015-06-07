<?php
/*
Template Name: Dashboard
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
                                <!--TODO : image from ofer function -->
                                <div class="category_square_avatar in_header">
                                    <?php echo get_avatar( $current_user->ID, 160 );?>
                                </div>
                                <div class="dtls">
                                    <div class="current_category_name">
                                             <h1><?php echo $current_user->display_name; ?></h1>
                                    </div>

                                    <div class="current_category_description">
                                        <?php echo $current_user->subject; ?>
                                    </div>

                                    <div class="current_category_description sub">
                                        <?php echo $current_user->description; ?>
                                    </div>

                                    <a href="<?php echo get_the_permalink('47'); ?>">
                                       <button class="edit_profile">
                                            <?php echo __('עריכת פרופיל', 'swgeula'); ?>
                                        </button>
                                    </a>

                                </div>

                   </div>
    </div>	
                     
    <div class="nextstage_block box">
      <div class="big_icon">
         <i class="fa fa-trophy">
             <div class="current_level">
           <?php
                // TODO: get the current level
                $current_level = 1;
                echo __('שלב', 'swgeula') . ' ' . $current_level; 
             ?>
         </div>
         </i>
         
      </div>
        <div class="dtls">
           
            <div class="first_title">
            <?php
                the_field('dashboard_first_title');echo ' ' . $current_user->display_name; 
            ?>
            </div>
            
            <div class="second_title">
                <?php the_field('dashboard_second_title'); ?>
            </div>
            
            <p>
                <?php
                    //TODO: get the number of points tahat user have
                    $total_points = 138;
                    echo __('צברת סה”כ', 'swgeula') . ' ' . $total_points . ' ' . __('נקודות', 'swgeula') 
                ?>
            </p>
            
            <div class="progress">
              <!-- TODO: get the status of bar-->
              <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                <span class="sr-only">20% Complete</span>
              </div>
            </div>
            
            <p>
                <?php
                    //TODO: get the number of points tahat user need to get to go to next level
                    $points_to_next_level = 770;
                    echo __('למד וצבור עוד', 'swgeula') . ' ' . $points_to_next_level . ' ' . __('נקודות כדי לעלות לשלב הבא', 'swgeula') 
                ?>
            </p>
            
            <?php
                        
            $rows = get_field('rabbi_quote_rep' ); // get all the rows
            $rand_row = $rows[ array_rand( $rows ) ]; // get a random row
            
            ?>
                    
                    <p class="rabbi_quote">
                        <?php echo $rand_row['rabbi_quote']; ?>
                    </p>

                    <p class="rabbi_quote_source">
                        <?php echo $rand_row['rabbi_quote_source']; ?>
                    </p>
            
        </div>

        
    </div>
                     
    <div class="box achievements_block">
       
        <div class="achievements_singles">
            <div class="row">
               <?php 
                for ($x = 0; $x <= 22; $x++) { ?>
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="achievements_single">
                       <div class="elipse"></div>
                       <div class="number_and_sub">
                            <b>8</b>
                            <p><?php echo __('נושא', 'swgeula'); ?></p>
                        </div>
                    </div>
                </div>
                <?php }  ?>
            </div>
        </div>
        
        <div id="donut-chart"></div>
        <script>
        Morris.Donut({
          element: 'donut-chart',
          resize: 'true',
          colors: ['#7d669e','#8FB28F'],
          data: [
            {label: "בית המקדש", value: 10 ,color:"#f9845b"},
            {label: "גאולה", value: 20,color:"#7d669e"},
            {label: "הלווים", value: 15},
            {label: "הכהנים", value: 12},
            {label: "משיח", value: 20},
            {label: "הרבי", value: 20}
          ]
        });
        </script>
    </div>
                      
                      		
    	    	   	
		
	
				
</div>
<?php
} //of else logged in
?>
<?php get_footer(); ?>
				