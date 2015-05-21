<?php
if ( isset($catAddID) ) :
    $catStatus = getCatInMyLessons($catAddID);        
?>
<?php if ($catStatus==2) {?>
        <!--done-->
         <a href="javascript:void(0);" onclick="" title="<?php _e('done', 'swgeula');?>" alt="<?php _e('done', 'swgeula');?>" class="add_lesson_btn done" >
            <i class="fa fa-check"></i>
        </a>
<?php } else  if ($catStatus==1 || $catStatus==0) {  ?>    
         <!-- remove -->    
         <a href="javascript:void(0);" id="btn_rm_<?php echo $catAddID;?>" onclick="if (confirm('<?php _e('Are you sure you want to remove this category from your lessons?', 'swgeula');?>')) { removeFromMyLessons(<?php echo $catAddID;?>); <?php if( isset($bMyLessons) && ($bMyLessons===true) ) {?>hideCat(<?php echo $catAddID;?>,'<?php echo $NumberSpanID; ?>')<?php }?>}" title="<?php _e('remove from my lessons', 'swgeula');?>" alt="<?php _e('remove from my lessons', 'swgeula');?>" class="add_lesson_btn remove"   onMouseOut="this.style.color='<?php echo $color; ?>'" style="color:<?php echo $color; ?>">
            <i class="fa fa-star add"></i>
            <i class="fa fa-times remove"></i>
        </a>
        <!-- add -->    
        <a style="display:none;" id="btn_add_<?php echo $catAddID;?>" href="javascript:void(0);" onclick="addToMyLessons(<?php echo $catAddID;?>);" title="<?php _e('add to my lessons', 'swgeula');?>" alt="<?php _e('add to my lessons', 'swgeula');?>" class="add_lesson_btn add"  onMouseOver="this.style.color='<?php echo $color; ?>'" onMouseOut="this.style.color='#b2bac2'">
            <i class="fa fa-star"></i>
        </a>  
<?php } else { ?>                
        <!-- remove -->    
         <a style="display:none;" id="btn_rm_<?php echo $catAddID;?>" href="javascript:void(0);" onclick="if (confirm('<?php _e('Are you sure you want to remove this category from your lessons?', 'swgeula');?>')) { removeFromMyLessons(<?php echo $catAddID;?>); <?php if( isset($bMyLessons) && ($bMyLessons===true) ) {?>hideCat(<?php echo $catAddID;?>,'<?php echo $NumberSpanID; ?>')<?php }?>}" title="<?php _e('remove from my lessons', 'swgeula');?>" alt="<?php _e('remove from my lessons', 'swgeula');?>" class="add_lesson_btn remove"   onMouseOut="this.style.color='<?php echo $color; ?>'" style="color:<?php echo $color; ?>">
            <i class="fa fa-star add"></i>
            <i class="fa fa-times remove"></i>
        </a>
        <!-- add -->    
        <a href="javascript:void(0);" id="btn_add_<?php echo $catAddID;?>" onclick="addToMyLessons(<?php echo $catAddID;?>);" title="<?php _e('add to my lessons', 'swgeula');?>" alt="<?php _e('add to my lessons', 'swgeula');?>" class="add_lesson_btn add"  onMouseOver="this.style.color='<?php echo $color; ?>'" onMouseOut="this.style.color='#b2bac2'">
            <i class="fa fa-star"></i>
        </a>                          
<?php
    }
endif;
?>        