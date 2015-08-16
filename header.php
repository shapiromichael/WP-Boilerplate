<!DOCTYPE HTML>
<html>
	<head>
		<?php
			
			BP_partial('header', 'meta');

			wp_enqueue_style('main');
			wp_enqueue_script('plugins');
			
			wp_head();
			
		?>
		</head>

		<body <?php body_class(); ?>>

			<header>
				<?php 

					BP_partial('header', 'menu');

				?>
			</header>
