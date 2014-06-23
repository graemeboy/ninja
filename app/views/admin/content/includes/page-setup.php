<div class="container">
    <div class="col-sm-8">
        <div class="admin-widget">
            <form role="form">
                <div class="form-group">
                    <label for="edit-page-title" class="sr-only">Page Title</label>
                    <input type="text" class="form-control input-lg edit-page-title" placeholder="Enter title here" id="edit-page-title" value="<?php echo $page_title ?>" />

                </div>
                <div class="form-group">
                    <label for="edit-page-content" class="sr-only">Page Content</label>

                    <textarea class="form-control edit-page-content" id="edit-page-content" placeholder="Enter content here"><?php echo $page_content ?></textarea>
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

<h3 class="page-title">Add Content</h3>