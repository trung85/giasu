<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WriterStrap
 * @since WP WriterStrap 1.1
 */
?>
	
	</div><!-- close .main-content-inner -->
	
	<div class="sidebar col-12 col-lg-4">

		<?php // add the class "panel" below here to wrap the sidebar in Bootstrap style ;) ?>
		<div class="sidebar-padder">
			<div id="social">
			<?php if(of_get_option('facebook_link')) {?>
			<a href="<?php echo esc_url(of_get_option('facebook_link')); ?>" class="facebook"><i class="fa fa-facebook"></i></a>
			<?php } ?>
			<?php if(of_get_option('twitter_link')) {?>
			<a href="<?php echo esc_url(of_get_option('twitter_link')); ?>" class="twitter"><i class="fa fa-twitter"></i></a>
			<?php } ?>
			<?php if(of_get_option('gplus_link')) {?>
			<a href="<?php echo esc_url(of_get_option('gplus_link')); ?>" class="gplus"><i class="fa fa-google-plus"></i></a>
			<?php } ?>
			<?php if(of_get_option('rss_link')) {?>
			<a href="<?php echo esc_url(of_get_option('rss_link')); ?>" class="linkedin"><i class="fa fa-rss"></i></a>
			<?php } ?>
			<?php if(of_get_option('youtube_link')) {?>
			<a href="<?php echo esc_url(of_get_option('youtube_link')); ?>" class="youtube"><i class="fa fa-youtube"></i></a>
			<?php } ?>
			<?php if(of_get_option('pinterest_link')) {?>
			<a href="<?php echo esc_url(of_get_option('pinterest_link')); ?>" class="pinterest"><i class="fa fa-pinterest"></i></a>
			<?php } ?>
		</div>
			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
	
				<aside id="search" class="widget widget_search">
					<?php get_search_form(); ?>
				</aside>
	
				<aside id="archives" class="widget widget_archive">
					<h3 class="widget-title"><?php _e( 'Archives', 'WriterStrap' ); ?></h3>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</aside>
	
				<aside id="meta" class="widget widget_meta"> 
					<h3 class="widget-title"><?php _e( 'Meta', 'WriterStrap' ); ?></h3>
					<ul>
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						<?php wp_meta(); ?>
					</ul>
				</aside>
	
			<?php endif; ?>
			
		</div><!-- close .sidebar-padder -->
