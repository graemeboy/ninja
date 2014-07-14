<?php namespace ninja\Widget;

require_once('AbstractWidget.php');
use ninja\Widget\AbstractWidget as Widget;

class SocialPagesWidget extends Widget {
	
	public $facebookUrl;
	public $twitterUrl;
	public $googleplusUrl;

	//public static $settingsModel;

	function __construct ($widgetData) {
		parent::__construct($widgetData);

		//error_log("Widget after parent construct,data: " . http_build_query($widgetData) . "\n", 3, SYSDIR . "/error_log.txt");

		// Set Facebook URL
		if (!empty($widgetData['facebook-url'])) {
			$this->facebookUrl = $widgetData['facebook-url'];
		} else {
			$this->facebookUrl = "";
		}

		// Set Twitter URL
		if (!empty($widgetData['twitter-url'])) {
			$this->twitterUrl = $widgetData['twitter-url'];
		} else  {
			$this->twitterUrl = "";
		}

		// Set Google+ URL
		if (!empty($widgetData['googleplus-url'])) {
			$this->googleplusUrl = $widgetData['googleplus-url'];
		} else {
			$this->googleplusUrl = "";
		}
	}

	/**
	 * Return a string representation of the output (equal to toString()?)
	 * 
	 */
	function getDisplay() {
		$content = "<h3>" . $this->widgetTitle . "</h3>";

		if (!empty($this->facebookUrl) && 
			trim($this->facebookUrl) !== '') {
			$content .= '<span class="social-pages-icon social-page-facebook"><a href="' . $this->facebookUrl . '" ><i class="fa fa-facebook"></i></a></span>';
		}
		if (!empty($this->twitterUrl) && 
				trim($this->twitterUrl) !== '') {
			$content .= '<span class="social-pages-icon social-page-twitter"><a href="' . $this->twitterUrl . '" ><i class="fa fa-twitter"></i></a></span>';
		}
		if (!empty($this->googleplusUrl) && 
			trim($this->googleplusUrl) !== '') {
			$content .= '<span class="social-pages-icon social-page-google"><a href="' . $this->googleplusUrl . '" ><i class="fa fa-google"></i></a></span>';
		}

		return $content;
	}


	function save () {
		$widgetData = array (
			'widget-title' => $this->widgetTitle,
			'active' => $this->widgetActive,
			'facebook-url' => $this->facebookUrl,
			'twitter-url' => $this->twitterUrl,
			'googleplus-url' => $this->googleplusUrl,
			'order' => $this->widgetOrder
		);

		//error_log("Saving data \n", 3, SYSDIR . "/error_log.txt");
		$widgetSettings = static::$settingsModel->getWidgetSettings();
		$widgetSettings['social-pages'] = $widgetData;
		//error_log("Actual save \n", 3, SYSDIR . "/error_log.txt");
		static::$settingsModel->updateWidgetSettings($widgetSettings);
		//error_log("Saved! \n", 3, SYSDIR . "/error_log.txt");
	}
}
 ?>