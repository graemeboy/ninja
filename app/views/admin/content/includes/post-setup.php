<div class="container">
    <div class="col-sm-8">
        <div class="admin-widget">
            <form role="form">
                <div class="form-group">
                    <label for="edit-post-title" class="sr-only">Post Title</label>
                    <input type="text" class="form-control input-lg edit-post-title" placeholder="Enter title here" id="edit-post-title" value="<?php echo $post_title ?>" />

                </div>
                <div class="form-group">
                    <label for="edit-post-tags" class="sr-only">Tags (separate with commas)</label>
                    <input type="text" class="form-control edit-post-title" placeholder="Tags (separate with commas)" id="edit-post-title" value="<?php echo $post_tags ?>" />

                </div>
                <div class="form-group">
                    <label for="edit-post-content" class="sr-only">Post Content</label>

                    <textarea class="form-control edit-post-content" id="edit-post-content" placeholder="Enter content here"><?php echo $post_content ?></textarea>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-4">
        <div>
            <a href="#" class="btn btn-lg btn-success">Publish</a>
        </div>
    </div>
</div>
<script language="javascript">
$(document).ready(function()	{
    $('#edit-post-content').markItUp(myMarkdownSettings);
});
</script>
<h3 class="page-title">Add Content</h3>
