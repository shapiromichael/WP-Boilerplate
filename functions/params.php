<?php
	
	// It's good practice to add those defines to the WP config file,
	// otherwise it will be syncd with GIT

	define('ENV', 'DEV'); // DEV - development, STG - Staging, PRD - Production

	define('CSS_DIR', get_bloginfo('template_url') . '/css' );
	define('JS_DIR',  get_bloginfo('template_url') . '/js' );
	