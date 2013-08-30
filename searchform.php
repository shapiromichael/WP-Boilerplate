<?php
	
	$search_query = ( isset($_GET['s']) ) ? $_GET['s'] : '' ;

	get_template_part('views/components/search');
	