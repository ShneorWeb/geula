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
                  <div class="panel ">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                         <div class="day">
                             <?php _e('Sunday', 'swgeula'); ?>
                         </div>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                      
                          <div class="table_schedule_cont">
                               <table class="schedule">
                                   <thead>
                                        <tr>
                                            <th>
                                                <a href="javascript:void(0)" onclick="addSchedule(2,'07:00')"><big>7</big><small>AM</small></a>
                                            </th>
                                            <th>
                                                <big>8</big><small>AM</small>
                                            </th>
                                             <th>
                                                <big>9</big><small>AM</small>
                                            </th>
                                            <th>
                                                <big>10</big><small>AM</small>
                                            </th>
                                             <th>
                                                <big>11</big><small>AM</small>
                                            </th>
                                            <th>
                                                <big>12</big><small>AM</small>
                                            </th>
                                             <th>
                                                <big>1</big><small>PM</small>
                                            </th>
                                            <th>
                                                <big>2</big><small>PM</small>
                                            </th>
                                            <th>
                                                <big>1</big><small>PM</small>
                                            </th>
                                            <th>
                                                <big>3</big><small>PM</small>
                                            </th>
                                            <th>
                                                <big>4</big><small>PM</small>
                                            </th>
                                            <th>
                                                <big>5</big><small>PM</small>
                                            </th>
                                            <th>
                                                <big>6</big><small>PM</small>
                                            </th>
                                            <th>
                                                <big>7</big><small>PM</small>
                                            </th>
                                            <th>
                                                <big>8</big><small>PM</small>
                                            </th>
                                            <th>
                                                <big>9</big><small>PM</small>
                                            </th>
                                            <th>
                                                <big>10</big><small>PM</small>
                                            </th>
                                            <th>
                                                <big>11</big><small>PM</small>
                                            </th>
                                              <th>
                                                <big>12</big><small>PM</small>
                                            </th>
                                             <th>
                                                <big>1</big><small>AM</small>
                                            </th>
                                             <th>
                                                <big>2</big><small>AM</small>
                                            </th>
                                             <th>
                                                <big>3</big><small>AM</small>
                                            </th>
                                             <th>
                                                <big>4</big><small>AM</small>
                                            </th>
                                             <th>
                                                <big>5</big><small>AM</small>
                                            </th>
                                             <th>
                                                <big>6</big><small>AM</small>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect yellow"></div>
                                            </td>
                                              <td>
                                                <div class="table_rect"></div>
                                                <div class="table_rect"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect green"></div>
                                                 <div class="table_rect"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect yellow"></div>
                                                 <div class="table_rect"></div>
                                            </td>
                                             <td>
                                                <div class="table_rect yellow"></div>
                                                 <div class="table_rect"></div>
                                            </td>
                                             <td>
                                                <div class="table_rect yellow"></div>
                                                 <div class="table_rect"></div>
                                            </td>
                                             <td>
                                                <div class="table_rect"></div>
                                                <div class="table_rect"></div>
                                            </td>
                                              <td>
                                                <div class="table_rect"></div>
                                                <div class="table_rect"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect yellow"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect yellow"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect green"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect"></div>
                                                <div class="table_rect"></div>
                                            </td>
                                             <td>
                                                <div class="table_rect"></div>
                                                <div class="table_rect"></div>
                                            </td>
                                             <td>
                                                <div class="table_rect"></div>
                                                <div class="table_rect"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect"></div>
                                                <div class="table_rect"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect yellow"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect yellow"></div>
                                            </td>
                                             <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect yellow"></div>
                                            </td>
                                             <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect yellow"></div>
                                            </td>
                                             <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect yellow"></div>
                                            </td>
                                              <td>
                                                <div class="table_rect"></div>
                                                <div class="table_rect"></div>
                                            </td>
                                              <td>
                                                <div class="table_rect"></div>
                                                <div class="table_rect"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect yellow"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect yellow"></div>
                                            </td>
                                            <td>
                                                <div class="table_rect green"></div>
                                                <div class="table_rect yellow"></div>
                                            </td>
                                        </tr>
                                    </tbody>
                               </table>
                           </div>
                           
                      </div>
                    </div>
                  </div>
                  <div class="panel ">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                         <div class="day">
                        <?php _e('Monday', 'swgeula'); ?>
                            </div>
                      </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
                       labore sustainable VHS.
                      </div>
                    </div>
                  </div>
                  <div class="panel ">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          <div class="day">
                          <?php _e('Tuesday', 'swgeula'); ?>
                            </div>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                        labore sustainable VHS.
                      </div>
                    </div>
                  </div>
                   <div class="panel ">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapseThree">
                          <div class="day">
                          <?php _e('Wednesday', 'swgeula'); ?>
                            </div>
                        </a>
                      </h4>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                        labore sustainable VHS.
                      </div>
                    </div>
                  </div>
                   <div class="panel ">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapseThree">
                          <div class="day">
                          <?php _e('Thursday', 'swgeula'); ?>
                            </div>
                        </a>
                      </h4>
                    </div>
                    <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                        labore sustainable VHS.
                      </div>
                    </div>
                  </div>
                  
                   <div class="panel ">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false" aria-controls="collapseThree">
                          <div class="day">
                          <?php _e('Friday', 'swgeula'); ?>
                            </div>
                        </a>
                      </h4>
                    </div>
                    <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                        labore sustainable VHS.
                      </div>
                    </div>
                  </div>
                  
                   <div class="panel">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="false" aria-controls="collapseThree">
                          <div class="day">
                          <?php _e('Saturday', 'swgeula'); ?>
                            </div>
                        </a>
                      </h4>
                    </div>
                    <div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                        labore sustainable VHS.
                      </div>
                    </div>
                  </div>
                  
                </div>  
                   
                 
    </div>	
                     
			
</div>

<?php 
    } //of else not logged
?>
<?php get_footer(); ?>
				