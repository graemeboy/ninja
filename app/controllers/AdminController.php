<?php
require_once BASEPATH . 'admin-functions.php';
require_once APPPATH . 'models/Post.php';

/**
 * Class Admin
 *
 * Sets up the controllers for the admin pages.
 */
class AdminController extends Controller
{
    public static $postModel;

    public function __construct() {
        static::$postModel = new Post();
        echo "Has post model";
    }
    /**
     * index
     * The user is requesting the index admin page.
     * If the user is logged in, show the dashboard,
     * otherwise, redirect to a log in page.
     */
    public function index() {
        echo 'Welcome to the admin index.';

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
        echo "init post";

        $posts = static::$postModel->getAll();
        echo "got posts";

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
        print_r($postData);
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
        echo "Rendering page";
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
    public function deletePost( $slug, $router ) {
        static::$postModel->delete( $slug );
        $router->redirect( '/admin/edit-posts' );
    }

    /**
     * Render the Add Media page in admin
     */
    public function manageMedia( $slim ) {
        $slim->render( 'admin/content/manage-media.php', array (
                'page_title' => "Manage Media",
                'meta_title' => 'Manage Media - Admin Dashboard'
            ) );
    }

    /*-------------------------------
     * Settings Pages
     *-------------------------------
     */
    public function settingsSite( $slim ) {
        $slim->render( 'admin/settings/settings-site.php', array (
                'page_title' => "Site Settings",
                'meta_title' => 'Site Settings - Admin Dashboard'
            ) );
    }
} // class Admin
