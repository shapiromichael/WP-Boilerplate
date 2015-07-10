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

		wp_register_style('vendor',       CSS_DIR . '/vendor.css',      array(),          VERSION );
		wp_register_style('main',         CSS_DIR . '/main.css',        array('vendor'),  VERSION );

		// Admin login
		wp_register_style('admin-login',  CSS_DIR . '/admin/login.css', array(),          VERSION );
	}


	function BP_register_scripts() {

		// Libs
		wp_register_script('plugins', JS_DIR . '/plugins.min.js', array(),            VERSION );

		// Site scripts
		wp_register_script('main',    JS_DIR . '/main.min.js',    array('plugins'), VERSION );
		
		// Dashboard login
		// wp_register_script('admin-login',     JS_DIR . '/admin/login.js',       array('jquery'),     VERSION );
	}


	// Dashboard
	function BP_register_admin_styles() {
		wp_register_style('admin-main',      CSS_DIR . '/admin.css',           array(),             VERSION );
		wp_register_style('admin-options',   CSS_DIR . '/admin/options.css',   array('farbtastic'), VERSION );
		wp_register_style('admin-metaboxes', CSS_DIR . '/admin/metaboxes.css', array(),             VERSION );
	}

	function BP_register_admin_scripts() {

	}


	// TinyMCE styles
	function BP_editor_style( $styles ) {
		$styles .= ', ' . CSS_DIR . '/admin/editor.css';
		return $styles;
	}
	