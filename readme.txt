=== Google Analytics and Google Tag Manager ===
Contributors: WEBKINDER
Tags: google analytics, tracking code, analytics, anonymization, anonymize, anonymizeIp, cookie, Datenschutz, ga, gaoptout, google, googleanalytics, google tag manager, gtm, Datenschutz, datenschutzkonform, script, snippet
Requires at least: 4.9
Tested up to: 6.5
Requires PHP: 7.2
Stable tag: 1.11.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Google Analytics or Google Tag Manager for WordPress without tracking your own visits.

== Description ==

Deploy Google Analytics on your website without having to edit code and without tracking your own visits. You can exclude any logged in user from this and enable tracking solely for them. You can also ignore a device by ticking a box which sets a session cookie.

You can also enter your Google Tag Manager ID and disable tracking via GTM.

We would love to hear your [feedback](https://wordpress.org/support/plugin/wk-google-analytics/reviews/). It helps us improve and expand the plugin according to your needs.

If you have any questions or feature requests, feel free to contact us via support@webkinder.ch.

== Installation ==

1. Upload the folder in the zip file to your plugins directory or install the plugin via the WordPress admin panel option ‘Add new’.
1. Activate the plugin.
1. Navigate to ‘Settings’ and ‘Google Analytics’ to configure the plugin and enter your Google Analytics tracking ID or your Google Tag Manager container ID.
1. Check if the tracking works by following the [official Google documentation](https://support.google.com/analytics/answer/1008083?hl=en).

== Screenshots ==

1. The settings page of this plugin. The cookie mechanism is activated here.

== Changelog ==

= 1.11.2 =

* Verify support up to 6.5

= 1.11.1 =

* Verify 6.3 support

= 1.11.0 =

* Renamed UA to G in settings for better understanding with the upcoming changes

= 1.10.1 =

* Changed Google Tag Manager Script URL to always use https instead of protocol-relative URL

= 1.10.0 =

* Added following hooks for better frontend control through developers: 'wk_google_tag_manager_script', 'wk_google_tag_manager_noscript', 'wk_google_analytics_script', 'wk_render_tag_manager_scripts', 'wk_render_google_analytics_scripts'.

= 1.9.10 =

* Updated wording

= 1.9.9 =

* Tested up to WordPress 6.1

= 1.9.8 =

* Update composer packages and unit testing for CI

= 1.9.7 =

* Remove newsletter signup

= 1.9.6 =

* Changed wording and updated plugin icon and banner

= 1.9.4 =

* Fix deprecated warning "wp_get_default_privacy_policy_content" added with WordPress 5.7

= 1.9.3 =

* Fallback for wp_add_inline_script() without registered script used for Google Tag Manager in WordPress with versions below 5.1

= 1.9.2 =

* Updated wording
* NoScript is now using wp_body_open action added with 5.2 if already supported

= 1.9.1 =

* Updated plugin icon and banner

= 1.9.0 =

* Updated analytics implementation
* Changed naming

= 1.8.0 =

* Bugfix for caching plugins
* Refactored code base
* Dropping support for PHP 5.6, 7.0

= 1.7.4 =

* Bugfix for javascript blocked browsers

= 1.7.3 =

* Bugfix for caching plugins

= 1.7.2 =

* Automatically deactivate plugin when PHP version is not sufficient.

= 1.7.1 =
* The "Anonymize IPs" field is now checked by default.
* The Google Analytics tracking opt-out shortcode is automatically integrated on the new WordPress Privacy Policy page along with the Privacy Policy for the use of Google Analytics. This statement is currently available in English and German. You can use this shortcode on any page you wish, so your users can opt-out of Google Analytics tracking.
* Updated newsletter inside the setting pages
* Tested up to WordPress 4.9.6

= 1.6.2 =
* Refactored settings page for cleaner settings fields
* Added direct settings link from plugin overview screen
* Tested up to WordPress 4.7.2

= 1.6.1 =
* 'Test your tracking code now' linking to the correct language

= 1.6 =
* Improved tag manager script placement, preventing search console errors

= 1.5 =
* Visual improvement of the settings page

= 1.2 =
* added support for Google Tag Manager

= 1.1 =
* added anonymize IP's option
* added uninstall file

= 1.0 =
* Initial release
