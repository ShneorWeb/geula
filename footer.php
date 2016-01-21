<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package swgeula
 */

//$post->ID = 4;
$defaultPost = 4;
    
?>
    <div class="donate_cont">
     <p><?php the_field('donate_title', $defaultPost); ?></p>
     <a href="<?php the_field('donate_url', $defaultPost); ?>" target="_blank">
        <button><?php echo __('Donation', 'swgeula'); ?></button>
     </a>
</div>

<div class="credits_cont">
     <p><?php the_field('credits_title', $defaultPost); ?></p>
     <p class="before_credit_logo"><?php echo __('Design and development:', 'swgeula'); ?></p>
     <a href="http://www.shneorweb.com/" target="_blank">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/shneorwebLogo.png">
     </a>
</div>

	</div><!-- #content -->

	<footer id="colophon" class="clearfix site-footer" role="contentinfo">
		<div class="site-info">
			 <p>&copy; <?php bloginfo('name'); ?> <?php echo date('Y'); ?></p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div>

<?php wp_footer(); ?>

</body>
</html>
