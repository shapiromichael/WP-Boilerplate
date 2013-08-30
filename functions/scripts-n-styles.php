	<?php

	/*
	 *	Registering all scripts and styles fot this theme.
	 *	Will automatically register minified or expanded styles
	 */
	function theme_register_scripts_n_styles() {

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
		wp_register_style('fancybox', CSS_DIR . '/libs/fancybox.css' );
		
		// Site styles
		wp_register_style('general',  CSS_DIR . '/general.css', array('fancybox') );
		wp_register_style('home',     CSS_DIR . '/home.css',    array('general') );

		// Dashboard login
		wp_register_style('login',    CSS_DIR . '/admin/login.css' ); 
	}


	function theme_register_scripts() {

		// Libs
		wp_register_script('fancybox',  JS_DIR . '/libs/fancybox.js',     array('jquery'),     true );

		// Site scripts
		wp_register_script('general',   JS_DIR . '/general.js',           array('fancybox'),   true );
		wp_register_script('home',      JS_DIR . '/home.js',              array('general'),    true );
		
		// Dashboard login
		wp_register_script('login',     JS_DIR . '/admin/login.js',       array('jquery'),     true );
	}


	// Dashboard
	function theme_register_admin_styles() {
		wp_register_style('admin-general',  CSS_DIR . '/admin/general.css' );
	}

	function theme_register_admin_scripts() {

	}


	// TinyMCE styles
	function theme_editor_style( $styles ) {
		$styles .= ', ' . CSS_DIR . '/admin/' . 'editor.css';
		return $styles;
	}
	
