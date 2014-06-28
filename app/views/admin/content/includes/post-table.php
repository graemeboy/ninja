<div style="margin-left:30px">
    <table class="table admin-table">
        <thead>
            <th>Title</th>
            <th>Tags</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php
                if (!empty($posts)) {
                    foreach ($posts as $slug=>$post) {
                        print_post_row($post, $slug);
                    } // foreach
                } // if
            ?>
        </tbody>
    </table>
</div>
    
<?php
    /**
     * function print_post_row
     * Prints out a row of data for the manage post table.
     */
    function print_post_row($post, $slug) {
        $tags = implode(',', $post['tags']);
        $tags = str_replace(',', ', ', $tags);
        echo "<tr>";
        echo "<td><a href=\"/admin/edit-posts/$slug\">{$post['title']}</a></td>";
        echo "<td>$tags</td>";
        echo "<td class=\"edit-post-actions\" style='width: 340px;'>";
        echo "<div class=\"row\">";
        print_post_actions($slug);
        echo "</div>";
        echo "</td>";
        echo "</tr>";
    } // print_post_row(array, string)

/**
 * function print_post_actions
 * Prints the actions for editing a post, for the manage post table
 */
    function print_post_actions ($slug){
        $url_base = '/admin/';
        $edit_pages = array (
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
        foreach ($edit_pages as $url=>$page) {
            ?>
                <a class="edit-page-action" href="<?php 
                    echo $url_base . $url ?>/<?php echo $slug ?>">
                        <span class="<?php echo $page['icon'] ?>"></span>
                        <?php echo $page['title'] ?>
                </a>
            <?php
        } // foreach
    } // print_post_actions (string)
?>