<?php
echo "Creating new Slim object<br/>";
$router = new \Slim\Slim();
$router->config(array(
    'debug' => true,
    'templates.path' => APPPATH . 'views/_templates'
));

/*
 * ------------------------------------
 * Include and Initialize Controllers
 * ------------------------------------
 * Require controllers for admin and frontend
 */
// Frontend Controllers
require_once(APPPATH . 'controllers/front.php');
// Admin Controllers
require_once(APPPATH . 'controllers/admin.php');

// Models
require_once(APPPATH . 'models/posts.php');
require_once(APPPATH . 'models/pages.php');

echo "Initializing admin controller<br/>";


echo "Controllers have be added<br/>";
///*
// * ------------------------------------
// * Define Static Frontend Routes
// * ------------------------------------
// */
// Homepage.
$router->get('/', function () {
    $front = new Front();
    $front->index();
});
/*
 * ------------------------------------
 * Define Static Admin Routes
 * ------------------------------------
 */

// Admin Index
$router->get('/admin', function () {
    $admin = new Admin();
    $admin->index();
});
// Admin Dashboard
$router->get('/admin/dashboard', function () {
    $admin = new Admin();
    $admin->dashboard();
});

// Dynamic Routes
// Posts or Pages
$router->get('/:slug', function ($slug) use ($router) {
    // Check to see if it is a posts   
    echo "Checking for post with slug: $slug in " . DATAPATH. "posts/posts_summary.json<br/>";
    
    // Check Posts
    $PostModel = new PostModel();
    $posts = $PostModel->get_posts();
    if (!empty($posts[$slug])) {
        echo "Post found.<br/>";
        echo "<h3>{$posts[$slug]['title']}</h3>";
    } else {
        // Check Pages
        $PageModel = new PageModel();
        $pages = $PageModel->get_pages();
        if (!empty($pages[$slug])) {
            
        } else {
            // No post or pages found with that slug.
            // Return 404
            $router->notFound();
        } // else
    } // else
});

// Set the 404
$router->notFound(function () use ($app) {
    $router->render('404.php');
});

// Run the router
$router->run();
?>