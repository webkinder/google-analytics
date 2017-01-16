<?php
/*
Plugin Name: Google Analytics by WebKinder
Plugin URI:  https://wordpress.org/plugins/wk-google-analytics/
Description: Google Analytics for WordPress without tracking your own visits
Version:     1.6.1
Author:      WebKinder
Author URI:  http://www.webkinder.ch
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /lang
Text Domain: wk-ga
*/

class wk_ga {
    public function __construct() {

    	//Lifecycle hooks
    	register_activation_hook( __FILE__, array( $this, "activation" ) );
    	register_deactivation_hook( __FILE__, array( $this, "deactivation" ) );

    	//i18n
    	add_action('plugins_loaded', array( $this, "load_textdomain") );

    	//Settings
    	add_action( 'admin_init', array( $this, "register_settings" ) );
    	add_action( 'admin_menu', array( $this, "settings_page" ) );

    	//Cookie Handling
    	add_action( 'admin_enqueue_scripts', array( $this, "load_admin_scripts" ) );

      //Cookie function
      add_action( 'wp_head', array( $this, 'render_script') );

      //Google Analytics script in <head>
      add_action( 'wp_head', array( $this, 'google_analytics_script') );

      //Google Tag Manager script in header
      add_action( 'wp_head', array( $this, 'google_tag_manager_script'));

      //Google Tag Manager noscript footer
      add_action( 'wp_footer', array( $this, 'google_tag_manager_noscript'));
    }

    /*
     * Should Track Visit
     */
    function should_track_visit() {
      return ( !is_user_logged_in() || get_option('track_logged_in') );
    }

    /*
     * Render Script
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

    /*
     * Tag Manager Script Tag
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

     /*
      * Tag Manager Script Tag
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

     /*
      * Google Analytics Script Tag
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
            //anonymize IP
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

    /*
     * Load Text Domain
     */
	function load_textdomain() {
		load_plugin_textdomain( 'wk-ga', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
	}

    /*
     * Plugin Activation
     */
    public function activation() {

    }

    /*
     * Plugin Deactivation
     */
    public function deactivation() {

    }

    /*
     * Register Settings
     */
    public function register_settings() {
	    register_setting(
	         'wk_ga_google_analytics',
	         'ga_tracking_code'
	    );

	    register_setting(
	         'wk_ga_google_analytics',
	         'track_logged_in'
	    );

      register_setting(
        'wk_ga_google_analytics',
        'ga_anonymize_ip'
      );

      register_setting(
        'wk_ga_google_analytics',
        'ga_use_tag_manager'
      );

      register_setting(
        'wk_ga_google_analytics',
        'ga_tag_manager_id'
      );

	}

	/*
	 *
	 */
	public function load_admin_scripts( $hook ) {
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
			'TrackText' => __('Do not track any visits from this device.','wk-ga')
		);
		wp_localize_script('wk-ga-admin-js', 'text_content', $translation_array );
		wp_enqueue_script('wk-ga-admin-js');

	}

    /*
     * Settings Page
     */
    public function settings_page() {
        add_options_page(
        'Google Analytics',
        'Google Analytics',
        'manage_options',
        'google_analytics',
        array( $this, "settings_content" )
    	);
    }

    public function settings_content() {

    if ( ! isset( $_REQUEST['settings-updated'] ) )
          $_REQUEST['settings-updated'] = false;
    ?>
	    <div class="wrap">
	        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

			<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
            	<div class="updated fade"><p><strong><a target="_blank" href="https://support.google.com/analytics/answer/1008083"><?php _e( 'Test your tracking code now!', 'wk-ga' ); ?></a></strong></p>
            	</div>
          	<?php endif; ?>

	        <p><?php _e('Enter your Google Analytics tracking code below. You can also use Google Tag Manager instead by checking the relevant setting.', 'wk-ga'); ?>
	        </p>
          <div class="wk-left-part">
  	        <form id="wk-google-analytics-settings" method="post" action="options.php">
                  <?php settings_fields( 'wk_ga_google_analytics' ); ?>
                  <?php do_settings_sections('wk_ga_google_analytics'); ?>

                  <div class="use-google-analytics">
  	                <label><?php _e('GA Tracking Code', 'wk-ga'); ?></label>
  	                <input type="text" name="ga_tracking_code" placeholder="UA-XXXXXXXX-X" value="<?php echo esc_attr( get_option( "ga_tracking_code" ) ); ?>" />
  	              </div>
                  <div class="use-google-analytics">
                    <label><?php _e("Anonymize IP's", 'wk-ga'); ?></label>
                    <input type="checkbox" name="ga_anonymize_ip" value="1" <?php checked( get_option( "ga_anonymize_ip") ); ?> />
                  </div>
                  <div>
                  	<label><?php _e('Track logged in users', 'wk-ga'); ?></label>
                  	<input type="checkbox" name="track_logged_in" value="1" <?php checked( get_option( "track_logged_in" ) ); ?> />
                  </div>
                  <div>
                    <label><?php _e("Use Google Tag Manager instead", 'wk-ga'); ?></label>
                    <input id="use-google-tag-manager" type="checkbox" name="ga_use_tag_manager" value="1" <?php checked( get_option( "ga_use_tag_manager") ); ?> />
                  </div>
                  <div class="use-google-tag-manager">
                    <label><?php _e("Google Tag Manager ID", 'wk-ga'); ?></label>
                    <input type="text" name="ga_tag_manager_id" placeholder="GTM-XXXXXX" value="<?php echo esc_attr( get_option( "ga_tag_manager_id" ) ); ?>" />
                  </div>
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
