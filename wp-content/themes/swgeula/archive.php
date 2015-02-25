<?php get_header(); ?>	

        		<div class="col-md-12">			
				<div class="page-header">	
				
				<!--<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
				<?php /* If this is a category archive */ if (is_category()) { ?>
				<h1 class="pagetitle">Archive for the ‘<?php single_cat_title(); ?>’ Category</h1>
				<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
				<h1 class="pagetitle">Posts Tagged ‘<?php single_tag_title(); ?>’</h1>
				<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<h1 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h1>
				<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h1 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h1>
				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h1 class="pagetitle">Archive for <?php the_time('Y'); ?></h1>
				<?php /* If this is an author archive */ } elseif (is_author()) { ?>
				<h1 class="pagetitle">Author Archive</h1>
				<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h1 class="pagetitle">Blog Archives</h1>
				<?php } ?>-->
				

				
					<?php echo $cfs->get('image');
				    	$cat_image =  get_category_meta('image');?>
				    		<?php echo wp_get_attachment_image($cat_image, 'category_image'); 
				    		$values = get_category_meta('level');
foreach ($values as $value => $label) {
    echo '<p>' . $value . '</p>';
}

				    	?>  </div>
				    	
				    	
<?php $this_category = get_category($cat); ?>   

<ul class="product_list" style="padding:0px;">
	<?php
	if (is_category()) {
	$id = get_query_var('cat');
	$args = array(	'parent' => $id );
	foreach (get_categories($args) as $cat) : ?>


			<div class="col-sm-4 ">
					<li class="category_square">
					<div class="category_top_square">
						<span class="category_top_time"><a>12 שעות</a></span>
						<span class="glyphicon glyphicon-folder-open"></span>
					</div>
						<div class="category_square_content">
						<div class="category_square-format">
							<?php $values = get_category_meta('type');
foreach ($values as $value => $label) {
    echo '<p><span>' . $value .'</span>' ;
}
$values = get_category_meta('format');
foreach ($values as $value => $label) {
    echo  '&nbsp; <span>' . $value . '</span></p>';
}?></div>
						

				<h3><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->cat_name; ?></a></h3>
				<div class="category_square_description">
						<?php echo category_description($cat->term_id); 

						?>
				</div>

				<div class="category_square_author">
						<?php $values = get_category_meta('authors');
foreach ($values as $user_id) {
    $the_user = get_user_by('id', $user_id);
    echo '<div class="category_square_avatar">'. get_avatar( $the_user, 60 ) . '</div>'; 
    echo '<div class="category_square_author_name">' . $the_user->user_login . '</div>';
    get_the_author_meta( description, $userID );
    

}?>
				</div>
				</div>
						</li>
			</div>

			<?php $count = $the_query->current_post + 1; ?>
			<?php if( $count % 3 == 0): ?>

			</div><div class="row">
			
			<?php endif; ?>

			

	

	<?php endforeach; } ?>
</ul>
			
				<!--<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article>

				    <div class="page-header">	
				    	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				    	

				    	<p> <?php the_author(); ?> on <?php echo the_time('l, F jS, Y'); ?> in <?php the_category( ', ' );?>.  <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></p>
				    </div>				

					<?php the_excerpt(); ?>

				</article>
				<?php endwhile; endif; ?>-->
				<div class="col-md-3">	
				
				
				<?php get_sidebar(); ?>
			<!-- .sidebar -->			
			</div>
			</div>
			
				<?php get_footer(); ?>
				