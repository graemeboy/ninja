<?php namespace ninja\Models;

require_once('Content.php');
use ninja\Models\Content as Content;

class Post extends Content
{
    /*-------------
     * Fields
     *------------
     */
    // Summary path, a path to some standard data file type (json, xml, yaml.)
    const SUMMARY_PATH = "posts/posts_summary.json";
    const HTML_PATH = "posts/html/";
    const MARKDOWN_PATH = "posts/markdown/";

    /*-------------
     * Constructors
     *-------------
     */
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
     * function isPost
     * Returns true if a post is contained in the array of posts stored in summary.
     *
     * @param string  $slug
     * @return boolean isPost
     */
    public function isPost( $slug ) {
        // Get all post summaries (the smallest sets of data about posts)
        $posts = $this->getAll();
        // Return boolean if a post exists with this slug.
        return !empty( $posts[$slug] );
    } // isPost(string)

} // class PostModel

?>
