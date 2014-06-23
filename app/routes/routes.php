<?php
//echo "Creating new Slim object<br/>";
$router = new \Slim\Slim();
$router->config(array(
    'debug' => true,
    'templates.path' => APPPATH . 'views/'
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

//echo "Initializing admin controller<br/>";


//echo "Controllers have be added<br/>";
///*
// * ------------------------------------
// * Define Static Frontend Routes
// * ------------------------------------
// */
$front = new Front();
// Homepage.
$router->get('/', function () use ($front) {
    
    $front->index();
});
/*
 * ------------------------------------
 * Define Static Admin Routes
 * ------------------------------------
 */
$admin = new Admin();
// Admin Index
$router->get('/admin', function () use ($admin, $router) {
    $admin->index($router);
});
// Admin Dashboard
$router->get('/admin/dashboard', function () use ($admin, $router) {
    $admin->dashboard($router);
});
// Add Posts and Pages and Media
$router->get('/admin/add-post', function () use ($admin, $router) {
    $admin->add_post($router);
});
$router->get('/admin/add-page', function () use ($admin, $router) {
    $admin->add_page($router);
});
$router->get('/admin/add-media', function () use ($admin, $router) {
    $admin->add_media($router);
});
// Manage Posts, Pages, and Media
$router->get('/admin/edit-posts', function () use ($admin, $router) {
    $admin->manage_posts($router);
});
$router->get('/admin/edit-pages', function () use ($admin, $router) {
    $admin->manage_posts($router);
});
$router->get('/admin/edit-media', function () use ($admin, $router) {
    $admin->manage_media($router);
});
$router->get('/admin/edit-posts/:slug', function ($slug) use ($admin, $router) {
    $admin->edit_post($router, $slug);
});
// Settings Pages
$router->get('/admin/settings-site', function () use ($admin, $router) {
    $admin->settings_site($router);
});
// Dynamic Routes
// Posts or Pages
$router->get('/:slug', function ($slug) use ($front, $router) {
    // Check to see if it is a posts   
    //echo "Checking for post with slug: $slug in " . DATAPATH. "posts/posts_summary.json<br/>";
    
    // Check Posts
    $PostModel = new PostModel();
    $posts = $PostModel->get_posts();
    if (!empty($posts[$slug])) {
        //echo "Post found.<br/>";
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
$router->notFound(function () use ($router) {
    $router->render('404.php');
});

// Run the router
$router->run();
?>