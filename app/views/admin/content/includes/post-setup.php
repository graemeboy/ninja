<div class="container">
    <div class="col-sm-8">
        <div class="admin-widget">
            <form id="save_post_form" role="form">
                <input type="hidden" name="slug-original" id="slug-original" value="<?php echo $slug ?>" />
                <div class="form-group">
                    <label for="edit-post-title" class="sr-only">Post Title</label>
                    <input type="text" class="form-control input-lg edit-post-title" placeholder="Enter title here" id="edit-post-title" name="title" value="<?php echo $title ?>" />

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="edit-post-tags" class="sr-only control-label">Slug</label>
                            <input type="text" class="form-control edit-post-slug" placeholder="Slug" id="edit-post-slug" name="slug"  value="<?php echo $slug ?>" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="edit-post-tags" class="sr-only control-label">Tags</label>
                            <input type="text" class="form-control edit-post-tags" placeholder="Tags (separate with commas)" id="edit-post-tags" name="tags" value="<?php echo $tags ?>" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit-post-content" class="sr-only">Post Content</label>

                    <textarea class="form-control edit-post-content" id="edit-post-content" name="content" placeholder="Enter content here">
                        <?php echo $content ?>
                    </textarea>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-4">
        <div>
            <a href="#" id="save-post-button" class="btn btn-lg btn-success">
                <?php echo $save_button ?>
            </a>
        </div>
        <div class="page-notification" style="font-size:14px;background:rgba(255,255,255,0.3);margin-top:18px;position:relative;height:35px;display:none;"><div class="post-save-progress" style="width:0;height:35px;background:rgba(0,0,0,0.1)"></div><div style="position:absolute; top: 7px; left: 10px;" class="page-notification-text">Saving post...</div></div>
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
                $('#edit-post-tags').val(keywords.replace(/ /g, ', '));
            } // if
        });
        $('#edit-post-tags').keyup(function () {
            setTags = false;
        });
        $('#edit-post-slug').keyup(function () {
            setSlug = false;
        });
        
        $('#save-post-button').click(function (e) {
           e.preventDefault();
            var contentValid = false;
            if ((contentValid = validatePostContent()) !== true) {
                alert(contentValid);
                return false;
            } // if
            $('.page-notification-text').text('Saving post...');
            $('.page-notification').show();
            var data = $('form#save_post_form').serialize();
            data += '&action=save_post';
            $.ajax({
                url: "/admin/ajax",
                type: "POST",
                data: data,
                complete: function (resp) {
                    $('.page-notification-text').text('Post saved successfully.');
                    console.log(resp.responseText);
                    // If user clicks button again, it saves, not publishes.
                    $('#save-post-button').text('Save Post');
                    $('#slug-original').val($('#edit-post-slug').val());
                    // No more automatic updates for slug
                    setSlug = false;
                },
                progress: function (evt) {
                    if (evt.lengthComputable) {
                        $('.post-save-progress').css('width', parseInt((evt.loaded / evt.total * 100), 10) + "%");
                    } else {
                        console.log("Length not computable.");
                    } // else
                } // progress
            })
        });
        
        /**
         * Boolean validatePostContent
         * Returns true if the post is okay to save, else returns an error message.
         */
        function validatePostContent () {
            if ($('#edit-post-slug').val() === '') {
                return 'The slug must contain at least some characters!';
            }
            return true;
        } // validatePostContent ()
        
        $('#edit-post-content, #edit-post-title, #edit-post-tags, #edit-post-slug').keyup(function () {
           $('.page-notification').fadeOut(); 
        });

        (function addXhrProgressEvent($) {
            var originalXhr = $.ajaxSettings.xhr;
            $.ajaxSetup({
                progress: function () {
                    console.log("standard progress callback");
                },
                xhr: function () {
                    var req = originalXhr(),
                        that = this;
                    if (req) {
                        if (typeof req.addEventListener == "function") {
                            req.addEventListener("progress", function (evt) {
                                that.progress(evt);
                            }, false);
                        }
                    }
                    return req;
                }
            });
        })(jQuery);
    });
</script>
<h3 class="page-title">Add Content</h3>