<?php namespace ninja\Models;

use ninja\Models\Page;

//require 'widgets/AboutWidget.php';
//require 'widgets/ShareWidget.php';
require 'widgets/SocialPagesWidget.php';
//require 'widgets/SocialMetricsWidget.php';
//require 'widgets/TextWidget.php';

// Use widgets
use ninja\Widget\AboutWidget;
use ninja\Widget\ShareWidget;
use ninja\Widget\SocialPagesWidget;
use ninja\Widget\SocialMetricsWidget;
use ninja\Widget\TextWidget;

/*
 * A model for getting and updating all site settings.
 *
 * Includes function to get and update user, appearance, and security settings.
 */
class Settings {

	/**
	 * Default settings for the appearance.
	 *
	 * @access public static
	 * @var array
	 */
	public static $defaultAppearance = array (
		'layout' => 'default',
		'style' => 'cerulean',
	);

	/**
	 * Set the path to the configuration file relative to app path.
	 *
	 * @access const
	 * @var string address of configuration file.
	 */
	const APPEARANCE_CONFIG = 'config/appearance.json';

	/**
	 * The full path to the appearance configuration.
	 *
	 * @access public static
	 * @var string full path to configuration file.
	 */
	public static $appearanceConfigPath;

	function __construct() {
		// Set the path to the appearance configuration file.
		$this->setAppearancePath( APPPATH . self::APPEARANCE_CONFIG );
	}

	/**
	 * Get the appearance settings.
	 *
	 * Request the appearance settings from the appearance file, and return them
	 * in a PHP array.
	 *
	 * @return array of requested settings if exists, else empty array.
	 */
	function getAppearanceSettings() {
		$jsonData = json_decode( file_get_contents( static::$appearanceConfigPath ), true );
		if (!empty($jsonData)) {
			return $jsonData;
		} else {
			// Return an empty arary.
			return array();
		}
	}

	/**
	 * Set the primary menu
	 * 
	 * Set the menu items in the appearance configurations for the primary menu.
	 * @param  array $menu items the list of items that will appear in the primary menu
	 */
	function setPrimaryMenu($menuItems) {
		$this->setMenu('primary', $menuItems);
	}

	/**
	 * Set the secondary menu
	 * 
	 * Set the menu items in the appearance configurations for the second menu.
	 * @param  array $menu items the list of items that will appear in the secondary menu
	 */
	function setSecondaryMenu($menuItems) {
		$this->setMenu('secondary', $menuItems);
	}

	/**
	 * Set a given menu options.
	 * 
	 * @param  string $type the identifier for the menu
	 * @param  array $menuItems the list of items that will appear in this menu
	 */
	function setMenu($type, $menuItems) {
		$pageModel = new Page();
		// Get the current appearance settings.
		$settings = $this->getAppearanceSettings();
		// Set the primary menu variable to the new layout.
		$menu = array();
		foreach ($menuItems as $slug) {
			$menu[$slug] = $pageModel->getTitle($slug);
		}
		$settings[$type . '-menu'] = $menu;
		// Save the new settings.
		$this->saveSettings( $settings );
	}

	function addMenuItem($menu, $slug, $title) {
		$settings = $this->getAppearanceSettings();
		// Set the primary menu variable to the new layout.
		$settings[$menu . '-menu'][$slug] = $title;
		// Save new settings;
		$this->saveSettings($settings);
	}


	function getPrimaryMenu () {
		return $this->getMenuSettings('primary');
	}

	function getSecondaryMenu () {
		return $this->getMenuSettings('secondary');
	}

	function getMenuSettings($type) {
		$settings = $this->getAppearanceSettings();
		if (!empty($settings[$type . '-menu'])) {
			return $settings[$type . '-menu'];
		} else {
			return array();
		}
	}

	/**
	 * Return a list of widgets that are set to active as well as their settings.
	 * 
	 * @return  $activeWidgets a associative list of active widgets ids and settings
	 */
	function getActiveWidgets() {
		$activeWidgets = array();
		// Get the current widget settings
		$widgets = $this->getWidgetSettings();
		// Append the active widgets to the active widget array.
		foreach ($widgets as $id=>$settings) {
			if ($settings['active'] = 'on') {
				$activeWidgets[$id] = $settings;
			}
		}
		// Return the active wdiget array.
		return $activeWidgets;
	}

