<?php

	// Styles
	wp_enqueue_style('main');
	
	get_header();
	
	// The content
	//get_template_part('content/home/featured');
	
	?>
	<img src="<?php echo get_theme_mod('some_image'); ?>" alt="">
	<?php
	
	// Scripts
	wp_enqueue_script('main');
	
	get_footer();
