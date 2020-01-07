<?php
/*
Plugin Name: Google Analytics by WebKinder
Plugin URI:  https://wordpress.org/plugins/wk-google-analytics/
Description: Google Analytics for WordPress without tracking your own visits
Version:     1.8.0
Author:      WebKinder
Author URI:  https://www.webkinder.ch
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: wk-google-analytics
*/


define('WK_GOOGLE_ANALYTICS_DIR', dirname(__FILE__));

$autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoload)) {
	require_once($autoload);
}

WebKinder\GoogleAnalytics\PluginFactory::create()->run();
