<?php
require_once(BASEPATH . 'admin-functions.php');

/**
 * Class Front
 *
 * Sets up the controllers for the front end of the application.
 */
class Front extends Controller
{
    /* ----------
     *  Fields
     * ----------
     */
    const THEMEPATH = 'front/defaultTheme/';
    
    // PostModel
    public static $postModel;
    public static $themeDir;
    /* ---------------
     *  Constructors
     * ---------------
     */
    public function __construct () {
        self::$postModel = new PostModel();
        $this->setThemePath(self::THEMEPATH);
    } // __construct ()
    
    /**
     * function setThemePath
     * Mutates the current theme path
     * @param string path
     * @return void
     * @post the theme path is set to the path param
     */
    public function setThemePath($path) {
        self::$themeDir = $path;
    } // setThemePath
    
    /* ---------------
     *  Methods
     * ---------------
     */
    /**
     * Index
     * This is the homepage.
     */
    function index()
    {
        echo "Welcome to the homepage";
        echo "Data path is: " . DATAPATH;
    } // index ()
    
    /**
     * function post
     * Renders a post on the front end
     */
    function post ($slug, $app) {
        $postData = self::$postModel->getPostSummary($slug);
        $postHtml = self::$postModel->getPostHTML($slug);
        $postData['content'] = $postHtml;
        echo self::$themeDir . 'main.php';
        
        $app->render(self::$themeDir . 'main.php', array (
            'meta_title' => 'Edit Post - Admin Dashboard',
            'post_data' => $postData,
        ));
    } // post ()
    
} // class Front