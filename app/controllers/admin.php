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
    
    public function dashboard() {
        echo "This is the admin dashboard";
    } // dashboard ()

} // class Admin