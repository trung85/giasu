<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WriterStrap
 * @since WP WriterStrap 1.1
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'single' ); ?>
		
		<div  class="col-md-4 randomposts" >
			<h2>You may also Like <span class="catcolor"><?php  single_cat_title( '', true ); ?></span></h2>		
		<?php get_template_part( 'content', 'random' ); ?>
		</div>

		<?php wp_reset_query(); ?>

		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template();
		?>

	<?php endwhile; // end of the loop. ?>
	
		

<?php get_sidebar(); ?>
<?php get_footer(); ?>