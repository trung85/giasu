<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WriterStrap
 * @since WP WriterStrap 1.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'WriterStrap' ),
				'after'  => '</div>',
			) );
		?>
		<div class="clear"></div>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'WriterStrap' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
