<?php
/**
 * Class LoaderTest
 *
 * @package Google_Analytics
 */

/**
 * Loader test case.
 */
class LoaderTest extends WP_UnitTestCase {

	public function setUp() {
		$this->plugin = WebKinder\GoogleAnalytics\PluginFactory::create();
	}

	/**
	 * A single example test.
	 */
	function test_should_track_visit() {

		// Logged out should always be tracked
		wp_logout();

		$settings = get_option('wk_google_analytics');
		$settings['track_logged_in'] = 1;
		update_option('wk_google_analytics', $settings);
		$this->assertTrue($this->plugin->loader->should_track_visit());


		$settings = get_option('wk_google_analytics');
		$settings['track_logged_in'] = 0;
		update_option('wk_google_analytics', $settings);
		$this->assertTrue($this->plugin->loader->should_track_visit());

		// Logged in should only be tracked when option is set
		$user_id = $this->factory->user->create();
		wp_set_current_user( $user_id );

		$settings = get_option('wk_google_analytics');
		$settings['track_logged_in'] = 1;
		update_option('wk_google_analytics', $settings);
		$this->assertTrue($this->plugin->loader->should_track_visit());

		$settings = get_option('wk_google_analytics');
		$settings['track_logged_in'] = 0;
		update_option('wk_google_analytics', $settings);
		$this->assertFalse($this->plugin->loader->should_track_visit());
	}
}
