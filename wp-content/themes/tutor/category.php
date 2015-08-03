<?php

$context = TutorSite::get_context();

$currentCategory = get_queried_object();

$posts = Timber::query_posts(
    array(
        'category_name' => $currentCategory->cat_name,
        'post_type' => array('post', TutorSite::POST_TYPE_NEW_CLASS)
    )
);

$templates = array( 'category.twig' );
if (!empty($posts->get_posts()[0]) && ($postType = $posts->get_posts()[0]->post_type) != 'post') {
    $templates = array( 'category-' . $postType .'.twig' );
}

$context['currentCategory'] = $currentCategory;
$context['posts']           = $posts->get_posts();
$context['template_uri']    = $context['template_uri'];

Timber::render( $templates, $context );

