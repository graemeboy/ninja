<?php namespace ninja\Controllers;

use ninja\Models\Post as Post;
use ninja\Models\Settings as Settings;

require_once BASEPATH . 'admin-functions.php';
require_once APPPATH . 'models/Post.php';
require_once APPPATH . 'models/Settings.php';

/**
 * Class Admin
 *
 * Sets up the controllers for the admin pages.
 */
class AdminController extends Controller
{
    /**
     * The model for posts.
     * 
     * @access public static
     * @var  string
     */
    public static $postModel;

    public function __construct() {
        static::$postModel = new Post();
    }
    /**
     * The URL requested by "/admin" or "/admin/"
     * 
     * Because no specific page in the admin is requested, 
     * redirect the user to the dashboard.
     * 
     * @param Object @app the Slim framework app that provides redirect.
     */
    public function index( $app ) {
        // If logged in, redirect to the dashboard.
        $app->redirect( '/admin/dashboard' );
    }

    /**
     * 
     */
    function ajaxRequest( $postData ) {
        echo "received post";
        $action = "admin_ajax_" . $postData[ 'action' ];
        // Check if this ajax method exists
        if ( method_exists( $this, $action ) ) {
            unset( $postData['action'] );
            print_r( $postData );
            $resp = call_user_func_array( array( $this, $action ), array( $postData ) );
        } else {
            $resp = 'incorrect action: ' . $action;
        }
        echo $resp;
    }

    /**
     * admin_ajax_delete
     *
     * @param string  $slug
     * @return [type]            [description]
     */
    function admin_ajax_delete( $slug ) {
        static::$postModel->delete( $slug );
    }

    function admin_ajax_save( $postData ) {
        // Add current time as last updated.
        $postData['last_edited'] = date( "Y-m-d H:i:s" );
        // Save the post data.
        static::$postModel->save( $postData );
        echo "success";
    }

    /**
     * Update the site's layout settings.
     *
     * Receive data from the admin frontend that tells the server which layout
     * option to update to, and then set that option in the configuration file
     * for the site's appearance.
     *
     * @param array   $data contains the new layout id
     * @return void
     */
    function admin_ajax_update_layout( $data ) {
        print_r( $data );
        echo "success";
    }

    /**
     * Update the site's style settings.
     *
     * Receive data from the admin frontend that tells the server which stylesheet
     * should be rendered when displaying the frontend of the website. Update those
     * options in the site's configuration file.
     *
     * @param array   $data contains the new style id
     * @return void
     */
    function admin_ajax_update_style( $data ) {
        print_r( $data );
        echo "success";
    }


    /**
     * Render the Admin Dashboard
     */
    public function dashboard( $slim ) {
        $slim->render( 'admin/dashboard.php', array (
                'head_title' => "Admin Dashboard",
                'meta_title' => 'Admin Dashboard'
            ) );
    }

    /*-------------------------------
     *  Add Content Controllers
     *-------------------------------
     */
    /**
     * Render the Add Post page in the admin area
     */
    public function addPost( $slim ) {
        $post_data = array (
            'title' => '',
            'content' => '',
            'tags' => array (),
            'slug' => ''
        );
        $slim->render( 'admin/content/add-post.php', array (
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
            ) );
    }

    /**
     * Render the Add Page page in admin
     */
    public function addPage( $slim ) {
        $slim->render( 'admin/content/add-page.php', array (
                'page_title' => "Add a Page",
                'meta_title' => 'Add a Post - Admin Dashboard'
            ) );
    }
    /**
     * Render the Add Media page in admin
     */
    public function addMedia( $slim ) {
        $slim->render( 'admin/content/add-media.php', array (
                'page_title' => "Add Media",
                'meta_title' => 'Add Media - Admin Dashboard',
            ) );
    }

    /*-------------------------------
     *  Manage Content Controllers
     *-------------------------------
     */
    public function managePosts( $slim ) {
        $posts = static::$postModel->getAll();

        $slim->render( 'admin/content/manage-posts.php', array (
                'page_title' => "Manage Posts",
                'meta_title' => 'Manage Posts - Admin Dashboard',
                'styles' => array (
                    '/public/fontawesome/css/font-awesome.min.css'
                ),
                'posts' => $posts,
            ) );
    }

    /**
     * Render the Add Page page in admin
     */
    public function manage_pages( $slim ) {
        $slim->render( 'admin/content/manage-pages.php', array (
                'page_title' => "Manage Pages",
                'meta_title' => 'Manage Posts - Admin Dashboard'
            ) );
    }

    /*-------------------------------
     *  Edit Content Controllers
     *-------------------------------
     */
    public function editPost( $slim, $slug ) {
        echo "editing post";
        $postData = static::$postModel->getSummary( $slug );
        print_r( $postData );
        $postMarkdown = static::$postModel->getMarkdown( $slug );
        echo $postMarkdown;
        $postData['content'] = $postMarkdown;

        $slim->render( 'admin/content/add-post.php', array (
                'page_title' => "Edit Post",
                'meta_title' => 'Edit Post - Admin Dashboard',
                'post_data' => $postData,
                'scripts' => array (
                    '/public/js/markitup/markdown.js',
                    '/public/js/markitup/jquery.markitup.js'
                ),
                'styles' => array (
                    '/public/fontawesome/css/font-awesome.min.css'
                ),
                'save_button' => 'Save Post',
            ) );
    }

    /**
     * function appearance
     *
     * @param slim    Obj
     */
    function appearance( $slim ) {
        $slim->render( 'admin/appearance.php', array (
                'page_title' => "Layout and Style",
                'meta_title' => "Layout and Style - Admin Dashboard"
            ) );
    }

    /**
     * function deletePost
     *
     * @param string  $slug, the slug identifier of the post_data
     * @return void
     * @post any html files, .md files, and post summary data are removed.
     */
    function deletePost( $slug ) {
        static::$postModel->delete( $slug );
    }

    /**
     * Render the Add Media page in admin
     */
    function manageMedia( $slim ) {
        $slim->render( 'admin/content/manage-media.php', array (
                'page_title' => "Manage Media",
                'meta_title' => 'Manage Media - Admin Dashboard'
            ) );
    }

    /*-------------------------------
     * Settings Pages
     *-------------------------------
     */
    function settingsSite( $slim ) {
        $slim->render( 'admin/settings/settings-site.php', array (
                'page_title' => "Site Settings",
                'meta_title' => 'Site Settings - Admin Dashboard'
            ) );
    }
} // class Admin
