<?php
/**
 * The Template for displaying all single posts
 */

if ( ! class_exists( 'Timber' ) ) {
    echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
    return;
}


$data[TutorSite::SIDEBAR_LEFT] = is_active_sidebar(TutorSite::SIDEBAR_LEFT)
    ? Timber::get_widgets(TutorSite::SIDEBAR_LEFT)
    : null;

Timber::render( array( 'sidebar-left.twig' ), $data );
