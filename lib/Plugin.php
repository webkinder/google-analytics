<?php

namespace WebKinder\GoogleAnalytics;

class Plugin
{

	/**
	 * @var Loader
	 */
	public $loader;

	/**
	 * @var Settings
	 */
	public $settings;

	public function run()
	{

		//i18n
		add_action('plugins_loaded', array($this, 'load_textdomain'));

		//settings
		$this->settings = new Settings();

		add_action('admin_init', array($this->settings, 'register_settings'));
		add_action('admin_menu', array($this->settings, 'settings_page'));

		//loader
		$this->loader = new Loader();

		//cookie handling
		add_action('admin_enqueue_scripts', array($this->loader, 'load_admin_styles'));
		add_action('wp_enqueue_scripts', array($this->loader, 'register_public_scripts'));
		add_action('admin_enqueue_scripts', array($this->loader, 'register_public_scripts'));

		add_action('wp_enqueue_scripts', array($this->loader, 'register_ga_scripts'));

		//Google Tag Manager noscript footer
		add_action('wp_body_open', function () {
			$this->loader->google_tag_manager_noscript();
		});

		add_action('wp_footer', function () {
			//Google Tag Manager noscript footer (if wp_body_open is not used in theme yet)
			if (did_action('wp_body_open') === 0) {
				$this->loader->google_tag_manager_noscript();
			}
		});

		//additional links to admin plugin page
		add_filter('plugin_row_meta', array($this, 'additional_admin_information_links'), 10, 2);
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'additional_admin_action_links'));

		// add privacy policy content
		add_action('admin_init', [$this, 'register_privacy_policy_content']);
	}

	/**
	 * Adds custom links to wk-google-analytics on admin plugin screen on the RIGHT
	 *
	 * @since 1.6.2
	 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_row_meta
	 *
	 */
	function additional_admin_information_links($links, $file)
	{

		if (dirname($file) == basename(WK_GOOGLE_ANALYTICS_DIR)) {
			$links[] = '<a href="http://bit.ly/2jnKboN">' . __('Donate to this plugin', 'wk-google-analytics') . '</a>';
		}

		return $links;
	}

	/**
	 * Sets up the translations in /lang directory
	 *
	 * @since 1.0
	 *
	 */
	function load_textdomain()
	{
		load_plugin_textdomain('wk-google-analytics', false, basename(plugin_dir_path(__DIR__)) . '/languages');
	}

	/**
	 * Get the text for GA
	 *
	 * @return string
	 */
	static function get_ga_policy_text()
	{
		ob_start();
		include WK_GOOGLE_ANALYTICS_DIR . '/content/privacy_policy.php';
		$content = ob_get_clean();
		return $content;
	}

	/**
	 * Add privacy policy content
	 *
	 * @return void
	 */
	public function register_privacy_policy_content()
	{
		wp_add_privacy_policy_content(__('WEBKINDER Google Analytics', 'wk-google-analytics'), self::get_ga_policy_text());
	}
}
