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

		$loader = new \WebKinder\GoogleAnalytics\Loader();

		update_option('track_logged_in', 1);
		$this->assertTrue($loader->should_track_visit());

		update_option('track_logged_in', 0);
		$this->assertTrue($loader->should_track_visit());

		// Logged in should only be tracked when option is set
		$user_id = $this->factory->user->create();
		wp_set_current_user($user_id);

		update_option('track_logged_in', 1);
		$this->assertTrue($loader->should_track_visit());

		update_option('track_logged_in', 0);
		$this->assertFalse($loader->should_track_visit());
	}
}
