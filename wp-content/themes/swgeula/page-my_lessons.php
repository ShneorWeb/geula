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
                        <?php echo __('השיעורים שלי', 'swgeula'); ?>
                    </a>
                    <a href="<?php echo esc_url( get_permalink( get_page_by_title( __('שיעורים שאני מוסר', 'swgeula') ) ) ); ?>">
                        <?php echo __('שיעורים שאני מוסר', 'swgeula'); ?>
                    </a>
                </div>

                <div class="image_category">
                               
                               <?php 
                                    //if there is a lesson in schedule
                                    $schedule = true;
                                ?>
                                
                                <div class="big_icon">
                                    <i class="fa fa-calendar-o"></i>
                                    <?php if($schedule){?>
                                        <div class="status x"><i class="fa fa-times"></i></div>
                                    <?php }else{?>
                                        <div class="status v"><i class="fa fa-check"></i></div>
                                    <?php }?>
                                </div>
                                <div class="dtls">
                                    
                                    <h2>
                                       <?php if($schedule){?>
                                       <?php the_field('title_no_lessons'); ?>
                                       <?php }else{?>
                                       <?php the_field('title_is_lessons'); ?>
                                       <?php }?>
                                    </h2>

                                    <?php if(!$schedule){?>                                            
                                    <p><?php echo __('תזמון הלימוד שלך הינו ל', 'swgeula') . $lesson_date . " " . __('בשעה', 'swgeula'). $lesson_time; ?> <a href="#" class="schedule_new"><?php echo __('תזמן מחדש', 'swgeula'); ?></a></p>  
                                    <?php }?> 
                                     
                                    <?php if($schedule){?>
                                           <button class="schedule_btn">
                                                <i class="fa fa-clock-o"></i><?php echo __('תזמן לימוד', 'swgeula'); ?>
                                            </button>
                                    <?php }?>
                                        
                                        <h3 class="ltl_title">
                                            <?php echo __('השיעור הבא', 'swgeula'); ?>
                                        </h3>
                                        
                                        <div class="single_lesson_cont">
								    
                                            <a href="#">
                                                <div class="name">                                            
                                                    <i class="fa fa-chevron-left"></i>                               
                                                    פוסט שלישי לדוגמא מקטגוריה שלישית תחת הכהנים                                                                        </div>    
                                                <div class="time">                                            
                                                    00:00:00 
                                                 </div>
                                            </a>
                                        
                                    </div>
                                        
                                </div>

                   </div>
                   
                   <h3 class="ltl_title">
                       <?php
                            $number_of_series = 6;
                            echo __('סדרות שאני לומד', 'swgeula') . "<span>" . $number_of_series . "</span>";
                       ?>
                   </h3>
                   
                   <div class="row cat_cont">
                        <?php include_once("inc/category_boxes.php");?>
                   </div>
    </div>	
                     
			
</div>

<?php get_footer(); ?>
				