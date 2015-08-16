<?php
	
	get_header();

	?>
	<section>
		<div class="container">
		<?php

			// The content
			while( have_posts() ){
				the_post();
				the_title();
				the_content();
			}

		?>
		</div>
	</section>
	<?php
	
	get_footer();
