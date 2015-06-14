<?php
/*
Template Name: Scheduling
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
                    <a href="<?php 
                                if($gsLocaleShort=='he'){
                                    $temp2 = get_page_by_path('השיעורים-שלי');  
                                    echo get_permalink( $temp2->ID );
                                }
                                else{
                                   $temp2 = get_page_by_path('my-lessons');  
                                   echo get_permalink( $temp2->ID ); 
                                }
                             ?>">
                        <?php _e('my lessons', 'swgeula'); ?>
                    </a>
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
                     <a class="current">
                        <?php _e('Scheduling Lessons', 'swgeula'); ?>
                    </a>
                </div>

                <div class="image_category">

                   <h1><?php the_field('title', $post->ID); ?></h1>
                   <p><?php the_field('main_cont', $post->ID); ?></p>
                   <div class="mts"><div class="rect"></div><?php _e('Manned time strip', 'swgeula'); ?></div>
                   <div class="uts"><div class="rect"></div><?php _e('Unmanned time strip', 'swgeula'); ?></div>
                   <p class="small"><?php the_field('comment', $post->ID); ?></p>
               
                </div>
            
                <div class="clearfix"></div>
                  
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                
                <?php 

                $arrDays = array(7);

                $arrDays[0] = array('Sunday',7,"One");
                $arrDays[1] = array('Monday',1,"Two");
                $arrDays[2] = array('Tuesday',2,"Three");
                $arrDays[3] = array('Wednesday',3,"Four");
                $arrDays[4] = array('Thursday',4,"Five");
                $arrDays[5] = array('Friday',5,"Six");
                $arrDays[6] = array('Saturday',6,"Seven");                


                for ($indDays=0;$indDays<7;$indDays++)  :

                  $arrSlots = getScheduleSlotsForDay($arrDays[$indDays][1]);                 
                ?>

                  <div class="panel ">
                    <div class="panel-heading" role="tab" id="heading<?php echo $arrDays[$indDays][2];?>">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $arrDays[$indDays][2];?>" aria-expanded="<?php if ($indDays>0) echo "false"; else echo("true"); ?>" aria-controls="collapse<?php echo $arrDays[$indDays][2];?>">
                         <div class="day">
                             <?php _e($arrDays[$indDays][0], 'swgeula'); ?>
                         </div>
                        </a>
                      </h4>
                    </div>
                    <div id="collapse<?php echo $arrDays[$indDays][2];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $arrDays[$indDays][2];?>"><!-- add class 'in' to collapse panel-->
                      <div class="panel-body">
                      
                          <div class="table_schedule_cont">
                               <table class="schedule">
                                   <thead>
                                        <tr>
                                          <?php for ($i=7;$i<=12;$i++) {                                             
                                            echo ('<th><big>'.$i.'</big><small>'.($i<12?'AM':'PM').'</small></th>');
                                          }?>

                                          <?php for ($i=1;$i<=12;$i++) {                                             
                                            echo ('<th><big>'.$i.'</big><small>'.($i<12?'PM':'AM').'</small></th>');
                                          }?> 

                                          <?php for ($i=1;$i<=6;$i++) {                                                                                          
                                            echo ('<th><big>'.$i.'</big><small>AM</small></th>');
                                          }?>                                                                                                                                                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                           <?php for ($i=7;$i<=12;$i++) {                                            
                                            $rectIndex = $i*2;                                            
                                            echo('<td>'.
                                                '<a href="javascript:void(0)" onclick="addSchedule(this,'.$arrDays[$indDays][1].',\''.($i<11?'0'.$i:$i).':00\')"><div class="table_rect '.($arrSlots[$rectIndex]>0?($arrSlots[$rectIndex]==1?'yellow':'orange'):'green').'"></div></a>'.
                                                '<a href="javascript:void(0)" onclick="addSchedule(this,'.$arrDays[$indDays][1].',\''.($i<11?'0'.$i:$i).':30\')"><div class="table_rect '.($arrSlots[$rectIndex+1]>0?($arrSlots[$rectIndex]==1?'yellow':'orange'):'green').'"></div></a>'.
                                            '</td>');
                                          }?>                                            
                                          <?php for ($i=1;$i<=12;$i++) { 
                                             $rectIndex = ($i+12)*2;
                                             if ($rectIndex==48) $rectIndex=0;
                                             echo('<td>'.
                                                '<a href="javascript:void(0)" onclick="addSchedule(this,'.$arrDays[$indDays][1].',\''.($i<11?'0'.$i:$i).':00\')"><div class="table_rect '.($arrSlots[$rectIndex]>0?($arrSlots[$rectIndex]==1?'yellow':'orange'):'green').'"></div></a>'.
                                                '<a href="javascript:void(0)" onclick="addSchedule(this,'.$arrDays[$indDays][1].',\''.($i<11?'0'.$i:$i).':30\')"><div class="table_rect '.($arrSlots[$rectIndex+1]>0?($arrSlots[$rectIndex]==1?'yellow':'orange'):'green').'"></div></a>'.
                                            '</td>');
                                           }?> 
                                           <?php for ($i=1;$i<=6;$i++) { 
                                             $rectIndex = $i*2;     
                                             echo('<td>'.
                                                '<a href="javascript:void(0)" onclick="addSchedule(this,'.$arrDays[$indDays][1].',\''.$i.':00\')"><div class="table_rect '.($arrSlots[$rectIndex]>0?($arrSlots[$rectIndex]==1?'yellow':'orange'):'green').'"></div></a>'.
                                                '<a href="javascript:void(0)" onclick="addSchedule(this,'.$arrDays[$indDays][1].',\''.$i.':30\')"><div class="table_rect '.($arrSlots[$rectIndex+1]>0?($arrSlots[$rectIndex]==1?'yellow':'orange'):'green').'"></div></a>'.
                                            '</td>');
                                          }?> 
                                        </tr>
                                    </tbody>
                               </table>
                           </div>
                           
                      </div>
                    </div>
                  </div>                  
                <?php endfor; ?>                  
                </div>  
                   
                 
    </div>  
                     
      
</div>

<?php 
    } //of else not logged
?>
<?php get_footer(); ?>
        