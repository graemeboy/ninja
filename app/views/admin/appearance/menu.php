<?php
    // Extract the settings data, provided, in the settings array, by the controller.
    extract($settings);


    // Include the admin header file.
    include_once(dirname(__FILE__) . '/../includes/header.php');

    // Output the title of this page.
    page_title($page_title, $icon);

    include_once(dirname(__FILE__) . '/../includes/footer.php');
?>