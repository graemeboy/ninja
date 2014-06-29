<?php
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
    const THEMEPATH = 'front/defaultTheme/';

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
        $postData = static::$postModel->getPostSummary( $slug );
        $postHtml = static::$postModel->getPostHTML( $slug );
        $postData['content'] = $postHtml;
        echo static::$themeDir . 'main.php';

        $app->render( static::$themeDir . 'main.php', array (
                'meta_title' => 'Edit Post - Admin Dashboard',
                'post_data' => $postData,
            ) );
    } // post ()

} // class Front
