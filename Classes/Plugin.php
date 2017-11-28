<?php

namespace WebKinder\GoogleAnalytics;

class Plugin {
  
  public function run() {

    //i18n
    add_action('plugins_loaded', array( $this, 'load_textdomain') );

  	//settings
    include_once 'Settings.php';
    $this->settings = new Settings();
    
    add_action( 'admin_init', array( $this->settings, 'register_settings' ) );
    add_action( 'admin_menu', array( $this->settings, 'settings_page' ) );

    //loader
    include_once 'Loader.php';
    $this->loader = new Loader();
    
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