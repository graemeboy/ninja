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
        $this->setMarkdownPath( DATAPATH . self::MARKDOWN_PATH );
        $this->setHtmlPath( DATAPATH . self::HTML_PATH );
        $this->setSummaryPath( DATAPATH . self::SUMMARY_PATH );
    } // __construct ()

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
        $posts = $this->getAllPosts();
        // Return boolean if a post exists with this slug.
        return !empty( $posts[$slug] );
    } // isPost(string)


    /* ------------------
     *  Mutator Methods
     * -----------------
     */


    /**
     * function forceSafeSlug
     * Ensures that the slug can be used as it is.
     * This ought to have been done on the frontend, but is further
     * reinforced at this point.
     *
     * @param string  $str
     * @param int     $length, the maximum length of the slug
     * @return string
     */
    //    function forceSafeSlug($str, $length = 64) {
    //        $str = safeString(strip_tags($str));
    //
    //        $str = str_replace(" ", "-", $str);
    //        $str = strtolower(preg_replace("/[^a-zA-Z0-9_-]/i", "", $str));
    //        $str = preg_replace("/[-]+/i", "-", $str);
    //        if ($length > 0) {
    //            $str = substr($str, 0, $length);
    //        }
    //        $str = trim($str, " -"); // Make sure it doesn't start or end with '-'..
    //
    //        return $str;
    //    }
} // class PostModel

?>
