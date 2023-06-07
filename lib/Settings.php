<?php

namespace WebKinder\GoogleAnalytics;

class Settings
{
	/**
	 * Add an options page under 'Settings'.
	 *
	 * @since 1.0
	 * @see https://codex.wordpress.org/Function_Reference/add_options_page
	 */
	public function settings_page()
	{
		add_options_page(
			'Google Analytics + Tag Manager by WEBKINDER',
			'Google Analytics',
			'manage_options',
			'google_analytics',
			[$this, 'settings_content']
		);
	}

	/**
	 * Ouputs the markup for the options page.
	 *
	 * @since 1.0
	 */
	public function settings_content()
	{
		if (!isset($_REQUEST['settings-updated'])) {
			$_REQUEST['settings-updated'] = false;
		}
		?>
		<div class="wrap">
			<h2><?php echo esc_html(get_admin_page_title()); ?></h2>
			<?php if (false !== $_REQUEST['settings-updated']) { ?>
				<div class="updated fade">
					<p>
						<strong>
							<a target="_blank" href="https://support.google.com/analytics/answer/1008083"><?php _e('Test your tracking code now!', 'wk-google-analytics'); ?></a>
						</strong>
					</p>
				</div>
			<?php } ?>
			<div class="wk-left-part">
				<form id="wk-google-analytics-settings" method="post" action="options.php">
					<?php settings_fields('wk_ga_google_analytics'); ?>
					<?php do_settings_sections('google_analytics'); ?>
					<?php submit_button(); ?>
				</form>
			</div>
		</div>
	<?php

	}

	/**
	 * Registers all the settings separately.
	 *
	 * @since 1.0
	 * @see https://codex.wordpress.org/Function_Reference/register_setting
	 * @see https://codex.wordpress.org/Function_Reference/add_settings_section
	 * @see https://codex.wordpress.org/Function_Reference/add_settings_field
	 */
	public function register_settings()
	{
		add_settings_section(
			'google_analytics',
			'',
			[$this, 'settings_header'],
			'google_analytics'
		);

		// @since 1.0
		register_setting(
			'wk_ga_google_analytics',
			'ga_tracking_code'
		);

		add_settings_field(
			'ga_tracking_code',
			__('Google Analytics 4 Stream-ID', 'wk-google-analytics'),
			[$this, 'tracking_code_field'],
			'google_analytics',
			'google_analytics'
		);

		// @since 1.0
		register_setting(
			'wk_ga_google_analytics',
			'track_logged_in'
		);

		add_settings_field(
			'ga_anonymize_ip',
			__('IP Anonymization', 'wk-google-analytics'),
			[$this, 'anonymize_ip_field'],
			'google_analytics',
			'google_analytics'
		);

		// @since 1.1
		register_setting(
			'wk_ga_google_analytics',
			'ga_anonymize_ip'
		);

		add_settings_field(
			'track_logged_in',
			__('Track logged in users', 'wk-google-analytics'),
			[$this, 'track_logged_in_field'],
			'google_analytics',
			'google_analytics'
		);

		// @since 1.2
		register_setting(
			'wk_ga_google_analytics',
			'ga_use_tag_manager'
		);

		add_settings_field(
			'ga_use_tag_manager',
			__('Use Google Tag Manager instead', 'wk-google-analytics'),
			[$this, 'use_tag_manager_field'],
			'google_analytics',
			'google_analytics'
		);

		// @since 1.2
		register_setting(
			'wk_ga_google_analytics',
			'ga_tag_manager_id'
		);

		add_settings_field(
			'ga_tag_manager_id',
			__('Google Tag Manager ID', 'wk-google-analytics'),
			[$this, 'tag_manager_id_field'],
			'google_analytics',
			'google_analytics'
		);
	}

	/**
	 * Renders the header text for the settings page.
	 *
	 * @since 1.6.2
	 */
	public function settings_header()
	{
		wp_enqueue_script('cookie-js');
		wp_enqueue_script('wk-ga-admin-js');
		?>
		<p><?php _e('Enter your Google Analytics tracking ID below. Should you use Google Tag Manager to deploy Google Analytics, enter your GTM Container ID in the respective field and tick the box “Use Google Tag Manager instead”.', 'wk-google-analytics'); ?>
		</p>
	<?php
	}

	/**
	 * Renders text input for the Google Analytics tracking code.
	 *
	 * @since 1.6.2
	 */
	public function tracking_code_field()
	{
		$field = 'ga_tracking_code';
		$value = esc_attr(get_option($field));

		?>
		<input type="text" name="<?php echo $field; ?>" placeholder="G-XXXXXXXXXX" value="<?php echo $value; ?>" />
	<?php
	}

	/**
	 * Renders checkbox for the anonymize IP's option.
	 *
	 * @since 1.6.2
	 */
	public function anonymize_ip_field()
	{
		$field = 'ga_anonymize_ip';
		$value = get_option($field);
		$value = (false !== $value) ? $value : true;

		?>

		<div class="anonymize-ip-tooltip">
			<input type="hidden" name="<?php echo $field; ?>" value="0">
			<input type="checkbox" name="<?php echo $field; ?>" value="1" <?php checked($value); ?> />
			<span class="tooltip-text"><?php echo __('This setting is only effective if you use Google Analytics. If you use Google Tag Manager to deploy Google Analytics, you have to enable <a href="https://support.google.com/analytics/answer/2763052?hl=de" target="_blank">IP Anonymization</a> in your GTM settings.', 'wk-google-analytics'); ?></span>
		</div>

		<style>
			.anonymize-ip-tooltip:hover .tooltip-text {
				display: inline-block;
			}

			.anonymize-ip-tooltip .tooltip-text {
				display: none;
			}
		</style>
	<?php
	}

	/**
	 * Renders checkbox for the track logged in users option.
	 *
	 * @since 1.6.2
	 */
	public function track_logged_in_field()
	{
		$field = 'track_logged_in';
		$value = get_option($field);

		?>
		<input type="checkbox" name="<?php echo $field; ?>" value="1" <?php checked($value); ?> />
	<?php

	}

	/**
	 * Renders checkbox for the use tag manager option.
	 *
	 * @since 1.6.2
	 */
	public function use_tag_manager_field()
	{
		$field = 'ga_use_tag_manager';
		$value = get_option($field);

		?>
		<input type="checkbox" name="<?php echo $field; ?>" value="1" <?php checked($value); ?> />
	<?php

	}

	/**
	 * Renders text field for the Google Tag Manager ID.
	 *
	 * @since 1.6.2
	 */
	public function tag_manager_id_field()
	{
		$field = 'ga_tag_manager_id';
		$value = esc_attr(get_option($field));

		?>
		<input type="text" name="<?php echo $field; ?>" placeholder="GTM-XXXXXX" value="<?php echo $value; ?>" />
<?php

	}
}
