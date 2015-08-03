<?php

$data = array();
$templates = array( 'searchform.twig' );
$context = Timber::get_context();

$data['search_text'] = empty($_GET['s']) ? "Search" : get_search_query();
$data['search_url'] = $context['site']->url();
$data['template_uri'] = $context['template_uri'];

Timber::render( $templates, $data );
