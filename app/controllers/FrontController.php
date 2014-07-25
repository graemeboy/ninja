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
    const PUBLIC_DIR = 'public/';

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
        // Set public path
        static::$app->view->setData( 'public_dir', self::PUBLIC_DIR );
    }

    function renderPost( $slug ) {
        $postData = static::$postModel->getSummary( $slug );
        $postHtml = static::$postModel->getHtml( $slug );
        $postData['content'] = $postHtml;

        $socialButtonSettings = static::$settingsModel->getSocialButtonSettings();
        if (!empty($socialButtonSettings) && $socialButtonSettings === 'share_post_bottom') {
            $networks = array (
                'facebook', 'googleplus', 'twitter', 'stumbleupon', 'linkedin', 'reddit'
            );
            $shareButtons = "<style>.post-bottom-share-button{display:inline-block;margin-right:15px;margin-bottom:5px;width:180px}</style>";
            $shareButtons .= getSocialButtons($networks, 'post-bottom-share-button');
            static::$app->view->setData('shareButtons', $shareButtons);
        }

        // Render the post.
        $this->renderContent ($postData, 'post.php');
    }

    function renderPage( $slug ) {
        // Set the page content and other data.
        $pageData = static::$pageModel->getSummary( $slug );
        $pageHtml = static::$pageModel->getHtml( $slug );
        $pageData['content'] = $pageHtml;

        // Render the page.
        $this->renderContent($pageData, 'page.php');
    }

    function renderContent($data, $file) {
        static::$app->render( static::$layoutDir . $file, array (
            'meta_title' => $data['title'],
            'post_data' => $data,
        ) );
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
        $homepageContent = static::$settingsModel->getHomepageType();
        // Check the settings model to see whether
        if ( $homepageContent === 'posts' ) {
            // the user wants to display posts or a static page.
            // Get the excerpts for the last $num number of posts
            $numExcerpts = 5;
            $excerpts = static::$postModel->getExcerpts( $numExcerpts );
            $this->renderContent( array(
                'title' => 'Home',
                'excerpts' => $excerpts,
                ), 'index.php' );
            // Set the app data, giving it the excerpts.
            // Render content, using the "home.php" file for rendering.
        } else {
            // Show a static page
            $slug = 'home';
            $this->renderPage( $slug );
        }
    } // index ()

    /**
     * Render a post on the front end.
     */
    function post( $slug ) {
        $this->renderPost( $slug );
    }

    /**
     * Render a page on the front end.
     */
    function page( $slug ) {
        $this->renderPage( $slug );
    }

} // class Front
