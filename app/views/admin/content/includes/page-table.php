<?php
    /**
     * The actions for each page, e.g. view, trash, edit.
     */
    $actions = array (
        'edit-pages' => array (
            'icon' => 'dashicons dashicons-edit',
            'title' => 'Edit'
        ),
        'delete-page' => array (
            'icon' => 'dashicons dashicons-trash',
            'title' => 'Delete'
        ),
        'view-post' => array (
            'icon' => 'dashicons dashicons-visibility',
            'title' => 'View'
        ),
    );

?>
<div>
    <table class="table admin-table">
        <thead>
            <th>Title</th>
            <th>Last Edited</th>
            <th colspan="4" style="text-align:center">Actions</th>
        </thead>
        <tbody>
            <?php
                if (!empty($pages)) {
                    foreach ($pages as $slug=>$page) {
                        // Print out the table row of data and actions.
                        print_page_row($page, $slug, $actions);
                    }
                }
            ?>
        </tbody>
    </table>
</div>
    
<?php

    /**
     * Print out a row of data for the manage pages table.
     */
    function print_page_row($page, $slug, $actions) {
        $last_edited = '';
        if (!empty($page['last_edited'])) {
            $last_edited = date('m/d/Y', strtotime($page['last_edited']));
        }
        echo "<tr>";
        echo "<td><a href=\"/admin/edit-pages/$slug\">{$page['title']}</a></td>";
        echo "<td>$last_edited</td>";
        print_content_actions($slug, $actions);
        echo "</tr>";
    } // print_post_row(array, string)


?>