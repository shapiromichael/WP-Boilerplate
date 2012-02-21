<?php
	
	// Loading scripts n styles on the dashboard
	function theme_admin_head() {
		
		global $pagenow;
		$templateUrl = get_bloginfo('template_url');
		
		?>
        <link rel="icon" href="<?php echo $templateUrl; ?>/images/icon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="<?php echo $templateUrl; ?>/images/icon.ico" type="image/x-icon">
		  <link rel="stylesheet" type="text/css" href="<?php echo $templateUrl; ?>/css/admin/general.css" />
		<?php	
		
		if( $pagenow == 'admin.php' ){
			?>
			   <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/admin/options.css" />
			   <script language="javascript" type="text/javascript" src="<?php echo $url; ?>/js/libs/jquery.js"></script>
            <script language="javascript" type="text/javascript" src="<?php echo $url; ?>/js/admin/options.js"></script>
			<?php
		}else{
			?><!-- PAGE: <?php echo $pagenow; ?>--><?php
		}
	}
	add_action('admin_head', 'theme_admin_head');
	
	
	// Tweaking the login screen
	function theme_login_screen() {
		
		$templateUrl = get_bloginfo('template_url');
		
		?>
        <link rel="icon" href="<?php echo $templateUrl; ?>/images/icon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="<?php echo $templateUrl; ?>/images/icon.ico" type="image/x-icon">
		  <style>
		     body.login { 
					/* Here you can set the background style */
			  }
			  .login #login h1 a {
				   width: 327px; height: 54px; background: url(<?php echo $templateUrl; ?>/images/admin/logo.png) no-repeat;
			  }
		  </style>
		  <script language="javascript" type="text/javascript" src="<?php echo $templateUrl; ?>/js/libs/jquery.js"></script>
        <script language="javascript" type="text/javascript">
	     <!--
	   		
			$(document).ready(function(){
				$('#login h1 a').attr('href','<?php echo home_url(); ?>').removeAttr('title');
			});
			
		  //-->
		  </script>
		<?php
	}
	add_action('login_head','theme_login_screen');
