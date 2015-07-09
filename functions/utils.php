<?php
	
	
/*	
 *	Lets you customize the more link after the post excerpt
 */
function BP_excerpt_more_link($more) {
	global $post;
	return '<a class="moretag" href="'. get_permalink($post->ID) . '"> Read more &raquo; </a>';
}
add_filter('excerpt_more', 'BP_excerpt_more_link');
	