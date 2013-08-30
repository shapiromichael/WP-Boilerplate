<?php

	// Styles
	wp_enqueue_style('home');
	
	get_header();
	
	// The content
	get_template_part('views/home');
	
	// Scripts
	wp_enqueue_script('home');
	
	get_footer();
