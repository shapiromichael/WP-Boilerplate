<?php
	
	// Theme supports
	add_theme_support('menus');
	add_theme_support('post-thumbnails');
	
	// Remove WP defaults
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	