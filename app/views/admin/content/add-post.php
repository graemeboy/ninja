<?php
    include_once(dirname(__FILE__) . '/../includes/header.php');

    page_title('Add a Post');

/*
 * -----------------
 * Set default post data
 * -----------------
 */

    // Post Title
    $post_title = '';
    // Post Content
    $post_content = '';
    // Post Tags
    $post_tags = '';

    // Include the post setup file
    include_once('includes/post-setup.php');
    include_once(dirname(__FILE__) . '/../includes/footer.php');

?>