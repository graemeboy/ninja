<div class="container">
    <div class="row">
    <div class="col-sm-8">
        <form id="save-content-form" role="form">
            <input type="hidden" name="slug-original" id="slug-original" value="<?php echo $slug ?>" />
            <?php 
            // Include a title input.
            include('edit-title.php');
            
            // Include a slug input.
            include('edit-slug.php');
            
            // Include a content input.
            include('edit-content.php');
            ?>
        </form>
    </div>
    <div class="col-sm-4">
        <?php include('save-button.php') ?>
    </div>
    <div id="page-notification">
        <?php include ( APPPATH . 'views/admin/includes/notification.htm'); ?>
    </div>
</div>
</div>

<script type="text/javascript">
// Defined whether to automatically set tags based on title.
var setTags = false;
// Set the content type to page, not post.
var contentType = "page";
</script>