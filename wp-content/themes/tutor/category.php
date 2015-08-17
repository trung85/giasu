<?php

$context = TutorSite::get_context();

$currentCategory = get_queried_object();

$posts = Timber::query_posts(
    array(
        'category_name' => $currentCategory->cat_name,
        'post_type' => array('post', TutorSite::POST_TYPE_NEW_CLASS),
        'nopaging' => true,
        'orderby'=> 'modified',
        'order' => 'DESC',
    )
);

$templates = array( 'category.twig' );
$postsAry = $posts->get_posts();

if (!empty($postsAry[0]) && ($postType = $postsAry[0]->post_type) != 'post') {

    $delivered = array();
    foreach ($postsAry as $key => $value) {
        if ($value->trang_thai != 0) {
            $delivered[] = $value;
            unset($postsAry[$key]);
        }
    }

    $postsAry = array_merge($postsAry, $delivered);

    $templates = array( 'category-' . $postType .'.twig' );
}

$context['currentCategory'] = $currentCategory;
$context['posts']           = $postsAry;
$context['template_uri']    = $context['template_uri'];

Timber::render( $templates, $context );

