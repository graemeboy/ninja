<?php namespace ninja\Controllers;

use ninja\Models\Post;
use ninja\Models\Page;
use ninja\Models\Settings;
use ninja\Libraries\UploadHandler;

require_once BASEPATH . 'admin-functions.php';
require_once APPPATH . 'models/Post.php';
require_once APPPATH . 'models/Page.php';
require_once APPPATH . 'models/Settings.php';
require_once APPPATH . 'libraries/UploadHandler.php';

/**
 * Class Admin
 *
 * Sets up the controllers for the admin pages.
 */
class AdminController extends Controller
{
    /**
     * The path to the thumbnail directory.
     *
     * @access  const
     * @var  String the path to thumbnails of styles and layouts.
     */
    const THUMBNAIL_PATH = "/public/admin/thumbnails";

    /**
     * The model for posts.
     *
     * @access public static
     * @var  string
     */
    public static $postModel;

    /**
     * The model for pages.
     *
     * @access public static
     * @var  string
     */
    public static $pageModel;

    /**
     * The model for settings.
     *
     * @access  public static
     * @var  Object model
     */
    public static $settingsModel;

    /**
     * The array of possible layouts, provided by the package.
     *
     * @access  public static
     * @var  Array an array of strings that identify the layouts.
     */
    public static $layouts = array (
        'default', '1', '2'
    );

    /**
     * The array of possible styles, provided by the package.
     *
     * @access  public static
     * @var  Array, an array of strings that identify the styles.
     */
    public static $styles = array (
        'amelia', 'cerulean', 'cosmo', 'cyborg', 'darkly', 'flatly',
        'journal', 'lumen', 'readable', 'simplex', 'slate', 'spacelab',
        'superhero', 'united', 'yeti'
    );



    public function __construct() {
        // Init post model.
        static::$postModel = new Post();
        // Init page model.
        static::$pageModel = new Page();
        // Init settings model.
        static::$settingsModel = new Settings();
    }
    /**
     * The URL requested by "/admin" or "/admin/"
     *
     * Because no specific page in the admin is requested,
     * redirect the user to the dashboard.
     *
     * @param Object  @app the Slim framework app that provides redirect.
     */
    public function index( $app ) {
        // If logged in, redirect to the dashboard.
        $app->redirect( '/admin/dashboard' );
    }

    /**
     *
     */
    function ajaxRequest( $postData ) {

        $action = "admin_ajax_" . $postData[ 'action' ];
        // Check if this ajax method exists
        if ( method_exists( $this, $action ) ) {
            unset( $postData['action'] );
            $resp = call_user_func_array( array( $this, $action ), array( $postData ) );
        } else {
            $resp = 'incorrect action: ' . $action;
        }
    }

    /**
     * Set the primary menu items.
     *
     */
    function admin_ajax_set_primary_menu( $data ) {
        $items = array_filter( explode( ',', $data['items'] ) );
        static::$settingsModel->setPrimaryMenu( $items );
    }

    /**
     * Set the secondary menu items.
     *
     */
    function admin_ajax_set_secondary_menu( $data ) {
        $items = array_filter( explode( ',', $data['items'] ) );
        static::$settingsModel->setSecondaryMenu( $items );
    }

    /**
     * admin_ajax_delete
     *
     * @param string  $slug
     */
    function admin_ajax_delete( $slug ) {
        static::$postModel->delete( $slug );
    }

    function admin_ajax_save( $contentData ) {
        // Add current time as last updated.
        $contentData['last_edited'] = date( "Y-m-d H:i:s" );
        $contentType = $contentData['contentType'];
        unset( $contentData['contentType'] );
        if ( $contentType === 'post' ) {
            // Save the post data.
            static::$postModel->save( $contentData );
        } else if ( $contentType === 'page' ) {
                // Save the page data.
                static::$pageModel->save( $contentData );
            }
        die( "success" );
    }

    function admin_ajax_save_widget( $widgetData ) {
        $widgetId = $widgetData['widgetId'];
        unset($widgetData['widgetId']);
        
        static::$settingsModel->saveWidget($widgetId, $widgetData);
    }

