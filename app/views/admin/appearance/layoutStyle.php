<?php
    // Extract the settings data, provided, in the settings array, by the controller.
    extract($settings);
    /*  ------------------------------
        Reserved variables:
            - $layout, the layout identifier in appearance configuration.
            - $style, the style identifier in the appearance configuration.
            - $layouts, the set of layouts that are provided with the package.
            - $styles, the set of styles that are provided with the package.
            - $thumbPath, the path to find the thumbnails for styles and layouts
        -------------------------------
     */

    // Include the admin header file.
    include_once(dirname(__FILE__) . '/../includes/header.php');
    
    // Output the title of this page.
    page_title($page_title, 'dashicons dashicons-art');
    
    /**
     * Print an array of options
     * 
     * Take in an array of items, as well as the currently active item,
     * and print a set of links that the user can click on to choose a new setting.
     * @param array $items the array of items to display.
     * @param string $type the type, e.g. style or layout, that is being printed.
     * @param  string $active the currently saved item that should be highlighted to the user.
     * @param  string $thumbpath the path to the thumbnails for previewing styles or layouts.
     */
    function printItems ($items, $type, $active, $thumbPath) {
        $params = array ("type" => $type, "active" => $active, "thumbPath" => $thumbPath);
        array_walk($items, 'printAppearanceItem', $params);
    }

    /**
     * Print an appearance item.
     * 
     * Print an a link that the user can click on to change appearance settings.
     * @param  string $item the id of the item being printed.
     * @param  array $params an array of parameters given in printItems()
     */
    function printAppearanceItem ($item, $a, $params) {
        extract($params);
        $class = "$type appearance-item";
        // Check if this item is the active item.
        if ($item === $active) {
            $class .= " appearance-active";
        }
        // Set url for the .png file so that the user can see a preview of option.
        $previewUrl = "$thumbPath/$item.png";
    ?>
        <a href="#" data-ref="<?php echo $item ?>" class="<?php echo $class ?>">
            <div style="background-image:url('<?php echo $previewUrl ?>')" class="appearance-preview">
            </div>
        </a>
    <?php } // printAppearanceItem (string, array, string)
    ?>

    <div class="container admin-content">
        <p><strong>Tip:</strong> Click on a layout or style to activte it on your site.</p>
        <h3 class="page-subtitle" style="margin:35px 0 0 0;">Layouts - the structure and layout of your content</h3>
        <div id="layout-notification">
            <?php include (dirname(__FILE__) . '/../includes/notification.htm'); ?>
        </div>
            <?php
            // Print the layout options.
            printItems($layouts, 'layout', $layout, $thumbPath);
            ?>
        <div class="clearfix"></div>
        <h3 class="page-subtitle" style="margin:35px 0 0 0;">Styles - the colors and typography of your content</h3>
        <div id="style-notification" style="min-height:50px">
            <?php include (dirname(__FILE__) . '/../includes/notification.htm'); ?>
        </div>
            <?php
                // Print the style options.
                printItems($styles, 'style', $style, $thumbPath);
            ?>
    </div>
    <?php
    include_once(dirname(__FILE__) . '/../includes/footer.php');
?>