	/**
	 * Returns the content of each widget that is active.
	 * 
	 * Gets an array of active widget objects, and from them extracts each 
	 * widget's content. Takes those strings and concatenates them, returning all content for the sidebar.
	 * @return string $content the HTML content of the sidebar
	 */
	function getSidebarContent() {
		// Get an array of active widgets.
		$activeWidgets = $this->getActiveWidgets();
		// Define the content string to be returned.
		$content = "";
		// Step through active widgets, and concatenate content.
		foreach ($activeWidgets as $id=>$settings) {
			// Init the appropriate widget.
			$widget = $this->initWidget($id, $settings);
			// Call the widget's print function.
			$content .= $widget->getDisplay() . "\n";
		}
		// Return the final content for the sidebar.
		return $content;
	}

	/**
	 * Given a widget ID, instatiate the appropriate widget object.
	 * 
	 * @return  $widget the appropriate widget object
	 */
	function initWidget($id, $widgetSettings) {
		// Make a map of widget IDs to classes
		$set = implode(';', $widgetSettings);
		error_log("About to do switch, id: " . $set . "..", 3, SYSDIR . "/error_log.txt");
		switch ($id) {
			case 'about':
				return new AboutWidget($widgetSettings);
			case 'social-metrics':
				return new SocialMetricsWidget($widgetSettings);
			case 'social-sharing':
				return new SocialSharingWidget($widgetSettings);
			case 'social-pages':
				return new SocialPagesWidget($widgetSettings);
			case 'plain-text':
				return new TextWidget($widgetSettings);
		}

	}

	/**
	 * Save a widget's settings
	 * 
	 * Instantiate an appropriate widget class, and call its save functions,
	 * passing to it the new widget settings.
	 * @param string $id the id relating to the widget class
	 * @param array $widgetData the new settings for the widget
	 */
	function saveWidget($id, $widgetData) {
		error_log("Got some data: $id \n", 3, SYSDIR . "/error_log.txt");
		// Instantiate the appropriate widget, given the id.
		$widget = $this->initWidget($id, $widgetData);
		error_log("About to save widget \n", 3, SYSDIR . "/error_log.txt");
		// Save the widget
		$widget->save($widgetData);
	}

	/**
	 * Get the current settings for widgets
	 *
	 * @return the widget settings.
	 */
	function getWidgetSettings() {
		$settings = $this->getAppearanceSettings();
		if (!empty($settings['widgets'])) {
			return $settings['widgets'];
		} else {
			return array();
		}
	}

	/**
	 * Update widget settings with new settings, saving them to the appearance config file.
	 * 
	 * @param  array $widget settings, an array of new settings.
	 */
	function updateWidgetSettings($widgetSettings) {
		// Get the current appearance settings.
		$settings = $this->getAppearanceSettings();
		// Set the widget settings to the new widget settings.
		$settings['widgets'] = $widgetSettings;
		// Save the new widget settings.
		$this->saveSettings($settings);
	}

	/**
	 * Set the full path to the appearance configuration file.
	 *
	 * @param string  $path the full path to appearance config file.
	 */
	function setAppearancePath( $path ) {
		static::$appearanceConfigPath = $path;
	}

	/**
	 * Set the layout for the website's frontend.
	 *
	 * Take in an id string of the layout requested, and update the appearance
	 * configuration file, setting the layout configuration to this string.
	 *
	 * @param string  $layout, a string identifying the new layout option.
	 * @return void
	 */
	function setLayout( $layout ) {
		// Get the current appearance settings.
		$settings = $this->getAppearanceSettings();
		// Set the layout variable to the new layout.
		$settings['layout'] = $layout;
		// Save the new settings.
		$this->saveSettings( $settings );
	}

	/**
	 * Set the stylesheet for the website's frontend.
	 *
	 * Take in an id string for the requested style, and update the appearance configuration file,
	 * setting the style configuration to this new option. This will have the effect of loading
	 * the a stylesheet related to this style id on the website frontend.
	 *
	 * @param  string  $style, a string identifying the css file name (does not include CSS extension).
	 * @return  void
	 */
	function setStyle( $style ) {
		// Get the current appearance settings.
		$settings = $this->getAppearanceSettings();
		// Set the layout variable to the new layout.
		$settings['style'] = $style;
		// Save the new settings.
		$this->saveSettings( $settings );
	}

	/**
	 * Save the appearance settings.
	 * 
	 * Take in a PHP array of settings, convert to appropriate data structure,
	 * and save the settings using the appearance configuration path.
	 * @param  array $settings a PHP array of the new settings.
	 * @return  void
	 */
	function saveSettings( $settings ) {
		// Encode the settings to JSON format.
		$settings = json_encode( $settings );
		// Update the appearance configuration file.
		file_put_contents( static::$appearanceConfigPath, $settings );
	}
}

?>
