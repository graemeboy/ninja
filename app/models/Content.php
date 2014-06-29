<?php
/**
 * ContentModel
 *
 * The two models that are indended to extend this class are Post and Page.
 * There are minor differences between posts and pages in this CMS:
 *     1. The data and content for each are stored in different locations.
 *     2. They tend to appear in different views, pages in menus, and posts in archives, etc.
 * This warrants the creation of separate models for the content types. However, they both
 * have similar traits - save, delete, and a request for all tokens of its type.
 * This abstract class defines the common functions, while extended classes are intended to set
 * different directory paths for data, and provide a minimal number of idiosyncratic functions.
 */
abstract class ContentModel {

    /* -----------------
     *  Fields
     * -----------------
     */

    // The path for the summary data for each post or page.
    protected $summaryPath;
    // The path in which HTML content is stored for quick access on the frontend.
    protected $htmlPath;
    // The path in which markdown content is store for access when editing in the admin area.
    protected $markdownPath;

    /* -----------------
     *  Constructors
     * -----------------
     */

    function __construct() {

    } // __construct()

    /* -----------------
     *  Observers
     * -----------------
     */

    /**
     * function getAll
     * Return a PHP array of all the items of the current object's content type.
     *
     * @param string  $summaryPath, the directory for content summaries.
     * @return PHP array of the summaries of each item of content. Empty array if none exist.
     */
    function getAll() {
        if ( file_exists( $this->summaryPath ) ) {
            $json_data = file_get_contents( $this->summaryPath );
            // Return data as a php array if there are any.
            if ( !empty( $json_data ) ) {
                return json_decode( $json_data, true );
            }
        }
        // There are no posts or pages yet, return an empty array.
        return array();
    }

    /**
     * function getSummary
     * Returns a PHP array of the summary of a single item of content, e.g. post.
     *
     * @param string  $slug, the unique identifier for content.
     * @return the summary of content from the given slug.
     */
    public function getSummary( $slug ) {
        $content = $this->getAll();
        return $content[$slug];
    }

    /**
     * function getMarkdown
     * Given a slug for a post or page, return the markdown content.
     *
     * @param string  slug, the slug identifying the file needed.
     * @return the markdown content for the post or page, if the file exists.
     */
    function getMarkdown( $slug ) {
        $markdownFile = $this->markdownPath . "$slug.md";
        if ( file_exists( $markdownFile ) ) {
            return file_get_contents( $markdownFile );
        }
    }

    /**
     * function getHtml
     * Returns the HTML content for an item of content.
     *
     * @param string  $slug, the unique identifier for the content.
     * @return string, the HTML text for the content.
     */
    function getHtml( $slug ) {
        $htmlFile = $this->htmlPath . "$slug.html";
        if ( file_exists( $htmlFile ) ) {
            return file_get_contents( $htmlFile );
        }
    }

    /**
     * function getMarkDownPath
     *
     * @return string, the path to the markdown directory
     */
    function getMarkdownPath() {
        return $this->markdownPath;
    }

    /**
     * function getHtmlPath
     *
     * @return string, the path to the HTML directory
     */
    function getHtmlPath() {
        return $this->HtmlPath;
    }

    /**
     * function getSummaryPath
     *
     * @return string, the path to the summary directory
     */
    function getSummaryPath() {
        return $this->summaryPath;
    }


    /* ------------
     *  Mutators
     * ------------
     */

    /**
     * function setHTMLPath
     *
     * @param string $htmlPath, the path to the HTML content
     */
    function setHtmlPath( $htmlPath ) {
        $this->htmlPath = $htmlPath;
    }

    /**
     * function setMarkdownPath
     *
     * @param string $markdownPath, the path to the markdown content
     */
    function setMarkdownPath( $markdownPath ) {
        $this->markdownPath = $markdownPath;
    }

    /**
     * function setSummaryPath
     *
     * @param string $summaryPath, the path to the content summaries
     */
    function setSummaryPath( $summaryPath ) {
        $this->summaryPath = $summaryPath;
    }

