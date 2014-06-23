<div class="container">
    <div class="col-sm-8">
        <div class="admin-widget">
            <form role="form">
                <div class="form-group">
                    <label for="edit-post-title" class="sr-only">Post Title</label>
                    <input type="text" class="form-control input-lg edit-post-title" placeholder="Enter title here" id="edit-post-title" value="<?php echo $title ?>" />

                </div>
                <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="edit-post-tags" class="sr-only control-label">Slug</label>
                        <input type="text" class="form-control edit-post-slug" placeholder="Slug" id="edit-post-slug" value="<?php echo $slug ?>" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="edit-post-tags" class="sr-only control-label">Tags</label>
                        <input type="text" class="form-control edit-post-tags" placeholder="Tags (separate with commas)" id="edit-post-tags" value="<?php echo $tags ?>" />
                    </div>
                </div>
                </div>
                <div class="form-group">
                    <label for="edit-post-content" class="sr-only">Post Content</label>

                    <textarea class="form-control edit-post-content" id="edit-post-content" placeholder="Enter content here">
                        <?php echo $content ?>
                    </textarea>
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
    $(document).ready(function () {
        var keywords;
        // Defined whether to automatically set tags based on title.
        var setTags = true;
        // Defined whether to automatically set slug based on title.
        var setSlug = true;
        $('#edit-post-content').markItUp(myMarkdownSettings);
        $('#edit-post-title').keyup(function () {
            keywords = $(this).val().toLowerCase().removeStopWords();
            if (setSlug === true) {
                $('#edit-post-slug').val(encodeURIComponent(
                    keywords.replace(/ /g, '-')));
            } // if
            if (setTags === true) {
                $('#edit-post-tags').val(keywords.replace(/ /g, ','));
            } // if
        });
        $('#edit-post-tags').keyup(function () {
            setTags = false; 
        });
        $('#edit-post-slug').keyup(function () {
            setSlug = false; 
        });
    });
</script>
<h3 class="page-title">Add Content</h3>
