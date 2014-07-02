<?php
    /**
     * The actions for each post, e.g. view, trash, edit.
     */
    $actions = array (
        'spin-post' => array (
            'icon' => 'fa fa-circle-o-notch',
            'title' => 'Spin'
        ),
        'edit-posts' => array (
            'icon' => 'dashicons dashicons-edit',
            'title' => 'Edit'
        ),
        'delete-post' => array (
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
            <th>Tags</th>
            <th>Last Edited</th>
            <th colspan="4" style="text-align:center">Actions</th>
        </thead>
        <tbody>
            <?php
                if (!empty($posts)) {
                    foreach ($posts as $slug=>$post) {
                        print_post_row($post, $slug, $actions);
                    }
                }
            ?>
        </tbody>
    </table>
</div>
    
<?php

    /**
     * function print_post_row
     * Prints out a row of data for the manage post table.
     */
    function print_post_row($post, $slug, $actions) {
        $last_edited = '';
        if (!empty($post['last_edited'])) {
            $last_edited = date('m/d/Y', strtotime($post['last_edited']));
        }
        if (isset($post['tags'])) {
            $tags = implode(',', $post['tags']);
            $tags = str_replace(',', ', ', $tags);
        }
        echo "<tr>";
        echo "<td><a href=\"/admin/edit-posts/$slug\">{$post['title']}</a></td>";
        echo "<td>$tags</td>";
        echo "<td>$last_edited</td>";
        print_content_actions($slug, $actions);
        echo "</tr>";
    } // print_post_row(array, string)


?>