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

<script>
//console.log("moment=");
//moment.tz.add('America/Los_Angeles|PST PDT|80 70|0101|1Lzm0 1zb0 Op0');
//var jun = moment("2014-06-01T12:00:00Z");
//console.log( jun.tz('America/Los_Angeles').format('ha z') );
//moment().tz("America/Los_Angeles").format();
</script>

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
                    <?php
                    $curRoles = $current_user->roles;
                    $bShowLessonsInstruct = false;
                    foreach($curRoles as $tempRole) {
                        if ($tempRole == "instructor" || $tempRole == "administrator" || $tempRole == "editor" || $tempRole == "author") $bShowLessonsInstruct = true;
                    }

                    if ($bShowLessonsInstruct) {
                    ?>
                    <a href="<?php 
                                if($gsLocaleShort=='he'){
                                    $temp1 = get_page_by_path('שיעורים-שאני-מוסר');  
                                    echo get_permalink( $temp1->ID );
                                }
                                else{
                                   $temp1 = get_page_by_path('lessons-i-teach');  
                                   echo get_permalink( $temp1->ID ); 
                                }
                             ?>">
                        <?php _e('lessons I teach', 'swgeula'); ?>
                    </a>
                    <?php } ?>
                    <a href="
                               <?php 
                                if($gsLocaleShort=='he'){
                                    $temp2 = get_page_by_path('תזמון-שיעורים');  
                                    echo get_permalink( $temp2->ID );
                                }
                                else{
                                   $temp2 = get_page_by_path('scheduling-lessons');  
                                   echo get_permalink( $temp2->ID ); 
                                }
                                 ?>
                               ">
                                <?php _e('Scheduling Lessons', 'swgeula'); ?>
                            </a>
                </div>

                <div class="image_category">
                               
                               <?php 
                                    $arrNextScheduled = getNextScheduledCat($current_user->ID);                                                                                                           
                                    if ( is_array($arrNextScheduled) && (count($arrNextScheduled)>0) ) $bScheduled = true;
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
                                           <button class="schedule_btn" onclick="document.location.href='<?php  if($gsLocaleShort=='he'){
                                    $temp2 = get_page_by_path('תזמון-שיעורים');  
                                    echo get_permalink( $temp2->ID );
                                }
                                else{
                                   $temp2 = get_page_by_path('scheduling-lessons');  
                                   echo get_permalink( $temp2->ID ); 
                                } ?>'">
                                                <i class="fa fa-clock-o"></i><?php _e('schedule learning', 'swgeula'); ?>                                                
                                            </button>                                                                                                                                                                                        
                                    <?php }?>
                                        
                                        <h3 class="ltl_title">
                                            <?php 
                                            $arrDays = array(7);                                            
                                            $arrDays[0] = 'Monday';
                                            $arrDays[1] = 'Tuesday';
                                            $arrDays[2] = 'Wednesday';
                                            $arrDays[3] = 'Thursday';
                                            $arrDays[4] = 'Friday';
                                            $arrDays[5] = 'Saturday'; 
                                            $arrDays[6] = 'Sunday';


                                            $arrSchedule = getNextSchedule($current_user->ID);                                            

                                            if ($bScheduled) {
                                                _e('The next lesson is scheduled for', 'swgeula'); 
                                                if ($gsLocaleShort=="en") _e(' ','swgeula');
                                                _e($arrDays[(int)$arrSchedule[0]-1]);
                                                _e(' ');
                                                _e("@",'swgeula');
                                                _e(' ');
                                                _e($arrSchedule[1]);
                                            }
                                            else {
                                                _e("Next Lesson",'swgeula');
                                            }
                                            ?> 
                                        </h3>
                                        
                                        <div class="single_lesson_cont">
								    
                                            <a href="<?php echo get_permalink((int)getNextLessonToPlay((int)$arrNextScheduled[0]));?>">
                                                <div class="name">      
                                                  
                                                   <?php if(ICL_LANGUAGE_CODE=='he'){?>                              
                                                    <i class="fa fa-chevron-left"></i>            
                                                    <?php }else{?>
                                                    <i class="fa fa-chevron-right"></i>  
                                                    <?php } ?>
                                                    
                                                    <?php                                                                                                                            
                                                    if ( $bScheduled) {                                                        
                                                        $temp = get_post((int)getNextLessonToPlay((int)$arrNextScheduled[0]));                                                        
                                                        echo $temp->post_title;                                                        
                                                    }
                                                    elseif ( is_array($tempArrMyCats) && (count($tempArrMyCats)>0) ) {
                                                        _e("start learning to get updated with next lesson","swgeula");
                                                    } 
                                                    else _e("add series and start learning to get updated with next lesson","swgeula");                                                    
                                                    ?>
                                                </div>
                                                <div class="time">                                            
                                                    <?php                                                    
                                                    if ( is_array($arrSchedule) && count($arrSchedule)>1 ) {                                                        
                                                        echo($arrSchedule[1]);
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
                            echo __("series I'm learning", 'swgeula') . __("<span id='count-my-lessons-learn'>") . __( (isset($arrMyCats) && is_array($arrMyCats))?count($arrMyCats):0) . __("</span>");
                            if ( count($arrMyCats)==0 ) $arrMyCats[] = -1;
                            $NumberSpanID = "count-my-lessons-learn";                            
                       ?>
                   </h3>
                   
                   <div class="row cat_cont">                    
                        <?php if ($arrMyCats[0]!=-1) include("inc/category_boxes.php");?>
                   </div>
                   
                    <h3 class="ltl_title">
                       <?php                                                             
                            $arrMyCats = null;              
                            if ( is_array($tempArrMyCats2) && count($tempArrMyCats2)>0 ) $arrMyCats = $tempArrMyCats2;                                                                                     
                            echo __("series I added", 'swgeula') . __("<span id='count-my-lessons-add'>") . __( (isset($arrMyCats) && is_array($arrMyCats))?count($arrMyCats):0) . __("</span>");                            
                            if ( count($arrMyCats)==0 ) $arrMyCats[] = -1;
                            $NumberSpanID = "count-my-lessons-add";                            
                       ?>
                   </h3>
                   
                   <div class="row cat_cont">                    
                        <?php if ($arrMyCats[0]!=-1)  include("inc/category_boxes.php");?>
                   </div>
    </div>	
                     
			
</div>

<?php 
    } //of else not logged
?>
<?php get_footer(); ?>
				