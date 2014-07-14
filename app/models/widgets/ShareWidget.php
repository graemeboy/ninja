<?php namespace ninja\Widget;

require_once('AbstractWidget.php');
use ninja\Widget\AbstractWidget as Widget;

class ShareWidget extends Widget {
	
	public $shareNetworks;

	function __construct ($widgetData) {
		parent::__construct($widgetData);
	

		if (!empty($widgetData['networks'])) {
			$this->shareNetworks = $widgetData['networks'];
		} else {
			$this->shareNetworks = array();
		}
	}

	function getDisplay () {
		$content = "<h3>" . $this->widgetTitle . "</h3>";

		if (!empty ($this->shareNetworks)) {
			foreach ($this->shareNetworks as $network) {
				switch($network) {
					case 'facebook':
						$content .= "<div>facebook share button</div>";
						break;
					case 'twitter':
						$content .= "<div>twitter share button</div>";
						break;
					case 'googleplus':
						$content .= "<div>googleplus share button</div>";
						break;
					case 'stumbleupon':
						$content .= "<div>stumbleupon share button</div>";
						break;
					case 'linkedin':
						$content .= "<div>linkedin share button</div>";
						break;
					case 'reddit':
						$content .= "<div>reddit share button</div>";
						break;
				}
			}
		}
		return $content;
	}

	function save () {
		$widgetData = array (
			'widget-title' => $this->widgetTitle,
			'active' => $this->widgetActive,
			'order' => $this->widgetOrder,
			'networks' => $this->shareNetworks,
		);

		$widgetSettings = static::$settingsModel->getWidgetSettings();
		$widgetSettings['social-sharing'] = $widgetData;
		static::$settingsModel->updateWidgetSettings($widgetSettings);
	}
}
 ?>