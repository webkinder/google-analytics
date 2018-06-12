<?php
/*
Plugin Name: Google Analytics by WebKinder
Plugin URI:  https://wordpress.org/plugins/wk-google-analytics/
Description: Google Analytics for WordPress without tracking your own visits
Version:     1.7.2
Author:      WebKinder
Author URI:  https://www.webkinder.ch
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: wk-google-analytics
*/


define('WK_GOOGLE_ANALYTICS_DIR', dirname(__FILE__));

include_once 'Classes/PluginFactory.php';

// If EnvironmentChecks fails dont run
if (WebKinder\GoogleAnalytics\PluginFactory::create() !== null) {
    WebKinder\GoogleAnalytics\PluginFactory::create()->run();
}
