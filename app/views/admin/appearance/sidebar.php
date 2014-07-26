<?php
	// Include the admin header file.
    include_once(dirname(__FILE__) . '/../includes/header.php');

    // Output the title of this page.
    page_title($page_title, $icon);

    $val = "";

    function printWidgetHead ($widget_settings, $title, $id) { 
    	if (!empty($widget_settings['active']) && 
    			trim ($widget_settings['active'] === 'on')) {
    		$active = true;
    	} else {
    		$active = false;
    	}
    	?>
    	<div class="panel-heading">
    		<div class="checkbox" style="margin:0">
    			<label class="form-label">
    				<input type="checkbox" name="active" value="on" id="include-<?php echo $id ?>" <?php
    					if ($active) {
    						echo "checked";
    					}
    				?>> <?php echo $title ?>
    			</label>
    		</div>
    	</div>
    	<!-- .panel-heading -->
    <?php }

    function printWidgetTitleOption($widget_settings, $id) {
    	// I do the check for the title within the function for convenience.
    	// Otherwise, it would have to go in the startWidget function.
    	if (!empty($widget_settings['widget-title'])) {
    		$title = $widget_settings['widget-title'];
    	} else {
    		$title = "";
    	}
    	?>
    	<div class="row">
	    	<div class="col-md-8">
		    	<div class="form-group">
					<label class="control-label">Widget Title (Optional)</label>
					<input type="text" name="widget-title" value="<?php echo $title ?>" id="widget-title-<?php echo $id ?>" class="form-control">
				</div>
			</div>
    <?php printOrderOption($widget_settings, $id);
	}

    function printOrderOption($widget_settings, $id) { 
    	if (!empty($widget_settings['order'])) {
    		$order = $widget_settings['order'];
    	} else {
    		$order = '';
    	}
    	$orderOptions = array (
    		1 => 'First',
    		2 => 'Second',
    		3 => 'Third',
    		4 => 'Fourth',
    	);
    	?>
		<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Order</label>
					<select class="form-control" name="order">
						<?php
						foreach ($orderOptions as $val=>$label) {
							echo "<option value='$val'";
							// $val is int, $order is string.
							if ($val == $order) {
								echo 'selected';
							}
							echo ">$label</option>";
						}
						?>
					</select>
				</div>
			</div>
		</div>
    <?php }

    function printWidgetCheckbox($active, $class, $value, $title) { ?>
    	<div class="checkbox">
			<label class="control-label">
				<input type="checkbox" name="<?php echo $class ?>[]" class="<?php echo $class ?>" value="<?php echo $value ?>" <?php
					if ($active === 'yes') {
						echo "checked";
					}
				?>> <?php echo $title ?>
			</label>
		</div>
    <?php }

    function startWidget($widget_settings, $id, $title) {  ?>
		<div class="col-sm-4">
			<form id="widget-form-<?php echo $id ?>">
		    <div class="panel admin-panel">
		    	<?php printWidgetHead ($widget_settings, $title, $id) ?>
		    	<div class="panel-body">
		    		<?php printWidgetTitleOption($widget_settings, $id);
	}

    function endWidget($id) {
    	// Print the save button
    	printWidgetButton($id);
    	// Close the panel body.
    	echo "</div>";
    	// Close the form
    	echo "</form>";
    	// Close the panel itself.
    	echo "</div>";
    	// Close .col-sm-4.
    	echo "</div>";
    }

    function printWidgetTextInput($widget_settings, $id) {
    	if (!empty($widget_settings[$id])) {
    		$val = $widget_settings[$id];
    	} else {
    		$val = "";
    	}
    	?>
    	<input type="text" id="<?php echo $id ?>" name="<?php echo $id ?>" value="<?php echo $val ?>" class="form-control">
    	<?php
    }

    function printNetworksOptions($networks, $widget_settings, $id, $checkboxClass) {
		foreach ($networks as $networkId=>$title) {
			if (!empty($widget_settings['networks'])
				&& in_array($networkId, $widget_settings['networks'])) {
				$active = 'yes';
			} else {
				$active = 'no';
			}
			printWidgetCheckbox($active, $checkboxClass, $networkId, $title);
		}
    }

    /**
     * Print the "save" button for a widget
     * 
     * @param  string $id the widget's id
     */
    function printWidgetButton ($id) { ?>
    	<div>
    		<a href="#" data-id="<?php echo $id ?>" class="widget-save-button btn btn-success" id="save-widget-<?php echo $id ?>">Save</a>
    	</div>
    <?php }

    ?>
    <div id="sidebar-notification">
        <?php include ( APPPATH . 'views/admin/includes/notification.htm'); ?>
    </div>


    <h4 style="margin-bottom:20px;">Check the option near a widget's title for it to appear in the sidebar.</h4>

    <div class="row">
    	<?php 
    	// About Widget
    	$id = 'about';
    	$this_widget_settings = $widget_settings[$id];
    	if (!empty($this_widget_settings['text'])) {
    		$aboutText = $this_widget_settings['text'];
    	} else {
    		$aboutText = "";
    	}
    	startWidget($widget_settings[$id], $id, 'About'); ?>
    		<div class="form-group">
    			<label class="control-label">About Text</label>
    			<textarea id="about-text" name="text" class="form-control widget-textarea"><?php
    				echo $aboutText;
    			?></textarea>
    		</div>
    	<?php
    	endWidget($id);

    	// Social Networking Pages Widget
    	$id = 'social-pages';
    	$this_widget_settings = $widget_settings[$id];
    	startWidget($this_widget_settings, $id, 'Social Networking Pages');
		?>
		<p>Add a link to any pages you want to promote:</p>
		<div class="form-group">
			<label class="control-label">Facebook URL</label>
			<?php printWidgetTextInput($this_widget_settings, 'facebook-url', $val); ?>
		</div>
		<div class="form-group">
			<label class="control-label">Twitter URL</label>
			<?php printWidgetTextInput($this_widget_settings, 'twitter-url', $val); ?>
		</div>
		<div class="form-group">
			<label class="control-label">Google+ URL</label>
			<?php printWidgetTextInput($this_widget_settings, 'googleplus-url', $val); ?>
		</div>
		<?php 
		endWidget($id);

		// Social Sharing Widget
		$id = 'social-sharing';
		$this_widget_settings = $widget_settings[$id];
		startWidget($this_widget_settings, $id, 'Social Network Sharing');
		echo "<p>Sharing buttons to appear:</p>";
		$checkboxClass = "networks";
		// Define all social networks, id=>title
		$socialNetworks = array (
			'facebook' => 'Facebook',
			'twitter' => 'Twitter',
			'googleplus' => 'Google+',
			'linkedin' => 'LinkedIn',
			'stumbleupon' => 'StumbleUpon',
			'reddit' => 'Reddit'
		);
		// Print the checkboxes for all social networks.
		printNetworksOptions($socialNetworks, $this_widget_settings, $id, $checkboxClass);
		endWidget($id);
		?>
	</div>
	<!-- .row -->
	<div class="row">
		<?php
		// Social Metrics Widget
		// $id = 'social-metrics';
		// $this_widget_settings = $widget_settings[$id];
		// startWidget($this_widget_settings, $id, 'Social Metrics');
		// echo "<p>Show how many likes or shares you have for your pages, for these networks:</p>";
		// $checkboxClass = "networks";

		// // Define all social networks that allow easy access to metrics, format: id=>title
		// $socialNetworks = array (
		// 	'facebook' => 'Facebook',
		// 	'twitter' => 'Twitter'
		// );
		// // Print the checkboxes for all social networks.
		// printNetworksOptions($socialNetworks, $this_widget_settings, $id, $checkboxClass);
		// endWidget($id);

		// Plain text widget
		$id = 'plain-text';
		$this_widget_settings = $widget_settings[$id];
		if (!empty($this_widget_settings['text'])) {
    		$text = $this_widget_settings['text'];
    	} else {
    		$text = "";
    	}
		startWidget($this_widget_settings, $id, 'Plain Text');
		?>
		<div class="form-group">
			<label class="control-label">Text</label>
			<textarea id="plain-text-text" name="text" class="form-control widget-textarea"><?php echo $text ?></textarea>
		</div>
		<?php
		endWidget($id);
		?>
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			// Turn the plain text widget textarea into a markdown editor!
			myMarkdownSettings = {
			    nameSpace:          'markdown', // Useful to prevent multi-instances CSS conflict
			    previewParserPath:  '~/sets/markdown/preview.php',
			    onShiftEnter:       {keepDefault:false, openWith:'\n\n'},
			    markupSet: [
			        {name:'Bold"', key:"B", HTMLContent: '<i class="fa fa-bold"></i>', openWith:'**', closeWith:'**'},
			        {name:'Italic', key:"I", openWith:'_', HTMLContent: '<i class="fa fa-italic"></i>', closeWith:'_'},
			        {name:'Bulleted List', HTMLContent: '<i class="fa fa-list"></i>', openWith:'- ' },
			        {name:'Numeric List', HTMLContent: '<i class="fa fa-list-ol"></i>', openWith:function(markItUp) {
			            return markItUp.line+'. ';
			        }},
			        {name:'Picture', key:"P", HTMLContent: '<i class="fa fa-picture-o"></i>', replaceWith:'![[![Alternative text]!]]([![Url:!:http://]!] "[![Title]!]")'},
			        {name:'Link', HTMLContent: '<i class="fa fa-chain"></i>',  key:"L", openWith:'[', closeWith:']([![Url:!:http://]!] "[![Title]!]")', placeHolder:'Your text to link here...' },
			    ]
			}
			$('textarea.widget-textarea').markItUp(myMarkdownSettings);


			/* 
				Action listener for saving widgets.
				Each widget is saved separately, so they need separate listeners.
			*/
			$(".widget-save-button").click(function (event) {
				event.preventDefault();
				var id = $(this).attr("data-id");

				var data = $('#widget-form-' + id).serialize();
				data += '&action=save_widget&widgetId=' + id;
        
        		postAdminAjax(data, completeWidgetSave);
			});

			/**
			 * Callback for once the widget has beensaved
			 * @return void
			 */
			function completeWidgetSave(resp) {
				console.log(resp);
				// Define notifications for successful saving as well as failure.
		        var successNotification = "Your widget settings have been successfully saved.";
		        var failureNotification = "There was a problem saving the widget settings. Please try again.";
		        // Change the notification text.
		        changeNotification(resp, '#sidebar-notification', successNotification, failureNotification);
			} // completeWidgetSave(mixed)

	
		});
	</script>
    <?php

    include_once(dirname(__FILE__) . '/../includes/footer.php');

?>