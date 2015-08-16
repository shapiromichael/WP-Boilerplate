<?php
	
	/* 
	 *  The theme prefix is: "BP_", you can global find & replace that to whatever feels right
	 */

	// Theme version is used when registered scripts and styles
	if (function_exists('wp_get_theme')){
		$theme_data = wp_get_theme();
		$theme_version = $theme_data->get('Version');
	}else{
		$theme_data = get_theme_data(trailingslashit(get_stylesheet_directory()).'style.css');
		$theme_version = $theme_data['Version'];
	}
	define('VERSION', $theme_version );

	define('DEBUG', WP_DEBUG );

	define('PATH', get_bloginfo('template_url'));
	define('CSS_PATH', PATH . '/assets/css');
	define('JS_PATH',  PATH . '/assets/js');
	define('UI_PATH',  PATH . '/assets/images/ui');
	define('ABS_DIR', get_template_directory());
	define('VIEWS_DIR', 'views' );
	define('PARTIALS_DIR', VIEWS_DIR . '/partials');
