<?php
/*
Plugin Name: Google Analytics by WebKinder
Plugin URI:  https://wordpress.org/plugins/wk-google-analytics/
Description: Google Analytics for WordPress without tracking your own visits
Version:     1.6.2
Author:      WebKinder
Author URI:  https://www.webkinder.ch
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /lang
Text Domain: wk-google-analytics
*/

class wk_ga {
  
  public function __construct() {

    //lifecycle hooks
    register_activation_hook( __FILE__, array( $this, 'activation' ) );
    register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );

    //i18n
    add_action('plugins_loaded', array( $this, 'load_textdomain') );

  	//settings
  	add_action( 'admin_init', array( $this, 'register_settings' ) );
  	add_action( 'admin_menu', array( $this, 'settings_page' ) );

  	//cookie handling
  	add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) );

    //cookie function
    add_action( 'wp_head', array( $this, 'render_script') );

    //Google Analytics script in <head>
    add_action( 'wp_head', array( $this, 'google_analytics_script') );

    //Google Tag Manager script in header
    add_action( 'wp_head', array( $this, 'google_tag_manager_script'));

    //Google Tag Manager noscript footer
    add_action( 'wp_footer', array( $this, 'google_tag_manager_noscript'));

    //additional links to admin plugin page
    add_filter( 'plugin_row_meta', array( $this, 'additional_admin_information_links' ), 10, 2);
    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'additional_admin_action_links' ) );

  }

  /**
   * Adds custom links to wk-google-analytics on admin plugin screen on the RIGHT
   *
   * @since 1.6.2
   * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_row_meta
   *
   */
  function additional_admin_information_links( $links, $file ) {

    $base = plugin_basename(__FILE__);

    if ($file == $base) {
      $links[] = '<a href="http://bit.ly/2jnKboN">' . __('Donate to this plugin', 'wk-ga') . '</a>';
    }

    return $links;

  }

  /**
   * Adds custom links to wk-google-analytics on admin plugin screen on the LEFT
   *
   * @since 1.6.2
   * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
   *
   */
  function additional_admin_action_links( $links ) {

    return array_merge( array('settings' => '<a href="' . admin_url( '/options-general.php?page=google_analytics' ) . '">' . __( 'Settings', 'wk-google-analytics' ) . '</a>'),  $links );

  }

  /**
   * Returns whether the current request should be tracked or not
   *
   * @since 1.2
   * @return boolean
   *
   */
  function should_track_visit() {
    return ( !is_user_logged_in() || get_option('track_logged_in') );
  }

  /**
   * Returns if the cookie is present
   *
   * @since 1.2
   * @return boolean
   *
   */
  function render_script() {
    ?>
    <script>
    function hasWKGoogleAnalyticsCookie() {
      return (new RegExp('wp_wk_ga_untrack_' + document.location.hostname) ).test(document.cookie);
    }
    </script>
    <?php
  }

  /**
   * Outputs the Google Tag Manager script tag if necessary
   *
   * @since 1.2
   *
   */
  function google_tag_manager_script() {
    if( $this->should_track_visit() && get_option('ga_use_tag_manager') ) {
      $TAG_MANAGER_ID   = get_option('ga_tag_manager_id');
      ?>
      <script>
        if( !hasWKGoogleAnalyticsCookie() ) {
          //Google Tag Manager
          (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','<?php echo $TAG_MANAGER_ID; ?>');
        }
      </script>
      <?php
    }
  }

  /**
   * Outputs the Google Tag Manager noscript tag if necessary
   *
   * @since 1.6
   *
   */
  function google_tag_manager_noscript() {
    if( $this->should_track_visit() && get_option('ga_use_tag_manager') ) {
      $TAG_MANAGER_ID   = get_option('ga_tag_manager_id');
      ?>
      <noscript><iframe src="//www.googletagmanager.com/ns.html?id=<?php echo $TAG_MANAGER_ID; ?>"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

      <?php
    }
  }

  /**
   * Outputs the Google Analytics script if necessary
   *
   * @since 1.2
   * @see https://developers.google.com/analytics/devguides/collection/analyticsjs/ip-anonymization
   *
   */
  function google_analytics_script() {
    if( $this->should_track_visit() && ! get_option('ga_use_tag_manager') ) {
      $GA_TRACKING_CODE = get_option('ga_tracking_code');
      $ANONYMIZE_IP     = get_option('ga_anonymize_ip');
      ?>

      <script>
      if( !hasWKGoogleAnalyticsCookie() ) {
        //Google Analytics
  			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    		ga('create', '<?php echo $GA_TRACKING_CODE; ?>', 'auto');

          <?php
            if( $ANONYMIZE_IP ) :
          ?>
            ga('set', 'anonymizeIp', true);
          <?php
            endif;
          ?>

        ga('send', 'pageview');
      }
      </script>
      
        <?php
    }
  }

  /**
   * Sets up the translations in /lang directory
   *
   * @since 1.0
   *
   */
	function load_textdomain() {
		load_plugin_textdomain( 'wk-google-analytics', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
	}

  /**
   * Placeholder function for plugin activation
   *
   * @since 1.0
   *
   */
  function activation() {
    
    if (version_compare(PHP_VERSION, '5.3', '<')) {
      deactivate_plugins( plugin_basename(__FILE__) );
      wp_die(__('This Plugin needs PHP version 5.3 to run.', 'wk-google-analytics'));
    }
    
    if (version_compare(get_bloginfo('version'), '4.8', '<')) {
      deactivate_plugins( plugin_basename(__FILE__) );
      wp_die(__('This Plugin needs WordPress version 4.8 to run.', 'wk-google-analytics'));
    }
    
  }

  /**
   * Placeholder function for plugin deactivation
   *
   * @since 1.0
   *
   */
  function deactivation() {

  }

  /**
   * Registers all the settings separately
   *
   * @since 1.0
   * @see https://codex.wordpress.org/Function_Reference/register_setting
   * @see https://codex.wordpress.org/Function_Reference/add_settings_section
   * @see https://codex.wordpress.org/Function_Reference/add_settings_field
   *
   */
  function register_settings() {

    add_settings_section(
      'google_analytics',
      __('Google Analytics', 'wk-ga'),
      array( $this, 'settings_header'),
      'google_analytics'
    );

    /**
     * @since 1.0
     */
    register_setting(
      'wk_ga_google_analytics',
      'ga_tracking_code'
    );

    add_settings_field(
      'ga_tracking_code',
      __('GA Tracking Code', 'wk-ga'),
      array( $this, 'tracking_code_field' ),
      'google_analytics',
      'google_analytics'
    );

    /**
     * @since 1.0
     */
    register_setting(
      'wk_ga_google_analytics',
      'track_logged_in'
    );

    add_settings_field(
      'ga_anonymize_ip',
      __('Anonymize IP"s', 'wk-google-analytics'),
      array( $this, 'anonymize_ip_field' ),
      'google_analytics',
      'google_analytics'
    );

    /**
     * @since 1.1
     */
    register_setting(
      'wk_ga_google_analytics',
      'ga_anonymize_ip'
    );

    add_settings_field(
      'track_logged_in',
      __('Track logged in users', 'wk-google-analytics'),
      array( $this, 'track_logged_in_field' ),
      'google_analytics',
      'google_analytics'
    );

    /**
     * @since 1.2
     */
    register_setting(
      'wk_ga_google_analytics',
      'ga_use_tag_manager'
    );

    add_settings_field(
      'ga_use_tag_manager',
      __('Use Google Tag Manager instead', 'wk-google-analytics'),
      array( $this, 'use_tag_manager_field' ),
      'google_analytics',
      'google_analytics'
    );

    /**
     * @since 1.2
     */
    register_setting(
      'wk_ga_google_analytics',
      'ga_tag_manager_id'
    );

    add_settings_field(
      'ga_tag_manager_id',
      __('Google Tag Manager ID', 'wk-google-analytics'),
      array( $this, 'tag_manager_id_field' ),
      'google_analytics',
      'google_analytics'
    );

	}

  /**
   * Renders the header text for the settings page
   *
   * @since 1.6.2
   *
   */
  function settings_header() {
    ?>

    <p><?php _e('Enter your Google Analytics tracking code below. You can also use Google Tag Manager instead by checking the relevant setting.', 'wk-google-analytics'); ?></p>

    <?php
  }

  /**
   * Renders text input for the Google Analytics tracking code
   *
   * @since 1.6.2
   *
   */
  function tracking_code_field() {

    $field = 'ga_tracking_code';
    $value = esc_attr( get_option( $field ) );

    ?>

    <input type="text" name="<?php echo $field; ?>" placeholder="UA-XXXXXXXX-X" value="<?php echo $value; ?>" />

    <?php
  }

  /**
   * Renders checkbox for the anonymize IP's option
   *
   * @since 1.6.2
   *
   */
  function anonymize_ip_field() {

    $field = 'ga_anonymize_ip';
    $value = get_option( $field );

    ?>

    <input type="checkbox" name="<?php echo $field; ?>" value="1" <?php checked( $value ); ?> />

    <?php

  }

  /**
   * Renders checkbox for the track logged in users option
   *
   * @since 1.6.2
   *
   */
  function track_logged_in_field() {

    $field = 'track_logged_in';
    $value = get_option( $field );

    ?>

    <input type="checkbox" name="<?php echo $field; ?>" value="1" <?php checked( $value ); ?> />

    <?php

  }

  /**
   * Renders checkbox for the use tag manager option
   *
   * @since 1.6.2
   *
   */
  function use_tag_manager_field() {

    $field = 'ga_use_tag_manager';
    $value = get_option( $field );

    ?>

    <input type="checkbox" name="<?php echo $field; ?>" value="1" <?php checked( $value ); ?> />

    <?php

  }

  /**
   * Renders text field for the Google Tag Manager ID
   *
   * @since 1.6.2
   *
   */
  function tag_manager_id_field() {

    $field = 'ga_tag_manager_id';
    $value = esc_attr( get_option( $field ) );

    ?>

    <input type="text" name="<?php echo $field; ?>" placeholder="GTM-XXXXXX" value="<?php echo $value; ?>" />

    <?php

  }

	/**
	 * Loads all the admin scripts for settings page
   *
   * @since 1.0
   * @see https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
   * @see https://github.com/js-cookie/js-cookie
   *
	 */
	function load_admin_scripts( $hook ) {
		if( $hook != "settings_page_google_analytics" ) {
			return;
		}

		//admin styles
		wp_enqueue_style( 'custom-admin-styles', plugin_dir_url( __FILE__ ) . '/css/admin-styles.css' );

		//cookie library
		wp_enqueue_script( 'cookie-js', plugin_dir_url( __FILE__ ) . '/js/js.cookie.js' );

		//admin js for cookies
		wp_register_script( 'wk-ga-admin-js', plugin_dir_url( __FILE__ ) . '/js/admin-functions.js', array('jquery', 'cookie-js') );

		//translate JavaScript
		$translation_array = array(
			'TrackText' => __('Do not track any visits from this device.','wk-google-analytics')
		);
		wp_localize_script('wk-ga-admin-js', 'text_content', $translation_array );
		wp_enqueue_script('wk-ga-admin-js');

	}

  /**
   * Add an options page under 'Settings'
   *
   * @since 1.0
   * @see https://codex.wordpress.org/Function_Reference/add_options_page
   *
   */
  function settings_page() {
    add_options_page(
      'Google Analytics',
      'Google Analytics',
      'manage_options',
      'google_analytics',
      array( $this, "settings_content" )
  	);
  }

  /**
   * Ouputs the markup for the options page
   *
   * @since 1.0
   *
   */
  function settings_content() {

    if ( ! isset( $_REQUEST['settings-updated'] ) )
      $_REQUEST['settings-updated'] = false;
    ?>

  	<div class="wrap">
  	   <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

  	<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
      <div class="updated fade">
        <p>
          <strong><a target="_blank" href="https://support.google.com/analytics/answer/1008083"><?php _e( 'Test your tracking code now!', 'wk-google-analytics' ); ?></a></strong>
        </p>
      </div>
    <?php endif; ?>

    <div class="wk-left-part">
      <form id="wk-google-analytics-settings" method="post" action="options.php">
        <?php settings_fields( 'wk_ga_google_analytics' ); ?>
        <?php do_settings_sections('google_analytics'); ?>
        <div id="track-device"></div>
        <?php submit_button(); ?>
      </form>
    </div>
      <div class="wk-right-part">
        <?php include_once( __DIR__ . "/includes/mailchimp-form.php" ); ?>
      </div>
  	</div>

  <?php

  }

}

$wk_ga = new wk_ga();

?>
