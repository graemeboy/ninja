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

<?php
    /**
     * function print_post_row
     * Prints out a row of data for the manage post table.
     */
    function print_post_row($post, $slug) {
        $tags = str_replace(',', ', ', $post['tags']);
        echo "<tr>";
        echo "<td><a href=\"/admin/edit-posts/$slug\">{$post['title']}</a></td>";
        echo "<td>$tags</td>";
        echo "<td class=\"edit-post-actions\">";
        print_post_actions($slug);
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
                'icon' => 'fa fa-pencil',
                'title' => 'Edit'
            ),
            'delete-post' => array (
                'icon' => 'fa fa-trash-o',
                'title' => 'Delete'
            ),
        );
        foreach ($edit_pages as $url=>$page) {
            ?>
                <a class="col-sm-3 edit-page-action" href="<?php 
                    echo $url_base . $url ?>/<?php echo $slug ?>">
                        <i class="<?php echo $page['icon'] ?>"></i>
                        <?php echo $page['title'] ?>
                </a>
            <?php
        } // foreach
    } // print_post_actions (string)
?>