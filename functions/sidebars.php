<?php

	function BP_sidebars(){
		
		// Default sidebar
		register_sidebar(
			array(
				'id'            => 'default-sidebar',
				'name'          => 'Default Sidebar',
				'description'   => '',
				'before_widget' => '<div class="widget %2$s" id="%1$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4>',
				'after_title'   => '</h4>'
			)
		);
		
	}
	add_action('widgets_init','BP_sidebars');
