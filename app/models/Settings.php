<?php namespace ninja\Models;
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
