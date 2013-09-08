	<?php

	/*
	 *	Registering all scripts and styles fot this theme.
	 *	Will automatically register minified or expanded styles
	 */
	function theme_register_scripts_n_styles() {

		// Libs used on both
		wp_register_style('font-awesome', CSS_DIR . '/libs/font-awesome.css', array(),           '3.2.1' );

		if( is_admin() ) {
			theme_register_admin_styles();
			theme_register_admin_scripts();
			add_filter( 'mce_css', 'theme_editor_style' );

		}else{
			theme_register_styles();
			theme_register_scripts();
		}
		
	}
	add_action( 'init', 'theme_register_scripts_n_styles' );


	function theme_register_styles() {

		// Libs
		wp_register_style('fancybox', CSS_DIR . '/libs/fancybox.css', array(),           '1.3.4' );
		
		// Site styles
		wp_register_style('general',  CSS_DIR . '/general.css',       array('fancybox'), VERSION );
		wp_register_style('home',     CSS_DIR . '/home.css',          array('general'),  VERSION );

		// Dashboard login
		wp_register_style('login',    CSS_DIR . '/admin/login.css',   array(),           VERSION ); 
	}


	function theme_register_scripts() {

		// Libs
		wp_register_script('fancybox',  JS_DIR . '/libs/fancybox.js',     array('jquery'),     '1.3.4' );

		// Site scripts
		wp_register_script('general',   JS_DIR . '/general.js',           array('fancybox'),   VERSION );
		wp_register_script('home',      JS_DIR . '/home.js',              array('general'),    VERSION );
		
		// Dashboard login
		wp_register_script('login',     JS_DIR . '/admin/login.js',       array('jquery'),     VERSION );
	}


	// Dashboard
	function theme_register_admin_styles() {
		wp_register_style('admin-general',    CSS_DIR . '/admin/general.css',   array(),                             VERSION );
		wp_register_style('admin-options',    CSS_DIR . '/admin/options.css',   array('farbtastic', 'font-awesome'), VERSION );
		wp_register_style('admin-metaboxes',  CSS_DIR . '/admin/metaboxes.css', array(),                             VERSION );
	}

	function theme_register_admin_scripts() {

	}


	// TinyMCE styles
	function theme_editor_style( $styles ) {
		$styles .= ', ' . CSS_DIR . '/admin/' . 'editor.css';
		return $styles;
	}
	
