<div class="container">
    <div class="col-sm-8">
        <div class="admin-widget">
            <form role="form">
                <div class="form-group">
                    <label for="edit-page-title" class="sr-only">page Title</label>
                    <input type="text" class="form-control input-lg edit-page-title" placeholder="Enter title here" id="edit-page-title" value="<?php echo $title ?>" />

                </div>
                <div class="form-group">
                    <label for="edit-page-tags" class="sr-only">Tags (separate with commas)</label>
                    <input type="text" class="form-control edit-page-title" placeholder="Tags (separate with commas)" id="edit-page-title" value="<?php echo $tags ?>" />

                </div>
                <div class="form-group">
                    <label for="edit-page-content" class="sr-only">page Content</label>

                    <textarea class="form-control edit-page-content" id="edit-page-content" placeholder="Enter content here"><?php echo $content ?></textarea>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-4">
        <div>
            <a href="#" class="btn btn-lg btn-success"><?php echo $save_button ?></a>
        </div>
    </div>
</div>
<script language="javascript">
$(document).ready(function()	{
    $('#edit-page-content').markItUp(myMarkdownSettings);
});
</script>
<h3 class="page-title">Add Content</h3>