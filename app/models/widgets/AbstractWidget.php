<?php namespace ninja\Widget;

require_once(APPPATH . 'models/Settings.php');
use ninja\Models\Settings;

abstract class AbstractWidget {

	/*
		Fields
	 */
	public static $settingsModel;

	public $widgetTitle;

	public $widgetActive;

	public $widgetOrder;

	/*
		Constructors
	 */
	function __construct( $widgetData ) {
		error_log("Inside parent constructor \n", 3, SYSDIR . "/error_log.txt");
		if (!empty($widgetData['widget-title'])) {
			$this->widgetTitle = $widgetData['widget-title'];
		} else {
			$this->widgetTitle = "";
		}
		if (!empty($widgetData['active'])) {
			$this->widgetActive = $widgetData['active'];
		} else {
			$this->widgetActive = "off";
		}

		if (!empty($widgetData['order'])) {
			$this->widgetOrder = $widgetData['order'];
		} else {
			$this->widgetOrder = 5;
		}
		static::$settingsModel = new Settings();
	}

	/*
		Abstract functions
	 */
	
	/**
	 * Save the current widget object to the appearance configuration file.
	 */
	abstract function save();

	/**
	 * Return the current widget's display
	 */
	abstract function getDisplay();

	/*
		Mutator Methods
	 */
}
