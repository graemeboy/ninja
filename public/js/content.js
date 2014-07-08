/**
 * Admin JavaScript utilities relating to the content model,
 * from which posts and pages extend.
 */

// Start jQuery, no-conflit.
$(document).ready(function() {
    // The keywords that are used in slug and tags.
    var keywords;
    // Defined whether to automatically set slug based on title.
    var setSlug = true;
    // Transform the edit content textarea into a markdown editor.
    $('textarea#edit-content').markItUp(myMarkdownSettings);

    // When tags are edited, turn off auto set tags.
    $('#edit-tags').blur(function() {
        setTags = false;
        // Always perform the search if the edit-tags field is blurred.
        performSearch();
    });
    // When slug is edited, turn off auto set slug.
    $('#edit-slug').keyup(function() {
        setSlug = false;
    });

    // Automatically set tags and slugs.
    $('#edit-title').keyup(debounce(function() {
        keywords = $('#edit-title').val().toLowerCase().removeStopWords();
        if (setSlug === true) {
            $('#edit-slug').val(encodeURIComponent(
                keywords.replace(/ /g, '-')));
        } // if
        if (setTags === true) {
            $('#edit-tags').val(keywords.replace(/ /g, ', '));
            performSearch();
        } // if
    }, 350));

    /**
     * Limit the number of times that the API can be requested through debouncing.
     *
     * Use an interval to specify when the API might be used, specifically after the
     * user has finnished typing for a while.
     * @param  function func the function to be debounced.
     * @param  int interval the number of miliseconds delayed for calling.
     * @return the return value of func
     */

    function debounce(func, interval) {
        var lastCall = -1;
        return function() {
            clearTimeout(lastCall);
            var args = arguments;
            lastCall = setTimeout(function() {
                func.apply(this, args);
            }, interval);
        };
    } // debounce (function, integer)

    /**
     * Callback for the completion of the post request to save a post.
     *
     * @param  mixed resp the server's response to the request.
     * @return void
     */

    function completeContentSave(resp) {
        // Define notifications for successful saving as well as failure.
        var successNotification = "Your post was saved successfully.";
        var failureNotification = "There was a problem saving the post. Please try again.";
        // Change the notification text.
        changeNotification(resp, '#page-notification', successNotification, failureNotification);
        // If user clicks button again, it saves, not publishes.
        $('#save-content-button').text('Save');
        $('#slug-original').val($('#edit-slug').val());
        // No more automatic updates for slug
        setSlug = false;
    } // completeContentSave(mixed)

    $('#edit-content, #edit-title, #edit-tags, #edit-slug').keyup(function() {
        $('.page-notification').fadeOut();
    });

    /**
     * Boolean validateContent
     * Returns true if the content is okay to save, else returns an error message.
     */

    function validateContent() {
        if ($('#edit-post-slug').val() === '') {
            return 'The slug must contain at least some characters!';
        } // if
        return true;
    } // validateContent ()

    $('#save-content-button').click(function(e) {
        e.preventDefault();
        var contentValid = false;
        if ((contentValid = validateContent()) !== true) {
            alert(contentValid);
            return false;
        } // if
        var data = $('form#save-content-form').serialize();
        data += '&action=save&contentType=' + contentType;
        postAdminAjax(data, completeContentSave);
    });
});