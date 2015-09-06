<?php

function BP_Options(){
	$args = array();

	$args['page_title'] = 'WP Boilerplate Options';

	$sections = array();

	$sections[] = array(
		'title' => 'General',
		'fields' => array(
			array(
				'id' => 'ga_account_id',
				'type' => 'text',
				'title' => 'Google Analytics', 
				'sub_desc' => 'Account code'
				)
		)
	);

	$sections[] = array(
		'title' => 'Homepage',
		'fields' => array(
		)
	);


	$tabs = array();

	global $BP_Options;
	$BP_Options = new BP_Options($sections, $args, $tabs);

}
add_action('init', 'BP_Options', 0);
