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

	/**
	 * A single example test.
	 */
	function test_creates_only_one_instance() {
		$one = WebKinder\GoogleAnalytics\PluginFactory::create();
		$this->assertNull( $one );
	}
}
