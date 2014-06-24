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

function save_post($post_data) {
    $post_model = new PostModel();
    
    // Forget the action now.
    unset($post_data['action']);
    
    // Save summary data.
    $summary_data = $post_data;
    $post_model->append_summary($summary_data);
    
    // Save markdown data.
    $md_data = $post_data;
    // Save the date last edited.
    $md_data['last_edited'] = date("Y-m-d H:i:s");
    // Save tags as array.
    $md_data['tags'] = explode(',', $md_data['tags']);
    // Trim  each tag.
    foreach ($md_data['tags'] as $index=>$tag) {
        $md_data['tags'][$index] = trim($tag);
    } // foreach
    //$post_model->save_markdown($md_data);
    
    // Save HTML summary data.
    $html_data = $post_data;
    $html_data['content'] = convert_md_to_html($post_data['content']);
    print_r($html_data);
} // save_post(array)

/**
 * function convert_md_to_html
 * Converts markdown content as string to html
 * @param $md, markdown string
 */
function convert_md_to_html($md) {
    require_once(BASEPATH . 'includes/Parsedown/Parsedown.php');
    $Parsedown = new Parsedown();
    // Return the parsed $md as HTML
    return $Parsedown->text($md);
} // convert_md_to_html(string)

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