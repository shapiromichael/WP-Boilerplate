<?php

define('ENV', 'DEV');


/*
 *	Registering all scripts and styles fot this theme.
 *	Will automatically register minified or expanded styles
 */
function register_scripts_n_styles() {

	$is_minfied = ( defined('ENV') && ENV == 'DEV' ) ? false : true ;

	register_styles(  $is_minfied );
	register_scripts( $is_minfied );

	if( is_admin() ) {
		register_admin_styles(  $is_minfied );
		register_admin_scripts( $is_minfied );
		add_filter( 'mce_css', 'theme_editor_style' );
	}

}
add_action( 'init', 'register_scripts_n_styles' );




// Website
function register_styles( $is_minified = false ) {

	// Already Minified files
	wp_register_style('fancybox', CSS_DIR . '/libs/fancybox.css' );
	wp_register_style('fonts',    CSS_DIR . '/fonts.css' );

	if( !$is_minified ) {
		// Unminified version
		wp_register_style('general',  CSS_DIR . '/general.css',     array('fonts','fancybox') );
		wp_register_style('home',     CSS_DIR . '/home.css',        array('general') );
		wp_register_style('login',    CSS_DIR . '/admin/login.css' );
	} else {
		// Minified
		wp_register_style('general',  CSS_DIR . '/general.min.css', array('fonts','fancybox') );
		wp_register_style('home',     CSS_DIR . '/home.min.css',    array('general') );
		wp_register_style('login',    CSS_DIR . '/admin/login.min.css' );
	}

}


function register_scripts( $is_minified = false ) {

	// Already Minified files
	wp_register_script('jq',        JS_DIR . '/libs/jquery.js',       array(),              true );
	wp_register_script('modernizr', JS_DIR . '/libs/modernizr.js',    array(),              true );
	wp_register_script('fancybox',  JS_DIR . '/libs/fancybox.js',     array('jq'),          true );

	if( $is_minified ) {
		// Minified
		wp_register_script('general', JS_DIR . '/general.min.js',     array('jq','fancybox'), true );
		wp_register_script('home',    JS_DIR . '/home.min.js',        array('general'),       true );
		wp_register_script('login',   JS_DIR . '/admin/login.min.js', array('jq'),            true );
	} else {
		// Unminified version
		wp_register_script('general', JS_DIR . '/general.js',         array('jq','fancybox'), true );
		wp_register_script('home',    JS_DIR . '/home.js',            array('general'),       true );
		wp_register_script('login',   JS_DIR . '/admin/login.js',     array('jq'),            true );
	}

}



// Dashboard
function register_admin_styles( $is_minified = false ) {
	wp_register_style('admin-general',  CSS_DIR . '/admin/general.css' );
	wp_register_style('admin-options',  CSS_DIR . '/admin/options.css' );
	wp_register_style('colorpicker',    CSS_DIR . '/libs/colorpicker.css' );
}

function register_admin_scripts( $is_minified = false ) {
	wp_register_script('jq-ui',         JS_DIR . '/libs/jquery-ui.js',   array('jq'),                         true );
	wp_register_script('modernizr',     JS_DIR . '/libs/modernizr.js',   array(),                             true );
	wp_register_script('colorpick',     JS_DIR . '/libs/colorpicker.js', array('jq'),                         true );
	wp_register_script('admin-options', JS_DIR . '/admin/options.js',    array('jq', 'jq-ui', 'colorpicker'), true );
}




// TinyMCE styles
function theme_editor_style( $styles ) {
	$styles .= ', ' . CSS_DIR . '/admin/' . 'editor.css';
	return $styles;
}