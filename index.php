<?php

	// Styles
   wp_enqueue_style('general');
	
	get_header();
	
	// The content
	while( have_posts() ){
		the_post();
		//get_template_part('content/loop/posts');
	}
	
	// Scripts
	wp_enqueue_script('general');
	
	get_footer();
