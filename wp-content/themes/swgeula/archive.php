<?php get_header(); ?>	

    <div class="col-lg-12 col-md-12 archive_cont">	
        <?php

          $child = get_category($cat); 
          $parent = $child->parent;
          $parent_name = get_category($parent);
          $parent_name = $parent_name->name;
          $category_id = get_cat_ID( $parent_name );
          $category_link = get_category_link( $category_id );
          $this_category = get_category($cat);

         if (($category_id) != 0){		

                 $this_category = get_category($cat);

                 if (get_category_children($this_category->cat_ID) != "") {


            /*page level_one category.php*/
            include "inc/level_one_category.php";
            
            /*page single category with list of posts - level_three_category.php */
            }else{
            include "inc/level_three_category.php";
            }
      

        /*page main library*/
        } else{ 
             include "inc/library.php"; 
         } ?>
        
    </div>

</div>

<?php get_footer(); ?>
				