jQuery(document).ready(function($) {

    // On clicking item, update server settings and current display.
    $('.appearance-item').click(function(e) {
        // Make sure that it's not already active.
        if (!$(this).hasClass('appearance-active')) {
            e.preventDefault();
            // Set the new item to have the active class.
            if ($(this).hasClass('layout')) {
                $('.layout').removeClass('appearance-active');
                $('#layout-update').text('Updating layout...');
                updateLayout($(this).attr('data-ref'));
            } else {
                $('.style').removeClass('appearance-active');
                $('#style-update').text('Updating style...');
                updateStyle($(this).attr('data-ref'));
            } // else
            $(this).addClass('appearance-active');
        } // if
    }); // .click

    /**
     * Update the layout of the site
     *
     * Send a post request to update the layout of the website, and provide
     * a notification for the user on the settings page.
     * @param  string layout the reference id of the chosen layout
     * @return void
     */

    function updateLayout(layout) {
        /**
         * The action that the server must perform
         * @type string
         */
        var action = 'update_layout';
        var data = {
            "action": action,
            "layout": layout
        }
        // Send the request via helper function updateAppearance.
        postAdminAjax(data, notifyLayout);
    } // updateLayout (string)

    /**
     * Update the style of the site
     *
     * Send a post request to update the style of the website, and provide
     * a notification for the user on the settings page.
     * @param  string style the reference id for the chosen style
     * @return void
     */

    function updateStyle(style) {
        /**
         * The action that the server must perform.
         * @type string
         */
        var action = 'update_style';
        var data = {
            "action": action,
            "style": style
        } // data
        // Send the request via helper function updateAppearance.
        postAdminAjax(data, notifyStyle);
    } // updateStyle(style)

    /**
     * Update the style update-notification.
     *
     * @param  bool success returned by the ajax post
     * @return void
     */

    function notifyStyle(success) {
        var successNotification = "Your style was successfully updated.";
        var failureNotification = "There was an error updating the style, please try again.";
        changeNotification(success, '#style-notification',
            successNotification, failureNotification);
    } // notifyStyle(bool)

    /**
     * Update the layout update-notification
     * @param  bool success returned by the post request
     * @return void
     */

    function notifyLayout(success) {
        var successNotification = "Your layout was successfully updated.";
        var failureNotification = "There was an error updating the layout, please try again.";
        changeNotification(success, '#layout-notification',
            successNotification, failureNotification);
    } // notifyLayout (bool)

});