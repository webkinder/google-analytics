<?php
/**
 * Class SampleTest
 *
 * @package Google_Analytics
 */

/**
 * Sample test case.
 */
class FactoryTest extends WP_UnitTestCase {

	private $_plugin_instance;

	// Tests TODO:
	// Check Output Type
	// Check anonymisation

	public function setUp(): void
	{
		parent::setUp();

		update_option('ga_tracking_code', 'UA-12345678');

		$this->_plugin_instance = WebKinder\GoogleAnalytics\PluginFactory::create();

		/*update_option('ga_tag_manager_id', '');
		update_option('ga_anonymize_ip', '');
		update_option('ga_use_tag_manager', '');*/
	}

	function test_tracking_code_output()
	{
		do_action('wp_enqueue_scripts');
		$this->assertTrue(wp_script_is('wk-analytics-script', 'enqueued'));

	}

	/**
	 * A single example test.
	 */
	function test_creates_only_one_instance() {
		$one = WebKinder\GoogleAnalytics\PluginFactory::create();
		$two = WebKinder\GoogleAnalytics\PluginFactory::create();
		$this->assertEquals( $one, $two );
	}
}
