<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package swgeula
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="clearfix site-footer" role="contentinfo">
		<div class="site-info">
			 <p>&copy; <?php bloginfo('name'); ?> <?php echo date('Y'); ?></p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div>

<?php if ( is_page("registration") || is_page("sign-in") ) {?>  
<script src = "https://plus.google.com/js/client:plusone.js"></script>
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>
