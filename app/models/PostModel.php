<?php

require_once('ContentModel.php');

class PostModel extends ContentModel
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
        // Call the parent constructor
        parent::__construct();
        
        $this->setMarkdownPath(DATAPATH . self::MARKDOWN_PATH);
        $this->setHtmlPath(DATAPATH . self::HTML_PATH);
        $this->setSummaryPath(DATAPATH . self::SUMMARY_PATH);
        
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
        return $this->getAllContent($this->summaryPath);
    } // get posts()
    
    /**
     * function getPostSummary
     * @param string slug
     * @return the summary of a post from the given slug
     */
    public function getPostSummary($slug) {
        $posts = $this->getAllPosts();
        return $posts[$slug];
    } // getPostSummary(string)
    
    /**
     * function isPost
     * Returns true if a post is contained in the array of posts stored in summary.
     * @param string $slug
     * @return boolean isPost
     */
    public function isPost($slug) {
        // Get all post summaries (the smallest sets of data about posts)
        $posts = $this->getAllPosts();
        // Return boolean if a post exists with this slug.
        return (!empty($posts[$slug]));        
    } // isPost(string)
    
    /**
     * function getPostMarkdown
     * Gets the mardown data for a post, given a slug
     * @pre HTML post content exists with slug in appropriate directory
     * @return valid markdown for the post, based on html.
     */
    public function getPostMarkdown ($slug) {
        //return $this->getContentMarkdown($slug);
    } // get_post (string)
    
    /**
     * Returns the HTML content for a given post slug
     * @param slug, string
     * @return html string for post with given slug
     */
    public function getPostHtml ($slug) {
        return $this->getContentHtml($slug);
    } // getPostHtml (string)
    
    /* ------------------
     *  Mutator Methods
     * -----------------
     */
    
    /**
     * Will append all post summaries given a new post summary.
     * @pre no existing post should have the same slug. 
     *  Otherwise it is overwritten.
     */
    function appendSummary ($postData) {
        // Save tags as an array
        $tags = explode(',', $postData['tags']);
        if (!empty($tags)) {
            foreach ($tags as $index=>$tag) {
                $tags[$index] = trim($tag);
            } // foreach
            $postData['tags'] = $tags;
        } // if
        // Get all of the posts as assoc array
        $posts = $this->getAllPosts();
        // Set the array with item slug to the given post data
        $posts[$postData['slug']] = $postData;
        // Now save these data to the summary file
        $this->saveDataToFile($posts, $this->$summaryPage);
    } // appendSummary (array)
    
    
    /**
     * function deletePost
     * Takes a post slug and removes it from summary, 
     *  deletes the markdown and html files.
     */
    function deletePost($slug) {
        /*
         *  Delete post from summary
         */
        $posts = $this->getAllPosts();
        if (!empty($posts[$slug])) {
            unset($posts[$slug]);
        } // if
        $this->saveDataToFile($posts, $this->$summaryPage);
        // Remove the html file
        $this->deletePostHTML($slug);
        $this->deletePostMarkdown($slug);
    } // deletePost (string)
    
    /**
     * Unlinks the html page for a given post.
     */
    function deletePostHTML ($slug) {
        // HTML data is stored in an html file.
        $filename = $this->$htmlPath . "$slug.html";
        if (file_exists($filename)) {
            unlink($filename);
        } // if
    } // deletePostHTML

    /**
     * Unlinks the html page for a given post.
     */
    function deletePostMarkdown ($slug) {
        // HTML data is stored in an html file.
        $filename = $this->$markdownPath . "$slug.md";
        if (file_exists($filename)) {
            unlink($filename);
        } // if
    } // deletePostMarkdown
    
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
        file_put_contents ($this->$htmlPath . $slug.php, $data);
    } // save_html (array)
    
    
    
    /**
     * Add a post to the posts "database"
     */
    public function savePost ($postData){
        $slug = $postData['slug'];
        
        /*
         * Set data for summary and HTML
         */ 
        $markdown = $postData['content'];
        $htmlContent = convert_md_to_html($markdown);
        unset($postData['content']); // remove any content
        
        // Remove any existing post with the original slug
        if (!empty($postData['slug-original'])) {
            // The old slug must be deleted.
            if ($postData['slug-original'] !== $postData['slug']) {
                $this->deletePost($postData['slug-original']);
            } // if
            unset($postData['slug-original']);
        } // if
        // Save summary data.
        $this->appendSummary($postData);
        /*
         * Save HTML and Markdown content.
         */
        $this->saveHTMLToFile($htmlContent, $slug);
        $this->saveMarkdownToFile($markdown, $slug);
    } // savePost(array)
   
    
    /**
     * function removeOriginalPost
     * Posts can be edited and slugs changed. The edit post page
     * will send a "slug-original" value of the post's slug before
     * the change, which will be deleted.
     * @para $postData, includes param ['slug-original']
     */

    
    /**
     * Takes a PHP array and saves it as an appropriate data structure 
     * to the file.
     * @param $data, a php array
     */
    function saveDataToFile ($data, $filename) {
        // Save contents of php arrry to the summary page as json.
        file_put_contents ($filename, json_encode($data));
    } // save_summary (array)
    
    /**
     * function saveHTMLToFile
     * @param $htmlContent, string of html
     * @param $slug, string
     * @post an html file is created containing the given html
     */
    function saveHTMLToFile($htmlContent, $slug) {
        file_put_contents ($this->$htmlPath . "$slug.html", $htmlContent);
    } // saveHTMLToFile (string, string)
    
    /**
     * function saveMarkdownToFile
     * @param $markdown, string of markdown text
     * @param $slug, string
     * @post a markdown file is created containing the given html
     */
    function saveMarkdownToFile($markdown, $slug) {
        file_put_contents ($this->$markdownPath . "$slug.md", $markdown);
    } // saveMarkdownToFile (string, string)
    
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