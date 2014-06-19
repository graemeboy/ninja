<?php
/* --------------------
 * Environment
 * --------------------
 * Define the environment. 
 * Environment can be 'development', 'testing', or 'production'.
 */
    echo "defining environment<br/>";
    define('ENVIRONMENT', 'development');

/* --------------------
 * Error reporting
 * --------------------
 * Different for development environment than production.
 */
    echo "defining error reporting<br/>";

if (defined('ENVIRONMENT')) {
	switch (ENVIRONMENT) {
		case 'development':
			error_reporting(E_ALL);
		break;
	
		case 'testing':
		case 'production':
			error_reporting(0);
		break;

		default:
			exit('The application environment is not set correctly.');
	} // switch
} // if


echo "setting folder names<br/>";
/* --------------------
 * Application Folder
 * --------------------
 * Define the application folder name. If you change the name of the
 * application folder, update this setting.
 * 
 */
    $application_folder = 'app';

/* --------------------
 * System Folder
 * --------------------
 * Define the system folder name. If you change the name of the
 * system folder, update this setting.
 * 
 */
    $system_path = 'system';

/* --------------------
 * Data Path
 * --------------------
 * Define the path to the raw data files.
 * 
 */
    $data_path = 'models/data';
    
// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE.
// --------------------------------------------------------------------

/*
 *  Resolve the system path for reliability
 */
    
    echo "resolving system path<br/>";

	// Set the current directory correctly for CLI requests
	if (defined('STDIN')) {
		chdir(dirname(__FILE__));
	} // if

	if (realpath($system_path) !== FALSE) {
		$system_path = realpath($system_path).'/';
	} // if

	// ensure there's a trailing slash
	$system_path = rtrim($system_path, '/').'/';

	// Is the system path correct?
	if ( ! is_dir($system_path)) {
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	} // if

    echo "System path is $sytem_path<br/>";
/* ----------------
 * Path Constants
 * ----------------
 * Set path constants
 */
    echo "setting path constants<br/>";

    // The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

    // Path to the system folder
	define('BASEPATH', str_replace("\\", "/", $system_path));

    // Name of the "system folder"
	define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));
    // The path to the "application" folder

	if (is_dir($application_folder)) {
		define('APPPATH', $application_folder.'/');
	} // if
	else {
		if ( ! is_dir(BASEPATH.$application_folder.'/')) {
			exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
		} // if

		define('APPPATH', BASEPATH . $application_folder.'/');
	} // else

    // Define the path to the raw data files
    define ('DATAPATH', APPPATH . $data_path . '/');
/*
 * Bootstrap the application!
 */

echo "requiring the bootstrap file from "  . BASEPATH . "main.php <br/>";
require_once(BASEPATH . 'main.php');
?>