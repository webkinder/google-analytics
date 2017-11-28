# google-analytics

**Maintainer: Mauro**

WordPress Google Analytics Plugin

## DEV-mode

To enable the Google Analytics DEV-mode use `add_filter('wk_google_analytics_dev_mode', '__return_true')` in your code. This will hide the plugins settings page. If you enable the DEV-mode Google Analytics will always use the settings you set in your code by using the filter `wk_google_analytics_options`.
<h3>All possible settings: *(Array)*</h3>
<table style="width:100%;">
	<tr>
		<th>Key</th>
		<th>Value</th>
	</tr>
	<tr>
		<td>ga_tracking_code</td>
		<td>String</td>
	</tr>
	<tr>
		<td>ga_anonymize_ip</td>
		<td>Boolean</td>
	</tr>
	<tr>
		<td>track_logged_in</td>
		<td>Boolean</td>
	</tr>
	<tr>
		<td>ga_use_tag_manager</td>
		<td>Boolean</td>
	</tr>
	<tr>
		<td>ga_tag_manager_id</td>
		<td>String</td>
	</tr>
</table>