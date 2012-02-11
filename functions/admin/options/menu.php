<?php
	
	function theme_options_menu_setup() {
		add_menu_page('Options', 'Options', 'publish_posts', 'options', 'theme_options_general', get_bloginfo('template_url').'/images/admin/options-16.png');
		//add_submenu_page( 'options', 'Homepage', 'Homepage', 'publish_posts', 'options-homepage', 'theme_options_homepage' );
	}
	add_action('admin_menu', 'theme_options_menu_setup');
	