    function admin_ajax_upload_media() {
        // Handle the upload.
        $uploadHandler = new UploadHandler();
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
        if ( !empty( $data['layout'] ) ) {
            static::$settingsModel->setLayout( $data['layout'] );
        }
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
        if ( !empty( $data['style'] ) ) {
            static::$settingsModel->setStyle( $data['style'] );
        }
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
                    '/public/js/StopWord.js',
                    '/public/js/content.js',
                    //'/public/js/googleAPI.js',
                    //'https://apis.google.com/js/client.js?onload=onClientLoad'
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
        $page_data = array (
            'title' => '',
            'content' => '',
            'tags' => array (),
            'slug' => ''
        );
        $slim->render( 'admin/content/add-page.php', array (
                'page_title' => "Add a Page",
                'meta_title' => 'Add a Page - Admin Dashboard',
                'scripts' => array (
                    '/public/js/markitup/markdown.js',
                    '/public/js/markitup/jquery.markitup.js',
                    '/public/js/StopWord.js',
                    '/public/js/content.js'
                ),
                'styles' => array (
                    '/public/fontawesome/css/font-awesome.min.css'
                ),
                'save_button' => 'Create',
                'page_data' => $page_data,
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
    public function managePages( $slim ) {
        $pages = static::$pageModel->getAll();

        $slim->render( 'admin/content/manage-pages.php', array (
                'page_title' => "Manage Pages",
                'meta_title' => 'Manage Posts - Admin Dashboard',
                'styles' => array (
                    '/public/fontawesome/css/font-awesome.min.css'
                ),
                'pages' => $pages
            ) );
    }

    /*-------------------------------
     *  Edit Content Controllers
     *-------------------------------
     */
    public function editPost( $slim, $slug ) {
        $postData = static::$postModel->getSummary( $slug );
        $postMarkdown = static::$postModel->getMarkdown( $slug );
        $postData['content'] = $postMarkdown;

        $slim->render( 'admin/content/add-post.php', array (
                'page_title' => "Edit Post",
                'meta_title' => 'Edit Post - Admin Dashboard',
                'post_data' => $postData,
                'scripts' => array (
                    '/public/js/markitup/markdown.js',
                    '/public/js/markitup/jquery.markitup.js',
                    '/public/js/content.js',
                    '/public/js/StopWord.js',
                ),
                'styles' => array (
                    '/public/fontawesome/css/font-awesome.min.css'
                ),
                'save_button' => 'Save Post',
            ) );
    }

    public function editPage( $slim, $slug ) {
        $pageData = static::$pageModel->getSummary( $slug );
        $pageMarkdown = static::$pageModel->getMarkdown( $slug );
        $pageData['content'] = $pageMarkdown;

        $slim->render( 'admin/content/add-page.php', array (
                'page_title' => "Edit Page",
                'meta_title' => 'Edit Page - Admin Dashboard',
                'page_data' => $pageData,
                'scripts' => array (
                    '/public/js/markitup/markdown.js',
                    '/public/js/markitup/jquery.markitup.js',
                    '/public/js/content.js',
                    '/public/js/StopWord.js',
                ),
                'styles' => array (
                    '/public/fontawesome/css/font-awesome.min.css'
                ),
                'save_button' => 'Save Page',
            ) );
    }

    function menu( $slim ) {
        $pages = static::$pageModel->getAll();
        $primaryMenu = static::$settingsModel->getPrimaryMenu();
        $secondaryMenu = static::$settingsModel->getSecondaryMenu();

        $slim->render( 'admin/appearance/menu.php', array (
                'page_title' => "Menu Settings",
                'meta_title' => "Menu Settings",
                'icon' => 'dashicons dashicons-menu',
                'settings' => array(),
                'pages' => $pages,
                'primary_menu' => $primaryMenu,
                'secondary_menu' => $secondaryMenu
            ) );
    }

    function sidebar( $slim ) {
        $slim->render( 'admin/appearance/sidebar.php', array (
                'page_title' => "Sidebar Widgets",
                'meta_title' => "Sidebar Settings",
                'icon' => 'dashicons dashicons-align-right',
                'scripts' => array (
                    '/public/js/markitup/markdown.js',
                    '/public/js/markitup/jquery.markitup.js',
                ),
                'styles' => array (
                    '/public/fontawesome/css/font-awesome.min.css'
                ),
            ) );
    }

    /**
     * function layoutStyle
     *
     * @param slim
     */
    function layoutStyle( $slim ) {
        $settings = static::$settingsModel->getAppearanceSettings();
        // Set some defaults in case mandatory variables are not set.
        if ( empty( $settings['layout'] ) ) {
            $settings['layout'] = 'default';
        }
        if ( empty( $settings['style'] ) ) {
            $settings['style'] = 'cerulean';
        }



        $slim->render( 'admin/appearance/layoutStyle.php', array (
                'page_title' => "Layout and Style",
                'meta_title' => "Layout and Style - Admin Dashboard",
                'scripts' => array (
                    '/public/js/appearance.js',
                ),
                'settings' => $settings,
                'styles' => static::$styles,
                'layouts' => static::$layouts,
                'thumbPath' => self::THUMBNAIL_PATH
            ) );
    }

    /**
     * Delete a post
     *
     * Delete a post's associated files, give a valid post slug.
     *
     * @param string  $slug, the slug identifier of the post data
     * @return void
     * @post any html files, .md files, and post summary data are removed.
     */
    function deletePost( $slug ) {
        static::$postModel->delete( $slug );
    }

    /**
     * Delete a page
     *
     * Delete a page's associated files, give a valid page slug.
     *
     * @param string  $slug, the slug identifier of the page data
     * @return void
     * @post any html files, .md files, and page summary data are removed.
     */
    function deletePage( $slug ) {
        static::$pageModel->delete( $slug );
    }

    /**
     * Delete a media file and its thumbnail.
     *
     * Check if a media file exists, given the file name, and delete the file and its thumbnail.
     *
     * @param string  $filename, the file name of the media file within media directory.
     * @return void
     * @post the media file and its associated thumbnail are deleted from the server.
     */
    function deleteMedia( $filename ) {
        // Define the path to the file. Does not need resolving.
        $filePath = PUBLICPATH . "media/$filename";
        // Check if file exists.
        if ( is_readable( $filePath ) ) {
            // Delete the file.
            unlink( $filePath );
        }
        // Define the path to the file's thumbnail.
        $thumbPath = PUBLICPATH . "media/thumbnail/$filename";
        // Check if thumbnail exists.
        if ( is_readable( $thumbPath ) ) {
            // Delete the thumbnail.
            unlink( $thumbPath );
        }
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
} // class AdminController
