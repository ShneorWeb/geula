<?php
/*
Template Name: My Lessons
*/
get_header(); 

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

                                    <?php if($bScheduled){?>                                            
                                    <p><?php echo __('Your scheduled lesson is for', 'swgeula') . $lesson_date . " " . __('at', 'swgeula'). $lesson_time; ?> <a href="#" onclick="jQuery('#dp1').show();" class="schedule_new"><?php _e('schedule again', 'swgeula'); ?></a></p>  
                                            <div id="dp1" class="form-group" style="width:300px; display:none;">
                                                    <div class='input-group date' id='datetimepicker1'>
                                                        <input type='text' class="form-control" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                            </div> 
                                            <script>
                                                        jQuery(function () {                                                          
                                                            jQuery('#datetimepicker1').datetimepicker();
                                                            jQuery('#datetimepicker1').on('dp.change', function(e){
                                                                console.log(e.timeStamp);
                                                                setSchedule(e.timeStamp,25);
                                                            });
                                                        });
                                            </script>     
                                    <?php }?> 
                                     
                                    <?php if(!$bScheduled){?>                                    
                                           <button class="schedule_btn" onclick="jQuery('#dp1').show();">
                                                <i class="fa fa-clock-o"></i><?php _e('schedule learning', 'swgeula'); ?>                                                
                                            </button>                                                                                              
                                            <div id="dp1" class="form-group" style="width:300px; display:none;">
                                                    <div class='input-group date' id='datetimepicker1'>
                                                        <input type='text' class="form-control" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                            </div>                                                 
                                            <script>
                                                        jQuery(function () {                                                          
                                                            jQuery('#datetimepicker1').datetimepicker();
                                                            jQuery('#datetimepicker1').on('dp.change', function(e){
                                                                console.log(e.timeStamp);
                                                                setSchedule(e.timeStamp,25);
                                                            });
                                                        });
                                            </script>                                              
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
                            $bMyLessons=true;
                            $arrMyCats = array();
                            $tempArrMyCats = getMyCats();                            
                            if ( is_array($tempArrMyCats) && count($tempArrMyCats)>0 ) $arrMyCats = $tempArrMyCats;                                                         
                            echo __("series I'm learning", 'swgeula') . __("<span id='count-my-lessons'>") . __( (isset($arrMyCats) && is_array($arrMyCats))?count($arrMyCats):0) . __("</span>");
                            if ( count($arrMyCats)==0 ) $arrMyCats[] = -1;
                       ?>
                   </h3>
                   
                   <div class="row cat_cont">
                        <?php include_once("inc/category_boxes.php");?>
                   </div>
    </div>	
                     
			
</div>

<?php get_footer(); ?>
				