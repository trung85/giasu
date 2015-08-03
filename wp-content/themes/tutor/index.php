<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

if ( ! class_exists( 'Timber' ) ) {
	echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
	return;
}
$context = Timber::get_context();

//$context['posts'] = Timber::get_posts();
$context['post'] = Timber::get_post(TutorSite::HOME_PAGE_ID);

$context['search_form'] = get_search_form(false);   // false to not echo

// get dich-vu category
$serviceCat = get_category(TutorSite::SERVICE_CATE_ID);
$postsOfService = Timber::query_posts(array('category_name' => $serviceCat->cat_name));
$context['serviceCat'] = $serviceCat;
$context['postsOfService'] = $postsOfService;

$templates = array( 'index.twig' );
if ( is_home() ) {
	array_unshift( $templates, 'home.twig' );
}
Timber::render( $templates, $context );
