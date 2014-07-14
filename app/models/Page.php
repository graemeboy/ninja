<?php namespace ninja\Models;

require_once('Content.php');
require_once('Settings.php');
use ninja\Models\Content;
use ninja\Models\Settings;

class Page extends Content
{
    /*-------------
     * Fields
     *------------
     */
    // Summary path, a path to some standard data file type (json, xml, yaml.)
    const SUMMARY_PATH = "pages/pages_summary.json";
    // HTML path, a path to the HTML files for content, used to display pages on frontend.
    const HTML_PATH = "pages/html/";
    // Markdown path, a path to the .md file used for editing pages in the admin area.
    const MARKDOWN_PATH = "pages/markdown/";


    function __construct() {
        // Set the content paths.
        $this->setMarkdownPath( DATAPATH . self::MARKDOWN_PATH );
        $this->setHtmlPath( DATAPATH . self::HTML_PATH );
        $this->setSummaryPath( DATAPATH . self::SUMMARY_PATH );
    }
    
    /* -----------------
     *  Observers
     * ----------------
     */

    /**
     * function isPage
     * Returns true if a page is contained in the array of pages stored in summary.
     *
     * @param string  $slug
     * @return boolean isPage
     */
    function isPage( $slug ) {
        // Get all page summaries (the smallest sets of data about posts)
        $pages = $this->getAll();
        // Return boolean if a page exists with this slug.
        return !empty( $pages[$slug] );
    } // isPage(string)

    /*  ---------------------
     *   Mutators
     *  ---------------------
     */
    
    function save ($pageData) {
        parent::save($pageData);
        // Now, add it to the primary and secondary menus.
        //$settingsModel = new Settings();
        //$settingsModel->addMenuItem('primary', $pageData['slug'], $pageData['title']);
    }
} // class pageModel