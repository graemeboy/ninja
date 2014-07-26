<?php namespace ninja\Models;

use ninja\Models\Page;

require 'widgets/AboutWidget.php';
require 'widgets/ShareWidget.php';
require 'widgets/SocialPagesWidget.php';
require 'widgets/SocialMetricsWidget.php';
require 'widgets/TextWidget.php';

// Use widgets
use ninja\Widget\AboutWidget;
use ninja\Widget\ShareWidget;
use ninja\Widget\SocialPagesWidget;
use ninja\Widget\SocialMetricsWidget;
use ninja\Widget\TextWidget;
use ninja\Libraries\Sitemap;

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
	static $defaultAppearance = array (
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

	const ADMIN_CONFIG = 'config/admin.json';

	const DEFAULT_SITE_TITLE = 'Example Title';

	const DEFAULT_SITE_SUBTITLE = 'Example subtitle';

	const DEFAULT_LAYOUT = '1';

	const DEFAULT_STYLE = 'amelia';

	/**
	 * The full path to the appearance configuration.
	 *
	 * @access public static
	 * @var string full path to configuration file.
	 */
	static $appearanceConfigPath;

	static $siteConfigPath;

	static $adminConfigPath;

	static $siteSettings;

	function __construct() {
		// Set the path to the appearance configuration file.
		$this->setAppearancePath( APPPATH . self::APPEARANCE_CONFIG );
		$this->setSitePath ( SITE_CONFIG  );
		$this->setAdminPath ( APPPATH . self::ADMIN_CONFIG );
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
		return $this->fillEmptyAppearanceSettings (
			json_decode( file_get_contents( static::$appearanceConfigPath ), true )
		);
	}



	function getLayoutAndStyle() {
		$settings = $this->getAppearanceSettings();

		return array(
			'layout' => $settings['layout'],
			'style' => $settings['style'],
		);
	}

	function getAdminSettings() {
		$jsonData = json_decode( file_get_contents( static::$adminConfigPath ), true );
		if ( !empty( $jsonData ) ) {
			$settings = $jsonData;
		} else {
			// Return an empty arary.
			$settings = array();
		}
		return $this->fillEmptyAdminSettings( $settings );
	}

	/**
	 * Set the primary menu
	 *
	 * Set the menu items in the appearance configurations for the primary menu.
	 *
	 * @param array   $menu items the list of items that will appear in the primary menu
	 */
	function setPrimaryMenu( $menuItems ) {
		$this->setMenu( 'primary', $menuItems );
	}

	/**
	 * Set the secondary menu
	 *
	 * Set the menu items in the appearance configurations for the second menu.
	 *
	 * @param array   $menu items the list of items that will appear in the secondary menu
	 */
	function setSecondaryMenu( $menuItems ) {
		$this->setMenu( 'secondary', $menuItems );
	}

	/**
	 * Set a given menu options.
	 *
	 * @param string  $type      the identifier for the menu
	 * @param array   $menuItems the list of items that will appear in this menu
	 */
	function setMenu( $type, $menuItems ) {
		$pageModel = new Page();
		// Get the current appearance settings.
		$settings = $this->getAppearanceSettings();
		// Set the primary menu variable to the new layout.
		$menu = array();
		foreach ( $menuItems as $slug ) {
			$menu[$slug] = $pageModel->getTitle( $slug );
		}
		$settings[$type . '-menu'] = $menu;
		// Save the new settings.
		$this->saveAppearanceSettings( $settings );
	}

	function addMenuItem( $menu, $slug, $title ) {
		$settings = $this->getAppearanceSettings();
		// Set the primary menu variable to the new layout.
		$settings[$menu . '-menu'][$slug] = $title;
		// Save new settings;
		$this->saveAppearanceSettings( $settings );
	}


	function getPrimaryMenu() {
		return $this->getMenuSettings( 'primary' );
	}

	function getSecondaryMenu() {
		return $this->getMenuSettings( 'secondary' );
	}

	function getMenuSettings( $type ) {
		$settings = $this->getAppearanceSettings();
		if ( !empty( $settings[$type . '-menu'] ) ) {
			return $settings[$type . '-menu'];
		} else {
			return array();
		}
	}

	function getSiteSettings() {
		// If the siteSettings have been accessed before, they will be stored as a static variable.
		if ( !empty( static::$siteSettings ) ) {
			return static::$siteSettings;
		}
		// Otherwise, the site settings must be obtained from the configuration file.
		$jsonData = json_decode( file_get_contents( static::$siteConfigPath ), true );
		$settings = array();
		if ( !empty( $jsonData ) ) {
			$settings = $jsonData;
		}
		// Set the static variable to the site settings, and return them.
		return static::$siteSettings = $this->fillEmptySiteSettings( $settings );
	}

	function getHomepageType() {
		$siteSettings = $this->getSiteSettings();
		if ( !empty( $siteSettings['homepage_content'] ) ) {
			return $siteSettings['homepage_content'];
		} else {
			return "posts";
		}
	}

	function getSocialButtonSettings() {
		$siteSettings = $this->getSiteSettings();
		if ( !empty( $siteSettings['share_post_bottom'] ) &&
			$siteSettings['share_post_bottom'] === 'yes' ) {
			return 'share_post_bottom';
		} else {
			return 'none';
		}
	}

	function getShareTitle() {
		$siteSettings = $this->getSiteSettings();
		if ( !empty( $siteSettings['share_title'] ) ) {
			return $siteSettings['share_title'];
		} else {
			return '';
		}
	}

	function getSiteTitle() {
		$siteSettings = $this->getSiteSettings();
		if ( !empty( $siteSettings['site_title'] ) ) {
			return $siteSettings['site_title'];
		}
		return self::DEFAULT_SITE_TITLE;
	}

	function getSiteSubtitle() {
		$siteSettings = $this->getSiteSettings();
		if ( !empty( $siteSettings['site_subtitle'] ) ) {
			return $siteSettings['site_subtitle'];
		}
		return self::DEFAULT_SITE_SUBTITLE;
	}

	/**
	 * Fill one array with the key value pairs of another,
	 * if that array does not contain the keys of the other.
	 *
	 * Take all of the keys in defaults, check if they exist in array, if
	 * they do not, assign the value of the key in defaults to the array.
	 *
	 * @param unknown $array    the array to be filled
	 * @param unknown $defaults the array containing the default keys and values
	 * @precondition $defaults is not empty
	 * @postcondition $array contains all of the keys in $defaults
	 * @return  none.
	 */
	function fillDefaults( &$array, $defaults ) {
		foreach ( $defaults as $key => $def ) {
			if ( empty( $array[$key] ) ) {
				$array[$key] = $def;
			}
		}
	}

	function fillEmptySiteSettings( $settings ) {
		$defaults = array (
			'site_title' => self::DEFAULT_SITE_TITLE,
			'site_subtitle' => self::DEFAULT_SITE_SUBTITLE,
			'logo_url' => '',
			'copyright' => "&copy; 2014",
			'hometitle' => 'Home',
			'share_title' => '',
			'sitemap_slug' => '',
			'homepage_content' => 'posts'
		);
		$this->fillDefaults( $settings, $defaults );
		return $settings;
	}

	/**
	 * Fill any required admin settings that are currently empty.
	 *
	 * Take in an array of admin settings, and fill in any necessary settings
	 * with defaults if those settings are currently empty.
	 *
	 * @access public
	 * @return  $settings an array of admin settings, with all necessary settings filled.
	 */
	function fillEmptyAdminSettings( $settings ) {
		if ( empty( $settings['theme'] ) ) {
			$settings['theme'] = 'ninja';
		}
		if ( empty( $settings['signin_path'] ) ) {
			$settings['signin_path'] = 'auth/sign-in';
		}
		if ( empty( $settings['admin_path'] ) ) {
			$settings['admin_path'] = 'admin';
		}
		return $settings;
	}

	function getSigninPath() {
		$settings = $this->getAdminSettings();
		return $settings['signin_path'];
	}

	/**
	 * Fill any required appearance settings that are currently empty.
	 *
	 * Take in an array of the current appearance settings, and fill any
	 * required setting that is currently empty with the default value.
	 *
	 * @access public
	 * @return  array $settings an array of current settings with required settings filled in.
	 */
	function fillEmptyAppearanceSettings( $settings ) {
		if ( empty( $settings['layout'] ) ) {
			$settings['layout'] = self::DEFAULT_LAYOUT;
		}
		if ( empty( $settings['style'] ) ) {
			$settings['style'] = self::DEFAULT_STYLE;
		}
		return $settings;
	}

	/**
	 * Return the id of the admin theme currently in use.
	 *
	 * @access  public
	 * @return  the id of the admin theme,
	 */
	function getAdminTheme() {
		$settings = $this->getAdminSettings();
		return $settings['theme'];
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
		foreach ( $widgets as $id=>$settings ) {
			if ( $settings['active'] === 'on' ) {
				$activeWidgets[$id] = $settings;
			}
		}
		uasort($activeWidgets, array($this, "widgetSort"));
		// Return the active widget array, ordered by order.
		return $activeWidgets;
	}

	function widgetSort($a, $b) {
		$a = intval($a['order']);
		$b = intval($b['order']);
		if ($a === $b) {
			return 0;
		} else if ($a > $b) {
			return 1;
		}
		return -1;
	}

	/**
	 * Returns the content of each widget that is active.
	 *
	 * Gets an array of active widget objects, and from them extracts each
	 * widget's content. Takes those strings and concatenates them, returning all content for the sidebar.
	 *
	 * @return string $content the HTML content of the sidebar
	 */
	function getSidebarContent() {
		// Get an array of active widgets.
		$activeWidgets = $this->getActiveWidgets();
		// Define the content string to be returned.
		$content = "";
		// Step through active widgets, and concatenate content.
		foreach ( $activeWidgets as $id=>$settings ) {
			// Init the appropriate widget.
			$widget = $this->initWidget( $id, $settings );
			if ( !empty ( $widget ) ) {
				// Call the widget's print function.
				$content .= "<div class='widget'>" . $widget->getDisplay() . "</div>\n";
			}
		}
		// Return the final content for the sidebar.
		return $content;
	}

	/**
	 * Given a widget ID, instatiate the appropriate widget object.
	 *
	 * @return  $widget the appropriate widget object
	 */
	function initWidget( $id, $widgetSettings ) {
		// Make a map of widget IDs to classes
		//$set = implode(';', $widgetSettings);
		//error_log("About to do switch, id: " . $set . "..", 3, SYSDIR . "/error_log.txt");
		switch ( $id ) {
		case 'about':
			return new AboutWidget( $widgetSettings );
		case 'social-metrics':
			return new SocialMetricsWidget( $widgetSettings );
		case 'social-sharing':
			return new ShareWidget( $widgetSettings );
		case 'social-pages':
			return new SocialPagesWidget( $widgetSettings );
		case 'plain-text':
			return new TextWidget( $widgetSettings );
		}

	}

	/**
	 * Save a widget's settings
	 *
	 * Instantiate an appropriate widget class, and call its save functions,
	 * passing to it the new widget settings.
	 *
	 * @param string  $id         the id relating to the widget class
	 * @param array   $widgetData the new settings for the widget
	 */
	function saveWidget( $id, $widgetData ) {
		error_log( "Got some data: $id \n", 3, SYSDIR . "/error_log.txt" );
		// Instantiate the appropriate widget, given the id.
		$widget = $this->initWidget( $id, $widgetData );
		error_log( "About to save widget \n", 3, SYSDIR . "/error_log.txt" );
		// Save the widget
		$widget->save( $widgetData );
	}

	/**
	 * Get the current settings for widgets
	 *
	 * @return the widget settings.
	 */
	function getWidgetSettings() {
		$settings = $this->getAppearanceSettings();
		if ( !empty( $settings['widgets'] ) ) {
			$widgetSettings = $settings['widgets'];
		} else {
			$widgetSettings = array();
		}
		return $this->fillEmptyWidgetSettings( $widgetSettings );
	}

	function fillEmptyWidgetSettings( $settings ) {
		$widgetIds = array (
			'about', 'social-pages', 'social-sharing',
			'social-metrics', 'plain-text'
		);
		foreach ( $widgetIds as $count=>$id ) {
			if ( empty( $settings[$id] ) ) {
				$settings[$id] = array(
					'widget-title' => '',
					'active' => 'off',
					'order' => $count
				);
			}
		}
		return $settings;
	}



	/**
	 * Update widget settings with new settings, saving them to the appearance config file.
	 *
	 * @param array   $widget settings, an array of new settings.
	 */
	function updateWidgetSettings( $widgetSettings ) {
		// Get the current appearance settings.
		$settings = $this->getAppearanceSettings();
		// Set the widget settings to the new widget settings.
		$settings['widgets'] = $widgetSettings;
		// Save the new widget settings.
		$this->saveAppearanceSettings( $settings );
	}

	/**
	 * Set the full path to the appearance configuration file.
	 *
	 * @param string  $path the full path to appearance config file.
	 */
	function setAppearancePath( $path ) {
		static::$appearanceConfigPath = $path;
	}

	function setSitePath( $path ) {
		static::$siteConfigPath = $path;
	}

	function setAdminPath( $path ) {
		static::$adminConfigPath = $path;
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
		$this->saveAppearanceSettings( $settings );
	}

	/**
	 * Set the stylesheet for the website's frontend.
	 *
	 * Take in an id string for the requested style, and update the appearance configuration file,
	 * setting the style configuration to this new option. This will have the effect of loading
	 * the a stylesheet related to this style id on the website frontend.
	 *
	 * @param string  $style, a string identifying the css file name (does not include CSS extension).
	 * @return  void
	 */
	function setStyle( $style ) {
		// Get the current appearance settings.
		$settings = $this->getAppearanceSettings();
		// Set the layout variable to the new layout.
		$settings['style'] = $style;
		// Save the new settings.
		$this->saveAppearanceSettings( $settings );
	}

	/**
	 * Save the appearance settings.
	 *
	 * Take in a PHP array of settings, convert to appropriate data structure,
	 * and save the settings using the appearance configuration path.
	 *
	 * @param array   $settings a PHP array of the new settings.
	 * @return  void
	 */
	function saveAppearanceSettings( $settings ) {
		// Encode the settings to JSON format.
		$settings = json_encode( $settings );
		// Update the appearance configuration file.
		file_put_contents( static::$appearanceConfigPath, $settings );
	}

	function saveSiteSettings( $settings ) {
		// Encode the settings to JSON format.
		$settings = json_encode( $settings );
		// Update the site settings configuration file.
		file_put_contents( static::$siteConfigPath, $settings );
	}

	function saveAdminSettings( $settings ) {
		// Encode the settings to JSON format.
		$settings = json_encode( $settings );
		// Update the site settings configuration file.
		file_put_contents( static::$adminConfigPath, $settings );
	}


	/**
	 * Return the slug to the sitemap page
	 */
	function getSitemapSlug() {
		$settings = $this->getSiteSettings();
		return $settings['sitemap_slug'];
	}

	/**
	 * Returns the slugs of all posts and pages included in the sitemap
	 *
	 * @return  String array all of the slugs for posts and pages included in sitemap.
	 */
	function getSitemapIncludes() {
		$settings = $this->getSiteSettings();
		// Return the sitemap slugs, or an empty array if not set.
		if ( !empty( $settings['sitemap_includes'] ) ) {
			return $settings['sitemap_includes'];
		} else {
			return array();
		}
	}



	/**
	 * Update the sitemap page from a list of urls.
	 *
	 * Create a new XML file with references to all posts and pages
	 * specified by the user in the sitemap settings page.
	 *
	 * @param array   $data includes the sitemap slug setting, and the urls for references.
	 */
	function updateSitemap( $data ) {
		$sitemapSlug = $data['sitemap_slug'];
		$baseUrl = $_SERVER['SERVER_NAME'];
		$sitemapIncludes = $data['sitemap_includes'];

		// Update the XML file itself.
		$this->createSitemapFile( $baseUrl, $sitemapSlug, $sitemapIncludes );

		// Save the new settings.
		$settings = $this->getSiteSettings();
		$settings['sitemap_slug'] = $sitemapSlug;
		$settings['sitemap_includes'] = $sitemapIncludes;
		$this->saveSiteSettings( $settings );
	}

	/**
	 * Create an XML file for the sitemap.
	 */
	function createSitemapFile( $baseUrl, $sitemapSlug, $sitemapIncludes ) {
		// Use the sitemap library.
		include APPPATH . 'libraries/Sitemap.php';
		$sitemap = new Sitemap( $baseUrl );
		$sitemap->setPath( 'public/xml/' );

		// Add each of the pages and posts saved by the user.
		if ( !empty( $data['sitemap_includes'] ) ) {
			foreach ( $sitemapIncludes as $includeSlug ) {
				$sitemap->addItem( '/' . $includeSlug );
			}
		}

		// Create the sitemap.
		$sitemap->createSitemapIndex( $baseUrl . '/' . $sitemapSlug, 'Today' );
	}
}

?>
