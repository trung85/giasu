<?php
/**
 * PLUGIN_NAME Uninstall
 *
 * Uninstall methods
 *
 */
if( ! defined('TutorPlugin_TEST_UNINSTALL') && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();

require_once('<plugin-dir>.php');

class TutorPlugin_Uninstall extends TutorPlugin
{
	public function __construct()
	{
		return;
	}
	
}


new TutorPlugin_Uninstall();

/* End of uninstall.php */
/* Location: <plugin-dir>/uninstall.php */
