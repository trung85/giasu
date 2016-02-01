<?php

require_once dirname(__FILE__) . '/includes/google-api-php-client/src/Google/autoload.php';

require_once dirname(__FILE__) . '/includes/phpfastcache/phpfastcache.php';

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

class TutorSite extends TimberSite
{

    const SIDEBAR_RIGHT  = 'sidebar_right';
    const SIDEBAR_LEFT   = 'sidebar_left';
    const SIDEBAR_FOOTER = 'sidebar_footer';

    const HOME_PAGE_ID          = 117;
    const SERVICE_CATE_ID       = 11;

    const REGISTER_NEW_CLASS_ID = 561;
    const POST_TYPE_NEW_CLASS   = 'quanli_lopmoi';

	function __construct() {
		//add_theme_support( 'post-formats' );
        add_theme_support( 'post-formats', array(
            'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
        ));
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );

		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );

        add_filter( 'query_vars', array( $this, 'add_query_vars_filter' ) );

		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
        add_action( 'after_setup_theme', array( $this, 'register_menus' ) );
        add_action( 'widgets_init', array( $this, 'register_widgets' ) );

        // Enqueue scripts and styles
        add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

		parent::__construct();
	}

    function add_query_vars_filter( $vars ){
        $vars[] = "register_post_id";
        return $vars;
    }

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

    function register_menus()
    {
        register_nav_menus(array(
            'primary' => __( 'Primary Menu', 'Tutor' ),
            'main'    => __( 'Main Menu', 'Tutor' ),
            'right'   => __( 'Right Menu', 'Tutor' ),
            'left'    => __( 'Left Menu', 'Tutor' ),
            'footer'  => __( 'Footer Menu', 'Tutor' ),
            'social'  => __( 'Social Links Menu', 'Tutor' ),
        ));
    }

    function register_widgets()
    {
        register_sidebar(array(
            'name'          => __( 'Sidebar Right', 'Tutor Sidebar' ),
            'id'            => self::SIDEBAR_RIGHT,
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));

        register_sidebar(array(
            'name'          => __( 'Sidebar Left', 'Tutor Sidebar' ),
            'id'            => self::SIDEBAR_LEFT,
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));

        register_sidebar(array(
            'name'          => __( 'Sidebar Footer', 'Tutor Sidebar' ),
            'id'            => self::SIDEBAR_FOOTER,
            'before_widget' => '<aside id="%1$s" class="widget %2$s col-3">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }

    function register_scripts()
    {
        $context = Timber::get_context();
        wp_enqueue_style( 'tutor-style', $context['stylesheet_uri'] );
        // load bootstrap css
        //wp_enqueue_style( 'tutor-bootstrap', $context['template_uri'] . '/includes/resources/bootstrap-3.3.5/css/bootstrap.min.css' );
        // load bootstrap js
        //wp_enqueue_script('tutor-bootstrapjs', $context['template_uri'] . '/includes/resources/bootstrap-3.3.5/js/bootstrap.min.js', array('jquery') );
        //

        wp_enqueue_style( 'tutor-datatablescss', $context['template_uri'] . '/includes/resources/datatables/datatables.min.css' );
        wp_enqueue_script('tutor-datatablesjs', $context['template_uri'] . '/includes/resources/datatables/datatables.min.js', array('jquery') );

        wp_enqueue_script('tutor-bootstrapjs', $context['template_uri'] . '/js/site.js', array('jquery') );
    }

	function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';

		$context['primary_menu'] = new TimberMenu('primary');
        $context['main_menu'] = new TimberMenu('main');
        $context['social_menu'] = new TimberMenu('social');

		$context['site'] = $this;

        $context[self::SIDEBAR_LEFT] = Timber::get_sidebar(self::SIDEBAR_LEFT . '.php');
        $context[self::SIDEBAR_RIGHT] = Timber::get_sidebar(self::SIDEBAR_RIGHT . '.php', array('social_menu' => $context['social_menu']));

        $context['site_config'] = get_option('tz-todo');

        $context['register_newclass_page_id'] = self::REGISTER_NEW_CLASS_ID;

        global $wpdb;
        global $gaData;
        if (empty($gaData)) {
            $gaObject = $wpdb->get_results("SELECT * FROM wp_ga_data");
            $gaData['ga_today']      = (date('H') + 7 > 6 ? (date('H') + 7) * 60 + date('i') : rand(10, 50)); // $gaObject[0]->access_num;
            $gaData['ga_yesterday']  = $gaObject[1]->access_num;
            $gaData['ga_last_week']  = $gaObject[2]->access_num;
            $gaData['ga_last_month'] = $gaObject[3]->access_num;
            $gaData['ga_all']        = $gaObject[4]->access_num;
            $gaData['ga_online']     = $gaObject[5]->access_num;
        }

        // force display ga_today
        $gaData['ga_online'] = rand(10, 100);

        foreach (array('ga_yesterday', 'ga_last_week') as $value) {
            if ($gaData[$value] < 1000) {
                $gaData[$value] += 1000;
            }
        }
        // end force display ga_today

        $context = array_merge($context, $gaData);

        // $cache = phpFastCache("files");

        // try {

        //     $ga_cached = $cache->get('ga_cached');
        //     if ($ga_cached == null) {
        //         $ga = $this->getDataFromGA($context);
        //         $gaReal = $this->getRealtimeDataFromGA($context);

        //         // 300 = 5 minutes
        //         $ga_cached = array_merge($ga, $gaReal);

        //         // cached in 20min
        //         $cache->set('ga_cached', $ga_cached, 1200);

        //         // cached in one day
        //         $cache->set('ga_cached_one_day', $ga_cached, 86400);
        //     } else {
        //         //var_dump($ga_cached);
        //     }

        // } catch (Exception $ex) {
        //     $ga_cached = $cache->get('ga_cached_one_day');
        // }

        // // force display ga_today
        // $ga_cached['ga_online'] = rand(10, 100);

        // foreach (array('ga_yesterday', 'ga_last_week') as $value) {
        //     if ($ga_cached[$value] < 1000) {
        //         $ga_cached[$value] += 1000;
        //     }
        // }
        // // end force display ga_today

        // $context = array_merge($context, $ga_cached);

		return $context;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own fuctions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter( 'myfoo', new Twig_Filter_Function( 'myfoo' ) );
		return $twig;
	}

    static function get_context()
    {
        $context = Timber::get_context();
        $context['search_form'] = get_search_form(false);   // false to not echo

        return $context;
    }
}

new TutorSite();

function myfoo( $text ) {
	$text .= ' bar!';
	return $text;
}

function debug($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}
