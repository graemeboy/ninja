<?php
/**
 * ContentModel
 * 
 */
abstract class ContentModel
{
    /* -----------------
     *  Fields
     * -----------------
     */
    protected $summaryPath;
    protected $htmlPath;
    protected $markdownPath;
    
    /* -----------------
     *  Constructors
     * -----------------
     */
    function __construct () {
        
//        $this->setHtmlPath();
//        $this->setMarkdownPath();
//        $this->setSummaryPath();
        
    } // __construct()
    
    
    /* -----------------
     *  Observer Methods
     * -----------------
     */
    
    /**
     * function getAllContent
     * Return a PHP array of all the items of some content type.
     *  If no data are available, returns an empty PHP array.
     * @param string $summaryPath
     * @return PHP array of the summaries of each item of content
     */
    function getAllContent ($summaryPath) {
        
        if (file_exists($summaryPath)) {
            $json_data = file_get_contents($summaryPath);
            // Return posts as a php array.
            if (!empty($json_data)) {
                return json_decode($json_data, true);    
            }
        }
        // There are no posts yet, return an empty array.
         return array();
        
    } // getAllContent ()
    
    /**
     * function getContentMarkdown
     * Given a slug for a post or page, return the markdown content
     * @param string slug, the slug identifying the file needed
     * @pre the file exists
     * @return the markdown content for the post or page, if the file exists
     */
    function getContentMarkdown($slug) {
        $markdownFile = $this->$markdownPath . "$slug.md";
        if (file_exists($markdownFile)) {
            return file_get_contents($markdownFile);
        } // if   
    } // getContentMarkdown (string)
    
    function getContentHtml($slug) {
        $htmlFile = $this->htmlPath . "$slug.html";
        if (file_exists($htmlFile)) {
            return file_get_contents($htmlFile);
        } // if
    }
    
    function getMarkdownPath() {
        return $this->$markdownPath;
    }
    
    function getHtmlPath() {
        return $this->$HtmlPath;
    }
    
    function getSummaryPath() {
        return $this->$summaryPath;
    }
    
    
    /* ---------------
     *  Mutator Methods
     * ---------------
     */
    
    function setHtmlPath ($htmlPath) {
        $this->htmlPath = $htmlPath;
    }
    
    function setMarkdownPath($markdownPath) {
        $this->markdownPath = $markdownPath;
    }
    
    function setSummaryPath($summaryPath) {
        $this->summaryPath = $summaryPath;
    }
    
    
} // class ContentModel
?>