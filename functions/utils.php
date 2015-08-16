<?php
	

	// Lets you customize the more link after the post excerpt
	function BP_excerpt_more_link($more) {
		global $post;
		return '<a class="moretag" href="'. get_permalink($post->ID) . '"> Read more &raquo; </a>';
	}
	add_filter('excerpt_more', 'BP_excerpt_more_link');

	// Utils function for importing view template files
	function BP_view($slug, $name) {

		if( DEBUG ){
			$comment = ($slug) ? $slug : '';
			$comment = ($comment && $name) ? $comment . '-' . $name : '';
			$begin_comment = ($comment) ? '<!-- begin view: ' . $comment . ' -->' : '';
			$end_comment = ($comment) ? '<!-- end view: ' . $comment . ' -->' : '';
			echo $begin_comment;
		}

		get_template_part(VIEWS_DIR . '/' . $slug, $name);

		if( DEBUG && $end_comment){
			echo $end_comment;
		}
	}

	// Utils function for importing partial template files
	function BP_partial($slug, $name) {

		if( DEBUG ){
			$comment = ($slug) ? $slug : '';
			$comment = ($comment && $name) ? $comment . '-' . $name : '';
			$begin_comment = ($comment) ? '<!-- begin partial: ' . $comment . ' -->' : '';
			$end_comment = ($comment) ? '<!-- end partial: ' . $comment . ' -->' : '';
			echo $begin_comment;
		}

		get_template_part(PARTIALS_DIR . '/' . $slug, $name);

		if( DEBUG && $end_comment){
			echo $end_comment;
		}
	}
	