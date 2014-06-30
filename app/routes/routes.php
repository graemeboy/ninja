<?php namespace ninja\Routes;

use ninja\Controllers\AdminController as AdminController;
use ninja\Controllers\FrontController as FrontController;

//echo "Creating new Slim object<br/>";
$router = new \Slim\Slim();
$router->config( array(
        'debug' => true,
        'templates.path' => APPPATH . 'views/'
    ) );

/*
 * ------------------------------------
 * Include and Initialize Controllers
 * ------------------------------------
 * Require controllers for admin and frontend
 */
//echo "Frontend controllers<br/>";
// Frontend Controller
require_once APPPATH . 'controllers/FrontController.php';
//echo "Done front<br/>";
// Admin Controller
require_once APPPATH . 'controllers/AdminController.php';

$admin = new AdminController();
$front = new FrontController();

//echo "End controllers<br/>";
//echo "Page models";
// Models
require_once APPPATH . 'models/Post.php';

require_once APPPATH . 'models/Page.php';

//echo "Initializing admin controller<br/>";



//echo "Controllers have be added<br/>";
///*
// * ------------------------------------
// * Define Static Frontend Routes
// * ------------------------------------
// */

// Homepage.
$router->get( '/', function () use ( $front ) {
        $front->index();
    } );

//echo "define ajax";
/*
 * Static AJAX Admin Routes
 */
require_once('ajax.php');
//echo "done ajax";
/*
 * ------------------------------------
 * Define Static Admin Routes
 * ------------------------------------
 */
//require_once 'admin.php';
/**
 * Admin routes
 */
require_once('admin.php');

require_once('front.php');


// Run the router
$router->run();
?>
