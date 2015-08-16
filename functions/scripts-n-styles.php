<?php

	/*
	 *	Registering all scripts and styles fot this theme.
	 *	Will automatically register minified or expanded styles
	 */
	function BP_register_scripts_n_styles() {

		if( is_admin() ) {
			BP_register_admin_styles();
			BP_register_admin_scripts();
			add_filter( 'mce_css', 'BP_editor_style' );
		}else{
			BP_register_styles();
			BP_register_scripts();
		}
		
	}
	add_action( 'init', 'BP_register_scripts_n_styles' );


	function BP_register_styles() {

		wp_register_style('vendor',       CSS_PATH . '/vendor.css',      array(),          VERSION );
		wp_register_style('main',         CSS_PATH . '/main.css',        array('vendor'),  VERSION );

		// Admin login
		wp_register_style('admin-login',  CSS_PATH . '/admin/login.css', array(),          VERSION );
	}


	function BP_register_scripts() {

		// Libs
		wp_register_script('plugins', JS_PATH . '/plugins.min.js', array(),            VERSION );

		// Site scripts
		wp_register_script('main',    JS_PATH . '/main.min.js',    array('plugins'), VERSION );
		
		// Dashboard login
		// wp_register_script('admin-login',     JS_PATH . '/admin/login.js',       array('jquery'),     VERSION );
	}


	// Dashboard
	function BP_register_admin_styles() {
		wp_register_style('admin-main',      CSS_PATH . '/admin.css',           array(),             VERSION );
		wp_register_style('admin-options',   CSS_PATH . '/admin/options.css',   array('farbtastic'), VERSION );
		wp_register_style('admin-metaboxes', CSS_PATH . '/admin/metaboxes.css', array(),             VERSION );
	}

	function BP_register_admin_scripts() {

	}


	// TinyMCE styles
	function BP_editor_style( $styles ) {
		$styles .= ', ' . CSS_PATH . '/admin/editor.css';
		return $styles;
	}
	