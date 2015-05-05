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
                    <a href="#" class="current">
                        <?php echo __('השיעורים שלי', 'swgeula'); ?>
                    </a>
                    <a href="#">
                        <?php echo __('שיעורים שאני מלמד', 'swgeula'); ?>
                    </a>
                </div>

                <div class="image_category">
                                
                                <div class="big_icon">
                                    <i class="fa fa-calendar-o"></i>
                                    <div class="status x"><i class="fa fa-times"></i></div>
                                    <!-- display on after-->
                                    <div class="status v" style="display:none"><i class="fa fa-check"></i></div>
                                </div>
                                <div class="dtls">
                                    
                                    <h2><?php the_field('title_no_lessons'); ?></h2>

                                       <button class="schedule_btn">
                                            <i class="fa fa-clock-o"></i><?php echo __('תזמן לימוד', 'swgeula'); ?>
                                        </button>
                                        
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
    </div>	
                     
			
</div>

<?php get_footer(); ?>
				