<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WebKinder\GoogleAnalytics\PluginFactory;

/*
 * Plugin Name: WEBKINDER Integration for Google Analytics and Google Tag Manager
 * Plugin URI: https://wordpress.org/plugins/wk-google-analytics/
 * Description: Deploy Google Analytics on your website without having to edit code and without tracking your own visits. You can exclude any logged in user from this and enable tracking solely for them.
 * Version: 1.11.5
 * Author: WEBKINDER
 * Author URI: https://www.webkinder.ch/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languages
 * Text Domain: wk-google-analytics
 */

define( 'WK_GA_PLUGIN_FILE', __FILE__ );
define( 'WK_GA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WK_GA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define('WK_GOOGLE_ANALYTICS_DIR', dirname(__FILE__));

$autoload = __DIR__.'/vendor/autoload.php';
if (file_exists($autoload)) {
	require_once $autoload;
}

PluginFactory::create()->run();
