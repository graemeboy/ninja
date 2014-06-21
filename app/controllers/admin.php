<?php

/**
 * Class Admin
 *
 * Sets up the controllers for the admin pages.
 */
class Admin extends Controller
{
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
        $slim->render('admin/content/add-post.php', array (
            'head_title' => "Add a Post",
            'meta_title' => 'Add a Post - Admin Dashboard'
        ));
    } // add_post (slim Obj)
    
    /**
     * Render the Add Page page in admin 
     */
    public function add_page($slim) {
        $slim->render('admin/content/add-page.php', array (
            'head_title' => "Add a Page",
            'meta_title' => 'Add a Post - Admin Dashboard'
        ));
    } // add_page (slim Obj)
    /**
     * Render the Add Media page in admin 
     */
    public function add_media($slim) {
        $slim->render('admin/content/add-media.php', array (
            'head_title' => "Add Media",
            'meta_title' => 'Add Media - Admin Dashboard'
        ));
    } // add_page (slim Obj)
    
    /*-------------------------------
     *  Manage Content Controllers
     *-------------------------------
     */
    public function manage_posts($slim) {
        $slim->render('admin/content/manage-posts.php', array (
            'head_title' => "Manage Posts",
            'meta_title' => 'Manage Posts - Admin Dashboard'
        ));
    } // manage_posts (slim Obj)
    
    /**
     * Render the Add Page page in admin 
     */
    public function manage_pages($slim) {
        $slim->render('admin/content/manage-pages.php', array (
            'head_title' => "Manage Pages",
            'meta_title' => 'Manage Posts - Admin Dashboard'
        ));
    } // manage_pages (slim Obj)
    /**
     * Render the Add Media page in admin 
     */
    public function manage_media($slim) {
        $slim->render('admin/content/manage-media.php', array (
            'head_title' => "Manage Media",
            'meta_title' => 'Manage Media - Admin Dashboard'
        ));
    } // manage_media (slim Obj)
} // class Admin