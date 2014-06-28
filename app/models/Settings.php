<?php
/*
 * SettingsModel
 * Provides functions to get and set user settings.
 */
class SettingsModel {

	// Define default settings, in case the user wants to restore.
	public static $defaultSettings = array (
		'theme' => 'default',
		'style' => 'cerulean',
	);

	function __construct () {


	}

	/**
	 * function SetTheme
	 * Updates the settings for theme.
	 * @param   $themeName, a string identifying the theme's view directory.
	 */
	function setTheme($themeName) {


	}

	/**
	 * function setStyle
	 * Updates the style (typography, colors) for the theme.
	 * @param  $styleName, a string identifying the css file name (without extension)
	 */
	function setStyle($styleName) {


	}

	function restoreDefaults() {


	}



}

?>