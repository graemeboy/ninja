<?php
    include_once(dirname(__FILE__) . '/../includes/header.php');
    include_once('settings-functions.php');

    page_title('Site Settings');

    extract($site_settings);


	?>    
    <div id="site-notification">
        <?php include ( APPPATH . 'views/admin/includes/notification.htm'); ?>
    </div>
    <form id="site-settings-form" class="form form-horizontal">
    	<?php startFormOption('Site Title'); ?>
			<input type="text" id="site-settings-site-title" name="site_title" value="<?php echo $site_title ?>" class="form-control">
		<?php endFormOption(); ?>
        <?php startFormOption('Site Subtitle'); ?>
            <input type="text" id="site-settings-site-subtitle" name="site_subtitle" value="<?php echo $site_subtitle ?>" class="form-control">
        <?php endFormOption(); ?>
    	<?php startFormOption('Logo (URL)'); ?>
				<input type="text" name="logo_url" value="<?php echo $logo_url ?>" class="form-control">
		<?php endFormOption(); ?>
        <?php startFormOption('Homepage Meta Title'); ?>
            <input type="text" id="site-settings-site-hometitle" name="hometitle" value="<?php echo $hometitle ?>" class="form-control">
        <?php endFormOption(); ?>
        <?php startFormOption('Copyright Notice'); ?>
            <input type="text" id="site-settings-site-copyright" name="copyright" value="<?php echo htmlentities($copyright) ?>" class="form-control">
        <?php endFormOption(); ?>
    	<input type="submit" id="site-settings-btn" class="btn btn-success col-sm-offset-2" value="Save Settings">
    </form>

    <script>
    	jQuery(document).ready(function () {
    		$('#site-settings-form').submit(function (event) {
    			event.preventDefault();
    			var data = $(this).serialize();
                data += '&action=save_site_settings';
                postAdminAjax(data, completeSiteSave);
                // Anticipating that the save will work as expected, update the site title.
                $('.site-title').html( $('#site-settings-site-title').val() );
            });

            /**
             * Callback for once the widget has beensaved
             * @return void
             */
            function completeSiteSave(resp) {
                // Define notifications for successful saving as well as failure.
                var successNotification = "Your site settings have been successfully saved.";
                var failureNotification = "There was a problem saving the site settings. Please try again.";
                // Change the notification text.
                changeNotification(resp, '#site-notification', successNotification, failureNotification);
            } // completeWidgetSave(mixed)
    	});
    </script>

    <?php

    include_once(dirname(__FILE__) . '/../includes/footer.php');
?>