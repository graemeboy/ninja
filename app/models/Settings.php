<?php namespace ninja\Models;
/*
 * A model for getting and updating all site settings.
 *
 * Includes function to get and update user, appearance, and security settings.
 */
class SettingsModel {

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
		static::$appearanceConfigPath = APPPATH . APPEARANCE_CONFIG;
	}

	/**
	 * Get the appearance settings.
	 *
	 * Request the appearance settings from the appearance file, and return them
	 * in a PHP array.
	 *
	 * @return array of requested settings.
	 */
	function getAppearanceSettings() {
		$json_settings = file_get_contents( static::$appearanceConfigPath );
	}

	/**
	 * Set the layout for the website's frontend.
	 *
	 * Take in an id string of the layout requested, and update the appearance
	 * configuration file, setting the layout configuration to this string.
	 *
	 * @param string  $layout, a string identifying the new layout option.
	 */
	function setLayout( $layout ) {


	}

	/**
	 * Set the stylesheet for the website's frontend.
	 *
	 * Take in an id string for the requested style, and update the appearance configuration file,
	 * setting the style configuration to this new option. This will have the effect of loading
	 * the a stylesheet related to this style id on the website frontend.
	 *
	 * @param string  $style, a string identifying the css file name (does not include CSS extension).
	 * @return void
	 */
	function setStyle( $style ) {


	}

	function restoreDefaults() {


	}



}

?>
