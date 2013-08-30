<?php
	
	global $search_query;

?>
<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<input type="text" class="search-txt" value="<?php echo $search_query; ?>" name="s" id="s" />
	<input type="submit" class="search-btn" value="Search" />
</form>