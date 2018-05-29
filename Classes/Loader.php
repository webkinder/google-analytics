<?php

namespace WebKinder\GoogleAnalytics;

class Loader {

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
      </script> <?php
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
      $ANONYMIZE_IP     = (get_option('ga_anonymize_ip') !== false) ? (boolean) get_option('ga_anonymize_ip') : true ;
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
   * Registers cookie scripts for opt out shortcode
   */
  function register_public_scripts() {
    //cookie library
    wp_register_script( 'cookie-js', plugins_url(plugin_basename(WK_GOOGLE_ANALYTICS_DIR)) . '/js/js.cookie.js' );

    //admin js for cookies
    wp_register_script( 'wk-ga-admin-js', plugins_url(plugin_basename(WK_GOOGLE_ANALYTICS_DIR)) . '/js/admin-functions.js', array('jquery', 'cookie-js') );

    //translate JavaScript
    $translation_array = array(
      'TrackText' => __('Do not track any visits from this device.','wk-google-analytics')
    );
    wp_localize_script('wk-ga-admin-js', 'text_content', $translation_array );
  }


  /**
   * Loads all the admin scripts for settings page
   *
   * @since 1.0
   * @see https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
   * @see https://github.com/js-cookie/js-cookie
   *
   */
  function load_admin_styles( $hook ) {

    if( $hook != "settings_page_google_analytics" ) {
      return;
    }

    //admin styles
    wp_enqueue_style( 'custom-admin-styles', plugins_url(plugin_basename(WK_GOOGLE_ANALYTICS_DIR)) . '/css/admin-styles.css' );

  }

}
