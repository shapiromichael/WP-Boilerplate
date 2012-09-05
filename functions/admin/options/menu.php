<?php

	function theme_options_menu_setup() {

		add_menu_page('Temp-Options', 'Temp Options', 'publish_posts', 'options', 'theme_options_general', get_bloginfo('template_url').'/images/admin/options-16.png');

		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page( 'options', 'Sortlist',    'Sortlist',    'edit_dashboard', 'sortlist', 'theme_sortlist' );
		add_submenu_page( 'options', 'Custom Text', 'Custom Text', 'edit_dashboard', 'labels',   'options_custom_labels' );


	}
	add_action('admin_menu', 'theme_options_menu_setup');
