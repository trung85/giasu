<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WriterStrap
 * @since WP WriterStrap 1.1
 */
?>
			</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
		</div><!-- close .row -->
	</div><!-- close .container -->
</div><!-- close .main-content -->
<div id="primery-footer">
	<div class="container">
	<?php if ( ! dynamic_sidebar( 'sidebar-footer' ) ) : ?><?php endif; ?>
	</div>

</div>


<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="container">
		<div class="row">		
			<div class="site-footer-inner col-12">
			
				<div class="site-info">
					<?php do_action( 'WriterStrap_credits' ); ?>
					<?php echo of_get_option('footer_copy' , '&copy; 2014 Site name'); ?>
					<span class="sep"> | </span>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'WriterStrap' ), 'WriterStrap', '<a href="http://crayonux.com/" rel="designer">Crayonux</a>' ); ?>
				</div><!-- close .site-info -->
			
			</div>	
		</div>
	</div><!-- close .container -->
</footer><!-- close #colophon -->

<?php wp_footer(); ?>
</body>
</html>