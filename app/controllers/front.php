<?php

/**
 * Class Front
 *
 * Sets up the controllers for the front end of the application.
 */
class Front extends Controller
{
    /**
     * Index
     * This is the homepage.
     */
    public function index()
    {
        echo "Welcome to the homepage";
        echo "Data path is: " . DATAPATH;
    } // index ()
} // class Front