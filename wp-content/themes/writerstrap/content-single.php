<?php
/**
 *  Content displaying for single post page.
 *
 * @package WriterStrap
 * @since WP WriterStrap 1.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="col-2 left-meta-single">
	<a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>">
	<?php echo get_avatar( get_the_author_meta('ID') ); ?>
	</a>
</div>
	
<div class="col-10">
	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php WriterStrap_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'WriterStrap' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'WriterStrap' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'WriterStrap' ) );

			if ( ! WriterStrap_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'WriterStrap' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'WriterStrap' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'WriterStrap' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'WriterStrap' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>

		<?php edit_post_link( __( 'Edit', 'WriterStrap' ), '<span class="edit-link">', '</span>' ); ?>
	</footer></div><!-- .entry-meta -->
</article><!-- #post-## -->


