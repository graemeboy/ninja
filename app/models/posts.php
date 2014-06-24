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
        $post_string = var_export($posts_summary, true);
        $update = '<?php $posts_summary = ' . $post_string . '; ?>';
        file_put_contents (DATAPATH . 'posts/posts_summary.php', $update);
    } // append_summary (array)
    
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
    public function add_post ($post_data)
    {
        
    } // add_post(array)

    /**
     * Delete a song in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $song_id Id of song
     */
    public function delete_post($post_id)
    {
        
    } // delete_post(int)
} // class PostModel