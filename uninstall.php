<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

delete_option( 'ga_tracking_code' );
delete_option( 'track_logged_in' );
delete_option( 'ga_anonymize_ip' );
delete_option( 'ga_use_tag_manager' );
delete_option('ga_tag_manager_id');

// For site options in Multisite
delete_site_option( 'ga_tracking_code' );
delete_site_option( 'track_logged_in' );
delete_site_option( 'ga_anonymize_ip' );
delete_site_option( 'ga_use_tag_manager' );
delete_site_option('ga_tag_manager_id');
?>
