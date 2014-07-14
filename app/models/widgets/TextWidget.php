<?php namespace ninja\Widget;

require_once('AbstractWidget.php');
use ninja\Widget\AbstractWidget as Widget;

class TextWidget extends Widget {
	
	public $text;

	public $html;

	function __construct ($widgetData) {
		parent::__construct($widgetData);

		// When the widget is initialized from the frontend, html will be given.
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

		$widgetSettings = static::$settingsModel->getWidgetSettings();
		$widgetSettings['plain-text'] = $widgetData;
		static::$settingsModel->updateWidgetSettings($widgetSettings);
	}
}
 ?>