/**
 * Post an AJAX request to the admin ajax page using jQuery.
 *
 * Send a post request with some data to the admin ajax url, to update
 * some settings on the server. Precondition: data includes 'action' item to
 * identify server action required. Runs callback function with true or false
 * depending on success to request.
 * @param  JSON obj data the data that needs to be posted to the server.
 * @param callback, the callback function that is run after posting.
 */

function postAdminAjax(data, callback) {
    var adminAjaxURL = '/admin/ajax';
    // Send a post request.
    $.ajax({
        url: adminAjaxURL,
        type: "POST",
        data: data
    }).done(function(resp) {
        callback(true);
    }).fail(function(resp) {
        console.log("Failure: ");
        console.log(resp.responseText);
        callback(false);
    });
} // postAdminAjax (JSON obj)

/**
 * Fade the notification out after a given number of seconds.
 * @param string element the identifier for the notification div
 * @param int seconds the number of seconds to delay before hiding
 * @return void
 */

function hideNotification(element, seconds) {
    // Set a timer for seconds * 1000 (convert to miliseconds.)
    setTimeout(function() {
        // Fade the element out using jQuery.
        $(element + ' .notification-wrapper').fadeOut();
    }, seconds * 1000);
} // hideNotification (string, int)

/**
 * Change a given notification element to a given message.
 *
 * If the success parameter is true, update to success notification.
 * @param  bool success to show successNotification, else failureNotification
 * @param  string element the wrapper of the notification element to update
 * @param  stirng successNotification the notification to show if success === true
 * @param  string failureNotification the notification to show if success !== true
 * @return void
 */

function changeNotification(success, element, successNotification, failureNotification) {
    var textToShow;
    if (success === true) {
        textToShow = successNotification;
    } else {
        textToShow = failureNotification;
    } // else
    // Set the new text
    $(element + ' .notification').text(textToShow);
    // Show the element
    $(element + ' .notification-wrapper').fadeIn();
    // Hide the notification after 4 seconds.
    hideNotification(element, 4);
} // changeNotification