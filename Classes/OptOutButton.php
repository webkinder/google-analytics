<?php
namespace WebKinder\GoogleAnalytics;

class OptOutButton {
	public static function init() {
		add_shortcode( 'google_analytics_opt_out', 'WebKinder\GoogleAnalytics\OptOutButton::render');
	}

	public static function render() {
		wp_enqueue_script('cookie-js');
		wp_enqueue_script('wk-ga-admin-js');
		return '<div id="track-device"></div>';
	}
}
