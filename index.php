<?php

	// Styles
	wp_enqueue_style('main');
	
	get_header();
	
	// The content
	while( have_posts() ){
		the_post();
		//get_template_part('content/loop/posts');
	}
	
	// Scripts
	wp_enqueue_script('main');
	
	get_footer();
