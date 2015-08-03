<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

 
 
function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __('One', 'options_framework_theme'),
		'two' => __('Two', 'options_framework_theme'),
		'three' => __('Three', 'options_framework_theme'),
		'four' => __('Four', 'options_framework_theme'),
		'five' => __('Five', 'options_framework_theme')
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'options_framework_theme'),
		'two' => __('Pancake', 'options_framework_theme'),
		'three' => __('Omelette', 'options_framework_theme'),
		'four' => __('Crepe', 'options_framework_theme'),
		'five' => __('Waffle', 'options_framework_theme')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );
		
	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	
	

	$options = array();
	$options[] = array(
		'name' => __('General Setting', 'options_framework_theme'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Hidden Text Input', 'options_framework_theme'),
		'desc' => __('This option is hidden unless activated by a checkbox click.', 'options_framework_theme'),
		'id' => 'example_text_hidden',
		'std' => 'Hello',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => __('Upload your image logo here', 'options_framework_theme'),
		'desc' => __('Please uload max 200px width and 50px transparant logo image.', 'options_framework_theme'),
		'id' => 'logo_uploader',
		'type' => 'upload');
		
		$options[] = array(
		'name' => __('Upload your Fav icon here', 'options_framework_theme'),
		'desc' => __('Please upload your fav icon here', 'options_framework_theme'),
		'id' => 'fav_uploader',
		'type' => 'upload');
		
		$options[] = array(
		'name' => __('Upload your custom Header Image', 'options_framework_theme'),
		'desc' => __('Please upload your custom Header Image', 'options_framework_theme'),
		'id' => 'costom_header',
		'type' => 'upload');
		
		$options[] = array(
		'name' => __('Put your text here for custom heading', 'options_framework_theme'),
		'desc' => __('Please add your custom heading for the blog.', 'options_framework_theme'),
		'id' => 'custom_heading',
		"std" => 'Please add your custom heading for the blog',
		'type' => 'text');
		$options[] = array(
		'name' => __('Put your text custom Blog Description', 'options_framework_theme'),
		'desc' => __('Put your text custom Blog Description for your blog.', 'options_framework_theme'),
		'id' => 'custom_desc',
		'type' => 'textarea');
		$options[] = array(
		'name' => __('Put Your Header callout link', 'options_framework_theme'),
		'desc' => __('Put your custom callaut link here.', 'options_framework_theme'),
		'id' => 'custom_call',
		'type' => 'text');
		
	$options[] = array( 	
						'name' 		=> __('Theme color Color', 'WriterStrap'),
						'desc' 		=> __('Pick a theme color for the theme (default: #e74c3c).', 'WriterStrap'),
						'id' 		=> 'vis_primary_color',
						"std" 		=> '#e74c3c',
						"type" 		=> 'color'
			);
	$options[] = array(
		'name' => __('Footer setting', 'options_framework_theme'),
		'type' => 'heading');
		
		$options[] = array(
		'name' => __('Add your Footer copyright text here', 'options_framework_theme'),
		'desc' => __('Add your Footer copyright text here.', 'options_framework_theme'),
		'id' => 'footer_copy',
		"std" 		=> "&copy; 2014 Site Name",
		'type' => 'text');

	$options[] = array(
		'name' => __('Social Profile Setting', 'options_framework_theme'),
		'type' => 'heading');
		
		$options[] = array(
		'name' => __('Ad your social profile links with http:// here', 'options_framework_theme'),
		'desc' => __('Add your facebook page link here.', 'options_framework_theme'),
		'id' => 'facebook_link',
		'type' => 'text');
		
		$options[] = array(
		'desc' => __('Add your twitter page link here.', 'options_framework_theme'),
		'id' => 'twitter_link',
		'type' => 'text');
		$options[] = array(
		'desc' => __('Add your google plus page link here.', 'options_framework_theme'),
		'id' => 'gplus_link',
		'type' => 'text');
		$options[] = array(
		'desc' => __('Add your RSS feed link here.', 'options_framework_theme'),
		'id' => 'rss_link',
		'type' => 'text');
		$options[] = array(
		'desc' => __('Add your youtube page link here.', 'options_framework_theme'),
		'id' => 'youtube_link',
		'type' => 'text');
		$options[] = array(
		'desc' => __('Add your pinterest page link here.', 'options_framework_theme'),
		'id' => 'pinterest_link',
		'type' => 'text');

	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */

	

	return $options;
}