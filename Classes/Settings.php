<?php

namespace WebKinder\GoogleAnalytics;

class Settings {

  /**
   * Add an options page under 'Settings'
   *
   * @since 1.0
   * @see https://codex.wordpress.org/Function_Reference/add_options_page
   *
   */
  function settings_page() {
    if (!apply_filters('wk_google_analytics_dev_mode', false)) {
      add_options_page(
        'Google Analytics',
        'Google Analytics',
        'manage_options',
        'google_analytics',
        array( $this, "settings_content" )
      );
    }
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
        <?php include_once( WK_GOOGLE_ANALYTICS_DIR . "/includes/mailchimp-form.php" ); ?>
      </div>
    </div>

  <?php

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

     register_setting(
       'wk_ga_google_analytics',
       'wk_google_analytics'
     );

			add_settings_field(
				'tracking_code',
				__('GA Tracking Code', 'wk-google-analytics'),
				array( $this, 'tracking_code_field' ),
				'google_analytics',
				'google_analytics'
			);

			add_settings_field(
				'anonymize_ip',
				__('Anonymize IP"s', 'wk-google-analytics'),
				array( $this, 'anonymize_ip_field' ),
				'google_analytics',
				'google_analytics'
			);

			add_settings_field(
				'track_logged_in',
				__('Track logged in users', 'wk-google-analytics'),
				array( $this, 'track_logged_in_field' ),
				'google_analytics',
				'google_analytics'
			);

			add_settings_field(
				'use_tag_manager',
				__('Use Google Tag Manager instead', 'wk-google-analytics'),
				array( $this, 'use_tag_manager_field' ),
				'google_analytics',
				'google_analytics'
			);

			add_settings_field(
				'tag_manager_id',
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

    $field = 'tracking_code';
    $value =  $this->wk_get_option($field);
    ?>

    <input type="text" name="wk_google_analytics[<?php echo $field; ?>]" placeholder="UA-XXXXXXXX-X" value="<?php echo $value; ?>" />

    <?php
  }

  /**
   * Renders checkbox for the anonymize IP's option
   *
   * @since 1.6.2
   *
   */
  function anonymize_ip_field() {

    $field = 'anonymize_ip';
    $value =  $this->wk_get_option($field);

    ?>

    <input type="checkbox" name="wk_google_analytics[<?php echo $field; ?>]" value="1" <?php checked( $value ); ?> />

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
    $value =  $this->wk_get_option($field);

    ?>

    <input type="checkbox" name="wk_google_analytics[<?php echo $field; ?>]" value="1" <?php checked( $value ); ?> />

    <?php

  }

  /**
   * Renders checkbox for the use tag manager option
   *
   * @since 1.6.2
   *
   */
  function use_tag_manager_field() {

    $field = 'use_tag_manager';
    $value =  $this->wk_get_option($field);

    ?>

    <input type="checkbox" name="wk_google_analytics[<?php echo $field; ?>]" value="1" <?php checked( $value ); ?> />

    <?php

  }

  /**
   * Renders text field for the Google Tag Manager ID
   *
   * @since 1.6.2
   *
   */
  function tag_manager_id_field() {

    $field = 'tag_manager_id';
    $value =  $this->wk_get_option($field);

    ?>

    <input type="text" name="wk_google_analytics[<?php echo $field; ?>]" placeholder="GTM-XXXXXX" value="<?php echo $value; ?>" />

    <?php

  }

	/**
	 * Gets options from filter if dev-mode is enabled
	 *
	 * @since 2.0
	 *
	 */
	function wk_get_option($option) {

		if (apply_filters('wk_google_analytics_dev_mode', false)) {
			return apply_filters('wk_google_analytics_options', array(
				'ga_tracking_code' => '',
				'ga_anonymize_ip' => false,
				'track_logged_in' => false,
				'ga_use_tag_manager' => false,
				'ga_tag_manager_id' => ''
			));
		} else {
			return get_option( 'wk_google_analytics' )[$option];
		}

	}

}
