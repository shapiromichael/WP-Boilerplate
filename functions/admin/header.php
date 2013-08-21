<?php
	
	// Loading scripts n styles on the dashboard
	function theme_admin_head() {

		wp_enqueue_script( array('jq-ui', 'admin-options', 'colorpick') );
		wp_enqueue_style(  array('admin-general', 'admin-options', 'colorpicker') );

		?>
			<link rel="icon" href="<?php echo DIR; ?>/images/icon.ico" type="image/x-icon">
			<link rel="shortcut icon" href="<?php echo DIR; ?>/images/icon.ico" type="image/x-icon">
		<?php	

	}
	add_action('admin_head', 'theme_admin_head');


	// Tweaking the login screen
	function theme_login_screen() {

		wp_enqueue_script('login');
		wp_enqueue_style('login');
		
		?>
			<link rel="icon" href="<?php echo DIR; ?>/images/icon.ico" type="image/x-icon">
			<link rel="shortcut icon" href="<?php echo DIR; ?>/images/icon.ico" type="image/x-icon">
		<?php
	}
	add_action('login_head','theme_login_screen');
