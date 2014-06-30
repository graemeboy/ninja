<?php namespace ninja\Controllers;

use ninja\Models\Post as Post;

require_once BASEPATH . 'admin-functions.php';


/**
 * Class Front
 *
 * Sets up the controllers for the front end of the application.
 */
class FrontController extends Controller
{
    /* ----------
     *  Fields
     * ----------
     */
    // The theme path that frontend controllers will use.
    const THEMEPATH = 'front/2/';

    // The Post Model, for accessing and setting post data.
    public static $postModel;
    // The directory for the current theme that is set by the system configurations.
    public static $themeDir;

    /* ---------------
     *  Constructors
     * ---------------
     */
    public function __construct() {
        // Instantiate a new Post model.
        static::$postModel = new Post();
        // Set the theme path.
        static::$themeDir = static::THEMEPATH;
    }


    /* ---------------
     *  Methods
     * ---------------
     */
    /**
     * function index
     * The controller function for the homepage.
     *
     * @return void
     * @post the homepage is rendered.
     */
    function index() {
        echo "Welcome to the homepage";
        echo "Data path is: " . DATAPATH;
    } // index ()

    /**
     * function post
     * Renders a post on the front end
     */
    function post( $slug, $app ) {
        // Set the style for the views.
        $style = "Slate";
        $bootstrapPath = "public/bootstrap/css/bootstrap.min.css";
        $app->view->setData('stylesheet', "public/css/$style.css");
        $app->view->setData('bootstrap', $bootstrapPath);
        $app->view->setData('logo_url', 
            'http://ewa.ozythemes.com/layout02/wp-content/uploads/sites/2/2013/04/logo_green_x2.png');
        $app->view->setData('site_subtitle', 'This is the site subtitle');
        $app->view->setData('copyright', '&copy; 2014');

        $postData = static::$postModel->getSummary( $slug );
        $postHtml = static::$postModel->getHtml( $slug );
        $postData['content'] = $postHtml;

        $app->render( static::$themeDir . 'post.php', array (
                'meta_title' => $postData['title'],
                'post_data' => $postData,
            ) );
    } // post ()

} // class Front
