<?php
	
	// Styles
	wp_register_style('fancybox', CSS_DIR . '/libs/fancybox.css');
	
	wp_register_style('fonts', CSS_DIR . '/fonts.css');
	wp_register_style('general', CSS_DIR . '/general.css', array('fonts','fancybox'));
	wp_register_style('home', CSS_DIR . '/home.css', array('general'));

	
	// Scripts
	wp_register_script('jq', JS_DIR . '/libs/jquery.js');
	wp_register_script('modernizr', JS_DIR . '/libs/modernizr.js');
	wp_register_script('fancybox', JS_DIR . '/libs/fancybox.js', array('jq'));
	
	wp_register_script('general', JS_DIR . '/general.js', array('jq','fancybox'));
	wp_register_script('home', JS_DIR . '/home.js', array('general'));
	
	
	if ( is_admin() ) {
		
		// TinyMCE styles
		function theme_editor_style( $styles ) {
			$styles .= ', ' . CSS_DIR . '/admin/' . 'editor.css';
			return $styles;
		}
		add_filter( 'mce_css', 'theme_editor_style' );
		
	}
	