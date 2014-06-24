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
        $post_path = DATAPATH . "posts/md/$post_slug.json";
        if (file_exists($post_path)) {
            return (json_decode(file_get_contents($post_path), true));
        } // if
    } // get_post (string)
    
    /**
     * Will append a summary of a post to the post summary data
     * @pre no existing slug same as one given by post data
     */
    function append_summary ($post_data) {
        $posts_summary = $this->get_posts();
        $posts_summary[$post_data['slug']] = $post_data;
        $post_string = var_export($posts_summary, true);
        $update = '$posts_summary = ' . $post_string . ';';
        file_put_contents (DATAPATH . 'posts/posts_summary.php', $update);
    } // append_summary (array)
    
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