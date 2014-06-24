<?php
/**
 * System Initialization File
 * 
 * Defines path variables, loads base classes, executes request
 */

/*
 * Version
 * 
 * @var string
 */
    //echo "Defining version<br/>";
    define ('VERSION', '0.1');

/*
 * Execution time limit
 */
    if (function_exists("set_time_limit") == TRUE AND 
            @ini_get("safe_mode") == 0) {
        @set_time_limit(300);
    } // if

/*
 * Load the config file
 */
//echo "Loading config file<br/>";
require_once(APPPATH . 'config/config.php');
// Set the site title
    define ('SITETITLE', $config['site_title']);
// Set the username
    define ('USENAME', $config['username']);

/*
 * Load the Controller Class
 */
//echo "Loading Controller Class<br/>";
require_once(BASEPATH . 'controller.php');
/*
 * Load functions file
 */
require_once(BASEPATH . 'functions.php');
/*
 * Include the Slim Framework for router
 */
//echo "Loading Slim Framework<br/>";
require_once(BASEPATH . 'includes/Slim/Slim.php');

// Use the Slim framework for URL routing
//echo "Registering Slim autoloader<br/>";
\Slim\Slim::registerAutoloader();
/*
 * Include the routes file
 */
//echo "requiring routes from " . APPPATH . "routes/routes.php<br/>";
require_once( APPPATH . 'routes/routes.php');
//echo "Bootstrap complete<br/>";
/*
 * End of file: main.php
 */

?>