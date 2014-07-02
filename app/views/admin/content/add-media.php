<?php
    include_once(dirname(__FILE__) . '/../includes/header.php');
    page_title($page_title, 'dashicons dashicons-admin-media');

?>
<style type="text/css">
.fileinput-button {
  position: relative;
  overflow: hidden;
}
.fileinput-button input {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  opacity: 0;
  -ms-filter: 'alpha(opacity=0)';
  font-size: 200px;
  direction: ltr;
  cursor: pointer;
}

/* Fixes for IE < 8 */
@media screen\9 {
  .fileinput-button input {
    filter: alpha(opacity=0);
    font-size: 100%;
    height: 100%;
  }
}

.files {
    background: rgba(0,0,0,0.1);
}
.files .file-item .file-label {
    margin: 5px 0;
}
.files div.file-item {
    border-bottom: 1px solid rgba(0,0,0,0.1);
    padding: 10px;
}

.progress {
    margin-top:15px;
}
</style>
<body>

<div class="container-fluid">
    <!-- The fileinput-button span is used to style the file input field as button -->
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Add files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
</div>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/public/js/jQuery/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="/public/js/jQueryFileUpload/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="/public/js/jQueryFileUpload/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="/public/bootstrap/js/bootstrap.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/public/js/jQueryFileUpload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/public/js/jQueryFileUpload/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="/public/js/jQueryFileUpload/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/public/js/jQueryFileUpload/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="/public/js/jQueryFileUpload/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="/public/js/jQueryFileUpload/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="/public/js/jQueryFileUpload/jquery.fileupload-validate.js"></script>

<script>
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '/admin/ajax',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload').fileupload({
        url: url,
        formData: { 'action': 'upload_media' },
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf|mov|mp3|mp4|bmp|3g2|3gp|3gp2|3gppavi|divx|flv|gif|mpeg4|mpeg|mpg|m4v|wmv|swf|tiff|raw|tif|zip)$/i,
        maxFileSize: 500000000, // 500 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').addClass('file-item').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<div/>').addClass('file-label file-name').text("File to upload: " + file.name));
            if (!index) {
                node.append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend(file.preview)
                .prepend('<div class="file-label">File preview:</div>');
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload Now')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', '/' + file.url);
                //$('.file-name').text('File url: ' + file.url);
                var fullUrl = '<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/' + file.url;
                $(data.context.children().find('.file-name')).html('File url: <a href="'+fullUrl+'">' + fullUrl + '</a>');
                  //  .wrap(link);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index, file) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>

<?php
    include_once(dirname(__FILE__) . '/../includes/footer.php');
?>