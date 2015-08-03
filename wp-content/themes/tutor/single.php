<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;

$commentsArgs = array(
    // change "Leave a Reply" to "Gửi ý kiến"
    'title_reply'          => 'Gửi ý kiến',
    'comment_notes_before' => 'Địa chỉ mail của bạn sẽ không công khai.',
    'comment_notes_after'  => '',
    'label_submit'         => 'Gửi'
);

$context['comment_form'] = TimberHelper::get_comment_form($post->ID, $commentsArgs);

if ( post_password_required( $post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
}
