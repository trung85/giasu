<?php
/**
 * The Template for displaying all single posts
 */

if ( ! class_exists( 'Timber' ) ) {
    echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
    return;
}


$data[TutorSite::SIDEBAR_RIGHT] = is_active_sidebar(TutorSite::SIDEBAR_RIGHT)
    ? Timber::get_widgets(TutorSite::SIDEBAR_RIGHT)
    : null;



Timber::render( array( 'sidebar.twig' ), $data );
