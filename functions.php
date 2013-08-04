<?php
	
	// Theme params
	require_once('functions/params.php');
	
	// Theme support
	require_once('functions/theme.php');
	
	// Admin header section
	require_once('functions/admin/header.php'); // This should be outside is_admin() because of the login screen

	// Components
	require_once('functions/components/settings/component.php');
	require_once('functions/components/sortlist/component.php');
	
	if( is_admin() ){
		
		// Admin option pages
		require_once('functions/admin/options/menu.php');
		require_once('functions/admin/options/general.php');
		require_once('functions/admin/options/sortlist.php');
		require_once('functions/admin/options/labels.php');
		
		// Metaboxs
		
		// Other
		require_once('functions/admin/utils.php');
		require_once('functions/libs/sortlist.php');
	}	
	
	// Post Types
	require_once('functions/post-types.php');
		
	// Scripts & styles registration
	require_once('functions/scripts-n-styles.php');
	
	// Sidebars
	require_once('functions/sidebars.php');
	
	// Widgets
	require_once('functions/widgets/unregister.php');
	require_once('functions/widgets/example.php');
	
	// Other
	require_once('functions/utils.php');
	