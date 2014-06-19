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
        return json_decode(
            file_get_contents(DATAPATH . 'posts/posts_summary.json'), true);
    } // get posts()

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