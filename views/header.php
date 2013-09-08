<!DOCTYPE HTML>
<html>
	<head>
	<?php
		
		get_template_part('views/header', 'meta');

		wp_head();
		
	?>
	</head>
	<body <?php body_class(); ?>>

		<header>
			
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
			
		</header>