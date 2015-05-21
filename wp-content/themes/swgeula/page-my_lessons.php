<?php
/*
Template Name: My Lessons
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
                
                <div class="box menu">
                   <a class="current">
                        <?php _e('my lessons', 'swgeula'); ?>
                    </a>
                    <a href="<?php echo esc_url( get_permalink( get_page_by_title( __('lessons I teach', 'swgeula') ) ) ); ?>">
                        <?php _e('lessons I teach', 'swgeula'); ?>
                    </a>
                </div>

                <div class="image_category">
                               
                               <?php 
                                    $arrNextScheduled = getNextSchedulesCat();
                                    if ( is_array($arrNextScheduled) && count($arrNextScheduled)>0 ) $bScheduled = true;
                                    else $bScheduled = false;

                                    $bMyLessons=true;
                                    $arrMyCats = array();
                                    $tempArrMyCats = getMyCatsStudied();   
                                    $tempArrMyCats2 = getMyCatsNotYetStudied();   
                                ?>
                                
                                <div class="big_icon">
                                    <i class="fa fa-calendar-o"></i>
                                    <?php if($bScheduled){?>
                                        <div class="status v"><i class="fa fa-check"></i></div>
                                    <?php }else{?>
                                        <div class="status x"><i class="fa fa-times"></i></div>
                                    <?php }?>
                                </div>
                                <div class="dtls">
                                    
                                    <h2>
                                       <?php if($bScheduled){?>
                                       <?php the_field('title_is_lessons'); ?>
                                       <?php }else{?>
                                       <?php the_field('title_no_lessons'); ?>
                                       <?php }?>
                                    </h2>                                
                                    <?php if(!$bScheduled){?>                                    
                                           <button class="schedule_btn">
                                                <i class="fa fa-clock-o"></i><?php _e('schedule learning', 'swgeula'); ?>                                                
                                            </button>                                                                                                                                                                                        
                                    <?php }?>
                                        
                                        <h3 class="ltl_title">
                                            <?php _e('next lesson', 'swgeula'); ?>
                                        </h3>
                                        
                                        <div class="single_lesson_cont">
								    
                                            <a href="#">
                                                <div class="name">                                            
                                                    <i class="fa fa-chevron-left"></i>            
                                                    <?php                                                                                                                            
                                                    if ( is_array($arrNextScheduled) && count($arrNextScheduled)>0 ) {
                                                        $tempCatObj = get_category($arrNextScheduled[0]);                                                                                                        
                                                        echo($tempCatObj->name);
                                                    }
                                                    elseif ( is_array($tempArrMyCats) && (count($tempArrMyCats)>0) ) {
                                                        _e("start learning to get updated with next lesson","swgeula");
                                                    } 
                                                    else _e("add series and start learning to get updated with next lesson","swgeula");                                                    
                                                    ?>
                                                </div>
                                                <div class="time">                                            
                                                    <?php                                                    
                                                    if ( is_array($arrNextScheduled) && count($arrNextScheduled)>0 ) {                                                        
                                                        echo($arrNextScheduled[1]);
                                                    }
                                                    ?> 
                                                 </div>
                                            </a>
                                        
                                    </div>
                                        
                                </div>

                   </div>
                   
                   <h3 class="ltl_title">
                       <?php                                                    
                            if ( is_array($tempArrMyCats) && count($tempArrMyCats)>0 ) $arrMyCats = $tempArrMyCats;                                                         
                            echo __("series I'm learning", 'swgeula') . __("<span id='count-my-lessons'>") . __( (isset($arrMyCats) && is_array($arrMyCats))?count($arrMyCats):0) . __("</span>");
                            if ( count($arrMyCats)==0 ) $arrMyCats[] = -1;
                       ?>
                   </h3>
                   
                   <div class="row cat_cont">
                        <?php if ($arrMyCats[0]!=-1) include_once("inc/category_boxes.php");?>
                   </div>
                   
                    <h3 class="ltl_title">
                       <?php                                                             
                            $arrMyCats = null;              
                            if ( is_array($tempArrMyCats2) && count($tempArrMyCats2)>0 ) $arrMyCats = $tempArrMyCats2;                                                                                     
                            echo __("series I added", 'swgeula') . __("<span id='count-my-lessons'>") . __( (isset($arrMyCats) && is_array($arrMyCats))?count($arrMyCats):0) . __("</span>");
                            if ( count($arrMyCats)==0 ) $arrMyCats[] = -1;
                       ?>
                   </h3>
                   
                   <div class="row cat_cont">
                        <?php if ($arrMyCats[0]!=-1)  include_once("inc/category_boxes.php");?>
                   </div>
    </div>	
                     
			
</div>

<?php 
    } //of else not logged
?>
<?php get_footer(); ?>
				