<?php
return array(
	array(
		'id' => 'php',
		'check' => !version_compare(PHP_VERSION, '5.4', '>='),
		'error_message' => __('WebKinder Google Analytics needs PHP version 5.4 to run.', 'wk-google-analytics'),
	),
	array(
		'id' => 'wp',
		'check' => !version_compare(get_bloginfo('version'), '4.8', '>='),
		'error_message' => __('WebKinder Google Analytics needs WordPress version 4.8 to run.', 'wk-google-analytics'),
	)
);
