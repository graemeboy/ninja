<?php
  
    /**
     * function page_title
     * Prints a page title from given string
     * @param $title, the tile of the page_title
     * @post an h2 tag with appropriate class and text is printed
     */
    function page_title ($title) {
    ?>
    <div class="header-title-section">
        <h2 class="page-title"><?php echo $title ?></h2>
    </div>
    <?php
        
    } // page_title (string)

?>