<?php get_header(); ?>	

    <div class="col-lg-12 col-md-12 archive_cont">	      
        <?php                      
          $this_category = get_category($cat);
          $parent = $this_category->parent;
          $parentcat = get_category($parent);
          $parent_name = $parentcat->name;
          $parentcat_id = $parentcat->cat_ID;
          $category_link = get_category_link( $parentcat_id ); 
          $bInNosse = false;

          if ($parentcat->parent === getCatIDOfLibrary()) {            
            $bInNosse = true;            
            $this_category = get_category($parent);
            $parent = $this_category->parent;
            $parentcat = get_category($parent);
            $parent_name = $parentcat->name;
            $parentcat_id = $parentcat->cat_ID;
            $category_link = get_category_link( $parentcat_id );          
          }                 
          

         if ($parentcat_id != 0) {		                 

            if (get_category_children($this_category->cat_ID) != "") {

              /*page level_one category.php*/
              include "inc/level_one_category.php";
            
            /*page single category with list of posts - level_three_category.php */
            }
            else {
                include "inc/level_three_category.php";
            } 
            /*page main library*/
        } 
        else{        
             include "inc/library.php"; 
        } 
        ?>        
    </div>

</div>

<?php get_footer(); ?>
				