<?php
    $home_navigation = array (
        'icon' => 'glyphicon glyphicon-home',
        'children' => array (
            'dashboard' => array (
                'title' => 'Dashboard',
            ),
            'updates' => array (
                'title' => 'Updates'  
            ),
        )
    );
    $settings_navigation = array (
        'icon' => 'glyphicon glyphicon-cog',
        'children' => array (
            'settings-site' => array (
                'title' => 'Site Settings',
            ),
        )
    );
    // Define menu items for adding posts and pages
    
    $core_navigation_posts = array (
        'icon' => 'glyphicon glyphicon-pencil',
        'children' => array (
            'add-post' => array (
                'title' => 'Add Post',
            ),
            'edit-posts' => array (
                'title' => 'Edit Posts',
                'icon' => 'glyphicon glyphicon-pencil'
            )
        )
    ); 
    $core_navigation_pages = array (
        'icon' => 'glyphicon glyphicon-file',
        'children' => array (
                'add-page' => array (
                'title' => 'Add Page',
                
            ),
                'edit-pages' => array (
                'title' => 'Edit Pages',
                'icon' => 'glyphicon glyphicon-file'
            )
        )
    );
    $core_navigation_media = array (
        'icon' => 'glyphicon glyphicon-picture',
        'children' => array (
                'add-media' => array (
                'title' => 'Add Media',
            ),
                'manage-media' => array (
                'title' => 'Manage Media',
            )
        )
    );
    
    // Print the dashboard link
//    print_menu_item("dashboard", 
//                    "Dashboard", 
//                    "glyphicon glyphicon-home");
//    print_menu_list_divider();
    if (!empty($home_navigation)) {
        print_menu_list("Home", $home_navigation);
    } // if
    // Print the menu to add posts and pages
    if (!empty($core_navigation_posts)) {
        print_menu_list("Posts", $core_navigation_posts);
    } // if
    // Print the menu to manage posts and pages
    if (!empty($core_navigation_pages)) {
        print_menu_list("Pages", $core_navigation_pages);
    } // if
    if (!empty($core_navigation_media)) {
        print_menu_list("Media", $core_navigation_media);
    } // if
    if (!empty($settings_navigation)) {
        print_menu_list("Settings", $settings_navigation);
    } // if
/**
 * function create_menu_list
 * Takes a list of menu items, and creates a menu list from
 * those items. Menu lists are divided by the menu list divider.
 * 
 * @param subtitle, the title of this menu list
 * @param $menu_items, a list of items including href, title, icon
 * @pre $menu_items is not empty
 * @post a menu is printed
 * @post the link of each inner menu is the same as first item
 * @return none
 */
function print_menu_list ($list_title, $menu_items) {  
    $children = $menu_items['children'];
?>
    <div class="nav-menu-list<?php 
        if (array_key_exists(str_replace('/admin/', '', get_current_item()), $children)) {
            $is_current = true;
            echo " inner-menu-active";
        } else {
            $is_current = false;   
        }// else
        ?>">
    <?php       
        // Set the item's icon.
        if (!empty($menu_items['icon'])) {
            $icon = $menu_items['icon'];
        } else {
            $icon = '';
        }
    print_menu_subtitle($list_title, $icon, key($children));
    
    ?><div id='nav-inner-<?php echo strtolower($list_title) ?>' class='nav-inner-menu'<?php if ($is_current === true) { echo " style='display:block'"; } ?>>
    <?php foreach ($children as $href=>$data) {
        // Set the item's title.
        if (!empty($data['title'])) {
            $title = $data['title'];
        } else {
            $title = '';
        } // else
       
        print_menu_item ($href, $title, $icon);
    } // foreach 
    echo '</div>';
    ?> </div> <!-- .menu-list -->
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
    $menu_href_base = '/admin/';
    $href = $menu_href_base . $href;
    $cur_classname = 'nav-item-active'; ?>
    <div class="nav-menu-item<?php
        // add active class if current nav
        if ($href === get_current_item()) {
            echo " $cur_classname";
        } // if ?>">
        <a href="<?php echo $href ?>">
        <?php if ($title !== '') {
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
function print_menu_subtitle ($subtitle, $icon, $first_link) { ?>
    <a href="<?php echo $first_link ?>" data-menu="<?php echo strtolower($subtitle) ?>" class="nav-menu-title"><?php          if ($icon !== '') { ?>
        <span class="admin-menu-icon <?php echo $icon ?>"></span>
    <?php } // if
    echo $subtitle ?></a>
<?php } // print_menu_subtitle (string)

function print_menu_list_divider() {
    echo "<hr>";
}

function get_current_item () {
    // Go two levels deep!
    $url = explode('/', $_SERVER['REQUEST_URI']);
    if (count($url) > 1) {
        return "/{$url[1]}/{$url[2]}";
    } else {
        return $_SERVER['REQUEST_URI'];
    }
} // get_current_item()
?>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
       $('.nav-menu-title').mouseover(function (e) {
        e.preventDefault();
        var menuItems = $(this).attr('data-menu');
        if (!$(this).parent().hasClass('inner-menu-active')) {
            $('.nav-menu-list').removeClass('inner-menu-active');
            $('#nav-inner-' + menuItems).parent().addClass('inner-menu-active');
            $('.nav-inner-menu').slideUp(300);
            $('#nav-inner-' + menuItems).slideDown(300);
        }
        
       });
    });
</script>