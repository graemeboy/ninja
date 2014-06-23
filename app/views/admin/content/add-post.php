<?php
    include_once(dirname(__FILE__) . '/../includes/header.php');

    page_title($page_title);

/*
 * -----------------
 * Set default post data
 * -----------------
 */
    extract($post_data);
    $tags = implode(', ', $tags);

    // Include the post setup file
    include_once('includes/post-setup.php');
    include_once(dirname(__FILE__) . '/../includes/footer.php');

?>