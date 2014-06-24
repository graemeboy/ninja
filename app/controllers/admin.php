<?php

/**
 * Class Admin
 *
 * Sets up the controllers for the admin pages.
 */
class Admin extends Controller
{
    public function __construct () {
        require_once(BASEPATH . 'admin-functions.php');   
    }
    /**
     * index
     * The user is requesting the index admin page.
     * If the user is logged in, show the dashboard,
     * otherwise, redirect to a log in page.
     */
    public function index()
    {
        echo 'Welcome to the admin index.';

    } // index ()
    
    /**
     * Render the Admin Dashboard
     */
    public function dashboard($slim) {
        $slim->render('admin/dashboard.php', array (
            'head_title' => "Admin Dashboard",
            'meta_title' => 'Admin Dashboard'
        ));
    } // dashboard (slim Obj)
    
    /*-------------------------------
     *  Add Content Controllers
     *-------------------------------
     */
    /**
     * Render the Add Post page in the admin area
     */
    public function add_post($slim) {
        $post_data = array (
            'title' => '',
            'content' => '',
            'tags' => array (),
            'slug' => ''
        );
        $slim->render('admin/content/add-post.php', array (
            'page_title' => "Add a Post",
            'meta_title' => 'Add a Post - Admin Dashboard',
            'scripts' => array (
                '/public/js/markitup/markdown.js',
                '/public/js/markitup/jquery.markitup.js',
                '/public/js/StopWord.js'
            ),
            'styles' => array (
                '/public/fontawesome/css/font-awesome.min.css'   
            ),
            'save_button' => 'Publish',
            'post_data' => $post_data,
        ));
    } // add_post (slim Obj)
    
    /**
     * Render the Add Page page in admin 
     */
    public function add_page($slim) {
        $slim->render('admin/content/add-page.php', array (
            'page_title' => "Add a Page",
            'meta_title' => 'Add a Post - Admin Dashboard'
        ));
    } // add_page (slim Obj)
    /**
     * Render the Add Media page in admin 
     */
    public function add_media($slim) {
        $slim->render('admin/content/add-media.php', array (
            'page_title' => "Add Media",
            'meta_title' => 'Add Media - Admin Dashboard',
        ));
    } // add_page (slim Obj)
    
    /*-------------------------------
     *  Manage Content Controllers
     *-------------------------------
     */
    public function manage_posts($slim) {
        $post_model = new PostModel();
        $slim->render('admin/content/manage-posts.php', array (
            'page_title' => "Manage Posts",
            'meta_title' => 'Manage Posts - Admin Dashboard',
            'styles' => array (
                '/public/fontawesome/css/font-awesome.min.css'
            ),
            'posts' => $post_model->get_posts()
        ));
    } // manage_posts (slim Obj)
    
    /**
     * Render the Add Page page in admin 
     */
    public function manage_pages($slim) {
        $slim->render('admin/content/manage-pages.php', array (
            'page_title' => "Manage Pages",
            'meta_title' => 'Manage Posts - Admin Dashboard'
        ));
    } // manage_pages (slim Obj)
    
    /*-------------------------------
     *  Edit Content Controllers
     *-------------------------------
     */
    public function edit_post($slim, $slug) {
        $post_model = new PostModel();
        $post_data = $post_model->get_post_md($slug);
        $post_data['slug'] = $slug;
        $slim->render('admin/content/add-post.php', array (
            'page_title' => "Edit Post",
            'meta_title' => 'Edit Post - Admin Dashboard',
            'post_data' => $post_data,
            'scripts' => array (
                '/public/js/markitup/markdown.js',
                '/public/js/markitup/jquery.markitup.js'
            ),
            'styles' => array (
                '/public/fontawesome/css/font-awesome.min.css'   
            ),
            'save_button' => 'Save Post',
        ));
    } // edit_post(slim Obj, string)
    
    /**
     * Render the Add Media page in admin 
     */
    public function manage_media($slim) {
        $slim->render('admin/content/manage-media.php', array (
            'page_title' => "Manage Media",
            'meta_title' => 'Manage Media - Admin Dashboard'
        ));
    } // manage_media (slim Obj)
    
    /*-------------------------------
     * Settings Pages 
     *-------------------------------
     */
    public function settings_site($slim) {
        $slim->render('admin/settings/settings-site.php', array (
            'page_title' => "Site Settings",
            'meta_title' => 'Site Settings - Admin Dashboard'
        ));
    } // settings_site (slim Obj)
} // class Admin