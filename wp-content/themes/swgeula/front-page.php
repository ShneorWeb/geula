<?php 
if (is_user_logged_in()) {
	wp_safe_redirect(get_category_link(3));
} else { 

get_header(); ?>


<div class="hero_image">
   <img src="<?php the_field('big_image', $post->ID);?>" class="bgImg">
      
           <div class="quote_cont">
            <div class="quote">
              <?php the_field('quote', $post->ID); ?>
           </div>
            <div class="source">
              <?php the_field('source', $post->ID); ?>
           </div>
        </div>
    
</div>

<div class="register_cont">
   <div class="container">
        <h2><?php the_field('title_1', $post->ID); ?></h2>
        <p> <?php the_field('sub_title', $post->ID); ?></p>
        <form>
            <input type="text" placeholder="<?php echo __('Name', 'swgeula'); ?>">
            <input type="email" placeholder="<?php echo __('Email', 'swgeula'); ?>">
            <input type="password" placeholder="<?php echo __('Password', 'swgeula'); ?>">
            <input type="submit" value="<?php echo __('Create free account', 'swgeula'); ?>">
        </form>
    </div>
</div>

<div class="donate_cont">
     <p><?php the_field('donate_title', $post->ID); ?></p>
     <a href="<?php the_field('donate_url', $post->ID); ?>" target="_blank">
        <button><?php echo __('Donation', 'swgeula'); ?></button>
     </a>
</div>

<div class="credits_cont">
     <p><?php the_field('credits_title', $post->ID); ?></p>
     <p class="before_credit_logo"><?php echo __('Design and development:', 'swgeula'); ?></p>
     <a href="http://www.shneorweb.com/" target="_blank">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/shneorwebLogo.png">
     </a>
</div>


<?php
 } //of else logged in
?>
<?php get_footer(); ?>
				
					

