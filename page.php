<?php

	// Styles
    wp_enqueue_style('general');
	
	get_header();
	
	// The content
	while( have_posts() ){
		the_post();
		the_title();
		the_content();
	}
	
	// Scripts
	wp_enqueue_script('general');
	
	get_footer();
