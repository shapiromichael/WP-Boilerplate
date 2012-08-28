<?php

define('ENV', 'DEV');

function register_scripts_n_styles() {


	$is_minfied = ( defined('ENV') && ENV == 'DEV' ) ? false : true ;

	register_styles(  $is_minfied );
	register_scripts( $is_minfied );


	if( is_admin() ) {
		register_admin_styles(  $is_minfied );
		register_admin_scripts( $is_minfied );
		add_filter( 'mce_css', 'theme_editor_style' );
	}

	/*  Including expanded scripts and styles */
	// if( defined('ENV') && ENV == 'DEV' ) {
	
	// 	// Styles
	// 	wp_register_style('fancybox', CSS_DIR . '/libs/fancybox.css' );
	// 	wp_register_style('fonts',    CSS_DIR . '/fonts.css' );
	// 	wp_register_style('general',  CSS_DIR . '/general.css', array('fonts','fancybox') );
	// 	wp_register_style('home',     CSS_DIR . '/home.css', array('general') );

	// 	// Scripts
	// 	wp_register_script('jq',        JS_DIR . '/libs/jquery.js');
	// 	wp_register_script('modernizr', JS_DIR . '/libs/modernizr.js');
	// 	wp_register_script('fancybox',  JS_DIR . '/libs/fancybox.js', array('jq'));
	// 	wp_register_script('general',   JS_DIR . '/general.js', array('jq','fancybox'));
	// 	wp_register_script('home',      JS_DIR . '/home.js', array('general'));
	
	// } else {  // Including minified scripts and styles 

	// 	// Styles
	// 	wp_register_style('fancybox', CSS_DIR . '/libs/fancybox.css' );
	// 	wp_register_style('fonts',    CSS_DIR . '/fonts.css' );
	// 	wp_register_style('general',  CSS_DIR . '/general.min.css', array('fonts','fancybox') );
	// 	wp_register_style('home',     CSS_DIR . '/home.min.css', array('general') );

	// 	// Scripts
	// 	wp_register_script('jq',        JS_DIR . '/libs/jquery.js');
	// 	wp_register_script('modernizr', JS_DIR . '/libs/modernizr.js');
	// 	wp_register_script('fancybox',  JS_DIR . '/libs/fancybox.js', array('jq'));
	// 	wp_register_script('general',   JS_DIR . '/general.min.js', array('jq','fancybox'));
	// 	wp_register_script('home',      JS_DIR . '/home.min.js', array('general'));

	// }

}
add_action( 'init', 'register_scripts_n_styles' );




// Website
function register_styles( $is_minified = false ) {

	// Already Minified files
	wp_register_style('fancybox', CSS_DIR . '/libs/fancybox.css' );
	wp_register_style('fonts',    CSS_DIR . '/fonts.css' );

	if( !$is_minified ) {
		// Unminified version
		wp_register_style('general',  CSS_DIR . '/general.css', array('fonts','fancybox') );
		wp_register_style('home',     CSS_DIR . '/home.css', array('general') );
	} else {
		// Minified
		wp_register_style('general',  CSS_DIR . '/general.min.css', array('fonts','fancybox') );
		wp_register_style('home',     CSS_DIR . '/home.min.css', array('general') );
	}

}


function register_scripts( $is_minified = false ) {

	// Already Minified files
	wp_register_script('jq',        JS_DIR . '/libs/jquery.js');
	wp_register_script('modernizr', JS_DIR . '/libs/modernizr.js');
	wp_register_script('fancybox',  JS_DIR . '/libs/fancybox.js', array('jq'));

	if( $is_minified ) {
		// Minified
		wp_register_script('general',   JS_DIR . '/general.min.js', array('jq','fancybox'));
		wp_register_script('home',      JS_DIR . '/home.min.js', array('general'));
	} else {
		// Unminified version
		wp_register_script('general',   JS_DIR . '/general.js', array('jq','fancybox'));
		wp_register_script('home',      JS_DIR . '/home.js', array('general'));
	}


}




// Dashboard
function register_admin_styles( $is_minified = false ) {
	
}

function register_admin_scripts( $is_minified = false ) {

}




// TinyMCE styles
function theme_editor_style( $styles ) {
	$styles .= ', ' . CSS_DIR . '/admin/' . 'editor.css';
	return $styles;
}