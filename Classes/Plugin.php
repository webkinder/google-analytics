<?php

namespace WebKinder\GoogleAnalytics;

class Plugin {

  public function run() {

		add_action( 'plugins_loaded', array( $this, 'update_db_check' ) );

    //i18n
    add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

  	//settings
    include_once 'Settings.php';
    $this->settings = new Settings();

    add_action( 'admin_init', array( $this->settings, 'register_settings' ) );
    add_action( 'admin_menu', array( $this->settings, 'settings_page' ) );

    //loader
    include_once 'Loader.php';
    $this->loader = new Loader([
			'settings' => $this->settings
		]);

  	//cookie handling
  	add_action( 'admin_enqueue_scripts', array( $this->loader, 'load_admin_scripts' ) );
    //cookie function
    add_action( 'wp_head', array( $this->loader, 'render_script') );
    //Google Analytics script in <head>
    add_action( 'wp_head', array( $this->loader, 'google_analytics_script') );
    //Google Tag Manager script in header
    add_action( 'wp_head', array( $this->loader, 'google_tag_manager_script'));
    //Google Tag Manager noscript footer
    add_action( 'wp_footer', array( $this->loader, 'google_tag_manager_noscript'));


    //additional links to admin plugin page
    add_filter( 'plugin_row_meta', array( $this, 'additional_admin_information_links' ), 10, 2);
    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'additional_admin_action_links' ) );

  }

	function update_db_check() {
	    if ( !get_site_option( 'wk_ga_db_version' ) || version_compare(get_site_option( 'wk_ga_db_version' ), '1.6.2', '<') ) {
	    	$settings = [
					'tracking_code' => (get_option('ga_tracking_code', null) !== null) ? get_option('ga_tracking_code') : '',
					'anonymize_ip' => (get_option('ga_anonymize_ip', null) !== null) ? get_option('ga_anonymize_ip') : false,
					'track_logged_in' => (get_option('track_logged_in', null) !== null) ? get_option('track_logged_in') : false,
					'use_tag_manager' => (get_option('ga_use_tag_manager', null) !== null) ? get_option('ga_use_tag_manager') : false,
					'tag_manager_id' => (get_option('ga_tag_manager_id', null) !== null) ? get_option('ga_tag_manager_id') : '',
				];
				update_option('wk_google_analytics', $settings);

				delete_option('ga_tracking_code');
				delete_option('ga_anonymize_ip');
				delete_option('track_logged_in');
				delete_option('ga_use_tag_manager');
				delete_option('ga_tag_manager_id');

				update_site_option('wk_ga_db_version', '1.6.2');
	    }
	}


  /**
   * Adds custom links to wk-google-analytics on admin plugin screen on the RIGHT
   *
   * @since 1.6.2
   * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_row_meta
   *
   */
  function additional_admin_information_links( $links, $file ) {

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
	function load_textdomain() {
		load_plugin_textdomain( 'wk-google-analytics', false, plugins_url(plugin_basename(WK_GOOGLE_ANALYTICS_DIR)) . '/lang/' );
	}


}
