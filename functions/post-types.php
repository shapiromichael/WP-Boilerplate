<?php
	
	function BP_register_posttype(){
		
		BP_register_posttype_example();
		
	}
	add_action('init','BP_register_posttype');
	
	
	// Register example post type
	function BP_register_posttype_example(){
		
		$labels = array(
			'name'               => 'Example',
			'singular_name'      => 'Example',
			'add_new'            => 'Add New Example',
			'add_new_item'       => 'Add New Example',
			'edit_item'          => 'Edit Example',
			'new_item'           => 'New Example',
			'all_items'          => 'All Examples',
			'view_item'          => 'View Examples',
			'search_items'       => 'Search Examples',
			'not_found'          => 'No Examples Found',
			'not_found_in_trash' => 'No Examples Found in Trash', 
			'parent_item_colon'  => '',
			'menu_name'          => 'Examples'
		);
		
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true, 
			'show_in_menu'       => true, 
			'query_var'          => true,
			'rewrite'            => true,
			'capability_type'    => 'post',
			'has_archive'        => false, 
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'			 => 'dashicons-edit',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'  ),
			'taxonomies'         => array( 'category', 'post_tag' ),
			'menu_position'      => 5 // below Posts
		);
		register_post_type( 'example', $args );
		
	}
