<?php

class PostModel
{

    function __construct() {
        
    }

    /**
     * Get all post summaries
     * @return array of posts
     */
    public function get_posts()
    {
       // Return posts as an array.
        include_once (DATAPATH . 'posts/posts_summary.php');
        return $posts_summary;
    } // get posts()
    
    /**
     * function delete_post
     * Takes a post slug and removes it from summary, 
     *  deletes the markdown and html files.
     */
    function delete_post($post_slug) {
        // Delete post from summary
        include_once (DATAPATH . 'posts/posts_summary.php');
        if (!empty($post_summary[$post_slug])) {
            unset($post_summary[$post_slug]);
        } // if
        save_summary($posts_summary);
        // Remove the markdown files
        unlink(DATAPATH . "posts/md/$post_slug.php");
        unline(DATAPATH . "posts/html/$post_slug.php");
    } // delete_post (string)
    
    /**
     * Get data for a post, given a slug
     * @return array of post data
     */
    public function get_post_md($post_slug) {
        include_once (DATAPATH . "posts/md/$post_slug.php");
        return $post_data;
    } // get_post (string)
    
    /**
     * Will append or update post summaries given a new or updated post summary
     * @pre if appending, no existing slug same as one given by post data
     */
    function update_summary ($post_data) {
        $posts_summary = $this->get_posts();
        $posts_summary[$post_data['slug']] = $post_data;
        save_summary($posts_summary);
    } // append_summary (array)
    
    /**
     * Takes an array and saves the data to the post summary file.
     * @param $post_summary, an array of the summaries of each post.
     */
    function save_summary ($posts_summary) {
        $post_string = var_export($posts_summary, true);
        $update = '<?php $posts_summary = ' . $post_string . '; ?>';
        file_put_contents (DATAPATH . 'posts/posts_summary.php', $update);
    } // save_summary (array)
    
    /**
     * function save_markdown
     * Puts post data as an array in to a php file with the same of the slug
     */
    function save_markdown($post_data) {
        $slug = $post_data['slug'];
        $post_string = var_export($post_data, true);
        $data = '<?php $post_data = ' . $post_string . '; ?>';
        file_put_contents (DATAPATH . "posts/md/$slug.php", $data);
    } // save_markdown (array)
    
    /**
     * function save_html
     * Puts post data as an array in to a php file with the same of the slug
     */
    function save_html($post_data) {
        $slug = $post_data['slug'];
        $post_string = var_export($post_data, true);
        $data = '<?php $post_data = ' . $post_string . '; ?>';
        file_put_contents (DATAPATH . "posts/html/$slug.php", $data);
    } // save_html (array)
    
    /**
     * Add a post to the posts "database"
     */
    public function save_post ($post_data)
    {
        /*
         * If an existing post is being edited, then that post ought
         * to be removed before the new data are added.
         */
        if (!empty($post_data['slug-original'] && 
                   trim ($post_data['slug-original']) !== '' )) {
            $this->delete_post($post_data['slug-original']);
        } // if
        
        // Save summary data.
        $summary_data = $post_data;
        unset($summary_data['content']);
        $this->update_summary($summary_data);

        // Save markdown data.
        $md_data = $post_data;
        // Save the date last edited.
        // Save tags as array.
        $md_data['tags'] = explode(',', $md_data['tags']);
        // Trim  each tag.
        foreach ($md_data['tags'] as $index=>$tag) {
            $md_data['tags'][$index] = trim($tag);
        } // foreach
        $post_model->$this->save_markdown($md_data);

        // Save HTML summary data.
        $html_data = $post_data;
        $html_data['content'] = convert_md_to_html($post_data['content']);
        $post_model->$this->save_html($html_data);
    } // save_post(array)
} // class PostModel