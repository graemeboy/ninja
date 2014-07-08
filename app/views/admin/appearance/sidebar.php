<?php
	// Include the admin header file.
    include_once(dirname(__FILE__) . '/../includes/header.php');

    // Output the title of this page.
    page_title($page_title, $icon);

    $val = "";

    function printWidgetHead ($title, $id) { ?>
    	<div class="panel-heading">
    		<div class="checkbox" style="margin:0">
    			<label class="form-label">
    				<input type="checkbox" name="include-<?php echo $id ?>" value="on" id="include-<?php echo $id ?>"> <?php echo $title ?>
    			</label>
    		</div>
    	</div>
    	<!-- .panel-heading -->
    <?php }

    function printWidgetTitleOption($id) { ?>
    	<div class="form-group">
			<label class="control-label">Widget Title (Optional)</label>
			<input type="text" id="widget-title-<?php echo $id ?>" class="form-control">
		</div>
    <?php }

    function printWidgetCheckbox($class, $value, $title) { ?>
    	<div class="checkbox">
			<label class="control-label">
				<input type="checkbox" name="<?php echo $class ?>" class="<?php echo $class ?>" value="<?php echo $value ?>"> <?php echo $title ?>
			</label>
		</div>
    <?php }

    function startWidget($id, $title) { ?>
		<div class="col-sm-4">
			<form id="widget-form-<?php echo $id ?>">
		    <div class="panel admin-panel">
		    	<?php printWidgetHead ($title, $id) ?>
		    	<div class="panel-body">
		    		<?php printWidgetTitleOption($id);
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

    function printWidgetTextInput($id, $val) {
    	?>
    	<input type="text" id="<?php echo $id ?>" name="<?php echo $id ?>" value="<?php echo $val ?>" class="form-control">
    	<?php
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
    	startWidget('about', 'About'); ?>
    		<div class="form-group">
    			<label class="control-label">About Text</label>
    			<textarea id="about-text" value="" name="about-text" class="form-control widget-textarea"></textarea>
    		</div>
    	<?php 
    	endWidget('about');

    	// Social Networking Pages Widget
    	startWidget('social-pages', 'Social Networking Pages');
		?>
		<p>Add a link to any pages you want to promote:</p>
		<div class="form-group">
			<label class="control-label">Facebook URL</label>
			<?php printWidgetTextInput('social-pages-facebook', $val); ?>
		</div>
		<div class="form-group">
			<label class="control-label">Twitter URL</label>
			<?php printWidgetTextInput('social-pages-twitter', $val); ?>
		</div>
		<div class="form-group">
			<label class="control-label">Google+ URL</label>
			<?php printWidgetTextInput('social-pages-googleplus', $val); ?>
		</div>
		<?php 
		endWidget('social-pages');

		// Social Sharing Widget
		startWidget('social-sharing', 'Social Network Sharing');
		echo "<p>Sharing buttons to appear:</p>";
		$checkboxClass = "social-sharing";
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
		foreach ($socialNetworks as $id=>$title) {
			printWidgetCheckbox($checkboxClass, $id, $title);
		}
		endWidget('social-sharing');
		?>
	</div>
	<!-- .row -->
	<div class="row">
		<?php
		// Social Metrics Widget
		startWidget('plain-text', 'Social Metrics');
		echo "<p>Show how many likes or shares you have for your pages, for these networks:</p>";
		$checkboxClass = "social-metrics";

		// Define all social networks that allow easy access to metrics, format: id=>title
		$socialNetworks = array (
			'facebook' => 'Facebook',
			'twitter' => 'Twitter'
		);
		// Print the checkboxes for all social networks.
		foreach ($socialNetworks as $id=>$title) {
			printWidgetCheckbox($checkboxClass, $id, $title);
		}
		endWidget('social-metric', 'Social Metrics');
		startWidget('plain-text', 'Plain Text');
		?>
		<div class="form-group">
			<label class="control-label">Text</label>
			<textarea id="plain-text-text" name="plain-text-text" value="" class="form-control widget-textarea"></textarea>
		</div>
		<?php
		endWidget('plain-text');
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