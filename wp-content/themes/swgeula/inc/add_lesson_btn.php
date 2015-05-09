<!--regular-->
        <a href="javascript:void(0);" onclick="addToMyLessons('cat',<?php echo $cat2->cat_ID;?>);" title="<?php _e('add to my lessons', 'swgeula');?>" alt="<?php _e('add to my lessons', 'swgeula');?>" class="add_lesson_btn add"  onMouseOver="this.style.color='<?php echo $color; ?>',this.style.color" onMouseOut="this.style.color='#b2bac2'">
            <i class="fa fa-star"></i>
        </a>
        
        <!--added-->
         <a href="javascript:void(0);" onclick="" title="<?php _e('remove from my lessons', 'swgeula');?>" alt="<?php _e('remove from my lessons', 'swgeula');?>" class="add_lesson_btn remove"   onMouseOut="this.style.color='<?php echo $color; ?>'" style="color:<?php echo $color; ?>">
            <i class="fa fa-star add"></i>
            <i class="fa fa-times remove"></i>
        </a>
        
         <!--done-->
         <a href="javascript:void(0);" onclick="" title="<?php _e('done', 'swgeula');?>" alt="<?php _e('done', 'swgeula');?>" class="add_lesson_btn done" >
            <i class="fa fa-check"></i>
        </a>