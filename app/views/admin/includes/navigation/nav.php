<?php

    // Define menu items for adding posts and pages
    $core_navigation_add = array (
        'add-post' => array (
            'title' => 'Add Post',
            'icon' => 'glyphicon glyphicon-pencil'
        ),
        'add-page' => array (
            'title' => 'Add Page',
            'icon' => 'glyphicon glyphicon-file'
        ),
        'add-media' => array (
            'title' => 'Add Media',
            'icon' => 'glyphicon glyphicon-picture'
        ),
    );
    // Define menu items for managing posts and pages
    $core_navigation_manage = array (
        'manage-posts' => array (
            'title' => 'Edit Posts',
            'icon' => 'glyphicon glyphicon-pencil'
        ),
        'manage-pages' => array (
            'title' => 'Edit Pages',
            'icon' => 'glyphicon glyphicon-file'
        ),
        'manage-media' => array (
            'title' => 'Manage Media',
            'icon' => 'glyphicon glyphicon-picture'
        ),
    );
    
    // Print the dashboard link
    print_menu_item("dashboard", 
                    "Dashboard", 
                    "glyphicon glyphicon-home");

    // Print the menu to add posts and pages
    if (!empty($core_navigation_add)) {
        print_menu_list("Add Content", $core_navigation_add);
    } // if
    // Print the menu to manage posts and pages
    if (!empty($core_navigation_add)) {
        print_menu_list("Manage Content", $core_navigation_manage);
    } // if

/**
 * function create_menu_list
 * Takes a list of menu items, and creates a menu list from
 * those items. Menu lists are divided by <hr> tags.
 * 
 * @param subtitle, the title of this menu list
 * @param $menu_items, a list of items including href, title, icon
 * @pre $menu_items is not empty
 * @post a menu is printed
 * @return none
 */
function print_menu_list ($list_title, $menu_items) {  ?>
    <div class="nav-menu-list">
    <?php  print_menu_subtitle($list_title);
    foreach ($menu_items as $href=>$data) {
        // Set the item's title.
        if (!empty($data['title'])) {
            $title = $data['title'];
        } else {
            $title = '';
        } // else
        // Set the item's icon.
        if (!empty($data['icon'])) {
            $icon = $data['icon'];
        } else {
            $icon = '';
        } // else
        print_menu_item ($href, $title, $icon);
    } // foreach ?>
    <hr> </div> <!-- .menu-list -->
<?php } // create_menu_list (arrary)

/**
 * function print_menu_item
 * 
 * @param $title, the link text
 * @param $icon, the class names of the icon
 * @pre if title and icon ought not the be output, they are empty strings
 * @return none
 */
function print_menu_item ($href, $title, $icon) {
    $cur_nav_item = ($_SERVER['REQUEST_URI']);
    $menu_href_base = '/admin/';
    $href = $menu_href_base . $href;
    $cur_classname = 'nav-item-active'; ?>
    <div class="nav-menu-item<?php
        // add active class if current nav
        if ($href === $cur_nav_item) {
            echo " $cur_classname";
        } // if ?>">
        <a href="<?php echo $href ?>">
        <?php if ($icon !== '') { ?>
            <span class="admin-menu-icon <?php echo $icon ?>"></span>
        <?php } // if 
        if ($title !== '') {
            echo $title;
        } // if  ?>
        </a>
    </div> <!-- .nav-menu-item -->
<?php } // print_menu_item (string, string)

/**
 * function print_menu_subtitle
 * Print a subtitle with subtitle class.
 * 
 * @param $subtitle, the string to appear as subtitle
 * @post a div with subtitle class and subtitle text is output
 * @return none
 */
function print_menu_subtitle ($subtitle) { ?>
    <div class="nav-menu-subtitle"><?php echo $subtitle ?></div>
<?php } // print_menu_subtitle (string)
?>