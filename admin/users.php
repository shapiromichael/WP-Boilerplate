<?php


	function user_html_theme_style(){
		?>
			<table>
				<tr>
					<th>Choose HTML Editor Style</th>
					<td>
						asrfasdf
						asdf
						asdfasdfasdf
						asdfasdf
						
					</td>
				</tr>
			</table>

		<?php
	} 

	

	add_action('edit_user_profile', 'user_html_theme_style');
	add_action('show_user_profile', 'user_html_theme_style');
	