<?php
    include_once(dirname(__FILE__) . '/../includes/header.php');
    include_once('settings-functions.php');

    page_title('Admin Settings');

    $themes = array (
        'ninja' => 'Ninja',
        'samurai' => 'Samurai',
        'emperor' => 'Emperor',
        'geisha' => 'Geisha',
        'tiger' => 'Tiger',
        'zen' => 'Zen',
        'jade' => 'Jade',
    );
    ?>
     <div id="admin-settings-notification">
        <?php include ( APPPATH . 'views/admin/includes/notification.htm'); ?>
    </div>
    <form id="admin-settings-form" class="form form-horizontal">
    	<?php startFormOption('Admin Theme<br/><small>(Change settings to preview)</small>'); ?>
    	<select id="theme-control" name="theme" class="form-control">
    		<?php
            foreach ($themes as $val=>$title) {
                echo "<option value=\"$val\"";
                if ($admin_theme === $val) {
                    echo 'selected';
                }
                echo ">$title</option>";
            }
            ?>
    	</select>
    	<?php endFormOption(); ?>
    	<input type="submit" class="btn btn-success col-sm-offset-3" value="Save Settings">
    </form>

    <script>
        jQuery(document).ready(function ($) {
            $('#theme-control').change(function () {
                document.body.className = $(this).val();
            });

            $('#admin-settings-form').submit(function (event) {
                event.preventDefault();
                var data = $(this).serialize();
                data += '&action=save_admin_settings';
                postAdminAjax(data, completeAdminSave);
            });

            function completeAdminSave (resp) {
                // Define notifications for successful saving as well as failure.
                var successNotification = "Your admin settings have been successfully saved.";
                var failureNotification = "There was a problem saving the admin settings. Please try again.";
                // Change the notification text.
                changeNotification(resp, '#admin-settings-notification', successNotification, failureNotification);
            }
        });

    </script>