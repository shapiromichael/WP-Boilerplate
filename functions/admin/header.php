<?php
	
	// Loading scripts n styles on the dashboard
	function BP_admin_head() {

		wp_enqueue_script( array('jq-ui', 'admin-options', 'colorpick') );
		wp_enqueue_style(  array('admin-general', 'admin-options', 'colorpicker') );

		?>
			<link rel="icon" href="<?php echo DIR; ?>/assets/images/icon.ico" type="image/x-icon">
			<link rel="shortcut icon" href="<?php echo DIR; ?>/assets/images/icon.ico" type="image/x-icon">
		<?php	

	}
	add_action('admin_head', 'BP_admin_head');


	// Tweaking the login screen
	function BP_login_screen() {
		
		wp_enqueue_style('admin-login');
		
		?>
			<link rel="icon" href="<?php echo DIR; ?>/assets/images/icon.ico" type="image/x-icon">
			<link rel="shortcut icon" href="<?php echo DIR; ?>/assets/images/icon.ico" type="image/x-icon">
		<?php
	}
	add_action('login_head','BP_login_screen');
