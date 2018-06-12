=== Google Analytics ===
Contributors: webkinder
Tags: google analytics, tracking code, analytics, anonymization, anonymize, anonymizeIp, cookie, Datenschutz, ga, gaoptout, google, googleanalytics, google tag manager, gtm, Datenschutz, datenschutzkonform, script, snippet
Requires at least: 3.0
Requires PHP: 5.4
Tested up to: 4.9.6
Stable tag: 1.7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Google Analytics for WordPress without tracking your own visits.

== Description ==

Enable Google Analytics on all pages without tracking your own visits. You can exclude any logged in user as well as ignore a device completely by setting a cookie.

New feature: You can now also use Google Tag Manager with this plugin.

We would love to hear your feedback in a [review](https://wordpress.org/support/plugin/wk-google-analytics/reviews/). It helps us improve and expand the plugin according to your needs.

If you have any questions or feature requests, feel free to contact us via support@webkinder.ch.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wk-ga directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->Google Analytics screen to configure the plugin
1. Test your Tracking Code as shown [here](https://support.google.com/analytics/answer/1008083?hl=en)

== Screenshots ==

1. The settings page of this plugin. The cookie mechanism is activated here.

== Changelog ==

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
