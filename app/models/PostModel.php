<?php

class PostModel
{
    /*-------------
     * Fields 
     *------------
     */
    // Summary path, a path to some standard data file type (json, xml, yaml.)
    const SUMMARY_PATH = "posts/posts_summary.json";
    const HTML_PATH = "posts/html/";
    
    // The full path to the summary page, including system's data path.
    public static $summaryPage;
    public static $htmlPath;
    
    /*-------------
     * Constructors
     *-------------
     */
    function __construct() {
        // Set the summary page path
        self::$summaryPage = DATAPATH . self::SUMMARY_PATH;
        self::$htmlPath = DATAPATH . self::HTML_PATH;
    } // __construct ()
    
    /* -----------------
     *  Observers 
     * ----------------
     */
    
    /**
     * Get all post summaries as a PHP array
     * @return array of posts
     */
    public function getAllPosts() {
        $json_data = file_get_contents(self::$summaryPage);
        // Return posts as a php array.
        return json_decode($json_data, true);
    } // get posts()
    
    /**
     * function isPost
     * @param string $slug
     * @return boolean isPost
     */
    public function isPost($slug) {
        // Get all post summaries (the smallest sets of data about posts)
        $posts = $this->get_all_posts();
        // Return boolean if a post exists with this slug.
        return (!empty($posts[$slug]));        
    } // isPost(string)
    
    /**
     * Get the mardown data for a post, given a slug
     * @return array of post data
     */
    public function getPostMarkdown ($slug) {
        include_once (DATAPATH . "posts/md/$post_slug.php");
        return $post_data;
    } // get_post (string)
    
    /**
     * Returns the HTML content for a given post slug
     * @param slug, string
     * @return html string for post with given slug
     */
    public function getPostHTML ($slug) {
        $htmlFile = $self::$htmlPath . "$slug.html";
        if (file_exists($htmlFile)) {
            return file_get_contents($htmlFile);
        } // if
    } // getPostHTML (string)
    
    /* -------------
     *  Mutators
     * -------------
     */
    /**
     * Will append all post summaries given a new post summary.
     * @pre no existing post should have the same slug. 
     *  Otherwise it is overwritten.
     */
    function appendSummary ($postData) {
        // Get all of the posts as assoc array
        $posts = $this->get_posts();
        // Set the array with item slug to the given post data
        $posts[$postData['slug']] = $postData;
        // Now save these data to the summary file
        $this->saveDataToFile($posts, self::summaryPage);
    } // appendSummary (array)
    
    
    /**
     * function deletePost
     * Takes a post slug and removes it from summary, 
     *  deletes the markdown and html files.
     */
    function deletePost($postSlug) {
        /*
         *  Delete post from summary
         */
        $posts = $this->getAllPosts();
        if (!empty($posts[$postSlug])) {
            unset($posts[$postSlug]);
        } // if
        $this->saveDataToFile($posts, self::$summaryPage);
        // Remove the html file
        unlink(DATAPATH . "posts/md/$post_slug.php");
        unline(DATAPATH . "posts/html/$post_slug.php");
    } // deletePost (string)
    
    /**
     * Unlinks the html page for a given post.
     */
    function deletePostHTML ($slug) {
        // HTML data is stored in a json file.
        unlink(self::$htmlPath . "$slug.html");
    } // deletePostHTML

    /**
     * function savePostFile
     * Puts post data as an array in to a standard data structure file 
     * that has the same of the slug.
     * @param $postData, php array
     */
    function savePostFile ($postData) {
        $slug = $post_data['slug'];
        $post_string = var_export($post_data, true);
        $data = '<?php $post_data = ' . $post_string . '; ?>';
        file_put_contents (self::$htmlPath . $slug.php, $data);
    } // save_html (array)
    
    
    
    /**
     * Add a post to the posts "database"
     */
    public function savePost ($postData){
        
        /*
         * Set data for summary and HTML
         */ 
        $summaryData = $postData;
        unset($summaryData['content']); // remove any content
        
        $htmlContent = convert_md_to_html($postData['content']);
        
        // Remove any existing post with the original slug
        removeOriginalPost($postData);
        echo "updateding post data";
        // Save summary data.
        $this->appendSummary($summaryData);

        /*
         * Save HTML data.
         */
        $this->saveHTMLToFile($htmlContent, $postData['slug']);
    } // savePost(array)
   
    /**
     * function removeOriginalPost
     * Posts can be edited and slugs changed. The edit post page
     * will send a "slug-original" value of the post's slug before
     * the change, which will be deleted.
     * @para $postData, includes param ['slug-original']
     */
    public function removeOriginalPost ($postData) {
        /*
         * If an existing post is being edited, then that post ought
         * to be removed before the new data are added.
         */
        if (!empty($postData['slug-original']) && 
                   trim ($postData['slug-original']) !== '' ) {
            $this->deletePost($postData['slug-original']);
        } // if
    } // removeOriginalPost(array)
    
    /**
     * Takes a PHP array and saves it as an appropriate data structure 
     * to the file.
     * @param $data, a php array
     */
    function saveDataToFile ($data, $filename) {
        // Save contents of php arrry to the summary page as json.
        file_put_contents (json_encode($posts_summary), $filename);
    } // save_summary (array)
    
    /**
     * function saveHTMLToFile
     * @param $htmlContent, string of html
     * @param $slug, string
     * @post an html file is created containing the given html
     */
    function saveHTMLToFile($htmlContent, $slug) {
        file_put_contents ($htmlContent, "$slug.html");
    } // saveHTMLToFile (string, string)
    
/**
 * function forceSafeSlug
 * Ensures that the slug can be used as it is.
 * This ought to have been done on the frontend, but is further
 * reinforced at this point.
 *
 * @param string $str
 * @param int $length, the maximum length of the slug
 * @return string
 */
function forceSafeSlug($str, $length = 64) {
    $str = safeString(strip_tags($str));

    $str = str_replace(" ", "-", $str);
    $str = strtolower(preg_replace("/[^a-zA-Z0-9_-]/i", "", $str));
    $str = preg_replace("/[-]+/i", "-", $str);
    if ($length > 0) {
        $str = substr($str, 0, $length);
    }
    $str = trim($str, " -"); // Make sure it doesn't start or end with '-'..

    return $str;
}
} // class PostModel

?>