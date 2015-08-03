<?php defined( 'ABSPATH' ) or die( "No direct access allowed" );
/**
 * Controls plugin settings.
 * See http://codex.wordpress.org/Settings_API
 *
 * @author vinnyalves
 */
class TutorPlugin_Controller_Settings extends TutorPlugin {

	protected $settings_dao;

	public function __construct()
	{
		// We only allow instantiation in admin
		if ( ! parent::is_admin() )
			return;

		$this->settings_dao = $this->load_lib( 'dal/settings_dao' );

		add_action( 'admin_menu', array( &$this, 'add_options_page' ) );
		add_filter( get_parent_class( $this ) . '_settings', array( &$this->settings_dao, 'load' ), 0, 10 );
		add_action( 'admin_init', array( &$this, 'register_options' ) );
	}


	/**
	 * Creates the settings submenu item
	 */
	public function add_options_page()
	{
		$env = $this->get_env();

		$plugin_data = ( object ) get_plugin_data( $env->plugin_file );
		$view = $this->load_lib( 'view/settings' );

		$plugin_page = add_options_page( $plugin_data->Name, $plugin_data->Name, 'manage_options',
										 $this->domain, array( &$view,'show_admin' ) );

		// Add CSS and JS
		add_action( 'admin_head-' . $plugin_page, array( &$view,'add_admin_css' ) );
		add_action( 'admin_head-' . $plugin_page, array( &$view,'add_admin_js' ) );

        if (!empty($_POST)) {

        }
	}

	/**
	 * Whitelists our settings
	 */
	public function register_options()
	{
		register_setting( $this->settings_name, $this->settings_name, array( &$this->settings_dao, 'validate_settings' ) );

        $section = $this->domain . '_section';
        $section_callback = 'section_callback';

        add_settings_section($section, __( 'Your section description', $this->domain ), array( &$this, 'section_callback' ), $this->domain);

        add_settings_field($this->domain . '_address', __( 'Address', $this->domain ), array( &$this, 'render_address_field' ), $this->domain, $section);
	}

    public function section_callback()
    {
        echo __( 'This section description', $this->domain );
    }

    public function render_address_field()
    {
        $field_key = $this->domain . '_address';
        $field_name = $this->settings_name . "[{$field_key}]";

        $options = get_option( $this->settings_name );
        ?>
        <input type='text' name='<?php echo $field_name; ?>' value='<?php echo $options[$field_key]; ?>'>
        <?php
    }
}

/* End of file settings.class.php */
/* Location: <plugin-dir>/includes/controller/settings.class.php */
