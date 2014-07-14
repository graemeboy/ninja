<?php namespace ninja\Widget;

require_once('AbstractWidget.php');
use ninja\Widget\AbstractWidget as Widget;

class SocialMetricsWidget extends Widget {
	
	public $metricsNetworks;

	function __construct ($widgetData) {
		parent::__construct($widgetData);

		if (!empty($widgetData['networks'])) {
			$this->metricsNetworks = $widgetData['networks'];
		} else {
			$this->metricsNetworks = array();
		}
	}

	function getDisplay () {
		$content = "<h3>" . $this->widgetTitle . "</h3>";
		foreach ($this->metricsNetworks as $network) {
			switch ($network) {
				case 'facebook':
					$content .= "<div>Facebook stats for page</div>";
					break;
				case 'twitter':
					$content .= "<div>Twitter stats for page</div>";
					break;
			}
		}
		return $content;
	}

	function save () {
		$widgetData = array (
			'widget-title' => $this->widgetTitle,
			'active' => $this->widgetActive,
			'order' => $this->widgetOrder,
			'networks' => $this->metricsNetworks,
		);

		$widgetSettings = static::$settingsModel->getWidgetSettings();
		$widgetSettings['social-metrics'] = $widgetData;
		static::$settingsModel->updateWidgetSettings($widgetSettings);
	}
}
 ?>