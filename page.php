<?php
	
	get_header();
	
	// The content
	while( have_posts() ){
		the_post();
		the_title();
		the_content();
	}
	
	get_footer();
