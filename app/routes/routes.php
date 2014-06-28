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
require_once(APPPATH . 'models/PostModel.php');
require_once(APPPATH . 'models/PageModel.php');

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

//echo "define ajax";
/*
 * Static AJAX Admin Routes
 */
$router->post('/admin/ajax', function () use ($router) {
    $action = $router->request->post('action');
    if (function_exists($action)) {
        $resp = call_user_func($action, $router->request->post());
    } else {
        $resp = 'incorrect action: ' . $action;   
    }
    echo $resp;
});

function delete_post($post_slug) {
    $post_model = new PostModel();
    $post_model->delete_post($post_slug);
    
} // delete_post (string)

function save_post($postData) {
    print_r($postData);
    $postModel = new PostModel();
    echo "New model!";
    // Forget the action now.
    unset($postData['action']);
    $postData['last_edited'] = date("Y-m-d H:i:s");
    $postModel->savePost($postData);
    echo "success";
} // save_post(array)
//echo "define static";
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
    $admin->addPost($router);
});
$router->get('/admin/add-page', function () use ($admin, $router) {
    $admin->addPage($router);
});
$router->get('/admin/add-media', function () use ($admin, $router) {
    $admin->addMedia($router);
});
// Manage Posts, Pages, and Media
$router->get('/admin/edit-posts', function () use ($admin, $router) {
    $admin->managePosts($router);
});
$router->get('/admin/edit-pages', function () use ($admin, $router) {
    $admin->managePages($router);
});
$router->get('/admin/edit-media', function () use ($admin, $router) {
    $admin->manageMedia($router);
});
$router->get('/admin/edit-posts/:slug', function ($slug) use ($admin, $router) {
    $admin->editPost($router, $slug);
});
// Settings Pages
$router->get('/admin/settings-site', function () use ($admin, $router) {
    $admin->settingsSite($router);
});
// Appearance Settings - Theme and Styles
$router->get('/admin/appearance', function () use ($admin, $router) {
    $admin->appearance($router);
});
$router->get('/admin/delete-post/:slug', function ($slug) use ($admin, $router) {
    $admin->deletePost($slug, $router);
});

$router->get('/admin/view-post/:slug', function ($slug) use ($router) {
   $router->redirect("/$slug");
});

// Dynamic Routes
// Posts or Pages
$router->get('/:slug', function ($slug) use ($front, $router) {
    $PostModel = new PostModel();
    // Check if post exists.
    if ($PostModel->isPost($slug)) {
        $front->post($slug, $router);
    } else {
        // Check Pages
        $PageModel = new PageModel();
        $pages = $PageModel->get_pages();
        if (!empty($pages[$slug])) {
            // Found a page with this slug.
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