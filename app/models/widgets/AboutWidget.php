<?php namespace ninja\Widget;

require_once('AbstractWidget.php');
use ninja\Widget\AbstractWidget as Widget;

class AboutWidget extends Widget {
	
	public $text;

	public $html;

	function __construct ($widgetData) {
		error_log("Doing about constructor", 3, SYSDIR . "/error_log.txt");
		parent::__construct($widgetData);

		// The following would be good to create as a trait, 
		// as it's the same as in the text widget.
		if (!empty($widgetData['html'])) {
			
			$this->html = $widgetData['html'];

		} else if (!empty($widgetData['text'])) {
			// Otherwise, text will need to be saved to html.
			$this->text = $widgetData['text'];
			$this->html = convert_md_to_html($this->text);
		} else {
			$this->text = '';
			$this->html = '';
		}
	}

	function getDisplay() {
		$content = "<h3>" . $this->widgetTitle . "</h3>";
		$content .= $this->html;
		return $content;
	}

	function save () {
		$widgetData = array (
			'widget-title' => $this->widgetTitle,
			'active' => $this->widgetActive,
			'text' => $this->text,
			'html' => $this->html,
			'order' => $this->widgetOrder
		);

		error_log("Saving for about data \n", 3, SYSDIR . "/error_log.txt");
		$widgetSettings = static::$settingsModel->getWidgetSettings();
		$widgetSettings['about'] = $widgetData;
		static::$settingsModel->updateWidgetSettings($widgetSettings);
	}
}
 ?>