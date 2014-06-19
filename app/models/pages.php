<?php

class pageModel
{

    function __construct() {
        
    }

    /**
     * Get all page summaries
     * @return array of pages
     */
    public function get_pages()
    {
       // Return pages as an array.
       return json_decode(file_get_contents(DATAPATH .
                                'pages/pages_summary.json'), true);
    } // get pages()

    /**
     * Add a page to the pages "database"
     */
    public function add_page ($page_data)
    {
        
    } // add_page(array)

    /**
     * Delete a song in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $song_id Id of song
     */
    public function delete_page($page_id)
    {
        
    } // delete_page(int)
} // class pageModel