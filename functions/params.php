<?php
	
	// It's good practice to add those defines to the WP config file,
	// otherwise it will be syncd with GIT

	define('ENV', 'DEV'); // DEV - development, STG - Staging, PRD - Production

	define('DIR', get_bloginfo('template_url') );
	define('CSS_DIR', DIR . '/css' );
	define('JS_DIR',  DIR . '/js' );


	/**
	 *	Conduit Blog Parameters.
	 *	use the functions: get_param( $key ); to retrieve a parameter value form anywhere in the theme.
	 *	You can change the array structure as you want but you must maintain the structure.
	 *	Edit the parameter values in the Dahsboard > Conduit Options
	 *	The system selects all the paramters in a single query
	 *	reducing the database calls for each page reuest.
	 *	
	 *	'name': The id of the field, must be unique (cannot use identical keys in different sections).
	 *	'title': The title to display on dashboard. (if the title is not give, it will use the key insted).
	 *	'description': (optional) Description, will be displayed on the dashboard.
	 *	'section': index of the cooresponding section in the sections array.
	 */


	// Setup captions
	$OPTIONS_PARAMS_SECTIONS = array(
		0 => 'General',
		1 => 'Post',
		2 => 'Conduit Params',
		3 => 'Wibiya Params',
		4 => 'Mobile Params',
		5 => '404 Page',
	);

	// Params array
	$OPTIONS_PARAMS = array(
	
		// General Section
		array( 'name' => 'search_placeholder', 'title' => 'Search This Blog',         'description' => 'Watermark text that will appear in the search field',            'section' => 0),
		array( 'name' => 'read_more_link',     'title' => 'Read More Link Text',      'description' => 'Appears after eaxcerpt on every item on home, search, category', 'section' => 0),
		array( 'name' => 'footer_copyrights',  'title' => 'Copyrights in the Footer', 'description' => 'for example: All rights reserved for Sinapsa &copy;',            'section' => 0),
		array( 'name' => 'fb_app_id',          'title' => 'Facebook App ID',          'description' => 'Facebook App ID for putting in header meta tag',                 'section' => 0),
		array( 'name' => 'fb_admin',           'title' => 'Facebook Admin Name',      'description' => 'Facebook Admin Name for putting in header meta tag',             'section' => 0),
		array( 'name' => 'no_posts_found_msg', 'title' => 'No Posts Found Message',   'description' => 'This message will appear when search did not yield any results', 'section' => 0),
		array( 'name' => 'before_categories',  'title' => 'Before Categories',        'description' => 'Will appear before category links',                              'section' => 0),
		array( 'name' => 'before_tags',        'title' => 'Before Tags',              'description' => 'Will appear before tag links',                                   'section' => 0),
		

		// Post Section
		array( 'name' => 'before_author',      'title' => 'Before Author',            'description' => 'Will appear before the author title',                            'section' => 1),
		array( 'name' => 'bofore_date',        'title' => 'Before Date',              'description' => 'Will appear before the date',                                    'section' => 1),

		
		// Conduit Params Section
		array( 'name' => 'conduit_default_image', 'title' => 'Conduit Default Image',   'description' => 'Default Featured Image - if post has no featured image',       'section' => 2),
		array( 'name' => 'conduit_twitter_page',  'title' => 'Conduit Twitter Page',    'description' => 'Twitter @username or full URL',                                'section' => 2),
		array( 'name' => 'conduit_facebook_page', 'title' => 'Conduit Facebook Page',   'description' => 'Conduit facebook page URL',                                    'section' => 2),
		array( 'name' => 'conduit_linkedin_page', 'title' => 'Conduit Linked In Page',  'description' => 'Conduit Linked In page URL',                                   'section' => 2),
		array( 'name' => 'conduit_g_plus_page',   'title' => 'Conduit Google+ Page',    'description' => 'Conduit Google+ page URL',                                     'section' => 2),
		array( 'name' => 'conduit_stumble_page',  'title' => 'Conduit Stumble Page',    'description' => 'Conduit Stumble page URL',                                     'section' => 2),
		array( 'name' => 'conduit_youtube_page',  'title' => 'Conduit Youtube Page',    'description' => 'Conduit YouTube page URL',                                     'section' => 2),


		// Wibiya Params Section
		array( 'name' => 'wibiya_default_image', 'title' => 'Wibiya Default Image',    'description' => 'Default Featured Image - if post has no featured image',        'section' => 3),
		array( 'name' => 'wibiya_twitter_page',  'title' => 'Wibiya Twitter Page',     'description' => 'Twitter @username or full URL',                                 'section' => 3),
		array( 'name' => 'wibiya_facebook_page', 'title' => 'Wibiya Facebook Page',    'description' => 'Wibiya facebook page URL',                                      'section' => 3),
		array( 'name' => 'wibiya_linkedin_page', 'title' => 'Wibiya Linked In Page',   'description' => 'Wibiya Linked In page URL',                                     'section' => 3),
		array( 'name' => 'wibiya_g_plus_page',   'title' => 'Wibiya Google+ Page',     'description' => 'Wibiya Google+ page URL',                                       'section' => 3),
		array( 'name' => 'wibiya_stumble_page',  'title' => 'Wibiya Stumble Channel',  'description' => 'Wibiya Stumble channel URL',                                    'section' => 3),
		array( 'name' => 'wibiya_youtube_page',  'title' => 'Wibiya YoutTube Channel', 'description' => 'Wibiya YoutTube channel URL',                                   'section' => 3),


		// Mobile Params Section
		array( 'name' => 'mobile_default_image', 'title' => 'Wibiya Default Image',   'description' => 'Default Featured Image - if post has no featured image',         'section' => 4),


		// Mobile Params Section
		array( 'name' => 'title_404', 'title' => '404 Page Title',  'description' => '',                                                                                 'section' => 5),
		array( 'name' => 'text_404',  'title' => '404 Page Text',   'description' => '',                                                                                 'section' => 5),
	
	);
	