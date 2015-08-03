<?php
/**
 * WriterStrap functions and definitions
 *
 * @package WriterStrap
 * @since WP WriterStrap 1.1
 */


 /**
 * Adds support for a theme option.
 */
if ( !function_exists( 'optionsframework_init' ) ) {
	define('OPTIONS_FRAMEWORK_URL', get_template_directory() . '/inc/');
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');
}
if ( is_admin() && isset($_GET['activated'] ) && $pagenow ==    "themes.php" )
	add_action('admin_init', 'options_theme_activation');


function writterstrap_numeric_posts_nav() {

	if( is_singular() )
		return;

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="navigation"><ul>' . "\n";

	/**	Previous Post Link */
	if ( get_previous_posts_link() )
		printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

	/**	Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			echo '<li>...</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/**	Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>...</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/**	Next Post Link */
	if ( get_next_posts_link() )
		printf( '<li>%s</li>' . "\n", get_next_posts_link() );

	echo '</ul></div>' . "\n";

}
 
if ( ! isset( $content_width ) )
	$content_width = 750; /* pixels */

if ( ! function_exists( 'WriterStrap_setup' ) ) :
/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */ 
function WriterStrap_setup() {
    global $cap, $content_width;
    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();


		/**
		 * Add default posts and comments RSS feed links to head
		*/
		add_theme_support( 'automatic-feed-links' );
		
		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/
		add_theme_support( 'post-thumbnails' );
		
		/**
		 * Enable support for Post Formats
		*/
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
		
		/**
		 * Setup the WordPress core custom background feature.
		*/
		add_theme_support( 'custom-background', apply_filters( 'WriterStrap_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	


	/**
	 * This theme uses wp_nav_menu() in one location.
	*/ 
    register_nav_menus( array(
        'primary'  => __( 'Header bottom menu', 'WriterStrap' ),
    ) );

}
endif; // WriterStrap_setup
add_action( 'after_setup_theme', 'WriterStrap_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function WriterStrap_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'WriterStrap' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Sidebar Footer', 'WriterStrap' ),
		'id'            => 'sidebar-footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s col-3">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
}
add_action( 'widgets_init', 'WriterStrap_widgets_init' );

//custom style
function theme_custom_style() {
 if(of_get_option('vis_primary_color')) { ?> 
 
<style type="text/css">
a {
	color: <?php echo of_get_option('vis_primary_color'); ?>;
}

	.navbar-brand {
	background: <?php echo of_get_option('vis_primary_color'); ?>;
	}
	.navbar-brand:hover {
	background: <?php echo of_get_option('vis_primary_color'); ?> !important;
	}
	.dropdown-menu>li>a:hover {
	background: <?php echo of_get_option('vis_primary_color'); ?> !important;
   }
   #masthead {
	background-color: <?php echo of_get_option('vis_primary_color'); ?>;	
}
.pull-right ul.dropdown-menu input[type=text], #searchform input[type=text]{
	
	border: 2px solid <?php echo of_get_option('vis_primary_color'); ?> !important;

}
footer.entry-meta a {
	color: <?php echo of_get_option('vis_primary_color'); ?>; 
}
.sidebar  .widget  a {
	color: <?php echo of_get_option('vis_primary_color'); ?>;
}
.page-header .entry-meta a {
	color: <?php echo of_get_option('vis_primary_color'); ?>; 
}

.main-content-inner a{
	color: <?php echo of_get_option('vis_primary_color'); ?>;
}
.comment-reply-link, #commentsubmit{
	background: <?php echo of_get_option('vis_primary_color'); ?> !important;
}
.post-navigation a:hover {
	background: <?php echo of_get_option('vis_primary_color'); ?>;
}
	.navigation li a,
	.navigation li a:hover,
	.navigation li.disabled {
	background-color: <?php echo of_get_option('vis_primary_color'); ?>;
}

.pull-right:hover a {
	color: #000;
	background-color: <?php echo of_get_option('vis_primary_color'); ?> !important;
	
}
.pull-right a  {
	background-color: <?php echo of_get_option('vis_primary_color'); ?> !important;
}
#primery-footer {
	background-color: <?php echo of_get_option('vis_primary_color'); ?> !important;
}
</style>

<?php } ?>
<?php };
add_action('before', 'theme_custom_style');

/**
 * Enqueue scripts and styles
 */
function WriterStrap_scripts() {
	wp_enqueue_style( 'WriterStrap-style', get_stylesheet_uri() );

	// load bootstrap css
	wp_enqueue_style( 'WriterStrap-bootstrap', get_template_directory_uri() . '/includes/resources/bootstrap/css/bootstrap.min.css' );
	
	// load bootstrap js
	wp_enqueue_script('WriterStrap-bootstrapjs', get_template_directory_uri().'/includes/resources/bootstrap/js/bootstrap.min.js', array('jquery') );

	// load the glyphicons
	wp_enqueue_style( 'WriterStrap-glyphicons', get_template_directory_uri() . '/includes/resources/glyphicons/css/bootstrap-glyphicons.css' );
		
	// load bootstrap wp js
	wp_enqueue_script( 'WriterStrap-bootstrapwp', get_template_directory_uri() . '/includes/js/bootstrap-wp.js', array('jquery') );

	wp_enqueue_script( 'WriterStrap-skip-link-focus-fix', get_template_directory_uri() . '/includes/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'WriterStrap-keyboard-image-navigation', get_template_directory_uri() . '/includes/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'WriterStrap_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/includes/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/includes/jetpack.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/includes/bootstrap-wp-navwalker.php';
