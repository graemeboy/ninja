<?php namespace ninja\Controllers;

use ninja\Models\Post;
use ninja\Models\Page;
use ninja\Models\Settings;

require_once BASEPATH . 'front-functions.php';

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
    const LAYOUT_PATH = 'front/';
    const STYLE_PATH = 'public/css/';

    // The Post Model, for accessing post data.
    public static $postModel;
    // The Page Model, for accessing page data.
    public static $pageModel;
    // The Settings Model, for accessing settings for the front end.
    public static $settingsModel;
    // The directory for the current theme that is set by the system configurations.
    public static $layoutDir;
    // The directory for the current style, set by system configurations
    public static $stylesheet;
    // The engine for rending post and page templates.
    static $app;

    /* ---------------
     *  Constructors
     * ---------------
     */
    public function __construct() {
        global $router;
        // Instantiate a new Post model.
        static::$postModel = new Post();
        // Init the Page Model.
        static::$pageModel = new Page();
        // Init Settings
        static::$settingsModel = new Settings();

        // Set the theming for the frontend.
        $this->setFrontTheming();

        static::$app = $router;
        $this->setFrontData();
    }

    /**
     * Set the theming variables for the frontend
     *
     * Set the layout directory, and the path to the stylesheet,
     * as configured by the user.
     *
     * @return void
     */
    function setFrontTheming() {
        // Get layout and style settings from Settings model.
        $layoutAndStyle = static::$settingsModel->getLayoutAndStyle();
        // Set layout dir - contains trailing slash.
        static::$layoutDir = static::LAYOUT_PATH . $layoutAndStyle['layout'] . '/';
        // Set stylesheet - the path to the exact, single stylesheet.
        static::$stylesheet = static::STYLE_PATH . $layoutAndStyle['style'] . '.css';
    }

    /**
     * Set the data displayed on the frontend
     *
     * Set the app data, including the stylesheet directory, path
     * to bootstrap CSS file, logo, sidebar content, site title and subtitle, and copyright notice.
     *
     * @return  void
     */
    function setFrontData() {
        // Set the style for the views.
        $bootstrapPath = "public/bootstrap/css/bootstrap.min.css";
        static::$app->view->setData( 'stylesheet', static::$stylesheet );
        static::$app->view->setData( 'bootstrap', $bootstrapPath );
        // Set the sidebar content.
        static::$app->view->setData( 'sidebar_content',
            ( static::$settingsModel->getSidebarContent() ) );
        // Set site settings, including logo, title, subtitle, copyright notice.
        static::$app->view->setData( 'site_settings',
            ( static::$settingsModel->getSiteSettings() ) );
        // Set primary menu.
        static::$app->view->setData( 'primary_menu',
            ( static::$settingsModel->getPrimaryMenu() ) );
        // Set secondary menu.
        static::$app->view->setData( 'secondary_menu',
            ( static::$settingsModel->getSecondaryMenu() ) );
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
     * Render a post on the front end.
     */
    function post( $slug ) {
        // Set the post data and html content.
        $postData = static::$postModel->getSummary( $slug );
        $postHtml = static::$postModel->getHtml( $slug );
        $postData['content'] = $postHtml;

        // Render the post.
        static::$app->render( static::$layoutDir . 'post.php', array (
                'meta_title' => $postData['title'],
                'post_data' => $postData,
            ) );
    }

    /**
     * Render a page on the front end.
     */
    function page( $slug ) {
        // Set the page content and other data.
        $pageData = static::$pageModel->getSummary( $slug );
        $pageHtml = static::$pageModel->getHtml( $slug );
        $pageData['content'] = $pageHtml;

        // Render the page.
        static::$app->render( static::$layoutDir . 'page.php', array (
                'meta_title' => $pageData['title'],
                'post_data' => $pageData,
            ) );
    }

} // class Front
