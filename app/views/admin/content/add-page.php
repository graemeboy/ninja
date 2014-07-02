<?php
    include_once(dirname(__FILE__) . '/../includes/header.php');

    page_title($page_title, 'dashicons dashicons-welcome-add-page');

    extract($page_data);


    // Include the post setup file
    include_once('includes/page-setup.php');

    include_once(dirname(__FILE__) . '/../includes/footer.php');

?>