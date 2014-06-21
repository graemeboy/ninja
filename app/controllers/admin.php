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
    
    /**
     * Render the Add Post page in the admin area
     */
    public function add_post($slim) {
        $slim->render('admin/add-post.php', array (
            'head_title' => "Add a Post",
            'meta_title' => 'Add a Post - Admin Dashboard'
        ));
    } // add_post (slim Obj)
    
    /**
     * Render the Add Page page in admin 
     */
    public function add_page($slim) {
        $slim->render('admin/add-page.php', array (
            'head_title' => "Add a Page",
            'meta_title' => 'Add a Post - Admin Dashboard'
        ));
    } // add_page (slim Obj)
} // class Admin