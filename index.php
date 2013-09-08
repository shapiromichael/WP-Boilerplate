<?php
	
	get_header();
	
	// The content
	while( have_posts() ){
		the_post();
		
		//get_template_part('content/loop/posts');
	}
	
	get_footer();
