<?php
    // Extract the settings data, provided, in the settings array, by the controller.
    extract($settings);


    // Include the admin header file.
    include_once(dirname(__FILE__) . '/../includes/header.php');

    // Output the title of this page.
    page_title($page_title, $icon);
    ?>
    

    <?php
    	if (!empty($pages)) { ?>
    		<p>Check which pages you wish to appear in your primary and secondary menus.</p>
    		<p>Primary menus generally appear in navbars near the top of the page, while secondary menus appear in the footer.</p>

    		<div class="row">
    			<div class="col-sm-5">
					<h3>Primary Menu</h3>
					
					<?php printMenuOptions($pages, 'primary', $primary_menu) ?>
					<a href="#" id="updatePrimary" class="btn btn-success">Save Primary Menu</a>
				</div>
				<div class="col-sm-5">
					<h3>Secondary Menu</h3>
					<?php printMenuOptions($pages, 'secondary', $secondary_menu); ?>
					<a href="#" id="updateSecondary" class="btn btn-success">Save Secondary Menu</a>
				</div>
			</div>
			<?php
    	} else {
    		echo "<p>You can select pages to show in these menus once you've created some.<br/>" .
    			"Navigate to the Add Page page by using the admin menu to the left.</p>";
    	}

    	/**
    	 * Print out checkbox inputs for each of the possible menu items.
    	 * 
    	 * Given a menu type, primary or secondary, print out clickable options 
    	 * for the user to choose which menu items should appear in that menu.
    	 * @param  array $pages an associative array of all possible pages for the menu
    	 * @param  string $menu the identifier for the menu, primary or secondary
    	 */
    	function printMenuOptions ($pages, $menu, $curMenu) {
			foreach ($pages as $page) { ?>
				<div class="checkbox menu-check-wrap">
				    <label class="menu-check-label">
				      <input type="checkbox" <?php
				      if (!empty($curMenu[$page['slug']])) {
				      	echo 'checked="checked"';
				      }
				      ?> class="<?php echo $menu ?>-menu-check" value="<?php echo $page['slug'] ?>"> <?php echo $page['title'] ?>
				    </label>
				 </div>
			<?php }
    	}
    ?>
    <div id="menu-notification">
        <?php include ( APPPATH . 'views/admin/includes/notification.htm'); ?>
    </div>

    <script type="text/javascript">
    	jQuery(document).ready(function ($) {
    		$('#updatePrimary').click(function (event) {
    			event.preventDefault();
    			updateMenu('primary');
    		}); // .click

    		$('#updateSecondary').click(function (event) {
    			event.preventDefault();
		        updateMenu('secondary');
    		}); // .click

    		function updateMenu (menu) {
    			var data = "action=set_" + menu + "_menu&items=";
		        $('.' + menu + '-menu-check').each(function () {
		        	if ($(this).is(":checked")) {
		        		data += $(this).val() + ",";
		        	} // if
		        }); // .each
		        // Remove the last comma
		        data = data.replace(/(^,)/g);
				postAdminAjax(data, completeMenuSave);
    		} // updateMenu (string)

    		function completeMenuSave(resp) {
				// Define notifications for successful saving as well as failure.
        		var successNotification = "Your menu was successfully updated.";
        		var failureNotification = "There was a problem updating the menu. Please try again.";
        		// Change the notification text.
        		changeNotification(resp, '#menu-notification', successNotification, failureNotification);
    		} // completeMenuSave ()
    	});
    </script>
    <?php


    include_once(dirname(__FILE__) . '/../includes/footer.php');
?>