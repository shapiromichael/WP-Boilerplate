<!DOCTYPE HTML>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(''); ?></title>
<link rel="icon" href="<?php echo bloginfo('template_directory'); ?>/images/icon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo bloginfo('template_directory'); ?>/images/icon.ico" type="image/x-icon">
<meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=EDGE" />
<meta name="viewport" content="width=device-width" />
<?php
	
	wp_head();
	
?>
</head>

<body <?php body_class(); ?>>

	<div id="header">
		
		<ul class="main-menu">
			<?php 
				wp_nav_menu( array(
					'menu'            => 'Main Menu',
					'container'       => '',
					'items_wrap'      => '%3$s',
					'fallback_cb'     => false,
					'depth'           => 4
					));
			?>
		</ul>
		
	</div>
	<?php
	
	if( WP_DEBUG ){ echo '<!-- #header -->'; }
	