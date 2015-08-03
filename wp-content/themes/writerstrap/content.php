<?php
/**
* The default template for displaying content. Used for both single and index/archive/search.

 * @package WriterStrap
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="col-2 left-meta">
	<div class="postdate">
		<?php the_time('M'); ?>
		<span><?php the_time('d'); ?></span>
	</div>
</div>

<div class="col-10">
	<header class="page-header">
	
		<h2 class="page-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	</header><!-- .entry-header -->
	<div class="clear"></div>
	<?php if ( is_search() || is_archive() ) : // Only display Excerpts for Search and Archive Pages ?>
	<div class="entry-summary">		
		<?php if ( has_post_thumbnail() ) {?>
		<div class="post-thumb-home">
		<?php
			the_post_thumbnail('medium');	
			?>
			</div>
			<?php
		} ?>
		<?php the_excerpt(); ?>
		<div class="clear"></div>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		
		<?php if ( has_post_thumbnail() ) {?>
		<div class="post-thumb-home">
		<?php
			the_post_thumbnail('medium');	
			?>
			</div>
			<?php
		} ?>
		<?php the_excerpt(); ?>
		<div class="clear"></div>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php WriterStrap_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'WriterStrap' ), __( '1 Comment', 'WriterStrap' ), __( '% Comments', 'WriterStrap' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'WriterStrap' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
	
</div><div class="clear"></div></article>
<!-- #post-## -->
