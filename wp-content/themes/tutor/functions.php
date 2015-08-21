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


        $cache = phpFastCache("files");
        $ga_cached = $cache->get('ga_cached');
        if ($ga_cached == null) {
            $ga = $this->getDataFromGA($context);
            $gaReal = $this->getRealtimeDataFromGA($context);

            // 300 = 5 minutes
            $ga_cached = array_merge($ga, $gaReal);
            $cache->set('ga_cached', $ga_cached, 300);
        }

        $context = array_merge($context, $ga_cached);

		return $context;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own fuctions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter( 'myfoo', new Twig_Filter_Function( 'myfoo' ) );
		return $twig;
	}

    public function getDataFromGA($context)
    {
        // OAuth2 service account p12 key file
        $p12FilePath = $context['template_uri'] . '/includes/GiaSuTaiNangSaiGon-991960f3b23f.p12';

        // OAuth2 service account ClientId
        $serviceClientId = '720446430781-5cvfn89mkugmttmiuptlq5693gbr2blt.apps.googleusercontent.com';

        // OAuth2 service account email address
        $serviceAccountName = '720446430781-5cvfn89mkugmttmiuptlq5693gbr2blt@developer.gserviceaccount.com';

        // Scopes we're going to use, only analytics for this tutorial
        $scopes = array(
            'https://www.googleapis.com/auth/analytics.readonly'
        );

        $googleAssertionCredentials = new Google_Auth_AssertionCredentials(
            $serviceAccountName,
            $scopes,
            file_get_contents($p12FilePath)
        );

        $client = new Google_Client();
        $client->setClassConfig('Google_Cache_File', array('directory' => dirname(__FILE__) . '/cache'));

        $client->setAssertionCredentials($googleAssertionCredentials);
        $client->setClientId($serviceClientId);
        $client->setApplicationName("GiaSuTaiNangSaiGon");

        // Create Google Service Analytics object with our preconfigured Google_Client
        $analytics = new Google_Service_Analytics($client);
        // Add Analytics View ID, prefixed with "ga:"
        $analyticsViewId    = 'ga:106766364';
        $metrics            = 'ga:pageviews';

        $dates = array(
            'ga_today' => date("Y-m-d"),
            'ga_yesterday' => date('Y-m-d', strtotime("-1 days")),
            'ga_last_week' => array(
                'from' => date("Y-m-d", strtotime("-1 week +1 day")),
                'to' => date('Y-m-d', strtotime("-1 days"))
            ),
            'ga_last_month' => array(
                'from' => date("Y-m-d", strtotime("-1 month +1 day")),
                'to' => date('Y-m-d', strtotime("-1 days"))
            ),
            'ga_all' => array(
                'from' => "2015-08-01",
                'to' => date('Y-m-d')
            )
        );

        $result = array();
        foreach ($dates as $gaKey => $value) {
            $startDate = $endDate = null;
            if (is_array($value)) {
                $startDate = $value['from'];
                $endDate = $value['to'];
            } else {
                $startDate = $endDate = $value;
            }

            $data = $analytics->data_ga->get($analyticsViewId, $startDate, $endDate, $metrics, array(
                'dimensions'    => 'ga:pagePath',
                'sort'          => '-ga:pageviews',
            ));
            // Data
            $items = $data->getRows();

            $total = 0;
            foreach ($items as $key => $value) {
                $total += $value[1];
            }

            $result[$gaKey] = $total;
        }

        return $result;
    }

    public function getRealtimeDataFromGA($context)
    {
        $result = array();
        // OAuth2 service account p12 key file
        $p12FilePath = $context['template_uri'] . '/includes/GiaSuTaiNangSaiGon-991960f3b23f.p12';

        // OAuth2 service account ClientId
        $serviceClientId = '720446430781-5cvfn89mkugmttmiuptlq5693gbr2blt.apps.googleusercontent.com';

        // OAuth2 service account email address
        $serviceAccountName = '720446430781-5cvfn89mkugmttmiuptlq5693gbr2blt@developer.gserviceaccount.com';

        // Scopes we're going to use, only analytics for this tutorial
        $scopes = array(
            'https://www.googleapis.com/auth/analytics.readonly'
        );

        $googleAssertionCredentials = new Google_Auth_AssertionCredentials(
            $serviceAccountName,
            $scopes,
            file_get_contents($p12FilePath)
        );

        $client = new Google_Client();
        $client->setClassConfig('Google_Cache_File', array('directory' => dirname(__FILE__) . '/cache'));

        $client->setAssertionCredentials($googleAssertionCredentials);
        $client->setClientId($serviceClientId);
        $client->setApplicationName("GiaSuTaiNangSaiGon");

        // Create Google Service Analytics object with our preconfigured Google_Client
        $analytics = new Google_Service_Analytics($client);
        $analyticsViewId    = 'ga:106766364';
        $optParams = array(
            'dimensions' => 'rt:medium'
        );

        $result['ga_online'] = 0;
        try {
            $results = $analytics->data_realtime->get(
                $analyticsViewId,
                'rt:activeUsers',
                $optParams
            );
            $result['ga_online'] = $results->getTotalResults();
        } catch (apiServiceException $e) {
            // Handle API service exceptions.
            // $error = $e->getMessage();
        }

        return $result;
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