    /**
     * function appendSummary
     *
     * @param array $postData, contains the summary data for the new content.
     * @post the summary data for the content is appended to the data structure for posts.
     * @return void
     */
    function appendSummary( $postData ) {
        // Separate string of tags into array, using ',' as delineator.
        $tags = explode( ',', $postData['tags'] );
        // Remove any whitespace around each tag.
        $postData['tags'] = trimTags($tags);
        // Get all of the posts as assoc array
        $posts = $this->getAll();
        // Set the array with item slug to the given post data
        $posts[$postData['slug']] = $postData;
        // Now save these data to the summary file
        $this->saveDataToFile( $posts, $this->summaryPath );
    }


    /**
     * function save
     * Saves the post content to the appropriate structures and directories.
     * @param array $postData, all data for the post.
     */
    function save( $contentData ) {
        $slug = $contentData['slug'];
        // Extract markdown content.
        $markdown = $contentData['content'];
        // Convert markdown content to HTML
        $htmlContent = convert_md_to_html( $markdown );
        // Remove content before saving summary.
        unset( $contentData['content'] );
        // Remove any existing post with the original slug
        if ( !empty( $contentData['slug-original'] ) ) {
            // The old slug must be deleted, if it's not the same as the new one.
            if ( $contentData['slug-original'] !== $contentData['slug'] ) {
                $this->delete( $contentData['slug-original'] );
            } // if
            // No need to save the original slug in the content summary.
            unset( $contentData['slug-original'] );
        } // if
        // Save summary data.
        $this->appendSummary( $contentData );
        // Save HTML
        $this->saveHTMLToFile( $htmlContent, $slug );
        // Save Markdown
        $this->saveMarkdownToFile( $markdown, $slug );
    }

    /**
     * Takes a PHP array and saves it as an appropriate data structure
     * to the file.
     *
     * @param unknown $data, a php array
     */
    function saveDataToFile( $data, $filename ) {
        // Save contents of php arrry to the summary page as json.
        file_put_contents( $filename, json_encode( $data ) );
    } // save_summary (array)

    /**
     * function saveHTMLToFile
     *
     * @param unknown $htmlContent, string of html
     * @param unknown $slug,        string
     * @post an html file is created containing the given html
     */
    function saveHTMLToFile( $htmlContent, $slug ) {
        file_put_contents( $this->htmlPath . "$slug.html", $htmlContent );
    } // saveHTMLToFile (string, string)

    /**
     * function saveMarkdownToFile
     *
     * @param unknown $markdown, string of markdown text
     * @param unknown $slug,     string
     * @post a markdown file is created containing the given html
     */
    function saveMarkdownToFile( $markdown, $slug ) {
        file_put_contents( $this->markdownPath . "$slug.md", $markdown );
    } // saveMarkdownToFile (string, string)


    /**
     * function delete
     * Removes all traces of the content.
     *
     * @param string  $slug the unique identifier of the content.
     * @return void
     */
    function delete( $slug ) {
        $content = $this->getAll();
        if ( !empty( $content[$slug] ) ) {
            unset( $content[$slug] );
        } // if
        $this->saveDataToFile( $content, $this->summaryPath );
        // Remove the html file
        $this->deleteHtml( $slug );
        $this->deleteMarkdown( $slug );
    }

    /**
     * function deleteHtml
     * Unlinks the html page for a given content.
     *
     * @param string  $slug the unique identifier of the content.
     */
    function deleteHtml( $slug ) {
        // HTML data is stored in an html file.
        $filename = $this->$htmlPath . "$slug.html";
        if ( file_exists( $filename ) ) {
            unlink( $filename );
        } // if
    }

    /**
     * function deletMarkdown
     * Unlinks the markdown file for a given content.
     *
     * @param string  $slug the unique identifier of the content.
     */
    function deleteMarkdown( $slug ) {
        // HTML data is stored in an html file.
        $filename = $this->markdownPath . "$slug.md";
        if ( file_exists( $filename ) ) {
            unlink( $filename );
        } // if
    }

} // class ContentModel
?>
